Spine           = require("spine")
$               = Spine.$
Model           = Spine.Model
Category         = require('models/category')
Product           = require('models/product')
Photo           = require('models/photo')
ProductsPhoto     = require('models/products_photo')
CategoriesProduct  = require('models/categories_product')
Extender        = require('extensions/controller_extender')
Drag            = require('extensions/drag')
UriHelper = require('extensions/uri_helper')

require('extensions/tmpl')

class ProductsList extends Spine.Controller
  
  @extend UriHelper
  @extend Drag
  @extend Extender
  
  events:
    'click .dropdown-toggle'       : 'dropdownToggle'
    'click .opt-AddProducts'       : 'addProducts'
    'click .opt-delete'            : 'deleteProduct'
    'click .opt-ignored'           : 'ignoreProduct'
    'click .opt-original'          : 'original'
    'click .zoom'                  : 'zoom'
    
  constructor: ->
    super
    @widows = []
    @add = @html
    Product.bind('update', @proxy @updateTemplate)
    Product.bind("ajaxError", Product.errorHandler)
    CategoriesProduct.bind('change', @proxy @changeRelated)
    Product.bind('change:collection', @proxy @renderBackgrounds)
    Category.bind('change:selection', @proxy @exposeSelection)
    
  changedProducts: (category) ->
    
  changeRelated: (item, mode) ->
    if mode isnt 'create'
      return unless @parent and @parent.isActive() and (mode isnt 'create')
      return unless Category.record
      return unless Category.record.id is item['category_id']
      
    product = Product.find(item['product_id'])
    
    switch mode
      when 'create'
        @wipe()
        @append @template @mixinAttributes([product], ['ignored'])
        @renderBackgrounds [product]
        @el.sortable('destroy').sortable()
#        $('.tooltips', @el).tooltip()
        $('.dropdown-toggle', @el).dropdown()
      when 'destroy'
        el = @findModelElement(product)
        el.detach()
      when 'update'
        #for the ignore attribute
        @updateIgnored(item)
    
    @refreshElements()
    @el
  
  mixinAttributes: (items, atts) ->
    for item in items
      ga = CategoriesProduct.categoryProductExists(item.id, Category.record.id)
      for att in atts 
        item[att] = ga[att]
    items
    
  render: (items=[], mode) ->
    @log 'render', mode
        
    if items.length
      @wipe()
#      items = @mixinAttributes(items, ['ignored']) unless @modal
      @[mode] @template items
      @renderBackgrounds items
      @exposeSelection()
      $('.dropdown-toggle', @el).dropdown()
    else if mode is 'add'
      @html '<label class="invite"><span class="enlightened">Nothing to add.  &nbsp;</span></label>'
      @append '<h3><label class="invite label label-default"><span class="enlightened">Es können keine Produkte hinzugefügt werden. Eventuell muss erst eine Kategorie ausgewählt werden.</span></label></h3>'
    else
      if Category.record
        if Product.count()
          @html '<label class="invite"><span class="enlightened">Keine Produkte in dieser Kategorie. &nbsp;</span><br><br>
          <button class="opt-CreateProduct blue large"><i class="glyphicon glyphicon-plus"></i><span>Neues Produkt</span></button>
          <button class="opt-AddProducts dark large"><i class="glyphicon glyphicon-book"></i><span>Aus Katalog wählen</span></button>
          </label>'
        else
          @html '<label class="invite"><span class="enlightened bootom">Keine Produkte in dieser Kategorie</span><br><br>
          <button class="opt-CreateProduct blue large"><i class="glyphicon glyphicon-plus"></i><span>Neues Produkt</span></button>
          </label>'
      else
        @html '<label class="invite"><span class="enlightened">Keine Produkte im Katalog vorhanden</span><br><br>
        <button class="opt-CreateProduct blue large"><i class="glyphicon glyphicon-plus"></i><span>Neues Produkt</span></button>
        </label>'
    
    @el
    
  updateIgnored: (item) ->
    ignored = item.ignored
    productEl = @children().forItem(Product.find(item.product_id))
    productEl.toggleClass('ignored', ignored)
    
  updateTemplate: (item) ->
    productEl = @children().forItem(item)
    contentEl = $('.thumbnail', productEl)
    active = productEl.hasClass('active')
    hot = productEl.hasClass('hot')
    style = contentEl.attr('style')
    
    tmplItem = productEl.tmplItem()
    tmplItem.data = item
    tmplItem.update?()
    
    productEl = @children().forItem(item)
    contentEl = $('.thumbnail', productEl)
    productEl.toggleClass('active', active)
    productEl.toggleClass('hot', hot)
    contentEl.attr('style', style)
    @updateIgnored item if item = CategoriesProduct.categoryProductExists(item.id, Category.record?.id)
    
    @el.sortable()
  
  exposeSelection: (selection=Category.selectionList(), id=Category.record?.id) ->
    if Category.record
      return unless Category.record.id is id
    @deselect()
    
    for id in selection
      $('#'+id, @el).addClass("active")
      
    if first = selection.first()
      $('#'+first, @el).addClass("hot")
      
  # workaround:
  # remember the Product since
  # after last ProductPhoto is destroyed the Product container cannot be retrieved anymore
  widowedProductsPhoto: (ap) ->
    @log 'widowedProductsPhoto'
    list = ap.products()
    @widows.push item for item in list
    @widows
  
  removeWidows: (widows=[]) ->
    Model.Uri.Ajax.cache = false
    for widow in widows
      $.when(@processProduct(widow)).done (xhr, rec) =>
        @callback xhr, rec
    @widows = []
    Model.Uri.Ajax.cache = true
  
  renderBackgrounds: (products) ->
    @log 'renderBackgrounds'
    return unless @parent.isActive()
    products = [products] unless Array.isArray(products)
    @removeWidows @widows
    for product in products
      $.when(@processProduct(product)).done (xhr, rec) =>
        @callback xhr, rec
        
  processProduct: (product) ->
    @log 'processProduct'
    deferred = $.Deferred()
    all = product.photos()
    sorted = all.sort Photo.sortByReverseOrder
    data = sorted.slice(0, 4)

    @callDeferred data, @uriSettings(60, 60), (xhr) -> deferred.resolve(xhr, product)
    
    deferred.promise()
      
  callback: (json, product) ->
    el = $('[data-id='+product?.id+']', @el)
    thumb = $('.thumbnail', el)
    
    sources = []
    css = []
    cssdefault = []
    for jsn in json
      for key, val of jsn
        sources.push src if src = val.src
        css.push 'url('+src+')'
        cssdefault.push 'url(/img/ajax-loader-product-thumbs.gif)'
    
    if sources.length
      thumb.addClass('load')
      thumb.css('backgroundImage', c for c in cssdefault)
      @snap thumb, src, css for src in sources
    else
      thumb.css('backgroundImage', ['url(/img/drag_info.png)'])
      
  snap: (el, src, css) ->
    img = @createImage()
    img.el = el
    img.me = @
    img.css = css
    img.src = src
    img.onload = @onLoad
    img.onerror = @onError
    
  onLoad: ->
    @me.log 'image loaded'
    @el.removeClass('load')
    @el.css('backgroundImage', @css)
    
  onError: (e) ->
    @me.log 'could not load image, trying again'
    @onload = @me.renderBackgrounds([Product.record])
    @onerror = null
      
  original: (e) ->
    id = $(e.currentTarget).item().id
    Category.selection[0].global.update [id]
    @navigate '/category', ''
    
    e.preventDefault()
    e.stopPropagation()
      
  zoom: (e) ->
    item = $(e.currentTarget).item()

    @parent.stopInfo()
    @navigate '/category', (Category.record?.id or ''), item.id
    
    e.preventDefault()
    e.stopPropagation()
    
  back: (e) ->
    if Category.record
      @navigate '/categories', 'cid', Category.record.id
    else
      @navigate '/categories', ''
    
    e.preventDefault()
    e.stopPropagation()
    
  dropdownToggle: (e) ->
    el = $(e.currentTarget)
    el.dropdown()
    e.preventDefault()

  ignoreProduct: (e) ->
    product = $(e.currentTarget).item()
    category = @parent.el.data('current').model.record
    Spine.trigger('product:ignore', product, category)
    
    e.stopPropagation()
    e.preventDefault()
    
  deleteProduct: (e) ->
    @log 'deleteProduct'
    item = $(e.currentTarget).item()
    return unless item?.constructor?.className is 'Product'
    
    Spine.trigger('destroy:product', [item.id])
    
    e.stopPropagation()
    e.preventDefault()
    
  addProducts: (e) ->
    @log 'add'
#    e.stopPropagation()
#    e.preventDefault()
    
    Spine.trigger('products:add')
    
  wipe: ->
    if Category.record
      first = Category.record.count() is 1
    else
      first = Product.count() is 1
    @el.empty() if first
    @el
    
module?.exports = ProductsList