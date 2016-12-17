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

  @configure 'Category', 'id', 'cid', 'name', 'screenname', 'order', 'user_id', 'protected'

  @extend Filter
  @extend Model.Ajax
  @extend AjaxRelations
  @extend Uri
  @extend Extender

  @humanName: -> 'die Kategorie'
  @humanNames: -> 'die Kategorien'

  @selectAttributes: ['screenname']
  
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
    return Model[@childType].all() unless id
    @products id
    
  @products: (id) ->
    filterOptions =
      model: 'Category'
      sort: 'sortByOrder'
      
    Model[@childType].filterRelated(id, filterOptions)
    
  @product: (id, pid) ->
    filterOptions =
      model: 'Category'
    pros = @products id
    res = []
    res.push pro for pro in pros when pro.id is pid
    res[0]
    
  @publishedProducts: (id) ->
    filterOptions =
      func: 'selectNotIgnored'
    ret = []
    cps = CategoriesProduct.filterSortByOrder(id, filterOptions)
    ret.push Product.find(cp.product_id) for cp in cps
    ret

  @selectedProductsHasPhotos: ->
    products = Product.toRecords @selectionList()
    for alb in products
      return true if alb.contains()
    false
  
  @activePhotos: (id = @record?.id) ->
    ret = []
    if id
      gas = CategoriesProduct.filter(id, {associationForeignKey: 'category_id', func: 'selectNotIgnored'})
      search = 'product_id'
    else
      ids = Category.selectionList()
      gas = Product.toRecords(ids)
      search = 'id'
      
    for ga in gas
      product = Product.find(ga = CategoriesProduct.find(search))
      break unless product
      photos = product.photos() or []
      ret.push pho for pho in photos
    ret
    
  @details: =>
    return @record.details() if @record
    products = Product.all()
    imagesCount = 0
    for product in products
      imagesCount += product.count = ProductsPhoto.filter(product.id, associationForeignKey: 'product_id').length
    
    $().extend @defaultDetails,
      gCount: Category.count()
      iCount: imagesCount
      aCount: products.length
      sCount: Category.selectionList().length
      author: User.first().name
    
  @findRelated: (joins = [], joinid = '') ->
    record for join in joins when (record = @find(join[joinid]))
   
  @renderBuffer: (buffer) ->
    items = Category.filter()
    @buffer = items
   
  init: (instance) ->
    return unless id = instance.id
    prot = @isProtectedModel(instance.name)
    instance.protected = prot
    s = new Object()
    s[id] = []
    @constructor.selection.push s
    instance
    
  validate: ->
    valid = !(Category.protected[@name])
    return 'Geschützte Kategorie!' unless valid
    return false
    
  activePhotos: ->
    @constructor.activePhotos(@id)
    
  details: =>
    products = Category.products(@id)
    published = CategoriesProduct.publishedProducts(@id)
    imagesCount = 0
    for product in products
      imagesCount += product.count = ProductsPhoto.filter(product.id, associationForeignKey: 'product_id').length
    $().extend @defaultDetails,
      name: @name
      screenname: @screenname
      iCount: imagesCount
      aCount: products.length
      pCount: published.length
      sCount: Category.selectionList().length
      author: User.first().name
    
  count_: (inc = 0) ->
    filterOptions =
      model: 'Category'
      
    Product.filterRelated(@id, filterOptions).length + inc
    
  contains: (inc = 0) ->
    @constructor.contains(@id).length + inc
    
  products: ->
    @constructor.products @id
    
  updateAttributes: (atts, options={}) ->
    @load(atts)
    @save()
  
  updateAttribute: (name, value, options={}) ->
    @[name] = value
    @save()

  select: () ->
    
module?.exports = Model.Category = Category