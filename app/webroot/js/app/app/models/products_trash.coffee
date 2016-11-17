Spine             = require("spine")
$                 = Spine.$
Model             = Spine.Model
Extender          = require("extensions/model_extender")

class ProductsTrash extends Spine.Model

  @configure "ProductsTrash", 'id', 'location'

  @extend Extender
  
  @childType: 'Products'
  
  init: (instance) ->
    return unless id = instance.id
    
    
module?.exports = Model.ProductsTrash = ProductsTrash

