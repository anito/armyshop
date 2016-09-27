Spine = require("spine")
$     = Spine.$
Category  = require('models/category')
Product  = require('models/product')
Photo  = require('models/photo')

class RefreshView extends Spine.Controller

  elements:
    'button'              : 'logoutEl'

  events:
    'click .opt-Refresh'        : 'refresh'
    
    
  template:  (icon = 'repeat') ->
    $('#refreshTemplate').tmpl icon: icon
    
  constructor: ->
    super
    Spine.bind('refresh:all', @proxy @refresh)
    
  refresh: ->
    @render 'cloud-download'
    Category.trigger('refresh:one')
    Product.trigger('refresh:one')
    Photo.trigger('refresh:one')
    @fetchAll()
    
  fetchAll: ->
    Photo.fetch(null, clear:true)
    Product.fetch(null, clear:true)
    Category.fetch(null, clear:true)
    
  render: (icon) ->
    @html @template icon

module?.exports = RefreshView