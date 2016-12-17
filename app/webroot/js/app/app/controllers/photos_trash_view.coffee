Spine           = require("spine")
$               = Spine.$
Controller      = Spine.Controller
Drag            = require('extensions/drag')
User            = require("models/user")
PhotosTrash     = require("models/photos_trash")
Extender        = require('extensions/controller_extender')
PhotoExtender   = require('extensions/photo_extender')
UriHelper       = require('extensions/uri_helper')

class PhotosTrashView extends Spine.Controller
  
  @extend Drag
  @extend Extender
  @extend PhotoExtender
  @extend UriHelper
  
  elements:
    '.items'                       : 'items'
    
  events:
    'click'                        : 'clearSelection'
    'click .item'                  : 'click'
    'click .dropdown-toggle'       : 'dropdownToggle'
    'click .opt-destroy'           : 'destroyPhoto'
    'click .opt-recover'           : 'recoverPhoto'
    
    'mousemove .item'              : 'in'
    'mouseleave .item'             : 'out'
    
    'dragstart '                   : 'dragstart'
    'dragend'                      : 'dragend'
    'drop'                         : 'drop'
    'dragover   '                  : 'dragover'
    'dragenter  '                  : 'dragenter'
    
    'keyup'                        : 'keyup'
    
  template: (items) ->
    $("#photosTrashTemplate").tmpl items
 
  constructor: ->
    super
    @bind('active', @proxy @active)
    
    Photo.bind('destroy:trash', @proxy @destroy)
    PhotosTrash.bind('change:selection', @proxy @exposeSelection)
    
    Photo.bind('beforeDestroy', @proxy @beforeDestroy)
    Photo.bind('destroy:photos', @proxy @destroyPhotos)
    Photo.bind('refresh', @proxy @initTrash)
    Photo.bind('inbound:trash', @proxy @inbound)
    Photo.bind('outbound:trash', @proxy @outbound)
    Photo.bind('empty:trash', @proxy @emptyTrash)
    Spine.bind('refresh:one', @proxy @refreshOne)
    
  initTrash: (items) ->
    for item in items when item.deleted
      trash = new PhotosTrash(id: item.id)
      trash.save()
      item.bind('update destroy', @proxy @watch)
    
  refreshOne: ->
    Photo.one('refresh', @proxy @refresh)
    
  # calls render for joins only
  refresh: () ->
    items = Photo.filter(true, func: 'selectDeleted')
    @render items
    
  render: (items) ->
    @items.html @template items
    @proxy @size(App.showView.sOutValue)
    $('.dropdown-toggle', @el).dropdown()
    @callDeferred items, @uriSettings(300,300), @proxy @callback
    @el
    
  active: (items) ->
    @render(items)
    
    App.showView.trigger('change:toolbarOne', ['Default', 'Help'])
    App.showView.trigger('change:toolbarTwo', ['Speichern'])
    
  inbound: (photos) ->
    photos = [photos] unless Array.isArray photos
    for photo in photos
      photo.deleted = true
      photo.save()
      Photo.trigger('trashed', photo)
    @initTrash photos
    
  outbound: (item) ->
#    alert 'outbound'
    
  watch: (item) ->
    if !item.deleted or item.destroyed
      trash = PhotosTrash.find(item.id)
      console.log trash
      trash.destroy()
      Photo.trigger('outbound:trash')
      @remove(item)
    
  dropdownToggle: (e) ->
    el = $(e.currentTarget)
    el.dropdown()
    
    e.stopPropagation()
    e.preventDefault()
    
  recoverPhoto: (e) ->
    e.stopPropagation()
    item = $(e.currentTarget).item()
    item.deleted = false
    item.save()
    
  destroyPhoto: (e) ->
    e.stopPropagation()
    item = $(e.currentTarget).item()
    
    @destroyPhotos(e, id) if id = item?.id
    
  destroyPhotos: (e, ids=@model.selectionList(), callback) ->
    @log 'destroyPhotos'
    ids = [ids] unless Array.isArray(ids)
    
    photos = Photo.toRecords(ids)
    for photo in photos
      if photo.deleted
        # delete from the trash
        if res or (res = App.confirm('DESTROY', @humanize(photos)))
          Photo.trigger('destroy:trash', photo)
          continue
        else break
        
    if typeof callback is 'function'
      callback.call()    
    
  beforeDestroy: (photo) ->
    @log 'beforeDestroy'
    return
    photo.unbind('released:fromTrash')
    photo.removeSelectionID()
    
    products = ProductsPhoto.products(photo.id)
    for product in products
      product.removeFromSelection photo.id
      photo.removeSelectionID()
      # remove all associated photos
      photos = ProductsPhoto.photos(product.id).toId()
      Photo.trigger('destroy:join', photos, product)
    
  destroyPhotos_: (ids, callback) ->
    @log 'destroyPhoto'
    ids = [ids] unless Array.isArray(ids)
    
    @stopInfo()
    
    ids = ids || Product.selectionList().slice(0)
    photos = Photo.toRecords(ids)
    
    for photo in photos
      el = @list.findModelElement(photo)
      el.removeClass('in')
      if product = Product.record
        @destroyJoin
          photos: [photo]
          product: product
      else
        photo.destroy()
      
        
    if typeof callback is 'function'
      callback.call()
    
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
    @navigate '/category', Category.record?.id or '', Category.record?.selectionList?().first() or '', iid = if (iid = Product.record?.selectionList?().first()) then 'iid/' + iid else null
    
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
        @destroyPhotos(e)
        e.preventDefault()
        e.stopPropagation()
    
      
module?.exports = PhotosTrashView