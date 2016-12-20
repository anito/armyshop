Spine                   = require("spine")
$                       = Spine.$
Model                   = Spine.Model
User                    = require('models/user')
Config                  = require('models/config')
Drag                    = require('extensions/drag')
Product                 = require('models/product')
Root                    = require('models/root')
PhotosTrash             = require('models/photos_trash')
ProductsTrash           = require('models/products_trash')
Category                = require('models/category')
Toolbar                 = require("models/toolbar")
Settings                = require('models/settings')
Flash                   = require("models/flash")
Clipboard               = require("models/clipboard")
ProductsTrash           = require("models/products_trash")
MainView                = require("controllers/main_view")
TrustamiView            = require("controllers/trustami_view")
LoginView               = require("controllers/login_view")
LoaderView              = require("controllers/loader_view")
Sidebar                 = require("controllers/sidebar")
ShowView                = require("controllers/show_view")
ModalSimpleView         = require("controllers/modal_simple_view")
ModalActionView         = require("controllers/modal_action_view")
ToolbarView             = require("controllers/toolbar_view")
LoginView               = require("controllers/login_view")
ProductEditView         = require("controllers/product_edit_view")
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
    '#fu'                 : 'uploadEl'
    '#loader'             : 'loaderEl'
    '#login'              : 'loginEl'
    '#modal-category'     : 'slideshowEl'
    '#show .content'      : 'content'
    '.vdraggable'         : 'vDrag'
    '.hdraggable'         : 'hDrag'
    '.vdivide'            : 'vDragHandle'
    '.hdivide'            : 'hDragHandle'
    '.status-symbol img'  : 'statusIcon'
    '.status-text'        : 'statusText'
    '.status-symbol'      : 'statusSymbol'
    '.toolbar-three'       : 'trustamiEl'
    
  events:
    'click [class*="-trigger-edit"]' : 'activateEditor'
    'click'               : 'delegateFocus'
    
#    'drop'                : 'drop'
    
    'keyup'               : 'key'
    'keydown'             : 'key'

  constructor: ->
    super
    
    @version = "2.0.0"
    @autoupload = true
    @useDragImage = false
    @intro = true
    @sidebarInitWidth = 430
    
    Spine.dragItem = SpineDragItem.create()
    
    @CONFIRM =  
      'REMOVE': (options) ->
        if options.plural then '\nSollen ' + options.type + ' ' + $().brace(options.length) + ' wirklich entfernt werden?\n\n' else '\nSoll ' + options.type + ' "' + options.name + '" wirklich entfernt werden?\n\n'
      'DELETE': (options) ->
        if options.plural then '\nSollen ' + options.type + ' ' + $().brace(options.length) + ' in den Papierkorb verschoben werden?\n\n' else '\nSoll ' + options.type + ' "' + options.name + '" in den Papierkorb verschoben werden?\n\n'
      'DESTROY': (options) ->
        if options.plural then '\nSollen ' + options.type + ' ' + $().brace(options.length) + ' endgültig gelöscht werden?\n\n' else '\nSoll ' + options.type + ' "' + options.name + '" endgültig gelöscht werden?\n\n'
      'REMOVE_AND_DELETE': (options) ->
        if options.plural then '\nSollen ' + options.type + ' ' + $().brace(options.length) + ' entfernt und in den Papierkorb verschoben werden?\n\n' else '\nSoll ' + options.type + ' "' + options.name + '" entfernt und in den Papierkorb verschoben werden?\n\n'
      'NOCAT': (options) ->
        '\nKeine Kategorie ausgwählt.\n\n'
      'EMPTYTRASH': (options) ->
        '\nSoll der Papierkorb geleert werden?\n\n'
      'DESTROY_CATEGORY': (options) ->
        '\nSoll die Kategorie "' + options.name + '" entfernt werden?\n\n'
      'DESTROY_CATEGORY_NOT_ALLOWED': (options) ->
        '\nGeschützte Kategorie!\n\n'
      'NO_VALID_CATEGORY': (options) ->
        '\nDiese Kategorie unterstützt diese Funktion nicht!\n\n'
      'NO_FAVORITE_FOR_IGNORED': (options) ->
        '\nAusgeblendeter Artikel kann kein Produkt des Tages sein!\n\n'
      'NO_IGNORE_FOR_FAVORITE': (options) ->
        '\nEin Produkt des Tages kann nicht ausgeblendet werden!\n\n'
      'METHOD_NOT_SUPPORTED': (options) ->
        '\nFunktion momentan nicht verfügbar!\n\n'
      'NO_CAT_FOR_UPLOAD': (options) ->
        '\nEs ist momentan kein Produkt ausgewählt!\n\nUm den Upload abzuschliessen, markiere ein Produkt und klicke anschliessend unten auf "Start".\n\n'
    
    @ALBUM_SINGLE_MOVE = @createImage('/img/cursor_folder_1.png')
    @ALBUM_DOUBLE_MOVE = @createImage('/img/cursor_folder_3.png')
    @IMAGE_SINGLE_MOVE = @createImage('/img/cursor_images_1.png')
    @IMAGE_DOUBLE_MOVE = @createImage('/img/cursor_images_3.png')
    
    @ignoredHashes = ['slideshow', 'preview', 'flickr', 'logout']
    @arr = ['false', 'fitness', 'outdoor', 'specials', 'tools']
    
    $(window).bind('hashchange', @proxy @storeHash)
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
    @trustamiView = new TrustamiView
      el: @trustamiEl
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
      sidebar: @sidebar
      parent: @
    @overviewView = new OverviewView
      el: @overviewEl
    @previewView = new PreviewView
      el: @previewEl
    @missingView = new MissingView
      el: @missingEl
    @category = new CategoryEditView
      el: @categoryEl
      externalClass: '.optCategory'
    @product = new ProductEditView
      el: @productEl
      externalClass: '.optProduct'
    @upload = new UploadEditView
      el: @uploadEl
      parent: @showView
      externalClass: '.optUpload'
    @slideshowView = @showView.slideshowView

    @vmanager = new Spine.Manager(@sidebar)
    @vmanager.external = @showView.toolbarOne
    @vmanager.initDrag @vDrag,
      initSize: => @sidebarInitWidth #@el.width()/3.5
      sleep: true
      disabled: false
      axis: 'x'
      min: -> 20
      tol: -> 50
      max: => @el.width()/2
      goSleep: => @sidebar.inner.hide()
      awake: => @sidebar.inner.show()

    @hmanager = new Spine.Manager(@category, @product, @upload)
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
    
    @initRoot()
    
    @routes
      
      '/category/:cid/:pid/iid/:iid': (params) ->
        Model.Root.updateSelection params.cid or []
        Category.updateSelection params.pid or []
        Product.updateSelection params.iid or []
        buffer = Photo.renderBuffer()
        @showView.trigger('active', @showView.photosView, buffer || Photo.buffer)
      '/category/:cid/:pid/:iid': (params) ->
        Model.Root.updateSelection params.cid or []
        if (params.pid is 'pid')
          Category.updateSelection params.iid or []
          buffer = Product.renderBuffer()
          @showView.trigger('active', @showView.productsView, buffer || Product.buffer)
        else
          Category.updateSelection params.pid or []
          Product.updateSelection params.iid or []
          buffer = Photo.renderBuffer()
          @showView.trigger('active', @showView.photoView, buffer || Photo.buffer)
      '/category/:cid/:pid': (params) ->
        if (params.cid is 'cid')
          buffer = Category.renderBuffer()
          @showView.trigger('active', @showView.categoriesView, buffer || Category.buffer)
          
          Model.Root.updateSelection params.pid or []
        else
          Model.Root.updateSelection params.cid or []
          Category.updateSelection params.pid or []
          Product.updateSelection []
          buffer = Photo.renderBuffer()
          @showView.trigger('active', @showView.photosView, buffer || Photo.buffer)
      '/category/:cid': (params) ->
        Model.Root.updateSelection params.cid or []
        Category.updateSelection()
        buffer = Product.renderBuffer()
        @showView.trigger('active', @showView.productsView, buffer || Product.buffer)
      '/category/*': ->
        Root.updateSelection []
        @showView.trigger('active', @showView.categoriesView)
      '/overview/*': ->
        @overviewView.trigger('active')
      '/search/:sid': (params) ->
        @sidebar.filter {}, params.sid
        @showView.trigger('active', @showView.productsView)
      '/trash/products/:id': (params) ->
        items = Product.filter(true, func: 'selectDeleted')
        @showView.trigger('active', @showView.productsTrashView, items)
      '/trash/photos/:id': (params) ->
        items = Photo.filter(true, func: 'selectDeleted')
        @showView.trigger('active', @showView.photosTrashView, items)
      '/wait/*glob': (params) ->
        @showView.trigger('active', @showView.waitView)
      '/*glob': (params) ->
        @navigate '/overview', ''
          
#      '/category/:gid/:aid/:pid': (params) ->
#        Model.Root.updateSelection params.gid or []
#        if (params.aid is 'pid') and (pid = params.pid)
#          alert '3'
#          Category.updateSelection pid
#          buffer = Product.renderBuffer()
#          @showView.trigger('active', @showView.productsView, buffer || Product.buffer)
#        else
#          alert '4'
#          Category.updateSelection params.aid or []
#          Product.updateSelection params.pid or []
#          @showView.trigger('active', @showView.photoView, params.pid)
#      '/category/:gid/:aid': (params) ->
#        Model.Root.updateSelection params.gid or []
#        if (params.gid is 'cid') and (aid = params.aid)
#          alert '5'
#          Category.updateSelection aid
#          @showView.trigger('active', @showView.categoriesView)
#        else
#          alert '6'
#          Category.updateSelection params.aid or []
#          buffer = Photo.renderBuffer()
#          @showView.trigger('active', @showView.photosView, buffer || Photo.buffer)
#      '/category/*': ->
#        alert '7'
#        Root.updateSelection []
#        @showView.trigger('active', @showView.categoriesView)

    @loadToolbars()
    @defaultSettings =
      welcomeScreen: false,
      test: true
      
  initRoot: ->
    root = new Model.Root()
    root.save()
    Model.Root.current root
      
  validate: (user, json) ->
    valid = (usid = user.sessionid) and (jsid = json.sessionid) and (usid is jsid)
    unless valid
      User.logout()
    else
      @user = User.user = user
      user.tmi = json.tmi
      user.save()
      settings = @loadUserSettings(user.id)
      @initLocation(settings)
      @setInterval(10000)
      @delay @setupView, 500
      unless (intro = settings.intro)?
        settings.updateAttributes(intro: !intro)
        intro = true
#      @startScript(intro)
      @startScript(false)
  
  startScript: (b) ->
    setTimeout ->
      App.sidebar.toggleDraghandle()
    , 2500
    setTimeout ->
      App.showView.toggleDraghandle()
    , 3500
    setTimeout ->
      App.previewView.togglePreview()
    , 4500
    return unless b
    setTimeout ->
      App.sidebar.toggleDraghandle()
    , 4500
    setTimeout ->
      App.sidebar.toggleDraghandle()
    , 5500
    setTimeout ->
      App.showView.toggleDraghandle()
    , 6500
    setTimeout ->
      App.showView.toggleDraghandle()
    , 7500
    setTimeout ->
      App.vDragHandle.addClass('fire puls')
    , 9000
    setTimeout ->
      App.vDragHandle.removeClass('fire puls')
    , 12000
    setTimeout ->
      App.hDragHandle.addClass('fire puls')
    , 9000
    setTimeout ->
      App.hDragHandle.removeClass('fire puls')
    , 12000
    setTimeout ->
      alert 'Intro abschalten über Extras -> Intro-Quatsch'
    , 13000
  
  loadUserSettings: (id) ->
    Settings.fetch()
    
    unless settings = Settings.findByAttribute('user_id', id)
      Spine.trigger('show:wait',
        small: true
        header: false
        body: '<h3>Welcome</h3><br>to<br><h4>HA Lehmann Admin</h4><h2>Beta</h2>'
        footer: false
      )
      
      
#      @notify '<h3>Welcome</h3><br>to<br><h4>HA Lehmann Admin</h4><h2>Beta</h2>'
      
      settings = Settings.create
        user_id   : id
        autoupload: @autoupload
        intro     : @intro
    settings
        
  initLocation: (settings) ->
    return if location.hash
    hash = if h = settings.hash then h else '#/overview/'
    @navigate hash
    
  setInterval: (time) ->
    callback = (json) =>
      json = $.parseJSON(json)
      success = json.success
      sessionid = json.sessionid
      @user.sessionid = sessionid
      @user.save()
    func = => @user.isValid(callback)
    
    if @user
      clearInterval(@uuid) if @uuid
      @uuid = User.uuid()
      @uuid = setInterval(func, time)
    
  test: -> console.log 'Test'
    
  storeHash: ->
    return unless settings = Settings.loadSettings()
    hash = location.hash
    if !@ignoredHashes.contains(hash)
      settings.previousHash = settings.hash
    settings.hash = hash
    settings.save()
    
  fullscreen: ->
    Spine.trigger('chromeless', true)
    
  changeBackground: (cat) ->
    arr = @arr
    res = @getData(cat, arr)
    
    for c in arr
      @el.removeClass(c)
    @el.addClass(res)
      
  notify: (text) ->
    @modalView.render
      small: true
      body: -> require("views/notify")
        text: text
    .show()
      
  refreshSettings: (records) ->
#    if settings = Settings.loadSettings()
#      @navigate settings.hash
    
  changeSettings: (rec) ->
    
  setupView: ->
    @log 'setup View'
    Spine.unbind('uri:alldone')
    @mainView.trigger('active')
    @mainView.el.hide()
    @statusSymbol.fadeOut('slow', @proxy @finalizeView)
      
  finalizeView: ->
    @loginView.render()
    @mainView.el.fadeIn(500)
      
  startPage: ->
    return
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

  activateEditor: (e) ->
    el = $(e.currentTarget)
    test = el.prop('class')
    if /\bcat-trigger*/.test(test)
      @category.trigger('active')
    else if /\bpro-trigger*/.test(test)
      @product.trigger('active')
    else if /\bpho-trigger*/.test(test)
      @upload.trigger('active')
    e.stopPropagation()
    e.preventDefault()
      
  getData: (s) ->
    test = (s, a) -> 
      matcher = new RegExp(".*"+a+".*", "g");
      found = matcher.test(s);
    ret = a for a in @arr when test s, a
    ret
    
  confirm: (phrase, options={}, mode='confirm') ->
    defaults = {plural: false}
    options = $().extend defaults, options
    
    if window[mode].call(null, @CONFIRM[phrase](options))
      return true
    return
  
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
#          @delegateFocus(e, @showView)
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
            @delegateFocus(e, @showView.current)
          e.preventDefault()
      when 38 #Up
        unless isFormfield
          @delegateFocus(e, @showView.current)
          e.preventDefault()
      when 39 #Right
        unless isFormfield
          if @overviewView.isActive()
            @delegateFocus(e, @overviewView)
          else
            @delegateFocus(e, @showView.current)
          e.preventDefault()
      when 40 #Down
        unless isFormfield
          @delegateFocus(e, @showView.current)
          e.preventDefault()
      when 65 #ctrl A
        unless isFormfield
          @delegateFocus(e, @showView.current)
          e.preventDefault()
      when 73 #ctrl I
        unless isFormfield
          @delegateFocus(e, @showView.current)
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
