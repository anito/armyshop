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
    'click'                           : 'clearSelection'
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
    
    Spine.bind('refresh:one', @proxy @refreshOne)
    
    Product.bind('create', @proxy @create)
    Product.bind('ajaxError', Product.errorHandler)
#    Product.bind('destroy', @proxy @destroy)
    Product.bind('create:join', @proxy @createJoin)
    Product.bind('destroy:join', @proxy @destroyJoin)
    Product.bind('change:collection', @proxy @renderBackgrounds)
    Product.bind('show:unpublished', @proxy @showUnpublished)
    Product.bind('show:unused', @proxy @showUnused)
    Product.bind('trashed', @proxy @remove)
    
#    CategoriesProduct.bind('ajaxError', Product.errorHandler)
    
    Spine.bind('reorder', @proxy @reorder)
    Spine.bind('create:product', @proxy @createProduct)
    Spine.bind('loading:start', @proxy @loadingStart)
    Spine.bind('loading:done', @proxy @loadingDone)
    Spine.bind('loading:fail', @proxy @loadingFail)
    Spine.bind('delete:products', @proxy @deleteProducts)
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
    
  refreshOne: ->
    Product.one('refresh', @proxy @refresh)
    
  # calls render for joins only
  refresh: () ->
    @render Product.renderBuffer(true)
    
  render: (items, mode='html') ->
#    return unless @isActive()
    
    @list.render(items, mode)
    @list.sortable('product') if Category.record
#    $('.tooltips', @el).tooltip(title:'default title')
    @el
      
  active: (items, options) ->
    b1 = @eql.call(@parent)
    b2 = @eql_()
    return if b1 and b2
    
    App.showView.trigger('change:toolbarOne', ['Default'])
    App.showView.trigger('change:toolbarTwo', ['Trustami'])
    
    @render(items)
    
    @parent.scrollTo(@models.record)
    
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
      favorite: false
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
      else
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
        
      
    unless Category.record
      return App.confirm('NOCAT', null, 'alert')
      
    product = new Product @newAttributes()
    product.one('ajaxSuccess', @proxy cb)
    product.save()
    product
       
  beforeDestroyCategoriesProduct: (ga) ->
    category = Category.find ga.category_id
    category.removeFromSelection ga.product_id if category
    product = Product.find ga.product_id
       
  destroyCategoriesProduct: (ga) ->
#    @remove product
#    func = -> @render(null, 'html')
#    @delay(func, 500) unless products.length
       
  ignoreProduct: (ga, ignored) ->
    @log 'ignoreProduct'
    ga.ignored = ignored
    ga.save()
    
  deleteProducts: (ids, callback) ->
    @log 'deleteProduct'
    # only joins should be here when no Category is selected
    # otherwise (no Category is selected) we should mark the product as deleted
    ids = [ids] unless Array.isArray(ids)
    @stopInfo()
    
    ids = Category.selectionList()[..] #or ids[..]
    products = Product.toRecords(ids)
    for product in products
      if product.deleted
        Product.trigger('destroy:products', ids)
        break
      cats = CategoriesProduct.categories(product.id)
      unless category = Category.record
        # for the Catalogue View
        if cats.length
          #remove from all Categories
          if res1 or (res1 = App.confirm('REMOVE_AND_DELETE', @humanize(products)))
            for cat in cats
              @destroyJoin product, cat
            Product.trigger('inbound:trash', product)
            continue
          else break
        else
          if res2 or (res2 = App.confirm('DELETE', @humanize(products)))
            Product.trigger('inbound:trash', product)
            continue
          else break
      else
        # for the Joins View
        # send the last joined product to trash
        if cats.length is 1
          if res3 or (res3 = App.confirm('DELETE', @humanize(products)))
            @destroyJoin(product, category)
            Product.trigger('inbound:trash', product)
            continue
          else break
        else
          # there are still other identical Products
          # just remove it from the Cat
          if res4 or (res4 = App.confirm('REMOVE', @humanize(products)))
            @destroyJoin(product, category)
            continue
          else break
      
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
          ga.silentUpdate()
          
    Category.record.save(done: cb)
    
  reorder: (category) ->
    if category.id is Category.record.id
      @render(Product.renderBuffer())
      
  click: (e, excl) ->
    item = $(e.currentTarget).item()
    @select(e, item.id)
    
  select: (e, ids = []) ->
    ids = [ids] unless Array.isArray ids
    if (@isMeta(e)) and e.type is 'click'
      list = @model.selectionList()[..]
      list.addRemove(ids)
    else
      list = ids[..]
    
    if list.length
      @navigate '/category', Category.record?.id or '', 'pid', list[0]
    else
      @navigate '/category', Category.record?.id or ''
    
    @model.updateSelection list
    
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