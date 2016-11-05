Spine     = require("spine")
$         = Spine.$
Extender  = require('extensions/controller_extender')

class SubNoProduct extends Spine.Controller

  @extend Extender
  
  constructor: ->
    super
    @bind('active', @proxy @active)
    
  active: ->
    @render()
    
  render: ->
    @renderEmpty('Kein Produkt ausgewählt')
    
 module?.exports = SubNoProduct