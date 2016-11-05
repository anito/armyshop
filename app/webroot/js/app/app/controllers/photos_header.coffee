Spine           = require("spine")
$               = Spine.$
Category         = require('models/category')
Product           = require('models/product')
Photo           = require('models/photo')
User            = require('models/user')
CategoriesProduct  = require('models/categories_product')
ProductsPhoto     = require('models/products_photo')
Extender        = require('extensions/controller_extender')

class PhotosHeader extends Spine.Controller
  
  @extend Extender
  
  events:
    'click .gal'       : 'backToCategories'
    'click .alb'       : 'backToProducts'

  template: (item) ->
    $("#headerPhotosTemplate").tmpl item

  constructor: ->
    super
    @bind('active', @proxy @active)
#    Category.bind('create update destroy', @proxy @render)
#    Product.bind('change', @proxy @render)
    Photo.bind('current', @proxy @render)
#    Photo.bind('change', @proxy @render)
#    Photo.bind('refresh', @proxy @render)
#    Category.bind('change:current', @proxy @render)
#    Product.bind('change:current', @proxy @render)
#    Product.bind('change:collection', @proxy @render)
    
    
  backToCategories: (e) ->
    @log 'backToCategories'
    @navigate '/category', ''
    e.preventDefault()
    
  backToProducts: (e) ->
    @log 'backToProducts'
    @navigate '/category', Category.record?.id or ''
    e.preventDefault()
    
  goUp: (e) ->
    @navigate '/category', Category.record.id or ''
    e.preventDefault()
    e.stopPropagation()
    
  change:  ->
    @render()
    
  render: ->
#    return unless @isActive()
    @html @template
      model             : Product
      category          : Category.record
      product           : Product.record
      photo             : Photo.record
      modelProduct      : Product
      modelPhoto        : Photo
      modelGas          : CategoriesProduct
      modelAps          : ProductsPhoto
      count             : @count()
      author            : User.first().name
    
  count: ->
    if Product.record
      ProductsPhoto.filter(Product.record.id, associationForeignKey: 'product_id').length
    else
      Photo.filter()
    
  active: ->
    @render()

module?.exports = PhotosHeader