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
    'keyup'                         : 'saveOnKeyup'
    
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
      unless Category.count()
        @content.html $("#noSelectionTemplate").tmpl({type: '<label class="invite"><span class="enlightened">Director has no category yet &nbsp;<button class="opt-CreateCategory dark large">New Category</button></span></label>'})
      else
        @content.html $("#noSelectionTemplate").tmpl({type: '<label class="invite"><span class="enlightened">Select a category!</span></label>'})
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