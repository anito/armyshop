Spine   = require("spine")
$       = Spine.$
Recent  = require('models/recent')
Photo   = require('models/photo')
Product = require('models/product')
CategoriesProduct = require('models/categories_product')
Description = require('models/product')
Settings= require('models/settings')
Extender= require('extensions/controller_extender')
UriHelper = require('extensions/uri_helper')

require('extensions/tmpl')

class OverviewView extends Spine.Controller

  @extend UriHelper
  @extend Extender

  elements:
    '#overview-carousel'            : 'carousel'
    '.recents .carousel-item'       : 'recentsItems'
    '.recents .item'                : 'recentsItem'
    '.summary'                      : 'summary'
    
  events:
    'click button.close'                  : 'close'
    'click .item'                         : 'showPhoto'
    'keyup'                               : 'keyup'
    'click .opt-ShowProductsTrash'        : 'showProductsTrash'
    'click .opt-ShowUnpublishedProducts'  : 'showUnpublishedProducts'
    'click .opt-ShowUnusedProducts'       : 'showUnusedProducts'
    'click .opt-ShowAllCategories:not(.disabled)'     : 'showCategories'
    'click .opt-ShowAllProducts:not(.disabled)'       : 'showProductMasters'
    'click .opt-ShowAllPhotos:not(.disabled)'         : 'showPhotoMasters'
    
  template: (photos, products) ->
    $("#overviewTemplate").tmpl
      photos: photos
      summary:
        categories  : Category.all()
        photos      : Photo.all()
        products    : Product.filter(true)
        published   : CategoriesProduct.publishedProductsAll(true)
        unpublished : CategoriesProduct.unpublishedProducts(true)
        others      : CategoriesProduct.otherProducts(true)
        trashed     : Product.filter(true, func: 'selectDeleted')
      counter: ->
        li = []
#        li.push i for p, i in products
        li = li.concat([li.length, li.length+1])# add the to previous slides
        li

  toolsTemplate: (items) ->
    $("#toolsTemplate").tmpl items
    
  constructor: ->
    super
    @bind('active', @proxy @active)
#    @carousel.on('slide.bs.carousel', @proxy @focus)
    @el.data current: Recent
    @max = 42
    @bind('render:toolbar', @proxy @renderToolbar)
    
    @carouselOptions =
      keyboard:true
      paused: true
      
    @carousel.data('bs.carousel')
    @carousel.carousel(@carouselOptions)
    
#    Category.bind('change:collection', @proxy @renderAux)
#    Spine.bind('product:ignore', @proxy @renderAux)
    Recent.bind('refresh', @proxy @render)
    
  active: ->
    @loadRecent()
    
  loadRecent: ->
    Recent.loadRecent(@max, @proxy @parse)
    
  parse: (json) ->
    recents = []
    for item in json
      recents.push item['Photo']
    Recent.refresh(recents, {clear:true})
    
  renderAux: ->
    @loadRecent()
    
  render: (tests) ->
    #validate fresh records against existing model collection
    items = []
    for test in tests
      items.push photo if photo = Photo.find(test.id)
      
    products = @getProducts()
    
    @html @template items, products
    
    @callDeferred items, @uriSettings(70, 70), @proxy @callbackRecents
    
    photos = @getProductPhotos()
    @callDeferred photos, @uriSettings(300, 300), @proxy @callbackPreview
    
  showProductsTrash: ->
    @navigate '/trash/products', ''
        
  showUnpublishedProducts: (e) ->
    e.preventDefault()
    Product.trigger('show:unpublished')
    
  showUnusedProducts: (e) ->
    e.preventDefault()
    Product.trigger('show:unused')
    
  callbackRecents: (json) ->
    for jsn in json
      id for id of jsn 
      src = jsn[id].src
      photoEl = $('[data-id='+ id+']', @recentsItems)
      img = new Image
      img.me = @
      img.element = photoEl
      img.src = src
      img.onload = @imageLoad
  
  callbackPreview: (json, items) ->
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
    img.me = @
    img.res = res
    img.onload = @onLoad
    img.onerror = @onError
    img.src = res.src

  onLoad: ->
    @imgEl.attr('src', @src)
    @imgEl.addClass('in')

  onError: (e) ->
    @me.log 'image could not be loaded'
  
  getProducts: ->
    for item in Product.records
      product: item
      descriptions: Description.filterSortByOrder(item.id)
      photo: Product.photos(item.id).first()
  
  getProductPhotos: ->
    photos = []
    $('[data-image-id]', @el).each (index)->
      photos.push(item) if item = $(@).item()
    photos
      
  imageLoad: ->
    @me.log 'loaded'
    css = 'url(' + @src + ')'
    @element.css
      'backgroundImage': css
      'backgroundPosition': 'center, center'
    
  showPhoto: (e) ->
    return
    index = @recentsItem.index($(e.currentTarget))
  
  error: (xhr, statusText, error) ->
    @log xhr
    @record.trigger('ajaxError', xhr, statusText, error)
    
  showCategories: ->
    @navigate '/category', cid = if (cid = Category.record?.id) then 'cid/' + cid else null
  
  showProductMasters: ->
    @navigate '/category', ''
    
  showPhotoMasters: ->
    @navigate '/category', '/'
    
  close: (e) ->
    previousHash = Model.Settings.loadSettings().previousHash
    if previousHash isnt location.hash
      @navigate previousHash
    else
      @navigate '#/category', if first = Category.first()?.id then first else ''# '#/categories')
      
    e.preventDefault()
    e.stopPropagation()
    
  keyup: (e) ->
    code = e.charCode or e.keyCode
    
    @log 'keyup', code
    
    @carousel.data('bs.carousel') || @carousel.carousel(@carouselOptions)
      
    switch code
      when 27 #Esc
        @close(e)
      when 32 #Space
        paused = @carousel.data('bs.carousel').paused
        if paused
          @carousel.carousel('next')
          @carousel.carousel('cycle')
        else
          @carousel.carousel('pause')
      when 39 #Right
        @carousel.carousel('next')
      when 37 #Left
        @carousel.carousel('prev')

module?.exports = OverviewView