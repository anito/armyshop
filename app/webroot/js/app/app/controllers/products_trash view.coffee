Spine           = require("spine")
$               = Spine.$
Controller      = Spine.Controller
Drag            = require('extensions/drag')
User            = require("models/user")
Product           = require('models/product')
Category         = require('models/category')
CategoriesProduct  = require('models/categories_product')
ProductsPhoto     = require('models/products_photo')
Info            = require('controllers/info')
ProductsList      = require('controllers/products_list')
Extender        = require('extensions/controller_extender')
User            = require('models/user')

require('extensions/tmpl')

class ProductsView extends Spine.Controller
  
  @extend Drag
  @extend Extender
  
  elements:
    '.hoverinfo'                      : 'infoEl'
    '.header .hoverinfo'              : 'headerEl'
    '.items'                          : 'itemsEl'
    
  productsTemplate: (items, options) ->
    $("#productsTemplate").tmpl items, options
    
#  toolsTemplate: (items) ->
#    $("#toolsTemplate").tmpl items
#
  headerTemplate: (items) ->
    $("#headerProductTemplate").tmpl items
 
  infoTemplate: (item) ->
    $('#productInfoTemplate').tmpl item
 
  constructor: ->
    super
    @bind('active', @proxy @active)
    
    @type = 'Product'
    @parentType = 'Category'
    
    @current = Model[@parentType].record
    
    @el.data('current',
      model: Model[@parentType]
      models: Model[@type]
    )
    @header.template = @headerTemplate
    @viewport = @list.el
#      joinTableItems: (query, options) -> Spine.Model['CategoriesProduct'].filter(query, options)

    CategoriesProduct.bind('beforeDestroy', @proxy @beforeDestroyCategoriesProduct)
    CategoriesProduct.bind('destroy', @proxy @destroyCategoriesProduct)
    CategoriesProduct.bind('ignored', @proxy @ignoreProduct)
    
#    Category.bind('create destroy', @proxy @refresh)
    
    Spine.bind('bindRefresh:one', @proxy @bindRefresh)
    
    Product.bind('create', @proxy @create)
    Product.bind('ajaxError', Product.errorHandler)
    Product.bind('beforeDestroy', @proxy @beforeDestroyProduct)
    Product.bind('destroy', @proxy @destroy)
    Product.bind('create:join', @proxy @createJoin)
    Product.bind('destroy:join', @proxy @destroyJoin)
    Product.bind('change:collection', @proxy @renderBackgrounds)
    Product.bind('show:unpublished', @proxy @showUnpublished)
    Product.bind('show:unused', @proxy @showUnused)
#    Spine.bind('select:product', @proxy @select)
    
    @bind('drag:start', @proxy @dragStart)
    @bind('drag:enter', @proxy @dragEnter)
    @bind('drag:over', @proxy @dragOver)
    @bind('drag:leave', @proxy @dragLeave)
    @bind('drag:drop', @proxy @dragDrop)
    
    $(@views).queue('fx')
    
  render: (items) ->
    return unless @isActive()
    @html items
    @el
      
module?.exports = ProductsView