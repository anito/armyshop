Spine           = require("spine")
$               = Spine.$
Photo           = require('models/photo')
Product           = require('models/product')
ProductsPhoto     = require('models/products_photo')
ToolbarView     = require("controllers/toolbar_view")
Extender        = require('extensions/controller_extender')
Drag            = require('extensions/drag')

require('extensions/tmpl')

class PhotosList extends Spine.Controller
  
  @extend Drag
  @extend Extender
  
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
    Photo.bind('update', @proxy @update)
    Product.bind('ajaxError', Product.errorHandler)
    Product.bind('change:selection', @proxy @exposeSelection)
    ProductsPhoto.bind('change', @proxy @changeRelated)
    
  changeRelated: (item, mode) ->
#    return unless @parent.isActive()
    return unless Product.record
    return unless Product.record.id is item['product_id']
    return unless photo = Photo.find(item['photo_id'])
    @log 'changeRelated'
    
    switch mode
      when 'create'
        @wipe()
        @append @template photo
        @callDeferred [photo]
        @size(App.showView.sOutValue)
        @el.sortable('destroy').sortable()
        $('.dropdown-toggle', @el).dropdown()
      when 'destroy'
        el = @findModelElement(photo)
        el.detach()
      when 'update'
        @el.sortable('destroy').sortable()
    
    @refreshElements()
    @el
    
  render: (items=[], mode) ->
    @log 'PhotosList::render ' + mode
    
    if items.length
      @wipe()
      @[mode] @template items
      @callDeferred items
      @size(App.showView.sOutValue)
      @exposeSelection()
      $('.dropdown-toggle', @el).dropdown()
    else if mode is 'add'
      @html '<h3 class="invite"><span class="enlightened">Nothing to add.  &nbsp;</span></h3>'
      @append '<h3><label class="invite label label-default"><span class="enlightened">Either no more photos can be added or there is no product selected.</span></label></h3>'
    else 
      if Photo.count()
        @html '<label class="invite">
        <span class="enlightened">No photos here. &nbsp;
        <p>Simply drop your photos to your browser window</p>
        <p>Note: You can also drag existing photos to a sidebars folder</p>
        </span>
        <button class="opt-Upload dark large"><i class="glyphicon glyphicon-upload"></i><span>Upload</span></button>
        <button class="opt-AddPhotos dark large"><span style="font-size: .6em; position: absolute; top: -18px;">import from</span><i class="glyphicon glyphicon-book"></i><span>Library</span></button>
        </label>'
      else
        @html '<label class="invite"><span class="enlightened">No photos here. &nbsp;
        <p>Simply drop your photos to your browser window</p>
        <button class="opt-Upload dark large"><i class="glyphicon glyphicon-upload"></i><span>Upload</span></button>
        </label>'
      
    @el
  
  renderAll: ->
    @log 'renderAll'
    items = Photo.all()
    if items.length
      @html @template items
      @activateRecord()
      @callDeferred  items
      @size(App.showView.sOutValue)
    @el
  
  wipe: ->
    if Product.record
      first = Product.record.count() is 1
    else
      first = Photo.count() is 1
    @el.empty() if first
    @el

  update: (item) ->
    @log 'update'
    
    helper =
      refresh: =>
        el = @children().forItem(item, true)
        tb = $('.thumbnail', el)
        el: el
        tb: tb

    elements = helper.refresh()
    css = elements.tb.attr('style')
    active = elements.el.hasClass('active')
    hot = elements.el.hasClass('hot')
    photoEl = elements.el.tmplItem()
    photoEl.data = item
    try
      photoEl.update()
    catch e
    elements = helper.refresh()
    elements.tb.attr('style', css).addClass('in')
    elements.el.toggleClass('active', active)
    elements.el.toggleClass('hot', hot)
    @el.sortable('destroy').sortable('photos')# if Product.record
    @refreshElements()
  
  thumbSize: (width, height) ->
    width: width or App.showView.thumbSize
    height: height or App.showView.thumbSize
  
  # the actual final rendering method
  uri: (items, mode) ->
    @log 'uri'
    
    Photo.uri @thumbSize(),
      (xhr, record) => @callback(xhr, items),
      items
  
  callDeferred: (items) ->
    @log 'callDeferred'
    $.when(@uriDeferred(items)).done (xhr, rec) =>
      @callback xhr, rec
  
  uriDeferred: (items) ->
    @log 'uriDeferred'
    deferred = $.Deferred()
    
    Photo.uri @thumbSize(),
      (xhr, record) => deferred.resolve(xhr, items)
      items
      
    deferred.promise()
  
  callback: (json, items) =>
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
    img.this = @
    img.res = res
    img.onload = @onLoad
    img.onerror = @onError
    img.src = res.src
    
  onLoad: ->
    css = 'url(' + @src + ')'
    @thumb.css
      'backgroundImage': css
      'backgroundSize': '100% auto'
    @thumb.addClass('in')
    
  onError: (e) ->
    @this.snap @res
    
  photos: (mode) ->
    if mode is 'add' or !Product.record
      Photo.all()
    else if product = Product.find mode
      product.photos()
    else if Product.record
      Product.record.photos()
    
  #  ****** START SLIDESHOW SPECIFICS *****
  
  modalParams: ->
    width: 600
    height: 451
    force: false
    
  loadModal: (items, mode='html') ->
    Photo.uri @modalParams(),
      (xhr, record) => @callbackModal(xhr, items),
      @photos()
  
  callbackModal: (json, items) ->
    @log 'callbackModal'
    searchJSON = (id) ->
      for itm in json
        return itm[id] if itm[id]
        
    for item in items
      jsn = searchJSON item.id
      if jsn
        el = @children().forItem(item)
        a = $('<a></a>').attr
          'data-href'             : jsn.src
          'title'                 : item.title or item.src
          'data-iso'              : item.iso or ''
          'data-captured'         : item.captured or ''
          'data-photo'      : item.photo or ''
          'data-model'            : item.model or ''
          'rel'                   : 'category'
        $('.play', el).append a
        
    
  #  ****** END ***** 
  
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
    if Product.record?.nope# never get here
      index = @thumbEl.index($(e.target).parents('li').find('.thumbnail'))
      options =
        index         : index
        startSlideshow: false
      @slideshow.trigger('play', options)
    else
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
      
      @callDeferred res
      products = Product.toRecords(products)
      Product.trigger('change:collection', products)
      
    
    $('#'+item.id+'>.thumbnail', @el).removeClass('in') for item in items
    Photo.dev('rotate', options, callback, items)
    false
    
module?.exports = PhotosList