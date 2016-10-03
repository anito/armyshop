Spine               = require("spine")
$                   = Spine.$
Model               = Spine.Model
Controller          = Spine.Controller
Root                = require('models/root')
Category            = require('models/category')
Product             = require('models/product')
Photo         = require('models/photo')
ProductsPhoto = require('models/products_photo')
CategoriesProduct   = require('models/categories_product')
Clipboard           = require("models/clipboard")
Settings            = require("models/settings")
ToolbarView         = require("controllers/toolbar_view")
WaitView            = require("controllers/wait_view")
ProductsView        = require("controllers/products_view")
PhotosHeader        = require('controllers/photos_header')
PhotosView          = require('controllers/photos_view')
PhotoHeader         = require('controllers/photo_header')
PhotoView           = require('controllers/photo_view')
ProductsHeader      = require('controllers/products_header')
ProductsAddView     = require('controllers/products_add_view')
PhotosAddView       = require('controllers/photos_add_view')
CategoriesView      = require('controllers/categories_view')
CategoriesHeader    = require('controllers/categories_header')
SlideshowView       = require('controllers/slideshow_view')
SlideshowHeader     = require('controllers/slideshow_header')
OverviewHeader      = require('controllers/overview_header')
OverviewView        = require('controllers/overview_view')
ModalSimpleView     = require("controllers/modal_simple_view")
Extender            = require('extensions/controller_extender')
Drag                = require('extensions/drag')
require('spine/lib/manager')

class ShowView extends Spine.Controller

  @extend Drag
  @extend Extender

  elements:
    '#views .views'           : 'views'
    '.contents'               : 'contents'
    '.items'                  : 'lists'
    '.header .categories'     : 'categoriesHeaderEl'
    '.header .products'       : 'productsHeaderEl'
    '.header .photos'         : 'photosHeaderEl'
    '.header .photo'          : 'photoHeaderEl'
    '.header .overview'       : 'overviewHeaderEl'
    '.header .slideshow'      : 'slideshowHeaderEl'
    '.opt-Overview'           : 'btnOverview'
    '.opt-EditCategory'       : 'btnEditCategory'
    '.opt-Category .ui-icon'  : 'btnCategory'
    '.opt-AutoUpload'         : 'btnAutoUpload'
    '.opt-Previous'           : 'btnPrevious'
    '.opt-Sidebar'            : 'btnSidebar'
    '.opt-FullScreen'         : 'btnFullScreen'
    '.opt-SlideshowPlay'      : 'btnSlideshowPlay'
    '.toolbarOne'             : 'toolbarOneEl'
    '.toolbarTwo'             : 'toolbarTwoEl'
    '.props'                  : 'propsEl'
    '.content.categories'     : 'categoriesEl'
    '.content.products'       : 'productsEl'
    '.content.photos'         : 'photosEl'
    '.content.photo'          : 'photoEl'
    '.content.wait'           : 'waitEl'
    '#slideshow'              : 'slideshowEl'
    '#modal-action'           : 'modalActionEl'
    '#modal-addProduct'       : 'modalAddProductEl'
    '#modal-addPhoto'         : 'modalAddPhotoEl'
    '.overview'               : 'overviewEl'
    
    '.slider'                 : 'slider'
    '.opt-Product'            : 'btnProduct'
    '.opt-Category'           : 'btnCategory'
    '.opt-Photo'              : 'btnPhoto'
    '.opt-Upload'             : 'btnUpload'
    
  events:
    'click .opt-AutoUpload:not(.disabled)'            : 'toggleAutoUpload'
    'click .opt-Overview:not(.disabled)'              : 'showOverview'
    'click .opt-Previous:not(.disabled)'              : 'back'
    'click .opt-Sidebar:not(.disabled)'               : 'toggleSidebar'
    'click .opt-FullScreen:not(.disabled)'            : 'toggleFullScreen'
    'click .opt-CreateCategory:not(.disabled)'         : 'createCategory'
    'click .opt-CreateProduct:not(.disabled)'           : 'createProduct'
    'click .opt-DuplicateProducts:not(.disabled)'       : 'duplicateProducts'
    'click .opt-ToggleVisible'                        : 'toggleVisible'
    'click .opt-CopyProductsToNewCategory:not(.disabled)': 'copyProductsToNewCategory'
    'click .opt-CopyPhotosToNewProduct:not(.disabled)'  : 'copyPhotosToNewProduct'
    'click .opt-CopyPhoto'                            : 'copyPhoto'
    'click .opt-CutPhoto'                             : 'cutPhoto'
    'click .opt-PastePhoto'                           : 'pastePhoto'
    'click .opt-CopyProduct'                            : 'copyProduct'
    'click .opt-CutProduct'                             : 'cutProduct'
    'click .opt-PasteProduct'                           : 'pasteProduct'
    'click .opt-EmptyProduct'                           : 'emptyProduct'
    'click .opt-CreatePhoto:not(.disabled)'           : 'createPhoto'
    'click .opt-DestroyEmptyProducts:not(.disabled)'    : 'destroyEmptyProducts'
    'click .opt-DestroyCategory:not(.disabled)'        : 'destroyCategory'
    'click .opt-DestroyProduct:not(.disabled)'          : 'destroyProduct'
    'click .opt-DestroyPhoto:not(.disabled)'          : 'destroyPhoto'
    'click .opt-EditCategory:not(.disabled)'           : 'editCategory' # for the large edit view
    'click .opt-Category:not(.disabled)'               : 'toggleCategoryShow'
    'click .opt-Rotate-cw:not(.disabled)'             : 'rotatePhotoCW'
    'click .opt-Rotate-ccw:not(.disabled)'            : 'rotatePhotoCCW'
    'click .opt-Product:not(.disabled)'                 : 'toggleProductShow'
    'click .opt-Photo:not(.disabled)'                 : 'togglePhotoShow'
    'click .opt-Upload:not(.disabled)'                : 'toggleUploadShow'
    'click .opt-ShowAllProducts:not(.disabled)'         : 'showProductMasters'
    'click .opt-AddProducts:not(.disabled)'             : 'showProductMastersAdd'
    'click .opt-ShowAllPhotos:not(.disabled)'         : 'showPhotoMasters'
    'click .opt-AddPhotos:not(.disabled)'             : 'showPhotoMastersAdd'
    'click .opt-ActionCancel:not(.disabled)'          : 'cancelAdd'
    'click .opt-SlideshowAutoStart:not(.disabled)'    : 'toggleSlideshowAutoStart'
    'click .opt-SlideshowPreview:not(.disabled)'      : 'slideshowPreview'
    'click .opt-SlideshowPhoto:not(.disabled)'        : 'slideshowPhoto'
    'click .opt-SlideshowPlay:not(.disabled)'         : 'slideshowPlay'
    'click .opt-ShowPhotoSelection:not(.disabled)'    : 'showPhotoSelection'
    'click .opt-ShowProductSelection:not(.disabled)'    : 'showProductSelection'
    'click .opt-SelectAll:not(.disabled)'             : 'selectAll'
    'click .opt-SelectNone:not(.disabled)'            : 'selectNone'
    'click .opt-SelectInv:not(.disabled)'             : 'selectInv'
    'click .opt-CloseDraghandle'                      : 'toggleDraghandle'
    'click .opt-Help'                                 : 'help'
    'click .opt-Version'                              : 'version'
    'click .opt-Prev'                                 : 'prev'
    'click [class*="-trigger-edit"]'                  : 'activateEditor'
    
    'dblclick .draghandle'                            : 'toggleDraghandle'
    
    'hidden.bs.modal'                                 : 'hiddenmodal'
    
    # you must define dragover yourself in subview !!!!!!important
    'dragstart .item'                                 : 'dragstart'
    'dragenter .view'                                 : 'dragenter'
    'dragend'                                         : 'dragend'
    'drop'                                            : 'drop'
    
    'keydown'                                         : 'keydown'
    'keyup'                                           : 'keyup'
    
  constructor: ->
    super
    
    @bind('active', @proxy @active)
    @silent = true
    @toolbarOne = new ToolbarView
      el: @toolbarOneEl
    @toolbarTwo = new ToolbarView
      el: @toolbarTwoEl
    @categoriesHeader = new CategoriesHeader
      el: @categoriesHeaderEl
    @productsHeader = new ProductsHeader
      el: @productsHeaderEl
      parent: @
    @photosHeader = new PhotosHeader
      el: @photosHeaderEl
      parent: @
    @photoHeader = new PhotoHeader
      el: @photoHeaderEl
      parent: @
    @categoriesView = new CategoriesView
      el: @categoriesEl
      className: 'items'
      assocControl: 'opt-Category'
      header: @categoriesHeader
      parent: @
    @productsView = new ProductsView
      el: @productsEl
      className: 'items'
      header: @productsHeader
      parentModel: Category
      parent: @
    @photosView = new PhotosView
      el: @photosEl
      className: 'items'
      header: @photosHeader
      parentModel: Product
      parent: @
      slideshow: @slideshowView
    @photoView = new PhotoView
      el: @photoEl
      className: 'items'
      header: @photoHeader
      photosView: @photosView
      parent: @
      parentModel: Photo
    @productsAddView = new ProductsAddView
      el: @modalAddProductEl
      parent: @productsView
    @photosAddView = new PhotosAddView
      el: @modalAddPhotoEl
      parent: @photosView
    @waitView = new WaitView
      el: @waitEl
      parent: @
    
#    @modalHelpView = new ModalSimpleView
#      el: $('#modal-view')
#    
#    @modalVersionView = new ModalSimpleView
#      el: $('#modal-view')
#    
#    @modalNoSlideShowView = new ModalSimpleView
#      el: $('#modal-view')
    
#    @bind('canvas', @proxy @canvas)
    @bind('change:toolbarOne', @proxy @changeToolbarOne)
    @bind('change:toolbarTwo', @proxy @changeToolbarTwo)
    @bind('activate:editview', @proxy @activateEditView)
    
    @bind('drag:start', @proxy @dragStart)
    @bind('drag:enter', @proxy @dragEnter)
    @bind('drag:end', @proxy @dragEnd)
    @bind('drag:drop', @proxy @dragDrop)
    
    @toolbarOne.bind('refresh', @proxy @refreshToolbar)
    
    @bind('awake', @proxy @awake)
    @bind('sleep', @proxy @sleep)
    
    Category.bind('change', @proxy @changeToolbarOne)
    Category.bind('change:selection', @proxy @refreshToolbars)
    Product.bind('change:selection', @proxy @refreshToolbars)
    CategoriesProduct.bind('change', @proxy @refreshToolbars)
    CategoriesProduct.bind('error', @proxy @error)
    ProductsPhoto.bind('error', @proxy @error)
    ProductsPhoto.bind('create destroy', @proxy @refreshToolbars)
    Product.bind('change', @proxy @changeToolbarOne)
    Photo.bind('change', @proxy @changeToolbarOne)
    Photo.bind('refresh', @proxy @refreshToolbars)
    Product.bind('current', @proxy @refreshToolbars)
    Spine.bind('products:copy', @proxy @copyProducts)
    Spine.bind('photos:copy', @proxy @copyPhotos)
#    Spine.bind('deselect', @proxy @deselect)
    
    @current = @controller = @categoriesView
    
    @sOutValue = 160 # initial thumb size (slider setting)
    @sliderRatio = 50
    @thumbSize = 240 # size thumbs are created serverside (should be as large as slider max for best quality)
    
    @canvasManager = new Spine.Manager(@categoriesView, @productsView, @photosView, @photoView)
    @headerManager = new Spine.Manager(@categoriesHeader, @productsHeader, @photosHeader, @photoHeader)
    
    @canvasManager.bind('change', @proxy @changeCanvas)
    @headerManager.bind('change', @proxy @changeHeader)
    @trigger('change:toolbarOne')
    
    Category.bind('change:current', @proxy @scrollTo)
    Product.bind('change:current', @proxy @scrollTo)
    Photo.bind('change:current', @proxy @scrollTo)
    
    Settings.bind('change', @proxy @changeSettings)
    Settings.bind('refresh', @proxy @refreshSettings)
    
  active: (controller, params) ->
    # preactivate controller
    if controller
      controller.trigger('active', params)
      controller.header?.trigger('active')
      @activated(controller)
    @focus()
    
  changeCanvas: (controller, args) ->
    @controllers = (c for c in @canvasManager.controllers when c isnt controller)
    $('.items', @el).removeClass('in3') for c in @controllers
    #remove global selection if we've left from Product Library
#    if @previous?.type is "Product" and !Category.record
#      @resetSelection()
        
    t = switch controller.type
      when "Category"
        true
      when "Product"
        unless Category.record
          true
        else false
      when "Photo"
        unless Product.record
          true
        else false
      else false
        
        
    _1 = =>
      if t
        @contents.addClass('all')
      else
        @contents.removeClass('all')
      _2()
        
    _2 = =>
      viewport = controller.viewport or controller.el
      viewport.addClass('in3')
      
      
    window.setTimeout( =>
      _1()
    , 500)
    
  resetSelection: (controller) ->
#    Category.updateSelection(null)
    
  changeHeader: (controller) ->
    
  activated: (controller) ->
    @previous = @current unless @current.subview
    @current = @controller = controller
    @currentHeader = controller.header
    @prevLocation = location.hash
    @el.data('current',
      model: controller.el.data('current').model
      models: controller.el.data('current').models
    )
    # the controller should already be active, however rendering hasn't taken place yet
    controller.trigger 'active'
    controller.header.trigger 'active'
    controller
    
  changeToolbarOne: (list) ->
    @toolbarOne.change list
    @toolbarTwo.refresh()
    @refreshElements()
    
  changeToolbarTwo: (list) ->
    @toolbarTwo.change list
    @refreshElements()
    
  refreshToolbar: (toolbar, lastControl) ->
    
  refreshToolbars: ->
    @log 'refreshToolbars'
    @toolbarOne.refresh()
    @toolbarTwo.refresh()
    
  renderViewControl: (controller) ->
#    App.hmanager.change(controller)
    App[controller].trigger('active')
  
  createCategory: (e) ->
    Spine.trigger('create:category')
    e.preventDefault()
  
  createPhoto: (e) ->
    Spine.trigger('create:photo')
    e.preventDefault()
  
  createProduct: ->
    Spine.trigger('create:product')
    
    if Category.record
      @navigate '/category', Category.record.id, Product.last()
    else
      @showProductMasters()
  
  copyProducts: (products, category) ->
    Product.trigger('create:join', products, category)
      
  copyPhotos: (photos, product) ->
    options =
      photos: photos
      product: product
    Photo.trigger('create:join', options)
      
  copyProductsToNewCategory: ->
    @productsToCategory Category.selectionList()[..]
      
  copyPhotosToNewProduct: ->
    @photosToProduct Product.selectionList()[..]
      
  duplicateStart: ->
      
  donecallback: (rec) ->
    console.log 'DONE'
      
  failcallback: (t) ->
    console.log 'FAIL'
  
  progresscallback: (rec) ->
    console.log 'PROGRESS'
    console.log @state()
  
  duplicateProducts: ->
    @deferred = $.Deferred()
    $.when(@duplicateProductsDeferred()).then(@donecallback,@failcallback,@progresscallback)
    
      
  duplicateProductsDeferred: ->
    deferred = @deferred or @deferred = $.Deferred()
    list = Category.selectionList()
    for id in list
      @duplicateProduct id
    
    deferred.promise()
    
  duplicateProduct: (id) ->
    return unless product = Product.find(id)
    callback = (a, def) => @deferred.always(->
      console.log 'completed with success ' + a.id
    )
    photos = product.photos().toID()
    @photosToProduct photos, callback
      
  productsToCategory: (products, category) ->
    Spine.trigger('create:category',
      products: products
      category: category
      deleteFromOrigin: false
      relocate: true
    )
  
  photosToProduct: (photos, callback) ->
    target = Category.record
    Spine.trigger('create:product', target,
      photos: photos
      deleteFromOrigin: false
      relocate: true
      deferred: @deferred
      cb: callback
    )
    
  createProductCopy: (products=Category.selectionList(), target=Category.record) ->
    @log 'createProductCopy'
    for id in products
      if Product.find(id)
        photos = Product.photos(id).toID()
        
        Spine.trigger('create:product', target
          photos: photos
        )
        
    if target
      target.updateSelection products
      @navigate '/category', target.id
    else
      @showProductMasters()
      
  createProductMove: (products=Category.selectionList(), target=Category.record) ->
    for id in products
      if Product.find(id)
        photos = Product.photos(id).toID()
        Spine.trigger('create:product', target
          photos: photos
          from:Product.record
        )
    
    if Category.record
      @navigate '/category', target.id
    else
      @showProductMasters()
  
  emptyProduct: (e) ->
    products = Category.selectionList()
    for aid in products
      if product = Product.find aid
        aps = ProductsPhoto.filter(product.id, key: 'product_id')
        for ap in aps
          ap.destroy()
    
      Product.trigger('change:collection', product)
    
    e.preventDefault()
    e.stopPropagation()
    
  editCategory: (e) ->
    Spine.trigger('edit:category')

  editProduct: (e) ->
    Spine.trigger('edit:product')

  destroyEmptyProducts: (e) ->
    products = Product.findEmpties()
    for product in products
      product.destroy()

  destroySelected: (e) ->
    models = @controller.el.data('current').models
    @['destroy'+models.className]()
    e.stopPropagation()

  destroyCategory: (e) ->
    return unless Category.record
    Spine.trigger('destroy:category', Category.record.id)
  
  destroyProduct: (e) ->
    Spine.trigger('destroy:product')

  destroyPhoto: (e) ->
    Spine.trigger('destroy:photo')

  toggleCategoryShow: (e) ->
    @trigger('activate:editview', 'category', e.target)
    e.preventDefault()
    
  toggleProductShow: (e) ->
    @trigger('activate:editview', 'product', e.target)
    @refreshToolbars()
    e.preventDefault()

  togglePhotoShow: (e) ->
    @trigger('activate:editview', 'photo', e.target)
    @refreshToolbars()
    e.preventDefault()

  toggleUploadShow: (e) ->
    @trigger('activate:editview', 'upload', e.target)
    e.preventDefault()
    @refreshToolbars()
    
  activateEditor: (e) ->
    App.activateEditor e
    
  toggleCategory: (e) ->
    @changeToolbarOne ['Category']
    @refreshToolbars()
    e.preventDefault()
    
  toggleProduct: (e) ->
    @changeToolbarOne ['Product']
    @refreshToolbars()
    e.preventDefault()
    
  togglePhoto: (e) ->
    @changeToolbarOne ['Photos', 'Slider']#, App.showView.initSlider
    @refreshToolbars()
    
  toggleUpload: (e) ->
    @changeToolbarOne ['Upload']
    @refreshToolbars()

  toggleSidebar: () ->
    App.sidebar.toggleDraghandle()
    
  toggleFullScreen: () ->
    App.trigger('chromeless')
    @refreshToolbars()
    
  toggleFullScreen: () ->
    @slideshowView.toggleFullScreen()
    @refreshToolbars()
    
  toggleSlideshow: ->
    active = @btnSlideshow.toggleClass('active').hasClass('active')
    @slideshowView.slideshowMode(active)
    @refreshToolbars()

  toggleSlideshowAutoStart: ->
    res = App.slideshow.data('bs.modal').options.toggleAutostart()
    @refreshToolbars()
    res
    
  isAutoplay: ->
    @slideshowView.autoplay
  
  toggleDraghandle: ->
    @animateView()
    
  toggleAutoUpload: ->
#    active = !@isAutoUpload()
#    console.log first = Setting.first()
#    active = !first.autoupload
    @settings = Settings.findUserSettings()
    active = @settings.autoupload = !@settings.autoupload
    $('#fileupload').data('blueimpFileupload').options['autoUpload'] = active
    @settings.save()
    @refreshToolbars()
  
  refreshSettings: (records) ->
    @changeSettings settings if settings = Settings.findUserSettings()
    @refreshToolbars()
  
  changeSettings: (rec) ->
    active = rec.autoupload
    $('#fileupload').data('blueimpFileupload').options['autoUpload'] = active
    @refreshToolbars()
  
  isAutoUpload: ->
    $('#fileupload').data('blueimpFileupload').options['autoUpload']
  
  activateEditView: (controller) ->
    App[controller].trigger('active')
    @openView()
    
  closeView: ->
    return if !App.hmanager.el.hasClass('open')
    @animateView(close: true)
  
  openView: (val='300') ->
    return if App.hmanager.el.hasClass('open')
    @animateView(open: val)
    
  animateView: (options) ->
    min = 20
    
    options = $().extend {open: false}, options
    speed = if options.close or options.open then 600 else 400
    
    if options.open
      App.hmanager.el.removeClass('open')
      App.hmanager.el.addClass('forcedopen')
      
    
    isOpen = ->
      App.hmanager.el.hasClass('open')
    
    height = ->
      h = if !isOpen()# and !options.close
        parseInt(options.open or App.hmanager.currentDim)
      else
        parseInt(min)
      h
    
    @views.animate
      height: height()+'px'
      speed
      (args...) ->
        if $(@).height() is min
          $(@).removeClass('open forcedopen')
        else
          $(@).addClass('open')
    
  awake: -> 
    @views.addClass('open')
  
  sleep: ->
    @animateView()
    
  openPanel: (controller) ->
    return if @views.hasClass('open')
    App[controller].deactivate()
    ui = App.hmanager.externalClass(App[controller])
    ui.click()
    
  closePanel: (controller, target) ->
    App[controller].trigger('active')
    target.click()
    
  selectAll: (e) ->
    try
      list = @select_()
      @current.select(e, list)
    catch e
    
  selectNone: (e) ->
    try
      @current.select(e, [])
    catch e
    
  selectInv: (e)->
    try
      list = @select_()
      selList = @current.el.data('current').model.selectionList()
      list.removeFromList(selList)
      @current.select(e, list)
    catch e
    
  select_: ->
    list = []
    root = @current.itemsEl
    items = $('.item', root)
    unless root and items.length
      return list
    items.each () ->
      list.unshift @.id
    list
    
  uploadProgress: (e, coll) ->
    
  uploadDone: (e, coll) ->
#    @log coll
    
  sliderInValue: (val) ->
    val = val or @sOutValue
    @sInValue=(val/2)-@sliderRatio
    
  sliderOutValue: (value) ->
    val = value || @slider.slider('value')
    @sOutValue=(val+@sliderRatio)*2
    
  initSlider: =>
    inValue = @sliderInValue()
    @refreshElements()
    @slider.slider
      orientation: 'horizonatal'
      value: inValue
      slide: (e, ui) =>
        @sliderSlide ui.value
    
  sliderSlide: (val) =>
    newVal = @sliderOutValue val  
    Spine.trigger('slider:change', newVal)
    newVal
    
  slideshowPlay: (e) =>
    @slideshowView.trigger('play')
    
  slideshowPreview: (e) ->
    @navigate '/slideshow', ''
    
  slideshowPhoto: (e) ->
    if Photo.record
      @slideshowView.trigger('play', {}, [Photo.record])
    
  showOverview: (e) ->
    @navigate '/overview', ''

  toggleVisible: (e, list = Category.selectionList()) ->
    for id in list
      ga =  CategoriesProduct.categoryProductExists id, Category.record?.id
      ga.ignored = !ga.ignored
      ga.save()

  showPhotosTrash: ->
    Photo.inactive()
    
  showProductsTrash: ->
    Product.inactive()

  showProductMasters: ->
    @navigate '/category', ''
    
  showPhotoMasters: ->
    @navigate '/category', '/'
    
  showProductMastersAdd: (e) ->
    e.preventDefault()
    e.stopPropagation()
    Spine.trigger('products:add')
    
  showPhotoMastersAdd: (e) ->
    e.preventDefault()
    e.stopPropagation()
    Spine.trigger('photos:add')
    
  cancelAdd: (e) ->
    @back()
    App.sidebar.filter()
    @el.removeClass('add')
    e.preventDefault()
    
  showPhotoSelection: ->
    if Category.record
      @navigate '/category', Category.record.id, Category.selectionList()[0] or ''
    else
      @navigate '/category','', Category.selectionList()[0] or ''
    
  showProductSelection: ->
    @navigate '/category', Category.record.id or ''
      
  copy: (e) ->
    #type of copied objects depends on view
    model = @current.el.data('current').models.className
    switch model
      when 'Photo'
        @copyPhoto()
      when 'Product'
        @copyProduct()
  
  cut: (e) ->
    #type of copied objects depends on view
    model = @current.el.data('current').models.className
    switch model
      when 'Photo'
        @cutPhoto()
      when 'Product'
        @cutProduct()
  
  paste: (e) ->
    #type of pasted objects depends on clipboard items
    return unless first = Clipboard.first()
    model = first.item.constructor.className
    switch model
      when 'Photo'
        @pastePhoto()
      when 'Product'
        @pasteProduct()
      
  copyPhoto: ->
    Clipboard.deleteAll()
    for id in Product.selectionList()
      Clipboard.create
        item: Photo.find id
        type: 'copy'
        
    @refreshToolbars()
    
  cutPhoto: ->
    Clipboard.deleteAll()
    for id in Product.selectionList()
      Clipboard.create
        item: Photo.find id
        type: 'copy'
        cut: Product.record
        
    @refreshToolbars()
    
  pastePhoto: ->
    return unless product = Product.record
    clipboard = Clipboard.findAllByAttribute('type', 'copy')
    items = []
    for clb in clipboard
      items.push clb.item
      
    callback = =>
      cut = Clipboard.last().cut
      origin = Clipboard.last().origin
      if cut
        Clipboard.destroyAll()
        options =
          photos: items
          product: cut
        Photo.trigger('destroy:join', options)
      @refreshToolbars()
      
    options = 
      photos: items
      product: product
    Photo.trigger('create:join', options, callback)
      
  rotatePhotoCW: (e) ->
    Spine.trigger('rotate', false, -90)
    @refreshToolbars()
    false
      
  rotatePhotoCCW: (e) ->
    Spine.trigger('rotate', false, 90)
    @refreshToolbars()
    false
      
  copyProduct: ->
    Clipboard.deleteAll()
    for item in Category.selectionList()
      Clipboard.create
        item: Product.find item
        type: 'copy'
        
    @refreshToolbars()
    
  cutProduct: ->
    Clipboard.deleteAll()
    for id in Category.selectionList()
      Clipboard.create
        item: Product.find id
        type: 'copy'
        cut: Category.record
        
    @refreshToolbars()
    
  error: (record, err) ->
    alert err
    
  pasteProduct: ->
    return unless category = Category.record
    clipboard = Clipboard.findAllByAttribute('type', 'copy')
    
    callback = =>
      cut = Clipboard.last().cut
      origin = Clipboard.last().origin
      if cut
        Clipboard.deleteAll()
        Product.trigger('destroy:join', items, cut)
      @refreshToolbars()
    
    items = []
    for clb in clipboard
      items.push clb.item
      
    Product.trigger('create:join', items.toID(), category, callback)
      
  help: (e) ->
    carousel_id = 'help-carousel'
    options = interval: 1000
    slides =
      [
        img: "/img/keyboard.png"
        width: '700px'
      ,
        items: [
            'What is Photo Director?',
            'Photo Director is a (experimental) content management tool for your photos',
            'Manage your photo content using different types of sets, such as products and categories',
            'As a result products can than be used to present your content in slideshows'
          ]
      ,
        items: [
            'Upload photos'
            'Select the product you want to upload photos to'
            'If no product is selected, Director will change to the photos library after upload'
            items: [
              'To start uploading your content, you can:'
              'Drag photos from the desktop to your browser, or'
              'Use the appropriate upload menu item'
            ]
            'Director currently supports JPG, JPE, GIF and PNG'
          ]
      ,
        items: [
            'Arrange your content',
            'Host your photo content in products'
            'On the other hand, products are supposed to be hosted in categories'
            'This also gives you the flexibility to reuse identical products in different places (categories)'
          ]
      ,
        items: [
            'Order to your content'
            'After the content is part of a set, it will become sortable'
          ]
      ,
        items: [
            'Interaction',
            items: [
              'Organize your products or photos in sets'
              'Drag your content from your main view to your sidebar or vice versa'
              'You can also quickly reorder products within the sidebar only, without opening another category'
            ]
          ]
      ,
        items: [
            'Navigation'
            items: [
              'You can navigate through objects using arrow keys:',
              'To open the active object (dark blue border) hit Enter',
              'To close it again hit Esc'
            ]
          ]
      ,
        items: [
            'Selecting content',
            items: [
              'You can easily select one or more items. To do this, either...'
              'Select multiple objects using both ctrl-key and arrow key(s), or'
              'Single click multiple objects'
            ]
          ]
      ,
        items: [
            'Clipboard support'
            'You can copy, paste or cut objects just as you would do on a regular PC (by keybord or mouse)'
          ]
      ]
    
    dialog = new ModalSimpleView
      options:
        small: false
        header: 'Quick Help'
        body: -> require("views/carousel")
          slides: slides
          id: carousel_id
        footerButtonText: 'Close'
      modalOptions:
        keyboard: true
        show: false
        
    dialog.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    dialog.el.one('hide.bs.modal', @proxy @hidemodal)
    dialog.el.one('show.bs.modal', @proxy @showmodal)
    dialog.el.one('shown.bs.modal', @proxy @shownmodal)
    
    @carousel = $('.carousel', @el)
    @carousel.carousel options
        
    dialog.render().show()
    
  version: (e) ->
    dialog = new ModalSimpleView
      options:
        small: true
        body: -> require("views/version")
          copyright     : 'Axel Nitzschner'
          spine_version : Spine.version
          app_version   : App.version
          bs_version    : $.fn.tooltip.Constructor.VERSION
      modalOptions:
        keyboard: true
        show: false
      
    dialog.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    dialog.el.one('hide.bs.modal', @proxy @hidemodal)
    dialog.el.one('show.bs.modal', @proxy @showmodal)
    dialog.el.one('shown.bs.modal', @proxy @shownmodal)
    
    dialog.render().show()
    
  noSlideShow: (e) ->
    @log 'noslideshow'
    dialog = new ModalSimpleView
      options:
        small: false
        body: => require("views/no_slideshow")
          copyright           : 'Axel Nitzschner'
          spine_version       : Spine.version
          app_version         : App.version
          noCategory           : !!!Category.record
          selectedProducts      : Category.selectionList(null).length
          noProductsView        : !(!Category.record and @productsView.isActive())
          productsCount         : CategoriesProduct.products(Category.record?.id).length
          photosCount         : CategoriesProduct.photos(Category.record?.id).length
          activeProductsCount   : CategoriesProduct.activeProducts(Category.record?.id).length
          activePhotosCount   : App.activePhotos().length
          bs_version          : $.fn.tooltip.Constructor.VERSION
      modalOptions:
        keyboard: true
        show: false
        
    dialog.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    dialog.el.one('hide.bs.modal', @proxy @hidemodal)
    dialog.el.one('show.bs.modal', @proxy @showmodal)
    dialog.el.one('shown.bs.modal', @proxy @shownmodal)
    
    dialog.render().show()
    
  hidemodal: (e) ->
    @log 'hidemodal'
    
  hiddenmodal: (e) ->
    @log 'hiddenmodal'
    App.modal.exists = false
    
  showmodal: (e) ->
    @log 'showmodal'
    App.modal.exists = true
      
  shownmodal: (e) ->
    @log 'shownmodal'
      
  selectByKey: (e, direction) ->
    @log 'selectByKey'
    isMeta = e.metaKey or e.ctrlKey
    index = null
    lastIndex = null
    list = @controller.list?.listener or @controller.list
    elements = if list then $('.item', list.el) else $()
    models = @controller.el.data('current').models
    parent = @controller.el.data('current').model
    record = models.record
    
    try
      activeEl = list.findModelElement(record) or $()
    catch e
      return
      
    elements.each (idx, el) =>
      lastIndex = idx
      if $(el).is(activeEl)
        index = idx
        
    last    = elements[lastIndex] or false
    unless index?
      prev = next = first = elements[0] or false
    else if isMeta
      active  = elements[index]
      first   = elements[0] or false
      prev    = elements[index-1] or false
      next    = elements[index+1] or false
    else
      first   = elements[0] or false
      prev    = elements[index-1] or elements[index] or false
      next    = elements[index+1] or elements[index] or false
    
    switch direction
      when 'left'
        el = $(prev)
      when 'up'
        el = $(first)
      when 'right'
        el = $(next)
      when 'down'
        el = $(last)
        
        
    id = el.attr('data-id')
    
    if isMeta
      #support for multiple selection
      selection = parent.selectionList()[..]
      unless id in selection
        selection.addRemoveSelection(id)
      else
        first = selection.first()
        selection.addRemoveSelection(id)
        selection.addRemoveSelection(first)
        selection.addRemoveSelection(id)
        
      list.parent.select e, selection
    else
      list.parent.select e, [id]
        
  scrollTo: (item) ->
    return unless @controller.isActive() and item
    return unless item.constructor.className is @controller.el.data('current').models.className
    parentEl = @controller.el
    
    try
      el = @controller.list.findModelElement(item) or $()
      return unless el.length
    catch e
      # some controller don't have a list
      return
      
    marginTop = 55
    marginBottom = 10
    
    ohc = el[0].offsetHeight
    otc = el.offset().top
    stp = parentEl[0].scrollTop
    otp = parentEl.offset().top
    ohp = parentEl[0].offsetHeight  
    
    resMin = stp+otc-(otp+marginTop)
    resMax = stp+otc-(otp+ohp-ohc-marginBottom)
    
    outOfRange = stp > resMin or stp < resMax
    return unless outOfRange
    
    outOfMinRange = stp > resMin
    outOfMaxRange = stp < resMax

    res = if outOfMinRange then resMin else if outOfMaxRange then resMax
    return if Math.abs(res-stp) <= ohc/2
    
    parentEl.animate scrollTop: res,
      queue: false
      duration: 'slow'
      complete: =>
        
  zoom: (e) ->
    controller = @controller
    models = controller.el.data('current').models
    record = models.record
    
    return unless controller.list
    activeEl = controller.list.findModelElement(record)
    $('.zoom', activeEl).click()
    
    e.preventDefault()
    e.stopPropagation()
        
  back: (e) ->
    @controller.list?.back(e) or @controller.back?(e)
  
  prev: (e) ->
    history.back()
    e.preventDefault()
    e.stopPropagation()
  
  keydown: (e) ->
    code = e.charCode or e.keyCode
    
    el=$(document.activeElement)
    isFormfield = $().isFormElement(el)
    
  keyup: (e) ->
    code = e.charCode or e.keyCode
    
    el=$(document.activeElement)
    isFormfield = $().isFormElement(el)
    
    switch code
      when 8 #Backspace
        unless isFormfield
          @destroySelected(e)
          e.preventDefault()
      when 13 #Return
        unless isFormfield
          @zoom(e)
          e.stopPropagation()
          e.preventDefault()
      when 27 #Esc
        unless isFormfield or App.modal.exists
          @back(e)
          e.preventDefault()
      when 32 #Space
        unless isFormfield
          photos = App.activePhotos()
          
          if photos.length
            @slideshowView.play(null, photos)
          else
            @noSlideShow() 
          e.preventDefault()
      when 37 #Left
        unless isFormfield
          @selectByKey(e, 'left')
          e.preventDefault()
      when 38 #Up
        unless isFormfield
          @selectByKey(e, 'up')
          e.preventDefault()
      when 39 #Right
        unless isFormfield
          @selectByKey(e, 'right')
          e.preventDefault()
      when 40 #Down
        unless isFormfield
          @selectByKey(e, 'down')
          e.preventDefault()
      when 65 #CTRL A
        unless isFormfield
          if e.metaKey or e.ctrlKey
            @selectAll(e)
      when 67 #CTRL C
        unless isFormfield
          if e.metaKey or e.ctrlKey
            @copy(e)
      when 73 #CTRL I
        unless isFormfield
          if e.metaKey or e.ctrlKey
            @selectInv(e)
      when 77 #CTRL M
        unless isFormfield
          if e.metaKey or e.ctrlKey
            @toggleVisible(e)
      when 86 #CTRL V
        unless isFormfield
          if e.metaKey or e.ctrlKey
            @paste(e)
      when 88 #CTRL X
        unless isFormfield
          if e.metaKey or e.ctrlKey
            @cut(e)
      when 82 #CTRL R
        unless isFormfield
          if e.metaKey or e.ctrlKey
            Spine.trigger('rotate', false, -90)

module?.exports = ShowView