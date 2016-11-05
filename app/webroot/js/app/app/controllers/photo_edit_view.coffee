Spine       = require("spine")
$           = Spine.$
Photo = require('models/photo')
KeyEnhancer = require('extensions/key_enhancer')
Extender    = require('extensions/controller_extender')
ProductsPhoto = require('models/products_photo')

class PhotoEditView extends Spine.Controller

  @extend Extender
  
  elements:
    '.content'      : 'content'
  
  events:
    'click'           : 'click'
    'keyup'           : 'saveOnKeyup'
    
  template: (item) ->
    $('#editPhotoTemplate').tmpl(item)
  
  constructor: ->
    super
    @current = false
    
    @bind('active', @proxy @active)
    Photo.bind('current', @proxy @change)
  
  change: (item) ->
    @current = item
    @render()
  
  render: () ->
    if @current
      @content.html @template @current
    else
      info = '<label class="invite"><span class="enlightened">Kein Foto ausgewählt</span></label>' unless Product.selectionList().length and !Product.count()
      @content.html $("#noSelectionTemplate").tmpl({type: info || ''})
    @el
  
  save: (el) ->
    if @current
      atts = el.serializeForm?() or @el.serializeForm()
      @current.updateChangedAttributes(atts)
 
  saveOnKeyup: (e) =>
    code = e.charCode or e.keyCode
    
    switch code
      when 32 # SPACE
        e.stopPropagation() 
      when 9 # TAB
        e.stopPropagation()
    
    @save @el
    
  click: (e) ->

module?.exports = PhotoEditView