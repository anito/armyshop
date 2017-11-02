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
    @bind('selected', @proxy @selected)
    
    PhotosTrash.bind('change:selection', @proxy @exposeSelection)
    PhotosTrash.bind('recover', @proxy @recoverPhotos)
    PhotosTrash.bind('beforeDestroy', @proxy @beforeDestroy)
    
    Photo.bind('destroy:trash', @proxy @destroy)
    Photo.bind('inbound:trash', @proxy @inbound)
    Photo.bind('destroy:photos', @proxy @destroyPhotos)
    Photo.bind('refresh', @proxy @initTrash)
    Photo.bind('empty:trash', @proxy @emptyTrash)
    
    Spine.bind('refresh:one', @proxy @refreshOne)
    
  initTrash: (items) ->
    for item in items when item.deleted
      trash = new PhotosTrash(id: item.id)
      trash.save()
      item.one('update destroy', @proxy @watch)
    
  refreshOne: ->
    Photo.one('refresh', @proxy @refresh)
    
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
    
  watch: (item) ->
    if !item.deleted or item.destroyed
      trash = PhotosTrash.find(item.id)
      trash.destroy()
      @remove(item)
    
  dropdownToggle: (e) ->
    el = $(e.currentTarget)
    el.dropdown()
    
    e.stopPropagation()
    e.preventDefault()
    
  recoverPhoto: (e) ->
    e.stopPropagation()
    
    item = $(e.target).item()
    @recoverPhotos item
    
    e.stopPropagation()
    e.preventDefault()
    
  recoverPhotos: (items) ->
    items = [items] unless Array.isArray(items)
    
    for item in items
      photo = Photo.find(item.id)
      photo.deleted = false
      photo.save()
    
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
    
  beforeDestroy: (trash) ->
    @log 'beforeDestroy'
    trash.removeSelectionID()
    PhotosTrash.removeFromSelection(null, trash.id)
    
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
    @select e, item.id, true
    
    e.stopPropagation()
    
  back: (e) ->
    @navigate '/category', Category.record?.id or '', Category.record?.selectionList?().first() or '', iid = if (iid = Product.record?.selectionList?().first()) then 's/' + iid else null
    
  in: (e) =>
    el = $(e.currentTarget)
    $('.glyphicon-set.fade' , el).addClass('show').removeClass('fade')
    
  out: (e) =>
    el = $(e.currentTarget)
    set = $('.glyphicon-set.fade' , el).addClass('fade').removeClass('show')
    
  keyup: (e) ->
    code = e.charCode or e.keyCode
    
    switch code
      when 8 #Backspace
        @destroyPhotos(e)
        e.preventDefault()
        e.stopPropagation()
    
      
module?.exports = PhotosTrashView