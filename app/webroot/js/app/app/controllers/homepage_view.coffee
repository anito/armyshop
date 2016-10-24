Spine     = require("spine")
$         = Spine.$
Category  = require('models/category')
Extender  = require('extensions/controller_extender')
UriHelper = require('extensions/uri_helper')
HomepageList  = require('controllers/homepage_list')

class HomepageView extends Spine.Controller

  elements:
    '.items'      : 'items'
    
  @extend Extender
  @extend UriHelper
  
  constructor: ->
    super
    @bind('active', @proxy @active)
    @list = new HomepageList
      el: @items
      parent: @
    
    Spine.bind('bindRefresh:one', @proxy @bindRefresh)
    
  active: (e) ->
    @change()
    
  change: ->
    @current = Category.current(Category.findByAttribute('name', @categoryName))
    @render()
    
  bindRefresh: ->
    @tracker = [1,2,3,4]
    Photo.one('refresh', @proxy @untrackBinds)
    Description.one('refresh', @proxy @untrackBinds)
    Product.one('refresh', @proxy @untrackBinds)
    Category.one('refresh', @proxy @untrackBinds)
    
  untrackBinds: (arr) ->
    @tracker.pop()
    @change() unless @tracker.length
    
  render: ->
    @refreshView.render('repeat')
    return unless @current
    
    items = []
    products = Category.products @current.id
    items.push @item(product) for product in products
    @list.render(items)
    (@callDeferred item.photo, @uriSettings(300, 300), @proxy @callback) for item in items
    
  item: (item) ->
    product: item
    descriptions: Description.filterSortByOrder(item.id)
    photo: Product.photos(item.id).first()
    
  callback: (json, items) ->
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
    
 module?.exports = HomepageView
