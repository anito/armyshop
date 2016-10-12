Spine         = require("spine")
$             = Spine.$
Model         = Spine.Model
Filter        = require("extensions/filter")
Category       = require('models/category')
Product         = require('models/product')
Clipboard     = require('models/clipboard')
ProductsPhoto   = require('models/products_photo')
Extender      = require("extensions/model_extender")
AjaxRelations = require("extensions/ajax_relations")
Uri           = require("extensions/uri")
Dev           = require("extensions/dev")
Cache         = require("extensions/cache")
require("spine/lib/ajax")

class Photo extends Spine.Model
  @configure "Photo", 'id', 'title', "photo", 'filesize', 'captured', 'exposure', "iso", 'longitude', 'aperture', 'software', 'model', 'order', 'user_id', 'active', 'src', 'selected'

  @extend Cache
  @extend Model.Ajax
  @extend Uri
  @extend Dev
  @extend AjaxRelations
  @extend Filter
  @extend Extender

  @selectAttributes: ['title', "photo", 'user_id']
  
  @parent: 'Product'
  
  @foreignModels: ->
    'Product':
      className             : 'Product'
      joinTable             : 'ProductsPhoto'
      foreignKey            : 'photo_id'
      associationForeignKey : 'product_id'

  @url: '' + base_url + @className.toLowerCase() + 's'

  @fromJSON: (objects) ->
    super
    @createJoinTables objects
    key = @className
    json = @make(objects, key) #if Array.isArray(objects)# and objects[key]#test for READ or PUT !
    json

  @nameSort: (a, b) ->
    aa = (a or '').name?.toLowerCase()
    bb = (b or '').name?.toLowerCase()
    return if aa == bb then 0 else if aa < bb then -1 else 1
  
  @defaults:
    width: 140
    height: 140
    square: 1
    quality: 70
  
  @success: (uri) =>
    @log 'success'
    Photo.trigger('uri', uri)
    
  @error: (json) =>
    Photo.trigger('ajaxError', json)
  
  @create: (atts) ->
    @__super__.constructor.create.call @, atts
  
  @refresh: (values, options = {}) ->
    @__super__.constructor.refresh.call @, values, options
    
  @trashed: ->
    res = []
    for item of @irecords
      res.push item unless ProductsPhoto.find(item.id)
    res
    
  @inactive: ->
    @findAllByAttribute('active', false)
    
  @activePhotos: -> [ @record ]
    
  @createJoin: (items=[], target, callback) ->
    unless Array.isArray items
      items = [items]

    return unless items.length
    isValid = true
    cb = ->
      Product.trigger('change:collection', target)
      if typeof callback is 'function'
        callback.call(@)
    
    items = items.toID()
    ret = for item in items
      ap = new ProductsPhoto
        product_id    : target.id
        photo_id    : item.id or item
        order       : parseInt(ProductsPhoto.photos(target.id).last()?.order)+1 or 0
      valid = ap.save
        validate: true
        ajax: false
      isValid = valid unless valid
      
    if isValid
      target.save(done: cb)
    else
      Spine.trigger('refresh:all')
    ret
    
  @destroyJoin: (items=[], target, cb) ->
    unless Array.isArray items
      items = [items]
      
    return unless items.length and target
    
    items = items.toID()
    for id in items
      aps = ProductsPhoto.filter(id, key: 'photo_id')
      ap = ProductsPhoto.productPhotoExists(id, target.id)
      ap.destroy(done: cb) if ap
      
    Product.trigger('change:collection', target)
      
  @products: (id) ->
    filterOptions =
      model: 'Photo'
      key:'photo_id'
      sort: 'sortByOrder'
    Product.filterRelated(id, filterOptions)
  
  init: (instance) ->
    return unless instance?.id
    @constructor.initCache instance.id
    
  parent: -> @constructor.parent
  
  createJoin: (target) ->
    @constructor.createJoin [@id], target
  
  destroyJoin: (target) ->
    @constructor.destroyJoin [@id], target
        
  products: ->
    @constructor.products @id
        
  selectAttributes: ->
    result = {}
    result[attr] = @[attr] for attr in @constructor.selectAttributes
    result

  select: (joinTableItems) ->
    for record in joinTableItems
      return true if record.photo_id is @id and (@['order'] = parseInt(record.order))?
      
  select_: (joinTableItems) ->
    return true if @id in joinTableItems
      
  selectPhoto: (id) ->
    return true if @id is id
      
  details: =>
    category : Model.Category.record
    product   : Model.Product.record
    photo   : Model.Photo.record
    author  : User.first().name

module?.exports = Model.Photo = Photo