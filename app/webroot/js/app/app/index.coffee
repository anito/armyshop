require('lib/setup')

Spine = require('spine')
$      = Spine.$
ModalSimpleView = require("controllers/modal_simple_view")


class App extends Spine.Controller

  elements:
    '#header'           : 'header',
    '#header .nav.items': 'items',
    '#header .nav-item' : 'item',
    '#content'          : 'content',
    '#nav'              : 'nav'
    '#menu-trigger'     : 'menutrigger'

  events:
    'mouseenter #outdoor-item-menu' :           'changeBackground'
    'mouseenter #defense-item-menu' :           'changeBackground'
    'mouseenter #goodies-item-menu' :           'changeBackground'

    'click .opt-agb'                :           'showAgb'
    'click .opt-imp'                :           'showImp'
    'click .opt-pay'                :           'showPay'
  
  
  
  constructor: ->
    super
    # Getting started - should be removed
    @modal = exists: false
    @arr = ['home', 'outdoor', 'defense', 'goodies', 'out']
    
    #@content.append require("views/sample")({version:Spine.version})
    $('.nav-item', @items).removeClass('active')
    $('.'+@getData(base_url, @arr), @items).addClass('active')
    
    @setBackground()
  
  setBackground: ->
    @el.addClass(@getData base_url, @arr)
    
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
    
  getData: (s, arr=[]) ->
    test = (s, a) -> 
      matcher = new RegExp(".*"+a+".*", "g");
      found = matcher.test(s);
    for a, i in arr
      return arr[i] if test s, a
  
module.exports = App
