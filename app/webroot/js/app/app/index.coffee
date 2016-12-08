require('lib/setup')

Spine           = require('spine')
$               = Spine.$
ModalSimpleView = require("controllers/modal_simple_view")
RefreshView     = require('controllers/refresh_view')
Extender        = require('extensions/controller_extender')
Settings        = require("models/settings")
User            = require("models/user")
UriHelper       = require('extensions/uri_helper')

class App extends Spine.Controller

  @extend Extender
  @extend UriHelper
  
  elements:
    '#header'           : 'header',
    '#header .nav.items': 'items',
    '#header .nav-item' : 'item',
    '#content'          : 'content',
    '#nav'              : 'nav'
    '#stats'            : 'stats'
    '#menu-trigger'     : 'menutrigger'
    '#stats'            : 'stats'
    '.logo-1'           : 'logo1'
    '.logo-2'           : 'logo2'
    '.sidebar'          : 'sidebar'
    '#refresh'          : 'refreshEl'
    '.trustami-badge'   : 'trustami'
    '.hb-badge'         : 'hb'

  events:
    'mouseenter #fitness-item-menu' :           'changeBackground'
    'mouseenter #outdoor-item-menu' :           'changeBackground'
    'mouseenter #tools-item-menu'   :           'changeBackground'
    'mouseenter #specials-item-menu':           'changeBackground'
    'mouseenter .opt-stats'         :           'showStats' 
    'mousemove  .opt-stats'         :           'moveStats' 
    'mouseleave .opt-stats'         :           'hideStats' 
    'click .opt-stats'              :           'noMethod' 
    
    'click .opt-hint'               :           'showWarning'
    'click .opt-agreed'             :           'agreed'
    'click .opt-close'              :           'closeSidebar'
    'click .opt-sidebar'            :           'toggleSidebar'
    'click .sidebar .td:first-child':           'toggleSidebar'
    'click .paypal'                 :           'toggleView'
    'click .opt-del'                :           'showDelivery'
    'click .opt-agb'                :           'showAgb'
    'click .opt-imp'                :           'showImp'
    'click .opt-privacy'            :           'showPrivacy'
    'click .opt-revocation'         :           'showRevocation'
    'click .opt-pay'                :           'showPay'
    'click .opt-reset'              :           'reset'
    'click [class^="logo-"], [class*=" logo-"]':'redirectHome'
  
  trustamiTemplate:  (item) ->
    $('#trustamiTemplate').tmpl item
  
  hbTemplate: ->
    $('#hbTemplate').tmpl()
  
  constructor: ->
    super
    # Getting started - should be removed
    @modal = exists: false
    
    @arr = ['home', 'fitness', 'outdoor', 'tools', 'specials', 'out']
    
    setting =
      hidden        : false
      agreed        : false
      sidebaropened : false
    
    @refreshView = new RefreshView
      el: @refreshEl
    
    Spine.bind('active:category', @proxy @initCategory)
    Spine.bind('refresh:complete', @proxy @renderRefreshView)
    
    @initSettings(setting)
    @initSidebar()
    @initLogos()
    @exposeNav()
    @renderRefreshView()
    @getTrustami()
    @renderHb()
    
    @routes
    
      '/item/:pid': (params) ->
        @showDetails params.pid
      '/*glob' : (params) ->
    
  initCategory: (cat) ->
#    if cat.name is 'outdoor' then @checkWarning()
    @initBackground(cat.name)
    @exposeNav(cat.name)
    
  exposeNav: (name='home') ->
    name = @getData(name, @arr)
    $('.nav-item', @items).removeClass('active')
    $('.nav-item.'+name, @items).addClass('active')
    
  renderRefreshView: ->
    @refreshView.render()
    
  renderTrustami: (tmi) ->
    @trustami.html @trustamiTemplate tmi: tmi
    
  renderHb: () ->
    @hb.html @hbTemplate()
    
  getTrustami: ->
    callback = (json) =>
      tmi = $.parseJSON(json).tmi
      @renderTrustami(tmi)
      
    @user = if !(user = @user) then user = new User else user
    @user.save()
    @user.getTmi(callback)
    
  checkWarning: ->
    if !@isAgreed() then @showWarning()
    
  initSettings: (setting) ->
    Settings.fetch()
    if i = Settings.first()?.id then return i
    s = new Settings(setting)
    s.save()
    s.id
    
  initBackground: (name) ->
    @el.addClass(name)
    
  initLogos: ->
    flag = Settings.records[0].hidden
    @logo1.toggleClass('hide', !!flag)
    @logo2.toggleClass('hide', !!!flag)
  
  initSidebar: ->
    isOpen = Settings.records[0].sidebaropened
    @setSidebar(!isOpen, true)
    
  changeBackground: (e) ->
    e.preventDefault()
    e.stopPropagation()
    el = $(e.currentTarget)
    
    arr = @arr
    s = el.attr('id')
    res = @getData s, arr
    
    for c in arr
      @el.removeClass(c)
    @el.addClass(res)
  
  removeBackground: (e) ->
    e.preventDefault()
    e.stopPropagation()
    
    arr = @arr
    for c in arr
      @el.removeClass(c)
    @el.addClass('out')
    
  showAgb: (e) -> 
    options =
      small: false
      css: 'alert alert-warning'
      header: 'AGBs'
      body: -> require("views/agb")
        copyright     : 'Axel Nitzschner'
        spine_version : Spine.version
        app_version   : App.version
        bs_version    : '1.1.1'#$.fn.tooltip.Constructor.VERSION
      
    dialog = new ModalSimpleView
      modalOptions:
        keyboard: true
        show: false
      renderOptions: options
      
    dialog.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    dialog.el.one('hide.bs.modal', @proxy @hidemodal)
    dialog.el.one('show.bs.modal', @proxy @showmodal)
    dialog.el.one('shown.bs.modal', @proxy @shownmodal)
    
    dialog.show(options)
    e.preventDefault()
    
  showImp: (e) -> 
    options =
      small: false
      css: 'alert alert-warning'
      header: 'Impressum'
      body: -> require("views/imp")
        copyright     : 'Axel Nitzschner'
        spine_version : Spine.version
        app_version   : App.version
        bs_version    : '1.1.1'#$.fn.tooltip.Constructor.VERSION
      
    dialog = new ModalSimpleView
      modalOptions:
        keyboard: true
        show: false
      renderOptions: options
      
    dialog.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    dialog.el.one('hide.bs.modal', @proxy @hidemodal)
    dialog.el.one('show.bs.modal', @proxy @showmodal)
    dialog.el.one('shown.bs.modal', @proxy @shownmodal)
    
    dialog.show(options)
    e.preventDefault()
    
  showPay: (e) ->
    options =
      small: false
      css: 'alert alert-warning'
      header: 'Zahlungsmöglichkeiten'
      body: -> require("views/pay")
        copyright     : 'Axel Nitzschner'
        spine_version : Spine.version
        app_version   : App.version
        bs_version    : '1.1.1'#$.fn.tooltip.Constructor.VERSION
      
    dialog = new ModalSimpleView
      modalOptions:
        keyboard: true
        show: false
      renderOptions: options
    
    dialog.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    dialog.el.one('hide.bs.modal', @proxy @hidemodal)
    dialog.el.one('show.bs.modal', @proxy @showmodal)
    dialog.el.one('shown.bs.modal', @proxy @shownmodal)
    
    dialog.show(options)
    e.preventDefault()
    
  showWarning: (e) -> 
    agreed = @isAgreed()
    options =
      small: false
      css: 'alert alert-danger'
      header: 'Hinweis zum Versand von Pfeffer- und CS Gas-Sprays'
      body: -> require("views/warning")
        copyright     : 'Axel Nitzschner'
        spine_version : Spine.version
        app_version   : App.version
        bs_version    : '1.1.1'#$.fn.tooltip.Constructor.VERSION
      footer:
        footerButtonText: -> if !agreed then "Verstanden"
      
    dialog = new ModalSimpleView
      modalOptions:
        keyboard: true
        show: false
      renderOptions: options
      
    dialog.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    dialog.el.one('hide.bs.modal', @proxy @hidemodal)
    dialog.el.one('show.bs.modal', @proxy @showmodal)
    dialog.el.one('shown.bs.modal', @proxy @shownmodal)
    
    dialog.show(options)
    
  showDelivery: (e) ->
    options =
      small: false
      css: 'alert alert-warning'
      header: 'Versand'
      body: -> require("views/delivery")
        copyright     : 'Axel Nitzschner'
        spine_version : Spine.version
        app_version   : App.version
        bs_version    : '1.1.1'#$.fn.tooltip.Constructor.VERSION
      
    dialog = new ModalSimpleView
      modalOptions:
        keyboard: true
        show: false
      renderOptions: options
        
    dialog.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    dialog.el.one('hide.bs.modal', @proxy @hidemodal)
    dialog.el.one('show.bs.modal', @proxy @showmodal)
    dialog.el.one('shown.bs.modal', @proxy @shownmodal)
    
    dialog.show()
    e.preventDefault()
    
  showPrivacy: (e) ->
    options =
      small: false
      css: 'alert alert-warning'
      header: 'Datenschutzerklärung'
      body: -> require("views/privacy")()
      
    dialog = new ModalSimpleView
      modalOptions:
        keyboard: true
        show: false
      renderOptions: options
        
    dialog.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    dialog.el.one('hide.bs.modal', @proxy @hidemodal)
    dialog.el.one('show.bs.modal', @proxy @showmodal)
    dialog.el.one('shown.bs.modal', @proxy @shownmodal)
    
    dialog.show()
    e.preventDefault()
    
  showRevocation: (e) ->
    options =
      small: false
      css: 'alert alert-warning'
      header: 'Widerrufsrecht'
      body: -> require("views/revocation")()
      
    dialog = new ModalSimpleView
      modalOptions:
        keyboard: true
        show: false
      renderOptions: options
        
    dialog.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    dialog.el.one('hide.bs.modal', @proxy @hidemodal)
    dialog.el.one('show.bs.modal', @proxy @showmodal)
    dialog.el.one('shown.bs.modal', @proxy @shownmodal)
    
    dialog.show()
    e.preventDefault()
    
  showDetails: (id) ->
    @product = Product.find id
    return unless @product
    
    options =
      small: false
      css: 'alert'
      header: @product.title
      body: => $('#norbuPricingDetailsTemplate').tmpl(@product).html()
    
    dialog = new ModalSimpleView
      modalOptions:
        keyboard: true
        show: false
      renderOptions: options
      
    dialog.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    dialog.el.one('hide.bs.modal', @proxy @hidemodal)
    dialog.el.one('show.bs.modal', @proxy @showmodaldetails)
    dialog.el.bind('shown.bs.modal', @proxy @shownmodal)
    
    dialog.show()
    
  hidemodal: (e) ->
    @navigate '/'
    
  hiddenmodal: (e) ->
    @log 'hiddenmodal'
    @modal.exists = false
    
  showmodal: (e) =>
    @log 'showmodal'
    @modal.exists = true
    
  showmodaldetails: (e) =>
    @log 'showmodal'
    @modal.exists = true
    cb = (json, items) =>
      result = for jsn in json
        ret = for key, val of jsn
          src: val.src
          id: key
        ret[0]

      onError = -> throw 'unable to load image'
      onLoad = ->
        @imgEl.attr('src', @src).removeClass('load')
        @imgEl.addClass('in')
      
      snap = (res) =>
        imgEl = $('#'+res.id+' img', @el)
        img = @createImage()
        img.imgEl = imgEl
        img.this = @
        img.res = res
        img.onload = onLoad
        img.onerror = onError
        img.src = res.src

      for res in result
        snap(res)

    @callDeferred @product.photos(1), @uriSettings(740, 740), cb
      
  shownmodal: (e) ->
    @log 'shownmodal'
    
  redirectHome: -> location.href = '/'
    
  toggleView: (e) ->
    e.preventDefault()
    @el.toggleClass('on')
    
  toggleSidebar: (e) ->
    e.preventDefault()
    @setSidebar()
    
  closeSidebar: (e) ->
    e.preventDefault()
    @setSidebar(true)
    
  setSidebar: (bol, notrans=false) ->
    @sidebar.toggleClass('notrans', notrans)
    @sidebar.toggleClass('off', bol)
    isOpen = !@sidebar.hasClass('off')
    Settings.update(Settings.first().id, sidebaropened: isOpen)
    
  showSidebar: (e) ->
    e.preventDefault()
    @sidebar.addClass('glinch')
    
  hideSidebar: (e) ->
    return
    e.preventDefault()
    @sidebar.addClass('off')
    
  showStats: (e) ->
    @stats.attr('src', '/stat/counter.php').addClass('in').removeClass('away')
    e.preventDefault()
    
  moveStats: (e) ->
    @stats.position(e)
    e.preventDefault()
    
  hideStats: (e) ->
    @stats.attr('src', '').removeClass('in').addClass('away')
    e.preventDefault()
    
  reset: ->
#    @logo1.toggleClass('hide')
#    bol = @logo1.hasClass('hide')
#    @logo2.toggleClass('hide', !bol)
    Settings.update(Settings.first().id, {hidden: false, agreed: false})
    
  agreed: ->
    Settings.update(Settings.first().id, {agreed: true})

  isAgreed: ->
    Settings.first()?.agreed
    
  getData: (s, arr=[]) ->
    test = (s, a) -> 
      matcher = new RegExp(".*"+a+".*", "g");
      found = matcher.test(s);
    for a, i in arr
      return arr[i] if test s, a
  
module.exports = App
