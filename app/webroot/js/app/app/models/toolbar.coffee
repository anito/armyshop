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
      name: 'Hilfe'
      icon: 'question-sign'
      content:
        [
          name: 'Tastaturbefehle'
          klass: 'opt-Help '
        ,
          name: 'Über'
          klass: 'opt-Version '
        ]
    group0:
      name: 'Ansicht'
      content:
        [
          name: -> 'Übersicht'
          klass: 'opt-ShowOverview'
          icon: 'book'
          disabled: -> false
        ,
          devider: true
        ,
          name: -> 'Kategorien'
          klass: 'opt-ShowAllCategories'
          icon: 'book'
          disabled: -> false
        ,
          name: -> 'Produkte-Katalog'
          klass: 'opt-ShowAllProducts'
          icon: 'book'
          disabled: -> false
        ,
          name: -> 'Foto-Katalog'
          klass: 'opt-ShowAllPhotos'
          icon: 'book'
          disabled: -> false
        ,
          devider: true
        ,
          name: 'Vollbild Aus/Ein'
          klass: 'opt-FullScreen'
          icon: 'fullscreen'
          iconcolor: 'black'
        ,
          name: 'Seitenleiste Ein/Aus'
          klass: 'opt-Sidebar'
          shortcut: '->|'
        ]
    group1:
      name: 'Kategorie'
      content:
        [
          name: 'Neu'
          icon: 'asterisk'
          klass: 'opt-CreateCategory'
        ,
          devider: true
        ,
          name: 'Bearbeiten'
          icon: 'pencil'
          klass: 'opt-Category'
          disabled: ->
        ,
          name: 'Löschen'
          icon: 'trash'
          klass: 'opt-DestroyCategory'
          disabled: ->
            ret = !Category.record.isValid?() #or (c for c in Category.protected when c is Category.record.name ).length
          shortcut: '<-'
        ,
          devider: true
        ,
          name: -> 'Kategorien'
          klass: 'opt-ShowAllCategories'
          icon: 'book'
          disabled: -> false
        ]
    group2:
      name: 'Produkt'
      content:
        [
          name: 'Neu'
          icon: 'asterisk'
          klass: 'opt-CreateProduct'
        ,
          name: 'Aus Katalog hinzufügen'
          icon: 'plus'
          klass: 'opt-AddProducts'
          disabled: -> !Category.record
        ,
          name: 'Dupizieren'
          icon: 'certificate'
          klass: 'opt-DuplicateProducts hide'
          disabled: -> !Product.record
        ,
          devider: true
        ,
          name: 'Bearbeiten'
          icon: 'pencil'
          klass: 'opt-Product'
          disabled: ->
        ,
          name: ->
            len = '('+Category.selectionList().length+')'
            type = if Category.record then 'Entfernen' else 'Löschen'
            return type+' '+len
          icon: 'trash'
          klass: 'opt-DestroyProduct'
          disabled: -> !Category.selectionList().length
          shortcut: '<-'
        ,
          devider: true
        ,
          name: ->
            a = 'Veröffentlichen Ein/Aus'
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
          name: 'Kopieren'
          icon: ''
          klass: 'opt-CopyProduct'
          disabled: -> !Category.selectionList().length
          shortcut: 'Ctrl+C'
        ,
          name: 'Auschneiden'
          icon: ''
          klass: 'opt-CutProduct'
          disabled: -> !Category.selectionList().length
          shortcut: 'Ctrl+X'
        ,
          name: 'Einfügen'
          icon: ''
          klass: 'opt-PasteProduct'
          disabled: -> !Clipboard.findAllByAttribute('type', 'copy').length or !Category.record
          shortcut: 'Ctrl+V'
        ,
          devider: true
        ,
          name: -> 'Produkte-Katalog'
          klass: 'opt-ShowAllProducts'
          icon: 'book'
          disabled: -> false
        ]
    group3:
      name: 'Foto'
      content:
        [
          name: 'Upload'
          icon: 'upload'
          klass: 'opt-UploadDialogue'
        ,
          name: 'Foto aus Katalog hinzufügen'
          icon: 'plus'
          klass: 'opt-AddPhotos'
          disabled: -> !Product.record
        ,
          devider: true
        ,
          name: ->
            'Rotieren ('+ Product.selectionList().length + ')'
          header: true
          disabled: true
        ,
          name: 'Im Uhrzeiger'
          klass: 'opt-Rotate-cw'
          shortcut: 'Ctrl+R'
          icon: 'circle-arrow-right'
          disabled: -> !Product.selectionList().length
        ,
          name: 'Gegen Uhrzeiger'
          klass: 'opt-Rotate-ccw'
          icon: 'circle-arrow-left'
          disabled: -> !Product.selectionList().length
        ,
          devider: true
        ,
          name: 'Bearbeiten'
          icon: 'pencil'
          klass: 'opt-Photo'
          disabled: ->
        ,
          name: ->
            if Product.record
              type = 'Entfernen'
            else
              type = 'Löschen'
            len = Product.selectionList().length
            return type+' ('+len+')'
          shortcut: '<-'
          icon: 'trash'
          klass: 'opt-DestroyPhoto '
          disabled: -> !Product.selectionList().length
        ,
          devider: true
        ,
          name: 'Kopieren'
          icon: ''
          klass: 'opt-CopyPhoto'
          disabled: -> !Product.selectionList().length
          shortcut: 'Ctrl+C'
        ,
          name: 'Ausschneiden'
          icon: ''
          klass: 'opt-CutPhoto'
          disabled: -> !Product.selectionList().length
          shortcut: 'Ctrl+X'
        ,
          name: 'Einfügen'
          icon: ''
          klass: 'opt-PastePhoto'
          disabled: -> !Clipboard.findAllByAttribute('type', 'copy').length or !Product.record
          shortcut: 'Ctrl+V'
        ,
          devider: true
        ,
          name: -> 'Foto-Katalog'
          klass: 'opt-ShowAllPhotos'
          icon: 'book'
          disabled: -> false
        ,
          devider: true
        ,
          name: 'Auto Upload'
          icon: -> if Model.Settings.isAutoUpload() then 'ok' else ''
          klass: 'opt-AutoUpload'
          disabled: -> true
        ]
    group31:
      name: -> 
        'Extras'
      content:
        [
          name: -> 'Daten sichern'
          klass: 'opt-MysqlDump'
          icon: 'floppy-save'
          disabled: -> true
        ,
          name: 'Gesicherte Daten wiederherstellen'
          klass: 'opt-MysqlRestore'
          icon: 'floppy-open'
          disabled: -> true
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
    group5:
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
          itemGroup: @dropdownGroups.group31
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
      name: 'Speichern'
      content:
        [
          name: -> 'Synchronisieren'
          icon: 'floppy-disk'
          klass: 'opt-Save hide'
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
          klass: -> 'opt-FullScreen'
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