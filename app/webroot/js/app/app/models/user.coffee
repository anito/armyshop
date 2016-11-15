Spine     = require("spine")
$         = Spine.$
Log       = Spine.Log
Model     = Spine.Model
Flash     = require("models/flash")
Settings  = require("models/settings")
Clipboard = require("models/clipboard")
Extender  = require("extensions/model_extender")

require('spine/lib/local')

class User extends Spine.Model

  @configure 'User', 'id', 'username', 'name', 'tmi', 'groupname', 'sessionid', 'hash', 'redirect'

  @extend Extender
  @extend Model.Local
  @include Log
  
  @trace: true
  
  @ping: ->
    @fetch()
    if user = @first()
      user.confirm()
    else
      alert 'Authorisierung fehlgeschlagen.\nBitte melden Sie sich erneut an.'
      @redirect 'users/login'
    
  @logout: ->
    @user.logout() if @user?
    @destroyAll()
    Clipboard.destroyAll()
    $(window).off()
  
  @test: -> alert 'test'
  
  @redirect: (url='', hash='') ->
    location.href = base_url + url + hash

  init: (instance) ->
    
  logout: ->
    $.ajax
      url: base_url + 'users/logout'
      data: JSON.stringify(@)
      type: 'POST'
      success: @logoutRedirect
      error: @errorHandler
  
  logoutRedirect: (json) ->
    json = $.parseJSON json
    console.log json
    Flash.fetch()
    flash = Flash.first() or new Flash
    flash.updateAttributes json
    User.redirect 'logout'
  
  confirm: ->
    $.ajax
      url: base_url + 'users/ping'
      data: JSON.stringify(@)
      type: 'POST'
      success: @success
      error: @proxy @errorHandler
  
  getTmi: (callback) ->
    $.ajax
      headers: {'X-Requested-With': 'XMLHttpRequest'}
      url: base_url + 'users/getTmi'
      type: 'GET'
      processData: false
      success: (json) -> callback.call @, json
      error: @proxy @errorHandler
    
  setTmi: (callback) ->
    $.ajax
      url: base_url + 'users/setTmi'
      data: JSON.stringify(@)
      type: 'POST'
      success: callback
      error: @proxy @errorHandler
    
  success: (json) =>
    @constructor.trigger('pinger', @, $.parseJSON(json))

module?.exports = Model.User = User