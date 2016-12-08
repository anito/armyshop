# jQuery.tmpl.js utilities

$ = jQuery ? require("jqueryify")

$.fn.item_ = (keep) ->
  item = $(@).tmplItem().data
  unless keep
    return item.reload?()
  else return item

$.fn.item = ->
  item = $(@).tmplItem().data

$.fn.forItem = (item={}) ->
  @filter ->
    compare = $(@).item()
    item.eql?(compare) or item is compare

$.fn.serializeForm = ->
  result = {}
  $.each $(@).find('input,textarea').serializeArray(), (i, item) ->
    result[item.name] = item.value
  result