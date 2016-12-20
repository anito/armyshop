Spine           = require("spine")
$                 = Spine.$
Model             = Spine.Model
ProductsPhoto     = require('models/products_photo')
Category          = require('models/category')
Product           = require('models/product')
Photo             = require('models/photo')
Extender          = require('extensions/controller_extender')
ProductExtender   = require('extensions/product_extender')
CategoriesProduct = require('models/categories_product')
UriHelper         = require('extensions/uri_helper')
Drag              = require('extensions/drag')

require('extensions/tmpl')

class ProductsList extends Spine.Controller
  
  @extend Drag
  @extend Extender
  @extend ProductExtender
  @extend UriHelper
  
  events:
    'click .dropdown-toggle'       : 'dropdownToggle'
    'click .opt-AddProducts'       : 'addProducts'
    'click .opt-delete'            : 'deleteProduct'
    'click .opt-ignored'           : 'ignoreProduct'
    'click .opt-original'          : 'original'
    'click .opt-favorite'           : 'toggleFavorite'
    'click .zoom'                  : 'zoom'
    
  constructor: ->
    super
    @widows = []
    @add = @html
    Product.bind('update', @proxy @updateTemplate)
    Product.bind("ajaxError", Product.errorHandler)
    CategoriesProduct.bind('change', @proxy @changeRelated)
    CategoriesProduct.bind('destroy', @proxy @testEmpty)
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
        @wipe().append @template(product)
        @renderBackgrounds product
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
    if ga
      atts = ga?.mixinAttributes(item)
      item.silentUpdate(atts)
      return item
    item
  
  render: (items=[], mode="html") ->
    @log 'render', mode
    
    unless items.length
      s = if (s = @model.record?.screenname or s = @model.record?.name or s = @model.record?.title)? then 'in ' + s + ' nichts los - kein Moos' else 'nichts los hier. Brutal...'
      @renderEmpty(s)
      return @el
    
    items = @mixin items
    @[mode] @template items
    @renderBackgrounds items
    @exposeSelection()
    $('.dropdown-toggle', @el).dropdown()
      
    @el
  
  original: (e) ->
    id = $(e.currentTarget).item().id
    Category.selection[0].global.update [id]
    @navigate '/category', ''
    
    e.preventDefault()
    e.stopPropagation()
      
  toggleFavorite: (e) ->
    if (cat = Category.record) and (!Category.protected[cat?.name])
      App.confirm('NO_VALID_CATEGORY', null, 'alert')
      return
    item = $(e.currentTarget).item()
    isFavorite = item.favorite
    if !isFavorite and item.ignored
      App.confirm('NO_FAVORITE_FOR_IGNORED', null, 'alert')
      return
    favorites = Product.findAllByAttribute('favorite', true)
    favorite.updateAttributes('favorite': false) for favorite in favorites
    item.updateAttributes('favorite': !isFavorite)
    
    e.preventDefault()
    e.stopPropagation()
      
  zoom: (e) ->
    item = if e.type is 'click' then $(e.currentTarget).item() else @models.record
    
    @parent.stopInfo()
    
    @navigate '/category', Category.record?.id or '', item?.id or '', iid = if (iid = item.selectionList?().first()) then 'iid/' + iid else null
    
    e.preventDefault()
    e.stopPropagation()
    
  back: (e) ->
    @navigate '/category', cid = if (cid = Category.record?.id) then 'cid/' + cid else null
    
    e.preventDefault()
    e.stopPropagation()
    
  dropdownToggle: (e) ->
    el = $(e.currentTarget)
    el.dropdown()
    e.preventDefault()

  ignoreProduct: (e) ->
    product = $(e.currentTarget).item()
    category = @parent.model.record
    Spine.trigger('product:ignore', product, category)
    
    e.stopPropagation()
    e.preventDefault()
    
  deleteProduct: (e) ->
    @log 'deleteProduct'
    item = $(e.currentTarget).item()
    return unless item?.constructor?.className is 'Product'
    
    Spine.trigger('delete:products', [item.id])
    
    e.stopPropagation()
    e.preventDefault()
    
  addProducts: (e) ->
    @log 'add'
#    e.stopPropagation()
#    e.preventDefault()
    
    Spine.trigger('products:add')
    
module?.exports = ProductsList