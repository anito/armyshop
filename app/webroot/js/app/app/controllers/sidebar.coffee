Spine          = require("spine")
$              = Spine.$
Category        = require('models/category')
Product          = require('models/product')
Photo          = require('models/photo')
Root           = require('models/root')
CategoriesProduct = require('models/categories_product')
ProductsPhoto    = require('models/products_photo')
User           = require("models/user")
Drag           = require('extensions/drag')
SidebarList    = require('controllers/sidebar_list')
RefreshView    = require('controllers/refresh_view')
Extender       = require('extensions/controller_extender')
SpineDragItem  = require('models/drag_item')

class Sidebar extends Spine.Controller

  @extend Drag
  @extend Extender

  elements:
    'form'                  : 'form'
    'input.search-query'    : 'input'
    '.flickr'               : 'flickr'
    '.items'                : 'items'
    '.inner'                : 'inner'
    '.droppable'            : 'droppable'
    '.expander'             : 'expander'
    '#refresh'              : 'refreshEl'


  events:
    'click .clear-search'       : 'clearSearch'
    'keyup input'               : 'filter'
    'click .opt-CreateProduct'  : 'createProduct'
    'click .opt-CreateCategory' : 'createCategory'
#    'click a[href]'             : 'followLink'
    
    'dblclick .draghandle'      : 'toggleDraghandle'

    'sortupdate .sublist'         : 'sortupdate'
    
    'dragstart  .alb.item'        : 'dragstart'
    'dragover   .gal.item'        : 'dragover' # Chrome only dispatches the drop event if this event is cancelled
    'dragenter  .gal.item'        : 'dragenter'
    'dragenter  .alb.item'        : 'dragenter'
    'dragleave  .gal.item'        : 'dragleave'
    'dragleave  .alb.item'        : 'dragleave'
    'dragend    .gal.item'        : 'dragend'
    'dragend    .alb.item'        : 'dragend'
    'drop       .gal.item'        : 'drop'
    'drop       .alb.item'        : 'drop'

  categoryTemplate: (items) ->
    $("#sidebarTemplate").tmpl(items)
    
  constructor: ->
    super
    @el.width(8)
    @defaultTemplate = @categoryTemplate
    @list = new SidebarList
      el: @items,
      template: @categoryTemplate
      parent: @
    @refreshView = new RefreshView
      el: @refreshEl
      
    Category.one('refresh', @proxy @refresh)
    Category.bind('error', @proxy @error)
    Category.bind('update', @proxy @render)
    Category.bind("ajaxError", Category.errorHandler)
    Category.bind("ajaxSuccess", Category.successHandler)
    
    Spine.bind('refresh:one', @proxy @refreshOne)
    Spine.bind('create:category', @proxy @createCategory)
    Spine.bind('edit:category', @proxy @edit)
    Spine.bind('delete:category', @proxy @deleteCategory)
    
    @bind('drag:timeout', @proxy @expandAfterTimeout)
    @bind('drag:help', @proxy @dragHelp)
    @bind('drag:start', @proxy @dragStart)
    @bind('drag:enter', @proxy @dragEnter)
    @bind('drag:over', @proxy @dragOver)
    @bind('drag:leave', @proxy @dragLeave)
    @bind('drag:drop', @proxy @dragDrop)
    
    @model = @defaultModel = 'Category'
    
  filter: (e, qry) ->
    if qry then @input.val(qry)
    @query = @input.val() || qry
    @render()
  
  refresh: (items) ->
    @render()
    
  refreshOne: ->
    Category.one('refresh', @proxy @refresh)
    
  render: () ->
    @log 'render'
#    items = items.sort Category.sortByOrder
    @products = Product.filter(@query, func: 'searchSelect')
    if @query
      items = []
      for pro in @products
        items.push cat for cat in CategoriesProduct.categories(pro.id)
    else
      items = Category.filter(@query, func: 'searchSelect')
    @list.render items
    @refreshView.render()
  
  newAttributes: ->
    if User.first()
      screenname  : @categoryName()
      author      : User.first().name
      user_id     : User.first().id
    else
      User.ping()
      
  categoryName: (proposal = 'Category ' + (->
    s = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
    index = if (i = Category.count()+1) < s.length then i else (i % s.length)
    s.split('')[index])()) ->
    Category.each (record) =>
      if record.name is proposal
        return proposal = @categoryName(proposal + proposal.split(' ')[1][0])
    return proposal

  createCategory: (options={}) ->
    @log 'createCategory'
    
    cb = (category) ->
      category.updateSelectionID()
      Root.updateSelection([category.id])
      
      if options.products
        Product.trigger('create:join', options.products, category)
        Product.trigger('destroy:join', options.products, options.deleteFromOrigin) if options.deleteFromOrigin
        
#      unless /^#\/categories\//.test(location.hash)
  #      @navigate '/category', category.id
#      else
#        Category.trigger('activate', category.id)
        
    category = new Category @newAttributes()
    category.one('ajaxSuccess', @proxy cb)
    category.save(options)
    
  error: (item, err) ->
    alert err
    
  createProduct: ->
    Spine.trigger('create:product')
    
  deleteCategory: (id) ->
    return unless category = Category.find id
    if category.isValid()
      if App.confirm('DESTROY_CATEGORY', @humanize(category))
        category.destroy() 
    else
      App.confirm('DESTROY_CATEGORY_NOT_ALLOWED', null, 'alert')

  clearSearch: ->
    $(@input).val('')
    @filter()

  edit: ->
    App.categoryEditView.render()
    App.contentManager.change(App.categoryEditView)

  toggleDraghandle: (options) ->
    width = =>
      max = App.vmanager.currentDim
      w =  @el.width()
      if App.vmanager.sleep
        App.vmanager.awake()
        @clb = ->
        max+"px"
      else
        @clb = App.vmanager.goSleep
        '20px'
    
    w = width()
    speed = 700
    @el.animate
      width: w
      speed
      => @clb()
    
  expandAfterTimeout: (e, timer) ->
    clearTimeout timer
    categoryEl = $(e.target).closest('.gal.item')
    item = categoryEl.item()
    return unless item and item.id isnt Spine.dragItem.originModelName.record?.id
    @list.expand(item, true)
    
  sortupdate: (e, o) ->
    list = o.item.parent()
    category = list.parent().item()
    gas = CategoriesProduct.filter(category.id, associationForeignKey: 'category_id')
    list.children().each (index) ->
      product = $(@).item()
      for ga in gas
        if ga.product_id is product.id and parseInt(ga.order) isnt index
          ga.order = index
          ga.silentUpdate()
        
          
    category.save()
    Spine.trigger('reorder', category)
    
module?.exports = Sidebar