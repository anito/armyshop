Spine                   = require("spine")
$                       = Spine.$
Drag                    = require("extensions/drag")
User                    = require('models/user')
Config                  = require('models/config')
Product                 = require('models/product')
Root                    = require('models/root')
Category                = require('models/category')
Toolbar                 = require("models/toolbar")
Settings                = require('models/admin_settings')
SpineError              = require("models/spine_error")
Clipboard               = require("models/clipboard")
MainView                = require("controllers/main_view")
LoginView               = require("controllers/login_view")
LoaderView              = require("controllers/loader_view")
Sidebar                 = require("controllers/sidebar")
ShowView                = require("controllers/show_view")
ModalSimpleView         = require("controllers/modal_simple_view")
ModalActionView         = require("controllers/modal_action_view")
ToolbarView             = require("controllers/toolbar_view")
LoginView               = require("controllers/login_view")
ProductEditView         = require("controllers/product_edit_view")
PhotoEditView           = require("controllers/photo_edit_view")
UploadEditView          = require("controllers/upload_edit_view")
CategoryEditView        = require("controllers/category_edit_view")
OverviewView            = require('controllers/overview_view')
PreviewView             = require('controllers/preview_view')
MissingView             = require("controllers/missing_view")
Extender                = require('extensions/controller_extender')
SpineDragItem           = require('models/drag_item')

require('spine/lib/route')
require('spine/lib/manager')
require("extensions/manager")

class Main extends Spine.Controller
  
  @extend Drag
  @extend Extender
  
  # Note:
  # this is how to change a toolbar:
  # App.showView.trigger('change:toolbar', 'Product')
  
  elements:
    '#fileupload'         : 'uploader'
    '#preview'            : 'previewEl'
    '#main'               : 'mainEl'
    '#sidebar'            : 'sidebarEl'
    '#show'               : 'showEl'
    '#overview'           : 'overviewEl'
    '#sidebar .flickr'    : 'sidebarFlickrEl'
    '#missing'            : 'missingEl'
    '#ga'                 : 'categoryEl'
    '#al'                 : 'productEl'
    '#ph'                 : 'photoEl'
    '#fu'                 : 'uploadEl'
    '#loader'             : 'loaderEl'
    '#login'              : 'loginEl'
    '#modal-category'     : 'slideshowEl'
    '#show .content'      : 'content'
    '.vdraggable'         : 'vDrag'
    '.hdraggable'         : 'hDrag'
    '.status-symbol img'  : 'statusIcon'
    '.status-text'        : 'statusText'
    '.status-symbol'      : 'statusSymbol'
    
  events:
    'click [class*="-trigger-edit"]' : 'activateEditor'
    'click'               : 'delegateFocus'
    
    'drop'                : 'drop'
    
    'keyup'               : 'key'
    'keydown'             : 'key'

  constructor: ->
    super
    
    @version = "2.0.0"
    
    # default user settings if none found
    @autoupload = true
    
    Spine.DragItem = SpineDragItem.create()
    
#    @ALBUM_SINGLE_MOVE = @createImage('/img/cursor_folder_1.png')
#    @ALBUM_DOUBLE_MOVE = @createImage('/img/cursor_folder_3.png')
#    @IMAGE_SINGLE_MOVE = @createImage('/img/cursor_images_1.png')
#    @IMAGE_DOUBLE_MOVE = @createImage('/img/cursor_images_3.png')
    
    @ignoredHashes = ['slideshow', 'overview', 'preview', 'flickr', 'logout']
    @arr = ['false', 'outdoor', 'defense', 'goodies']
    
    User.bind('pinger', @proxy @validate)
    
    #reset clipboard
    Clipboard.fetch()
    Clipboard.destroyAll()
    
    Settings.one('refresh', @proxy @refreshSettings)
    Settings.one('change', @proxy @changeSettings)
    
    $('#modal-category').bind('hidden', @proxy @hideSlideshow)
    
    @modalView = new ModalSimpleView
#    @modal2ButtonView = new Modal2ButtonView
#      el: @modalEl
    @missingView = new MissingView
      el: @missingEl
    @category = new CategoryEditView
      el: @categoryEl
      externalClass: '.optCategory'
    @product = new ProductEditView
      el: @productEl
      externalClass: '.optProduct'
    @photo = new PhotoEditView
      el: @photoEl
      externalClass: '.optPhoto'
    @upload = new UploadEditView
      el: @uploadEl
      externalClass: '.optUpload'
    @sidebar = new Sidebar
      el: @sidebarEl
      externalClass: '.optSidebar'
    @loginView = new LoginView
      el: @loginEl
    @mainView = new MainView
      el: @mainEl
    @loaderView = new LoaderView
      el: @loaderEl
    @showView = new ShowView
      el: @showEl
      activeControl: 'btnCategory'
      uploader: @upload
      sidebar: @sidebar
      parent: @
    @overviewView = new OverviewView
      el: @overviewEl
    @previewView = new PreviewView
      el: @previewEl
    @slideshowView = @showView.slideshowView

    @vmanager = new Spine.Manager(@sidebar)
    @vmanager.external = @showView.toolbarOne
    @vmanager.initDrag @vDrag,
      initSize: => 400 #@el.width()/3.5
      sleep: true
      disabled: false
      axis: 'x'
      min: -> 8
      tol: -> 50
      max: => @el.width()/2
      goSleep: => @sidebar.inner.hide()
      awake: => @sidebar.inner.show()

    @hmanager = new Spine.Manager(@category, @product, @photo, @upload)
    @hmanager.external = @showView.toolbarOne
    @hmanager.initDrag @hDrag,
      initSize: => @el.height()*0.4
      disabled: false
      axis: 'y'
      min: -> 50
      sleep: true
      max: => @el.height()/1.5
      goSleep: ->
#        controller.el.hide() if controller = @manager.active()
      awake: ->
#        controller.el.show() if controller = @manager.active()
    
    $(window).bind('hashchange', @proxy @storeHash)
    @modal = exists: false
    
    @appManager = new Spine.Manager(@mainView, @loaderView)
    @contentManager = new Spine.Manager(@overviewView, @showView)
    
    @hmanager.bind('awake', => @showView.trigger('awake'))
    @hmanager.bind('sleep', => @showView.trigger('sleep'))
    @hmanager.bind('change', @proxy @changeEditCanvas)
    @appManager.bind('change', @proxy @changeMainCanvas)
    @contentManager.bind('change', @proxy @changeContentCanvas)
    
    Category.bind('current', @proxy @changeBackground)
    
    @bind('canvas', @proxy @canvas)

    @product.trigger('active')
    
    @loaderView.trigger('active')
    
    @initializeFileupload()
    
    @routes
      
      '/category/:gid/:aid/:pid': (params) ->
        Root.updateSelection params.gid or []
        Category.updateSelection params.aid or []
        Product.updateSelection params.pid or []
        @showView.trigger('active', @showView.photoView, params.pid)
      '/category/:gid/:aid': (params) ->
        Root.updateSelection params.gid or []
        Category.updateSelection params.aid or []
        Product.updateSelection()
        @showView.trigger('active', @showView.photosView)
      '/category/:gid': (params) ->
        Root.updateSelection params.gid or []
        Category.updateSelection()
        Product.updateSelection()
        @showView.trigger('active', @showView.productsView)
      '/categories_/*': ->
        @showView.trigger('active', @showView.categoriesView)
      '/overview/*': ->
        @overviewView.trigger('active')
      '/wait/*glob': (params) ->
        @showView.trigger('active', @showView.waitView)
      '/*glob': (params) ->
        @missingView.trigger('active')

    @defaultSettings =
      welcomeScreen: false,
      test: true
    
    @loadToolbars()
    @initLocation()
    
  initLocation: ->
    return unless settings = Settings.findUserSettings()
    if hash = settings.hash then hash else '/home'
    App.navigate(hash, '')

  
  storeHash: ->
    return unless settings = Settings.findUserSettings()
    if hash = location.hash
      if !@ignoredHashes.contains(hash)
        settings.previousHash = hash
      settings.hash = hash
      settings.save()
    
  fullscreen: ->
    Spine.trigger('chromeless', true)
    
  validate: (user, json) ->
    @log 'Pinger done'
    valid = user.sessionid is json.sessionid
    valid = user.id is json.id and valid
    unless valid
      User.logout()
    else
      @loadUserSettings(user.id)
      @delay @setupView, 1000
  
  changeBackground: (cat) ->
    
    arr = @arr
    res = @getData(cat, arr)
    
    for c in arr
      @el.removeClass(c)
    @el.addClass(res)
  
  drop: (e) ->
    @log 'drop'
    
    # prevent ui drops
    unless e.originalEvent.dataTransfer.files.length
      e.stopPropagation()
      e.preventDefault()
      
    # clean up placeholders, jquery-sortable-plugin sometimes leaves alone
    $('.sortable-placeholder').detach()
      
  notify: (text) ->
    @modalView.render
      small: true
      body: -> require("views/notify")
        text: text
    .show()
      
  loadUserSettings: (id) ->
    Settings.fetch()
    
    unless settings = Settings.findByAttribute('user_id', id)
      @notify '<h3>Welcome</h3><br>to<br><h4>HA Lehmann Admin</h4><h2>Beta</h2>'
      
      Settings.create
        user_id   : id
        autoupload: @autoupload
        hash: '#'
        previousHash: '#'
        
  refreshSettings: (records) ->
    if hash = location.hash
      @navigate hash
    else if settings = Settings.findUserSettings()
      @navigate settings.hash
      
    
  changeSettings: (rec) ->
    @navigate rec.hash
    
  setupView: ->
    @log 'setup View'
    Spine.unbind('uri:alldone')
    @mainView.trigger('active')
    @mainView.el.hide()
    @statusSymbol.fadeOut('slow', @proxy @finalizeView)
      
  finalizeView: ->
    @loginView.render()
    @mainView.el.fadeIn(500, @proxy @showIt)
      
  showIt: ->
    unless /^#\/category\//.test(location.hash)
      @navigate '/category', Category.first()?.id
      
  canvas: (controller) ->
    controller.trigger 'active'
    
  changeMainCanvas: (controller) ->
    
  changeContentCanvas: (controller, b) ->
    @controllers = (c for c in @contentManager.controllers when c isnt controller)
    c.el.removeClass('in') for c in @controllers
    
    _1 = => controller.el.addClass('in')
    
    window.setTimeout( =>
      _1()
    , 500)
    
  changeEditCanvas: (controller) ->
  
  initializeFileupload: ->
    @uploader.fileupload
      autoUpload        : true
      singleFileUploads : false
      sequentialUploads : true
      pasteZone         : false
      maxFileSize       : 10000000 #5MB
      maxNumberOfFiles  : 20
      acceptFileTypes   : /(\.|\/)(gif|jpe?g|png)$/i
      getFilesFromResponse: (data) ->
        res = []
        for file in data.files
          res.push file
        res
    
  loadToolbars: ->
    Toolbar.load()

  activePhotos: ->
    model = @showView.current.el.data('current').model
    
    photos = model.activePhotos()
    photos

  activateEditor: (e) ->
    el = $(e.currentTarget)
    test = el.prop('class')
    if /\bgal-trigger*/.test(test)
      @category.trigger('active')
    else if /\balb-trigger*/.test(test)
      @product.trigger('active')
    else if /\bpho-trigger*/.test(test)
      @photo.trigger('active')
      
    e.preventDefault()
    e.stopPropagation()
    
  getData: (s, arr=[]) ->
    test = (s, a) -> 
      matcher = new RegExp(".*"+a+".*", "g");
      found = matcher.test(s);
    for a, i in arr
      return arr[i] if test s, a
    
  key: (e) ->
    code = e.charCode or e.keyCode
    type = e.type
    
    el=$(document.activeElement)
    isFormfield = $().isFormElement(el)
      
    #use this keydown for tabindices to gain focus
    #tabindex elements will then be able to listen for keyup events subscribed in the controller 
    return unless type is 'keydown'
    
    switch code
      when 8 #Backspace
        unless isFormfield
          @delegateFocus(e, @showView)
          e.preventDefault()
      when 9 #Tab
        unless isFormfield
          @sidebar.toggleDraghandle()
          e.preventDefault()
      when 13 #Return
        unless isFormfield
          @delegateFocus(e, @showView)
          e.preventDefault()
      when 27 #Esc
        unless isFormfield
          if @overviewView.isActive()
            @delegateFocus(e, @overviewView)
          else
            @delegateFocus(e, @showView)
          e.preventDefault()
      when 32 #Space
        unless isFormfield
          if @overviewView.isActive()
            @delegateFocus(e, @overviewView)
          else
            @delegateFocus(e, @showView)
          e.preventDefault()
      when 37 #Left
        unless isFormfield
          if @overviewView.isActive()
            @delegateFocus(e, @overviewView)
          else
            @delegateFocus(e, @showView)
          e.preventDefault()
      when 38 #Up
        unless isFormfield
          @delegateFocus(e, @showView)
          e.preventDefault()
      when 39 #Right
        unless isFormfield
          if @overviewView.isActive()
            @delegateFocus(e, @overviewView)
          else
            @delegateFocus(e, @showView)
          e.preventDefault()
      when 40 #Down
        unless isFormfield
          @delegateFocus(e, @showView)
          e.preventDefault()
      when 65 #ctrl A
        unless isFormfield
          @delegateFocus(e, @showView)
          e.preventDefault()
      when 73 #ctrl I
        unless isFormfield
          @delegateFocus(e, @showView)
          e.preventDefault()
      when 77 #ctrl M
        unless isFormfield
          @delegateFocus(e, @showView)
          e.preventDefault()
      when 86 #CTRL V
        if isFormfield
          if e.metaKey or e.ctrlKey
            e.stopPropagation()
          
  delegateFocus: (e, controller = @showView) ->
    el=$(document.activeElement)
    return if $().isFormElement(el)
    controller.focus()
      
module?.exports = Main
