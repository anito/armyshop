Spine     = require("spine")
$         = Spine.$
Product     = require("models/product")
Settings  = require("models/settings")

class UploadEditView extends Spine.Controller

  elements:
    '.delete:not(.files .delete)' : 'clearEl'
    '.files'                      : 'filesEl'
    '.uploadinfo'                 : 'uploadinfoEl'

  events:
    'fileuploaddone'              : 'done'
    'fileuploadsubmit'            : 'submit'
    'fileuploadfail'              : 'fail'
#    'fileuploaddrop'              : 'drop'
    'fileuploadadd'               : 'add'
#    'fileuploadpaste'             : 'paste'
    'fileuploadsend'              : 'send'
    'fileuploadprogressall'       : 'alldone'
    'fileuploadprogress'          : 'progress'
    'fileuploaddestroyed'         : 'destroyed'
    
  template: (item) ->
    $('#template-upload').tmpl item
    
  constructor: ->
    super
    @bind('active', @proxy @active)
    Product.bind('change:current', @proxy @changeDataLink)
    @data = fileslist: [link: false]
    @queue = []
    
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
    
  destroyed: ->
    
  fail: (e, data) ->
    @log data.textStatus
    @log data.errorThrown
    product = Product.find(@data.link)
    Spine.trigger('loading:fail', product, data.errorThrown)
      
  drop: (e, data) ->

  add: (e, data) ->
    @data.fileslist.push file for file in data.files
    
    @trigger('active')
    if !Settings.isAutoUpload()
      App.showView.openView()
      
    @clearEl.click()
        
  notify: ->
    App.modal2ButtonView.show
      header: 'No Product selected'
      body: 'Please select an product .'
      info: ''
      button_1_text: 'Hallo'
      button_2_text: 'Bye'
        
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
      options = $().extend {},
        photos: photos
        product: product
      
      Photo.trigger('create:join', options)
#      @navigate '/category', Category.record?.id or '', product.id
    else
      Photo.trigger('created', photos)
      @navigate '/category', Category.record?.id or '', ''
      
    Spine.trigger('loading:done', product)
    selection = photos.toId()
    Product.updateSelection(selection)
    
    e.preventDefault()
    
  progress: (e, data) ->
    
  paste: (e, data) ->
    @log 'paste'
    @drop(e, data) if data.files.length
    
  submit: (e, data) ->
    
  changedSelected: (product) ->
    product = Product.find(product.id)
    if @data.fileslist.length
      $.extend @data, link: Product.record?.id
        
module?.exports = UploadEditView