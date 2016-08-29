require('lib/setup')

Spine = require('spine')

class App extends Spine.Controller

  elements:
    '#header'           : 'header',
    '#header .nav.items': 'items',
    '#header .nav-item' : 'item',
    '#content'          : 'content',
    '#nav'              : 'nav'

  events:
    'mouseenter #outdoor-item-menu' :           'changeBackground'
    'mouseenter #defense-item-menu' :           'changeBackground'
    'mouseenter #goodies-item-menu' :           'changeBackground'
#    'mouseleave #outdoor-item-menu' :           'removeBackground'
#    'mouseleave #defense-item-menu' :           'removeBackground'
#    'mouseleave #goodies-item-menu' :           'removeBackground'

  
  
  
  constructor: ->
    super
    # Getting started - should be removed
    
    @arr = ['home', 'outdoor', 'defense', 'goodies', 'out']
    
    #@content.append require("views/sample")({version:Spine.version})
    $('.nav-item', @items).removeClass('active')
    $('.'+@getData(base_url, @arr), @items).addClass('active')
    
    @setBackground()
  
  setBackground: ->
    @el.addClass(@getData base_url, @arr)
    
  changeBackground: (e) ->
    e.preventDefault()
    e.stopPropagation()
    el = $(e.currentTarget)
    
    arr = @arr
    s = el.attr('id')
    res = @getData s, arr
    
    for c in arr
      @el.removeClass(c)
    @el.addClass(res)
  
  removeBackground: (e) ->
    e.preventDefault()
    e.stopPropagation()
    
    arr = @arr
    for c in arr
      @el.removeClass(c)
    @el.addClass('out')
    
  getData: (s, arr=[]) ->
    test = (s, a) -> 
      matcher = new RegExp(".*"+a+".*", "g");
      found = matcher.test(s);
    for a, i in arr
      return arr[i] if test s, a
  
module.exports = App
