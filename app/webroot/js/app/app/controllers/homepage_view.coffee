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
    @current = Category.current(Category.findByAttribute('name', @categoryName))
    @render()
    
  bindRefresh: ->
    @tracker = [Photo.className, Description.className, Product.className, Category.className]
    Photo.one('refresh', @proxy @untrackBinds)
    Description.one('refresh', @proxy @untrackBinds)
    Product.one('refresh', @proxy @untrackBinds)
    Category.one('refresh', @proxy @untrackBinds)
    
  untrackBinds: (arr) ->
    className = arr.first().constructor.className
    @tracker.splice(index, 1) for t, index in @tracker when t is className
    @render() unless @tracker.length
    
  render: ->
    @refreshView.render('repeat')
    return unless @current
    
    items = []
    products = Category.publishedProducts @current.id
    items.push @item(product) for product in products
    
    @list.render(items)
    @callDeferred item.photo, @callback for item in items
    
  item: (item) ->
    product: item
    descriptions: Description.filterSortByOrder(item.id)
    photo: Product.photos(item.id).first()
    
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
    
 module?.exports = HomepageView
