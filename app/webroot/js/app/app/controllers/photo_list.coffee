Spine           = require("spine")
$               = Spine.$
Product           = require('models/product')
Extender        = require('extensions/controller_extender')
ProductsPhoto   = require('models/products_photo')

require('extensions/tmpl')

class PhotoList extends Spine.Controller
  
  @extend Extender
  
  events:
    'click .rotate-cw'        : 'rotateCW'
    'click .rotate-ccw'       : 'rotateCCW'
    
    'click .zoom'                     : 'zoom'
    'click .rotate'                   : 'rotate'
  
  constructor: ->
    super
    
    ProductsPhoto.bind('beforeDestroy', @proxy @back)
    
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
    
  back: ->
    @navigate '/category', Category.record?.id or '', Category.record?.selectionList?().first() or '', iid = if (iid = Product.record?.selectionList?().first()) then 'iid/' + iid else null
  
  zoom: (e) ->
  
  rotate: (e) ->
    @rotate(e)
    
module?.exports = PhotoList