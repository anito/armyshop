Spine             = require("spine")
$                 = Spine.$
Model             = Spine.Model
Category           = require('models/category')
Filter            = require("extensions/filter")
Extender          = require("extensions/model_extender")

class Root extends Spine.Model

  @configure "Root", 'id'

  @extend Extender
  
  @childType: 'Category'
  
  init: (instance) ->
    return unless id = instance.id
    
    
module?.exports = Model.Root = Root

