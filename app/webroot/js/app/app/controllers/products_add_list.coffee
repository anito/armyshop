Spine           = require("spine")
$               = Spine.$
Model           = Spine.Model
Category         = require('models/category')
Product           = require('models/product')
Photo           = require('models/photo')
ProductsPhoto     = require('models/products_photo')
CategoriesProduct  = require('models/categories_product')
Extender        = require('extensions/controller_extender')
ProductExtender        = require('extensions/product_extender')
UriHelper = require('extensions/uri_helper')

require('extensions/tmpl')

class ProductsAddList extends Spine.Controller
  
  @extend UriHelper
  @extend Extender
  @extend ProductExtender
  
  constructor: ->
    super
    
  
  render: (items) ->
    if items.length
      @html @template items
      @renderBackgrounds items
    else
      @renderEmpty('Es gibt nichts hinzuzufügen.')
    @el
    
  exposeSelection: (selection) ->
    @deselect()

    for id in selection
      el = $('#'+id, @el)
      el.addClass("active hot")

module?.exports = ProductsAddList