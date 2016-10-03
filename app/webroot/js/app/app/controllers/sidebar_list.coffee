Spine           = require("spine")
$               = Spine.$
Root            = require("models/root")
Product           = require('models/product')
Category         = require('models/category')
ProductsPhoto     = require('models/products_photo')
CategoriesProduct  = require('models/categories_product')
Drag            = require('extensions/drag')
Extender        = require('extensions/controller_extender')

require('extensions/tmpl')

class SidebarList extends Spine.Controller

  @extend Drag
  @extend Extender
  
  elements:
    '.gal.item'               : 'item'

  events:
    "click      .item"            : 'click'
    "click      .expander"        : 'clickExpander'

  selectFirst: true
    
  contentTemplate: (items) ->
    $('#sidebarContentTemplate').tmpl(items)
    
  sublistTemplate: (items) ->
    $('#productsSublistTemplate').tmpl(items)
    
  ctaTemplate: (item) ->
    $('#ctaTemplate').tmpl(item)
    
  constructor: ->
    super
    
    Category.bind('change:collection', @proxy @renderCategory)
    CategoriesProduct.bind('update', @proxy @renderFromCategoriesProduct)
    Product.bind('change:collection', @proxy @renderProduct)
    Category.bind('change', @proxy @change)
    Product.bind('create destroy update', @proxy @renderSublists)
    Category.bind('change:selection', @proxy @exposeSublistSelection)
    Category.bind('current', @proxy @exposeSelection)
    Product.bind('current', @proxy @scrollTo)
    Category.bind('current', @proxy @scrollTo)
    
  template: -> arguments[0]
  
  change: (item, mode, e) =>
    @log 'change'
    
    switch mode
      when 'create'
        @current = item
        @create item
        @exposeSelection item
      when 'update'
        @current = item
        @update item
      when 'destroy'
        @current = null
        @destroy item
          
  create: (item) ->
    @append @template item
#    @closeAllOtherSublists item
    @reorder item
  
  update: (item) ->
    @updateTemplate item
    @reorder item
  
  destroy: (item) ->
    @children().forItem(item, true).detach()
  
  render: (items, mode) ->
    @children().addClass('invalid')
    for item in items
      categoryEl = @children().forItem(item)
      unless categoryEl.length
        @append @template item
        @reorder item
      else
        @updateTemplate(item).removeClass('invalid')
      @renderOneSublist item
    @children('.invalid').remove()
    
  reorder: (item) ->
    @log 'reorder'
    id = item.id
    index = (id, list) ->
      for itm, i in list
        return i if itm.id is id
      i
    
    children = @children()
    oldEl = @children().forItem(item)
    idxBeforeSort =  @children().index(oldEl)
    idxAfterSort = index(id, Category.all().sort(Category.nameSort))
    newEl = $(children[idxAfterSort])
    if idxBeforeSort < idxAfterSort
      newEl.after oldEl
    else if idxBeforeSort > idxAfterSort
      newEl.before oldEl
    
  updateSublist: (ga) ->
    category = Category.find ga.category_id
    @renderOneSublist category
    
  renderAllSublist: ->
    @log 'renderAllSublist'
    for gal, index in Category.records
      @renderOneSublist gal
      
  renderSublists: (product) ->
    @log 'renderSublists'
    gas = CategoriesProduct.filter(product.id, key: 'product_id')
    for ga in gas
      @renderOneSublist category if category = Category.find ga['category_id']
      
  renderFromCategoriesProduct: (ga) ->
    @log 'renderFromCategoriesProduct'
    @renderOneSublist category if category = Category.find ga['category_id']
      
  renderOneSublist: (category = Category.record) ->
    @log 'renderOneSublist'
    filterOptions =
      model: 'Category'
      key:'category_id'
      sorted: 'sortByOrder'
      
    products = Product.filterRelated(category.id, filterOptions)
    for product in products
      product.count = ProductsPhoto.filter(product.id, key: 'product_id').length
      product.ignored = !(CategoriesProduct.isActiveProduct(category.id, product.id))
      
    products.push {flash: ' '} unless products.length
    categoryEl = @children().forItem(category)
    categorySublist = $('ul', categoryEl)
    categorySublist.html @sublistTemplate(products)
    categorySublist.sortable('product')
    @exposeSublistSelection(null, category.id)
    
  updateTemplate: (item) ->
    categoryEl = @children().forItem(item)
    categoryContentEl = $('.item-content', categoryEl)
    tmplItem = categoryContentEl.tmplItem()
    tmplItem.data = item
    try
      tmplItem.update()
    catch e
    categoryEl
    
  renderItemFromCategoriesProduct: (ga, mode) ->
    category = Category.find(ga.category_id)
    if category
      @updateTemplate category
      @renderOneSublist category
    
  renderCategory: (item) ->
    @updateTemplate item
    @renderOneSublist item
    
  renderProduct: (item) ->
    gas = CategoriesProduct.filter(item.id, key: 'product_id')
    for ga in gas
      if category = Category.find ga.category_id
        @renderCategory category
    
  renderItemFromProductsPhoto: (ap) ->
    @log 'renderItemFromProductsPhoto'
    gas = CategoriesProduct.filter(ap.product_id, key: 'product_id')
    for ga in gas
      @renderItemFromCategoriesProduct ga
  
  exposeSelection: (item = Category.record) ->
    @children().removeClass('active')
    @children().forItem(item).addClass("active") if item
#    @expand item, true
    @exposeSublistSelection null, item?.id
    
  exposeSublistSelection: (selection = Category.selectionList(), id=Category.record?.id) ->
    @log 'exposeSublistSelection'
    item = Category.find id
    if item
      categoryEl = @children().forItem(item)
      productsEl = categoryEl.find('li')
      productsEl.removeClass('selected active')
#      $('.glyphicon', categoryEl).removeClass('glyphicon-folder-open')
      
      for sel in item.selectionList()
        if product = Product.find(sel)
          productsEl.forItem(product).addClass('selected')

      if activeProduct = Product.find item.selectionList().first()
        activeEl = productsEl.forItem(activeProduct).addClass('active')
#        $('.glyphicon', activeEl).addClass('glyphicon-folder-open')
        
    @refreshElements()

  click: (e) ->
    el = $(e.target).closest('li')
    item = el.item()
    
    switch item.constructor.className
      when 'Category'
#        @expand(item, !(Category.record?.id is item.id) or !@isOpen(el))
        @navigate '/category', item.id
#        @closeAllOtherSublists item
      when 'Product'
        category = $(e.target).closest('li.gal').item()
        @navigate '/category', category.id, item.id
    
  clickExpander: (e) ->
    categoryEl = $(e.target).closest('li.gal')
    isOpen = categoryEl.hasClass('open')
    unless isOpen
      categoryEl.addClass('manual')
    else
      categoryEl.removeClass('manual')
      
    item = categoryEl.item()
    if item
      @expand(item, !isOpen, e)
    
    e.stopPropagation()
    e.preventDefault()
    
  expand: (item, open) ->
    categoryEl = @categoryElFromItem(item)
    expander = $('.expander', categoryEl)
    
    if open
      @openSublist(categoryEl)
    else
      @closeSublist(categoryEl) unless categoryEl.hasClass('manual')
        
  isOpen: (el) ->
    el.hasClass('open')
    
  openSublist: (el) ->
    el.addClass('open')
    
  closeSublist: (el) ->
    el.removeClass('open manual')
    
  closeAllSublists: ->
    for category in Category.all()
      @expand category
  
  closeAllOtherSublists: (item) ->
    for category in Category.all()
      @expand category, item?.id is category.id
  
  categoryElFromItem: (item) ->
    @children().forItem(item)

  close: () ->
    
  show: (e) ->
    App.contentManager.change App.showView
    e.stopPropagation()
    e.preventDefault()
    
  scrollTo: (item) ->
    return unless item and Category.record
    el = @children().forItem(Category.record)
    clsName = item.constructor.className
    switch clsName
      when 'Category'
        queued = true
        ul = $('ul', el)
        # messuring categoryEl w/o sublist
        ul.hide()
        el_ = el[0]
        ohc = el_.offsetHeight if el_
        ul.show()
        speed = 300
      when 'Product'
        queued = false
        ul = $('ul', el)
        el = $('li', ul).forItem(item)
        el_ = el[0]
        ohc = el_.offsetHeight if el_
        speed = 700
      
    return unless el.length
      
    otc = el.offset().top
    stp = @el[0].scrollTop
    otp = @el.offset().top
    ohp = @el[0].offsetHeight  
    
    resMin = stp+otc-otp
    resMax = stp+otc-(otp+ohp-ohc)
    
    outOfRange = stp > resMin or stp < resMax
    
    return unless outOfRange
    
    outOfMinRange = stp > resMin
    outOfMaxRange = stp < resMax
    
    res = if outOfMinRange then resMin else if outOfMaxRange then resMax
    
    @el.animate scrollTop: res,
      queue: queued
      duration: speed
      complete: =>
    
module?.exports = SidebarList