Spine                     = require("spine")
$                         = Spine.$
Model                     = Spine.Model
Log                       = Spine.Log
Flash                     = require("models/flash")

Model.Extender =

  extended: ->

    Extend =
      
      trace: !Spine.isProduction
      logPrefix: '(' + @className + ')'
      
      
      guid: ->
        mask = [8, 4, 4, 4, 12]

        ret = []
        ret = for sub in mask
          res = null
          milli = new Date().getTime();
          back = new Date().setTime(milli*(-200))
          diff = milli - back
          re1 = diff.toString(16).split('')
          re2 = re1.slice(sub*(-1))
          re3 = re2.join('')
          re3

        re4 = ret.join('-')
        re4

      uuid: ->
        s4 = -> Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1)
        s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4()

      
      record: false

      selection: [global:[]]

      current: (recordOrID) ->
        id = recordOrID?.id or recordOrID
        rec = @find(id) or false
        prev = @record
        @record = rec
        same = !!(@record?.eql?(prev) and !!prev)
        Model[@className].trigger('current', @record, !same)
        if !same
          Model[@className].trigger('change:current', @record, @className) 
        @record

      selectionList: (recordID) ->
        ret = []
        id = recordID or @record?.id or @record?.cid
        return @selection[0].global unless id
        for item in @selection
          return item[id] if item[id]
        ret
      
      updateSelection: (list=@selectionList(), id, options) ->
        defaults = {trigger: true}
        option = $().extend defaults, options
        ret = @emptySelection id, list
        @trigger('change:selection', ret, id) if option.trigger
        Model[@childType]?.current(ret.first())
        ret

      emptySelection: (id, idOrList = []) ->
        unless @isArray idOrList
          idOrList = [idOrList]
        originalList = @selectionList(id)
        originalList[0...originalList.length] = idOrList
        originalList

      removeFromSelection: (id, idOrList=[], options) ->
        originalList = @selectionList(id)
        unless @isArray idOrList
          idOrList = [idOrList]
          
        for id in idOrList
          unless (index = originalList.indexOf(id)) is -1
            originalList.splice(index, 1)
          
        list = @updateSelection id, originalList.slice(0), options
        list

      isArray: (value) ->
        Object::toString.call(value) is "[object Array]"

      isObject: (value) ->
        Object::toString.call(value) is "[object Object]"
        
      isString: (value) ->
        Object::toString.call(value) is "[object String]"

      selected: ->
        @record
        
      toId: (records = @records) ->
        record.id for record in records
      
      toRecords: (ids = []) ->
        @find id for id in ids
      
      duplicate: (items, atts={}, options) ->
        unless Array.isArray(items)
          items = [items]
          
        ret = []
        ret = for item in items
          newItem = item.dup(true).save(options)
          newItem.updateAttributes(atts, options)
          newItem
        ret
      
      successHandler: (data, status, xhr) ->
        
      errorHandler: (record, xhr, statusText, error) ->
        status = xhr.status
        unless status is 200
          error = new Flash
            record      : record
            xhr         : xhr
            statusText  : statusText
            error       : error

          error.save()
#          User.redirect 'users/login'
          
      customErrorHandler: (record, xhr) ->
        status = xhr.status
        unless status is 200
          error = new Error
            flash       : '<strong style="color:red">Login failed</strong>'
            xhr         : xhr

          error.save()
          User.redirect 'users/login'
          
      contains: -> []
      
      createJoinTables: (arr) ->
        return unless @isArray arr
        joinTables = @joinTables()
        for key in joinTables
          Model[key].refresh(@createJoins(arr, key), clear: true)
        
      make: (arr, key) ->
        return new @(arr) if !Array.isArray arr
        new @(obj[key]) for obj in arr
        
      activePhotos: -> Category.activePhotos()
        
      # private
      
      joinTables: ->
        fModels = @foreignModels()
        joinTables = for key, value of fModels
          fModels[key]['joinTable']
        joinTables

      createJoins: (json, tableName) ->
        res = []
        introspect = (obj) =>
          if @isObject(obj)
            for key, val of obj
              if key is tableName
                res.push item for item in val
              else introspect obj[key]
          
          if @isArray(obj)
            for val in obj
              introspect val

        for obj in json
          introspect(obj)
        res
        
    Include =
      
      trace: !Spine.isProduction
      logPrefix: @className + '::'
      
      selectionList: ->
        @constructor.selectionList(@id)
      
      selectionParentList: ->
        modelName = @constructor['parent']
        try
          Model[modelName].selectionList()
        catch e
          return []
      
      updateSelectionID: ->
        for item, idx in @constructor.selection
          index = idx if item[@cid]
        @constructor.selection.splice(index, 1) if index
        @init @
        
      # removes itself from the list
      removeSelectionID: ->
        for _item, _idx in @constructor.selection
          _x = _idx if _item[@id]
        @constructor.selection.splice(_x, 1) if _x #remove selection object container
        
        modelName = @constructor['parent']
        return unless modelName
        
        list = Model[modelName].selection
        for __itm in list
          for __key, __val of __itm
             __val.splice(__x, 1) unless __x = __val.indexOf(@id) is -1 #remove all selection entries
      
      # removes items from the selectionList
      removeFromSelection: (list, options) ->
        @constructor.removeFromSelection(@id, list, options)
      
      updateSelection: (list=[], options) ->
        list = [list] unless @constructor.isArray list
        list = @constructor.updateSelection list, @id, options

      emptySelection: ->
        list = @constructor.emptySelection @id

      addRemoveSelection: (isMetaKey) ->
        originalList = @constructor.selectionList @id
        return unless originalList
        if isMetaKey
          @addUnique(originalList)
        else
          @toggleSelected(originalList)
        originalList
        
      addToSelection: (isMetaKey) ->
        originalList = @constructor.selectionList @id
        return unless originalList
        if isMetaKey
          @addUnique(originalList)
        else
          unless @id in originalList
            originalList.unshift @id
        originalList

      shiftSelection: ->
        originalList = @constructor.selectionList @id
        return unless originalList
        return originalList if index = originalList.indexOf(@id) is 0
        rm = originalList.splice(0, 1, originalList[index])
        originalList.splice(index, 1)
        originalList.push(rm[0])
        index = originalList.indexOf(@id)
        originalList
        

      #prevents an update if model hasn't changed
      updateChangedAttributes: (atts) ->
        @log 'updateChangedAttributes'
        invalid = false
        origAtts = @selectAttributes()
        for key, value of atts
          unless origAtts[key] is value
            invalid = yes
            @[key] = value

        @save() if invalid
        
      #private
      
      addUnique: (list) ->
        list[0...list.length] = [@id]
        list

      toggleSelected: (list) ->
        unless @id in list
          list.unshift @id
        else
          index = list.indexOf(@id)
          list.splice(index, 1) unless index is -1
        list
        
      searchSelect: (query) ->
        query = query.toLowerCase()
        atts = @selectAttributes.apply @
        for key, value of atts
          value = value.toLowerCase()
          unless (value?.indexOf(query) is -1)
            return true
        false
        
      idSelect: (query) ->
        query = query.toLowerCase()
        value = @id.toLowerCase()
        unless (value?.indexOf(query) is -1)
          return true
        false
        
      idExcludeSelect: (query) ->
        if (query.indexOf(@id) is -1)
          return true
        false
        
      defaultDetails:
        iCount: 0
        aCount: 0
        sCount: 0
        author: ''
        
        
    @include Log
    @extend Log
    @extend Extend
    @include Include

module?.exports = Model.Extender