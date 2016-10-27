Spine             = require("spine")
$                 = Spine.$
Model             = Spine.Model
CategoriesProduct = require('models/categories_product')
Clipboard         = require('models/clipboard')
AjaxRelations     = require("extensions/ajax_relations")
Uri               = require("extensions/uri")
Utils             = require("extensions/utils")
Filter            = require("extensions/filter")
Extender          = require("extensions/model_extender")
require("extensions/cache")
require("spine/lib/ajax")


class Product extends Spine.Model

  @configure "Product", 'id', 'cid', 'title', 'subtitle', 'link', 'notes', 'price', 'user_id', 'ignored', 'order', 'invalid', 'active', 'selected'

  @extend Model.Cache
  @extend Model.Ajax
  @extend Uri
  @extend Utils
  @extend AjaxRelations
  @extend Filter
  @extend Extender

  @selectAttributes: ['title', 'subtitle', 'notes', 'price']
  
  @parent: 'Category'
  
  @childType: 'Photo'
  
  @previousID: false

  @url: '' + base_url + @className.toLowerCase() + 's'

  @fromJSON: (objects) ->
    super
    @createJoinTables objects
    key = @className
    json = @make(objects, key) #if Array.isArray(objects)# and objects[key]#test for READ or PUT !
    json

  @nameSort: (a, b) ->
    aa = (a or '').title?.toLowerCase()
    bb = (b or '').title?.toLowerCase()
    return if aa == bb then 0 else if aa < bb then -1 else 1

  @foreignModels: ->
    'Category':
      className             : 'Category'
      joinTable             : 'CategoriesProduct'
      foreignKey            : 'product_id'
      associationForeignKey : 'category_id'
    'Photo':
      className             : 'Photo'
      joinTable             : 'ProductsPhoto'
      foreignKey            : 'product_id'
      associationForeignKey : 'photo_id'
    
  @contains: (id=@record.id) ->
    return Photo.all() unless id
    @photos id
    
  @photos: (id, max) ->
    filterOptions =
      model: 'Product'
      sort: 'sortByReverseOrder'
    ret = Photo.filterRelated(id, filterOptions)
    ret[0...max || ret.length]
    ret
    
  @descriptions: (id) ->
    Description.filterSortByOrder(id)
    
  @activePhotos: ->
    if id = @record.id
      return @photos(id)
    return @contains()
    
  @inactive: ->
    @findAllByAttribute('active', false)
    
  @createJoin: (items=[], target, callback) ->
    @log 'createJoin'
    unless Array.isArray items
      items = [items]
    
    return unless items.length and target
    isValid = true
    cb = ->
      Category.trigger('change:collection', target)
      if typeof callback is 'function'
        callback.call(@)
    
    ret = for item in items
      ga = new CategoriesProduct
        category_id  : target.id
        product_id   : item.id
        ignored      : true
        order        : parseInt(CategoriesProduct.products(target.id).last()?.order)+1 or 0
      valid = ga.save
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
    
    return unless target
    
    for item in items
      gas = CategoriesProduct.filter(item.id, associationForeignKey: 'product_id')
      ga = CategoriesProduct.categoryProductExists(item.id, target.id)
      ga?.destroy(done: cb)
      
    Category.trigger('change:collection', target)
      
  @throwWarning: ->
  
  @categorySelectionList: ->
    if Category.record and Product.record
      productId = Category.selectionList()[0]
      return Product.selectionList(productId)
    else# if Category.record and Category.selectionList().length
      return []
      
  @details: =>
    return @record.details() if @record
    $().extend @defaultDetails,
      iCount      : Photo.count()
      sCount      : Product.selectionList().length
      
  @findEmpties: ->
    ret = []
    @each (item) ->
      ret.push item unless item.photos().length
    ret
  
  @findRelated: (joins = [], joinid = '') ->
    record for join in joins when (record = @find(join[joinid])) and !!(typeof(record.order = join.order) and !!typeof(record.ignored = join.ignored))
      
  @unusedProducts: ->
    @filter(true, {func: 'selectUnused'})
      
  init: (instance) ->
    return unless id = instance.id
    s = new Object()
    s[id] = []
    @constructor.selection.push s
    
  parent: -> @constructor.parent
    
  selChange: (list) ->
  
  createJoin: (target) ->
    @constructor.createJoin [@], target
  
  destroyJoin: (target) ->
    @constructor.destroyJoin [@], target
        
  count: (inc = 0) =>
    @constructor.contains(@id).length + inc
  
  contains: ->
    @constructor.contains @id
  
  photos: (max) ->
    @constructor.photos @id, max
  
  descriptions: ->
    @constructor.descriptions @id
  
  details: =>
    $().extend @defaultDetails,
      iCount : @photos().length
      sCount : Product.selectionList().length
      product: Product.record
      category: Category.record
      ignored: CategoriesProduct.isActiveProduct(Category.record?.id, Product.record?.id)
  
  # loops over each record and make sure to set the copy property
  select: (joinTableItems) ->
    for record in joinTableItems
      return true if record.product_id is @id and (@prototype['order'] = parseInt(record.order))? and (@prototype['ignored'] = !!record.ignored )?
      
  select_: (joinTableItems) ->
    return true if @id in joinTableItems
      
  selectProduct: (id) ->
    return true if @id is id
    
  selectUnused: (id) ->
    return true unless CategoriesProduct.findByAttribute('product_id', @id)
      
module?.exports = Model.Product = Product