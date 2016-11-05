Spine           = require("spine")
$               = Spine.$
Category         = require('models/category')
Product           = require('models/product')
Photo           = require('models/photo')
CategoriesProduct  = require('models/categories_product')
ProductsPhoto     = require('models/products_photo')
Extender        = require('extensions/controller_extender')

class ProductsHeader extends Spine.Controller
  
  @extend Extender
  
  events:
    'click .gal'      : 'backToCategories'
  
  constructor: ->
    super
    @bind('active', @proxy @active)
    Category.bind('change', @proxy @render)
    CategoriesProduct.bind('change', @proxy @render)
    Category.bind('change:selection', @proxy @render)
    Product.bind('refresh', @proxy @render)
    Product.bind('change', @proxy @render)
    Product.bind('change:current', @proxy @render)
    Product.bind('change:collection', @proxy @render)

  render: ->
#    return unless @isActive()
    @html @template
      model             : Category
      modelProduct      : Product
      modelPhoto        : Photo
      modelGas          : CategoriesProduct
      modelAps          : ProductsPhoto
      category          : Category.record
      product           : Product.record
      photo             : Photo.record
      author            : User.first().name
        
    @refreshElements()
    
  count: ->
    if Category.record
      filterOptions =
        model: 'Category'
        
      Product.filterRelated(Category.record.id, filterOptions).length
    else
      Product.filter()
      
  backToCategories: (e) ->
    @navigate '/category', ''
    e.preventDefault()
    
  goUp: (e) ->
    @navigate '/category', ''
    e.preventDefault()
    e.stopPropagation()
    
  active: ->
    @render()
    
module?.exports = ProductsHeader