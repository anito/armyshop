Spine = require("spine")
$     = Spine.$
Model = Spine.Model

class SpineDragItem extends Spine.Model

  @configure 'SpineDragItem', 'el', 'els', 'target', 'source', 'sourceModelName', 'sourceModelId', 'originModel', 'originModelName', 'originRecord', 'originRecordName', 'originRecordId', 'selection', 'selected', 'closest'
  
  init: ->

module?.exports = Model.SpineDragItem = SpineDragItem