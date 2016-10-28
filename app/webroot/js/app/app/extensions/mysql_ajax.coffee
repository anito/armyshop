Spine = require("spine")
$     = Spine.$

MysqlAjax =

  extended: ->

    extend =
    
      send: () ->

    include =
    
      mysql: (action, options) ->
        if typeof options?.done is 'function'
          @doneResponse = options.done
        if typeof options?.fail is 'function'
          @failResponse = options.fail
        
        @ajax action
    
      ajax: (action) ->
        $.ajax(
          url: '/mysql/' + action
        )
        .done(@doneResponse)
        .fail(@failResponse)

      doneResponse: (xhr, t) ->
        console.log xhr
        console.log t
      
      failResponse: (e) ->
        console.log e

    @extend extend
    @include include


module?.exports = MysqlAjax