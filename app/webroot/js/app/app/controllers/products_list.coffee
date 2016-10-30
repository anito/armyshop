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
    return unless @parent and @parent.isActive()
    return unless Category.record
    return unless Category.record.id is item['category_id']
      
    product = Product.find(item['product_id'])
    product = @mixinOne product
    switch mode
      when 'create'
        @log 'changeRelated'
        @wipe()
        @append @template(product)
        @renderBackgrounds [product]
        @el.sortable('destroy').sortable()
#        $('.tooltips', @el).tooltip()
        $('.dropdown-toggle', @el).dropdown()
      when 'update'
        @updateTemplate(product)
    
    @refreshElements()
    @el
  
  mixin: (items) ->
    @mixinOne item for item in items
    
  mixinOne: (item) ->
    return item unless Category.record
    ga = CategoriesProduct.productExists(item.id, Category.record.id)
    atts = ga?.mixinAttributes(item)
    item.silentUpdate(atts)
    item
  
  render: (items, mode="html") ->
    @log 'render', mode
        
    if items.length
      @wipe()
#      items = @mixinAttributes(items, ['ignored']) unless @modal
      items = @mixin items
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
    
  exposeSelection: (selection=Category.selectionList(), id=Category.record?.id) ->
    if Category.record
      return unless Category.record.id is id
    @deselect()

    for id in selection
      el = $('#'+id, @el)
      el.addClass("active")

    if first = selection.first()
      $('#'+first, @el).addClass("hot")
    
  updateTemplate: (item) ->
    item = @mixinOne item
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
    productEl.toggleClass('ignored', item.ignored)

    @el.sortable()
    
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
    
  wipe: (force) ->
    if force then @el.empty(); return @el
    
    if Category.record
      first = Category.record.count() is 1
    else
      first = Product.count() is 1
    @el.empty() if first
    @el
    
module?.exports = ProductsList