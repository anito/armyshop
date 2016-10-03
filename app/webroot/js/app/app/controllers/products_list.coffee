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

require('extensions/tmpl')

class ProductsList extends Spine.Controller
  
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
    Category.bind('change:selection', @proxy @exposeSelection)
    
  changedProducts: (category) ->
    
  changeRelated: (item, mode) ->
    return unless @parent and @parent.isActive()
    return unless Category.record
    return unless Category.record.id is item['category_id']
    return unless product = Product.find(item['product_id'])
    
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
      items = @mixinAttributes(items, ['ignored']) unless @modal
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
          <button class="opt-CreateProduct dark large"><i class="glyphicon glyphicon-asterisk"></i><span>Neues Produkt erstellen</span></button>
          <button class="opt-AddProducts dark large"><i class="glyphicon glyphicon-book"></i><span>Katalog</span></button>
          </label>'
        else
          @html '<label class="invite"><span class="enlightened">Keine Produkte in dieser Kategorie</span><br><br>
          <button class="opt-CreateProduct dark large"><i class="glyphicon glyphicon-asterisk"></i><span>Neues Produkt erstellen</span></button>
          </label>'
      else
        @html '<label class="invite"><span class="enlightened">Keine Produkte im Katalog vorhanden</span><br><br>
        <button class="opt-CreateProduct dark large"><i class="glyphicon glyphicon-asterisk"></i><span>Neues Produkt erstellen</span></button>
        </label>'
    
    @el
    
  updateIgnored: (item) ->
    @log item
    ignored = item.ignored
    productEl = @children().forItem(Product.find(item.product_id))
    @log Product.find(item.product_id)
    productEl.toggleClass('ignored', ignored)
    
  updateTemplate: (product) ->
    productEl = @children().forItem(product)
    contentEl = $('.thumbnail', productEl)
    active = productEl.hasClass('active')
    hot = productEl.hasClass('hot')
    
    style = contentEl.attr('style')
    tmplItem = productEl.tmplItem()
    tmplItem.data = product
    try
      tmplItem.update()
    catch e

    productEl = @children().forItem(product)
    contentEl = $('.thumbnail', productEl)
    productEl.toggleClass('active', active)
    productEl.toggleClass('hot', hot)
    
    @log productEl
    contentEl.attr('style', style)
      
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
  
  renderBackgrounds: (products) ->
    @log 'renderBackgrounds'
    products = [products] unless Product.isArray(products)
    @removeWidows @widows
    for product in products
      $.when(@processProductDeferred(product)).done (xhr, rec) =>
        @callback xhr, rec
        
  removeWidows: (widows=[]) ->
    Model.Uri.Ajax.cache = false
    for widow in widows
      $.when(@processProductDeferred(widow)).done (xhr, rec) =>
        @callback xhr, rec
    @widows = []
    Model.Uri.Ajax.cache = true
  
  processProduct: (product) ->
    data = product.photos(4)
  
    Photo.uri
      width: 50
      height: 50,
      (xhr, rec) => @callback(xhr, product)
      data
  
  processProductDeferred: (product) ->
    @log 'processProductDeferred'
    deferred = $.Deferred()
    data = product.photos(4)
    
    Photo.uri
      width: 50
      height: 50,
      (xhr, rec) -> deferred.resolve(xhr, product)
      data
      
    deferred.promise()
      
  callback: (json, product) ->
    el = $('#'+product.id, @el)
    thumb = $('.thumbnail', el)
    
    res = for jsn in json
      ret = for key, val of jsn
        val.src
      ret[0]
    
    
    css = []
    for url in res
      css.push 'url(' + url + ')'
      @snap url, thumb, css
      
    thumb.css('backgroundImage', 'url(/img/drag_info.png)') unless css.length
      
  snap: (src, el, css) ->
    img = @createImage()
    img.element = el
    img.this = @
    img.css = css
    img.onload = @onLoad
    img.onerror = @onError
    img.src = src
      
  onLoad: ->
    @element.css('backgroundImage', @css)
    
  onError: ->
    @this.snap @src, @element, @css
      
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
    @navigate '/categories', ''
    
    e.preventDefault()
    e.stopPropagation()
    
  dropdownToggle: (e) ->
    el = $(e.currentTarget)
    el.dropdown()
    e.preventDefault()

  ignoreProduct: (e) ->
    e.stopPropagation()
    item = $(e.currentTarget).item()
    return unless item?.constructor?.className is 'Product'
    if ga = CategoriesProduct.categoryProductExists(item.id, Category.record.id)
      CategoriesProduct.trigger('ignored', ga, !ga.ignored)
    
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