Spine           = require("spine")
$               = Spine.$
Controller      = Spine.Controller
Product           = require('models/product')
Photo           = require('models/photo')
ProductsPhoto     = require('models/products_photo')
Category         = require('models/category')
CategoriesProduct  = require('models/categories_product')
Info            = require('controllers/info')
PhotosList      = require('controllers/photos_list')
Drag            = require('extensions/drag')
Extender        = require('extensions/controller_extender')

require('extensions/tmpl')

class PhotosView extends Spine.Controller
  
  @extend Drag
  @extend Extender
  
  elements:
    '.hoverinfo'      : 'infoEl'
    '.items'          : 'itemsEl'
  
  events:
    'click'                        : 'clearSelection'
    'click .item'                  : 'click'
    'sortupdate .items'            : 'sortupdate'
    
    'dragstart .item'              : 'dragstart'
    'dragstart'                    : 'stopInfo'
    'dragover .item'               : 'dragover'
    'drop'                         : 'drop'
    'mousemove .item'              : 'infoUp'
    'mouseleave  .item'            : 'infoBye'
    
  template: (items) ->
    $('#photosTemplate').tmpl(items)
    
  preloaderTemplate: ->
    $('#preloaderTemplate').tmpl()
    
  headerTemplate: (items) ->
    $("#headerPhotosTemplate").tmpl items
    
  infoTemplate: (item) ->
    $('#photoInfoTemplate').tmpl item
    
  constructor: ->
    super
    @bind('active', @proxy @active)
    
    @current = @el.data('modelName').record
    
    @info = new Info
      el: @infoEl
      template: @infoTemplate
    @list = new PhotosList
      el: @itemsEl
      template: @template
      parent: @
    @header.template = @headerTemplate
    @viewport = @list.el
    
    @bind('drag:drop', @proxy @dragDrop)
    
    ProductsPhoto.bind('destroy', @proxy @destroyProductsPhoto)
    ProductsPhoto.bind('beforeDestroy', @proxy @beforeDestroyProductsPhoto)
    CategoriesProduct.bind('destroy', @proxy @backToProductView)
    
    Spine.bind('refresh:one', @proxy @refreshOne)
    
    Photo.bind('create', @proxy @add)
    Photo.bind('destroy', @proxy @destroy)
    Photo.bind('beforeDestroy', @proxy @beforeDestroyPhoto)
    Photo.bind('create:join', @proxy @createJoin)
    Photo.bind('destroy:join', @proxy @destroyJoin)
    Photo.bind('ajaxError', Photo.errorHandler)
    
    Spine.bind('delete:photo', @proxy @deletePhoto)
    Spine.bind('loading:done', @proxy @refresh)
    
  refreshOne: ->
    Product.one('refresh', @proxy @refresh)
  
  refresh: () ->
    @render Photo.renderBuffer(true)
  
  render: (items, mode='html') ->
    # render only if necessary
#    return unless @isActive() or force
    # if view is dirty but inactive we'll use the buffer next time
    @list.render(items)
    @list.sortable('photo') if Product.record
    @el
  
  active: (items, options) ->
    b1 = @eql.call(@parent)
    b2 = @eql_()
    return if b1 and b2
    
    App.showView.trigger('change:toolbarOne', ['Default', 'Slider', App.showView.initSlider])
    App.showView.trigger('change:toolbarTwo', ['Speichern'])
    
    @parent.scrollTo(@models.record)
    
    @render(items)
    
  update: (items) ->
    return unless Product.record
    @list.children().each (index) ->
      item = $(@).item()
      ap = ProductsPhoto.fromPhotoId(item.id)
      return unless ap
      ap.order = index
      ap.save(ajax:false)
      t = c.update item
      
    for item in items
      tmplItem = @list.update item
    
  activateRecord: (ids) ->
    unless (ids)
      ids = []
  
    unless Array.isArray(ids)
      ids = [ids]
    
    Photo.current ids[0]
  
  click: (e) ->
    App.showView.trigger('change:toolbarOne')
    
    item = $(e.currentTarget).item()
    @select e, item.id
    
  select: (e, ids = []) ->
    list = @model.selectionList()[..]
    ids = [ids] unless Array.isArray ids
    if e.metaKey or e.ctrlKey
      list.addRemove(ids)
    else
      list = ids[..]
    
    if @isActive()
      if list.length
        @navigate '/category', Category.record?.id or '', Product.record.id or '', 'iid', list[0]
      else
        @navigate '/category', Category.record?.id or '', Product.record.id or ''

    @model.updateSelection list
      
    e.stopPropagation()
  
  
  select_: (e, ids = []) ->
    isMeta = e.metaKey or e.ctrlKey or e.shiftKey
    ids = [ids] unless Array.isArray ids
    if (isMeta) and e.type is 'click'
      list = @model.selectionList()
      list.addRemove(ids)
    else
      list = ids[..]
#        @model.emptySelection() unless @isCtrlClick(e)
#        list = @model.selectionList()[..]
#        ids = list[..] unless ids.length
#        for id in ids
#          list.addRemove(id)

#    if list.length
#      @navigate '/category', Category.record?.id or '', Product.record.id or '', 'fid', list[0]
#    else
#      @navigate '/category', Category.record?.id or '', Product.record.id or ''
      
    @model.updateSelection(list)
    
    e.stopPropagation()
      
  clearPhotoCache: ->
    Photo.clearCache()
  
  beforeDestroyPhoto: (photo) ->
    # remove selection from root
    Product.removeFromSelection null, photo.id
    
    # all involved products
    products = ProductsPhoto.products(photo.id)
    
    for product in products
      product.removeFromSelection photo.id
      photo.removeSelectionID()
      
      # remove all associated photos
      @destroyJoin
        photos: photo.id
        product: product
      
  beforeDestroyProductsPhoto: (ap) ->
    product = Product.find ap.product_id
    product.removeFromSelection ap.photo_id
  
  destroy: (item) ->
    el = @list.findModelElement(item)
    el.detach()
    @render() unless Photo.count()
      
  destroyProductsPhoto: (ap) ->
    photos = ProductsPhoto.photos ap.product_id
    @render(null, 'html') unless photos.length
  
  deletePhoto: (ids, callback) ->
    App.confirm('METHOD_NOT_SUPPORTED', mode: 'alert')
  
  save: (item) ->

  # methods after uplopad
  
  addProductsPhoto: (ap) ->
    el = @list.findModelElement photo if photo = Photo.find(ap.photo_id)
    return if el.length
    @add photo
  
  add: (photos) ->
    unless Array.isArray photos
      photos = [photos]
    Product.updateSelection(photos.toId())
    unless Product.record
      @list.wipe() 
      @render(photos, 'append')
      @list.el.sortable('destroy').sortable('photos')
      
  createJoin: (photos, target, cb) ->
    Photo.createJoin photos, target, cb
    Photo.trigger('activate', photos.last())
    target.updateSelection photos.toId()
  
  destroyJoin: (options, callback) ->
    @log 'destroyJoin'
    product = options.product
    photos = options.photos
    photos = [photos] unless Array.isArray(photos)
    
    return unless product
    Photo.destroyJoin photos, product, callback
    product.updateSelection()
    
  sortupdate: (e) ->
    @log 'sortupdate'
    f = @list.children().length-1
    
    @list.children().each (index) ->
      idx = f-index
      item = $(@).item()
      if item and Product.record
        ap = ProductsPhoto.fromPhotoId(item.id)
        if ap and parseInt(ap.order) isnt idx
          ap.order = idx
          ap.save(ajax:false)
        # set a *invalid flag*, so when we return to products cover view, thumbnails will be regenerated
        Product.record.invalid = true
        
    # saving Product to automatically save foreign model to the database
    Product.record.save()
    
  backToProductView: (ga) ->
    return unless @isActive()
    if category = Category.find ga.category_id
      @navigate '/category', category.id
      
  infoUp: (e) ->
    @info.up(e)
    el = $('.glyphicon-set' , $(e.currentTarget)).addClass('in').removeClass('out')
    
  infoBye: (e) ->
    @info.bye(e)
    el = $('.glyphicon-set' , $(e.currentTarget)).addClass('out').removeClass('in')
    
  stopInfo: (e) =>
    @info.bye(e)
      
  dragComplete: ->
    @list.exposeSelection()
    
module?.exports = PhotosView