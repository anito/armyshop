Spine           = require("spine")
$               = Spine.$
Product           = require('models/product')
Category         = require('models/category')
ProductsPhoto     = require('models/products_photo')
CategoriesProduct  = require('models/categories_product')
Extender        = require('extensions/controller_extender')

class PhotoHeader extends Spine.Controller
  
  @extend Extender
  
  events:
    'click .gal'   : 'backToCategories'
    'click .alb'   : 'backToProducts'
    'click .pho'   : 'backToPhotos'

  template: (item) ->
    $("#headerPhotoTemplate").tmpl item

  constructor: ->
    super
    @bind('active', @proxy @active)
    Photo.bind('current', @proxy @render)
    Category.bind('change', @proxy @render)
    Product.bind('change', @proxy @render)
    Photo.bind('change', @proxy @render)

  render: ->
#    return unless @isActive()
    @html @template
      model       : Product
      category     : Category.record
      product       : Product.record
      photo       : Photo.record
      modelProduct  : Product
      modelPhoto  : Photo
      modelGas    : CategoriesProduct
      modelAps    : ProductsPhoto
      count       : @count()
      author      : User.first().name
      zoomed      : true
    
  count: ->
    if Product.record
      ProductsPhoto.filter(Product.record.id, associationForeignKey: 'product_id').length
    else
      Photo.count()
    
  active: ->
    @render()
    
  backToCategories: (e) ->
    @navigate '/category', ''
    e.preventDefault()
    
  backToProducts: (e) ->
    @navigate '/category', Category.record?.id or ''
    e.preventDefault()
    
  backToPhotos: (e) ->
    @navigate '/category', Category.record?.id or '', Category.record?.selectionList().first() or ''
    e.preventDefault()
    
  goUp: (e) ->
    @navigate '/category', Category.record.id or '', Category.record?.selectionList().first() or ''
    e.preventDefault()
    
  drop: (e) ->
    e.stopPropagation()
    e.preventDefault()

    
module?.exports = PhotoHeader