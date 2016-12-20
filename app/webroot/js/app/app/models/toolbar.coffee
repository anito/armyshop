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
          disabled: -> true
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
          klass: 'opt-ShowCategories'
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
          klass: 'opt-DeleteCategory'
          disabled: ->
            ret = !Category.record.isValid?() #or (c for c in Category.protected when c is Category.record.name ).length
          shortcut: '<-'
        ,
          devider: true
        ,
          name: -> 'Kategorien'
          klass: 'opt-ShowCategories'
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
            len = 0
            model = App.showView.current.model
            modelName = App.showView.current.model.className
            if modelName is 'ProductsTrash'
              type = 'Löschen'
              len = model.selectionList().length
            else
              type = 'Entfernen'
              len = Category.selectionList().length
            return type+' ('+len+')'
          icon: 'trash'
          klass: 'opt-DeleteProduct'
          disabled: ->
            len = 0
            model = App.showView.current.model
            modelName = App.showView.current.model.className
            if modelName is 'ProductsTrash'
              len = model.selectionList().length
            else
              len = Category.selectionList().length
            !len
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
        ,
          name: -> 'zeige Produkt des Tages'
          klass: 'opt-ShowFavorite'
          icon: 'star'
          disabled: -> !(prod = Product.findByAttribute('favorite', true))
        ,
          devider: true
        ,
          name: -> 'Papierkorb'
          klass: 'opt-ShowProductsTrash'
          icon: 'trash'
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
            len = 0
            model = App.showView.current.model
            modelName = App.showView.current.model.className
            if modelName is 'PhotosTrash'
              type = 'Löschen'
              len = model.selectionList().length
            else
              type = 'Entfernen'
              len = Product.selectionList().length
            return type+' ('+len+')'
          shortcut: '<-'
          icon: 'trash'
          klass: 'opt-DeletePhoto'
          disabled: ->
            len = 0
            model = App.showView.current.model
            modelName = App.showView.current.model.className
            if modelName is 'PhotosTrash'
              len = model.selectionList().length
            else
              len = Product.selectionList().length
            !len
        ,
          devider: true
        ,
          name: 'Kopieren'
          icon: ''
          klass: 'opt-CopyPhoto'
          disabled: -> !Product.selectionList().length and App.showView.current.model.className.toLowerCase().indexOf('trash') >= 0
          shortcut: 'Ctrl+C'
        ,
          name: 'Ausschneiden'
          icon: ''
          klass: 'opt-CutPhoto'
          disabled: -> !Product.selectionList().length and App.showView.current.model.className.toLowerCase().indexOf('trash') >= 0
          shortcut: 'Ctrl+X'
        ,
          name: 'Einfügen'
          icon: ''
          klass: 'opt-PastePhoto'
          disabled: -> !Clipboard.findAllByAttribute('type', 'copy').length or !Product.record and App.showView.current.model.className.toLowerCase().indexOf('trash') >= 0
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
          name: -> 'Papierkorb'
          klass: 'opt-ShowPhotosTrash'
          icon: 'trash'
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
          name: -> 'Datensicherung anlegen'
          klass: 'opt-MysqlDump'
          icon: 'floppy-open'
          disabled: -> false
        ,
          name: 'Gesicherte Daten wiederherstellen'
          klass: 'opt-MysqlRestore'
          icon: 'floppy-save'
          disabled: -> false
        ,
          name: 'Intro-Quatsch'
          klass: 'opt-IntroQuatsch'
          icon: -> if Model.Settings.isIntroQuatsch() then 'ok' else ''
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
      name: 'Speichern'
      content:
        [
          icon: 'arrow-left'
          klass: 'opt opt-Previous'
          type: 'span'
        ]
    package_17:
      name: 'Trustami'
      content:
        [
          name: '<span><button type="submit" class="btn left dark glyphicon glyphicon-chevron-up"></button><button type="submit" class="btn right dark glyphicon glyphicon-chevron-down"></button></span><input class="tmi" type="text" value=""></input>'
          klass: 'opt opt-SaveTrustami trustami-badge'
          type: 'span'
        ]
        
  init: (ins) ->
    
  # for the filter
  select: (list) ->
    @name in list
    
module?.exports = Toolbar