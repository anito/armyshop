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
    '.preview'              : 'preview'
    '.items'                : 'items'
    '.inner'                : 'inner'
    '.expander'             : 'expander'
    '.content'              : 'contentEl'

  events:
    'click a[href]'          : 'followLink'
    'click .expander'        : 'expand'
    'click .item-content'    : 'expand'

  template:  (item) ->
    $('#norbuPricingTemplate').tmpl item if item
    
  constructor: ->
    super
    Product.bind('create update destroy', @proxy @change)
    Product.bind('current', @proxy @change)
    
    Photo.bind('develop',  @proxy @developed)
    
    Description.bind('change', @proxy @render)
    
    ProductsPhoto.bind('update destroy', @proxy @changedRelatedPhoto)
    
    Category.bind('change:selection', @proxy @dimmPreview)
    CategoriesProduct.bind('destroy', @proxy @change)
    
    @createDummy()
    @render()
    
  newAttributes: ->
    title: 'Semper Fi'
    id: '12345'
    price: '1.000.000,00'
    subtitle: 'Keep smiling & semper fi'
    
  createDummy: ->
    @dummy = new Product @newAttributes()
    @dummy.save(ajax:false)
    
  developed: (photos) ->
    photo = photos[0].Photo
    @callDeferred photo, @uriSettings(300, 300), @callback
    
  change: (item) ->
    if item?.destroyed or !item
      @current = @dummy
    else
      @current = item
    @render() 
    
  changedRelatedPhoto: (item) ->
    item = Product.find(item.product_id)
    if item isnt @current then @change item
    
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
    @callDeferred photo, @uriSettings(300, 300), @callback
    
  callback: (json, items) =>
    result = for jsn in json
      ret = for key, val of jsn
        src: val.src
        id: key
      ret[0]

    for res in result
      @snap(res)

  snap: (res) ->
    imgEl = $('[data-image-id='+res.id+'] img', @el)
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
    
  togglePreview: ->
    @expander.click()
    
  dimmPreview: (sel) ->
    dimm =  !!sel.length
    @preview.toggleClass('over', dimm)
    
  expand: (e) ->
    parent = $(e.target).closest('li')
    parent.toggleClass('open')

    e.preventDefault()
    
module?.exports = PreviewView