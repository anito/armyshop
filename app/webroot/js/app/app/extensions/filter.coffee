Spine = require("spine")
$     = Spine.$
Model = Spine.Model

Filter =

  extended: ->

    extend =
      options:
        func: 'select'

      filter: (query, options) ->
        opts = $.extend({}, @options, options)
        return @all() unless query
        @select (item) ->
          item[opts.func] query, opts
          
      filterSortByOrder: (query, options) ->
        (@filter query, options).sort(@sortByOrder)
          
      filterRelated: (id, options) ->
        model = @foreignModels()[options.model]
        joinTableItems = Model[model.joinTable].filter(id, options)
        if sort = options?.sort
          (@filter joinTableItems).sort(@[sort])
        else
          @filter joinTableItems
          
      nameSort: (a, b) ->
        aa = (a or '').name?.toLowerCase()
        bb = (b or '').name?.toLowerCase()
        return if aa == bb then 0 else if aa < bb then -1 else 1
          
      sortByOrder: (a, b) ->
        aInt = parseInt(a.order)
        bInt = parseInt(b.order)
        if aInt < bInt then -1 else if aInt > bInt then 1 else 0

      sortByReverseOrder: (a, b) ->
        aInt = parseInt(a.order)
        bInt = parseInt(b.order)
        if aInt < bInt then 1 else if aInt > bInt then -1 else 0
          
      sortByScreenName: (a, b) ->
        a = a.screenname
        b = b.screenname
        if a < b then -1 else if a > b then 1 else 0

    include =
    
      select: (query) ->
        query = query?.toLowerCase()
        atts = (@selectAttributes or @attributes).apply @
        for key, value of atts
          value = value?.toLowerCase()
          unless (value?.indexOf(query) is -1)
            return true
        false

    @extend extend
    @include include


module?.exports = Model.Filter = Filter