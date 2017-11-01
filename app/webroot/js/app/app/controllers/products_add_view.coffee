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

  elements:
    '.modal-footer'                          : 'footer'
    '.items'                                 : 'itemsEl'

  events:
    'click'                                       : 'clearSelection'
    'click .item'                                 : 'click'
    'click .opt-modalAddExecute:not(.disabled)'   : 'add'
    'click .opt-modalSelectInv:not(.disabled)'    : 'selectInv'
    'click .opt-modalSelectAll:not(.disabled)'    : 'selectAll'
    'click .close'                                : 'hide'
    'keyup'                                       : 'keyup'

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
    @el = $('#modal-view')

    @visible = false

    modal = @el.modal
      show: @visible
      backdrop: true

    @list = new ProductsAddList
      template: @subTemplate
      parent: @parent
      modal: true
      
    @selectionList = []

    modal.bind('show.bs.modal', @proxy @modalShow)
    modal.bind('hide.bs.modal', @proxy @modalHide)

    Spine.bind('products:add', @proxy @show)
    @bind('selected', @proxy @selected)

  render: (items) ->
    @html @template @items = items
    @delegateEvents(@events)
    @list.el = @itemsEl
    @list.render items
    @el

  renderFooter: (selection) ->
    @footer.html @footerTemplate selection

  show: ->
    list = CategoriesProduct.products(Category.record.id).toId()
    records = window.records = Product.filter list, func: 'idExcludeSelect'
    @render(records).modal('show')

  hide: ->
    @el.modal('hide')
  
  modalShow: (e) ->
    @preservedList = Category.selectionList().slice(0)
    @selectionList = []
  
  modalHide: (e) ->
    
  click: (e) ->
    item = $(e.currentTarget).item()
    @select(e, item.id, true)
    
    e.stopPropagation()
    e.preventDefault()
    
  select__: (ids = [], cumul=true) ->
    ids = [ids] unless Array.isArray ids
      
    if cumul
      list = @selectionList[..]
      for item in items
        list.addRemove(item)
    else list = items[..]
        
    @selectionList = list[..]
    
  selected: (list) ->
    @renderFooter list
    @list.exposeSelection list
      
  add: ->
    products = Product.toRecords(@selectionList)
    Product.trigger('create:join', products, Category.record, @proxy @hide)
    
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