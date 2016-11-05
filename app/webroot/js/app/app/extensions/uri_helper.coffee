Spine = require("spine")
$     = Spine.$
Photo = require("models/photo")

UriHelper =

  extended: ->

    include =
    
      callDeferred: (items=[], options, cb) ->
        options = $().extend @uriSettings(), options
        items = [items] unless Array.isArray(items)
          
        $.when(@uriDeferred(items, options)).done (xhr) =>
          cb xhr

      uriDeferred: (items, options) ->
        deferred = $.Deferred()

        Photo.uri options,
          (xhr) => deferred.resolve(xhr)
          items

        deferred.promise()
        
      cb: =>
      # defaultSettings
      uriSettings: (width=30, height=10, square=1, quality=70) ->
        width: width
        height: height
        square: square
        quality: quality
        
    @include include


module?.exports = UriHelper