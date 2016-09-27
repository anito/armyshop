require('lib/setup')

Spine = require('spine')
$      = Spine.$
ModalSimpleView = require("controllers/modal_simple_view")
Settings = require("models/settings")


class App extends Spine.Controller

  elements:
    '#header'           : 'header',
    '#header .nav.items': 'items',
    '#header .nav-item' : 'item',
    '#content'          : 'content',
    '#nav'              : 'nav'
    '#menu-trigger'     : 'menutrigger'
    '.logo-1'           : 'logo1'
    '.logo-2'           : 'logo2'
    '.sidebar'          : 'sidebar'

  events:
    'mouseenter #outdoor-item-menu' :           'changeBackground'
    'mouseenter #defense-item-menu' :           'changeBackground'
    'mouseenter #goodies-item-menu' :           'changeBackground'
    'mouseenter .opt-sidebar'       :           'showSidebar'
    'mouseleave .opt-sidebar'       :           'hideSidebar'
    
    'click .opt-hint'               :           'showWarning'
    'click .opt-agreed'             :           'agreed'
    'click .opt-close'              :           'closeSidebar'
    'click .opt-sidebar'            :           'toggleSidebar'
    'click .sidebar .td:first-child':           'toggleSidebar'
    'click .paypal'                 :           'toggleView'
    'click .opt-del'                :           'showDelivery'
    'click .opt-agb'                :           'showAgb'
    'click .opt-imp'                :           'showImp'
    'click .opt-pay'                :           'showPay'
    'click .opt-reset'              :           'reset'
    'click [class^="logo-"], [class*=" logo-"]':'redirectHome'
  
  
  constructor: ->
    super
    # Getting started - should be removed
    @modal = exists: false
    @arr = ['home', 'outdoor', 'defense', 'goodies', 'out']
    setting =
      hidden        : false
      agreed        : false
      sidebaropened : false
    
    #@content.append require("views/sample")({version:Spine.version})
    $('.nav-item', @items).removeClass('active')
    $('.'+@getData(base_url, @arr), @items).addClass('active')
    
    @initSettings(setting)
    @initSidebar()
    @initBackground()
    @initLogos()
    
    if @getData(base_url, @arr) == 'defense' then @checkWarning()
    
    
    @routes
      '/home/' : (params) ->
    
  checkWarning: ->
    if !@isAgreed() then @showWarning()
    
  initSettings: (setting) ->
    Settings.fetch()
    @log Settings.records
    if i = Settings.first()?.id then return i
    s = new Settings(setting)
    s.save()
    @log s
    s.id
    
  initBackground: ->
    @el.addClass(@getData base_url, @arr)
    
  initLogos: ->
    flag = Settings.records[0].hidden
    @logo1.toggleClass('hide', !!flag)
    @logo2.toggleClass('hide', !!!flag)
  
  initSidebar: ->
    isOpen = Settings.records[0].sidebaropened
    @setSidebar(!isOpen, true)
    
  isAgreed: ->
    Settings.first()?.agreed
  
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
    dialog = new ModalSimpleView
      options:
        small: false
        css: 'alert alert-warning'
        header: 'AGBs'
        body: -> require("views/agb")
          copyright     : 'Axel Nitzschner'
          spine_version : Spine.version
          app_version   : App.version
          bs_version    : '1.1.1'#$.fn.tooltip.Constructor.VERSION
      modalOptions:
        keyboard: true
        show: false
      
    dialog.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    dialog.el.one('hide.bs.modal', @proxy @hidemodal)
    dialog.el.one('show.bs.modal', @proxy @showmodal)
    dialog.el.one('shown.bs.modal', @proxy @shownmodal)
    
    dialog.render().show()
    e.preventDefault()
    
  showImp: (e) -> 
    dialog = new ModalSimpleView
      options:
        small: true
        css: 'alert alert-warning'
        header: 'Impressum'
        body: -> require("views/imp")
          copyright     : 'Axel Nitzschner'
          spine_version : Spine.version
          app_version   : App.version
          bs_version    : '1.1.1'#$.fn.tooltip.Constructor.VERSION
      modalOptions:
        keyboard: true
        show: false
      
    dialog.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    dialog.el.one('hide.bs.modal', @proxy @hidemodal)
    dialog.el.one('show.bs.modal', @proxy @showmodal)
    dialog.el.one('shown.bs.modal', @proxy @shownmodal)
    
    dialog.render().show()
    e.preventDefault()
    
  showPay: (e) -> 
    dialog = new ModalSimpleView
      options:
        small: false
        css: 'alert alert-warning'
        header: 'Zahlungsmöglichkeiten'
        body: -> require("views/pay")
          copyright     : 'Axel Nitzschner'
          spine_version : Spine.version
          app_version   : App.version
          bs_version    : '1.1.1'#$.fn.tooltip.Constructor.VERSION
      modalOptions:
        keyboard: true
        show: false
      
    dialog.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    dialog.el.one('hide.bs.modal', @proxy @hidemodal)
    dialog.el.one('show.bs.modal', @proxy @showmodal)
    dialog.el.one('shown.bs.modal', @proxy @shownmodal)
    
    dialog.render().show()
    e.preventDefault()
    
  showWarning: (e) -> 
    agreed = @isAgreed()
    dialog = new ModalSimpleView
      options:
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
      modalOptions:
        keyboard: true
        show: false
    @log dialog
      
    dialog.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    dialog.el.one('hide.bs.modal', @proxy @hidemodal)
    dialog.el.one('show.bs.modal', @proxy @showmodal)
    dialog.el.one('shown.bs.modal', @proxy @shownmodal)
    
    dialog.render().show()
    
  showDelivery: ->
    dialog = new ModalSimpleView
      options:
        small: false
        css: 'alert alert-warning'
        header: 'Versand'
        body: -> require("views/delivery")
          copyright     : 'Axel Nitzschner'
          spine_version : Spine.version
          app_version   : App.version
          bs_version    : '1.1.1'#$.fn.tooltip.Constructor.VERSION
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
    @modal.exists = false
    
  showmodal: (e) ->
    @log 'showmodal'
    @modal.exists = true
      
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
    
  reset: ->
#    @logo1.toggleClass('hide')
#    bol = @logo1.hasClass('hide')
#    @logo2.toggleClass('hide', !bol)
    Settings.update(Settings.first().id, {hidden: false, agreed: false})
    
  agreed: ->
    Settings.update(Settings.first().id, {agreed: true})
    
  getData: (s, arr=[]) ->
    test = (s, a) -> 
      matcher = new RegExp(".*"+a+".*", "g");
      found = matcher.test(s);
    for a, i in arr
      return arr[i] if test s, a
  
module.exports = App
