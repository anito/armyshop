Spine           = require("spine")
$               = Spine.$
Model           = Spine.Model
Filter          = require("extensions/filter")
Category         = require('models/category')
Model.Product     = require('models/product')
Model.Photo     = require('models/photo')
CategoriesProduct  = require('models/categories_product')
Selector        = require("extensions/selector")
Extender        = require("extensions/model_extender")

require("spine/lib/ajax")

class ProductsPhoto extends Spine.Model

  @configure "ProductsPhoto", 'id', 'cid', 'product_id', 'photo_id', 'order'

  @extend Model.Ajax
  @extend Filter
  @extend Selector
  @extend Extender
  
  @url: 'products_photos'
  
  @productPhotoExists: (pid, aid) ->
    aps = @filter 'placeholder',
      photo_id: pid
      product_id: aid
      func: 'selectUnique'
    aps[0] or false
    
  @productsPhotos: (aid) ->
    aps = @filter aid, key: 'product_id'
    
  @productPhotos: (aid) ->
    ret = []
    @each (item) ->
      ret.push photo if item['product_id'] is aid and photo = Photo.find(item['photo_id'])
    ret
    
  @photos: (aid, max) ->
    Photo.filterRelated(aid,
      model: 'Product'
      key: 'product_id'
      sorted: 'sortByOrder'
    ).slice(0, max)
    
  @products: (pid, max) ->
    Product.filterRelated(pid,
      model: 'Photo'
      key: 'photo_id'
      sorted: 'sortByOrder'
    ).slice(0, max)

  @c: 0

  validate: ->
    valid_1 = (Product.find @product_id) and (Photo.find @photo_id)
    valid_2 = !(ap = @constructor.productPhotoExists(@photo_id, @product_id) and @isNew())
    return 'No valid action!' unless valid_1
    return 'Photo already exists in Product' unless valid_2

  products: ->
    @constructor.products @photo_id
    
  photos: ->
    @constructor.photos @product_id

  allProductPhotos: =>
    product = Product.record
    return unless product
    photos = []
    aps = ProductsPhoto.filter(product.id, key:'product_id')
    for ap in aps
      photos.push Photo.find(ap.product_id) if Photo.exists(ap.product_id)
    photos

  select: (id, options) ->
    return true if @[options.key] is id
    
  selectPhoto: (id) ->
    return true if @photo_id is id and @product_id is Product.record.id
    
  selectUnique: (empty, options) ->
    return true if @product_id is options.product_id and @photo_id is options.photo_id

module.exports = Model.ProductsPhoto = ProductsPhoto