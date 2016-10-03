Spine         = require("spine")
$             = Spine.$
Model         = Spine.Model
Filter        = require("extensions/filter")
Model.Category = require('models/category')
Model.Product   = require('models/product')
Photo         = require('models/photo')
ProductsPhoto   = require('models/products_photo')
Extender      = require("extensions/model_extender")

require("spine/lib/ajax")


class CategoriesProduct extends Spine.Model

  @configure "CategoriesProduct", 'id', 'cid', 'category_id', 'product_id', 'order', 'ignored'

  @extend Model.Ajax
  @extend Filter
  @extend Extender

  @url: 'categories_products'
  
  @categoryProductExists: (aid, gid) ->
    gas = @filter 'placeholder',
      product_id: aid
      category_id: gid
      func: 'selectUnique'
    gas[0] or false
    
  @categories: (aid) ->
    Category.filterRelated(aid,
      model: 'Product'
      key: 'product_id'
      sorted: 'sortByOrder'
    )
    
  @products: (gid) ->
    Product.filterRelated(gid,
      model: 'Category'
      key: 'category_id'
      sorted: 'sortByOrder'
    )
      
  @activeProducts: (gid) ->
    @filter(gid, {key: 'category_id', func: 'selectNotIgnored'})
      
  @inactiveProducts: (gid) ->
    @filter(gid, {key: 'category_id', func: 'selectIgnored'})
      
  @photos: (id) ->
    ret = []
    unless id
      @each (item) =>
        photos = ProductsPhoto.productPhotos item.product_id
        ret.push photo for photo in photos
    else
      products = @products id
      for product in products
        photos = ProductsPhoto.productPhotos product.id
        ret.push photo for photo in photos
    ret
      
  @isActiveProduct: (gid, aid) ->
    gas = @filter(gid, {key: 'category_id', func: 'selectNotIgnored'})
    for ga in gas
      return !ga.ignored if ga.product_id is aid
    return false
      
  @c: 0
  
  validate: ->
    valid_1 = (Product.find @product_id) and (Category.find @category_id)
    valid_2 = !(ga = @constructor.categoryProductExists(@product_id, @category_id) and @isNew())
    return 'No valid action!' unless valid_1
    return 'Product already exists in Category' unless valid_2
    false
    
  categories: ->
    @constructor.categories @product_id
      
  products: ->
    @constructor.products @category_id
      
  allCategoryProducts: =>
    category = Category.record
    return unless category
    products = []
    gas = CategoriesProduct.filter(category.id, key:'category_id')
    for ga in gas
      products.push Product.find(ga.product_id) if Product.exists(ga.product_id)
    products
      
  isActiveProduct: (aid) ->
    @constructor.isActiveProduct @category_id, aid
      
  select: (id, options) ->
    return true if @[options.key] is id
    
  selectProduct: (id, gid) ->
    return true if @product_id is id and @category_id is Category.record.id
    
  selectUnique: (empty, options) ->
    return true if @product_id is options.product_id and @category_id is options.category_id
    
  selectNotIgnored: (id) ->
    return true if @category_id is id and @ignored is false
    
  selectIgnored: (id) ->
    return true if @category_id is id and @ignored is true
    
module.exports = Model.CategoriesProduct = CategoriesProduct