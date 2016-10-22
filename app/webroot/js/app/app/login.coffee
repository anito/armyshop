Spine             = require("spine")
$                 = Spine.$
SpineError        = require("models/spine_error")
User              = require("models/user")

class Login extends Spine.Controller

  elements:
    'form'                      : 'form'
    '.flash'                    : 'flashEl'
    '.info'                     : 'infoEl'
    '#UserPassword'             : 'passwordEl'
    '#UserUsername'             : 'usernameEl'
    '#flashTemplate'            : 'flashTemplate'
    '#infoTemplate'             : 'infoTemplate'
    '#login .dialogue-content'  : 'contentEl'
    '#loader'                   : 'loader'
    '.guest'                    : 'btnGuest'
    
  events:
    'keypress'          : 'submitOnEnter'
    'click #guestLogin' : 'guestLogin'
    'click #cancel'     : 'cancel'

  template: (el, item) ->
    el.tmpl(item)
    
  constructor: (form) ->
    super
    SpineError.fetch()
    lastError = SpineError.first() if SpineError.count()
    if lastError
      @render @flashEl, @flashTemplate, lastError 
      @render @infoEl, @infoTemplate, lastError if lastError.record
    SpineError.destroyAll()
    
    @renderGuestLogin()
    
  render: (el, tmpl, item) ->  
    el.html @template tmpl, item
    @el
    
  submit: =>
    $.ajax
      data: @form.serialize()
      type: 'POST'
      success: @success
      error: @error
      complete: @complete
      
  complete: (xhr) =>
    json = xhr.responseText
    @passwordEl.val('')
    @usernameEl.val('').focus()
    
  success: (json) =>
    User.fetch()
    User.destroyAll()
    user = new User @newAttributes($.parseJSON json)
    user.save()
    @render(@flashEl, @flashTemplate, json)
    delayedFunc = ->
      User.redirect 'admin#' + location.hash
    @contentEl.addClass('fade500')
    @delay delayedFunc, 500

  error: (xhr) =>
    json = $.parseJSON(xhr.responseText)
    @oldMessage = @flashEl.html() unless @oldMessage
    delayedFunc = -> @flashEl.html @oldMessage
    @render @flashEl, @flashTemplate, json
    @delay delayedFunc, 2000
    
  newAttributes: (json) ->
    id: json.id
    username: json.username
    name: json.name
    groupname: json.groupname
    sessionid: json.sessionid
    
  cancel: (e) ->
    User.redirect()
    e.preventDefault()
    
  renderGuestLogin: ->
    unless Spine.isProduction
      @btnGuest.removeClass('hide')
    
  guestLogin: ->
    @usernameEl.val('guest')
    @passwordEl.val('guest')
    @submit()
    
  submitOnEnter: (e) ->
    return unless e.keyCode is 13
    @submit()
    e.preventDefault()
    
module?.exports = Login