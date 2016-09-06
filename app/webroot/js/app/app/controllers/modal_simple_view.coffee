Spine = require("spine")
$      = Spine.$

class ModalSimpleView extends Spine.Controller
  
  elements:
    '.modal-header'       : 'header'
    '.modal-body'         : 'body'
    '.modal-footer'       : 'footer'
  
  events:
    'click .opt-ShowAllAlbums' : 'allAlbums'
    'click .opt-AddPhotos'     : 'addPhotos'
    'click .opt-CreateAlbum'   : 'createAlbum'
    'click .btnClose'          : 'close'
    'hidden.bs.modal'          : 'hiddenmodal'
    'show.bs.modal'            : 'showmodal'
    'shown.bs.modal'           : 'shownmodal'
    'keydown'                  : 'keydown'
  
  template: (item) ->
    $('#modalSimpleTemplate').tmpl(item)
    
  constructor: ->
    super
    @el = $('#modal-view')
    
    modalDefaults =
      keyboard: true
      show: false
      
    defaults =
      small: true
      body    : 'Default Body Text'

    @options = $.extend defaults, @options
    modals = $.extend modalDefaults, @modalOptions
    
    @render()
  
  render: (options = @options) ->
    @log 'render'
    @html @template options
    @refreshElements()
    @
      
  show: ->
    @log 'show'
    @log @el
    @el.modal('show')
    
  close: (e) ->
    @log 'close'
    @el.modal('hide')
    
  allAlbums: ->
    @navigate '/gallery', ''
    
  addPhotos: (e) ->
    Spine.trigger('photos:add')
    
  createAlbum: ->
    Spine.trigger('create:album')
    
  hiddenmodal: ->
    @log 'hiddenmodal...'
  
  showmodal: ->
    @log 'showmodal...'
    
  shownmodal: ->
    @log 'shownmodal...'
    
  keydown: (e) ->
    @log 'keydown'
    
    code = e.charCode or e.keyCode
    @log code
        
    switch code
      when 32 # SPACE
        e.stopPropagation() 
      when 9 # TAB
        e.stopPropagation()
      when 27 # ESC
        e.stopPropagation()
      when 13 # RETURN
        @close()
        e.stopPropagation()
    
module?.exports = ModalSimpleView