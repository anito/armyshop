Spine           = require("spine")
$               = Spine.$
Model           = Spine.Model
Category         = require('models/category')
Product           = require('models/product')
Photo           = require('models/photo')
ProductsPhoto     = require('models/products_photo')
CategoriesProduct  = require('models/categories_product')
Extender        = require('extensions/controller_extender')
PhotoExtender        = require('extensions/photo_extender')
UriHelper = require('extensions/uri_helper')

require('extensions/tmpl')

class PhotosAddList extends Spine.Controller
  
  @extend UriHelper
  @extend Extender
  @extend PhotoExtender
  
  elements:
    '.thumbnail'              : 'thumbEl'
  
  constructor: ->
    super
    
  
  render: (items) ->
    if items.length
      sorted = items.sort Product.sortByReverseOrder
      @html @template items
      @proxy @size(App.showView.sOutValue)
      @callDeferred sorted, @uriSettings(300,300), @proxy @callback
    else
      @html '<span class="enlightened">Es gibt nichts hinzuzufügen.</span>'
    @el
    
  exposeSelection: (selection) ->
    @deselect()

    for id in selection
      el = $('#'+id, @el)
      el.addClass("active hot")

module?.exports = PhotosAddList