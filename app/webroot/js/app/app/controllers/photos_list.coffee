Spine           = require("spine")
$               = Spine.$
Photo           = require('models/photo')
Product         = require('models/product')
ProductsPhoto   = require('models/products_photo')
ToolbarView     = require("controllers/toolbar_view")
Extender        = require('extensions/controller_extender')
Drag            = require('extensions/drag')
UriHelper       = require('extensions/uri_helper')
PhotoExtender   = require('extensions/photo_extender')

require('extensions/tmpl')

class PhotosList extends Spine.Controller
  
  @extend Drag
  @extend Extender
  @extend PhotoExtender
  @extend UriHelper
  
  elements:
    '.thumbnail'              : 'thumbEl'
    '.toolbar'                : 'toolbarEl'
    
  events:
    'click .opt-AddPhotos'        : 'addPhotos'
    'click .dropdown-toggle'      : 'dropdownToggle'
    'click .delete'               : 'deletePhoto'
    'click .zoom'                 : 'zoom'
    'click .rotate-cw'            : 'rotateCW'
    'click .rotate-ccw'           : 'rotateCCW'
    'click .original'             : 'original'
    
  selectFirst: true

  constructor: ->
    super
    
    @toolbar = new ToolbarView
      el: @toolbarEl
    @add = @html
    Spine.bind('slider:start', @proxy @sliderStart)
    Spine.bind('slider:change', @proxy @size)
    Spine.bind('rotate', @proxy @rotate)
    Product.bind('ajaxError', Product.errorHandler)
    Product.bind('change:selection', @proxy @exposeSelection)
    ProductsPhoto.bind('change', @proxy @changeRelated)
    
  changeRelated: (item, mode) ->
#    return unless @parent.isActive()
    return unless Product.record
    return unless Product.record.id is item['product_id']
    return unless item = Photo.find(item['photo_id'])
    @log 'changeRelated'
    
    switch mode
      when 'create'
        @wipe()
        @el.prepend @template item
        @refreshElements()
        @size(App.showView.sOutValue)
        @el.sortable('destroy').sortable('photo')
        $('.dropdown-toggle', @el).dropdown()
        @callDeferred [item], @uriSettings(300, 300), @proxy @callback
        
      when 'destroy'
        el = @findModelElement(item)
        el.detach()
      when 'update'
        @updateTemplate item
        @el.sortable('destroy').sortable('photo')
    
    @refreshElements()
    @el
  
  render: (items=[], mode='html') ->
    @log 'PhotosList::render ' + mode
    
    unless items.length
      s = if (s = @model.record?.screenname or s = @model.record?.name or s = @model.record?.title)? then 'in ' + s + ' nichts los - kein Moos' else 'nichts los hier. Brutal...'
      @renderEmpty(s)
      return @el
      
    sorted = items.sort Product.sortByReverseOrder
    @[mode] @template sorted
    #resize thumbnails to the correct values
    @proxy @size(App.showView.sOutValue)
    @exposeSelection()
    $('.dropdown-toggle', @el).dropdown()
    @callDeferred sorted, @uriSettings(300,300), @proxy @callback
    @el
  
  renderAll: ->
    items = Photo.all()
    if items.length
      @activateRecord()
      @html @template sorted
      @el.sortable('destroy').sortable('photo')
      @size(App.showView.sOutValue)
      sorted = Product.sortByReverseOrder items
#      @callDeferred  sorted, @uriSettings(300,300), @callback
    @el
    
  photos: (mode) ->
    if mode is 'add' or !Product.record
      Photo.all()
    else if product = Product.find mode
      product.photos()
    else if Product.record
      Product.record.photos()
      
  dropdownToggle: (e) ->
    el = $(e.currentTarget)
    el.dropdown()
    e.preventDefault()
    e.stopPropagation()   
    
  original: (e) ->
    id = $(e.currentTarget).item().id
    Product.selection[0].global.update [id]
    @navigate '/category', '/'
    
    e.preventDefault()
    e.stopPropagation()
    
  deletePhoto: (e) ->
    @log 'deletePhoto'
    item = $(e.currentTarget).item()
    return unless item?.constructor?.className is 'Photo' 
    
    Spine.trigger('delete:photos', [item.id])
    
    e.stopPropagation()
    e.preventDefault()
    
  zoom: (e) ->
    item = if e.type is 'click' then $(e.currentTarget).item() else @models.record
    
    @navigate '/category', Category.record?.id or '', Category.record?.selectionList?().first() or '', item.id or null
    
    e.stopPropagation()
    e.preventDefault()
    
  back: (e) ->
    @navigate '/category', Category.record?.id or '', pid = if (pid = Category.record?.selectionList?().first()) then 'pid/' + pid else null
    
    e.preventDefault()
    e.stopPropagation()
    
  initSelectable: ->
    options =
      helper: 'clone'
    @el.selectable()
    
  addPhotos: (e) ->
    e.stopPropagation()
    e.preventDefault()
    
    Spine.trigger('photos:add')
    
  sliderStart: ->
    @refreshElements()
      
  rotateCW: (e) ->
    item = $(e.currentTarget).item()
    @log item
    Spine.trigger('rotate', item, -90)
    e.stopPropagation()
    e.preventDefault()
    
  rotateCCW: (e) ->
    item = $(e.currentTarget).item()
    @log item
    Spine.trigger('rotate', item, 90)
    e.stopPropagation()
    e.preventDefault()
    
  rotate: (item, val=90) ->
    if item
     items = [item]
    else
      ids = Product.selectionList()[..]
      items = if ids.length then Photo.toRecords(ids.add(item?.id))
    options = val: val
    
    callback = (items) =>
      products = []
      res = for item in items
        photo = Photo.find item['Photo']['id']
        photo.clearCache()
        albs = photo.products()
        products.add alb.id for alb in albs
        photo
      
      @callDeferred res, @uriSettings(300,300), @proxy @callback
      products = Product.toRecords(products)
      Product.trigger('change:collection', products)
      Photo.trigger('develop', items)
      
    
    $('#'+item.id+'>.thumbnail', @el).removeClass('in') for item in items
    Photo.develop('rotate', options, callback, items)
    false
    
module?.exports = PhotosList