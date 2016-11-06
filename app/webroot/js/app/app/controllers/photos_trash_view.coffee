Spine           = require("spine")
$               = Spine.$
Controller      = Spine.Controller
Drag            = require('extensions/drag')
User            = require("models/user")
PhotosTrash     = require("models/photos_trash")
Extender        = require('extensions/controller_extender')
UriHelper       = require('extensions/uri_helper')

class PhotosTrashView extends Spine.Controller
  
  @extend UriHelper
  @extend Drag
  @extend Extender
  
  elements:
    '.items'                          : 'items'
    
  events:
    'mousemove .item'              : 'in'
    'mouseleave .item'             : 'out'
    
  template: (items) ->
    $("#photosTemplate").tmpl items
 
  constructor: ->
    super
    @bind('active', @proxy @active)
    
    Photo.bind('destroy:fromTrash', @proxy @destroy)
    PhotosTrash.bind('change:selection', @proxy @exposeSelection)
    
    Photo.bind('destroy:photos', @proxy @destroyPhotos)
    
  render: (items) ->
    @items.html @template items
    @el
    
  active: ->
    @render()
    
    App.showView.trigger('change:toolbarOne', ['Default'])
    App.showView.trigger('change:toolbarTwo', ['Trustami'])
    
  destroyPhotos: (ids, callback) ->
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
    
  destroy: ->
    
  in: (e) =>
    el = $(e.currentTarget)
    $('.glyphicon-set.fade' , el).addClass('in').removeClass('out')
    
  out: (e) =>
    el = $(e.currentTarget)
    set = $('.glyphicon-set.fade' , el).addClass('out').removeClass('in')  
      
module?.exports = PhotosTrashView