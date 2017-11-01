Spine           = require("spine")
$               = Spine.$
Category        = require('models/category')
Extender        = require('extensions/controller_extender')
PhotosTrash     = require('models/photos_trash')

class PhotosTrashHeader extends Spine.Controller
  
  @extend Extender
  
  events:
    'click .opt-RecoverPhotosTrash' : 'recover'
  
  template: (items) ->
    $("#headerPhotosTrashTemplate").tmpl items
  
  constructor: ->
    super
    @bind('active', @proxy @active)
    PhotosTrash.bind('change:selection', @proxy @change)

  change: (list) ->
    records = PhotosTrash.toRecords(list)
    @items = records
    @render records
    
  render: (items = []) ->
    @html @template {count:items.length}
    
  active: ->
    @render()
    
  recover: (e) ->
    PhotosTrash.trigger('recover', @items)
    
    e.stopPropagation()
    e.preventDefault()
    
module?.exports = PhotosTrashHeader