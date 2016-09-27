Spine           = require("spine")
$               = Spine.$
KeyEnhancer     = require('extensions/key_enhancer')
Extender        = require('extensions/controller_extender')
CategoriesProduct  = require('models/categories_product')

class ProductEditView extends Spine.Controller
  
  @extend Extender
  
  events:
    'keyup'         : 'saveOnKeyup'
  
  template: (item) ->
    $('#editProductTemplate').tmpl item

  constructor: ->
    super
    @bind('active', @proxy @active)
    Product.bind('current', @proxy @change)
  
  active: ->
    @render()
  
  change: (item) ->
    @current = item
    @render() 
  
  render: () ->
    if @current #and !item.destroyed 
      @html @template @current
    else
      @html $("#noSelectionTemplate").tmpl({type: '<label class="invite"><span class="enlightened">Select or create an product</span></label>'})
    @el

  save: (el) ->
    @log 'save'
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

module?.exports = ProductEditView