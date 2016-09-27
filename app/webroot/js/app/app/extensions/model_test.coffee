Spine                 = require("spine")
$                     = Spine.$
Model                 = Spine.Model
Log                   = Spine.Log

Model.Model_Test =

  extended: ->

    Extend =
      
      print: -> alert 'Hi, this is a Test'
          
    @extend Extend

module?.exports = Model.Model_Test