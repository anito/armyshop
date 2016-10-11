Spine           = require("spine")
$               = Spine.$
Controller      = Spine.Controller
Drag            = require('extensions/drag')
User            = require("models/user")
Product           = require('models/product')
Category         = require('models/category')
CategoriesProduct  = require('models/categories_product')
ProductsPhoto     = require('models/products_photo')
Info            = require('controllers/info')
ProductsList      = require('controllers/products_list')
Extender        = require('extensions/controller_extender')
User            = require('models/user')

require('extensions/tmpl')

class ProductsView extends Spine.Controller
  
  @extend Drag
  @extend Extender
  
  elements:
    '.hoverinfo'                      : 'infoEl'
    '.header .hoverinfo'              : 'headerEl'
    '.items'                          : 'itemsEl'
    
  events:
    'click      .item'                : 'click'
    
    'dragstart .item'                 : 'dragstart'
    'dragstart'                       : 'stopInfo'
    'drop .item'                      : 'drop'
    'dragover   .item'                : 'dragover'
    
    'sortupdate .items'               : 'sortupdate'
    'mousemove .item'                 : 'infoUp'
    'mouseleave .item'                : 'infoBye'
    
  productsTemplate: (items, options) ->
    $("#productsTemplate").tmpl items, options
    
#  toolsTemplate: (items) ->
#    $("#toolsTemplate").tmpl items
#
  headerTemplate: (items) ->
    $("#headerProductTemplate").tmpl items
 
  infoTemplate: (item) ->
    $('#productInfoTemplate').tmpl item
 
  constructor: ->
    super
#    @trace = false
    @bind('active', @proxy @active)
    @el.data('current',
      model: Category
      models: Product
    )
    @type = 'Product'
    @info = new Info
      el: @infoEl
      template: @infoTemplate
    @list = new ProductsList
      el: @itemsEl
      template: @productsTemplate
      parent: @
    @header.template = @headerTemplate
    @viewport = @list.el
#      joinTableItems: (query, options) -> Spine.Model['CategoriesProduct'].filter(query, options)

    CategoriesProduct.bind('beforeDestroy', @proxy @beforeDestroyCategoriesProduct)
    CategoriesProduct.bind('destroy', @proxy @destroyCategoriesProduct)
    CategoriesProduct.bind('ignored', @proxy @ignoreProduct)
    
    Product.bind('create', @proxy @create)
    Product.bind('refresh:one', @proxy @refreshOne)
    Product.bind('ajaxError', Product.errorHandler)
    Product.bind('beforeDestroy', @proxy @beforeDestroyProduct)
    Product.bind('destroy', @proxy @destroy)
    Product.bind('create:join', @proxy @createJoin)
    Product.bind('destroy:join', @proxy @destroyJoin)
    Product.bind('change:collection', @proxy @renderBackgrounds)
    
#    CategoriesProduct.bind('ajaxError', Product.errorHandler)
    
    Spine.bind('reorder', @proxy @reorder)
    Spine.bind('create:product', @proxy @createProduct)
    Spine.bind('loading:start', @proxy @loadingStart)
    Spine.bind('loading:done', @proxy @loadingDone)
    Spine.bind('loading:fail', @proxy @loadingFail)
    Spine.bind('destroy:product', @proxy @destroyProduct)
    Spine.bind('select:product', @proxy @select)
    
    @bind('drag:start', @proxy @dragStart)
    @bind('drag:help', @proxy @dragHelp)
    @bind('drag:drop', @proxy @dragDrop)
    
    $(@views).queue('fx')
    
  deactivate: ->
    @el.removeClass('active')
    @
    
  refreshOne: ->
    Product.one('refresh', @proxy @refresh)
    
  refresh: ->
    @updateBuffer()
    @render @buffer, 'html'
    
  updateBuffer: (category=Category.record) ->
    filterOptions =
      model: 'Category'
      key: 'category_id'
      sorted: 'sortByOrder'
    
    if category
      items = Product.filterRelated(category.id, filterOptions)
    else
      items = Product.filter()
    
    @buffer = items
    
  render: (items, mode='html') ->
    return unless @isActive()
    @list.render(items || @updateBuffer(), mode)
    @list.sortable('product') if Category.record
#    $('.tooltips', @el).tooltip(title:'default title')
    delete @buffer
    @el
      
  active: ->
    return unless @isActive()
    App.showView.trigger('change:toolbarOne', ['Default', 'Help'])
    App.showView.trigger('change:toolbarTwo', ['Speichern'])
    
    products = CategoriesProduct.products(Category.record.id)
    for alb in products
      if alb.invalid
        # reset flag for regenerating photo thumbnails in product
        alb.invalid = false
        alb.save(ajax:false)
        
    @refresh()
    @parent.scrollTo(@el.data('current').models.record)
    
  collectionChanged: ->
    unless @isActive()
      @navigate '/category', Category.record?.id or ''
      
  activateRecord: (ids) ->
    unless (ids)
      ids = []
  
    unless Array.isArray(ids)
      ids = [ids]
    
    Product.current ids[0]
  
  activateRecord_: (ids) ->
    unless (ids)
      ids = Category.selectionList()
      Product.current()
      noid = true
      
    unless Array.isArray(ids)
      ids = [ids]
    
    list = []
    for id in ids
      list.push product.id if product = Product.find(id)

    id = list[0]
    
    if id
      Product.current(id) unless noid
      App.sidebar.list.expand(Category.record, true) 
      
    Category.updateSelection(list)
    if Product.record
      Photo.trigger('activate', Product.selectionList())
    else
      Photo.trigger('activate')
      
  newAttributes: ->
    if user_id = User.first()?.id
      title   : @productName()
      subtitle: ''
      notes   : ''
      link    : ''
      author  : User.first().name
      invalid : false
      user_id : user_id
      order   : Product.count()
    else
      User.ping()
  
  productName: (proposal = 'New Product ' + (->
    s = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
    index = if (i = Product.count()+1) < s.length then i else (i % s.length)
    s.split('')[index])()) ->
    Product.each (record) =>
      if record.title is proposal
        return proposal = @productName(proposal + proposal.split(' ')[1][0])
    return proposal
  
  create: (record) -> record.updateSelectionID()
  
  createProduct: (target=Category.record, options={}) ->
    cb = (record, ido) ->
      if target
        record.createJoin(target)
        target.updateSelection(record.id)
      else
        @render([record], 'append')
        Category.updateSelection([record.id], Category.record?.id)
      
      # fill in / remove photos
      $().extend options, product: record
      
      if options.photos
        Photo.trigger('create:join', options, false)
        Photo.trigger('destroy:join', options.photos, options.deleteFromOrigin) if options.deleteFromOrigin
        
      if options.deferred
        options.deferred.notify(record)
      if options.cb
        options.cb.apply(@, [record, options.deferred])
        
      Product.trigger('activate', product.id)
      @navigate '/category', target?.id or ''
    
    product = new Product @newAttributes()
    product.one('ajaxSuccess', @proxy cb)
    product.save()
    product
       
  beforeDestroyCategoriesProduct: (ga) ->
    category = Category.find ga.category_id
    category.removeFromSelection ga.product_id if category
       
  destroyCategoriesProduct: (ga) ->
    products = CategoriesProduct.products ga.category_id
    @render(null, 'html') unless products.length
       
  ignoreProduct: (ga, ignored) ->
    @log 'ignoreProduct'
    ga.ignored = ignored
    ga.save()
  
  destroyProduct: (ids) ->
    @log 'destroyProduct'
  
    @stopInfo()
  
    func = (el) =>
      $(el).detach()
  
    products = ids || Category.selectionList().slice(0)
    products = [products] unless Product.isArray(products)
    
    for id in products
      if item = Product.find(id)
        el = @list.findModelElement(item)
        el.removeClass('in')
      
#      setTimeout(func, 300, el)
    
    if category = Category.record
      @destroyJoin products, Category.record
    else
      for id in products
        product.destroy() if product = Product.find(id)
  
  beforeDestroyProduct: (product) ->
    # remove selection from root
    Category.removeFromSelection null, product.id
    
    # all involved categories
    categories = CategoriesProduct.categories(product.id)

    for category in categories
      category.removeFromSelection product.id
      product.removeSelectionID()
      
#      @list.findModelElement(product).detach()
      
      # remove all associated products
      photos = ProductsPhoto.photos(product.id).toID()
      Photo.trigger('destroy:join', photos, product)
      # remove all associated products
      @destroyJoin product.id, category
   
  destroy: (item) ->
    item.removeSelectionID()
    el = @list.findModelElement(item)
    el.detach()
    @render() unless Product.count()
      
  createJoin: (products, category, callback) ->
    Product.createJoin products, category, callback
    category.updateSelection products
    
  destroyJoin: (products, category) ->
    @log 'destroyJoin'
    return unless category and category.constructor.className is 'Category'
    
    callback = ->
      
    products = [products] unless Product.isArray(products)
    products = products.toID()
    
    Product.destroyJoin products, category, callback
      
  loadingStart: (product) ->
    return unless @isActive()
    return unless product
    el = @itemsEl.children().forItem(product)
    $('.glyphicon-set', el).addClass('in')
    $('.downloading', el).removeClass('hide').addClass('in')
    
  loadingDone: (product) ->
    return unless @isActive()
    return unless product
    el = @itemsEl.children().forItem(product)
    $('.glyphicon-set', el).removeClass('in')
    $('.downloading', el).removeClass('in').addClass('hide')
  
  loadingFail: (product, error) ->
    return unless @isActive()
    err = error.errorThrown
    el = @itemsEl.children().forItem(product)
    $('.glyphicon-set', el).removeClass('in')
    $('.downloading', el).addClass('error').tooltip('destroy').tooltip(title:err).tooltip('show')
    
  renderBackgrounds: (products) ->
    return unless @isActive()
    @list.renderBackgrounds products
    
  sortupdate: (e, o) ->
    return unless Category.record
    
    cb = -> Category.trigger('change:collection', Category.record)
      
    @list.children().each (index) ->
      item = $(@).item()
      if item
        ga = CategoriesProduct.filter(item.id, func: 'selectProduct')[0]
        if ga and parseInt(ga.order) isnt index
          ga.order = index
          ga.save(ajax:false)
          
    Category.record.save(done: cb)
    
  reorder: (category) ->
    if category.id is Category.record.id
      @render()
      
  click: (e, excl) ->
    e.preventDefault()
    #don't propagate to bubble up -edit-trigger
#    e.stopPropagation()
    
    item = $(e.currentTarget).item()
    @select(e, item.id)
    
  select: (e, items = []) ->
    unless Array.isArray items
      items = [items]
      
    type = e.type
    switch type
      when 'keyup'
        selection = items
      when 'click'
        Category.emptySelection() unless @isCtrlClick(e)
        selection = Category.selectionList()[..]
        items = selection[..] unless items.length
        for id in items
          selection.addRemoveSelection(id)
    
    Category.updateSelection(selection, Category.record?.id)
    Product.updateSelection(Product.selectionList(), Product.record?.id)
    
  infoUp: (e) =>
    @info.up(e)
    el = $(e.currentTarget)
    $('.glyphicon-set.fade' , el).addClass('in').removeClass('out')
    
  infoBye: (e) =>
    @info.bye(e)
    el = $(e.currentTarget)
    set = $('.glyphicon-set.fade' , el).addClass('out').removeClass('in')
#    set.children('.open').removeClass('open')
    
  stopInfo: (e) =>
    @info.bye(e)
      
  dropComplete: (e) ->
    @log 'dropComplete'
        
module?.exports = ProductsView