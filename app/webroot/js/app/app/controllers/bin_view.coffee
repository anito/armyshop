Spine             = require("spine")
$                 = Spine.$
Bin               = require('models/bin')
Extender          = require('extensions/controller_extender')

class BinView extends Spine.Controller

  @extend Extender

  elements:
    '.item'           : 'item'
    
  constructor: ->
    super
    
    
    
module?.exports = BinView