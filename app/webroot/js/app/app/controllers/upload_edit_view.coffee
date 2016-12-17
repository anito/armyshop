Spine     = require("spine")
$         = Spine.$
Product     = require("models/product")
Settings  = require("models/settings")
PhotoEditView = require("controllers/photo_edit_view")

class UploadEditView extends Spine.Controller

  elements:
    '.delete:not(.files .delete)' : 'clearEl'
    '#fileupload button.cancel'   : 'cancelEl'
    '.files'                      : 'filesEl'
    '.uploadinfo'                 : 'uploadinfoEl'
    '#ph'                         : 'photoEl'
    '.editor'                     : 'editorEl'
    '#fileupload'                 : 'uploader'

  events:
    'fileuploaddone'              : 'done'
    'fileuploadsubmit'            : 'submit'
    'fileuploadfail'              : 'fail'
    'fileuploaddrop'              : 'drop'
    'fileuploadadd'               : 'add'
#    'fileuploadpaste'             : 'paste'
    'fileuploadsend'              : 'send'
    'fileuploadprogressall'       : 'alldone'
    'fileuploadprogress'          : 'progress'
    'fileuploaddestroyed'         : 'destroyed'
    
    'click .opt-editor'           : 'toggleEditor'
    
  template: (item) ->
    $('#template-upload').tmpl item
    
  constructor: ->
    super
    @bind('active', @proxy @active)
    Product.bind('change:current', @proxy @changeDataLink)
    @data = fileslist: [link: false]
    @queue = []
    
    @editor = new PhotoEditView
      el: @photoEl
      
    @editor.change()
    
  changeDataLink: (product) ->
    @data.link = product?.id
    
  change: (item) ->
    @render()
    
  active: ->
    
  render: ->
    selection = Category.selectionList()
    category = Category.record
    @product = Product.find(selection[0]) || false
    @uploadinfoEl.html @template
      category: category
      product: @product
    @refreshElements()
    @el
    
  setAutoupload: (b) ->
    @uploader.fileupload('option', 'autoUpload', b)
    
  getAutoupload: ->
    @uploader.fileupload('option', 'autoUpload')
    
  destroyed: ->
    
    
  fail: (e, data) ->
    @log data.textStatus
    @log data.errorThrown
    product = Product.find(@data.link)
    Spine.trigger('loading:fail', product, data.errorThrown)
      
  drop: (e, data) ->

  add: (e, data) ->
    @trigger('active')
    @clearEl.click()
    
    @parent.toggleAutoUpload(true)
    unless @checkSelected(data)
      @cancelUpload(e, data)
      return
      
    @data.fileslist.push file for file in data.files
    
        
  checkSelected: (data) ->
    valid = -> !!Category.selectionList().length
    auto = if @getAutoupload() then '' else 'nicht'
    
    unless valid()
      multiple = (data.files.length > 1)
      str = if multiple then 'Sollen die Fotos ' else 'Soll das Foto '
#      b = confirm('Es ist kein Produkt ausgewählt!\n'+str+'im Foto-Katalog abgelegt werden?')
      App.confirm('NO_CAT_FOR_UPLOAD', null, 'alert')
      return false
      
    return true
        
  cancelUpload: (e, data) ->
    @autoupload = @getAutoupload()
    if @autoupload then @parent.toggleAutoUpload(false)
        
    @jqXHR(data).abort()
    
    $('button.cancel', '#fileupload').click( => @jqXHR(data).abort() )
  
  jqXHR: (data) ->
    @uploader.fileupload('send', data)
      .error (jqXHR, textStatus, errorThrown) =>
        if (errorThrown is 'abort')
  #        if @autoupload then @setAutoupload(@autoupload)
          @log 'Foto Upload abgebrochen'
  
  submit: (e, data) ->
    $('button.cancel', @uploader).click( => @jqXHR(data).abort() )
    
  send: (e, data) ->
    product = Product.find(@data.link)
    Spine.trigger('loading:start', product)
    
  alldone: (e, data) ->
    
  done: (e, data) ->
    product = Product.find(@data.link)
    raws = $.parseJSON(data.jqXHR.responseText)
    
    photos = []
    photos.push new Photo(raw['Photo']).save(ajax: false) for raw in raws
    
    if product
      Photo.trigger('create:join', photos, product)
    else
      Photo.trigger('created', photos)
      @navigate '/category', Category.record?.id or '', ''
    
    console.log product
    Spine.trigger('loading:done', product)
    selection = photos.toId()
    Product.updateSelection(selection)
    
    if @autoupload then @parent.toggleAutoUpload(@autoupload)
    delete @autoupload
    
    e.preventDefault()
    
  progress: (e, data) ->
    
  paste: (e, data) ->
    @log 'paste'
    @drop(e, data) if data.files.length
    
  notify: ->
    App.modal2ButtonView.show
      header: 'No Product selected'
      body: 'Please select an product .'
      info: ''
      button_1_text: 'Hallo'
      button_2_text: 'Bye'
        
    
  changedSelected: (product) ->
    product = Product.find(product.id)
    if @data.fileslist.length
      $.extend @data, link: Product.record?.id
      
      
   #  ############ Editor #############
   
  toggleEditor: ->
    @editor.content.toggleClass('hide', !@isHidden())
    
  isHidden: ->
    @editor.content.hasClass('hide')
        
module?.exports = UploadEditView