Spine = require('spine')
$               = Spine.$
Controller      = Spine.Controller
Drag            = require('extensions/drag')
User            = require("models/user")
Product           = require('models/product')
Category         = require('models/category')
CategoriesProduct  = require('models/categories_product')
ProductsPhoto     = require('models/products_photo')
Info            = require('controllers/info')
ProductsAddList = require('controllers/products_add_list')
User            = require('models/user')
Extender        = require('extensions/controller_extender')

require('extensions/tmpl')

class ProductsAddView extends Spine.Controller

  @extend Extender

  events:
    'click .item'                            : 'click'
    'click .opt-AddExecute:not(.disabled)'   : 'add'
    'click .opt-SelectInv:not(.disabled)'    : 'selectInv'
    'click .opt-SelectAll:not(.disabled)'    : 'selectAll'
    'keyup'                                  : 'keyup'

  template: (items) ->
    $('#addTemplate').tmpl
      title: 'Select products'
      type: 'products'
      disabled: true
      contains: !!items.length
      container: Category.record
    
  subTemplate: (items, options) ->
    $("#productsTemplate").tmpl items, options
    
  footerTemplate: (selection) ->
    $('#footerTemplate').tmpl
      disabled: !selection.length
      contains: !!@items.length
    
  constructor: ->
    super
    
    @visible = false
    
    @modal = @el.modal
      show: @visible
      backdrop: true
    @list = new ProductsAddList
      template: @subTemplate
      parent: @parent
      modal: true
      
    @modal.bind('show.bs.modal', @proxy @modalShow)
    @modal.bind('hide.bs.modal', @proxy @modalHide)
    
    Spine.bind('products:add', @proxy @show)
      
  render: (items) ->
    @html @template @items = items
    @itemsEl = $('.items', @el)
    @list.el = @itemsEl
    @list.render items
  
  renderFooter: (selection) ->
    @footer = $('.modal-footer', @el)
    @footer.html @footerTemplate selection
  
  show: ->
    list = CategoriesProduct.products(Category.record.id).toId()
    records = Product.filter list, func: 'idExcludeSelect'
    @render records
    @el.modal('show')
    
  hide: ->
    @el.modal('hide')
  
  modalShow: (e) ->
    @preservedList = Category.selectionList().slice(0)
    @selectionList = []
  
  modalHide: (e) ->
    
  click: (e) ->
    e.stopPropagation()
    
    item = $(e.currentTarget).item()
    @select(item.id)
    
  select: (items = [], all) ->
    unless Array.isArray items
      items = [items]
    
    @selectionList = [] if all
    
    for item in items
      @selectionList.addRemove(item)
      
    @renderFooter @selectionList
    @list.exposeSelection(@selectionList)
    
  selectAll: (e) ->
    list = @all()
    @select(list, true)
    e.preventDefault()
    e.stopPropagation()
    
  selectInv: (e) ->
    list = @all()
    @select(list)
    e.preventDefault()
    e.stopPropagation()
    
  all: ->
    list = []
    root = @itemsEl
    items = $('.item', root)
    
    items.each (index, el) ->
      item = $(@).item()
      list.unshift item.id
    list
      
  add: ->
    Product.trigger('create:join', Product.toRecords(@selectionList), Category.record)
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
    
module.exports = ProductsAddView