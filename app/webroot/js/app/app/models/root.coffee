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
  
  @contains: (id=@record.id) ->
    Model[@childType].all()
    
  init: (instance) ->
    
  contains: (inc = 0) ->
    @constructor.contains(@id).length + inc
    
    
module?.exports = Model.Root = Root

