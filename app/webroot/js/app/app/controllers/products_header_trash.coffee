Spine           = require("spine")
$               = Spine.$
Category         = require('models/category')
Product           = require('models/product')
Photo           = require('models/photo')
User            = require('models/user')
CategoriesProduct  = require('models/categories_product')
ProductsPhoto     = require('models/products_photo')
Extender        = require('extensions/controller_extender')

class PhotosHeaderTrash extends Spine.Controller
  
  @extend Extender
  
  events:
    'click .gal'       : 'backToCategories'
    'click .alb'       : 'backToProducts'

  template: (item) ->
    $("#headerProductTemplate").tmpl item

  constructor: ->
    super
    @bind('active', @proxy @active)
    Category.bind('create update destroy', @proxy @render)
    Product.bind('change', @proxy @render)
    Product.bind('change:selection', @proxy @render)
    Photo.bind('change', @proxy @render)
    Photo.bind('refresh', @proxy @render)
    Category.bind('change:current', @proxy @render)
    Product.bind('change:current', @proxy @render)
    Product.bind('change:collection', @proxy @render)
    
  active: ->
    @render()
    
  change:  ->
    @render()
    
  render: (item) ->
    @html @template item
    

module?.exports = PhotosHeaderTrash