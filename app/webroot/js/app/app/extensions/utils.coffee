# jQuery.tmpl.js utilities

$ = jQuery ? require("jqueryify")

$.fn.brace = (str='') ->
  str = str.toString()
  return '(' + str + ')'

$.fn.deselect = () ->
  els = $(@).find('.item')
  els.removeClass('active hot')
  
$.fn.name = (str=new String, l=1000, repl='...') ->
  str = str.toString()
  repl = repl.toString()
  ret = str.slice(0, l)
  ret = ret + repl if str.length > l
  ret
  
$.extend jQuery.tmpl.tag,
  "for": 
    _default: {$2: "var i=1;i<=1;i++"},
    open: 'for ($2){',
    close: '};'
  
$.fn.isFormElement = (o=[]) ->
  str = Object::toString.call(o[0])
  formElements = ['[object HTMLInputElement]','[object HTMLTextAreaElement]']
  formElements.indexOf(str) isnt -1

$.fn.state = (state) ->
  d = 'disabled'
  @each ->
    $this = $(@)
    $this.html( $this.data()[state] )
    if state is 'loading'
      return $this.addClass(d).attr(d,d)
    else
      return $this.removeClass(d).removeAttr(d)
    
$.fn.unparam = (value) ->
  # Object that holds names => values.
  params = {}
  # Get query string pieces (separated by &)
  pieces = value.split('&')

  for piece in pieces
    pair = piece.split('=', 2)
    params[decodeURIComponent(pair[0])] = if pair.length is 2 then decodeURIComponent(pair[1].replace(/\+|false/g, '')) else true
  params

$.fn.position = (e) ->
  parent=@parent()
  info_h=@innerHeight()
  info_w=@innerWidth()
  w=$(window).width()
  h=$(window).height()
  t=$(window).scrollTop()
  s=parent.scrollTop()
  x_offset = 30
  y_offset = -20
  posx=e.pageX+x_offset-parent.offset().left
  posy=e.pageY+y_offset-parent.offset().top+s
  maxx=posx+info_w
  minx=posx-info_w
  maxy=posy+info_h
  if(maxx>=w)
    posx=e.pageX-(info_w)-x_offset
  if(maxy>=(h+t))
    posy=e.pageY-(info_h)-y_offset
  @css
    top:posy+'px'
    left:posx+'px'
