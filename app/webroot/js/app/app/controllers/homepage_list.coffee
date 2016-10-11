Spine = require("spine")
$     = Spine.$

class HomepageList extends Spine.Controller
  
  template:  (item) ->
    $('#norbuPricingTemplate').tmpl item if item
    
  constructor: ->
    super
    
  render: (items) ->
    @html @template items
    
module?.exports = HomepageList