Spine = require("spine")
$     = Spine.$

require('extensions/tmpl')

class HomepageList extends Spine.Controller
  
  elements:
    '.pricing__item'      : 'item'
    
  events:
    'click .pricing__item': 'click'
  
  template:  (item) ->
    $('#norbuPricingTemplate').tmpl item
    
  constructor: ->
    super
    
    @options =
      width         : 500
      height        : 500
      play:
        active      : true
        effect      : "slide"
        interval    : 5000
        auto        : true
        swap        : true
        pauseOnHover: false
        restartDelay: 2500
      callback:
        loaded      : (n) -> console.log n + 'loaded '
        start       : (n) -> console.log @
        complete    : (n) -> console.log n
      pagination:
        active      : false
        effect      : "slide"
      effect:
        slide:
          speed     : 200
        fade:
          speed     : 200
          crossfade : true
          
  render: (items) ->
    @html @template items
#    @createSlides items
    
  click: (e) ->
    id = $(e.currentTarget).data('id')
    item = $(e.currentTarget).item()
    @navigate '/item', item.id
    
  createSlides: (items) ->
    for item in items
      photos = item.photos
      $('#'+item.product.id, @el).slidesjs @options
    
module?.exports = HomepageList