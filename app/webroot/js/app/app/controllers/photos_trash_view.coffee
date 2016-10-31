Spine           = require("spine")
$               = Spine.$
Controller      = Spine.Controller
Drag            = require('extensions/drag')
User            = require("models/user")
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
    
  render: (items) ->
    @items.html @template items
    @el
    
  active: ->
    @render()
    
    App.showView.trigger('change:toolbarOne', ['Default', 'Help'])
    App.showView.trigger('change:toolbarTwo', ['Speichern'])
    
  destroy: ->
    
  in: (e) =>
    el = $(e.currentTarget)
    $('.glyphicon-set.fade' , el).addClass('in').removeClass('out')
    
  out: (e) =>
    el = $(e.currentTarget)
    set = $('.glyphicon-set.fade' , el).addClass('out').removeClass('in')  
      
module?.exports = PhotosTrashView