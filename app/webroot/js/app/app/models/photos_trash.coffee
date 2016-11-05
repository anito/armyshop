Spine             = require("spine")
$                 = Spine.$
Model             = Spine.Model
Extender          = require("extensions/model_extender")

class PhotosTrash extends Spine.Model

  @configure "PhotosTrash", 'id'

  @extend Extender
  
  init: (instance) ->
    return unless id = instance.id
    
    
module?.exports = Model.PhotosTrash = PhotosTrash

