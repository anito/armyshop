Spine       = require("spine")
$           = Spine.$
Controller  = Spine.Controller

Controller.Extender =
  
  extended: ->
    
    Extend = 
    
      empty: ->
        @log 'empty'
        @constructor.apply @, arguments
        
        
    Include = 
    
      init: ->
        
        @trace = !Spine.isProduction
        @logPrefix = '(' + @constructor.name + ')'
        
        @model   = Model[@el.data('modelName')]
        @models  = Model[@el.data('modelsName')]

      p: -> App.sidebar.products  
      
      followLink: (e) ->
        strWindowFeatures = "menubar=no,location=no,resizable=no,scrollbars=yes,status=no"
        window.open($(e.target).closest('a').attr('href'), 'new')
        e.preventDefault()
        e.stopPropagation()
        
      exposeSelection: (selection=Category.selectionList(), id=Category.record?.id) ->
        if Category.record
          return unless Category.record.id is id
        @deselect()

        for id in selection
          el = $('#'+id, @el)
          el.addClass("active")

        if first = selection.first()
          $('#'+first, @el).addClass("hot")
        
        
      renderBackgrounds: (products) ->
        @log 'renderBackgrounds'
#        return unless @parent.isActive()
        
        processProduct = (product) =>
          @log 'processProduct'
          deferred = $.Deferred()
          all = product.photos()
          sorted = all.sort Photo.sortByReverseOrder
          data = sorted.slice(0, 4)

          @callDeferred data, @uriSettings(60, 60), (xhr) -> deferred.resolve(xhr, product)

          deferred.promise()
          
        products = [products] unless Array.isArray(products)
        for product in products
          $.when(processProduct(product)).done (xhr, rec) =>
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
          @snap thumb, src, css for src in sources
        else
          thumb.css('backgroundImage', ['url(/img/drag_info.png)'])

      snap: (el, src, css) ->
        img = @createImage()
        img.el = el
        img.me = @
        img.css = css
        img.src = src
        img.onload = @onLoad
        img.onerror = @onError

      onLoad: ->
        @me.log 'image loaded'
        @el.removeClass('load')
        @el.css('backgroundImage', @css)

      onError: (e) ->
        @me.log 'could not load image, trying again'
        @onload = @me.renderBackgrounds([Product.record])
        @onerror = null

        
      createImage: (url, onload) ->
        img = new Image()
        img.onload = onload if onload
        img.src = url if url
        img
        
      eql: (recordOrID) ->
        id = recordOrID?.id or recordOrID
        rec = Category.record
        prev = @current
        @current = rec
        same = !!(@current?.eql?(prev) and !!prev)
        same
  
      activated: ->
  
      focusFirstInput: (el=@el) ->
        return unless el
        $('input', el).first().focus().select() if el.is(':visible')
        el

      focus: ->
        @el.focus()

      panelIsActive: (controller) ->
        App[controller].isActive()
        
      openPanel: (controller) ->
        ui = App.vmanager.externalUI(App[controller])
        ui.click()

      closePanel: (controller, target) ->
        App[controller].activate()
        ui = App.vmanager.externalUI(App[controller])
        ui.click()

      isCtrlClick: (e) ->
        e?.metaKey or e?.ctrlKey or e?.altKey

      children: (sel) ->
        @el.children(sel)
        
      find: (sel) ->
        @el.find(sel)

      remove: (item) ->
        els = @el.find('.items')
        el = els.children().forItem(item)
        return unless el.length
        el.addClass('out').removeClass('in')
        f = -> el.detach()
        @delay f, 400

      deselect: (args...) ->
        @el.deselect(args...)

      sortable: (type) ->
        @el.sortable type
        
      findModelElement: (item) ->
        @children().forItem(item, true)
        
    @extend Extend
    @include Include

module?.exports = Controller.Extender