Spine             = require("spine")
$                 = Spine.$
Controller        = Spine.Controller
Drag              = require('extensions/drag')
User              = require("models/user")
CategoriesProduct = require("models/categories_product")
Extender          = require('extensions/controller_extender')
UriHelper         = require('extensions/uri_helper')

class ProductsTrashView extends Spine.Controller
  
  @extend UriHelper
  @extend Drag
  @extend Extender
  
  elements:
    '.items'                           : 'items'
    
  events:
    'click .item'                  : 'click'
    'click .items'                 : 'deselect'
    'click .dropdown-toggle'       : 'dropdownToggle'
    'click .opt-delete'            : 'destroyProduct'
    'mousemove .item'              : 'in'
    'mouseleave .item'             : 'out'
    
    'dragstart '                      : 'dragstart'
    'dragend'                         : 'dragend'
    'drop'                            : 'drop'
    'dragover   '                     : 'dragover'
    'dragenter  '                     : 'dragenter'
    
  template: (items, options) ->
    $("#productsTrashTemplate").tmpl items, options
 
  constructor: ->
    super
    @bind('active', @proxy @active)
    
    Product.bind('beforeDestroy', @proxy @beforeDestroy)
    Product.bind('destroy:fromTrash', @proxy @destroy)
    
    Category.bind('change:selection', @proxy @exposeSelection)
    
    @bind('drag:start', @proxy @dragStart)
    @bind('drag:enter', @proxy @dragEnter)
    @bind('drag:over', @proxy @dragOver)
    @bind('drag:leave', @proxy @dragLeave)
    @bind('drag:drop', @proxy @dragDrop)
    
  change: ->
    items = Product.filter(true, func: 'selectDeleted')
    @render items
    
  render: (items) ->
    @log @items
    @items.html @template items
    @renderBackgrounds items
    @el
    
  active: (items) ->
    @render(items)
    
    App.showView.trigger('change:toolbarOne', ['Default', 'Help'])
    App.showView.trigger('change:toolbarTwo', ['Speichern'])
    
  dropdownToggle: (e) ->
    el = $(e.currentTarget)
    el.dropdown()
    
    e.stopPropagation()
    e.preventDefault()
    
  destroyProduct: (e) ->
    item = $(e.currentTarget).item()
    Category.updateSelection(item.id)
    
    Spine.trigger('destroy:product')
    
#    e.preventDefault()
    
  beforeDestroy: (product) ->
    @log 'beforeDestroy'
    
    product.removeSelectionID()
    
    categories = CategoriesProduct.categories(product.id)
    for category in categories
      category.removeFromSelection product.id
      # remove all associated products
      photos = ProductsPhoto.photos(product.id).toId()
      Photo.trigger('destroy:join', photos, product)
    
    @remove product
    
  destroy: (item) ->
    @log 'destroy'
  
    item.destroy()
    
  click: (e) ->
    @items.deselect()
    item = $(e.currentTarget).item()
    @select e, item.id
    
    e.stopPropagation()
    
  select: (e, ids) ->
    list = Category.selectionList()[..]
    ids = [ids] unless Array.isArray ids
    list.addRemove ids
    Category.updateSelection ids
    
    e.stopPropagation()
    
  back: (e) ->
    if Category.record
      @navigate '/categories', 'cid', Category.record.id
    else
      @navigate '/categories', ''
    
  in: (e) =>
    el = $(e.currentTarget)
    $('.glyphicon-set.fade' , el).addClass('in').removeClass('out')
    
  out: (e) =>
    el = $(e.currentTarget)
    set = $('.glyphicon-set.fade' , el).addClass('out').removeClass('in')
    
module?.exports = ProductsTrashView