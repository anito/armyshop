Spine     = require("spine")
$         = Spine.$

class SubNoProduct extends Spine.Controller

  constructor: ->
    super
    @bind('active', @proxy @active)
    
  active: ->
    @render()
    
  render: ->
    @html $("#noSelectionTemplate").tmpl({type: '<label class="invite"><span class="enlightened">Kein Produkt ausgewählt</span></label>'})
    
 module?.exports = SubNoProduct