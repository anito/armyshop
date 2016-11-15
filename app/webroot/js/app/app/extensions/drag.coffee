Spine = require("spine")
$     = Spine.$
Log   = Spine.Log
Category         = require('models/category')
Product           = require('models/product')
Photo           = require('models/photo')
ProductsPhoto     = require('models/products_photo')
CategoriesProduct  = require('models/categories_product')
SpineDragItem   = require('models/drag_item')

Controller = Spine.Controller

Controller.Drag =
  
  extended: ->
    
    Include =
        
      dragstart: (e) ->
        @log 'dragstart'
        event = e.originalEvent
        el = $(e.target)
        
        #cancel all drag events for no-data-elements
        unless record = el.item()
          e.stopPropagation()
          e.preventDefault()
          return
          
        parentEl = el.parents('.data')
        parentModel = parentEl.data('tmplItem')?.data.constructor or parentEl.data('modelName')
        parentRecord = parentEl.data('tmplItem')?.data or Model[parentModel].record# or parentModel
        
        Spine.dragItem.updateAttributes
          el: el
          els: []
          source: record
          sourceModelName: record.constructor.className
          sourceModelId: record.id
          originModel: Model[parentModel]
          originModelName: parentModel
          originRecord: parentRecord
          originRecordName: parentRecord.constructor.className
          originRecordId: parentRecord.id
          selection: []
          
        @trigger('drag:start', e, record)
        
        parentEl.addClass('drag-in-progress')
        model = Spine.dragItem.originRecord or Spine.dragItem.originModel
        source = Spine.dragItem.source
        
        selection = model.selectionList()[..]
        
        
        if selection.indexOf(id = source.id) is -1
          selection = [source.id]
          model.updateSelection selection
        
        Spine.dragItem.selection = selection
        Spine.dragItem.save()
        
        data = []
        data.push selection

        event = e.originalEvent
        event.dataTransfer.effectAllowed = 'move'
        event.dataTransfer.setData('text/json', JSON.stringify(data));
        
        # use drag images
        return unless App.useDragImage
        
        className = record.constructor.className
        switch className
          when 'Product'
            img = if data.length is 1 then App.ALBUM_SINGLE_MOVE else App.ALBUM_DOUBLE_MOVE
          when 'Photo'
            img = if data.length is 1 then App.IMAGE_SINGLE_MOVE else App.IMAGE_DOUBLE_MOVE
        event.dataTransfer?.setDragImage(img, 45, 60);

      dragenter: (e, data) ->
        @log 'enter'
        
        #cancel all drag events for no-data-elements
        unless Spine.dragItem.source
          e.stopPropagation()
          e.preventDefault()
          return
        
        event = e.originalEvent
#        event.stopPropagation()
        func =  => @trigger('drag:timeout', e, Spine.timer)
        clearTimeout Spine.timer
        Spine.timer = setTimeout(func, 1000)
        @trigger('drag:enter', e, data)
        false
        
      dragover: (e, data) ->
        e.stopPropagation()
        e.preventDefault()
        @trigger('drag:over', e, @)
        false

      dragleave: (e, data) ->
        @trigger('drag:leave', e, @)
        false

      dragend: (e, data) ->
        $('.drag-in-progress').removeClass('drag-in-progress')
        @trigger('drag:end', e, data)
        false

      drop: (e, data) ->
        
        @trigger('drag:drop', e, data)
        $('.drag-in-progress').removeClass('drag-in-progress')
        clearTimeout Spine.timer
        event = e.originalEvent
        data = event.dataTransfer.getData('text/json');
        try
          data = JSON.parse(data)
        catch e
        false
        
      dragStart: (e, record) ->
        
      dragEnter: (e) ->
        @log 'dragEnter'
        el = indicator = $(e.target).closest('.data')
        
        selector = el.attr('data-drag-over')
        if selector then indicator = el.children('.'+selector)
        
        target = t = Spine.dragItem.target = el.data('tmplItem')?.data or @model.record
        source = s = Spine.dragItem.source
        origin = o = Spine.dragItem.originRecord
#        console.log s
#        console.log o
        Spine.dragItem.closest?.removeClass('over nodrop')
        Spine.dragItem.closest = indicator
        if @validateDrop target, source, origin
          Spine.dragItem.closest.addClass('over')
        else
          Spine.dragItem.closest.addClass('over nodrop')
          
        Spine.dragItem.save()

      dragOver: (e) =>

      dragLeave: (e) =>

      dragEnd: (e) =>
        @log 'dragEnd'
        Spine.dragItem.closest?.removeClass('over nodrop')

      dragDrop: (e, record) ->
        # stops the browser from redirecting
        @log 'dragDrop'
        # prevent ui drops
        unless e.originalEvent.dataTransfer.files.length
          e.stopPropagation()
          e.preventDefault()

        # clean up placeholders, jquery-sortable-plugin sometimes leaves alone
        $('.sortable-placeholder').detach()
        
        
        target = Spine.dragItem.target
        source = Spine.dragItem.source
        origin = Spine.dragItem.originRecord #or Model[Spine.dragItem.originModelName].record
        
        return unless source or target or source
        
        Spine.dragItem.closest?.removeClass('over nodrop')
        
        unless @validateDrop target, source, origin, true
          return false
          
        hash = location.hash
        selection = Spine.dragItem.selection
        switch source.constructor.className
          when 'Product'
            cb = =>
              unless @isMeta(e)
                Product.trigger('destroy:join', Product.toRecords(selection), origin)
            Product.trigger('create:join', Product.toRecords(selection), target, cb)

          when 'Photo'
            photos = Photo.toRecords(selection)

            cb = => 
              unless @isMeta(e)
                Photo.trigger('destroy:join',
                  photos: photos
                  product: origin
                )
              @navigate hash

            Photo.trigger('create:join', photos, target, cb)
          
#        catch e
        
      validateDrop: (target, source, origin, alrt) =>
        tid = target?.id
        sid = source?.id
        oid = origin?.id
        return false unless (tid? and sid?) or (tid is sid)
        switch source.constructor.className
          when 'Product'
            if ['Category', 'ProductsTrash'].indexOf(target.constructor.className) is -1
              return false
            res2 = (oid is tid)
            if res2
              return false
            items = CategoriesProduct.filter(target.id, associationForeignKey: 'category_id')
            for item in items
              if item.product_id is source.id
                return false
            return true
            
          when 'Photo'
            unless target?.constructor.className is 'Product'
              return false
            if (oid is tid)
              return false

            items = ProductsPhoto.filter(target.id, associationForeignKey: 'product_id')
            for item in items
              if item.photo_id is sid
                return false
            return true
          
          else return false
          
    @include Include

module?.exports = Drag = Controller.Drag