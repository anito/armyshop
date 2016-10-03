Spine                 = require("spine")
$                     = Spine.$
Model                 = Spine.Model
User                  = require('models/user')
Photo                 = require('models/photo')
CategoriesProduct     = require('models/categories_product')
ProductsPhoto         = require('models/products_photo')
Filter                = require("extensions/filter")
AjaxRelations         = require("extensions/ajax_relations")
Uri                   = require("extensions/uri")
Extender              = require("extensions/model_extender")
require("spine/lib/ajax")

class Category extends Spine.Model

  @configure 'Category', 'id', 'cid', 'name', "photo", 'user_id'

  @extend Filter
  @extend Model.Ajax
  @extend AjaxRelations
  @extend Uri
  @extend Extender

  @selectAttributes: ['name']
  
  @parent: 'Root'
  
  @childType: 'Product'
  
  @url: '' + base_url + 'categories'

  @fromJSON: (objects) ->
    super
    @createJoinTables objects
    key = @className
    json = @make(objects, key) #if Array.isArray(objects)# and objects[key]#test for READ or PUT !
    json

  @foreignModels: ->
    'Product':
      className             : 'Product'
      joinTable             : 'CategoriesProduct'
      foreignKey            : 'category_id'
      associationForeignKey : 'product_id'
    
  @contains: (id=@record.id) ->
    return Product.all() unless id
    @products id
    
  @products: (id) ->
    filterOptions =
      model: 'Category'
      key:'category_id'
    Product.filterRelated(id, filterOptions)

  @selectedProductsHasPhotos: ->
    products = Product.toRecords @selectionList()
    for alb in products
      return true if alb.contains().length
    false
  
  @activePhotos: (id = @record?.id) ->
    ret = []
    if id
      gas = CategoriesProduct.filter(id, {key: 'category_id', func: 'selectNotIgnored'})
      search = 'product_id'
    else
      ids = Category.selectionList()
      gas = Product.toRecords(ids)
      search = 'id'
    for ga in gas
      product = Product.find ga[search]
      photos = product.photos() or []
      ret.push pho for pho in photos
    ret
    
  @details: =>
    return @record.details() if @record
    products = Product.all()
    imagesCount = 0
    for product in products
      imagesCount += product.count = ProductsPhoto.filter(product.id, key: 'product_id').length
    
    $().extend @defaultDetails,
      gCount: Category.count()
      iCount: imagesCount
      aCount: products.length
      sCount: Category.selectionList().length
      author: User.first().name
    
  
  init: (instance) ->
    return unless id = instance.id
    s = new Object()
    s[id] = []
    @constructor.selection.push s
    
  activePhotos: ->
    @constructor.activePhotos(@id)
    
  details: =>
    products = Category.products(@id)
    imagesCount = 0
    for product in products
      imagesCount += product.count = ProductsPhoto.filter(product.id, key: 'product_id').length
    $().extend @defaultDetails,
      name: @name
      iCount: imagesCount
      aCount: products.length
      pCount: @activePhotos().length
      sCount: Category.selectionList().length
      author: User.first().name
    
  count_: (inc = 0) ->
    filterOptions =
      model: 'Category'
      key:'category_id'
    Product.filterRelated(@id, filterOptions).length + inc
    
  count: (inc = 0) ->
    @constructor.contains(@id).length + inc
    
  products: ->
    @constructor.products @id
    
  updateAttributes: (atts, options={}) ->
    @load(atts)
    @save()
  
  updateAttribute: (name, value, options={}) ->
    @[name] = value
    @save()

  selectAttributes: ->
    result = {}
    result[attr] = @[attr] for attr in @constructor.selectAttributes
    result

  select: (joinTableItems) ->
    for record in joinTableItems
      return true if record.category_id is @id
    
  select_: (joinTableItems) ->
    return true if @id in joinTableItems
    
module?.exports = Model.Category = Category