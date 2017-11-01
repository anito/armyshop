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
        
        @model   = if modelName = @el.data('modelName') then Model[modelName] else @parent?.model
        @models  = if modelsName = @el.data('modelsName') then Model[modelsName] else @parent?.models

      p: -> App.sidebar.products  
      
      humanize: (arr) ->
        arr = [arr] unless Array.isArray arr
        throw 'nothing to humanize' unless arr.length
        record = arr[0]
        plural = arr.length > 1
        
        plural: plural
        length: arr.length
        type: record.constructor['humanName'+ if (p = plural) then 's' else '']()
        name: record.n()
      
      emptyMessage: (name) -> name
      
      followLink: (e) ->
        strWindowFeatures = "menubar=no,location=no,resizable=no,scrollbars=yes,status=no"
        window.open($(e.target).closest('a').attr('href'), 'new')
        e.preventDefault()
        e.stopPropagation()
        
      exposeSelection: (selection=@model?.selectionList() or @selectionList) ->
        @log 'exposing'
        @deselect()
        
        for id in selection
          el = $('#'+id, @el)
          el.addClass("active")

        if first = selection.first()
          $('#'+first, @el).addClass("hot")
        
      createImage: (url, onload) ->
        img = new Image()
        img.onload = onload if onload
        img.src = url if url
        img
        
      equals: (controller) ->
        c = @current?.model.className
        p = @previous?.model.className
        !!(c is p) and controller.eql()
        
      eql: ->
        rec = @model.record or Model.Root.first()
        prev = @current_record
        @current_record = rec
        !!(@current_record?.eql?(prev) and !!prev)
  
      rootID: ->
        @root_id = @root_id or Model.Root.uuid()
        
  
      activated: ->
  
      testEmpty: ->
        if @model.record
          unless @model.record.contains()
            @renderEmpty()
      
      renderEmpty: (s='nichts zu melden', element='el') ->
        info = '<label class="invite"><span class="enlightened">'+@emptyMessage(s)+'</span></label>'
        @[element].html $("#noSelectionTemplate").tmpl({type: info || ''})
        @el
  
      wipe: (item) ->
        if @model.record
          first = @model.record.contains() is 1
        @el.empty() if first
        @el
  
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

      isMeta: (e) ->
        e?.metaKey or e?.ctrlKey or e?.altKey

      children: (sel) ->
        @el.children(sel)
        
      find: (sel) ->
        @el.find(sel)

      remove: (item) ->
        els = @el.find('.items')
        el = els.children().forItem(item)
        return unless el.length
        
        el.addClass('fade').removeClass('show')
        f = ->
          el.detach()
          @trigger('detached', item)
        @delay f, 400

      deselect: (args...) ->
        @el.deselect(args...)
        
      clearSelection: (e) ->
        @select e, []
        
      getList: ->
        @selectionList?[..] or @model?.selectionList()[..]
        
      select: (e, ids=[], addRemove) ->
        list = @getList()
        ids = [ids] unless Array.isArray ids
        
#        addRemove = addRemove or !@isMeta(e)
        
        if addRemove 
          list.addRemove(ids)
        else
          list = ids[..]

        @selectionList = list[..] if @selectionList
        @trigger 'selected', list

      selectAll: (e) ->
        @select e, @all()
        e.stopPropagation()
    
      selectInv: (e) ->
        @select e, @all(), true
        e.stopPropagation()
        
      selected: (list) ->
        @model.updateSelection list
        
      all: ->
        root = $('.items', @el)
        
        return [] unless root.length
        
        items = root.children('.item')

        list = []
        items.each (index, el) ->
          item = $(@).item()
          list.unshift item.id
        list
        
      sortable: (type) ->
        @el.sortable type
        
      findModelElement: (item) ->
        @children().forItem(item, true)
        
      noMethod: (e) ->
        e.stopPropagation()
        e.preventDefault()
        
    @extend Extend
    @include Include

module?.exports = Controller.Extender