Spine = require("spine")
$     = Spine.$
Model   = Spine.Model
Product  = require('models/product')
CategoriesProduct       = require('models/categories_product')
require('spine/lib/local')

class PreviewView extends Spine.Controller

  elements:
    '.items'                : 'items'
    '.inner'                : 'inner'
    '.expander'             : 'expander'
    '.content'              : 'contentEl'

  events:
    'click      .expander'         : 'expand'

  template:  (item) ->
    item =
      product: item
      descriptions: Description.filterSortByOrder(item.id)
      
    $('#norbuPricingTemplate').tmpl item
    
  constructor: ->
    super
    Product.bind('change', @proxy @change)
    Product.bind('current', @proxy @change)
    Product.bind('destroy', @proxy @change)
    Description.bind('change', @proxy @render)
    CategoriesProduct.bind('destroy', @proxy @change)
    @createDummy()
    @render()
    
  newAttributes: ->
    title: 'Test Dummy'
    id: '12345'
    price: '123,45'
    subtitle: 'Test Subtitle Dummy'

  createDummy: ->
    @dummy = new Product @newAttributes()
    @dummy.save(ajax:false)
    
  change: (item) ->
    @log item
    if item.destroyed or !item
      @current = @dummy
    else
      @current = item
    @render() 
    
  render: ->
    @contentEl.html @template @current
    
  expand: (e) ->
    parent = $(e.target).closest('li')
    parent.toggleClass('open')

    e.stopPropagation()
    e.preventDefault()
    
module?.exports = PreviewView