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

  @extend Drag
  @extend Extender
  
  events:
    'click .opt-SlideshowPlay'      : 'slideshowPlay'
    'click .dropdown-toggle'        : 'dropdownToggle'
    'click .delete'                 : 'deleteCategory'
    'click .zoom'                   : 'zoom'
    
    'mousemove .item'               : 'infoUp'
    'mouseleave .item'              : 'infoBye'
    
    'dragover'                      : 'dragover'
  
  constructor: ->
    super
    Category.bind('change:current', @proxy @exposeSelection)
    Product.bind('change:collection', @proxy @renderRelated)
    Category.bind('change', @proxy @renderOne)
    CategoriesProduct.bind('change', @proxy @renderOneRelated)
    Photo.bind('destroy', @proxy @renderRelated)
    Product.bind('destroy', @proxy @renderRelated)
    
  renderOneRelated: (ga) ->
    category = Category.find ga.category_id
    @updateOneTemplate(category) if category
    
  renderRelated: ->
    return unless @parent.isActive()
    @log 'renderRelated'
    @updateTemplates()
    
  renderOne: (item, mode) ->
    @log 'renderOne'
    switch mode
      when 'create'
        if Category.count() is 1
          @el.empty()
        @append @template item
        @exposeSelection()
      when 'update'
        try
          @updateTemplates()
          $('.dropdown-toggle', @el).dropdown()
        catch e
        @reorder item
        @exposeSelection()
      when 'destroy'
        @exposeSelection()
          
    @el

  render: (items, mode) ->
    @log 'render'
    @html @template items
    @exposeSelection()
    $('.dropdown-toggle', @el).dropdown()
    @el
  
  updateTemplates: ->
    @log 'updateTemplates'
    for category in Category.records
      @updateOneTemplate(category)

  updateOneTemplate: (category) ->
    categoryEl = @children().forItem(category)
    active = categoryEl.hasClass('active')
    contentEl = $('.thumbnail', categoryEl)
    tmplItem = contentEl.tmplItem()
    alert 'no tmpl item' unless tmplItem
    if tmplItem
      tmplItem.tmpl = $( "#categoriesTemplate" ).template()
      tmplItem.update?()
      categoryEl = @children().forItem(category).toggleClass('active hot', active)
    
  reorder: (item) ->
    id = item.id
    index = (id, list) ->
      for itm, i in list
        return i if itm.id is id
      i
    
    children = @children()
    oldEl = @children().forItem(item)
    idxBeforeSort =  @children().index(oldEl)
    idxAfterSort = index(id, Category.all().sort(Category.nameSort))
    newEl = $(children[idxAfterSort])
    if idxBeforeSort < idxAfterSort
      newEl.after oldEl
    else if idxBeforeSort > idxAfterSort
      newEl.before oldEl

  exposeSelection: ->
    @log 'exposeSelection'
    @deselect()
    $('#'+Category.record.id, @el).addClass("active hot")
      
    App.showView.trigger('change:toolbarOne')
    @parent.focus()
        
  dropdownToggle: (e) ->
    e.preventDefault()
    e.stopPropagation()
        
    el = $(e.currentTarget)
    el.dropdown()
    
  zoom: (e) ->
    @log 'zoom'
    e.stopPropagation()
    e.preventDefault()
    
    item = $(e.currentTarget).item()
    @navigate '/category', item.id
    
  back: (e) ->
    e.stopPropagation()
    e.preventDefault()
    
    @navigate '/overview', ''
    
  deleteCategory: (e) ->
    e.stopPropagation()
    e.preventDefault()
    
    item = $(e.currentTarget).item()
    el = $(e.currentTarget).parents('.item')
    Spine.trigger('destroy:category', item.id) if item
    
  infoUp: (e) =>
    el = $('.glyphicon-set' , $(e.currentTarget)).addClass('in').removeClass('out')
    e.preventDefault()
    
  infoBye: (e) =>
    el = $('.glyphicon-set' , $(e.currentTarget)).addClass('out').removeClass('in')
    e.preventDefault()
    
  slideshowPlay: (e) ->
    category = $(e.currentTarget).closest('.item').item()
    if App.activePhotos().length
      #Category.trigger('activate', category.id)
      App.slideshowView.trigger('play')
    else
      App.showView.noSlideShow()
    e.stopPropagation()

module?.exports = CategoriesList