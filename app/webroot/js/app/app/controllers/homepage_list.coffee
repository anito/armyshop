Spine = require("spine")
$     = Spine.$

require('extensions/tmpl')

class HomepageList extends Spine.Controller
  
  elements:
    '.pricing__item'      : 'item'
    
  events:
    'click .pricing__item img': 'click'
#    'click .pricing__item': 'test'
  
  test: ->
  
  template:  (item) ->
    $('#norbuPricingTemplate').tmpl item
    
  constructor: ->
    super
    
  render: (items) ->
    @html @template items
    
  click: (e) ->
    item = $(e.currentTarget).parents('.pricing__item').item()
    @navigate '/item', item.id
    
module?.exports = HomepageList