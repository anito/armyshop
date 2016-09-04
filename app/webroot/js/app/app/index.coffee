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
    
    'click .opt-agreed'             :           'agreed'
    'click .sidebar .close'         :           'closeSidebar'
    'click .opt-sidebar'            :           'toggleSidebar'
    'click .sidebar .td:first-child':           'toggleSidebar'
    'click .paypal_'                :           'toggleView'
    'click .opt-agb'                :           'showAgb'
    'click .opt-imp'                :           'showImp'
    'click .opt-pay'                :           'showPay'
    'click #swop-logo'              :           'swopLogos'
    'click [class^="logo-"], [class*=" logo-"]':'redirectHome'
  
  
  constructor: ->
    super
    # Getting started - should be removed
    @modal = exists: false
    @arr = ['home', 'outdoor', 'defense', 'goodies', 'out']
    setting =
      hidden  : false
      agreed  : false
    
    #@content.append require("views/sample")({version:Spine.version})
    $('.nav-item', @items).removeClass('active')
    $('.'+@getData(base_url, @arr), @items).addClass('active')
    
    @setBackground()
    @initSettings(setting)
    @setLogos()
    
    if @getData(base_url, @arr) == 'defense' then @checkWarning()
    
  setLogos: ->
    flag = Settings.records[0].hidden
    @logo1.toggleClass('hide', !!flag)
    @logo2.toggleClass('hide', !!!flag)
  
  swopLogos: ->
    @logo1.toggleClass('hide')
    bol = @logo1.hasClass('hide')
    @logo2.toggleClass('hide', !bol)
    Settings.update(Settings.first().id, {hidden: bol})
    #Settings.findLogoSettings()
  
  setBackground: ->
    @el.addClass(@getData base_url, @arr)
    
  initSettings: (setting) ->
    Settings.fetch()
    @log Settings.records
    if i = Settings.first()?.id then return i
    s = new Settings(setting)
    s.save()
    @log s
    s.id
    
  checkWarning: ->
    warnBol = Settings.first()?.agreed
    if !warnBol then @showWarning()
  
  initAgreedSettings: (logo) ->
    Settings.fetch()
    @log Settings.records
    if i = Settings.first()?.id then return i
    s = new Settings(logo)
    s.save()
    s.id
    
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
    dialog = new ModalSimpleView
      options:
        small: false
        css: 'alert alert-warning'
        header: 'Hinweis'
        body: -> require("views/warning")
          copyright     : 'Axel Nitzschner'
          spine_version : Spine.version
          app_version   : App.version
          bs_version    : '1.1.1'#$.fn.tooltip.Constructor.VERSION
        footer:
          footerButtonText: 'Verstanden'
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
    @sidebar.toggleClass('on')
    
  closeSidebar: (e) ->
    e.preventDefault()
    @sidebar.removeClass('on')
    
  showSidebar: (e) ->
    e.preventDefault()
    @sidebar.addClass('glinch')
    
  hideSidebar: (e) ->
    return
    e.preventDefault()
    @sidebar.removeClass('glinch on')
    
  agreed: ->
    Settings.update(Settings.first().id, {agreed: true})
    
  getData: (s, arr=[]) ->
    test = (s, a) -> 
      matcher = new RegExp(".*"+a+".*", "g");
      found = matcher.test(s);
    for a, i in arr
      return arr[i] if test s, a
  
module.exports = App
