Spine       = require("spine")
$           = Spine.$
KeyEnhancer = require('extensions/key_enhancer')
Extender    = require('extensions/controller_extender')
Category     = require("models/category")
Root        = require("models/root")

class CategoryEditView extends Spine.Controller
  
  @extend Extender
  
  elements:
    '.content'      : 'content'
  
  events:
    'keyup'         : 'saveOnKeyup'
    
  template: (item) ->
    $('#editCategoryTemplate').tmpl item

  constructor: ->
    super
    @bind('active', @proxy @active)
    Category.bind('current', @proxy @change)
    
  active: ->
    @render()

  change: (item) ->
    @current = item
    @render()
    
  change_: (item) ->
    @current = item
    @render()

  render: () ->
    if @current 
      @content.html @template @current
    else
      @renderEmpty('Keine Kategorie ausgewählt', 'content')
    @el

  save: (el) ->
    @log 'save'
    if category = Category.record
      atts = el.serializeForm?() or @el.serializeForm()
      category.updateChangedAttributes(atts)

  saveOnKeyup: (e) ->
    @log 'saveOnEnter'
    
    code = e.charCode or e.keyCode
        
    switch code
      when 32 # SPACE
        e.stopPropagation() 
      when 9 # TAB
        e.stopPropagation()
        
    @save @el
    
  createCategory: ->
    Spine.trigger('create:category')
    
  click: (e) ->
    
module?.exports = CategoryEditView