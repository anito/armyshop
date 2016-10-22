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
    'click button.close'  : 'close'
    'click .item'         : 'showPhoto'
    'keyup'               : 'keyup'

  template: (photos, products) ->
    $("#overviewTemplate").tmpl
      photos: photos
      summary:
        categories  : Category.all()
        products    : Product.all()
        photos      : Photo.all()
        published   : CategoriesProduct.publishedProducts(true)
        unpublished : CategoriesProduct.unpublishedProducts(true)
        unused      : Product.unusedProducts(true)
      products      : products
      counter: ->
        li = []
        li.push i for p, i in products
        li = li.concat([li.length, li.length+1])# add the to previous slides
        li

  toolsTemplate: (items) ->
    $("#toolsTemplate").tmpl items
    
  constructor: ->
    super
    @bind('active', @proxy @active)
#    @carousel.on('slide.bs.carousel', @proxy @focus)
    @el.data current: Recent
    @max = 100
    @bind('render:toolbar', @proxy @renderToolbar)
    
    @carouselOptions =
      keyboard:true
      paused: true
      
    @carousel.data('bs.carousel')
    @carousel.carousel(@carouselOptions)
    
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
    
  render: (tests) ->
    #validate fresh records against existing model collection
    items = []
    for test in tests
      items.push photo if photo = Photo.find(test.id)
      
    products = @getProducts()
    
    @html @template items, products
    @refreshElements()
    
    @callDeferred items, @uriSettings(70, 70), @proxy @callbackRecents
    
    photos = @getProductPhotos()
    @callDeferred photos, @uriSettings(300, 300), @proxy @callbackPreview
    
  callbackRecents: (json, items) ->
    searchJSON = (id) ->
      for itm in json
        return itm[id] if itm[id]
        
    for photo in items
      jsn = searchJSON photo.id
      photoEl = @recentsItems.children().forItem(photo)
      return unless photoEl.length
      img = new Image
      img.element = photoEl
      if jsn
        img.src = jsn.src
      else
        img.src = '/img/nophoto.png'
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
    me.log 'image could not be loaded'
  
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
    css = 'url(' + @src + ')'
    e = $('.thumbnail', @element).css
      'backgroundImage': css
      'backgroundPosition': 'center, center'
    
  showPhoto: (e) ->
    return
    index = @recentsItem.index($(e.currentTarget))
  
  error: (xhr, statusText, error) ->
    @log xhr
    @record.trigger('ajaxError', xhr, statusText, error)
    
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