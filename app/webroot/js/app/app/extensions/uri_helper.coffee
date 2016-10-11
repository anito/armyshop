Spine = require("spine")
$     = Spine.$
Photo = require("models/photo")


UriHelper =

  extended: ->

    include =
    
      callDeferred: (items=[], cb) ->
        items = [items] unless Array.isArray(items)
          
        $.when(@uriDeferred(items)).done (xhr, rec) =>
          cb xhr, rec

      uriDeferred: (items) ->
        deferred = $.Deferred()

        Photo.uri @size(),
          (xhr, record) => deferred.resolve(xhr, items)
          items

        deferred.promise()
        
      size: (width, height) ->
        width: 200
        height: 200

    @include include


module?.exports = UriHelper