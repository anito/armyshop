Spine                 = require("spine")
$                     = Spine.$
Category              = require('models/category')
Product               = require('models/product')
Photo           = require('models/photo')  
CategoriesProduct     = require('models/categories_product')
ProductsPhoto   = require('models/products_photo')
Extender              = require('extensions/controller_extender')

class CategoriesHeader extends Spine.Controller
  
  @extend Extender
  
  constructor: ->
    super
    @bind('active', @proxy @active)
    Category.bind('change', @proxy @render)
    Category.bind('refresh', @proxy @render)
    Category.bind('change:current', @proxy @render)
    
    Product.bind('change', @proxy @render)
    Product.bind('change:collection', @proxy @render)
    
    Photo.bind('refresh', @proxy @render)

  render: ->
#    return unless @isActive()
    @html @template
      model             : Category
      modelProduct      : Product
      modelPhoto        : Photo
      modelGas          : CategoriesProduct
      modelAps          : ProductsPhoto
      author            : User.first().name
    
  count: ->
    Category.count()
    
  active: ->
    @render()
  
  goUp: (e) ->
    @navigate '/overview', ''
    e.preventDefault()
    e.stopPropagation()
    
module?.exports = CategoriesHeader