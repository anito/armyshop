Spine     = require("spine")
$         = Spine.$
Model     = Spine.Model
Category   = require('models/category')
Product     = require('models/product')
Clipboard = require('models/clipboard')
Settings  = require('models/settings')
Filter    = require("extensions/filter")

class Toolbar extends Spine.Model


  @configure 'Toolbar', 'id', 'name', 'content'
  
  @extend Filter

  @load: ->
    @refresh(@tools(), clear:true)
  
  @tools: ->
    val for key, val of @data
    
  @dropdownGroups:
    group_help:
      name: 'Help'
      icon: 'question-sign'
      content:
        [
          name: 'Quick Help'
          klass: 'opt-Help '
        ,
          name: 'About'
          klass: 'opt-Version '
        ]
    group0:
      name: 'View'
      content:
        [
          name: 'Overview'
          klass: 'opt-Overview '
        ,
          name: 'Preview'
          klass: 'opt-SlideshowPreview '
          disabled: -> !App.activePhotos().length
        ,
          devider: true
        ,
          name: -> 'Product Library'
          klass: 'opt-ShowAllProducts'
          icon: 'book'
          disabled: -> false
        ,
          name: -> 'Photo Library'
          klass: 'opt-ShowAllPhotos'
          icon: 'book'
          disabled: -> false
        ,
          devider: true
        ,
          name: 'Invert Selection'
          klass: 'opt-SelectInv'
          shortcut: 'Ctrl+I'
        ,
          name: 'Select All'
          klass: 'opt-SelectAll'
          shortcut: 'Ctrl+A'
        ,
          devider: true
        ,
          name: 'Toggle Fullscreen'
          klass: 'opt-FullScreen'
          icon: 'fullscreen'
          iconcolor: 'black'
        ,
          name: 'Toggle Sidebar'
          klass: 'opt-Sidebar'
          shortcut: '->|'
        ]
    group1:
      name: 'Category'
      content:
        [
          name: 'New'
          icon: 'asterisk'
          klass: 'opt-CreateCategory'
        ,
          name: 'New from Product Selection'
          icon: 'certificate'
          klass: 'opt-CopyProductsToNewCategory'
          disabled: -> !Category.selectionList().length
        ,
          devider: true
        ,
          name: 'Edit'
          icon: 'pencil'
          klass: 'opt-Category'
          disabled: ->
        ,
          name: 'Destroy'
          icon: 'trash'
          klass: 'opt-DestroyCategory'
          disabled: -> !Category.record
          shortcut: '<-'
        ]
    group2:
      name: 'Product'
      content:
        [
          name: 'New'
          icon: 'asterisk'
          klass: 'opt-CreateProduct'
        ,
          name: 'New from Photo Selection'
          icon: 'asterisk'
          klass: 'opt-CopyPhotosToNewProduct'
          disabled: -> !Product.selectionList().length
        ,
          name: 'Add from Library'
          icon: 'plus'
          klass: 'opt-AddProducts'
          disabled: -> !Category.record
        ,
          name: 'Duplicate'
          icon: 'certificate'
          klass: 'opt-DuplicateProducts'
          disabled: -> !Product.record
        ,
          devider: true
        ,
          name: 'Edit'
          icon: 'pencil'
          klass: 'opt-Product'
          disabled: ->
        ,
          name: ->
            len = '('+Category.selectionList().length+')'
            type = if Category.record then 'Remove' else 'Destroy'
            return type+' '+len
          icon: 'trash'
          klass: 'opt-DestroyProduct'
          disabled: -> !Category.selectionList().length
          shortcut: '<-'
        ,
          name: -> 'Destroy Empty Products (' + Product.findEmpties().length + ')'
          icon: 'trash'
          klass: 'opt-DestroyEmptyProducts'
          disabled: -> !Product.findEmpties().length
        ,
          name: 'Empty Products'
          icon: 'fire'
          klass: 'opt-EmptyProduct'
          disabled: -> !Category.selectionList().length or !Category.selectedProductsHasPhotos()
        ,
          name: ->
            a = 'Toggle visible'
            b = ' (' + Category.selectionList().length + ')'
            if Category.record
              return a + b
            else
              return a
          icon: 'eye'
          klass: 'opt-ToggleVisible'
          shortcut: 'Ctrl-M'
          disabled: -> !Category.selectionList().length or !Category.record
        ,
          devider: true
        ,
          name: 'Copy'
          icon: ''
          klass: 'opt-CopyProduct'
          disabled: -> !Category.selectionList().length
          shortcut: 'Ctrl+C'
        ,
          name: 'Cut'
          icon: ''
          klass: 'opt-CutProduct'
          disabled: -> !Category.selectionList().length
          shortcut: 'Ctrl+X'
        ,
          name: 'Paste'
          icon: ''
          klass: 'opt-PasteProduct'
          disabled: -> !Clipboard.findAllByAttribute('type', 'copy').length or !Category.record
          shortcut: 'Ctrl+V'
        ,
          devider: true
        ,
          name: -> 'Product Library'
          klass: 'opt-ShowAllProducts'
          icon: 'book'
          disabled: -> false
        ]
    group3:
      name: 'Photo'
      content:
        [
          name: 'Upload'
          icon: 'upload'
          klass: 'opt-Upload'
        ,
          name: 'Add from Library'
          icon: 'plus'
          klass: 'opt-AddPhotos'
          disabled: -> !Product.record
        ,
          devider: true
        ,
          name: ->
            'Rotate ('+ Product.selectionList().length + ')'
          header: true
          disabled: true
        ,
          name: 'cw'
          klass: 'opt-Rotate-cw'
          shortcut: 'Ctrl+R'
          icon: 'circle-arrow-right'
          disabled: -> !Product.selectionList().length
        ,
          name: 'ccw'
          klass: 'opt-Rotate-ccw'
          icon: 'circle-arrow-left'
          disabled: -> !Product.selectionList().length
        ,
          devider: true
        ,
          name: 'Edit'
          icon: 'pencil'
          klass: 'opt-Photo'
          disabled: ->
        ,
          name: ->
            if Product.record
              type = 'Remove'
            else
              type = 'Destroy'
            len = Product.selectionList().length
            return type+' ('+len+')'
          shortcut: '<-'
          icon: 'trash'
          klass: 'opt-DestroyPhoto '
          disabled: -> !Product.selectionList().length
        ,
          devider: true
        ,
          name: 'Copy'
          icon: ''
          klass: 'opt-CopyPhoto'
          disabled: -> !Product.selectionList().length
          shortcut: 'Ctrl+C'
        ,
          name: 'Cut'
          icon: ''
          klass: 'opt-CutPhoto'
          disabled: -> !Product.selectionList().length
          shortcut: 'Ctrl+X'
        ,
          name: 'Paste'
          icon: ''
          klass: 'opt-PastePhoto'
          disabled: -> !Clipboard.findAllByAttribute('type', 'copy').length or !Product.record
          shortcut: 'Ctrl+V'
        ,
          devider: true
        ,
          name: -> 'Photo Library'
          klass: 'opt-ShowAllPhotos'
          icon: 'book'
          disabled: -> false
        ,
          devider: true
        ,
          name: 'Auto Upload'
          icon: -> if Settings.isAutoUpload() then 'ok' else ''
          klass: 'opt-AutoUpload'
          disabled: -> false
        ]
    group4:
      name: -> 
        len = App.activePhotos().length
        'Slideshow  <span class="badge">' + len + '</span>'
      content:
        [
          name: -> 'Preview'
          klass: 'opt-SlideshowPreview'
          icon: 'picture'
          disabled: -> !App.activePhotos().length
        ,
          name: 'Start'
          klass: 'opt-SlideshowPlay'
          shortcut: 'Space'
          icon: 'play'
          dataToggle: 'modal-category'
          disabled: -> !App.activePhotos().length
        ]
      
  @data:
    package_00:
      name: 'Empty'
      content: []
    package_01:
      name: 'Default'
      content:
        [
          dropdown: true
          itemGroup: @dropdownGroups.group_help
        ,
          dropdown: true
          itemGroup: @dropdownGroups.group0
        ,
          dropdown: true
          itemGroup: @dropdownGroups.group1
        ,
          dropdown: true
          itemGroup: @dropdownGroups.group2
        ,
          dropdown: true
          itemGroup: @dropdownGroups.group3
        ,
          dropdown: true
          itemGroup: @dropdownGroups.group4
        ]
    package_02:
      name: 'Close'
      content:
        [
          name: '&times;'
          klass: 'opt opt-Previous'
          innerklass: 'close white'
          type: 'button'
        ]
    package_09:
      name: 'Slideshow'
      content:
        [
          name: -> 'Start'
          icon: 'picture'
          icon2: 'play'
          klass: 'opt-SlideshowPlay'
          innerklass: -> if App.activePhotos().length then 'azur puls' else ''
          dataToggle: 'modal-category'
          disabled: -> !App.activePhotos().length
        ]
    package_10:
      name: 'Back_'
      locked: true
      content:
        [
          name: '&times;'
          klass: 'opt-Previous'
          type: 'span'
          icon: 'arrow-left'
          outerstyle: 'float: right;'
        ]
    package_11:
      name: 'Chromeless'
      locked: true
      content:
        [
          name: 'Chromeless'
          klass: -> 'opt-FullScreen' + if App.showView.slideshowView.fullScreenEnabled() then ' active' else ''
          icon: ''
          dataToggle: 'button'
          outerstyle: ''
        ,
          name: -> ''
          klass: 'opt-SlideshowPlay'
          icon: 'play'
          iconcolor: 'white'
          disabled: -> !App.activePhotos().length
        ]
    package_12:
      name: 'Slider'
      content:
        [
          name: '<span class="slider" style=""></span>'
          klass: 'opt-Thumbsize '
          type: 'div'
          innerstyle: 'width: 190px; position: relative;'
        ]
    package_13:
      name: 'SlideshowPackage'
      content:
        [
          name: 'Fullscreen'
          klass: -> 'opt-FullScreen' + if App.showView.slideshowView.fullScreenEnabled() then ' active' else ''
          icon: 'fullscreen'
          dataToggle: 'button'
          outerstyle: ''
        ,
          name: 'Start'
          klass: 'opt-SlideshowPlay'
          innerklass: 'symbol'
          icon: 'play'
          iconcolor: ''
          disabled: -> !App.activePhotos().length
        ,
          name: '<span class="slider" style=""></span>'
          klass: 'opt-Thumbsize '
          type: 'div'
          innerstyle: 'width: 190px; position: relative;'
        ]
    package_14:
      name: 'FlickrRecent'
      content:
        [
          name: ->
            details = App.flickrView.details('recent')
            'Recent Photos (' + details.from + '-' + details.to + ')'
          klass: 'opt'
          innerklass: 'symbol'
          icon: 'picture'
          type: 'span'
        ,
          name: ''
          klass: 'opt opt-Prev'
          icon: 'chevron-left'
          disabled: -> 
        ,
          name: ''
          klass: 'opt opt-Next'
          icon: 'chevron-right'
          disabled: -> 
        ]
    package_15:
      name: 'FlickrInter'
      content:
        [
          name: ->
            details = App.flickrView.details('inter')
            'Interesting Stuff (' + details.from + '-' + details.to + ')'
          icon: 'picture'
          klass: 'opt'
          type: 'span'
        ,
          name: ''
          klass: 'opt opt-Prev'
          icon: 'chevron-left'
          disabled: -> 
        ,
          name: ''
          klass: 'opt opt-Next'
          icon: 'chevron-right'
          disabled: -> 
        ]
    package_16:
      name: 'Close_'
      content:
        [
          icon: 'arrow-left'
          klass: 'opt opt-Previous'
          type: 'span'
        ]
        
  init: (ins) ->
    
  # for the filter
  select: (list) ->
    @name in list
    
module?.exports = Toolbar