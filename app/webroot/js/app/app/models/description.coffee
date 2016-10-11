Spine                 = require("spine")
$                     = Spine.$
Model                 = Spine.Model
AjaxRelations         = require("extensions/ajax_relations")
Filter                = require("extensions/filter")
Extender              = require("extensions/model_extender")
require("spine/lib/ajax")

class Description extends Spine.Model

  @configure 'Description', 'id', 'cid', 'description', "product_id", 'user_id', 'order'

  @extend Filter
  @extend Model.Ajax
  @extend AjaxRelations
  @extend Extender

  @selectAttributes: ['description']
  
  @url: 'descriptions'
  
  @fromJSON: (objects) ->
    super
    key = @className
    json = @make(objects, key) #if Array.isArray(objects)# and objects[key]#test for READ or PUT !
    json
  
  select: (id) ->
    return true if @product_id is id #and @user_id is User.first().id
  
module?.exports = Model.Description = Description
