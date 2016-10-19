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
    aps = @filter aid, associationForeignKey: 'product_id'
    
  @productPhotos: (aid) ->
    ret = []
    @each (item) ->
      ret.push photo if item['product_id'] is aid and photo = Photo.find(item['photo_id'])
    ret
    
  @fromPhotoId: (photo_id) ->
    (@filter photo_id, func: 'selectByPhotoId')[0] || []
    
  @photos: (aid, max) ->
    func = Photo.filterRelated(aid,
      model: 'Product'
      sort: 'sortByOrder'
    ).slice(0, max)
    
  @products: (pid, max) ->
    Product.filterRelated(pid,
      model: 'Photo'
      sort: 'sortByOrder'
    ).slice(0, max)

  @c: 0

  validate: ->
    valid_1 = (Product.find @product_id) and (Photo.find @photo_id)
    valid_2 = !(ap = @constructor.productPhotoExists(@photo_id, @product_id) and @isNew())
    return 'Ungültige Aktion!' unless valid_1
    return 'Produkt existiert bereits in dieser Kategorie' unless valid_2
    false

  products: ->
    @constructor.products @photo_id
    
  photos: (id) ->
    @constructor.photos @product_id

  allProductPhotos: =>
    product = Product.record
    return unless product
    photos = []
    aps = ProductsPhoto.filter(product.id, associationForeignKey:'product_id')
    for ap in aps
      photos.push Photo.find(ap.product_id) if Photo.exists(ap.product_id)
    photos

  select: (id, options) ->
    return true if @[options.associationForeignKey] is id
    
  selectByPhotoId: (id) ->
    return true if @photo_id is id and @product_id is Product.record.id
    
  selectUnique: (empty, options) ->
    return true if @photo_id is options.photo_id and @product_id is options.product_id

module.exports = Model.ProductsPhoto = ProductsPhoto