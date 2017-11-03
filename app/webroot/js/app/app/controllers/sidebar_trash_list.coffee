Spine             = require("spine")
$                 = Spine.$
Bin               = require("models/bin")
Root              = require("models/root")
Product           = require('models/product')
Category          = require('models/category')
ProductsPhoto     = require('models/products_photo')
ProductsTrash     = require('models/products_trash')
CategoriesProduct = require('models/categories_product')
Drag              = require('extensions/drag')
Extender          = require('extensions/controller_extender')

require('extensions/tmpl')

class SidebarTrashList extends Spine.Controller

  @extend Drag
  @extend Extender
  
  elements:
    '.item'               : 'item'

  events:
    "click      .item"            : 'click'
    "click      .expander"        : 'clickExpander'

  subtemplate: (items) ->
    $('#productsTrashSublistTemplate').tmpl(items)
    
  template: (items) ->
    $("#sidebarTemplate").tmpl(items)
    
  ctaTemplate: (item) ->
    $('#ctaTemplate').tmpl(item)
    
  constructor: ->
    super
    
    ProductsTrash.bind('change', @proxy @render)
    
    Spine.bind('scroll', @proxy @scrollTo)
    
  init: ->
    
    
  render: (item, mode) =>
    @log 'render'
    
    switch mode
      when 'create'
        @create item
      when 'update'
        @update item
      when 'destroy'
        @destroy item
          
  create: (item) ->
    @append @template item
#    @renderOneSublist item
#    @reorder item
    console.log 'trash list create'
    console.log item
  
  update: (item) ->
    console.log 'trash list update'
    console.log item
  
  destroy: (item) ->
    console.log 'trash list destroy'
    console.log item
      
  initialize: ->
    id = Category.findByAttribute('name', '__BIN__')?.id
    selector = '#sidebar [data-id="' + id + '"]'
    @el = $(selector)
    console.log @el
      
  click: (e) ->
    
  clickExpander: (e) ->
    el = $(e.target).closest('li.gal')
    
    unless @isOpen(el)
      el.addClass('manual')
    else
      el.removeClass('manual')
      
    item = el.item()
    if item
      @expand(item, !@isOpen(el))
    
    e.stopPropagation()
    e.preventDefault()
    
  expand: (item, open) ->
    el = @categoryElFromItem(item)
    expander = $('.expander', el)
    
    el.toggleClass('open', open)
    return
    if open
      @openSublist(el)
    else
      @closeSublist(el) unless el.hasClass('manual')
        
  open: ->

  close: () ->
    
  scrollTo: (item) ->
    return unless item # and Category.record
    el = @children().forItem(Category.record)
    clsName = item.constructor.className
    switch clsName
      when 'Category'
        return
        queued = false
        ul = $('ul', el)
        # messuring categoryEl w/o sublist
        ul.hide()
        el_ = el[0]
        ohc = el_.offsetHeight if el_
        ul.show()
        speed = 10
      when 'Product'
        queued = false
        ul = $('ul', el)
        el = $('li', ul).forItem(item)
        el_ = el[0]
        ohc = el_.offsetHeight if el_
        speed = 200
      else
        return
        
    return unless el.length
      
    otc = el.offset().top
    stp = @el[0].scrollTop
    otp = @el.offset().top
    ohp = @el[0].offsetHeight  
    
    resMin = stp+otc-otp
    resMax = stp+otc-(otp+ohp-ohc)
    
    outOfRange = stp > resMin or stp < resMax
    
    return unless outOfRange
    
    outOfMinRange = stp > resMin
    outOfMaxRange = stp < resMax
    
    res = if outOfMinRange then resMin else if outOfMaxRange then resMax
    
    @el.animate scrollTop: res,
      queue: queued
      duration: speed
      done: =>
    
module?.exports = SidebarTrashList