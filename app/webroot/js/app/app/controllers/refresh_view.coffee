Spine = require("spine")
$     = Spine.$
Category  = require('models/category')
Product  = require('models/product')
Photo  = require('models/photo')
Description  = require('models/description')

class RefreshView extends Spine.Controller

  elements:
    'button'              : 'logoutEl'

  events:
    'click .opt-ref'        : 'refresh'
    
    
  template:  (icon = 'repeat') ->
    $('#refreshTemplate').tmpl icon: icon
    
  constructor: ->
    super
    Spine.bind('refresh:all', @proxy @refresh)
    
  refresh: ->
    @render 'cloud-download'
    Spine.trigger('bindRefresh:one')
    @fetchAll()
    
  fetchAll: ->
    Description.fetch(null, clear:true)
    Photo.fetch(null, clear:true)
    Product.fetch(null, clear:true)
    Category.fetch(null, clear:true)
    
  render: (icon) ->
    @html @template icon

module?.exports = RefreshView