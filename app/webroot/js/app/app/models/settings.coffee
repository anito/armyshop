Spine = require('spine')
$       = Spine.$
Model   = Spine.Model
Log     = Spine.Log
Extender      = require("extensions/model_extender")
require('spine/lib/local')

class Settings extends Spine.Model
  @configure 'Settings', 'hidden', 'agreed', 'sidebaropened', 'user_id', 'autoupload', 'hash', 'previousHash'
  
  @extend Model.Local
  @extend Extender
  @include Log
  
  init: (instance) ->
  
  @findUserSettings: ->
    Settings.findByAttribute('user_id', User.first().id) if User.count()
  
  @isAutoUpload: ->
    return unless user = User.first()
    setting = @findByAttribute('user_id', user.id)
    ret = setting?.autoupload or false
    ret
  
  @findLogoSettings: ->
#    @findByAttribute('logo_id', 'logo1')
  
module.exports = Model.Settings = Settings