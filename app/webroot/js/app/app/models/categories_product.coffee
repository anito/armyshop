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
  
  @mixinAttributes: ['ignored', 'order']
  
  @productExists: (aid, gid) ->
    gas = @filter true,
      product_id: aid
      category_id: gid
      func: 'selectUnique'
    gas.first() or !!gas.length
    
  @categories: (aid) ->
    Category.filterRelated(aid,
      model: 'Product'
      sort: 'sortByOrder'
    )
    
  @products: (gid) ->
    Product.filterRelated(gid,
      model: 'Category'
      sort: 'sortByOrder'
    )
      
  @publishedProducts: (gid=Category.record?.id) ->
    @filter(gid, {associationForeignKey: 'category_id', func: 'selectNotIgnored'})
      
  @publishedProductsAll: (gid=Category.record?.id) ->
    @filter(gid, {associationForeignKey: 'category_id', func: 'selectNotIgnoredAll'})
      
  @unpublishedProducts: (gid=Category.record?.id) ->
    @filter(gid, {associationForeignKey: 'category_id', func: 'selectIgnored'})
      
  @otherProducts: (gid=Category.record?.id) ->
    @filter(gid, {associationForeignKey: 'category_id', func: 'selectOthers'})
      
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
    ret = []
    gas = @filter(gid, {associationForeignKey: 'category_id', func: 'selectNotIgnored'})
    ret.push ga for ga in gas when (ga.product_id is aid) and (!ga.ignored)
    !!ret.length
    
  @c: 0
  
  validate: ->
    valid_1 = (Product.find @product_id) and (Category.find @category_id)
    valid_2 = !(@constructor.productExists(@product_id, @category_id) and @isNew())
    return 'Ungültige Aktion!' unless valid_1
    ret2 = (p) -> 'Produkt ' + p.title + ' existiert bereits in dieser Kategorie'
    return ret2(Product.find(@product_id)) unless valid_2
    false
    
  mixinAttributes: ->
    result = {}
    result[attr] = @[attr] for attr in @constructor.mixinAttributes
    result
    
  categories: ->
    @constructor.categories @product_id
      
  products: ->
    @constructor.products @category_id
      
  allCategoryProducts: =>
    category = Category.record
    return unless category
    products = []
    gas = @constructor.filter(category.id, associationForeignKey:'category_id')
    for ga in gas
      products.push Product.find(ga.product_id) if Product.exists(ga.product_id)
    products
      
  isActiveProduct: (aid) ->
    @constructor.isActiveProduct @category_id, aid
      
  select: (id, options) ->
    return true if @[options.associationForeignKey] is id
    
  selectProduct: (id, gid) ->
    return true if @product_id is id and @category_id is Category.record.id
    
  selectUnique: (query, options) ->
    return true if (@product_id is options.product_id) and (@category_id is options.category_id)
    
  selectNotIgnored: (id, opts) ->
    return true if !@ignored and (@category_id is id) and @isProtectedModel(Category.find(@category_id)?.name)
    
  selectNotIgnoredAll: (id) ->
    return true if (!@ignored) and (@isProtectedModel(Category.find(@category_id)?.name))
    
  selectIgnored: (id) ->
    return true if @ignored and @isProtectedModel(Category.find(@category_id)?.name)
    
  selectOthers: (id) ->
    return true if !@isProtectedModel(Category.find(@category_id)?.name)
    
module.exports = Model.CategoriesProduct = CategoriesProduct