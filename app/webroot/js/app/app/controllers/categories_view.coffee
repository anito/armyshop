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
    'click .item'                     : 'click'
    
    'dragend'                         : 'dragend'
    'dragstart'                       : 'dragstart'
    'drop       '                     : 'drop'
#    'dragover   '                     : 'dragover'
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
    if Category.count()
      items = Category.records.sort Category.sortByOrder
      @list.render items
    else  
      @list.el.html '<label class="invite"><span class="enlightened">This Application has no categories. &nbsp;<button class="opt-CreateCategory blue large">Kategorie</button>'
          
  active: ->
    return unless @isActive()
    unless Category.record
      Category.updateSelection()
    App.showView.trigger('change:toolbarOne', ['Default'])
    App.showView.trigger('change:toolbarTwo', ['Speichern'])
    @render()
    
  click: (e) ->
    item = $(e.currentTarget).item()
    @select(e, item.id) #one category selected at a time
    
  select: (e, ids=[]) ->
    ids = [ids] unless Array.isArray ids
#    list = Root.selectionList()[..]
#    list.addRemove ids
    
#    Root.updateSelection ids
    
    @navigate '/categories', 'cid', ids[0]
    
    e.stopPropagation()
    
  beforeDestroy: (item) ->
    return unless item.isValid()
    @list.findModelElement(item).detach()

  destroy: (item) ->
    if item
      Category.current() if Category.record?.id is item?.id
      item.removeSelectionID()
      Root.removeFromSelection item.id
      
    unless Category.count()
      #force to rerender
      if /^#\/categories\//.test(location.hash)
        @navigate '/categories'
      @navigate '/categories', ''
    else
      unless /^#\/categories\//.test(location.hash)
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
  
module?.exports = CategoriesView