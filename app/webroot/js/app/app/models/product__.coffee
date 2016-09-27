Spine             = require("spine")
$                 = Spine.$
Model             = Spine.Model
Extender          = require("extensions/model_extender")
Test              = require("extensions/model_test")
require("spine/lib/ajax")


class Product extends Spine.Model

  @configure "Product", 'id', 'cid', 'title', 'price', 'user_id', 'order'

  @extend Model.Ajax
  @extend Extender
  @extend Test

      
module?.exports = Model.Product = Product

