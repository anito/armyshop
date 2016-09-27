Spine           = require("spine")
$               = Spine.$
Product           = require('models/product')
Extender        = require('extensions/controller_extender')

require('extensions/tmpl')

class PhotoList extends Spine.Controller
  
  @extend Extender
  
  events:
    'click .rotate-cw'        : 'rotateCW'
    'click .rotate-ccw'       : 'rotateCCW'
  
  constructor: ->
    super
    
  rotateCW: (e) ->
    item = $(e.currentTarget).item()
    Spine.trigger('rotate', item, -90)
    e.stopPropagation()
    e.preventDefault()
    
  rotateCCW: (e) ->
    item = $(e.currentTarget).item()
    Spine.trigger('rotate', item, 90)
    e.stopPropagation()
    e.preventDefault()
    
  back: (e) ->
    @navigate '/category', Category.record?.id or '', Product.record?.id or ''
    e.preventDefault()
    
module?.exports = PhotoList