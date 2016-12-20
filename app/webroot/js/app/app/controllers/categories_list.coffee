Spine           = require("spine")
$               = Spine.$
Root            = require("models/root")
Category         = require('models/category')
Photo         = require('models/photo')
CategoriesProduct  = require('models/categories_product')
ProductsPhoto     = require('models/products_photo')
Drag            = require('extensions/drag')
Extender        = require('extensions/controller_extender')

require('extensions/tmpl')

class CategoriesList extends Spine.Controller

  @extend Extender
  
  events:
    'click .dropdown-toggle'        : 'dropdownToggle'
    'click .delete'                 : 'deleteCategory'
    'click .zoom'                   : 'zoom'
    
#    'mousemove .item'               : 'infoUp'
#    'mouseleave .item'              : 'infoBye'
    
  
  constructor: ->
    super
    Product.bind('change:collection', @proxy @renderRelated)
    Category.bind('change', @proxy @renderOne)
    Category.bind('destroy', @proxy @testEmpty)
    CategoriesProduct.bind('change', @proxy @renderOneRelated)
    Photo.bind('destroy', @proxy @renderRelated)
    Product.bind('destroy', @proxy @renderRelated)
    Root.bind('change:selection', @proxy @exposeSelection)
    
  test: (args...) ->
    console.log args
    
  renderOneRelated: (ga) ->
    category = Category.find ga.category_id
    @updateTemplate(category) if category
    
  renderRelated: ->
    return unless @parent.isActive()
    @log 'renderRelated'
    @updateTemplates()
    
  renderOne: (item, mode) ->
    @log 'renderOne'
    switch mode
      when 'create'
        @wipe()
        @append @template item
        @reorder item
        @delay(@proxy(@exposeSelection), 2000)
      when 'update'
        @updateTemplate(item)
        $('.dropdown-toggle', @el).dropdown()
        @reorder item
        @exposeSelection()
      when 'destroy'
        @exposeSelection()
    @el

  render: (items, mode) ->
    unless items.length
      s = if (s = @model.record?.screenname or s = @model.record?.name or s = @model.record?.title)? then 'in ' + s + ' nichts los - kein Moos' else 'nichts los hier. Brutal...'
      @renderEmpty(s)
      return @el
    
    @html @template items
    @exposeSelection()
    $('.dropdown-toggle', @el).dropdown()
    @el.sortable('categories')
    @el
  
  updateTemplates: ->
    @log 'updateTemplates'
    for category in Category.records
      @updateTemplate(category)
#    @el.sortable('categories')

  updateTemplate: (item) ->
    itemEl = @children().forItem(item)
    active = itemEl.hasClass('active')
    hot = itemEl.hasClass('hot')
    innerEl = $('.thumbnail', itemEl)
    style = innerEl.attr('style')
    
    tmplItem = innerEl.tmplItem()
    tmplItem.data = item
    tmplItem.update?()
    
    itemEl.attr('id', item.id)
    itemEl.toggleClass('active', active)
    itemEl.toggleClass('hot', hot)
    innerEl.attr('style', style)
    @el.sortable()
    
  reorder: (item) ->
    id = item.id
    index = (id, list) ->
      for itm, i in list
        return i if itm.id is id
      i
    
    children = @children()
    oldEl = @children().forItem(item)
    idxBeforeSort =  @children().index(oldEl)
    idxAfterSort = index(id, Category.all().sort(Category.sortByOrder))
    newEl = $(children[idxAfterSort])
    if idxBeforeSort < idxAfterSort
      newEl.after oldEl
    else if idxBeforeSort > idxAfterSort
      newEl.before oldEl
        
  dropdownToggle: (e) ->
    e.preventDefault()
    e.stopPropagation()
        
    el = $(e.currentTarget)
    el.dropdown()
    
  zoom: (e) ->
    item = if e.type is 'click' then $(e.currentTarget).item() else @models.record
    
    if cid = item?.id
      @navigate '/category', cid, pid = if (pid = Category.record?.selectionList().first()) then 'pid/' + pid else null
    else
      @navigate '/category', ''
    
    e.stopPropagation()
    e.preventDefault()
    
  back: (e) ->
    e.stopPropagation()
    e.preventDefault()
    
    @navigate '/overview', ''
    
  deleteCategory: (e) ->
    e.stopPropagation()
    e.preventDefault()
    
    item = $(e.currentTarget).item()
    el = $(e.currentTarget).parents('.item')
    Spine.trigger('delete:category', item.id) if item
    
module?.exports = CategoriesList