Spine             = require("spine")
$                 = Spine.$
Controller        = Spine.Controller
Drag              = require('extensions/drag')
User              = require("models/user")
ProductsTrash     = require("models/products_trash")
CategoriesProduct = require("models/categories_product")
Products          = require("models/product")
ProductsPhoto     = require("models/products_photo")
Extender          = require('extensions/controller_extender')
ProductExtender   = require('extensions/product_extender')
UriHelper         = require('extensions/uri_helper')

class ProductsTrashView extends Spine.Controller
  
  @extend UriHelper
  @extend Drag
  @extend Extender
  @extend ProductExtender
  
  elements:
    '.items'                       : 'items'
    
  events:
    'click'                        : 'clearSelection'
    'click .item'                  : 'click'
    'click .dropdown-toggle'       : 'dropdownToggle'
    'click .opt-destroy'           : 'destroyProduct'
    'click .opt-recover'           : 'recoverProduct'
    
    'mousemove .item'              : 'in'
    'mouseleave .item'             : 'out'
    
    'dragstart '                   : 'dragstart'
    'dragend'                      : 'dragend'
    'drop'                         : 'drop'
    'dragover   '                  : 'dragover'
    'dragenter  '                  : 'dragenter'
    
    'keyup'                        : 'keyup'
    
  template: (items, options) ->
    $("#productsTrashTemplate").tmpl items, options
 
  constructor: ->
    super
    @bind('active', @proxy @active)
    
    Product.bind('beforeDestroy', @proxy @beforeDestroy)
    
    Product.bind('destroy:trash', @proxy @destroy)
    Product.bind('inbound:trash', @proxy @inbound)
    Product.bind('outbound:trash', @proxy @outbound)
    Product.bind('destroy:products', @proxy @destroyProducts)
    Product.bind('empty:trash', @proxy @emptyTrash)
    Product.bind('refresh', @proxy @initTrash)
    
    ProductsTrash.bind('change:selection', @proxy @exposeSelection)
    
    Spine.bind('refresh:one', @proxy @refreshOne)
    
    @bind('drag:start', @proxy @dragStart)
    @bind('drag:enter', @proxy @dragEnter)
    @bind('drag:over', @proxy @dragOver)
    @bind('drag:leave', @proxy @dragLeave)
    @bind('drag:drop', @proxy @dragDrop)
    
  initTrash: (items) ->
    for item in items when item.deleted
      trash = new ProductsTrash(id: item.id)
      trash.save()
      item.bind('update destroy', @proxy @watch)
    
  refreshOne: ->
    Product.one('refresh', @proxy @refresh)
    
  # calls render for joins only
  refresh: () ->
    items = Product.filter(true, func: 'selectDeleted')
    @render items
    
  render: (items) ->
    @items.html @template items
    @log items
    @renderBackgrounds items
    @el
    
  active: (items) ->
    @render(items)
    
    App.showView.trigger('change:toolbarOne', ['Default', 'Help'])
    App.showView.trigger('change:toolbarTwo', ['Speichern'])
    
  inbound: (products) ->
    products = [products] unless Array.isArray products
    for product in products
      product.deleted = true
      product.save()
      Product.trigger('trashed', product)
    @initTrash products
    
  outbound: (item) ->
#    alert 'outbound'
    
  watch: (item) ->
    if !item.deleted or item.destroyed
      trash = ProductsTrash.find(item.id)
      trash.destroy()
      Product.trigger('outbound:trash')
      @remove(item)
    
  dropdownToggle: (e) ->
    el = $(e.currentTarget)
    el.dropdown()
    
    e.stopPropagation()
    e.preventDefault()
    
  recoverProduct: (e) ->
    e.stopPropagation()
    item = $(e.currentTarget).item()
    item.deleted = false
    item.save()
    
  destroyProduct: (e) ->
    e.stopPropagation()
    item = $(e.currentTarget).item()
    
    @destroyProducts(e, id) if id = item?.id
    
    
  destroyProducts: (e, ids=@model.selectionList(), callback) ->
    @log 'destroyProducts'
    ids = [ids] unless Array.isArray(ids)
    
    products = Product.toRecords(ids)
    for product in products
      if product.deleted
        # delete from the trash
        if res or (res = App.confirm('DESTROY', @humanize(products)))
          Product.trigger('destroy:trash', product)
          continue
        else break
    
  beforeDestroy: (product) ->
    @log 'beforeDestroy'
    product.unbind('released:fromTrash')
    product.removeSelectionID()
    
    categories = CategoriesProduct.categories(product.id)
    for category in categories
      category.removeFromSelection product.id
      # remove all associated products
      photos = ProductsPhoto.photos(product.id).toId()
      Photo.trigger('destroy:join', photos, product)
    
  destroy: (items) ->
    @log 'destroy'
    items = [items] unless Array.isArray items
    item.destroy() for item in items
    
  emptyTrash: (items) ->
    if App.confirm('EMPTYTRASH')
      for item in items
        item.destroy()
    
  click: (e) ->
    item = $(e.currentTarget).item()
    @select e, item.id
    
    e.stopPropagation()
    
  select: (e, ids=[]) ->
    list = @model.selectionList()[..]
    ids = [ids] unless Array.isArray ids
    if @isMeta(e)
      list.addRemove(ids)
    else
      list = ids[..]
    
    @model.updateSelection list
    
    e.stopPropagation()
    
  back: (e) ->
    if cid = Category.record?.id
      @navigate '/category', cid, pid = if (Category.record?.selectionList().first()) then 'pid/' + pid else ''
    else
      @navigate '/category', ''
    
  in: (e) =>
    el = $(e.currentTarget)
    $('.glyphicon-set.fade' , el).addClass('in').removeClass('out')
    
  out: (e) =>
    el = $(e.currentTarget)
    set = $('.glyphicon-set.fade' , el).addClass('out').removeClass('in')
    
  keyup: (e) ->
    code = e.charCode or e.keyCode
    
    switch code
      when 8 #Backspace
        @destroyProducts(e)
        e.preventDefault()
        e.stopPropagation()
    
    
module?.exports = ProductsTrashView