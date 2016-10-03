Spine           = require("spine")
$               = Spine.$
Model           = Spine.Model
Controller      = Spine.Controller
Category           = require('models/category')
Product           = require('models/product')
Photo           = require('models/photo')
ProductsPhoto     = require('models/products_photo')
Settings        = require('models/settings')
Extender        = require('extensions/controller_extender')

require('extensions/uri')
require('extensions/tmpl')
require('extensions/utils')

class SlideshowView extends Spine.Controller
  
  @extend Extender
  
  elements:
    '.items'           : 'itemsEl'
    '.thumbnail'       : 'thumb'
    
  events:
    'click .item'      : 'click'
    'click .back'      : 'back'
    
    'keydown'          : 'keydown'
    
  template: (items) ->
    $("#photosSlideshowTemplate").tmpl items

  constructor: ->
    super
    @bind('active', @proxy @active)
    @el.data('current',
      model: Category
      models: Product
    )
    @temp = []
    @viewport = $('.items', @el)
    @thumbSize = 240
    
    @defaults =
      index             : 0
      startSlideshow    : true
      slideshowInterval : 2000
      clearSlides: true
      container: '#blueimp-category'
      displayClass: 'blueimp-category-display'
      fullScreen: false
      carousel: false
      useBootstrapModal: true
      onopen: @proxy @onopenCategory
      onopened: @proxy @onopenedCategory
      onclose:  @proxy @oncloseCategory
      onclosed: @proxy @onclosedCategory
      onslide: @onslide
    
    @bind('play', @proxy @play)
    Spine.bind('slider:change', @proxy @size)
    Spine.bind('chromeless', @proxy @chromeless)
    Spine.bind('loading:done', @proxy @loadingDone)
    
  active: (params) ->
    if params
      @options = $().unparam(params)
      
    App.showView.trigger('change:toolbarOne', ['SlideshowPackage', App.showView.initSlider])
    App.showView.trigger('change:toolbarTwo', ['Close'])
    @render()
    
  render: ->
    @log 'render'
    items = @temp
    unless items.length
      @itemsEl.html '<label class="invite">
        <span class="enlightened">This slideshow does not have any images &nbsp;
        <p>Note: Select one or more albums with images.</p>
        </span>
        <button class="back dark large"><i class="glyphicon glyphicon-chevron-up"></i><span>&nbsp;Back</span></button>
        </label>'
    else
      @itemsEl.html @template items
      @uri items
      @refreshElements()
      @size(App.showView.sliderOutValue())
    
    @el
    
  loadingDone: ->
    return unless @isActive()
    @temp.update []
       
  params: (width = @parent.thumbSize, height = @parent.thumbSize) ->
    width: width
    height: height
  
  uri: (items) ->
    @log 'uri'
    Photo.uri @params(),
      (xhr, record) => @callback(items, xhr),
      items
    
  # we have the image-sources, now we can load the thumbnail-images
  callback: (items, json) ->
    @log 'callback'
    searchJSON = (id) ->
      for itm in json
        return itm[id] if itm[id]
    for item, index in items
      jsn = searchJSON item.id
      if jsn
        ele = @itemsEl.children().forItem(item)
        img = new Image
        img.onload = @imageLoad
        img.that = @
        img.element = ele
        img.index = index
        img.items = items
        img.src = jsn.src
        $(img).addClass('hide')
  
  imageLoad: ->
    css = 'url(' + @src + ')'
    $('.thumbnail', @element).css
      'backgroundImage': css
      'backgroundPosition': 'center, center'
      'backgroundSize': '100%'
    .append @
    if @index is @items.length-1
      @that.loadModal @items
      
  modalParams: ->
    width: 600
    height: 451
    square: 2
    force: false
    
  # loading data-href for original images size (modalParams)
  loadModal: (items, mode='html') ->
    Photo.uri @modalParams(),
      (xhr, record) => @callbackModal(xhr, items),
      items
  
  callbackModal: (json, items) ->
    @log 'callbackModal'
    
    searchJSON = (id) ->
      for itm in json
        return itm[id] if itm[id]
        
    for item in items
      jsn = searchJSON item.id
      if jsn
        el = @itemsEl.children().forItem(item)
        thumb = $('.thumbnail', el)
        thumb.attr
          'href'   : jsn.src
          'title'       : item.title or item.src
          'data-category': 'category'
          'data-photo': item.photo
    @trigger('slideshow:ready')
      
  size: (val=@thumbSize, bg='none') ->
    # 2*10 = border radius
    @thumb.css
      'height'          : val+'px'
      'width'           : val+'px'
      'backgroundSize'  : bg
    
  
      
  fullScreenEnabled: ->
    !!(window.fullScreen)
    
  slideshowable: ->
    @temp().length
    
  click: (e) ->
    options =
      index         : @thumb.index($(e.target))
      startSlideshow: false
    @play(options)
    
    e.stopPropagation()
    e.preventDefault()
    
  play: (options={index:0}, list) ->
    @options = options
    unless @isActive()
      @previousHash = location.hash unless /^#\/slideshow\//.test(location.hash)
      params = $.param(options)
      p = @temp.update list or App.activePhotos() # mixin images to override album images
      @one('slideshow:ready', @proxy @playSlideshow) if p.length
      @navigate '/slideshow', params
    else @playSlideshow()
      
  playSlideshow: (options=@options) ->
    return if @categoryIsActive()
    options = $().extend({}, @defaults, options)
    @refreshElements()
    @category = blueimp.Category(@thumb, options)
    delete @options
    
  onopenedCategory: (e) ->
    
  onopenCategory: (e) ->
    App.modal.exists = true
    
  oncloseCategory: (e) ->
    if @previousHash
      location.hash = @previousHash
      delete @previousHash
    else
      @parent.back()
    
  onclosedCategory: (e) ->
    @images = []
    App.modal.exists = false
    
  onslide: (index, slide) ->
    text = @list[index].getAttribute('data-photo')
    node = @container.find('.photo')
    node.empty()
    if (text)
      node[0].appendChild(document.createTextNode(text));
    
  categoryIsActive: ->
    $('#blueimp-category').hasClass(@defaults.displayClass)
    
  back: (e) ->
    if previousHash = Settings.findUserSettings().previousHash
      location.hash = previousHash
    else
      @navigate '/categories/'
    
  keydown: (e) ->
    code = e.charCode or e.keyCode
    
    @log 'SlideshowView:keydownCode: ' + code
    
    switch code
      when 27 #Esc
        @back(e)
        e.preventDefault()
  
module?.exports = SlideshowView