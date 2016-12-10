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
    'click .opt-Refresh'  : 'refresh'
    
  template:  (icon = 'repeat') ->
    $('#refreshTemplate').tmpl icon: icon
    
  constructor: ->
    super
    Spine.bind('refresh:all', @proxy @refresh)
    
  refresh: (e) ->
    @render 'cloud-download'
    Spine.trigger('refresh:one')
    @fetchAll()
    
    e?.stopPropagation()
    e?.preventDefault()
    
  render: (icon) ->
    @html @template icon
    
  fetchAll: ->
    Photo.fetch(null, clear:true)
    Product.fetch(null, clear:true)
    Category.fetch(null, clear:true)
    Description.fetch(null, clear:true)
    

module?.exports = RefreshView