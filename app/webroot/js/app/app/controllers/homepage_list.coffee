Spine = require("spine")
$     = Spine.$

class HomepageList extends Spine.Controller
  
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
    
  createSlides: (items) ->
    for item in items
      photos = item.photos
      $('#'+item.product.id, @el).slidesjs @options
    
module?.exports = HomepageList