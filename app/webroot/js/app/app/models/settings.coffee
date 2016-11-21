Spine = require('spine')
$       = Spine.$
Model   = Spine.Model
Log     = Spine.Log
Extender      = require("extensions/model_extender")
require('spine/lib/local')

class Settings extends Spine.Model
  @configure 'Settings', 'hidden', 'agreed', 'sidebaropened', 'user_id', 'autoupload', 'hash', 'previousHash', 'intro'
  
  @extend Model.Local
  @extend Extender
  @include Log
  
  init: (instance) ->
  
  @loadSettings: ->
    if user = User.first()
      setting = @findByAttribute('user_id', user.id)
    else
      setting = @first()
    setting
      
  
  @isAutoUpload: ->
    setting = @loadSettings()
    !!setting?.autoupload
  
  @isIntroQuatsch: ->
    setting = @loadSettings()
    !!setting?.intro
  
  @findLogoSettings: ->
#    @findByAttribute('logo_id', 'logo1')
  
module.exports = Model.Settings = Settings