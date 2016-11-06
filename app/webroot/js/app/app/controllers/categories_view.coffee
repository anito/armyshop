Spine         = require("spine")
$             = Spine.$
Drag          = require('extensions/drag')
Root          = require('models/root')
Category       = require('models/category')
CategoriesProduct  = require('models/categories_product')
CategoriesList = require("controllers/categories_list")
ProductsPhoto   = require('models/products_photo')
Extender      = require('extensions/controller_extender')

class CategoriesView extends Spine.Controller
  
  @extend Drag
  @extend Extender
  
  elements:
    '.items'                          : 'items'
    
  events:
    'click'                           : 'clearSelection'
    'click .item'                     : 'click'
    
    'mousemove .item'                 : 'infoUp'
    'mouseleave .item'                : 'infoBye'
    
    'dragend'                         : 'dragend'
    'dragstart'                       : 'dragstart'
    'drop       '                     : 'drop'
    'dragover   '                     : 'dragover'
    'dragenter  '                     : 'dragenter'
    
    'sortupdate'               : 'sortupdate'
    
  headerTemplate: (items) ->
    $("#headerCategoryTemplate").tmpl(items)

  template: (items) ->
    $("#categoriesTemplate").tmpl(items)

  constructor: ->
    super
    @bind('active', @proxy @active)
    
    @list = new CategoriesList
      el: @items
      template: @template
      parent: @
    @header.template = @headerTemplate
    @viewport = @list.el
    
    Category.one('refresh', @proxy @render)
    
    Category.bind('beforeSave', @proxy @createProtected)
    Category.bind('beforeDestroy', @proxy @beforeDestroy)
    Category.bind('destroy', @proxy @destroy)
    Category.bind('refresh:category', @proxy @render)
    
    @bind('drag:start', @proxy @dragStart)
    @bind('drag:enter', @proxy @dragEnter)
    @bind('drag:over', @proxy @dragOver)
    @bind('drag:leave', @proxy @dragLeave)
    @bind('drag:drop', @proxy @dragDrop)

  render: (items) ->
#    return unless @isActive()
    items = Category.records.sort Category.sortByOrder
    @list.render items
          
  active: (items) ->
#    return if @eql Root.record
    
    App.showView.trigger('change:toolbarOne', ['Default'])
    App.showView.trigger('change:toolbarTwo', ['Trustami'])
    
    @render(items)
    
  click: (e) ->
    item = $(e.currentTarget).item()
    @select(e, item.id) #one category selected at a time
    
  select: (e, ids=[]) ->
    ids = [ids] unless Array.isArray ids
#    list = Root.selectionList()[..]
#    list.addRemove ids
    
    @navigate '/category', 'cid', ids[0]
    
    @model.updateSelection ids
    
    e.stopPropagation()
    
  beforeDestroy: (item) ->
    return unless item.isValid()
    @list.findModelElement(item).detach()

  destroy: (item) ->
    if item
      Category.current() if Category.record?.id is item?.id
      item.removeSelectionID()
      Root.removeFromSelection item.id
      
    if Category.count()
      #force to rerender
      unless /^#\/category\//.test(location.hash)
        @navigate '/category', Category.first().id
  
  newAttributes: ->
    if User.first()
      name   : 'New Name'
      user_id : User.first().id
      author: User.first().name
    else
      User.ping()
      
  createProtected: (item) ->
    for key, val of Category.protected
      unless Category.findByAttribute('name', key)
        item.name = key
        item.screenname = val.screenname
        break
      
  sortupdate: (e, o) ->
    cb = =>
      Category.trigger('change:collection', Category.record)
      @render()
      
    @list.children().each (index) ->
      item = $(@).item()
      if item
        if parseInt(item.order) isnt index
          item.order = index
          item.save(done: cb)
  
  infoUp: (e) =>
    el = $(e.currentTarget)
    $('.glyphicon-set.fade' , el).addClass('in').removeClass('out')
    
  infoBye: (e) =>
    el = $(e.currentTarget)
    set = $('.glyphicon-set.fade' , el).addClass('out').removeClass('in')
  
module?.exports = CategoriesView