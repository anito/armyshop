Spine = require("spine")
$     = Spine.$
Model   = Spine.Model
Product  = require('models/product')
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
    'click      .expander'         : 'expand'

  template:  (item) ->
    item =
      product: item
      descriptions: Description.filterSortByOrder(item.id)
      photos: Product.photos(item.id).slice(-1)
    console.log item.photos
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
    p = Product.photos(@current.id)
    if p.length
      console.log photos = p.slice(-1)
      @callDeferred photos, @callback
    
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
    
  expand: (e) ->
    parent = $(e.target).closest('li')
    parent.toggleClass('open')

    e.stopPropagation()
    e.preventDefault()
    
module?.exports = PreviewView