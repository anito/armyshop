Spine = require("spine")
$     = Spine.$
Model   = Spine.Model
Product  = require('models/product')
ProductsPhoto  = require('models/products_photo')
CategoriesProduct       = require('models/categories_product')
UriHelper = require('extensions/uri_helper')
Extender  = require('extensions/controller_extender')
require('spine/lib/local')

class PreviewView extends Spine.Controller
  
  @extend Extender
  @extend UriHelper
  
  elements:
    '.items'                : 'items'
    '.inner'                : 'inner'
    '.expander'             : 'expander'
    '.content'              : 'contentEl'

  events:
    'click      .expander'        : 'expand'
    'click      .item-content'         : 'expand'

  template:  (item) ->
    return unless item
    phs = Product.photos(item.id)
    ph = Product.photos(item.id)[0]#.reverse()[0]
    

    $('#norbuPricingTemplate').tmpl item
    
  constructor: ->
    super
    Product.bind('create update destroy', @proxy @change)
    Product.bind('current', @proxy @change)
    Description.bind('change', @proxy @render)
    ProductsPhoto.bind('update', @proxy @changedRelatedPhoto)
    CategoriesProduct.bind('destroy', @proxy @change)
    @createDummy()
    @render()
    
  newAttributes: ->
    title: 'Test Dummy'
    id: '12345'
    price: '123,45'
    subtitle: 'Test Subtitle Dummy'
    src:  'dummy.jpg'
    
  createDummy: ->
    @dummy = new Product @newAttributes()
    @dummy.save(ajax:false)
    
  change: (item) ->
    if item.destroyed or !item
      @current = @dummy
    else
      @current = item
    @render() 
    
  changedRelatedPhoto: (item) ->
    item = Product.find(item.product_id)
    if item then @change item
    
  item: (item) ->
    product: item
    descriptions: Description.filterSortByOrder(item.id)
    photo: Product.photos(item.id).first()
    
    
  render: ->
    return unless @current
    item = @item(@current)
    photo = item.photo
    @contentEl.html @template item
    return unless Photo.exists(photo?.id)
    @callDeferred photo, @callback
    
  size: (width, height) ->
    width: 300
    height: 300
    
  callback: (json, items) =>
    result = for jsn in json
      ret = for key, val of jsn
        src: val.src
        id: key
      ret[0]

    for res in result
      @snap(res)

  snap: (res) ->
    imgEl = $('#'+res.id+' img', @el)
    img = @createImage()
    img.imgEl = imgEl
    img.this = @
    img.res = res
    img.onload = @onLoad
    img.onerror = @onError
    img.src = res.src

  onLoad: ->
    @imgEl.attr('src', @src)
    @imgEl.addClass('in')

  onError: (e) ->
    @this.snap @res
    
  click: (e) ->
    return if parent.hasClass('open')
    @exapand(e)
    
  expand: (e) ->
    parent = $(e.target).closest('li')
    parent.toggleClass('open')

    e.stopPropagation()
    e.preventDefault()
    
module?.exports = PreviewView