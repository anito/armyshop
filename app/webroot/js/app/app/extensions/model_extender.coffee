
Spine                 = require("spine")
$                     = Spine.$
Model                 = Spine.Model
Log                   = Spine.Log

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

      
      selectAttributes: []
      
      isArray: (value) ->
        Object::toString.call(value) is "[object Array]"

      isObject: (value) ->
        Object::toString.call(value) is "[object Object]"
        
      isString: (value) ->
        Object::toString.call(value) is "[object String]"

      selected: ->
        @record
        
      toID: (records = @records) ->
        record.id for record in records
      
      toRecords: (ids = []) ->
        @find id for id in ids
      
      successHandler: (data, status, xhr) ->
        
      errorHandler: (record, xhr, statusText, error) ->
        status = xhr.status
        unless status is 200
          error = new SpineError
            record      : record
            xhr         : xhr
            statusText  : statusText
            error       : error

          error.save()
          User.redirect 'users/login'
          
      customErrorHandler: (record, xhr) ->
        status = xhr.status
        unless status is 200
          error = new Error
            flash       : '<strong style="color:red">Login failed</strong>'
            xhr         : xhr

          error.save()
          
    Include =
      
      trace: !Spine.isProduction
      logPrefix: @className + '::'
      
    @include Log
    @extend Log
    @extend Extend
    @include Include

module?.exports = Model.Extender