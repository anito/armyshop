Spine               = require("spine")
$                   = Spine.$
Model               = Spine.Model
Controller          = Spine.Controller
Root                = require('models/root')
Category            = require('models/category')
Product             = require('models/product')
Photo               = require('models/photo')
ProductsPhoto       = require('models/products_photo')
ProductsTrash       = require('models/products_trash')
PhotosTrash         = require('models/photos_trash')
CategoriesProduct   = require('models/categories_product')
Clipboard           = require("models/clipboard")
ToolbarView         = require("controllers/toolbar_view")
WaitView            = require("controllers/wait_view")
ProductsView        = require("controllers/products_view")
PhotosHeader        = require('controllers/photos_header')
PhotosView          = require('controllers/photos_view')
PhotoHeader         = require('controllers/photo_header')
PhotoView           = require('controllers/photo_view')
ProductsHeader      = require('controllers/products_header')
ProductsTrashView   = require('controllers/products_trash_view')
ProductsTrashHeader = require('controllers/products_trash_header')
PhotosTrashView     = require('controllers/photos_trash_view')
PhotosTrashHeader   = require('controllers/photos_trash_header')
ProductsAddView     = require('controllers/products_add_view')
PhotosAddView       = require('controllers/photos_add_view')
CategoriesView      = require('controllers/categories_view')
CategoriesHeader    = require('controllers/categories_header')
ModalSimpleView     = require("controllers/modal_simple_view")
Extender            = require('extensions/controller_extender')
Drag                = require('extensions/drag')
MysqlAjax           = require('extensions/mysql_ajax')
require('spine/lib/manager')

class ShowView extends Spine.Controller

  @extend Drag
  @extend Extender
  @extend MysqlAjax

  elements:
    '#fileupload'             : 'uploader'
    '#views .views'           : 'views'
    '.contents'               : 'contents'
    '.items'                  : 'lists'
    '.header .categories'     : 'categoriesHeaderEl'
    '.header .products'       : 'productsHeaderEl'
    '.header .photos'         : 'photosHeaderEl'
    '.header .photo'          : 'photoHeaderEl'
    '.header .photos-trash'   : 'photosTrashHeaderEl'
    '.header .products-trash' : 'productsTrashHeaderEl'
    '.opt-EditCategory'       : 'btnEditCategory'
    '.opt-Category .ui-icon'  : 'btnCategory'
    '.opt-AutoUpload'         : 'btnAutoUpload'
    '.opt-Previous'           : 'btnPrevious'
    '.opt-Sidebar'            : 'btnSidebar'
    '.opt-FullScreen'         : 'btnFullScreen'
    '.opt-Save'               : 'btnSave'
    '.toolbar-one'            : 'toolbarOneEl'
    '.toolbar-two'            : 'toolbarTwoEl'
    '.props'                  : 'propsEl'
    '.content.photos-trash'   : 'photosTrashEl'
    '.content.products-trash' : 'productsTrashEl'
    '.content.categories'     : 'categoriesEl'
    '.content.products'       : 'productsEl'
    '.content.photos'         : 'photosEl'
    '.content.photo'          : 'photoEl'
    '.content.wait'           : 'waitEl'
    '#modal-action'           : 'modalActionEl'
    '#modal-addProduct'       : 'modalAddProductEl'
    '#modal-addPhoto'         : 'modalAddPhotoEl'
    
    '.slider'                 : 'slider'
    '.opt-Product'            : 'btnProduct'
    '.opt-Category'           : 'btnCategory'
    '.opt-Photo'              : 'btnPhoto'
    '.opt-Upload'             : 'btnUpload'
    
  events:
    'click .dropdown-toggle:not(.disabled)'                          : 'dropdown'
    'click a[href]:not(.disabled)'                                   : 'followLink'
    'click .opt-MysqlDump:not(.disabled)'                            : 'mysqlDump'
    'click .opt-MysqlRestore:not(.disabled)'                         : 'mysqlRestore'
    'click .opt-ShowProducts:not(.disabled)'                         : 'showProducts'
    'click .opt-ShowPhotos:not(.disabled)'                           : 'showPhotos'
    'click .opt-ShowPhoto:not(.disabled)'                            : 'showPhoto'
    'click .opt-AutoUpload:not(.disabled)'                           : 'toggleAutoUpload'
    'click .opt-Previous:not(.disabled)'                             : 'back'
    'click .opt-Sidebar:not(.disabled)'                              : 'toggleSidebar'
    'click .opt-FullScreen:not(.disabled)'                           : 'toggleFullScreen'
    'click .opt-CreateCategory:not(.disabled)'                       : 'createCategory'
    'click .opt-CreateProduct:not(.disabled)'                        : 'createProduct'
    'click .opt-DuplicateProducts:not(.disabled)'                    : 'duplicateProducts'
    'click .opt-ToggleVisible:not(.disabled)'                        : 'toggleVisible'
    'click .opt-CopyProductsToNewCategory:not(.disabled)'            : 'copyProductsToNewCategory'
    'click .opt-CopyPhotosToNewProduct:not(.disabled)'               : 'copyPhotosToNewProduct'
    'click .opt-CopyPhoto:not(.disabled)'                            : 'copyPhoto'
    'click .opt-CutPhoto:not(.disabled)'                             : 'cutPhoto'
    'click .opt-PastePhoto:not(.disabled)'                           : 'pastePhoto'
    'click .opt-CopyProduct:not(.disabled)'                          : 'copyProduct'
    'click .opt-CutProduct:not(.disabled)'                           : 'cutProduct'
    'click .opt-PasteProduct:not(.disabled)'                         : 'pasteProduct'
    'click .opt-EmptyProduct:not(.disabled)'                         : 'emptyProduct'
    'click .opt-EmptyPhotosTrash:not(.disabled)'                     : 'emptyPhotosTrash'
    'click .opt-EmptyProductsTrash:not(.disabled)'                   : 'emptyProductsTrash'
    'click .opt-IntroQuatsch:not(.disabled)'                         : 'toggleIntroQuatsch'
    
    'click .opt-CreatePhoto:not(.disabled)'           : 'createPhoto'
    'click .opt-DestroyEmptyProducts:not(.disabled)'  : 'destroyEmptyProducts'
    'click .opt-DeleteCategory:not(.disabled)'        : 'deleteCategory'
    'click .opt-DeleteProduct:not(.disabled)'         : 'deleteProduct'
    'click .opt-DeletePhoto:not(.disabled)'           : 'deletePhoto'
    'click .opt-Category:not(.disabled)'              : 'toggleCategoryShow'
    'click .opt-Rotate-cw:not(.disabled)'             : 'rotatePhotoCW'
    'click .opt-Rotate-ccw:not(.disabled)'            : 'rotatePhotoCCW'
    'click .opt-Product:not(.disabled)'               : 'toggleProductShow'
    'click .opt-Photo:not(.disabled)'                 : 'togglePhotoShow'
    'click .opt-Upload:not(.disabled)'                : 'toggleUploadShow'
    'click .opt-UploadDialogue:not(.disabled)'        : 'uploadDialogue'
    'click .opt-ShowOverview:not(.disabled)'          : 'showOverview'
    'click .opt-ShowCategories:not(.disabled)'        : 'showCategories'
    'click .opt-ShowAllProducts:not(.disabled)'       : 'showProductMasters'
    'click .opt-AddProducts:not(.disabled)'           : 'showProductMastersAdd'
    'click .opt-ShowAllPhotos:not(.disabled)'         : 'showPhotoMasters'
    'click .opt-AddPhotos:not(.disabled)'             : 'showPhotoMastersAdd'
    'click .opt-ActionCancel:not(.disabled)'          : 'cancelAdd'
    'click .opt-ShowPhotoSelection:not(.disabled)'    : 'showPhotoSelection'
    'click .opt-ShowProductSelection:not(.disabled)'  : 'showProductSelection'
    'click .opt-SelectAll:not(.disabled)'             : 'selectAll'
    'click .opt-SelectNone.btn:not(.disabled)'        : 'selectNone'
    'click .opt-SelectNone:not(.btn):not(.disabled)'  : 'deselect'
    'click .opt-SelectInv:not(.disabled)'             : 'selectInv'
    'click .opt-CloseDraghandle:not(.disabled)'       : 'toggleDraghandle'
    'click .opt-Help:not(.disabled)'                  : 'help'
    'click .opt-Version:not(.disabled)'               : 'version'
    'click .opt-Prev:not(.disabled)'                  : 'prev'
    'click .opt-ShowProductsTrash:not(.disabled)'     : 'showProductsTrash'
    'click .opt-ShowPhotosTrash:not(.disabled)'       : 'showPhotosTrash'
    'click .opt-ShowFavorite:not(.disabled)'          : 'showFavorite'
    
    'dblclick .draghandle'                            : 'toggleDraghandle'
    
    'hidden.bs.modal'                                 : 'hiddenmodal'
    
    # you must define dragover yourself in subview !!!!!!important
#    'dragstart .item'                                 : 'dragstart'
#    'dragenter'                                       : 'dragenter'
#    'dragend'                                         : 'dragend'
#    'dragover'                                        : 'dragover'
#    'drop'                                            : 'drop'
    
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
      assocControl: 'opt-Category'
      header: @categoriesHeader
      parent: @
    @productsView = new ProductsView
      el: @productsEl
      header: @productsHeader
      parentModel: Category
      parent: @
    @photosView = new PhotosView
      el: @photosEl
      header: @photosHeader
      parentModel: Product
      parent: @
    @photoView = new PhotoView
      el: @photoEl
      header: @photoHeader
      photosView: @photosView
      parent: @
      parentModel: Photo
    @productsTrashHeader = new ProductsTrashHeader
      el: @productsTrashHeaderEl
    @photosTrashHeader = new PhotosTrashHeader
      el: @photosTrashHeaderEl
    @productsTrashView = new ProductsTrashView
      el: @productsTrashEl
      header: @productsTrashHeader
      parent: @
    @photosTrashView = new PhotosTrashView
      el: @photosTrashEl
      header: @photosTrashHeader
      parent: @
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
    
    @toolbarOne.bind('refresh', @proxy @refreshToolbar)
    
    @bind('awake', @proxy @awake)
    @bind('sleep', @proxy @sleep)
    
    Category.bind('change:current', @proxy @toggleClassAll)
    Product.bind('change:current', @proxy @toggleClassAll)
    Category.bind('change', @proxy @changeToolbarOne)
    Category.bind('change:selection', @proxy @refreshToolbars)
    Product.bind('change:selection', @proxy @refreshToolbars)
    CategoriesProduct.bind('change', @proxy @refreshToolbars)
    ProductsTrash.bind('change:selection', @proxy @refreshToolbars)
    PhotosTrash.bind('change:selection', @proxy @refreshToolbars)
    CategoriesProduct.bind('error', @proxy @error)
    CategoriesProduct.bind('destroy', @proxy @removeJoinedProductElement)
    ProductsPhoto.bind('destroy', @proxy @removeJoinedPhotoElement)
    ProductsPhoto.bind('error', @proxy @error)
    ProductsPhoto.bind('create destroy', @proxy @refreshToolbars)
    Product.bind('change', @proxy @changeToolbarOne)
    Photo.bind('change', @proxy @changeToolbarOne)
    Photo.bind('refresh', @proxy @refreshToolbars)
    Product.bind('current', @proxy @refreshToolbars)
    Spine.bind('products:copy', @proxy @copyProducts)
    Spine.bind('photos:copy', @proxy @copyPhotos)
    Spine.bind('product:ignore', @proxy @ignoreProduct)
    
    @current = @controller = @productsView
    
    @sOutValue = 160 # initial thumb size (slider setting)
    @sliderRatio = 50
    @thumbSize = 240 # size thumbs are created serverside (should be as large as slider max for best quality)
    
    @canvasManager = new Spine.Manager(@categoriesView, @productsView, @photosView, @photoView, @photosTrashView, @productsTrashView)
    @headerManager = new Spine.Manager(@categoriesHeader, @productsHeader, @photosHeader, @photoHeader, @photosTrashHeader, @productsTrashHeader)
    
    @canvasManager.bind('change', @proxy @changeCanvas)
    @headerManager.bind('change', @proxy @changeHeader)
    @trigger('change:toolbarOne')
    
    Category.bind('current', @proxy @scrollTo)
    Product.bind('current', @proxy @scrollTo)
    Photo.bind('current', @proxy @scrollTo)
    
    Model.Settings.bind('change', @proxy @changeSettings)
    Model.Settings.bind('refresh', @proxy @refreshSettings)
    
  dropdown: (e) ->
#    @toolbarOne.renderSub()
    el = $(e.target)
    el.dropdown('toggle')
    e.stopPropagation()
    
  active: (controller, params) ->
    @log 'active'
    # activate subcontroller
    if controller
      controller.trigger('active', params)
      controller.header?.trigger('active')
      @activated(controller).focus()
#    else
#      @focus()
    
  activated: (controller) ->
    p = @previous = @current unless @current.subview
    c = @current = @controller = controller
    @currentHeader = controller.header
    @prevLocation = location.hash
    @el.data('current',
      model: controller.model
      models: controller.models
    )
    @controller
#    return if (@previous is @current) and !@current.isActive()
    # the controller should already be active, however rendering hasn't taken place yet
    
  changeCanvas: (controller, args) ->
    @transform(controller, @previous, @current)
  
  transform: (controller, pContr, cContr) ->
    try
      cm = cContr.model.className
      pm = pContr.model.className
    catch e
#    return if cm is pm
    @controllers = (c for c in @canvasManager.controllers when c isnt controller)
    $('.items', @el).removeClass('in3') for c in @controllers
    fadein = =>
      viewport = controller.viewport or controller.el
      viewport.addClass('in3')
      
    window.setTimeout( =>
      fadein()
    , 500)
    
  resetSelection: (controller) ->
    
  changeHeader: (controller) ->
    
    
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
  
  copyProducts: (products, category) ->
    Product.trigger('create:join', products, category)
      
  copyPhotos: (photos, product) ->
    Photo.trigger('create:join', photos, product)
      
  copyProductsToNewCategory: ->
    @productsToCategory Category.selectionList()[..]
      
  copyPhotosToNewProduct: ->
    @photosToProduct Product.selectionList()[..]
      
  duplicateStart: ->
      
  donecallback: (rec) ->
      
  failcallback: (t) ->
  
  progresscallback: (rec) ->
  
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
      @log 'completed with success ' + a.id
    )
    photos = product.photos().toId()
    @photosToProduct photos, callback
    
  duplicateProduct_new: (id) ->
    return unless product = Product.find(id)
    target = Category.record
    productPhotos = ProductsPhoto.productsPhotos(product.id)
    descr = product.descriptions()
    options = 
      ajax: false
      validate: false
      
    newProduct = product.dup(true, options)
#    descriptions = Description.duplicate(descr, {'product_id': newProduct.id}, options)
    productPhotos = ProductsPhoto.duplicate(productPhotos, {'product_id': newProduct.id}, options)
    Product.createJoin(newProduct, Category.record) if Category.record
    
    newProduct.save()
    Category.record.save() if Category.record
    
    @log newProduct
    
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
        photos = Product.photos(id).toId()
        
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
        photos = Product.photos(id).toId()
        Spine.trigger('create:product', target
          photos: photos
          from:Product.record
        )
    
    if Category.record
      @navigate '/category', target.id
    else
      @showProductMasters()
  
  removeJoinedProductElement: (cp) ->
    @controller.remove item if (item = Product.find(cp.product_id)) and cp.category_id is Category.record.id
    
  removeJoinedPhotoElement: (cp) ->
    @remove item if item = Photo.find(cp.photo_id)
    
  
  emptyProduct: (e) ->
    products = Category.selectionList()
    for aid in products
      if product = Product.find aid
        aps = ProductsPhoto.filter(product.id, associationForeignKey: 'product_id')
        for ap in aps
          ap.destroy()
    
      Product.trigger('change:collection', product)
    
    e.preventDefault()
    
  emptyProductsTrash: ->
    items = Product.filter(true, func: 'selectDeleted')
    Product.trigger('empty:trash', items)
    
  emptyPhotosTrash: ->
    items = Photo.filter(true, func: 'selectDeleted')
    Photo.trigger('empty:trash', items)
    
  editCategory: (e) ->
    Spine.trigger('edit:category')

  editProduct: (e) ->
    Spine.trigger('edit:product')

  destroyEmptyProducts: (e) ->
    products = Product.findEmpties()
    for product in products
      product.destroy()

  deleteSelected: (e) ->
    @log 'deleteSelected'
    models = @controller.models
    @['delete'+models.className]()

  deleteCategory: (e) ->
    return unless id = Category.record?.id
    Spine.trigger('delete:category', id)
  
  deleteProduct: (e) ->
    model = App.showView.current.model
    Spine.trigger('delete:products', model.selectionList())

  deletePhoto: (e) ->
    model = App.showView.current.model
    Spine.trigger('delete:photos', model.selectionList())

  toggleCategoryShow: (e) ->
    @trigger('activate:editview', 'category', e.target)
    e.preventDefault()
    
  toggleProductShow: (e) ->
    @trigger('activate:editview', 'product', e.target)
    @refreshToolbars()
    e.preventDefault()

  togglePhotoShow: (e) ->
    @trigger('activate:editview', 'upload', e.target)
    @refreshToolbars()
    e.preventDefault()

  toggleUploadShow: (e) ->
    @trigger('activate:editview', 'upload', e.target)
    @refreshToolbars()
    e.preventDefault()
    e.stopPropagation()
    
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
    @toggleFullScreen()
    @refreshToolbars()
    
  # Toggle fullscreen mode:
  toggleFullScreen: (activate) ->
  
    root = document.documentElement
    
    if activate or !(isActive = @fullScreenEnabled())
      if(root.webkitRequestFullScreen)
        root.webkitRequestFullScreen(window.Element.ALLOW_KEYBOARD_INPUT)
      else if(root.mozRequestFullScreen)
        root.mozRequestFullScreen()
    else
      (document.webkitCancelFullScreen || document.mozCancelFullScreen || $.noop).apply(document)
      
    @fullScreenEnabled()

  fullScreenEnabled: ->
    !!(window.fullScreen)

  toggleDraghandle: ->
    @animateView()
    
  toggleAutoUpload: (args...) ->
    settings = Model.Settings.loadSettings()
    b = if args.length then args[0] else !settings.autoupload
    active = settings.autoupload = !!b
    @uploader.fileupload('option', 'autoUpload', active)
    settings.save()
    @refreshToolbars()
  
  toggleIntroQuatsch: (e) ->
    settings = Model.Settings.loadSettings()
    b = !settings.intro
    active = settings.intro = !!b
    settings.save()
    @refreshToolbars()
  
  refreshSettings: (records) ->
    @changeSettings settings if settings = Model.Settings.loadSettings()
    @refreshToolbars()
  
  changeSettings: (rec) ->
    active = rec.autoupload
    $('#fileupload').fileupload('option', 'autoUpload', active)
    @refreshToolbars()
  
  isAutoUpload: ->
    $('#fileupload').fileupload('option', 'autoUpload')
  
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
    min = 25
    
    options = $().extend {open: false}, options
    speed = if options.close or options.open then 800 else 700
    
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
    
  deselect: (e) ->
    model = @current.model
    
    if model then model.updateSelection([])
    
  selectNone: (e) ->
    @deselect(e)
    
  selectAll: (e) ->
    try
      list = @all()
      @current.select(e, list)
    catch e
    
  selectInv: (e)->
    try
      list = @all()
      selList = @current.model.selectionList()
      list.addRemove(selList)
      @current.select(e, list)
    catch e
    
  all: ->
    list = []
    root = $('.items', @current.el)
    items = $('.item', root)
    items.each () ->
      list.unshift @id
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
    
  toggleClassAll: (record, classname) ->
    el = $('[data-model-name='+classname+']',  @el)
    b = !Model[classname].record
    el.toggleClass('all', b)
    
  toggleVisible: (e, list = Category.selectionList()) ->
    for id in list
      ga =  CategoriesProduct.productExists id, Category.record?.id
      ga.ignored = !ga.ignored
      ga.save()

  showProductsTrash: ->
    @navigate '/trash/products', ''
    
  showPhotosTrash: ->
    @navigate '/trash/photos', ''
    
  showCategories: ->
    @navigate '/category', cid = if (cid = Category.record?.id) then 'cid/' + cid else null
    
  showProductMasters: ->
    @navigate '/category', ''
    
  showPhotoMasters: ->
    @navigate '/category', '/'
    
  showProducts: (e) ->
    @navigate '/category', cid = Category.record?.id or '', pid = if (pid = Category.record?.selectionList?().first()) then 'pid/' + pid else null
      
    e.preventDefault()
    
  showPhotos: (e) ->
    @navigate '/category', Category.record?.id or '', Category.record?.selectionList?().first() or '', iid = if (iid = Product.record?.selectionList?().first()) then 'iid/' + iid else null
    e.preventDefault()
    
  showPhoto: (e) ->
    @navigate '/category', Category.record?.id or '', Category.record?.selectionList?().first() or '', Product.record?.selectionList?().first() or ''
    e.preventDefault()
    
  showOverview: ->
    @navigate '/overview', ''
    
  showProductMastersAdd: (e) ->
    e.preventDefault()
    Spine.trigger('products:add')
    
  showPhotoMastersAdd: (e) ->
    e.preventDefault()
    Spine.trigger('photos:add')
    
  showProductSelection: ->
    @navigate '/category', Category.record.id or ''
  
  showPhotoSelection: ->
    if Category.record
      @navigate '/category', Category.record.id, Category.selectionList()[0] or ''
    else
      @navigate '/category','', Category.selectionList()[0] or ''
    
  cancelAdd: (e) ->
    @back()
    App.sidebar.filter()
    @el.removeClass('add')
    e.preventDefault()
  
  copy: (e) ->
    #type of copied objects depends on view
    model = @current.models.className
    switch model
      when 'Photo'
        @copyPhoto()
      when 'Product'
        @copyProduct()
  
  cut: (e) ->
    #type of copied objects depends on view
    model = @current.models.className
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
      
    Photo.trigger('create:join', items, product, callback)
      
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
      
    Product.trigger('create:join', items, category, callback)
      
  ignoreProduct: (product, category) ->
    return unless category
    itemId = product.id
    categoryId = category.id
    if ga = CategoriesProduct.productExists(itemId, categoryId)
      newIgnored = !ga.ignored
      if product.favorite and newIgnored
        App.confirm('NO_IGNORE_FOR_FAVORITE', null, 'alert')
        return
      CategoriesProduct.trigger('ignored', ga, newIgnored)
      
  help: (e) ->
    carouselOptions =
      id: 'help-carousel'
      interval: 1000
      slides:
        [
          img: "/img/keyboard.png"
          width: '700px'
        ,
          items: [
              'Abschnitt 1'
              items: [
                'Abschnitt 1.1'
              ]
            ]
        ,
          items: [
              'Abschnitt 2'
              items: [
                'Abschnitt 2.1'
              ]
            ]
        ,
          items: [
              'Abschnitt 3'
              items: [
                'Abschnitt 3.1'
              ]
            ]
        ,
          items: [
              'Abschnitt 4'
              items: [
                'Abschnitt 4.1'
              ]
            ]
        ,
          items: [
              'Abschnitt 5'
              items: [
                'Abschnitt 5.1'
              ]
            ]
        ,
          items: [
              'Abschnitt 6'
              items: [
                'Abschnitt 6.1'
              ]
            ]
        ,
          items: [
              'Abschnitt 7'
              items: [
                'Abschnitt 7.1'
              ]
            ]
        ,
          items: [
              'Abschnitt 1'
            ]
        ]
    
    dialog = new ModalSimpleView
      modalOptions:
        keyboard: true
        show: false
    options =
      small: false
      header: 'TastaturBefehle'
      body: -> require("views/carousel") carouselOptions
      footerButtonText: 'Close'
        
    dialog.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    dialog.el.one('hide.bs.modal', @proxy @hidemodal)
    dialog.el.one('show.bs.modal', @proxy @showmodal)
    dialog.el.one('shown.bs.modal', @proxy @shownmodal)
    
#    @carousel = $('.carousel', @el)
#    @carousel.carousel carouselOptions
        
    dialog.show(options)
    
  version: (e) ->
    dialog = new ModalSimpleView
      modalOptions:
        keyboard: true
        show: false
        
    options =
      small: true
      body: -> require("views/version")
        copyright     : 'Axel Nitzschner'
        spine_version : Spine.version
        app_version   : App.version
        bs_version    : $.fn.tooltip.Constructor.VERSION
      
    dialog.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    dialog.el.one('hide.bs.modal', @proxy @hidemodal)
    dialog.el.one('show.bs.modal', @proxy @showmodal)
    dialog.el.one('shown.bs.modal', @proxy @shownmodal)
    
    dialog.show(options)
    
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
      
  uploadDialogue: (e) ->
    @toggleUploadShow(e)
    $('input','#fu').click()
      
  showFavorite: (e) ->
    return unless url = Product.getFavoriteUrl('admin')
    @navigate url
    @refreshToolbars()
    
    e.preventDefault()
    e.stopPropagation()
      
  selectByKey: (e, direction) ->
    isMeta = e.metaKey or e.ctrlKey or e.shiftKey
    index = null
    lastIndex = null
    list = @controller.list?.listener or @controller.list
    elements = if list then $('.item', list.el) else $()
    return unless elements.length
    
    models = @controller.models
    parent = @controller.model
    record = models.record
    
    activeEl = list.findModelElement(record) or $()
      
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
        selection.addRemove(id)
      else
        first = selection.first()
        selection.addRemove(id)
        selection.addRemove(first)
        selection.addRemove(id)
      list.parent.select e, selection
    else
      list.parent.select e, [id]
        
  scrollTo: (item) ->
    Spine.trigger('scroll', item)
    return unless @controller.isActive() and item
    return unless item.constructor.className is @controller.models.className
    
    try
      # some controller don't have a list
      el = @controller.list.findModelElement(item) or $()
      return unless el.length
      parentEl = el.parent()
    catch e
      return
      
    marginTop = 55
    marginBottom = 10
    
    ohc = el[0].offsetHeight
    otc = el.offset().top
    stp = parentEl[0].scrollTop
    otp = parentEl.offset().top
    ohp = parentEl[0].offsetHeight
    dht = parentEl[0].scrollHeight
    
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
    @controller.list?.zoom?(e) or @controller.zoom?(e)
    
    e.preventDefault()
        
  back: (e) ->
    @controller.list?.back(e) or @controller.back?(e)
  
  prev: (e) ->
    history.back()
    e.preventDefault()
  
  mysqlDump: ->
    options =
      done: (xhr) => setTimeout ->
        Spine.trigger('done:wait')
      , 5000, xhr
      fail: (e) ->
    
#    @waitView.trigger('active',
    Spine.trigger('show:wait',
      small: true
      header: false
      body: 'Datensicherung läuft...'
      footer: false
    )
    @mysql 'dump', options
    
  mysqlRestore: ->
    options =
      done: (xhr) => setTimeout ->
        Spine.trigger('done:wait')
        Spine.trigger('refresh:all')
      , 5000, xhr
      fail: (e) ->
      
    Spine.trigger('show:wait',
      small: true
      header: false
      body: 'Wiederherstellung läuft...'
      footer: false
    )
    @mysql 'restore', options
  
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
          @deleteSelected(e)
          e.preventDefault()
      when 13 #Return
        unless isFormfield
          @zoom(e)
          e.preventDefault()
      when 27 #Esc
        unless isFormfield or App.modal.exists
          @back(e)
          e.preventDefault()
      when 32 #Space
        unless isFormfield
          photos = App.activePhotos()
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