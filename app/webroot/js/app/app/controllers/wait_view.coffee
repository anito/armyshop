Spine           = require("spine")
$               = Spine.$
Model           = Spine.Model
Controller      = Spine.Controller
ModalSimpleView = require("controllers/modal_simple_view")

Extender = require('extensions/controller_extender')

class WaitView extends Spine.Controller
  
  @extend Extender
  
  constructor: ->
    super
    @bind('active', @proxy @active)
    
    @header = new Spine.Controller
    
    Spine.bind('show:wait', @proxy @show)
    Spine.bind('done:wait', @proxy @close)
    
  render: (items) ->
      
  show: (params) ->
    App.showView.trigger('canvas', @)
    @active params
    
  active: (options) ->
    @notify(options)
    
  notify: (options={}) ->
    defaults =
      body: 'Body'
      small: true
    options = $.extend defaults, options
    
      
    @modalSimpleView = new ModalSimpleView
      modalOptions:
        keyboard: true
        show: false
      renderOptions: options
      
      
    @modalSimpleView.el.one('hidden.bs.modal', @proxy @hiddenmodal)
    @modalSimpleView.el.one('hide.bs.modal', @proxy @hidemodal)
    @modalSimpleView.el.one('show.bs.modal', @proxy @showmodal)
    
    @modalSimpleView.show()
      
  close: (cb) ->
    @modalSimpleView.close()
    if typeof cb is 'function'
      cb.call(@)
    
  hidemodal: (e) ->
    
  hiddenmodal: (e) ->
  
  showmodal: (e) ->
    
module?.exports = WaitView