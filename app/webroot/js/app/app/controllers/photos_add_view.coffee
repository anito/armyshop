Spine = require('spine')
$               = Spine.$
Drag            = require('extensions/drag')
User            = require("models/user")
Product           = require('models/product')
Category         = require('models/category')
CategoriesProduct  = require('models/categories_product')
ProductsPhoto     = require('models/products_photo')
Info            = require('controllers/info')
PhotosAddList      = require('controllers/photos_add_list')
User            = require('models/user')
Extender        = require('extensions/controller_extender')

require('extensions/tmpl')

class PhotosAddView extends Spine.Controller

  @extend Extender

  elements:
    '.modal-footer' : 'footer'
    '.items'        : 'itemsEl'

  events:
    'click .item'                               : 'click'
    'click .opt-modalAddExecute:not(.disabled)' : 'add'
    'click .opt-modalSelectInv:not(.disabled)'  : 'selectInv'
    'click .opt-modalSelectAll:not(.disabled)'  : 'selectAll'
    'keyup'                                     : 'keyup'
    
  template: (items) ->
    $('#addTemplate').tmpl
      title: 'Select Photos'
      type: 'photos'
      disabled: true
      contains: !!@items.length
      container: Product.record
      
  subTemplate: (items, options) ->
    $("#photosTemplate").tmpl items, options
    
  footerTemplate: (selection) ->
    $('#footerTemplate').tmpl
      disabled: !selection.length
      contains: !!@items.length
    
  constructor: ->
    super
    @el = $('#modal-view')

    @thumbSize = 100
    @visible = false

    @modal = @el.modal
      show: @visible
      backdrop: true

    @modal.bind('show.bs.modal', @proxy @modalShow)
    @modal.bind('shown.bs.modal', @proxy @modalShown)
    @modal.bind('hide.bs.modal', @proxy @modalHide)
    
    @list = new PhotosAddList
      template: @subTemplate
      parent: @parent
      
    Spine.bind('photos:add', @proxy @show)
    window.test = @
      
  render: (items) ->
    @html @template @items = items
    
    @selectionList = []
    #register events now and only once after the template has rendered
    @eventsDelegated = @delegateEvents(@events) unless @eventsDelegated
    
    @list.el = @itemsEl
    @list.render items
    @el
  
  renderFooter: (list) ->
    @footer.html @footerTemplate list
    
  show: ->
    product = Product.record
    list = ProductsPhoto.photos(product.id).toId()
    records = Photo.filter list, func: 'idExcludeSelect'
    @render(records, product).modal("show")

  hide: ->
    @el.modal('hide')
  
  modalShow: (e) ->
    Spine.trigger('slider:change', @thumbSize)
    @preservedList = Product.selectionList().slice(0)
  
  modalShown: (e) ->
    @log 'shown'
  
  modalHide: (e) ->
    Spine.trigger('slider:change', App.showView.sOutValue)
    
  click: (e) ->
    e.stopPropagation()
    e.preventDefault()
    
    item = $(e.currentTarget).item()
    @select(item.id, !@isMeta(e))
    
  select: (items = [], cumul) ->
    unless Array.isArray items
      items = [items]
      
    if cumul
      list = @selectionList[..]
      for item in items
        list.addRemove(item)
    else list = items[..]
        
    @selectionList = list[..]
    
    @renderFooter list
    @list.exposeSelection(list)
    
  selectAll: (e) ->
    list = @all()
    @select(list)
    e.stopPropagation()
    
  selectInv: (e) ->
    list = @all()
    @select(list, true)
    e.stopPropagation()
    
  all: ->
    root = @itemsEl
    items = root.children('.item')
    
    list = []
    items.each (index, el) ->
      item = $(@).item()
      list.unshift item.id
    list
    
  add: ->
    photos = Photo.toRecords(@selectionList)
    Photo.trigger('create:join', photos, Product.record, @proxy @hide)
    
  keyup: (e) ->
    code = e.charCode or e.keyCode
    
    @log 'PhotosAddView:keyupCode: ' + code
    
    switch code
      when 65 #CTRL A
        if e.metaKey or e.ctrlKey
          @selectAll(e)
          e.stopPropagation()
          e.preventDefault()
      when 73 #CTRL I
        if e.metaKey or e.ctrlKey
          @selectInv(e)
          e.preventDefault()
          e.stopPropagation()
    
module.exports = PhotosAddView