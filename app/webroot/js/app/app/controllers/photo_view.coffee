Spine         = require("spine")
$             = Spine.$
Product         = require('models/product')
ProductsPhoto   = require('models/products_photo')
PhotoList     = require('controllers/photo_list')
Info          = require('controllers/info')
Drag          = require('extensions/drag')
Extender      = require('extensions/controller_extender')

require('extensions/tmpl')

class PhotoView extends Spine.Controller
  
  @extend Drag
  @extend Extender
  
  elements:
    '.hoverinfo'       : 'infoEl'
    '.items'           : 'itemsEl'
    '.item'            : 'item'
  
  events:
    'mousemove  .item'                : 'infoUp'
    'mouseleave .item'                : 'infoBye'
    
    'dragstart  .item'                : 'stopInfo'
    'dragstart .item'                 : 'dragstart'
    'drop .item'                      : 'drop'
    
    'click .dropdown-toggle'          : 'dropdownToggle'
    'click .delete'                   : 'deletePhoto'
    
  template: (item) ->
    $('#photoTemplate').tmpl(item)
    
  infoTemplate: (item) ->
    $('#photoInfoTemplate').tmpl item
    
  constructor: ->
    super
    @currentId = 0
    @bind('active', @proxy @active)
    
    @list = new PhotoList
      el: @itemsEl
      parent: @
    #listen to a different view
    @list.listener = @parent.photosView.list
    @type = 'Photo'
    @info = new Info
      el: @infoEl
      template: @infoTemplate
    @viewport = @itemsEl
    
    Photo.one('refresh', @proxy @refresh)
    Product.bind('change:collection', @proxy @refresh)
    Photo.bind('change:current', @proxy @changeNavigation)
    
  change: (a, b) ->
    changed = !(@currentId is b[0])
    if changed
      @log b[0]
      @currentId = b[0]
      @render Photo.find(b)
    
  changeNavigation: (rec, changed) ->
    return unless @isActive()
    @navigate '/category', Category.record?.id or '', Category.record?.selectionList?().first() or '', rec.id if changed
    
  render: (item=Photo.record) ->
    @itemsEl.html @template item
    $('.dropdown-toggle', @el).dropdown()
    @uri item
    @el
  
  active: ->
#    return unless @isActive()
    App.showView.trigger('change:toolbarOne', ['Default'])
    App.showView.trigger('change:toolbarTwo', ['Trustami'])
    @render()
    
  refresh: ->
    @render()
    
  params: ->
    width: 600
    height: 451
    square: 2
    force: false
    
  uri: (item, mode = 'html') ->
    @log 'uri'
    Photo.uri @params(),
      (xhr, record) => @callback(xhr, item),
      [item]
  
  callback: (json, item) =>
    @log 'callback'
    img = new Image
    img.onload = @imageLoad
    
    searchJSON = (id) ->
      for itm in json
        return itm[id] if itm[id]
        
#    for item in items
    jsn = searchJSON item.id
    if jsn
      img.tmb = $('.thumbnail', @el)
      img.container = @itemsEl.removeClass('in')
      img.src = jsn.src
  
  imageLoad: ->
    tmb = @tmb
    container = @container
    w = @width
    h = @height
    
    if h > w
      @height = '100%'
      @width = 'auto'
    
    img = $(@)
    tmb.html img
    container.addClass('in')
  
  dropdownToggle: (e) ->
    el = $(e.currentTarget)
    el.dropdown('toggle')
    
    e.preventDefault()
    e.stopPropagation()
  
  deletePhoto: (e) ->
    item = $(e.currentTarget).item()
    return unless item?.constructor?.className is 'Photo' 
    
    Spine.trigger('delete:photos', [item.id], @proxy @list.back)
    
    @stopInfo(e)
    
    e.stopPropagation()
    e.preventDefault()
  
  infoUp: (e) =>
    @info.up(e)
    el = $('.glyphicon-set' , $(e.currentTarget)).addClass('in').removeClass('out')
    e.preventDefault()
    
  infoBye: (e) =>
    @info.bye()
    el = $('.glyphicon-set' , $(e.currentTarget)).addClass('out').removeClass('in')
    e.preventDefault()
    
  stopInfo: (e) =>
    @info.bye()
    
module?.exports = PhotoView