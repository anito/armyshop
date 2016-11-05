Spine       = require("spine")
$           = Spine.$
Controller  = Spine.Controller

Controller.ProductExtender =
  
  extended: ->
    
    Extend = 
    
      empty: ->
        @log 'empty'
        @constructor.apply @, arguments
        
    Include = 
    
      renderBackgrounds: (products=[]) ->
        @log 'renderBackgrounds'
        console.log products
#        return unless @parent.isActive()
        deferredProcess = (product) =>
          @log 'deferredProcess'
          deferred = $.Deferred()
          all = product.photos()
          n = if (n = all.length) is 1 then n else 4
          single = !!(n is 1)
          args = if single then [140, 140] else [68, 68]
          sorted = all.sort Photo.sortByReverseOrder
          data = sorted.slice(0, n)
          product.single = single

          @callDeferred data, @uriSettings(args...), (xhr) -> deferred.resolve(xhr, product)
#          @callDeferred data, product.to, (xhr) -> deferred.resolve(xhr, product)

          deferred.promise()
          
        products = [products] unless Array.isArray(products)
        for product in products
          console.log product
          $.when(deferredProcess(product)).done (xhr, rec) =>
            @callback xhr, rec

      callback: (json, product) ->
        el = $('[data-id='+product?.id+']', @el)
        thumb = $('.thumbnail', el)
        
        sources = []
        css = []
        cssdefault = []
        for jsn in json
          for key, val of jsn
            sources.push src if src = val.src
            css.push 'url('+src+')'
            cssdefault.push 'url(/img/ajax-loader-product-thumbs.gif)'
        
        
        if sources.length
          thumb.addClass('load')
          thumb.css('backgroundImage', c for c in cssdefault)
          @snap product, thumb, src, css for src in sources
        else
          thumb.css('backgroundImage', ['url(/img/drag_info.png)'])

      snap: (rec, el, src, css) ->
        img = @createImage()
        img.el = el
        img.single = rec.single
        img.me = @
        img.css = css
        img.src = src
        img.onload = @onLoad
        img.onerror = @onError

      onLoad: ->
        @me.log 'image loaded'
        @el.removeClass('load')
        @el.addClass('single') if @single
        @el.css('backgroundImage', @css)

      onError: (e) ->
        @me.snap @res
        
      updateTemplate: (item) ->
        @log 'updateTemplate'
        return if item.destroyed or item.deleted
        item = @mixinOne item
        
        itemEl = @children().forItem(item)
        active = itemEl.hasClass('active')
        hot = itemEl.hasClass('hot')
        innerEl = $('.thumbnail', itemEl)
        style = innerEl.attr('style')


        tmplItem = innerEl.tmplItem()
        tmplItem.data = item
        tmplItem.update?()

        itemEl.attr('id', item.id)
        itemEl.toggleClass('active', active)
        itemEl.toggleClass('hot', hot)
        innerEl.attr('style', style)
        
        itemEl.toggleClass('ignored', item.ignored)

        @el.sortable()
        
    @extend Extend
    @include Include

module?.exports = Controller.ProductExtender