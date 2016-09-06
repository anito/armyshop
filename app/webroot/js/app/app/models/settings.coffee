Spine = require('spine')
$       = Spine.$
Model   = Spine.Model
Log     = Spine.Log
Extender      = require("extensions/model_extender")
require('spine/lib/local')

class Settings extends Spine.Model
  @configure 'Settings', 'hidden', 'agreed', 'sidebaropened'
  
  @extend Model.Local
  @extend Extender
  @include Log
  
  init: (instance) ->
    
  
  @findLogoSettings: ->
#    @findByAttribute('logo_id', 'logo1')
  
module.exports = Model.Settings = Settings