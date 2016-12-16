Spine = require("spine")
$      = Spine.$

class ModalSimpleView extends Spine.Controller
  
  elements:
    '.modal-header'       : 'header'
    '.modal-body'         : 'body'
    '.modal-footer'       : 'footer'
  
  events:
    'click .opt-ShowAllProducts' : 'allProducts'
    'click .opt-AddPhotos'     : 'addPhotos'
    'click .opt-CreateProduct'   : 'createProduct'
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
    
    modalOptions =
      keyboard: true
      show: false
      
    renderOptions =
      css: 'default';
      small: true
      header  : 'Default Header'
      body    : 'Default Body Text'
      footer:
        footerButtonText: 'schliessen'

    @renderOptions = if @renderOptions then $.extend(renderOptions, @renderOptions) else renderOptions
    $.extend(modalOptions, @modalOptions) if @modalOptions
    @el.modal modalOptions
    
  render: ->
    @html @template @renderOptions
    @el
      
  show: ->
    @render().modal('show')
    
  close: (e) ->
    @el.modal('hide')
    
  allProducts: ->
    @navigate '/category', ''
    
  addPhotos: (e) ->
    Spine.trigger('photos:add')
    
  createProduct: ->
    Spine.trigger('create:product')
    
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