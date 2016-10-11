require('lib/setup')

Spine = require('spine')
$      = Spine.$
ModalSimpleView = require("controllers/modal_simple_view")
HomepageView    = require("controllers/homepage_view")
RefreshView     = require('controllers/refresh_view')
Settings        = require("models/settings")


class App extends Spine.Controller

  elements:
    '#header'           : 'header',
    '#header .nav.items': 'navItems',
    '#header .nav-item' : 'item',
    '#home'             : 'homeEl',
    '#defense'          : 'defenseEl',
    '#goodies'          : 'goodiesEl',
    '#outdoor'          : 'outdoorEl',
    '#nav'              : 'nav'
    '#menu-trigger'     : 'menutrigger'
    '.logo-1'           : 'logo1'
    '.logo-2'           : 'logo2'
    '.sidebar'          : 'sidebar'
    '#refresh'          : 'refreshEl'

  events:
    'mouseenter .item-menu'         :           'background'
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
    
    setting =
      hidden        : false
      agreed        : false
      sidebaropened : false
    
    @refreshView = new RefreshView
      el: @refreshEl
    @home = new HomepageView
      el: @homeEl
      nav: @navItems
      categoryName: 'home'
      refreshView: @refreshView
    @defense = new HomepageView
      el: @defenseEl
      nav: @navItems
      categoryName: 'defense'
      refreshView: @refreshView
    @outdoor = new HomepageView
      el: @outdoorEl
      nav: @navItems
      categoryName: 'outdoor'
      refreshView: @refreshView
    @goodies = new HomepageView
      el: @goodiesEl
      nav: @navItems
      categoryName: 'goodies'
      refreshView: @refreshView
      
    @manager = new Spine.Manager(@home, @defense, @outdoor, @goodies)
    @manager.bind('change', @proxy @viewChanged)
   
    @setData()
    @initSettings(setting)
    @initSidebar()
    @initLogos()
    
    @routes
      '/defense/' : (params) ->
        @defense.trigger('active')
      '/outdoor/' : (params) ->
        @outdoor.trigger('active')
      '/goodies/' : (params) ->
        @goodies.trigger('active')
      '/home/' : (params) ->
        @home.trigger('active')
      '/*glob' : (params) ->
        @navigate '/home', ''
    
#    @navigate '/home/'
    
  checkWarning: ->
    if !@isAgreed() then @showWarning()
    
  initSettings: (setting) ->
    Settings.fetch()
    if i = Settings.first()?.id then return i
    s = new Settings(setting)
    s.save()
    s.id
    
  initLogos: ->
    flag = Settings.records[0].hidden
    @logo1.toggleClass('hide', !!flag)
    @logo2.toggleClass('hide', !!!flag)
  
  initSidebar: ->
    isOpen = Settings.records[0].sidebaropened
    @setSidebar(!isOpen, true)
    
  isAgreed: ->
    Settings.first()?.agreed
  
  viewChanged: (c) ->
    @changeNavbar c.categoryName
    @changeBackground c.categoryName
    if c.categoryName == 'defense' then @checkWarning()
    
    @refreshView.render()
    
  background: (e) ->
    e.preventDefault()
    e.stopPropagation()
    el = $(e.currentTarget)
    
    s = el.attr('id')
    res = @getData s, @arr
    @changeBackground res
    
  changeNavbar: (cat) ->
    $('.nav-item', @navItems).removeClass('active')
    $('.'+cat, @navItems).addClass('active')
    
  changeBackground: (k) ->
    @el.removeClass(c.categoryName) for c in @manager.controllers
    @el.addClass(k)
    
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
    Settings.update(Settings.first().id, {hidden: false, agreed: false})
    
  agreed: ->
    Settings.update(Settings.first().id, {agreed: true})
    
  setData: ->
    @arr = []
    @arr.push c.categoryName for c in @manager.controllers
    
  getData: (s, arr=[]) ->
    test = (s, a) -> 
      matcher = new RegExp(".*"+a+".*", "g");
      found = matcher.test(s);
    for a, i in arr
      return arr[i] if test s, a
  
module.exports = App
