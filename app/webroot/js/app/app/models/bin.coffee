Spine             = require("spine")
$                 = Spine.$
Model             = Spine.Model
ProductsTrash     = require('models/products_trash')
Filter            = require("extensions/filter")
Extender          = require("extensions/model_extender")

class Bin extends Spine.Model

  @configure "Bin", 'id', 'title'

  @extend Filter
  @extend Extender

  @selectAttributes: ['title']
  
  details: =>
    $().extend @defaultDetails,
      iCount : @photos().length
      sCount : Product.selectionList().length
      product: Product.record
      category: Category.record
      
module?.exports = Model.Bin = Bin