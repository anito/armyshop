Spine  = require("spine")
$      = Spine.$

class Info extends Spine.Controller
  
  constructor: ->
    super
    @el.addClass('away').removeClass('show')
    @parent = @el.parent()
    
  render: (item) ->
    @html @template item
    @el
  
  up: (e) ->
    bye = => @bye()
    item = $(e.currentTarget).item()
    clearTimeout @timer
    clearTimeout @timer_
    @timer = setTimeout(bye, 2000)
    @el.removeClass('away').addClass('show')
    unless @current and @current?.id is item.id
      @current = item
      @render(@current)
        
    @position(e)
    
  bye: ->
    return unless @current
    stop = => @stop()
    @el.removeClass('show')
    clearTimeout @timer_
    @timer_ = setTimeout(stop, 200)
    
  stop: ->
    @el.addClass('away')
    @current = null
    
  position: (e) =>
    info_h=@el.innerHeight()
    info_w=@el.innerWidth()
    w=$(window).width()
    h=$(window).height()
    t=$(window).scrollTop()
    s=@parent.scrollTop()
    x_offset = 10
    y_offset = 10
    posx=e.pageX+x_offset-@parent.offset().left
    posy=e.pageY+y_offset-@parent.offset().top+s
    maxx=posx+info_w
    minx=posx-info_w
    maxy=posy+info_h
    if(maxx>=w)
      posx=e.pageX-(info_w)-x_offset
    if(maxy>=(h+t))
      posy=e.pageY-(info_h)-y_offset
    @el.css
      top:posy+'px'
      left:posx+'px'

module?.exports = Info