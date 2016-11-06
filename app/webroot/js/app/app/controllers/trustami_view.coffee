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
    User.bind('update', @proxy @render)
    @init()
    
  init: ->
    @user = User.first()
    
  render: (item) ->
    @html @template item
    
  save:  ->
    atts = @el.serializeForm()
    @user.updateAttributes(atts)
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
    
    switch code
      when 32 # SPACE
        e.stopPropagation() 
      when 9 # TAB
        e.stopPropagation()
    
    console.log el = $(e.target)
    
    @save()
    
  dummy: ->
  
module?.exports = TrustamiView