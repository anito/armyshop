Spine     = require("spine")
$         = Spine.$
Category  = require('models/category')
CategoriesProduct  = require('models/categories_product')
Extender  = require('extensions/controller_extender')
UriHelper = require('extensions/uri_helper')
HomepageList  = require('controllers/homepage_list')

class HomepageView extends Spine.Controller

  elements:
    '.items'            : 'items'
    
  @extend Extender
  @extend UriHelper
  
  constructor: ->
    super
    @bind('active', @proxy @active)
    @list = new HomepageList
      el: @items
      parent: @
      
    Category.one('refresh', @proxy @active)
    Spine.bind('refresh:one', @proxy @refreshOne)
    Spine.bind('refresh:complete', @proxy @render)
    
  active: ->
    cat = Category.current(Category.findByAttribute('name', @categoryName))
    @change(cat)
    
  change: (cat) ->
    Spine.trigger('active:category', cat)
    @current = cat
    @render()
    
  refreshOne: ->
    @tracker = [
      Photo.one('refresh', @proxy @untrackBinds)
      Description.one('refresh', @proxy @untrackBinds)
      Product.one('refresh', @proxy @untrackBinds)
      Category.one('refresh', @proxy @untrackBinds)
    ]
    
  untrackBinds: (arr) ->
    @tracker.pop()
    Spine.trigger('refresh:complete') unless @tracker.length
    
  render: ->
    return unless @current
    products = Category.publishedProducts @current.id
    @list.render products
    for product in products
      (@callDeferred p = product.photos(), @uriSettings(300, 300), @proxy @callback)
      pricingSlider(product.id) if p.length > 1

  callback: (json, items) ->
    result = for jsn in json
      ret = for key, val of jsn
        src: val.src
        id: key
      ret[0]

    for res, idx in result
      @snap(res, result.length, idx)

  snap: (res, l, i) ->
    imgEl = $('#'+res.id+' img', @el)
    img = @createImage()
    img.imgEl = imgEl
    img.l = l
    img.i = i
    img.me = @
    img.res = res
    img.onload = @onLoad
    img.onerror = @onError
    img.src = res.src

  onLoad: ->
    @imgEl.attr('src', @src).removeClass('load').addClass('in')
    @me.log 'all loaded' if @i is @l-1
    
  onError: (e) -> throw 'unable to load image (Homepage)'
    
 module?.exports = HomepageView
