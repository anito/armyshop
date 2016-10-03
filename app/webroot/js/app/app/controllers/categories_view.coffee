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
    '.items'                  : 'items'
    
  events:
    'click .item'             : 'click'
    
  headerTemplate: (items) ->
    $("#headerCategoryTemplate").tmpl(items)

  template: (items) ->
    $("#categoriesTemplate").tmpl(items)

  constructor: ->
    super
    @bind('active', @proxy @active)
    @el.data('current',
      model: Root
      models: Category
    )
    @type = 'Category'
    @list = new CategoriesList
      el: @items
      template: @template
      parent: @
    @header.template = @headerTemplate
    @viewport = @list.el
    Category.one('refresh', @proxy @render)
    
    Category.bind('beforeDestroy', @proxy @beforeDestroy)
    Category.bind('destroy', @proxy @destroy)
    Category.bind('refresh:category', @proxy @render)

  render: (items) ->
    return unless @isActive()
    if Category.count()
      items = Category.records.sort Category.nameSort
      @list.render items
    else  
      @list.el.html '<label class="invite"><span class="enlightened">This Application has no categories. &nbsp;<button class="opt-CreateCategory dark large">New Category</button>'
          
  active: ->
    return unless @isActive()
    unless Category.record
      Category.updateSelection()
    App.showView.trigger('change:toolbarOne', ['Default'])
    App.showView.trigger('change:toolbarTwo', ['Speichern'])
    @render()
    
  click: (e) ->
    e.preventDefault()
    e.stopPropagation()
    
    App.showView.trigger('change:toolbarOne', ['Default'])
    item = $(e.currentTarget).item()
    @select(e, item.id) #one category selected at a time
    
  select_: (item) ->
    Category.trigger('activate', item.id)
    
  select__: (ids = [], exclusive) ->
    unless Array.isArray ids
      ids = [ids]
    Root.emptySelection() if exclusive
      
    selection = Root.selectionList()[..]
    for id in ids
      selection.addRemoveSelection(id)
    
    Root.updateSelection(selection)
    Category.updateSelection(Category.selectionList())
    Product.updateSelection(Product.selectionList())
    
  select: (e, items = []) ->
    unless Array.isArray items
      items = [items]
      
    Root.updateSelection(items.first())
    Category.updateSelection(Category.selectionList())
    Product.updateSelection(Product.selectionList())
    
  beforeDestroy: (item) ->
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
  
module?.exports = CategoriesView