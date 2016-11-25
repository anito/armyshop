Spine = require("spine")
$     = Spine.$
User  = require('models/user')

class TrustamiView extends Spine.Controller

  elements:
    'input'                 : 'input'

  events:
    'click .opt-Count-Up'   : 'countUp'
    'click .opt-Count-Down' : 'countDown'
    
    'keyup'                 : 'saveOnKeyup'
    
  template: (item) ->
    $('#trustamiTemplate').tmpl item
    
  constructor: ->
    super
    User.one('update', @proxy @render)
    @init()
    
  init: ->
    @user = User.first()
    
  render: (item) ->
    @html @template item
    
  save:  ->
    atts = @el.serializeForm()
    if isNaN(n = parseInt(atts.tmi)) or n < 1
      @input.val(@user.tmi)
      return
      
    @input.val(n)
    @user.updateAttributes(tmi:n)
    @user.setTmi(@setCallback)
    
  countUp: ->
    val = parseInt(@input.val())+1
    @input.val(val)
    @save()
    
  countDown: ->
    val = parseInt(@input.val())-1
    @input.val(val)
    @save()
    
  getCallback: (json) ->
    json = $.parseJSON(json)
#    console.log = json['tmi']
  
  setCallback: (json) ->
    json = $.parseJSON(json)
#    console.log json
    
  saveOnKeyup: (e) =>
    code = e.charCode or e.keyCode
    return if code >= 37 and code <= 40
    
    el=$(document.activeElement)
    isFormfield = $().isFormElement(el)
    
    switch code
      when 32 # SPACE
        unless isFormfield
          e.stopPropagation() 
      when 9 # TAB
        unless isFormfield
          e.stopPropagation()
    
    @save()
    
  dummy: ->
  
module?.exports = TrustamiView