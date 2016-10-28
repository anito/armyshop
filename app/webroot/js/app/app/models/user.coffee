Spine     = require("spine")
$         = Spine.$
Log       = Spine.Log
Model     = Spine.Model
Settings  = require("models/settings")
Clipboard = require("models/clipboard")

require('spine/lib/local')

class User extends Spine.Model

  @configure 'User', 'id', 'username', 'name', 'groupname', 'sessionid', 'hash', 'redirect'

  @extend Model.Local
  @include Log
  
  @trace: true
  
  @ping: ->
    @fetch()
    if user = @first()
      user.confirm()
    else
      alert 'Ungültige Authorisierung.'
      @redirect 'users/login'
    
  @logout: ->
    @destroyAll()
    Clipboard.destroyAll()
    $(window).off()
    @redirect 'logout'
  
  @test: -> alert 'test'
  
  @redirect: (url='', hash='') ->
    location.href = base_url + url + hash

  init: (instance) ->
    
  confirm: ->
    $.ajax
      url: base_url + 'users/ping'
      data: JSON.stringify(@)
      type: 'POST'
      success: @success
      error: @error
  
  success: (json) =>
    @constructor.trigger('pinger', @, $.parseJSON(json))

  error: (xhr, e) =>
    console.log xhr
    console.log e
    
    @constructor.logout()
    @constructor.redirect 'users/login'
      
module?.exports = User