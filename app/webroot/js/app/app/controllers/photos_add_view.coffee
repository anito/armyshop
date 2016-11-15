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
    '.items'        : '_items'

  events:
    'click .item'                            : 'click'
    'click .opt-AddExecute:not(.disabled)'   : 'add'
    'click .opt-SelectInv:not(.disabled)'    : 'selectInv'
    'click .opt-SelectAll:not(.disabled)'    : 'selectAll'
    'keyup'                                  : 'keyup'
    
  template: (items) ->
    $('#addTemplate').tmpl
      title: 'Select photos'
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
      
  render: (items) ->
    @html @template @items = items
    @itemsEl = $('.items', @el)
    @list.el = @itemsEl
    @list.render items
  
  renderFooter: (list) ->
    @footer = $('.modal-footer', @el)
    @footer.html @footerTemplate list
    
  show: ->
    product = Product.record
    list = ProductsPhoto.photos(product.id).toId()
    records = Photo.filter list, func: 'idExcludeSelect'
    @render records, product
    @el.modal('show')
    
  hide: ->
    @el.modal('hide')
  
  modalShow: (e) ->
    Spine.trigger('slider:change', @thumbSize)
    @preservedList = Product.selectionList().slice(0)
    @selectionList = []
  
  modalShown: (e) ->
    @log 'shown'
  
  modalHide: (e) ->
    Spine.trigger('slider:change', App.showView.sOutValue)
    
  click: (e) ->
    e.stopPropagation()
    e.preventDefault()
    
    item = $(e.currentTarget).item()
    @select(item.id, @isMeta(e))
    
  select: (items = [], exclusive) ->
    unless Array.isArray items
      items = [items]
      
    @selectionList = [] if exclusive
    
    for item in items
      @selectionList.addRemove(item)
        
    @renderFooter @selectionList
    @list.exposeSelection(@selectionList)
    
  selectAll: (e) ->
    list = @all()
    @select(list, true)
    e.stopPropagation()
    
  selectInv: (e) ->
    list = @all()
    @select(list)
    e.stopPropagation()
    
  all: ->
    root = @itemsEl
    items = root.children('.item')
    return unless root and items.length
    list = []
    items.each (index, el) ->
      item = $(@).item()
      list.unshift item.id
    list
    
  add: ->
    photos = Photo.toRecords(@selectionList)
    Photo.trigger('create:join', photos, Product.record)
    @hide()
    
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