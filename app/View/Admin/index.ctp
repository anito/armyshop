<div id="loader" class="view">
  <div class="dialogue-wrap">
    <div class="dialogue">
      <div class="dialogue-content">
        <div class="bg transparent" style="line-height: 0.5em; text-align: center; color: #E1EEF7">
          <div class="status-symbol" style="z-index: 2;">
            <img src="/img/ajax-loader.gif" style="">
          </div>
          <div class="status-text"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="main" class="view vbox flex">
  <header id="title" class="">
    <div class="left" style="position: relative;">
      <h2 class="lehmann">
        <span class="chopin">Admin</span>
        <span class="lehmann-01"></span>
        <span class="lehmann-02"></span>
      </h2>
    </div>
    <div id="login" class="right" style="margin: 15px 5px;"></div>
  </header>
  <div id="wrapper" class="hbox flex">
    <div id="sidebar" class="views bg-medium hbox vdraggable">
      <div class="vbox sidebar canvas bg-dark flex inner" style="display: none">
        <div class="search">
          <form class="form-search">
            <input class="search-query" type="search" placeholder="Search">
          </form>
        </div>
        <ul id="preview" class="splitter autoflow noborder">
            <li class="preview parent flex">
              <div class="item-header">
                <div class="expander"></div>
                  <div class="item-content">
                    <span class="opt-preview">Preview</span>
                  </div>
              </div>
              <ul class="sublist" style="">
                <li class="content item item-content"></li>
              </ul>
            </li>
          </ul>
        <ul class="items flex vbox autoflow"></ul>
        <footer class="footer">
          <div style="white-space: nowrap; overflow: hidden;">
            <div id="refresh"></div>
            <button class="opt-CreateCategory dark hide">
              <i class="glyphicon glyphicon-plus"></i>
              <span>Kategorie</span>
            </button>
            <button class="opt-CreateProduct dark">
              <i class="glyphicon glyphicon-plus"></i>
              <span>Produkt</span>
            </button>
          </div>
        </footer>
      </div>
      <div class="vdivide draghandle"></div>
    </div>
    <div id="content" class="views vbox flex">
      <div tabindex="1" id="show" class="view canvas vbox flex fade">
        <div id="modal-action" class="modal fade"></div>
        <div id="modal-addProduct" class="modal fade"></div>
        <div id="modal-addPhoto" class="modal fade"></div>
        <ul class="options hbox">
          <nav class="toolbarOne hbox nav"></nav>
          <li class="splitter disabled flex"></li>
          <nav class="toolbarTwo hbox nav"></nav>
        </ul>
        <div class="contents views vbox flex deselector" style="height: 0;">
          <div class="header views vbox">
            <div class="categories view vbox"></div>
            <div class="products view vbox"></div>
            <div class="photos view vbox"></div>
            <div class="photo view vbox"></div>
            <div class="overview view"></div>
          </div>
          <div class="view wait content vbox flex autoflow" style=""></div>
          <div class="view  categories opt-SelectNone content vbox flex data parent autoflow" style="">
            <div class="items flex fadein in3">Categories</div>
          </div>
          <div class="view products opt-SelectNone content vbox flex data parent autoflow fadeelement" style="">
            <div class="hoverinfo fadeslow"></div>
            <div class="items flex fadein in3">Products</div>
          </div>
          <div class="view photos opt-SelectNone content vbox flex data parent autoflow fadeelement" style="">
            <div class="hoverinfo fadeslow"></div>
            <div class="items flex fadein in3" data-toggle="modal-category" data-target="#modal-category" data-selector="a">Photos</div>
          </div>
          <div tabindex="1" class="view photo content vbox flex data parent autoflow fadeelement nopad" style="">
            <div class="hoverinfo fadeslow"></div>
            <div class="items flex fade nopad">Photo</div>
          </div>
          <div id="slideshow" class="view content vbox flex data parent autoflow">
            <div class="items flex" data-toggle="blueimp-category" data-target="#blueimp-category" data-selector="a.thumbnail"></div>
          </div>
        </div>
        <div id="views" class="settings hbox autoflow">
          <div class="views contents bg-medium vbox flex autoflow hdraggable" style="position: relative">
            <div class="hdivide draghandle">
              <span class="opt opt-CloseDraghandle glyphicon glyphicon-resize-vertical glyphicon glyphicon-white right" style="cursor: pointer;"></span>
            </div>
            <div id="ga" class="view flex" style=""></div>
            <div id="al" class="view views flex vbox content" style="">
              <div class="footer" style="">
                <div class="span6" style="margin: 10px; white-space: nowrap; overflow: hidden;">
                  <section class="left">
                      <button type="submit" class="dark opt-EditorProduct">
                          <i class="glyphicon glyphicon-tasks"></i>
                          <span>Details</span>
                      </button>
                      <button type="submit" class="dark opt-EditorDescription">
                          <i class="glyphicon glyphicon-tasks"></i>
                          <span>Beschreibungen</span>
                      </button>
                  </section>
                  <section class="right">
                      <button type="submit" class="dark opt-CreateProduct">
                          <i class="glyphicon glyphicon-plus"></i>
                          <span>Produkt</span>
                      </button>
                  </section>
                </div>
              </div>
              <div class="vbox flex autoflow views" style="">
                <table role="presentation" class="table description view"></table>
                <table role="presentation" class="table product view"></table>
                <table role="presentation" class="table noproduct view"></table>
              </div>
            </div>
            <div id="ph" class="view flex autoflow" style=""></div>
            <div id="fu" class="view hbox flex bg-dark" style="margin: 0px">
              <!-- The file upload form used as target for the file upload widget -->
              <form id="fileupload" class="vbox flex" action="uploads/image" method="POST" enctype="multipart/form-data">
                  <!-- Redirect browsers with JavaScript disabled to the origin page -->
                  <noscript><input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/"></noscript>
                  <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                  <div class="vbox flex">
                    <!-- The table listing the files available for upload/download -->
                    <div class="footer fileupload-buttonbar" style="">
                      <div class="span6 left" style="margin: 10px; white-space: nowrap; overflow: hidden;">
                            <!-- The fileinput-button span is used to style the file input field as button -->
                            <span class="btn dark fileinput-button">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span>Add files...</span>
                                <input type="file" name="files[]" multiple>
                            </span>
                            <button type="submit" class="dark start">
                                <i class="glyphicon glyphicon-upload"></i>
                                <span>Start upload</span>
                            </button>
                            <button type="reset" class="dark cancel">
                                <i class="glyphicon glyphicon-ban-circle"></i>
                                <span>Cancel upload</span>
                            </button>
                            <button type="button" class="dark delete">
                                <i class="glyphicon glyphicon-remove"></i>
                                <span>Clear List</span>
                            </button>
                            <!-- The loading indicator is shown during file processing -->
                            <span class="fileupload-loading"></span>
                        </div>
                        <!-- The global progress information -->
                        <div class="span3 fileupload-progress fade" style="width: 260px; padding: 24px 0; display: table-cell;">
                            <!-- The global progress bar -->
                            <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width:0%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="vbox flex autoflow" style="">
                      <table role="presentation" class="table"><tbody class="files"></tbody></table>
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div tabindex="1" id="overview" class="view content vbox flex data parent fade" style="position: relative;">
        <div class="carousel-background bg-medium flex" style="z-index: 0;">
<!--          The data-ride="carousel" attribute is used to mark a carousel as animating starting at page load.-->
<!--          We can't use it here, since it must be triggered via the controller-->
          <div id="overview-carousel" class="carousel slide" data-ride="" data-interval="2000">
            
            <!-- Indicators -->
            <ol class="carousel-indicators">
              <li data-target="#overview-carousel" data-slide-to="0"></li>
              <li data-target="#overview-carousel" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner"></div>
            <!-- Controls -->
            <a class="left carousel-control" href="#overview-carousel" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#overview-carousel" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
          </div>
          <div class="xxl" style="color: rgba(156, 156, 156, 0.99); top: 260px;">
            Overview
            <div style="font-size: 0.3em; color: rgba(156, 156, 156, 0.59); line-height: 30px;">hit space (play/pause) or arrow keys (navigate)</div>
          </div>
        </div>
        
      </div>
      
      
    </div>
  </div>
</div>
<!-- modal-dialogue -->
<div tabindex="0" id="modal-view" class="modal fade"></div>
<!-- /.modal -->

<!-- Templates -->
<script id="flickrTemplate" type="text/x-jquery-tmpl">
  <a href='http://farm${farm}.static.flickr.com/${server}/${id}_${secret}_b.jpg' title="${title}" data-category>
    <img src='http://farm${farm}.static.flickr.com/${server}/${id}_${secret}_s.jpg'>
  </a>
</script>

<script id="flickrIntroTemplate" type="text/x-jquery-tmpl">
  <div class="dark xxl">
    <i class="glyphicon glyphicon-picture"></i>
    <span class="cover-header">flickr</span>
    <div class=" btn-primary xs">
      <a class="label recent ">flickr recent</a>
      <a class="label inter">flickr interesting</a>
    </div>
  </div>
</script>

<script id="addTemplate" type="text/x-jquery-tmpl">
  <div class="modal-dialog ${type}" style="width: 55%;">
    <div class="bg-dark content modal-content">
      <div class="modal-header dark">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">${title}</h4>
      </div>
      <div class="modal-body autoflow">
        <div class="items flex fadein in"></div>
      </div>
      <div class="modal-footer dark">
        {{tmpl() "#footerTemplate"}}
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</script>


<script id="footerTemplate" type="text/x-jquery-tmpl">
  <div class="btn-group left">
    <button type="button" class="opt-SelectAll dark {{if !contains}}disabled{{/if}}">Alles auswählen</button>
    <button type="button" class="opt-SelectInv dark {{if !contains}}disabled{{/if}}">Auswahl invertieren</button>
  </div>
  <div class="btn-group right">
    <button type="button" class="opt-AddExecute dark {{if disabled}}disabled{{/if}}">Hinzufügen</button>
    <button type="button" class="opt- dark" data-dismiss="modal">Abbrechen</button>
  </div>
</script>

<script id="modalSimpleHelpTemplate" type="text/x-jquery-tmpl">
  <ul>
    <li>Axel</li>
    <li>Nitzschner</li>
    <li>Test</li>
  </ul>
</script>
  
<script id="modalActionTemplate" type="text/x-jquery-tmpl">
  <form>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header dark">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <ul class="pager">
          <li class="refresh previous {{if min}}disabled{{/if}}"><a href="#">Refresh List</a></li>
        </ul>
        <h4 class="modal-title">${text}</h4>
      </div>
      <div class="modal-body autoflow">
        <div class="row">
          <div class="col-md-6 categories">
            <div class="list-group">
            {{tmpl($item.data.categories()) "#modalActionColTemplate"}}
            </div>
          </div>
          <div class="col-md-6 products">
            <div class="list-group">
            {{tmpl($item.data.products()) "#modalActionColTemplate"}}
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer dark">
        <button type="button" class="opt-Createcategory btn-default">New category</button>
        <button type="button" class="opt-CreateProduct btn-default" {{if type == 'category'}}disabled{{/if}}>New Product</button>
        <button type="button" class="btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="copy btn-default">Copy</button>
        <label class="hide">
        <input type="checkbox" class="remove">remove original items when done</label>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </form>
</script>

<script id="modalActionColTemplate" type="text/x-jquery-tmpl">
  {{tmpl($item.data.items) "#modalActionContentTemplate"}}
</script>

<script id="modalActionContentTemplate" type="text/x-jquery-tmpl">
  <a class="list-group-item item" id="${id}">{{if name}}${name}{{else}}${title}{{/if}}</a>
</script>

<script id="modalSmallTemplate" type="text/x-jquery-tmpl">
  
</script>

<script id="modalSimpleTemplate" type="text/x-jquery-tmpl">
  <div class="modal-dialog {{if small}}modal-sm{{else}}modal-lg{{/if}}">
    <div class="modal-content bg-dark">
      {{if header}}
      <div class="modal-header dark">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>${header}</h3>
      </div>
      {{/if}}
      {{if body}}
      <div class="modal-body dark" style="text-align: center;">
        {{html body}}
      </div>
      {{if info}}
      <div class="modal-header label-info dark">
        <div class="label label-info">${info}</div>
      </div>
      {{/if}}
      {{/if}}
      {{if footer}}
      <div class="modal-footer dark" style="position: relative">
        <div class="" style="text-align: left; max-width: 90%">{{if footer}}{{html footer}}{{/if}} </div>
        <button class="btn btnClose dark" style="">{{if footerButtonText}}${footerButtonText}{{else}}Ok{{/if}}</button>
      </div>
      {{/if}}
    </div>
  </div>
</script>

<script id="modalSimpleTemplateBody" type="text/x-jquery-tmpl">
  <div>test</div>
</script>

<script id="modal2ButtonTemplate" type="text/x-jquery-tmpl">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header dark">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>${header}</h3>
      </div>
      <div class="modal-body content">
        <ul class="items">
          ${body}
        </ul>
      </div>
      {{if info}}
      <div class="modal-header dark">
        <div class="label label-warning">${info}</div>
      </div>
      {{/if}}
      <div class="modal-footer dark">
        <button class="btn btnOk" data-dismiss="modal" aria-hidden="true">${button_1_text}</button>
        <button type="button" class="btn btnAlt">${button_2_text}</button>
      </div>
    </div>
  </div>
</script>

<script id="sidebarTemplate" type="text/x-jquery-tmpl">
  <li data-id="${id}" class="gal item data parent alb-trigger-edit">
    <div class="item-header">
      <div class="expander"></div>
      {{tmpl "#sidebarContentTemplate"}}
    </div>
    <ul class="sublist" style=""></ul>
  </li>
</script>

<script id="sidebarContentTemplate" type="text/x-jquery-tmpl">
  <div class="item-content">
    <span class="name">{{if screenname}}${$().name(screenname, 20)}{{else}}${$().name(name, 20)}{{/if}}</span>
    <span class="gal cta alb-trigger-edit">{{tmpl($item.data.details()) "#categoryDetailsTemplate"}}</span>
  </div>
</script>

<script id="productsSublistTemplate" type="text/x-jquery-tmpl">
  {{if flash}}
  <span class="author">${flash}</span>
  {{else}}
  <li data-id="${id}" class="sublist-item alb alb-trigger-edit item data {{if ignored}}ignored{{/if}}" title="${title}">
    <span class="glyphicon glyphicon-picture"></span>
    <span class="title center" title="${title}">{{if title}}${$().name(title, 16)}{{/if}}</span>
    <span class="cta">€ {{if price}}${price}{{else}}0{{/if}}</span>
  </li>
  {{/if}}
</script>

<script id="sidebarFlickrTemplate" type="text/x-jquery-tmpl">
  <li class="gal item parent" title="">
    <div class="item-header">
      <div class="expander"></div>
        <div class="item-content">
          <span class="opt-flickr" style="color: rgba(255,255,255, 1); text-shadow: 0 -1px 0 rgba(0,0,0,0.9); font-size: 1.5em;">${name}</span>
        </div>
    </div>
    <ul class="sublist" style="">
      {{tmpl($item.data.sub) "#sidebarFlickrSublistTemplate"}}
    </ul>
  </li>
</script>

<script id="sidebarFlickrSublistTemplate" type="text/x-jquery-tmpl">
  <li class="sublist-item item item-content ${klass}">
    <span class="glyphicon glyphicon-${icon}"></span>
    <span class="">${name}</span>
  </li>
</script>

<script id="overviewHeaderTemplate" type="text/x-jquery-tmpl">
</script>

<script id="categoryDetailsTemplate" type="text/x-jquery-tmpl">
    <span>${aCount} </span>
</script>

<script id="categoriesTemplate" type="text/x-jquery-tmpl">
  <li id="${id}" data-id="${id}" class="item container data fade in gal-trigger-edit" data-drag-over="thumbnail">
    <div class="thumbnail">
      <div class="inner">
        {{tmpl($item.data.details()) "#galDetailsTemplate"}}
      </div>
    </div>
    <div class="glyphicon-set right blue fade out" style="">
      <span class="tooltips downloading glyphicon glyphicon-download-alt glyphicon-white hide left fade" data-toggle="tooltip"></span>
      <span class="left">
        <a href="#" class="dd dropdown-toggle glyphicon glyphicon-chevron-down glyphicon-white" data-toggle="dropdown"></a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
          <li role="presentation" class="zoom"><a role="menuitem" tabindex="-1" data-toggle="tooltip" title="Öffnen" href="#"><i class="tooltips glyphicon glyphicon-folder-close"></i>Öffnen</a></li>
          <li class="divider"></li>
          <li role="presentation" class="delete"><a role="menuitem" tabindex="-1" data-toggle="tooltip" title="Löschen" href="#"><i class="glyphicon glyphicon glyphicon-trash"></i>Löschen</a></li>
        </ul>
      </span>
    </div>
  </li>
</script>

<script id="modalcategoriesActionTemplate" type="text/x-jquery-tmpl">
  <div class="modal-header dark">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>${header}</h3>
  </div>
  <div class="modal-body content">
    <div class="container item btn-group" data-toggle="buttons">
      {{tmpl($item.data.body) "#categoryActionTemplate"}}
    </div>
  </div>
  <div class="modal-footer dark">
    {{if info}}
    <div class="left label label-warning">${info}</div>
    {{/if}}
    <button class="btn btnOk" data-dismiss="modal" aria-hidden="true">OK</button>
    <button type="button" class="btn btnAlt">Save changes</button>
  </div>
</script>

<script id="categoryActionTemplate" type="text/x-jquery-tmpl">
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option1">${name}
  </label>
</script>

<script id="defaultActionTemplate" type="text/x-jquery-tmpl">
  <div class="modal-header dark">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>${header}</h3>
  </div>
  <div class="modal-body content">
  {{if body}}
    {{html body}}
  {{/if}}
  </div>
  {{if info}}
  <div class="modal-header dark">
    <div class="label label-warning">${info}</div>
  </div>
  {{/if}}
  <div class="modal-footer dark">
    <button class="btn btnOk" data-dismiss="modal" aria-hidden="true">OK</button>
    <button type="button" class="btn btnAlt">Save changes</button>
  </div>
</script>

<script id="missingViewTemplate" type="text/x-jquery-tmpl">
  <div class="dark xxl">
    <i class="glyphicon glyphicon-question-sign"></i>
    <span class="cover-header">404</span><span>Not Found Error</span>
    <div class=" btn-primary xs">
      <a class="label relocate">Proceed to Overview (or use TAB for sidebar)</a>
    </div>
  </div>
</script>

<script id="galDetailsTemplate" type="text/x-jquery-tmpl">
  <div style="">{{if name}}${name.slice(0, 15)}{{else}}...{{/if}}</div>
  <div style="font-size: 0.8em; font-style: oblique;">Products: ${aCount}</div>
  <div style="font-size: 0.8em; font-style: oblique;">Images: ${iCount}</div>
  <div class="opt-SlideshowPlay" style="">
    <span class="label label-default">
    <i class="glyphicon glyphicon-picture"></i><i class="glyphicon glyphicon-play"></i>
    ${pCount}
    </span>
  </div>
  {{if pCount}}
  <div class="hide" style="font-size: 0.8em; font-style: oblique; ">hit space to play</div>
  {{/if}}
</script>

<script id="editCategoryTemplate" type="text/x-jquery-tmpl">
  <div class="input-group left">
    <span class="input-group-addon" id="basic-addon1">Name</span>
    <input type="text" class="form-control" placeholder="Name der Kategorie" aria-describedby="basic-addon1" name="screenname" value="{{html screenname}}">
  </div>
</script>

<script id="productsTemplate" type="text/x-jquery-tmpl">
  <li id="${id}" data-id="${id}" class="item fade in alb-trigger-edit {{if Category.record}}{{if ignored}}ignored{{/if}}{{/if}}" draggable="true">
    <div class="thumbnail"></div>
    {{if Category.record}}
    <div class="glyphicon-set left" style="">
      <span class="dd">
        <a href="#" title="{{if ignored}}Einblenden{{else}}Ausblenden{{/if}}" class="glyphicon glyphicon-eye glyphicon-white opt-ignored"></a>
      </span>
    </div>
    {{/if}}
    <div class="glyphicon-set blue right fade out" style="">
      <span class="dd tooltips downloading glyphicon glyphicon-download-alt glyphicon-white hide left fade" data-toggle="tooltip"></span>
      <span class="left">
        <a href="#" class="dd dropdown-toggle glyphicon glyphicon-chevron-down glyphicon-white" data-toggle="dropdown"></a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
          <li role="presentation" class="zoom"><a role="menuitem" tabindex="-1" data-toggle="tooltip" title="Öffnen" href="#"><i class="tooltips glyphicon glyphicon-picture"></i>Fotos anzeigen</a></li>
          {{if Category.record}}
          <li role="presentation" class="opt-original"><a role="menuitem" tabindex="-1" data-toggle="tooltip" title="Im Katalog anzeigen" href="#"><i class="glyphicon glyphicon glyphicon-file"></i>Im Katalog anzeigen</a></li>
          {{/if}}
          <li class="divider"></li>
          <li role="presentation" class="opt-delete"><a role="menuitem" tabindex="-1" data-toggle="tooltip" title="{{if Category.record}}Entfernen{{else}}Löschen{{/if}} " href="#"><i class="glyphicon glyphicon glyphicon-trash"></i>{{if Category.record}}Entfernen{{else}}Löschen{{/if}}</a></li>
        </ul>
      </span>
    </div>
    <div class="titles">
      <div class="title">{{if title}}${$().name(title, 50)}{{/if}}</div>
      <div class="subtitle">{{if subtitle}}{{html $().name(subtitle, 113)}}{{/if}}</div>
        <section class="info-badges">
          <span class="link glyphicon glyphicon-link {{if link}}{{else}}warning-badge{{/if}}"></span>
          <span class="price {{if price}}{{else}}warning-badge{{/if}}">€&nbsp;{{if price}}${price}{{else}}0,00{{/if}}</span>
        </section>
    </div>
  </li>
</script>

<script id="editProductTemplate" type="text/x-jquery-tmpl">            
  <div class="input-group left" style="width: 68%">
    <span class="input-group-addon" id="basic-addon1">Titel</span>
    <input type="text" class="form-control" placeholder="Produkttitel" aria-describedby="basic-addon1" name="title" value="{{html title}}">
  </div>

  <div class="input-group right" style="width: 22%">
    <span class="input-group-addon" id="basic-addon2">Preis (€)</span>
    <input type="text" class="form-control" placeholder="Preis" aria-describedby="price" name="price" value="${price}">
  </div>

  <div class="input-group left">
    <span class="input-group-addon" id="subtitle">Kurzbeschreibung</span>
    <textarea type="text" class="form-control" placeholder="Kurzbeschreibung" aria-describedby="subtitle" name="subtitle" value="{{html subtitle}}">{{html subtitle}}</textarea>
  </div>
  
  <div class="input-group left">
    <span class="input-group-addon" id="notes">Notizen</span>
    <textarea type="text" class="form-control" aria-describedby="notes" placeholder="Notizen" name="notes">{{html notes}}</textarea>
  </div>

  <div class="input-group left">
    <div class="input-group-btn">
      <button type="button" class="btn btn-default" aria-label="Help">
        <span class="glyphicon glyphicon-link"></span>
      </button>
    </div>
    <input type="text" class="form-control" aria-describedby="link"  placeholder="Link to Hood.de" name="link" value="${link}">
  </div>
              
</script>

<script id="editDescriptionTemplate" type="text/x-jquery-tmpl">
  <div id="${id}" class="input-group data" draggable="true">
    <span class="input-group-addon" id="basic-addon1">${order}</span>
    <input class="form-control" placeholder="Beschreibung #${order}" aria-label="Text input with segmented button dropdown" name="description" value="{{html description}}">
    <div class="input-group-btn">
      <button type="button" class="btn btn-default opt-remove">-</button>
      <button type="button" class="btn btn-default opt-add">+</button>
    </div>
  </div>
</script>

<script id="editPhotoTemplate" type="text/x-jquery-tmpl">
  <div class="input-group left">
    <span class="input-group-addon" id="basic-addon1">Titel</span>
    <input type="text" class="form-control" placeholder="Fototitel" aria-describedby="basic-addon1" name="name" value="{{html name}}">
  </div>
</script>

<script id="productSelectTemplate" type="text/x-jquery-tmpl">
  <option {{if ((constructor.record) && (constructor.record.id == id))}}selected{{/if}} value="${id}">${title}</option>
</script>

<script id="headerCategoryTemplate" type="text/x-jquery-tmpl">
  <section class="top viewheader fadeelement">
    <div class="left">
      <div class="header-title">
        <h1>Categories Overview</h1>
      </div>
    </div>
    {{tmpl() "#categorySpecsTemplate"}}
  </section>
  <section class="hide">
    <span class="fadeelement breadcrumb">
      <li style="padding: 0px 19px;" class="opt-Prev">
        <div style="" class="go-up"></div>
      </li>
    </span>
  </section>
</script>

<script id="headerProductTemplate" type="text/x-jquery-tmpl">
  <section class="top viewheader fadeelement">
    <div class="left">  
      <div class="header-title">
        {{if model.record}}
        <h3>
        <span class="label label-default">{{if category.screenname}}${$().name(category.screenname, 10)}{{else}}${$().name(category.name, 10)}{{/if}}</span>
        </h3>
        <h3>
        {{if modelProduct.record}}
        <span class="label label-primary">${$().name(modelProduct.record.title, 15)}</span>
        {{/if}}
        </h3>
        {{else}}
        <h1>Produktkatalog</h1>
        {{/if}}
      </div>
    </div>
    {{tmpl() "#productSpecsTemplate"}}
  </section>
  <section class="hide">
    <span class="fadeelement breadcrumb">
      <li style="padding: 0px 19px;" class="opt-Prev">
        <div style="" class="go-up"></div>
      </li>
      <li class="gal gal-trigger-edit">
        <a href="#">categories</a>
      </li>
      <li class="alb active alb-trigger-edit">Products</li>
    </span>
  </section>
</script>

<script id="headerPhotosTemplate" type="text/x-jquery-tmpl">
  <section class="top viewheader fadeelement">
    <div class="left">  
      <div class="header-title">
        {{if product}}
        <h3>
        <span class="label label-{{if category.name}}default{{else}}warning{{/if}}">{{if category.name}}${$().name(category.name, 10)}{{else}}...{{/if}}</span>
        </h3>
        <h3 style="display: inline-block;">
        <span class="label label-{{if model.record}}primary{{else}}warning{{/if}}">{{if modelProduct.record}}{{if product.title}}${$().name(product.title, 15)}{{else}}...{{/if}}{{else}}None{{/if}}</span>
        </h3>
        {{else}}
        <h1>Fotokatalog</h1>
        {{/if}}
      </div>
    </div>
    {{tmpl() "#photoSpecsTemplate"}}
  </section>
  {{if zoomed}}
  {{tmpl() "#photoBreadcrumbTemplate"}}
  {{else}}
  {{tmpl() "#photosBreadcrumbTemplate"}}
  {{/if}}
</script>

<script id="headerPhotoTemplate" type="text/x-jquery-tmpl">
  <section class="top viewheader fadeelement">
    <div class="left">  
      <div class="header-title">
        {{if product}}
        <h3>
        <span class="label label-{{if category.name}}default{{else}}warning{{/if}}">{{if category.name}}${$().name(category.name, 10)}{{else}}...{{/if}}</span>
        </h3>
        <h3>
        <span class="label label-{{if model.record}}primary{{else}}warning{{/if}}">{{if modelProduct.record}}{{if product.title}}${$().name(product.title, 10)}{{else}}...{{/if}}{{else}}{{/if}}</span>
        </h3>
        {{else}}
        <h1>Fotokatalog</h1>
        {{/if}}
      </div>
    </div>
    {{tmpl() "#photoSpecsTemplate"}}
  </section>
  {{tmpl() "#photoBreadcrumbTemplate"}}
</script>

<script id="photosBreadcrumbTemplate" type="text/x-jquery-tmpl">
  <section class="hide">
    <span class="fadeelement breadcrumb">
      <li style="padding: 0px 19px;" class="opt-Prev">
        <div style="" class="go-up"></div>
      </li>
      <li class="gal gal-trigger-edit">
        <a href="#">categories</a>
      </li>
      <li class="alb alb-trigger-edit">
        <a href="#">Products</a>
      </li>
      <li class="pho active">Photos</li>
    </span>
  </section>
</script>


<script id="photoBreadcrumbTemplate" type="text/x-jquery-tmpl">
  <section class="hide">
    <span class="fadeelement breadcrumb">
      <li style="padding: 0px 19px;" class="opt-Prev">
        <div style="" class="go-up"></div>
      </li>
      <li class="gal gal-trigger-edit">
        <a href="#">categories</a>
      </li>
      <li class="alb alb-trigger-edit">
        <a href="#">Products</a>
      </li>
      <li class="pho pho-trigger-edit">
        <a href="#">Photos</a>
      </li>
      <li class="active">{{if photo.src}}${photo.src}{{else}}deleted{{/if}}</li>
    </span>
  </section>
</script>


<script id="categorySpecsTemplate" type="text/x-jquery-tmpl">
  <div class="right">
    <span class="">
    <div class="btn btn-sm">Kategorien<b><div>${model.count()}</div></b></div>
    </span> 
    <span class="">
    <div class="btn btn-sm">Produkte<b><div>${modelGas.count()} von ${Product.count()}</div></b></div>
    </span> 
  </div>
</script>

<script id="productSpecsTemplate" type="text/x-jquery-tmpl">
  <div class="right">
    <span class="">
      <div class="opt-Select{{if model.details().sCount>0}}None deselect{{else}}All select{{/if}} btn btn-sm {{if model.details().sCount>0}}{{/if}}"><b class=""><div>${model.details().sCount}</div></b></div>
    </span> 
    <span class="">
    <div class="btn btn-sm">Produkte<b><div>${model.details().aCount}{{if model.record}} von ${modelProduct.count()}{{/if}}</div></b></div>
    </span> 
  </div>
</script>

<script id="photoSpecsTemplate" type="text/x-jquery-tmpl">
  <div class="right">
    <span class="">
    <div class="opt-Select{{if model.details().sCount>0}}None deselect{{else}}All select{{/if}} btn btn-sm {{if model.details().sCount>0}}{{/if}}"><b class=""><div>${model.details().sCount}</div></b></div>
    </span> 
  </div>
</script>

<script id="productCountTemplate" type="text/x-jquery-tmpl">
  <span class="cta">€ ${price}</span>
</script>

<script id="productInfoTemplate" type="text/x-jquery-tmpl">
  <ul>
    <li class="tr name">
      <span class="td left">{{if title}}${title}{{else}}no title{{/if}} </span><span class="td"></span><span class="td right"> {{tmpl($item.data) "#productCountTemplate"}}</span>
    </li>
    <li class="tr italic">{{if photo}}
      <span class="td">Photo</span><span class="td">:</span><span class="td">${photo}</span>{{/if}}
    </li>
  </ul>
</script>

<script id="photosDetailsTemplate" type="text/x-jquery-tmpl">
  Author:  <span class="label label-default">${author}</span>
  category:  <span class="label label-{{if category}}default{{else}}warning{{/if}}">{{if category}}{{if category.name}}${category.name}{{else}}no name{{/if}}{{else}}not found{{/if}}</span>
  <br>
  <h2>Photos in Product: </h2>
  <label class="h2 chopin">{{if product.title}}${product.title}{{else}}no title{{/if}}</label>
  <span class="active cta right">
    <h2>Total: ${count}</h2>
  </span>
</script>

<script id="photoDetailsTemplate" type="text/x-jquery-tmpl">
  Author:&nbsp;<span class="label label-default">{{if author}}${author}{{/if}}</span>
  category:&nbsp;<span class="label label-{{if category}}default{{else}}warning{{/if}}">{{if category}}{{if category.name}}${category.name}{{else}}no name{{/if}}{{else}}not found{{/if}}</span>
  Product:&nbsp;<span class="label label-{{if product}}default{{else}}warning{{/if}}">{{if product}}{{if product.title}}${product.title}{{else}}no title{{/if}}{{else}}not found{{/if}}</span>
  <br>
  <h2>Photo:</h2>
  <label class="h2 chopin">
    {{if photo}}
    {{if photo.title}}${photo.title}{{else}}{{if photo.src}}${photo.src}{{else}}no title{{/if}}{{/if}}
    {{else}}
    deleted
    {{/if}}
  </label>
</script>

<script id="photosTemplate" type="text/x-jquery-tmpl">
  <li  id="${id}" data-id="${id}" class="item data fade in pho-trigger-edit" draggable="true">
    {{tmpl "#photosThumbnailTemplate"}}
    <div class="center hide" style="color: aliceblue">{{if order}}${order}{{/if}}</div>
  </li>
</script>

<script id="photosSlideshowTemplate" type="text/x-jquery-tmpl">
  <li  class="item data ">
    <a class="thumbnail image left fadeslow in"></a>
  </li>
</script>

<script id="photoTemplate" type="text/x-jquery-tmpl">
  <li data-id="${id}" class="item pho-trigger-edit">
    {{tmpl "#photoThumbnailTemplate"}}
  </li>
</script>

<script id="photosThumbnailTemplate" type="text/x-jquery-tmpl">
  <div class="thumbnail image left fadeslow"></div>
  <div class="glyphicon-set right blue fade out" style="">
    <span class="tooltips downloading glyphicon glyphicon-download-alt glyphicon-white hide left fade" data-toggle="tooltip"></span>
    <span class="left">
      <a href="#" class="dd dropdown-toggle glyphicon glyphicon-chevron-down glyphicon-white" data-toggle="dropdown"></a>
      <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
        <li role="presentation" class="zoom"><a role="menuitem" tabindex="-1" data-toggle="tooltip" title="Öffnen" href="#"><i class="tooltips glyphicon glyphicon-resize-full"></i>Öffnen</a></li>
        <li class="divider"></li>
        <li role="presentation" class="dropdown-header disabled"><a role="menuitem" tabindex="-1" data-toggle="tooltip" title="Rotate" href="#"><i class="tooltips"></i>Rotieren:</a></li>
        <li role="presentation" class="rotate-cw"><a role="menuitem" tabindex="-1" data-toggle="tooltip" title="Im Uhrzeiger drehen" href="#"><i class="tooltips glyphicon glyphicon glyphicon-circle-arrow-right"></i>Im Uhrzeiger</a></li>
        <li role="presentation" class="rotate-ccw"><a role="menuitem" tabindex="-1" data-toggle="tooltip" title="Gegen Uhrzeiger drehen" href="#"><i class="tooltips glyphicon glyphicon glyphicon-circle-arrow-left"></i>Gegen Uhrzeiger</a></li>
        <li class="divider"></li>
        {{if Product.record}}
        <li role="presentation" class="original"><a role="menuitem" tabindex="-1" data-toggle="tooltip" title="Im Katalog anzeigen" href="#"><i class="glyphicon glyphicon glyphicon-file"></i>Im Katalog anzeigen</a></li>
        <li class="divider"></li>
        {{/if}}
        <li role="presentation" class="delete"><a role="menuitem" tabindex="-1" data-toggle="tooltip" title="{{if Product.record}}Entfernen{{else}}Löschen{{/if}}" href="#"><i class="glyphicon glyphicon glyphicon-trash"></i>{{if Product.record}}Entfernen{{else}}Löschen{{/if}}</a></li>
      </ul>
    </span>
  </div>
</script>

<script id="photoThumbnailTemplate" type="text/x-jquery-tmpl">
  <div class="thumbnail image left"></div>
  <div class="glyphicon-set right blue fade out" style="">
    <span class="tooltips downloading glyphicon glyphicon-download-alt glyphicon-white hide left fade" data-toggle="tooltip"></span>
    <span class="left">
      <a href="#" class="dd dropdown-toggle glyphicon glyphicon-chevron-down glyphicon-white" data-toggle="dropdown"></a>
      <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
        <li role="presentation" class="zoom"><a role="menuitem" tabindex="-1" data-toggle="tooltip" title="Full Size" href="#"><i class="tooltips glyphicon glyphicon-resize-full"></i>Full size</a></li>
        <li class="divider"></li>
        <li role="presentation" class="dropdown-header disabled"><a role="menuitem" tabindex="-1" data-toggle="tooltip" title="Rotate" href="#"><i class="tooltips"></i>Rotate:</a></li>
        <li role="presentation" class="rotate-cw"><a role="menuitem" tabindex="-1" data-toggle="tooltip" title="Rotate cw" href="#"><i class="tooltips glyphicon glyphicon-circle-arrow-right"></i>cw</a></li>
        <li role="presentation" class="rotate-ccw"><a role="menuitem" tabindex="-1" data-toggle="tooltip" title="Rotate ccw" href="#"><i class="tooltips glyphicon glyphicon-circle-arrow-left"></i>ccw</a></li>
        <li class="divider"></li>
        <li role="presentation" class="delete"><a role="menuitem" tabindex="-1" data-toggle="tooltip" title="{{if Product.record}}Entfernen{{else}}Löschen{{/if}}" href="#"><i class="glyphicon glyphicon glyphicon-trash"></i>{{if Product.record}}Entfernen{{else}}Löschen{{/if}}</a></li>
      </ul>
    </span>
  </div>
  <div class="center">{{if title}}${title.substring(0, 15)}{{else}}{{if src}}${src.substring(0, 15)}{{else}}no title{{/if}}{{/if}}</div>
</script>

<script id="photoThumbnailSimpleTemplate" type="text/x-jquery-tmpl">
  <div class="opt- thumbnail image left"></div>
</script>

<script id="preloaderTemplate" type="text/x-jquery-tmpl">
  <div class="preloader">
    <div class="content">
      <div></div
    </div>
  </div>
</script>

<script id="photoInfoTemplate" type="text/x-jquery-tmpl">
  <ul>
    <li class="">
      <span class="">{{if title}}{{html title}}{{else}}${src}{{/if}}</span>
    </li>
    <li class="tr">{{if model}}
      <span class="td">Model</span><span class="td">:</span><span class="td">${model}</span>{{/if}}
    </li>
    <li class="tr">{{if software}}
      <span class="td">Software</span><span class="td">:</span><span class="td">${software}</span>{{/if}}
    </li>
    <li class="tr">{{if exposure}}
      <span class="td">Exposure</span><span class="td">:</span><span class="td">${exposure}</span>{{/if}}
    </li>
    <li class="tr">{{if iso}}
      <span class="td">Iso</span><span class="td">:</span><span class="td">${iso}</span>{{/if}}
    </li>
    <li class="tr">{{if aperture}}
      <span class="td">Aperture</span><span class="td">:</span><span class="td">${aperture}</span>{{/if}}
    </li>
    <li class="tr">{{if captured}}
      <span class="td">Captured</span><span class="td">:</span><span class="td">${captured}</span>{{/if}}
    </li>
    <li class="tr italic">{{if photo}}
      <span class="td">Photo</span><span class="td">:</span><span class="td">${photo}</span>{{/if}}
    </li>
  </ul>
</script>

<script id="toolsTemplate" type="text/x-jquery-tmpl">
  {{if dropdown}}
    {{tmpl(itemGroup)  "#dropdownTemplate"}}
  {{else}}
  <li class="${klass}"{{if outerstyle}} style="${outerstyle}"{{/if}}{{if id}} id="${id}"{{/if}}>
    <{{if type}}${type} class="{{if icon}}symbol{{/if}} tb-name {{if innerklass}}${innerklass}{{/if}}"{{else}}button class="symbol dark {{if innerklass}}${innerklass}{{/if}}" {{if dataToggle}} data-toggle="${dataToggle}"{{/if}}{{/if}}
    {{if innerstyle}} style="${innerstyle}"{{/if}}
    {{if disabled}}disabled{{/if}}>
    {{if icon}}
    <i class="glyphicon glyphicon-${icon} {{if iconcolor}}glyphicon-${iconcolor}{{/if}}"></i> 
    {{/if}}
    {{if icon2}}
    <i class="glyphicon glyphicon-${icon2} {{if iconcolor}}glyphicon-${iconcolor}{{/if}}"></i> 
    {{/if}}
    {{html name}}
    </{{if type}}${type}{{else}}button{{/if}}>
  </li>
  {{/if}}
</script>

<script id="dropdownTemplate" type="text/x-jquery-tmpl">
  <li class="dropdown" {{if id}} id="${id}"{{/if}} >
    <a class="dropdown-toggle" data-toggle="dropdown">
      {{if icon}}<i class="glyphicon glyphicon-${icon}  {{if iconcolor}}glyphicon glyphicon-${iconcolor}{{/if}}"></i>{{/if}}
      {{html name}}
      <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
      {{tmpl(content) "#dropdownListItemTemplate"}}
    </ul>
  </li>
</script>

<script id="dropdownListItemTemplate" type="text/x-jquery-tmpl">
  {{if devider}}
  <li class="divider"></li>
  {{else}}
  <li>
    <a {{if dataToggle}} data-toggle="${dataToggle}"{{/if}} class="${klass} {{if disabled}}disabled{{/if}} {{if header}}dropdown-header{{/if}}">
      <i class="glyphicon glyphicon-{{if icon}}${icon} {{if iconcolor}}glyphicon glyphicon-${iconcolor}{{/if}}{{/if}}"></i>
      {{html name}}
      {{if shortcut}}
      <span class="label label-primary">{{html shortcut}}</span>
      {{/if}}
    </a>
  </li>
  {{/if}}
</script>

<script id="testTemplate" type="text/x-jquery-tmpl">
  {{if eval}}{{tmpl($item.data.eval()) "#testTemplate"}}{{/if}}
</script>

<script id="noSelectionTemplate" type="text/x-jquery-tmpl">
  {{html type}}
</script>

<script id="loginTemplate" type="text/x-jquery-tmpl">
  <div class="btn-group">
    <button type="button" class="dropdown-toggle dark clear" style="min-width: 180px;" data-toggle="dropdown">
      <i class="glyphicon glyphicon-user"></i>
      <span>${user.name}</span>
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
      <li class="opt-logout"><a href="#">Logout</a></li>
      <li class="divider"></li>
      <li class="opt-trace"><a href="#">
        <i class="glyphicon {{if trace}}glyphicon-ok{{/if}}"></i>Trace</a>
      </li>
    </ul>
  </div>
</script>

<script id="overviewTemplate" type="text/x-jquery-tmpl">
  <div class="item recents active">
    <img src="/img/overview-background.png" style="width: 800px; height: 370px;">
    <div class="carousel-item">
      {{tmpl($item.data.photos) "#overviewPhotosTemplate"}}
    </div>
    <div class="carousel-caption">
      <h3>Recents</h3>
      <p>Last uploaded images</p>
    </div>  
  </div>
  <div class="item summary">
    <img src="/img/overview-background.png" style="width: 800px; height: 370px;">
    <div class="carousel-item">
      {{tmpl($item.data.summary) "#overviewSummaryTemplate"}}
    </div>
    <div class="carousel-caption">
      <h3>Summary</h3>
    </div> 
  </div>
</script>

<script id="overviewPhotosTemplate" type="text/x-jquery-tmpl">
  <div class="item">
    {{tmpl "#photoThumbnailSimpleTemplate"}}
  </div>
</script>

<script id="overviewSummaryTemplate" type="text/x-jquery-tmpl">
  <table class="carousel table center">
    <tbody>
      <tr>
        <td>categories</td>
        <td>Products</td>
        <td>Photos</td>
      </tr>
      <tr class="h1">
        <td>${Category.records.length}</td>
        <td>${Product.records.length}</td>
        <td>${Photo.records.length}</td>
      </tr>
    </tbody>
  </table>
</script>

<script id="refreshTemplate" type="text/x-tmpl">
  <button class="opt-Refresh dark left">
    <i class="glyphicon glyphicon-${icon}" style="line-height: 1.5em; padding-left: 8px;"></i>
    <span></span>
  </button>
</script>

<script id="fileuploadTemplate" type="text/x-jquery-tmpl">
  <span style="font-size: 0.6em;" class=" alert alert-success">
    <span style="font-size: 2.9em; font-family: cursive; margin-right: 20px;" class="alert alert-error">"</span>
    {{if product}}{{if product.title}}${product.title}{{else}}...{{/if}}{{else}}all photos{{/if}}
    <span style="font-size: 5em; font-family: cursive;  margin-left: 20px;" class="alert alert-block uploadinfo"></span>
  </span>
</script>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            {% if (file.error) { %}
                <div><span class="label label-important">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <p class="size">{%=o.formatFileSize(file.size)%}</p>
            {% if (!o.files.error) { %}
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar" style="width:0%;"></div></div>
            {% } %}
        </td>
        <td>
            {% if (!o.files.error && !i && !o.options.autoUpload) { %}
                <button class="dark start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="dark cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade dark">
        <td>
            <button class="dark delete" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <i class="glyphicon glyphicon-remove"></i>
                <span></span>
            </button>
        </td>
        <td>
            <span class="preview">
                {% if (file.thumbnail_url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" class="category" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" class="{%=file.thumbnail_url?'category':''%}" download="{%=file.name%}">{%=file.name%}</a>
            </p>
            {% if (file.error) { %}
                <div><span class="label label-important">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
    </tr>
{% } %}
</script>

<script id="sidebarPreviewTemplate" type="text/x-jquery-tmpl">
  <li class="" title="">
    <div class="item-header">
      <div class="expander"></div>
        <div class="item-content">
          <span class="opt-preview">${name}</span>
        </div>
    </div>
    <ul class="sublist" style="">
      <li class="sublist-item item item-content ${klass}">
        {{tmpl($item.data.product) "#norbuPricingTemplate"}}
      </li>
    </ul>
  </li>
</script>

<script id="norbuPricingTemplate" type="text/x-tmpl">
  <div id="${product.id}" class="pricing pricing--norbu" style="margin:0;">              
    <div class="pricing__item">
      <h3 class="pricing__title">${product.title}</h3>
      <p class="pricing__sentence">${product.subtitle}</p>
      <div class="pricing__price"><span class="pricing__currency">€</span>${product.price}
        <a href="${product.link}" target="_blank" class="" aria-disabled="false">
          {{tmpl($item.data.photo) "#norbuImageListTemplate" }}
        </a>
      </div>
      <div class="pricing__feature-list">
        <ul class="">{{tmpl($item.data.descriptions) "#norbuFeatureListTemplate" }}</ul>
      </div>
      <a href="${product.link}" target="_blank" class="pricing__action btn btn-dark btn-lg" role="button" aria-disabled="false">Zum Shop</a>
    </div>
  </div>
</script>

<script id="norbuImageListTemplate" type="text/x-tmpl">
  <div id="${id}" class="pricing__image"><img class="image" src="/img/semperfi.png"/></div>
</script>

<script id="norbuFeatureListTemplate" type="text/x-tmpl">
  <li class="pricing__feature">{{html description}</li>
</script>





