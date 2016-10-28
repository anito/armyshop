Spine           = require("spine")
$               = Spine.$
Photo           = require('models/photo')
Product         = require('models/product')
ProductsPhoto   = require('models/products_photo')
ToolbarView     = require("controllers/toolbar_view")
Extender        = require('extensions/controller_extender')
Drag            = require('extensions/drag')
UriHelper       = require('extensions/uri_helper')

require('extensions/tmpl')

class PhotosList extends Spine.Controller
  
#  @extend Drag
  @extend Extender
  @extend UriHelper
  
  elements:
    '.thumbnail'              : 'thumbEl'
    '.toolbar'                : 'toolbarEl'
    
  events:
    'click .opt-AddPhotos'        : 'addPhotos'
    'click .dropdown-toggle'      : 'dropdownToggle'
    'click .delete'               : 'deletePhoto'
    'click .zoom'                 : 'zoom'
    'click .rotate-cw'            : 'rotateCW'
    'click .rotate-ccw'           : 'rotateCCW'
    'click .original'             : 'original'
    
  selectFirst: true

  constructor: ->
    super
    
    @toolbar = new ToolbarView
      el: @toolbarEl
    @add = @html
    Spine.bind('slider:start', @proxy @sliderStart)
    Spine.bind('slider:change', @proxy @size)
    Spine.bind('rotate', @proxy @rotate)
    Product.bind('ajaxError', Product.errorHandler)
    Product.bind('change:selection', @proxy @exposeSelection)
    ProductsPhoto.bind('change', @proxy @changeRelated)
    
  changeRelated: (item, mode) ->
#    return unless @parent.isActive()
    return unless Product.record
    return unless Product.record.id is item['product_id']
    return unless item = Photo.find(item['photo_id'])
    @log 'changeRelated'
    
    switch mode
      when 'create'
        @wipe()
        
        @el.prepend @template item
        @refreshElements()
        @size(App.showView.sOutValue)
        @el.sortable('destroy').sortable('photo')
        $('.dropdown-toggle', @el).dropdown()
        @callDeferred [item], @uriSettings(300, 300), @callback
#        @updateTemplate item
        
      when 'destroy'
        el = @findModelElement(item)
        el.detach()
      when 'update'
        @updateTemplate item
        @el.sortable('destroy').sortable('photo')
    
    @refreshElements()
    @el
  
  render: (items=[], mode) ->
    @log 'PhotosList::render ' + mode
    
    if items.length
      @wipe()
      sorted = items.sort Product.sortByReverseOrder
      @[mode] @template sorted
      #resize thumbnails to the correct values
      @size(App.showView.sOutValue)
      @exposeSelection()
      $('.dropdown-toggle', @el).dropdown()
      @callDeferred sorted, @uriSettings(300,300), @callback
      
    else if mode is 'add'
      @html '<h3 class="invite"><span class="enlightened">Es können keine Fotos hinzugefügt werden.</span></h3>'
      @append '<h3><label class="invite label label-default"><span class="enlightened">Es können keine Fotos hinzugefügt werden. Eventuell muss erst ein Produkt ausgewählt werden.</span></label></h3>'
    else 
      if Photo.count()
        @html '<label class="invite">
        <div class="enlightened">Es sind keine Fotos vorhanden</div><br>
        <button class="opt-UploadDialogue dark large"><i class="glyphicon glyphicon-upload"></i><span>&nbsp;Upload</span></button>
        <button class="opt-AddPhotos dark"><i class="glyphicon glyphicon-book"></i><span>&nbsp;Aus Katalog wählen</span></button>
        </label>'
      else
        @html '<label class="invite">
        <div class="enlightened">Es sind keine Fotos vorhanden &nbsp;</div><br>
        <button class="opt-UploadDialogue dark large"><i class="glyphicon glyphicon-upload"></i><span>&nbsp;Upload</span></button>
        </label>'
    @el
  
  renderAll: ->
    items = Photo.all()
    if items.length
      @activateRecord()
      @html @template sorted
      @el.sortable('destroy').sortable('photo')
      @size(App.showView.sOutValue)
      sorted = Product.sortByReverseOrder items
      @callDeferred  sorted, @uriSettings(300,300), @proxy @callback
    @el
  
  wipe: ->
    if Product.record
      first = Product.record.count() is 1
    else
      first = Photo.count() is 1
    @el.empty() if first
    @el

  updateTemplate: (item) ->
    el = @children().forItem(item)
    tb = $('.thumbnail', el)
    
    css = tb.attr('style')
    active = el.hasClass('active')
    hot = el.hasClass('hot')
    
    tmplItem = el.tmplItem()
    tmplItem.data = item
    try
      tmplItem.update()
    catch e
    
    el = @children().forItem(item)
    tb = $('.thumbnail', el)
    
    tb.attr('style', css).addClass('in')
    el.toggleClass('active', active)
    el.toggleClass('hot', hot)
    @el.sortable('destroy').sortable('photos')
    tmplItem
  
  callback: (json) =>
    result = for jsn in json
      ret = for key, val of jsn
        src: val.src
        id: key
      ret[0]
    
    for res in result
      @snap(res)
        
  snap: (res) ->
    el = $('#'+res.id, @el)
    thumb = $('.thumbnail', el)
    img = @createImage()
    img.element = el
    img.thumb = thumb
    img.me = @
    img.res = res
    img.onload = @onLoad
    img.onerror = @onError
    img.src = res.src
    
  onLoad: ->
    @me.log 'image loaded'
    css = 'url(' + @src + ')'
    @thumb.css
      'backgroundImage': css
      'backgroundSize': '100% auto'
    @thumb.addClass('in')
    
  onError: (e) ->
    console.log 'could not load image, trying again'
    @onload = null#@me.snap @res
    @onerror = null
    
  photos: (mode) ->
    if mode is 'add' or !Product.record
      Photo.all()
    else if product = Product.find mode
      product.photos()
    else if Product.record
      Product.record.photos()
    
  exposeSelection: (selection = Product.selectionList()) ->
    @deselect()
    for id in selection
      $('#'+id, @el).addClass("active")
    if first = selection.first()
      $('#'+first, @el).addClass("hot")
      
    @parent.focus()
      
  remove: (ap) ->
    item = Photo.find ap.photo_id
    @findModelElement(item).detach() if item
    
  dropdownToggle: (e) ->
    el = $(e.currentTarget)
    el.dropdown()
    e.preventDefault()
    e.stopPropagation()   
    
  original: (e) ->
    id = $(e.currentTarget).item().id
    Product.selection[0].global.update [id]
    @navigate '/category', '/'
    
    e.preventDefault()
    e.stopPropagation()
    
  deletePhoto: (e) ->
    @log 'deletePhoto'
    item = $(e.currentTarget).item()
    return unless item?.constructor?.className is 'Photo' 
    
    Spine.trigger('destroy:photo', [item.id])
    
    e.stopPropagation()
    e.preventDefault()
    
  zoom: (e) ->
    item = $(e.currentTarget).item()
    @navigate '/category', Category.record?.id or '', Product.record?.id or '', item.id
    
    e.stopPropagation()
    e.preventDefault()
    
  back: (e) ->
    @navigate '/category', Category.record.id or ''
    e.preventDefault()
    e.stopPropagation()
    
  initSelectable: ->
    options =
      helper: 'clone'
    @el.selectable()
    
  addPhotos: (e) ->
    e.stopPropagation()
    e.preventDefault()
    
    Spine.trigger('photos:add')
    
  sliderStart: ->
    @refreshElements()
    
  size: (val, bg='none') ->
    # 2*10 = border radius
    @thumbEl.css
      'height'          : val+'px'
      'width'           : val+'px'
      'backgroundSize'  : bg
      
  rotateCW: (e) ->
    item = $(e.currentTarget).item()
    @log item
    Spine.trigger('rotate', item, -90)
    e.stopPropagation()
    e.preventDefault()
    
  rotateCCW: (e) ->
    item = $(e.currentTarget).item()
    @log item
    Spine.trigger('rotate', item, 90)
    e.stopPropagation()
    e.preventDefault()
    
  rotate: (item, val=90) ->
    if item
     items = [item]
    else
      ids = Product.selectionList()[..]
      items = if ids.length then Photo.toRecords(ids.add(item?.id))
    options = val: val
    
    callback = (items) =>
      products = []
      res = for item in items
        photo = Photo.find item['Photo']['id']
        photo.clearCache()
        albs = photo.products()
        products.add alb.id for alb in albs
        photo
      
      @callDeferred res, @uriSettings(300,300), @proxy @callback
      products = Product.toRecords(products)
      Product.trigger('change:collection', products)
      Photo.trigger('develop', items)
      
    
    $('#'+item.id+'>.thumbnail', @el).removeClass('in') for item in items
    Photo.develop('rotate', options, callback, items)
    false
    
module?.exports = PhotosList