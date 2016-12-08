Spine       = require("spine")
$           = Spine.$
Controller  = Spine.Controller

require('extensions/controller_extender')

Controller.PhotoExtender =
  
  extended: ->
    
    Extend = 
    
      empty: ->
        @log 'empty'
        @constructor.apply @, arguments
        
    Include = 
    
      updateTemplate: (item) ->
        el = @children().forItem(item)
        tb = $('.thumbnail', el)

        css = tb.attr('style')
        active = el.hasClass('active')
        hot = el.hasClass('hot')

        tmplItem = el.tmplItem()
        tmplItem.data = item
        tmplItem.update()

        el = @children().forItem(item)
        tb = $('.thumbnail', el)

        tb.attr('style', css).addClass('in')
        el.toggleClass('active', active)
        el.toggleClass('hot', hot)
        @el.sortable('destroy').sortable('photos')
        tmplItem

      callback: (json) ->
        result = for jsn in json
          ret = for key, val of jsn
            src: val.src
            id: key
          ret[0]

        for res in result
          @snap(res)

      snap: (res) ->
        el = $('#'+res.id, @el)
        thumb = $('.thumbnail', el)
        img = @createImage()
        img.element = el
        img.thumb = thumb
        img.me = @
        img.res = res
        img.onload = @onLoad
        img.onerror = @onError
        img.src = res.src

      onLoad: ->
        @me.log 'image loaded'
        css = 'url(' + @src + ')'
        @thumb.css
          'backgroundImage': css
          'backgroundSize': '100% auto'
        @thumb.addClass('in')

      onError: (e) ->
        console.log 'could not load image, trying again'
        @onload = null#@me.snap @res
        @onerror = null

      size: (val, bg='none') ->
        # 2*10 = border radius
        thumb = $('.thumbnail', @el)
        thumb.css
          'height'          : val+'px'
          'width'           : val+'px'
          'backgroundSize'  : bg
      
    @extend Extend
    @include Include
    
module?.exports = Controller.PhotoExtender