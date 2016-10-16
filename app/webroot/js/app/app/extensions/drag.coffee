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
        event = e.originalEvent
        el = $(e.target)
        
        #cancel all drag events for no-data-elements
        unless record = el.item()
          e.stopPropagation()
          e.preventDefault()
          return
          
        parentEl = el.parents('.data')
        parentModel = parentEl.data('tmplItem')?.data.constructor or parentEl.data('current')?.model
        parentRecord = parentEl.data('tmplItem')?.data or parentModel?.record# or parentModel
        
        
        Spine.DragItem = SpineDragItem.first()
        Spine.DragItem.updateAttributes
          el: el
          els: []
          source: record
          originModel: parentModel?.className
          originRecord: parentRecord
          selection: []
        
        @trigger('drag:help', e)
        @trigger('drag:start', e, @, record)
        
        parentEl.addClass('drag-in-progress')
        
        modelOrRecord = if rec = Spine.DragItem.originRecord then rec else Model[Spine.DragItem.originModel]
        if modelOrRecord
          data = []
          data.update modelOrRecord.selectionList() 
        else
          return
        
        event = e.originalEvent
        event.dataTransfer.effectAllowed = 'move'
        event.dataTransfer.setData('text/json', JSON.stringify(data));
        
        className = record.constructor.className
        return
        # don't use drag images
        switch className
          when 'Product'
            img = if data.length is 1 then App.ALBUM_SINGLE_MOVE else App.ALBUM_DOUBLE_MOVE
          when 'Photo'
            img = if data.length is 1 then App.IMAGE_SINGLE_MOVE else App.IMAGE_DOUBLE_MOVE
        event.dataTransfer?.setDragImage(img, 45, 60);

      dragenter: (e, data) ->
        func =  => @trigger('drag:timeout', e, Spine.timer)
        clearTimeout Spine.timer
        Spine.timer = setTimeout(func, 1000)
        @trigger('drag:enter', e, data)
        
      dragover: (e, data) ->
        event = e.originalEvent
        event.stopPropagation()
        event.preventDefault()
        @trigger('drag:over', e, @)

      dragleave: (e, data) ->
        @trigger('drag:leave', e, @)

      dragend: (e, data) ->
        $('.drag-in-progress').removeClass('drag-in-progress')
        @trigger('drag:end', e, data)

      drop: (e, data) ->
        @log 'drop'
        $('.drag-in-progress').removeClass('drag-in-progress')
        clearTimeout Spine.timer
        event = e.originalEvent
        data = event.dataTransfer.getData('text/json');
        try
          data = JSON.parse(data)
        catch e
        @trigger('drag:drop', e, data)
        event = e.originalEvent
        
      # helper methods
        
      dragHelp: (e, item, origin) ->
        Spine.DragItem = SpineDragItem.first()
        selection = []
        modelOrRecord = if rec = Spine.DragItem.originRecord then rec else Model[Spine.DragItem.originModel]
        selection.update modelOrRecord.selectionList()[..]
#        if modelOrRecord.selectionList().indexOf(Spine.DragItem.source.id) is -1
#          Spine.DragItem.selected = true
#          Spine.DragItem.save()
#          selection.add Spine.DragItem.source.id
#          Model[Spine.DragItem.originModel].updateSelection selection, Spine.DragItem.originRecord?.id, trigger: false
        
      dragStart: (e, controller, record) ->
        @log 'dragStart'
        Spine.DragItem = SpineDragItem.first()
        el = $(e.currentTarget)
        event = e.originalEvent
        source = Spine.DragItem.source
        selection = []
        unless source
          alert 'no source'
          return
        # check for drags from sublist and set its origin
        if el.parents('#sidebar').length
          originEl = el.parents('.gal.data')
          selection.update Spine.DragItem.originRecord.selectionList()[..]
        else
          switch source.constructor.className
            when 'Product'
              selection.update Category.selectionList()[..]
            when 'Photo'
              selection.update Product.selectionList()[..]
        
        Spine.DragItem.selection = selection[..]
        Spine.DragItem.save()
        
      dragEnter: (e) ->
        Spine.DragItem = SpineDragItem.first()
        return unless Spine.DragItem
        el = indicator = $(e.target).closest('.data')
        selector = el.attr('data-drag-over')
        if selector then indicator = el.children('.'+selector)
        
        target = Spine.DragItem.target = el.data('tmplItem')?.data or el.data('current')?.model.record
        source = Spine.DragItem.source
        origin = Spine.DragItem.originRecord
        
        Spine.DragItem.closest?.removeClass('over nodrop')
        Spine.DragItem.closest = indicator
        
        Spine.DragItem.save()
        
        if @validateDrop target, source, origin
          Spine.DragItem.closest.addClass('over')
        else
          Spine.DragItem.closest.addClass('over nodrop')
          

      dragOver: (e) =>

      dragLeave: (e) =>

      dragEnd: (e) =>
        Spine.DragItem = SpineDragItem.first()
        Spine.DragItem.closest?.removeClass('over nodrop')

      dragDrop: (e, record) ->
        Spine.DragItem = SpineDragItem.first()
        target = Spine.DragItem.target
        source = Spine.DragItem.source
        origin = Spine.DragItem.originRecord
        
        return unless source or target or source
        
        Spine.DragItem.closest?.removeClass('over nodrop')
        try
          unless @validateDrop target, source, origin
            @clearHelper()
            return
          hash = location.hash
          switch source.constructor.className
            when 'Product'
              selection = Spine.DragItem.selection
              Product.trigger('destroy:join', Product.toRecords(selection), origin) unless @isCtrlClick(e)# and origin
              Product.trigger('create:join', Product.toRecords(selection), target, => )#@navigate hash)

            when 'Photo'
              selection = Spine.DragItem.selection
              photos = Photo.toRecords(selection)

              Photo.trigger 'create:join',
                photos: photos
                product: target
              , => @navigate hash

              unless @isCtrlClick(e)
                Photo.trigger 'destroy:join',
                  photos: photos
                  product: origin
          
        catch e
        
        @clearHelper()
                
      clearHelper: ->
        modelOrRecord = if rec = Spine.DragItem.originRecord then rec else Model[Spine.DragItem.originModel]
        if Spine.DragItem.source and Spine.DragItem.selected
          list = Model[Spine.DragItem.originModel].removeFromSelection(Spine.DragItem.originRecord?.id, Spine.DragItem.source.id, trigger: false)
          Spine.DragItem.selected = false
          Spine.DragItem.save()
        
      validateDrop: (target, source, origin) =>
        return true unless target and source
        return true if target.eql source
        switch source.constructor.className
          when 'Product'
            unless target.constructor.className is 'Category'
              return false
            unless (origin.id != target.id)
              return false

            items = CategoriesProduct.filter(target.id, associationForeignKey: 'category_id')
            for item in items
              if item.product_id is source.id
                return false
            return true
          when 'Photo'
            unless target.constructor.className is 'Product'
              return false
            unless (origin.id != target.id)
              return false

            items = ProductsPhoto.filter(target.id, associationForeignKey: 'product_id')
            for item in items
              if item.photo_id is source.id
                return false
            return true
          
          else return false
          
    @include Include

module?.exports = Drag = Controller.Drag