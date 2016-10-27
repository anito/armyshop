Spine     = require("spine")
$         = Spine.$
KeyEnhancer = require('extensions/key_enhancer')
Extender    = require('extensions/controller_extender')
Category    = require("models/category")
Root        = require("models/root")

class SubEditViewProduct extends Spine.Controller

  @extend Extender
  
  events:
    'keyup'                         : 'saveOnKeyup'
    'click .opt-ignored'            : 'ignoreProduct'
  
  template: (item) ->
    $('#editProductTemplate').tmpl item
    
  constructor: ->
    super
    @bind('active', @proxy @active)
    Spine.bind('bindRefresh:one', @proxy @bindRefresh)
    
  bindRefresh: ->
    Product.one('refresh', @proxy @refresh)
    
  refresh: ->
    @active()
    
  active: ->
    @render()
    
  render: ->
    @html @template @parent.current
#    $('input',@el)[0].focus -> $(@).select()
    
  save: (el) ->
    @log 'save product'
    if @parent.current
      atts = el.serializeForm?() or @el.serializeForm()
      @parent.current.updateChangedAttributes(atts)

  ignoreProduct: (e) ->
    product = $(e.currentTarget).item()
    category = Category.record
    return unless category
    Spine.trigger('product:ignore', product, category)

  saveOnKeyup: (e) =>
    code = e.charCode or e.keyCode
        
    switch code
      when 32 # SPACE
        e.stopPropagation() 
      when 9 # TAB
        e.stopPropagation()

    @save @el
    
 module?.exports = SubEditViewProduct