Spine = require("spine")
$     = Spine.$

Mysql_Ajax =

  extended: ->

    extend =
    
      ajax: (action) ->
        alert action
        return
        @log 'ajax'
        
        

    include =
    
      ajax: (action) ->
        $.ajax(
          url: '/mysql/' + action
        )
        .done(@doneResponse)
        .fail(@failResponse)

      doneResponse: (xhr, t) ->
        @log xhr
        @log t
      
      failResponse: (e) ->
        @log e

    @extend extend
    @include include


module?.exports = Mysql_Ajax