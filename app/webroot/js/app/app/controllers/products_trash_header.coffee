Spine           = require("spine")
$               = Spine.$
Category        = require('models/category')
Extender        = require('extensions/controller_extender')
ProductsTrash   = require('models/products_trash')

class ProductsTrashHeader extends Spine.Controller
  
  @extend Extender
  
  events:
    'click .opt-RecoverProductsTrash' : 'recover'
  
  template: (items) ->
    $("#headerProductTrashTemplate").tmpl items
  
  constructor: ->
    super
    @bind('active', @proxy @active)
    ProductsTrash.bind('change:selection', @proxy @change)

  change: (list) ->
    records = ProductsTrash.toRecords(list)
    @items = records
    @render records
    
  render: (items = []) ->
    @html @template {count:items.length}
    
  active: ->
    @render()
    
  recover: (e) ->
    ProductsTrash.trigger('recover', @items)
    
    e.stopPropagation()
    e.preventDefault()
    
module?.exports = ProductsTrashHeader