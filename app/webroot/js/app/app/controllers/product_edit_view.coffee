Spine                   = require("spine")
$                       = Spine.$
KeyEnhancer             = require('extensions/key_enhancer')
Extender                = require('extensions/controller_extender')
CategoriesProduct       = require('models/categories_product')
ToolbarView             = require("controllers/toolbar_view")
SubEditViewProduct      = require('controllers/sub_edit_view_product')
SubEditViewDescription  = require('controllers/sub_edit_view_description')
SubNoProduct            = require('controllers/sub_no_product')

class ProductEditView extends Spine.Controller
  
  @extend Extender
  
  elements:
    '.content'                  : 'content'
    '.product'                  : 'productEl'
    '.description'              : 'descriptionEl'
    '.noproduct'                : 'noProductEl'
    'button.opt-EditorProduct'      : 'btnProduct'
    'button.opt-EditorDescription'  : 'btnDescription'
    
  events:
    'click .opt-EditorProduct'      : 'changeViewProduct'
    'click .opt-EditorDescription'  : 'changeViewDescription'

  constructor: ->
    super
    @bind('active', @proxy @active)
    
    @productView = new SubEditViewProduct
      el: @productEl
      parent: @
      btn: @btnProduct
    @descriptionView = new SubEditViewDescription
      el: @descriptionEl
      parent: @
      btn: @btnDescription
    @noProductView = new SubNoProduct
      el: @noProductEl
      parent: @
    
    @manager = new Spine.Manager(@productView, @descriptionView, @noProductView)
    @activeController = @productView
    
    @manager.bind('change', @proxy @changedController)
    Product.bind('current', @proxy @currentProduct)
    CategoriesProduct.bind('destroy, update', @proxy @changeRelated)
    Product.bind('destroy', @proxy @change)
    
  active: ->
    @render()
  
  change: (item) ->
    if item and item?.destroyed
      @current = null
    else
      @current = item
    @render() 
  
  changeRelated: (item) ->
    return unless item.product_id is Product.record?.id
    product = Category.product(item.category_id, item.product_id)
    @change product
  
  currentProduct: (item) ->
    return unless item.id is Product.record?.id
    if cat = Category.record
      item = Category.product(cat.id, item.id)
    @change item
    
  changedController: (controller) ->
    c.btn?.removeClass('active') for c in @manager.controllers when c isnt controller
    controller.btn?.addClass('active')
  
  render: () ->
    if @current
      @activeController.trigger('active')
    else @noProductView.trigger('active')
    
    @el
  
  changeViewProduct: (e) ->
    el = $(e.currentTarget)
    @el.find('button.active').removeClass('active')
    @activeController = @productView
    if @current then @activeController.trigger('active', el)
    
  changeViewDescription: (e) ->
    el = $(e.currentTarget)
    @el.find('button.active').removeClass('active')
    @activeController = @descriptionView
    if @current then @activeController.trigger('active', el)

  
    
  click: (e) ->

module?.exports = ProductEditView