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

  @configure "Product", 'id', 'cid', 'title', 'subtitle', 'link', 'notes', 'price', 'user_id', 'ignored', 'favorite', 'order', 'invalid', 'deleted', 'active', 'selected'

  @extend Model.Cache
  @extend Model.Ajax
  @extend Uri
  @extend Utils
  @extend AjaxRelations
  @extend Filter
  @extend Extender

  @humanName: -> 'das Produkt'
  @humanNames: -> 'die Produkte'

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
    return Model[@childType].all() unless id
    @photos id
    
  @photos: (id, max) ->
    max = if max <= 0 then 1 else max
    filterOptions =
      model: 'Product'
      sort: 'sortByReverseOrder'
    photos = Photo.filterRelated(id, filterOptions)
    ret = photos[0...max]
    ret
    
  @getFavoriteUrl: ->
    isAdmin = App.isAdmin()
    
    favorite = Product.findByAttribute('favorite', true)
    catPro = CategoriesProduct.findByAttribute('product_id', favorite?.id)
    cats = CategoriesProduct.categories favorite?.id
    catId = catPro?.category_id
    cat = Category.find(catId)
    
    if(isAdmin)
      unless favorite
        App.confirm('NO_FAVORITE_FOUND', mode: 'alert')
        return
      else
        unless catPro
          if App.confirm('FAVORITE_IN_TRASH')
            window.location.href = '#/trash/products/'
            return
          else return
        else if catId
          location = '/category/' + catId + '/s/' + favorite.id
    else if catPro and cat
      return if catPro.ignored or !Category.protected[cat.name]
      location = '/pages/' + cat.name + '#/item/' + favorite.id
      
    location
    
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
      # scope of record
      Category.trigger('change:collection', target)
      if typeof callback is 'function'
        callback.call(@)
    
    ret = for item in items
      if item.deleted
        item.deleted = false
        item.save(target: target)
      ga = new CategoriesProduct
        category_id  : target.id
        product_id   : item.id
        ignored      : item.ignored
        order        : parseInt(CategoriesProduct.products(target.id).last()?.order)+1 or 0
      valid = ga.save
        validate: true
        ajax: false
      isValid = valid unless valid
      
    if isValid
      # save on the target includes the join
      target.save
        validate: false
        done: cb
    else
      Spine.trigger('refresh:all')
    ret
    
  @destroyJoin: (items=[], target, callback) ->
    return unless target
    
    items = [items] unless Array.isArray items
    
    # scope of record
    cb = (item) ->
      category = Category.findByAttribute('name', 'NONECAT')
      product = Product.find(@product_id)
      
      gas = CategoriesProduct.filter(@product_id, associationForeignKey: 'product_id')
      Product.trigger('inbound:trash', product) unless gas.length
#      Product.trigger('create:join', product, category) unless gas.length
    
    for item in items
      ga = CategoriesProduct.productExists(item.id, target.id)
      try
        ga?.destroy(done: cb) # callback for unused products
      catch e
        alert e
      
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
  
  @findRelated_: (joins = [], joinid = '') ->
    record for join in joins when (record = @find(join[joinid])) and !!(typeof(record.order = join.order) and !!typeof(record.ignored = join.ignored))
    
  @findRelated: (joins = [], joinid = '') ->
    res = []
    for join in joins #when (record = @find(join[joinid])) and !!(typeof(record.order = join.order) and !!typeof(record.ignored = join.ignored))
      if record = @find(join[joinid])
        res.push record.silentUpdate('order': join.order, 'ignored': join.ignored)
    res
        
  @unusedProducts: ->
    @filter(true, {func: 'selectUnused'})
      
  @isUsedProduct: (id) ->
    ret = (cp = CategoriesProduct.findByAttribute('product_id', id))# and !cp.destroyed
    !!ret
      
  @validUrl: (me) ->
    if /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/.test(me.link)
      return true
    return false
      
  @renderBuffer: (buffer) ->
    filterOptions =
      model: 'Category'
      sort: 'sortByOrder'
      
    if (category = Category.record) or buffer
      # for the Category
      items = Category.products(category.id, filterOptions)
    else
      # for the Catalogue
      items = Product.filter(true)
    
    @buffer = items
      
  init: (instance) ->
    return unless id = instance.id
    s = new Object()
    s[id] = []
    @constructor.selection.push s
    
  parent: -> @constructor.parent
    
  isIgnored: (cid='') -> CategoriesProduct.isActiveProduct(cid, @id)
    
  selChange: (list) ->
  
  createJoin: (target) ->
    @constructor.createJoin [@], target
  
  destroyJoin: (target) ->
    @constructor.destroyJoin [@], target
        
  contains: (inc = 0) =>
    @constructor.contains(@id).length + inc
  
  photos: (max) =>
    @constructor.photos @id, max
  
  descriptions: =>
    @constructor.descriptions @id
  
  validUrl: -> @constructor.validUrl @
  
  details: =>
    $().extend @defaultDetails,
      iCount : @photos().length
      sCount : Product.selectionList().length
      product: Product.record
      category: Category.record
  
  # loops over each record and make sure to set the copy property
  select_: (joinTableItems) ->
    return false if @deleted
    ret = []
    ret.push record for record in joinTableItems when record.product_id is @id
    !!ret.length
    
  select: ->
    return true if !@deleted

  selectDeleted: ->
    return true if @deleted
      
  selectProduct: (id) ->
    return true if @id is id
    
  selectUnused: (id) ->
    return true unless CategoriesProduct.findByAttribute('product_id', @id)
      
module?.exports = Model.Product = Product