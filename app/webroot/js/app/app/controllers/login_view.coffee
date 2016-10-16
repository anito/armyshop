Spine = require("spine")
$     = Spine.$
User  = require('models/user')

class LoginView extends Spine.Controller

  elements:
    'button'              : 'logoutEl'

  events:
    'click .opt-logout'        : 'logout'
    'click .opt-trace'         : 'toggleTrace'
    
  constructor: ->
    super
    
  template: ->
    $('#loginTemplate').tmpl
      user: User.first()
      trace: !Spine.isProduction
    
  logout: ->
    User.logout()
    
  toggleTrace: ->
    Spine.isProduction = localStorage.isProduction = (localStorage.isProduction == 'false')
    @render()
    if confirm('Trace: ' + (if Spine.isProduction then 'Off' else 'On') + '\n\nApplication will now restart.\n\nContinue?')
      $(window).off()
      User.redirect('admin')
    
  render: ->
    @html @template()

module?.exports = LoginView