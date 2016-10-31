Spine             = require("spine")
$                 = Spine.$
Controller        = Spine.Controller
Drag              = require('extensions/drag')
User              = require("models/user")
Product           = require('models/product')
Category          = require('models/category')
CategoriesProduct = require('models/categories_product')
ProductsPhoto     = require('models/products_photo')
Info              = require('controllers/info')
ProductsList      = require('controllers/products_list')
Extender          = require('extensions/controller_extender')
User              = require('models/user')

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
    
    'dragstart '                      : 'dragstart'
    'dragstart'                       : 'stopInfo'
    'dragend'                         : 'dragend'
    'drop'                            : 'drop'
    'dragover   '                     : 'dragover'
    'dragenter  '                     : 'dragenter'
    
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
    
    @type = 'Product'
    @parentType = 'Category'
    
    @current = Model[@parentType].record
    
    @el.data('current',
      model: Model[@parentType]
      models: Model[@type]
    )
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
    
#    Category.bind('create destroy', @proxy @refresh)
    
    Spine.bind('bindRefresh:one', @proxy @bindRefresh)
    
    Product.bind('create', @proxy @create)
    Product.bind('ajaxError', Product.errorHandler)
#    Product.bind('destroy', @proxy @destroy)
    Product.bind('create:join', @proxy @createJoin)
    Product.bind('destroy:join', @proxy @destroyJoin)
    Product.bind('change:collection', @proxy @renderBackgrounds)
    Product.bind('show:unpublished', @proxy @showUnpublished)
    Product.bind('show:unused', @proxy @showUnused)
    Product.bind('move:toTrash', @proxy @moveToTrash)
    
#    CategoriesProduct.bind('ajaxError', Product.errorHandler)
    
    Spine.bind('reorder', @proxy @reorder)
    Spine.bind('create:product', @proxy @createProduct)
    Spine.bind('loading:start', @proxy @loadingStart)
    Spine.bind('loading:done', @proxy @loadingDone)
    Spine.bind('loading:fail', @proxy @loadingFail)
    Spine.bind('destroy:product', @proxy @destroyProduct)
#    Spine.bind('select:product', @proxy @select)
    
    @bind('drag:start', @proxy @dragStart)
    @bind('drag:enter', @proxy @dragEnter)
    @bind('drag:over', @proxy @dragOver)
    @bind('drag:leave', @proxy @dragLeave)
    @bind('drag:drop', @proxy @dragDrop)
    
    $(@views).queue('fx')
    
  deactivate: ->
    @el.removeClass('active')
    @
    
  bindRefresh: ->
    Product.one('refresh', @proxy @refresh)
    
  # calls render for joins only
  refresh: () ->
    @render @updateBuffer(true)
    
  updateBuffer: (buffer) ->
    filterOptions =
      model: 'Category'
      sort: 'sortByOrder'
      
    if buffer
      if category = Category.record
        # for the Category
        items = Category.products(category.id, filterOptions)
      else
        # for the Catalouge
        items = Product.filter(true)
    
    @buffer = items
    
  render: (items, mode='html') ->
    unless items
      return unless @isActive()
#    @list.wipe(true)
    
    items = (items || @updateBuffer(true))
    @list.render(items, mode)
    @list.sortable('product') if Category.record
#    $('.tooltips', @el).tooltip(title:'default title')
    delete @buffer
    @el
      
  active: (items) ->
    return if @eql Category.record
      
    @current.id = Category.record?.id
    App.showView.trigger('change:toolbarOne', ['Default', 'Help'])
    App.showView.trigger('change:toolbarTwo', ['Speichern'])
    
#    products = CategoriesProduct.products(Category.record.id)
#    @resetInvalid(products)
    
    if items then @render(items) else @refresh()
    
    @parent.scrollTo(@el.data('current').models.record)
    
  # reset flag for regenerating photo thumbnails in product
  resetInvalid: (products) ->
    for alb in products
      if alb.invalid
        alb.invalid = false
        alb.save(ajax:false)
        
  activateRecord: (ids) ->
    unless (ids)
      ids = []
  
    unless Array.isArray(ids)
      ids = [ids]
    
    Product.current ids[0]
  
  showUnpublished: ->
    gas = CategoriesProduct.unpublishedProducts(true)
    items = []
    items.push item for ga in gas when item = Product.find(ga.product_id)
      
    @navigate '/category', ''
    @render items
  
  showUnused: ->
    items = Product.unusedProducts(true)
      
    @navigate '/category', ''
    @render items
  
  newAttributes: ->
    if user_id = User.first()?.id
      title   : @productName()
      subtitle: ''
      notes   : ''
      link    : ''
      author  : User.first().name
      invalid : true
      ignored : true
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
        func = -> target.updateSelection(record.id)
#        target.updateSelection(record.id)
      else
#        @render([record], 'append')
        func = -> Category.updateSelection([record.id], Category.record?.id)
#      
      @navigate('/category', target?.id or '', 'pid', product.id)
      setTimeout(func, 100)
      
#      # fill in / remove photos
      $().extend options, product: record
      
      if options.photos
        Photo.trigger('create:join', options.photos, record, cb)
        cb = =>
          if origin = options.deleteFromOrigin
            Photo.trigger('destroy:join', options.photos, origin) 
        
      if options.deferred
        options.deferred.notify(record)
      if options.cb
        options.cb.apply(@, [record, options.deferred])
    
    product = new Product @newAttributes()
    product.one('ajaxSuccess', @proxy cb)
    product.save()
    product
       
  beforeDestroyCategoriesProduct: (ga) ->
    category = Category.find ga.category_id
    category.removeFromSelection ga.product_id if category
       
  destroyCategoriesProduct: (ga) ->
    products = CategoriesProduct.products ga.category_id
    @remove [products][0]
    func = -> @render(null, 'html')
    @delay(func, 500) unless products.length
       
  ignoreProduct: (ga, ignored) ->
    @log 'ignoreProduct'
    ga.ignored = ignored
    ga.save()
  
  destroyProduct: (ids) ->
    @log 'destroyProduct'
    # only joins should be here when no Category is selected
    # otherwise (no Category is selected) we should mark the product as deleted
    
    @stopInfo()
  
    ids = ids || Category.selectionList().slice(0)
    products = Product.toRecords(ids)
    for product in products
      cats = CategoriesProduct.categories(product.id)
      unless category = Category.record
        # for the Catalogue View
        if cats.length
          #remove from all Categories
          if res = App.confirm('DELETE')
            for cat in cats
              @destroyJoin product, cat
          else break
        unless product.deleted
          # send to the trash
          if res = App.confirm('DELETE')
            Product.trigger('move:toTrash', product)
          else break
        else
          # delete from the trash
          if res = App.confirm('DESTROY')
            Product.trigger('destroy:fromTrash', product)
          else break
      else
        # for the Joins View
#        @destroyJoin product, category
        cats = CategoriesProduct.categories(product.id)
        # send the last joined product to trash
        unless cats.length
          if res = App.confirm('DELETE')
            Product.trigger('move:toTrash', product)
          else break
        else
          # there are identical Product
          if res = App.confirm('REMOVE')
            for cat in cats
              @destroyJoin product, cat
          else break
          
    # remove from view
      @remove product if res
    
  moveToTrash: (product) ->
    product.deleted = true
    product.save()
      
  createJoin: (products, category, callback) ->
    Product.createJoin products, category, callback
    category.updateSelection products.toId()
    
  destroyJoin: (products, category) ->
    @log 'destroyJoin'
    callback = ->
      
    products = [products] unless Product.isArray(products)
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
    cb = -> Category.trigger('change:collection', Category.record)
      
    @list.children().each (index) ->
      item = $(@).item()
      if item and Category.record
        ga = CategoriesProduct.filter(item.id, func: 'selectProduct')[0]
        if ga and parseInt(ga.order) isnt index
          ga.order = index
          ga.save(ajax:false)
          
    Category.record.save(done: cb)
    
  reorder: (category) ->
    if category.id is Category.record.id
      @render()
      
  click: (e, excl) ->
    item = $(e.currentTarget).item()
    @select(e, item.id)
    
  select: (e, ids = []) ->
    list = Category.selectionList()[..]
    ids = [ids] unless Array.isArray ids
    list.addRemove ids
    
    Category.updateSelection ids
    
    if ids.length
      @navigate '/category', Category.record?.id or '', 'pid', ids[0]
    else
      @navigate '/category', Category.record?.id or ''
      
    e.stopPropagation()
    
  infoUp: (e) =>
    @info.up(e)
    el = $(e.currentTarget)
    $('.glyphicon-set.fade' , el).addClass('in').removeClass('out')
    
  infoBye: (e) =>
    @info.bye(e)
    el = $(e.currentTarget)
    set = $('.glyphicon-set.fade' , el).addClass('out').removeClass('in')
    
  stopInfo: (e) =>
    @info.bye(e)
      
  dropComplete: (e) ->
    @log 'dropComplete'
        
module?.exports = ProductsView