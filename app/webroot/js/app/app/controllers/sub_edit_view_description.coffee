Spine       = require("spine")
$           = Spine.$
Model       = Spine.Model
User        = require("models/user")
KeyEnhancer = require('extensions/key_enhancer')
Extender    = require('extensions/controller_extender')
Description = require("models/description")
Drag        = require('extensions/drag')

class SubEditViewDescription extends Spine.Controller

  @extend Extender
  @extend Drag
  
  events:
    'keyup'                         : 'saveOnKeyup'
    'click .opt-add'                : 'add'
    'click .opt-remove'             : 'remove'
    'sortupdate'                    : 'sortupdate'
    'drop'                          : 'drop'
  
  template: (item) ->
    $('#editDescriptionTemplate').tmpl item
    
  constructor: ->
    super
    @bind('active', @proxy @active)
    Description.bind('destroy', @proxy @destroy)
    Spine.bind('refresh:one', @proxy @refreshOne)
    
  newAttributes: (object={}) ->
    if (user_id = User.first()?.id) and (product_id = @parent.current?.id)
      count = Description.filter(product_id).length
      obj =
        product_id  : product_id
        description : ''
        user_id     : user_id
        order       : count+1
      object = $.extend({}, obj, object)
    else
      User.ping()
    
  refreshOne: ->
    Description.one('refresh', @proxy @refresh)
    
  refresh: ->
    @active()
    
  active: ->
    $(@btn, @parent.el).addClass('active')
    items = Description.filterSortByOrder @parent.current?.id
    if !items.length
      items = @create()
    @render items
    
  render: (items) ->
    @html @template items
    @el.sortable()
    @refreshElements()
    @el
    
  add: (e) ->
    item = $(e.target).item()
    el = @findModelElement(item)
    newItem = @create order:parseInt(item.order)+1
    el.after @template newItem
    @sortupdate()
    $('[data-description-id='+newItem.id+'] input', @el).focus()
    
  remove: (e) ->
    item = $(e.target).item()
    item.destroy()
  
  create: (attr) ->
    item = new Description @newAttributes(attr)
    item.save()
    item
  
  destroy: (item) ->
    el = @findModelElement(item)
    el.detach()
    unless Description.filter(@parent.current.id).length
      @active()
    @sortupdate()
  
  drop: (e) -> e.stopPropagation()
  
  sortupdate: ->
    @children().each (index) ->
      item = $(@).item()
      item.order = index+1
      item.save()
      
      tmplItem = $(@).tmplItem()
      tmplItem.data = item
      tmplItem.update()
      
    @el.sortable('destroy').sortable()
    @refreshElements()
    
  save: (e) ->
    @log 'save description'
    if @parent.current
      atts = $(e.target).parent().serializeForm?()
      item = $(e.target).item()
      item.updateChangedAttributes(atts)

  saveOnKeyup: (e) =>
    code = e.charCode or e.keyCode
        
    switch code
      when 32 # SPACE
        e.stopPropagation() 
      when 9 # TAB
        e.stopPropagation()
    
    @save e
    
 module?.exports = SubEditViewDescription