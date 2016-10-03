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
    'click .item'                  : 'click'
    'sortupdate .items'            : 'sortupdate'
    
    'dragstart .item'              : 'dragstart'
    'dragstart'                    : 'stopInfo'
    'dragover .item'               : 'dragover'
    
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
    @el.data('current',
      model: Product
      models: Photo
    )
    @type = 'Photo'
    @info = new Info
      el: @infoEl
      template: @infoTemplate
    @list = new PhotosList
      el: @itemsEl
      template: @template
      parent: @
      slideshow: @slideshow
    @header.template = @headerTemplate
    @viewport = @list.el
    
    @bind('drag:help', @proxy @dragHelp)
    @bind('drag:start', @proxy @dragStart)
    @bind('drag:drop', @proxy @dragComplete)
    
    ProductsPhoto.bind('destroy', @proxy @destroyProductsPhoto)
    ProductsPhoto.bind('beforeDestroy', @proxy @beforeDestroyProductsPhoto)
    CategoriesProduct.bind('destroy', @proxy @backToProductView)
    
    Photo.bind('refresh:one', @proxy @refreshOne)
    Photo.bind('created', @proxy @add)
    Photo.bind('destroy', @proxy @destroy)
    Photo.bind('beforeDestroy', @proxy @beforeDestroyPhoto)
    Photo.bind('create:join', @proxy @createJoin)
    Photo.bind('destroy:join', @proxy @destroyJoin)
    Photo.bind('ajaxError', Photo.errorHandler)
#    Product.bind('change:selection', @proxy @activateRecord)
    
    Spine.bind('destroy:photo', @proxy @destroyPhoto)
    Spine.bind('loading:done', @proxy @updateBuffer)
    
  refreshOne: ->
    Photo.one('refresh', @proxy @refresh)
    
  updateBuffer: (product=Product.record) ->
    filterOptions =
      model: 'Product'
      key: 'product_id'
      sorted: 'sortByOrder'
    
    if product
      items = Photo.filterRelated(product.id, filterOptions)
    else
      items = Photo.filter()
      
    @buffer = items
  
  refresh: ->
    @updateBuffer()
    @render @buffer, 'html', true
  
  render: (items, mode='html', force) ->
    # render only if necessary
    return unless @isActive() or force
    # if view is dirty but inactive we'll use the buffer next time
    @list.render(items || @updateBuffer(), mode)
    @list.sortable('photo') if Product.record
    delete @buffer
    @el
  
  active: (params) ->
    return unless @isActive()
    if params
      @options = $().unparam(params)
      if @options.slideshow
        @parent.slideshowView.play()
    
    App.showView.trigger('change:toolbarOne', ['Default', 'Slider', App.showView.initSlider])
    App.showView.trigger('change:toolbarTwo', ['Speichern'])
    @refresh()
    @parent.scrollTo(@el.data('current').models.record)
    
  activateRecord: (ids) ->
    unless (ids)
      ids = []
  
    unless Array.isArray(ids)
      ids = [ids]
    
    Photo.current ids[0]
  
  click: (e) ->
    e.preventDefault()
    e.stopPropagation()
    
    App.showView.trigger('change:toolbarOne')
    
    item = $(e.currentTarget).item()
    @select e, item.id
    
  select: (e, items = []) ->
    unless Array.isArray items
      items = [items]
      
    type = e.type
    switch type
      when 'keyup'
        selection = items
      when 'click'
        Product.emptySelection() unless @isCtrlClick(e)
        selection = Product.selectionList()[..]
        items = selection[..] unless items.length
        for id in items
          selection.addRemoveSelection(id)
    
    Product.updateSelection(selection, Product.record?.id)
      
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
  
  destroyPhoto: (ids, callback) ->
    @log 'destroyPhoto'
    
    @stopInfo()
    
    photos = ids || Product.selectionList().slice(0)
    photos = [photos] unless Array.isArray photos
    
    for id in photos
      if item = Photo.find(id)
        el = @list.findModelElement(item)
        el.removeClass('in')
      
    if product = Product.record
      @destroyJoin
        photos: photos
        product: product
    else
      for id in photos
        photo.destroy() if photo = Photo.find(id)
        
    if typeof callback is 'function'
      callback.call()
  
  save: (item) ->

  # methods after uplopad
  
  addProductsPhoto: (ap) ->
    el = @list.findModelElement photo if photo = Photo.find(ap.photo_id)
    return if el.length
    @add photo
  
  add: (photos) ->
    unless Photo.isArray photos
      photos = [photos]
    Product.updateSelection(photos.toID())
    @render(photos, 'append')
    @list.el.sortable('destroy').sortable('photos')
      
  createJoin: (options, cb) ->
    Photo.createJoin options.photos, options.product, cb
    Photo.trigger('activate', options.photos.last())
    options.product.updateSelection options.photos
  
  destroyJoin: (options, callback) ->
    @log 'destroyJoin'
    product = options.product
    photos = options.photos
    photos = [photos] unless Photo.isArray(photos)
    photos = photos.toID()
    
    return unless product
    Photo.destroyJoin photos, product, callback
    product.updateSelection()
    
  sortupdate: ->
    @log 'sortupdate'
    
    cb = ->
    
    @list.children().each (index) ->
      item = $(@).item()
      if item and Product.record
        ap = ProductsPhoto.filter(item.id, func: 'selectPhoto')[0]
        if ap and parseInt(ap.order) isnt index
          ap.order = index
          ap.save(ajax:false)
        # set a *invalid flag*, so when we return to products cover view, thumbnails can get regenerated
        Product.record.invalid = true
        
    Product.record.save(done: cb)
    
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