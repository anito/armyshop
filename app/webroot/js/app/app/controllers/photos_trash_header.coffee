Spine           = require("spine")
$               = Spine.$
Category         = require('models/category')
Extender        = require('extensions/controller_extender')

class PhotosTrashHeader extends Spine.Controller
  
  @extend Extender
  
  template: (items) ->
    $("#headerPhotosTrashTemplate").tmpl items
  
  constructor: ->
    super
    @bind('active', @proxy @active)

  render: (item) ->
    @html @template item
    
  active: ->
    @render()
    
module?.exports = PhotosTrashHeader