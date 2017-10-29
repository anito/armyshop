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
        <a href="/" target="_blank">
            <div class="left" style="position: relative;">
                <h2 class="lehmann">
                    <span class="chopin">Admin</span>
                    <span class="lehmann-01"></span>
                    <span class="lehmann-02"></span>
                </h2>
            </div>
        </a>
        <div id="login" class="right" style="margin: 15px 5px;"></div>
    </header>
    <div id="wrapper" class="hbox flex">
        <div id="sidebar" class="views bg-medium hbox vdraggable">
            <div class="vbox sidebar canvas bg-dark flex inner" style="display: none">
                <div class="search">
                    <form class="form-search">
                        <i class="clear-search glyphicons glyphicons-remove-circle"></i>
                        <input class="search-query" type="search" placeholder="Produktsuche">
                    </form>
                </div>
                <ul id="preview" class="autoflow noborder">
                    <li class="preview parent flex" style="">
                        <div class="item-header opt-preview" style="position: relative; top: -7px;">
                            <div class="expander" style="position: relative; top: 20px;"></div>
                            <div class="item-content">
                                <span class="">Vorschau</span>
                            </div>
                        </div>
                        <ul class="sublist tile pricing pricing--norbu" style="">
                            <li class="content item item-content"></li>
                        </ul>
                    </li>
                </ul>
                <ul class="items flex vbox autoflow"></ul>
                <footer class="footer">
                    <div style="white-space: nowrap; overflow: hidden;">
                        <div id="refresh"></div>
                        <button class="opt-CreateCategory blue hide">
                            <i class="glyphicons glyphicons-plus"></i>
                            <span>Kategorie</span>
                        </button>
                        <button class="opt-CreateProduct blue right">
                            <i class="glyphicons glyphicons-plus"></i>
                            <span>Produkt</span>
                        </button>
                    </div>
                </footer>
            </div>
            <div class="vdivide draghandle"></div>
        </div>
        <div id="content" class="views vbox flex">
            <div tabindex="2" id="show" class="view canvas vbox flex fade deselector">
                <div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="z-index: 100001; top: 65px;">
                    <div class="modal-dialog" role="document">needed by Modal</div>
                </div>
                <ul class="options hbox toolbar">
                    <nav class="navbar navbar-expand-lg toolbar toolbar-one hbox nav"></nav>
                    <li class="splitter flex"></li>
                    <nav class="navbar navbar-expand-lg toolbar toolbar-two hbox nav hide"></nav>
                    <li class="splitter flex"></li>
                    <nav class="navbar navbar-expand-lg toolbar toolbar-three hbox nav"></nav>
                </ul>
                <div class="contents views vbox flex fadeelement content bg-dark" style="height: 0;">
                    <div class="header views vbox">
                        <div data-model-name="Root" data-models-name="Category" class="categories  view vbox"></div>
                        <div data-model-name="Category" data-models-name="Product" class="products view vbox"></div>
                        <div data-model-name="Product" data-models-name="Photo" class="photos view vbox"></div>
                        <div data-model-name="Product" data-models-name="Photo" class="photo view vbox"></div>
                        <div data-model-name="PhotosTrash" data-models-name="Photo" class="photos-trash view vbox inline"></div>
                        <div data-model-name="ProductsTrash" data-models-name="Product" class="products-trash view vbox inline"></div>
                        <div class="overview view"></div>
                    </div>
                    <div class="view wait content vbox flex autoflow" style=""></div>
                    <div data-model-name="Root" data-models-name="Category" class="view categories content vbox flex data parent autoflow" style="">
                        <div class="items flex autoflow fadein in1">Categories</div>
                    </div>
                    <div data-model-name="Category" data-models-name="Product" class="view products content vbox flex data parent autoflow fadeelement" style="">
                        <div class="hoverinfo fade"></div>
                        <div class="items flex autoflow fadein in1">Products</div>
                    </div>
                    <div data-model-name="Product" data-models-name="Photo" class="view photos content vbox flex data parent autoflow fadeelement" style="">
                        <div class="hoverinfo fade"></div>
                        <div class="items flex autoflow fadein in1" data-toggle="modal-category"
                             data-target="#modal-category" data-selector="a">Photos
                        </div>
                    </div>
                    <div data-model-name="Product" data-models-name="Photo" class="view photo content vbox flex data parent autoflow fadeelement nopad" style="">
                        <div class="hoverinfo fade"></div>
                        <div class="items flex autoflow fadein in1 nopad">Photo</div>
                    </div>
                    <div data-model-name="ProductsTrash" data-models-name="Product" tabindex="1" class="view products-trash content vbox flex data parent autoflow fadeelement" style="">
                        <div class="items flex autoflow fadein in1">Product Trash</div>
                    </div>
                    <div data-model-name="PhotosTrash" data-models-name="Photo" tabindex="1" class="view photos-trash content vbox flex data parent autoflow fadeelement" style="">
                        <div class="items flex autoflow fadein in1">Photo Trash</div>
                    </div>
                </div>
                <div id="views" class="settings hbox autoflow">
                    <div class="views contents bg-medium vbox flex autoflow hdraggable" style="position: relative">
                        <div class="hdivide draghandle">
                            <span class="opt opt-CloseDraghandle glyphicons glyphicons-resize-vertical glyphicons glyphicons-white right" style="cursor: pointer;"></span>
                        </div>
                        <div id="ga" class="view flex vbox bg-dark" style="">
                            <div class="footer" style="">
                                <div class="span6" style="margin: 10px; white-space: nowrap; overflow: hidden;">
                                    <div class="btn-group-sm left">
                                        <button class="dark cat-trigger-edit active">
                                            <i class="glyphicons glyphicons-pencil"></i>
                                            <span>Kategorie</span>
                                        </button>
                                        <button class="dark pro-trigger-edit">
                                            <i class="glyphicons glyphicons-pencil"></i>
                                            <span>Produkt</span>
                                        </button>
                                        <button class="dark pho-trigger-edit">
                                            <i class="glyphicons glyphicons-pencil"></i>
                                            <span>Foto</span>
                                        </button>
                                    </div>
                                    <div class="btn-group-sm right">
                                        <button type="submit" class="blue opt-CreateCategory">
                                            <i class="glyphicons glyphicons-plus"></i>
                                            <span>Kategorie</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="vbox flex autoflow views" style="">
                                <table role="presentation" class="table content"></table>
                            </div>
                        </div>
                        <div id="al" class="view views flex vbox  bg-dark content" style="">
                            <div class="footer" style="">
                                <div class="span6" style="margin: 10px; white-space: nowrap; overflow: hidden;">
                                    <div class="btn-group-sm left">
                                        <button class="dark cat-trigger-edit">
                                            <i class="glyphicons glyphicons-pencil"></i>
                                            <span>Kategorie</span>
                                        </button>
                                        <button class="dark pro-trigger-edit active">
                                            <i class="glyphicons glyphicons-pencil"></i>
                                            <span>Produkt</span>
                                        </button>
                                        <button class="dark pho-trigger-edit">
                                            <i class="glyphicons glyphicons-pencil"></i>
                                            <span>Foto</span>
                                        </button>
                                    </div>
                                    <div class="btn-group-sm right">
                                        <button type="submit" class="dark opt-EditorProduct">
                                            <i class="glyphicons glyphicons-pencil"></i>
                                            <span>Details</span>
                                        </button>
                                        <button type="submit" class="dark opt-EditorDescription">
                                            <i class="glyphicons glyphicons-pencil"></i>
                                            <span>Eigenschaften</span>
                                        </button>
                                        <button type="submit" class="blue opt-CreateProduct">
                                            <i class="glyphicons glyphicons-plus"></i>
                                            <span>Produkt</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="vbox flex autoflow views" style="">
                                <table role="presentation" class="table description view"></table>
                                <table role="presentation" class="table product view"></table>
                                <table role="presentation" class="table noproduct view"></table>
                            </div>
                        </div>
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
                                            <div class="btn-group-sm left">
                                                <button class="dark cat-trigger-edit">
                                                    <i class="glyphicons glyphicons-pencil"></i>
                                                    <span>Kategorie</span>
                                                </button>
                                                <button class="dark pro-trigger-edit">
                                                    <i class="glyphicons glyphicons-pencil"></i>
                                                    <span>Produkt</span>
                                                </button>
                                                <button class="dark pho-trigger-edit active">
                                                    <i class="glyphicons glyphicons-pencil"></i>
                                                    <span>Foto</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="span6 right" style="margin: 10px; white-space: nowrap; overflow: hidden;">
                                            <div class="btn-group-sm">
                                                <button type="submit" class="dark start">
                                                    <i class="glyphicons glyphicons-upload"></i>
                                                    <span>Start Upload</span>
                                                </button>
                                                <button type="reset" class="dark cancel">
                                                    <i class="glyphicons glyphicons-ban-circle"></i>
                                                    <span>abbrechen</span>
                                                </button>
                                                <button type="button" class="dark delete">
                                                    <i class="glyphicons glyphicons-remove"></i>
                                                    <span>Liste leeren</span>
                                                </button>
                                                <button type="submit" class="dark start opt-editor">
                                                    <i class="glyphicons glyphicons-pencil"></i>
                                                    <span>Fotottitel</span>
                                                </button>
                                                <!-- The loading indicator is shown during file processing -->
                                                <!-- The fileinput-button span is used to style the file input field as button -->
                                                <button class="blue fileinput-button">
                                                    <i class="glyphicons glyphicons-plus"></i>
                                                    <span>Fotos</span>
                                                    <input type="file" name="files[]" multiple>
                                                </button>
                                                <span class="fileupload-loading"></span>
                                            </div>
                                        </div>
                                        <!-- The global progress information -->
                                        <div class="span3 fileupload-progress fade" style="width: 260px; padding: 24px 0; display: table-cell;">
                                            <!-- The global progress bar -->
                                            <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar" style="width:0%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="ph" class="autoflow" style="">
                                        <table role="presentation" class="editor table content dflex" style=""></table>
                                    </div>
                                    <div class="vbox flex autoflow" style="">
                                        <table role="presentation" class="table">
                                            <tbody class="files"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div tabindex="1" id="overview" class="view bg-dark content vbox flex data parent fade" style="position: relative;"></div>
        </div>
    </div>
</div>
<!-- modal-dialogue -->
<div class="modal fade" id="modal-simple" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">needed by Modal</div>
</div>
<!-- /.modal -->

<!-- Templates -->
<script id="flickrTemplate" type="text/html">
    <a href='http://farm${farm}.static.flickr.com/${server}/${id}_${secret}_b.jpg' title="${title}" data-category>
        <img src='http://farm${farm}.static.flickr.com/${server}/${id}_${secret}_s.jpg'>
    </a>
</script>

<script id="flickrIntroTemplate" type="text/html">
    <div class="dark xxl">
        <i class="glyphicons glyphicons-picture"></i>
        <span class="cover-header">flickr</span>
        <div class=" btn-primary xs">
            <a class="label recent ">flickr recent</a>
            <a class="label inter">flickr interesting</a>
        </div>
    </div>
</script>

<script id="addTemplate" type="text/html">
    <div class="modal-dialog modal-lg ${type}">
        <div class="bg-dark content modal-content">
            <div class="modal-header footer">
                <h2 class="modal-title">${title}</h2>
                <button type="button" class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body autoflow">
                <div class="items flex fadein show"></div>
            </div>
            <div class="modal-footer footer">
                {{tmpl() "#footerTemplate"}}
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</script>


<script id="footerTemplate" type="text/html">
    <div class="btn-group left">
        <button type="button" class="opt-modalSelectAll dark {{if !contains}}disabled{{/if}}">Alles auswählen</button>
        <button type="button" class="opt-modalSelectInv dark {{if !contains}}disabled{{/if}}">Auswahl invertieren</button>
    </div>
    <div class="btn-group right">
        <button type="button" class="opt-modalAddExecute dark {{if disabled}}disabled{{/if}}">Hinzufügen</button>
        <button type="button" class="opt- dark" data-dismiss="modal">Abbrechen</button>
    </div>
</script>

<script id="modalSimpleHelpTemplate" type="text/html">
    <ul>
        <li>Axel</li>
        <li>Nitzschner</li>
        <li>Test</li>
    </ul>
</script>

<script id="modalActionTemplate" type="text/html">
    <form>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header dark">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                    <ul class="pager">
                        <li class="refresh previous {{if min}}disabled{{/if}}"><a href="#">Refresh List</a></li>
                    </ul>
                    <h4 class="modal-title">${text}</h4>
                </div>
                <div class="modal-body autoflow">
                    <div class="row dflex">
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
                    <button type="button" class="opt-CreateProduct btn-default" {{if type== 'category'}}disabled{{/if}}>New Product</button>
                    <button type="button" class="btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="copy btn-default">Copy</button>
                    <label class="hide"><input type="checkbox" class="remove">remove original items when done</label>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</script>

<script id="modalActionColTemplate" type="text/html">
    {{tmpl($item.data.items) "#modalActionContentTemplate"}}
</script>

<script id="modalActionContentTemplate" type="text/html">
    <a class="list-group-item item" id="${id}">{{if name}}${name}{{else}}${title}{{/if}}</a>
</script>

<script id="modalSmallTemplate" type="text/html">

</script>

<script id="modalSimpleTemplate" type="text/html">
    <div class="modal-dialog {{if small}}modal-sm{{else}}modal-lg{{/if}}">
        <div class="modal-content bg-dark">
            {{if header}}
            <div class="modal-header dark">
                <button type="button" class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
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
                <div class="" style="text-align: left; max-width: 90%">
                    {{if footer}}{{html footer}}{{/if}}
                </div>
                <button class="btn btnClose dark" data-dismiss="modal">
                    {{if footerButtonText}}${footerButtonText}{{else}}Ok{{/if}}
                </button>
            </div>
            {{/if}}
        </div>
    </div>
</script>

<script id="modalSimpleTemplateBody" type="text/html">
    <div>test</div>
</script>

<script id="modal2ButtonTemplate" type="text/html">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header dark">
                <button type="button" class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
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
                <button class="btn btnOk" aria-hidden="true">${button_1_text}</button>
                <button type="button" class="btn btnAlt" data-dismiss="modal">${button_2_text}</button>
            </div>
        </div>
    </div>
</script>

<script id="sidebarTemplate" type="text/html">
    <li data-id="${id}" data-model-name="Category" data-models-name="Product" class="gal item data parent">
        <i class="glyphicons {{if protected}}glyphicons-lock pointer{{/if}}" title="{{if protected}}geschützte Kategorie{{/if}}"></i>
        <div class="item-header">
            <div class="expander"></div>
            {{tmpl "#sidebarContentTemplate"}}
        </div>
        <ul class="sublist" style=""></ul>
    </li>
</script>

<script id="sidebarContentTemplate" type="text/html">
    <div class="item-content">
        <span class="name">{{if screenname}}${$().name(screenname, 20)}{{else}}${$().name(name, 20)}{{/if}}</span>
        <span class="gal cta">{{tmpl($item.data.details()) "#categoryDetailsTemplate"}}</span>
    </div>
</script>

<script id="productsSublistTemplate" type="text/html">
    {{if flash}}
    <li class="sublist-item disabled" title="${flash}">
        <span class="author">${flash}</span>
    </li>
    {{else}}
    <li data-id="${id}" data-model-name="Product" data-models-name="Photo" class="sublist-item alb item data {{if ignored}}ignored{{/if}}" title="${title}">
    <span class="infogramm">
        <span class="glyphicons glyphicons-picture {{if details().iCount}}{{else}} notok{{/if}}" title="${details().iCount} Produktbild{{if details().iCount>1 || details().iCount==0}}er{{/if}}"></span>
        <span class="glyphicons glyphicons-eye-{{if ignored}}close notok{{else}}open{{/if}} opt-ignored" title="Produkt{{if ignored}} veröffentlichen{{else}} nicht veröffentlichen{{/if}}"></span>
        <span class="glyphicons glyphicons-{{if favorite}}star{{else}}star-empty{{/if}} opt-favorite" title="Produkt des Tages {{if favorite}} deaktivieren{{else}} aktivieren{{/if}}"></span>
    </span>
        <span class="inner-sub">
        <span class="title center" title="${title}">{{if title}}${$().name(title, 16)}{{/if}}</span>
        <span class="outer-cta">
            <span class="cta {{if price}}{{else}}notok{{/if}}">€ {{if price}}${price}{{else}}0{{/if}}</span>
        </span>
    </span>
    </li>
    {{/if}}
</script>

<script id="sidebarFlickrTemplate" type="text/html">
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

<script id="sidebarFlickrSublistTemplate" type="text/html">
    <li class="sublist-item item item-content ${klass}">
        <span class="glyphicons glyphicons-${icon}"></span>
        <span class="">${name}</span>
    </li>
</script>

<script id="overviewHeaderTemplate" type="text/html">
</script>

<script id="categoryDetailsTemplate" type="text/html">
    <span title="${pCount} von ${aCount} Produkten veröffentlicht">${pCount}/${aCount} </span>
</script>

<script id="categoriesTemplate" type="text/html">
    <li id="${id}" data-id="${id}" class="item data fade show" data-drag-over="" draggable="true">
        <div class="thumbnail">
            <div class="inner">
                {{tmpl($item.data.details()) "#galDetailsTemplate"}}
            </div>
        </div>
        <div class="glyphicons-set right fade" style="">
            <span class="tooltips downloading glyphicons glyphicons-download-alt glyphicons-white hide left fade" data-toggle="tooltip"></span>
            <span class="left">
                <div class="dropdown">
                    <a class="dropdown-toggle glyphicons glyphicons-white" data-toggle="dropdown"></a>
                    <div class="dropdown-menu" aria-labelledby="dLabel">
                        <a class="zoom dropdown-item" tabindex="-1" data-toggle="tooltip" title="Öffnen" href="#">
                            <i class="tooltips glyphicons glyphicons-folder-close"></i>Öffnen
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="delete dropdown-item {{if isInvalid()}}disabled{{/if}}" tabindex="-1" data-toggle="tooltip" title="Löschen" href="#">
                            <i class="glyphicons glyphicons glyphicons-bin"></i>Löschen
                        </a>
                    </div>
                </div>
            </span>
        </div>
    </li>
</script>

<script id="modalcategoriesActionTemplate" type="text/html">
    <div class="modal-header dark">
        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
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
        <button class="btn btnOk" aria-hidden="true">OK</button>
        <button type="button" class="btn btnAlt" data-dismiss="modal">Save changes</button>
    </div>
</script>

<script id="categoryActionTemplate" type="text/html">
    <label class="btn btn-primary">
        <input type="radio" name="options" id="option1">${name}
    </label>
</script>

<script id="defaultActionTemplate" type="text/html">
    <div class="modal-header dark">
        <button type="button" class="close" aria-hidden="true">&times;</button>
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
        <button class="btn btnOk" aria-hidden="true">OK</button>
        <button type="button" class="btn btnAlt">Save changes</button>
    </div>
</script>

<script id="missingViewTemplate" type="text/html">
    <div class="dark xxl">
        <i class="glyphicons glyphicons-question-sign"></i>
        <span class="cover-header">404</span><span>Not Found Error</span>
        <div class=" btn-primary xs">
            <a class="label relocate">Proceed to Overview (or use TAB for sidebar)</a>
        </div>
    </div>
</script>

<script id="galDetailsTemplate" type="text/html">
    <div style="">{{if screenname}}${$().name(screenname, 15)}{{else}}${name}{{/if}}
    </div>
    <div style="font-size: 0.8em; font-style: oblique;">Products: ${aCount}</div>
    <div style="font-size: 0.8em; font-style: oblique;">Images: ${iCount}</div>
    <div class="opt-SlideshowPlay hide" style="">
        <span class="label label-default">
            <i class="glyphicons glyphicons-picture"></i>
            <i class="glyphicons glyphicons-play"></i>
            ${pCount}
        </span>
    </div>
    {{if pCount}}
    <div class="hide" style="font-size: 0.8em; font-style: oblique; ">hit space to play</div>
    {{/if}}
</script>

<script id="editCategoryTemplate" type="text/html">
    <div class="input-group left">
        <span class="input-group-addon" id="basic-addon1">Name</span>
        <input type="text" class="form-control" placeholder="Name der Kategorie" aria-describedby="basic-addon1" name="screenname" value="{{html screenname}}">
    </div>
</script>

<script id="productsTemplate" type="text/html">
    <li id="${id}" data-id="${id}" data-model-name="Product" data-models-name="Photo" data-drag-over="" class="data item fade show {{if Category.record}}{{if ignored}}ignored{{/if}}{{/if}}" draggable="true">
        {{if favorite}}
        <i class="badge3"></i>
        {{/if}}
        <div class="thumbnail"></div>
        {{if Category.record}}
        <div class="glyphicons-set left hide" style="">
            <span class="">
                <a href="#" title="{{if ignored}}Einblenden{{else}}Ausblenden{{/if}}  Strg+M (Ctrl+M Mac)" class="glyphicons glyphicons-eye-open glyphicons-white opt-ignored"></a>
            </span>
        </div>
        {{/if}}
        <div class="glyphicons-set right fade" style="">
            <span class="left">
                <span class="tooltips downloading glyphicons glyphicons-download-alt glyphicons-white hide left fade" data-toggle="tooltip">
                </span>
             </span>
            <span class="left">
            <a href="#" class="dropdown-toggle glyphicons glyphicons-white" data-toggle="dropdown"></a>
            <div class="dropdown-menu" aria-labelledby="dLabel">
                <a class="opt-ignored dropdown-item" tabindex="-1" data-toggle="tooltip" title="{{if ignored}}Einblenden{{else}}Ausblenden{{/if}}" href="#">
                    <i class="glyphicons glyphicons-eye-open"></i>
                    {{if ignored}}Einblenden{{else}}Ausblenden{{/if}}
                </a>
                <a class="zoom dropdown-item" tabindex="-1" data-toggle="tooltip" title="Öffnen" href="#">
                    <i class="tooltips glyphicons glyphicons-picture"></i>
                    Fotos anzeigen
                </a>
                <a class="opt-favorite dropdown-item" tabindex="-1" data-toggle="tooltip" title="Produkt des Tages" href="#">
                    <i class="tooltips glyphicons glyphicons-star{{if favorite}}{{else}}-empty{{/if}}"></i>
                    Product des Tages
                </a>
                {{if Category.record}}
                <a class="opt-original dropdown-item" tabindex="-1" data-toggle="tooltip" title="Im Katalog anzeigen" href="#">
                    <i class="glyphicons glyphicons glyphicons-file"></i>Im Katalog anzeigen</a>
                </a>
                {{/if}}
                <div class="dropdown-divider"></div>
                <a class="opt-delete dropdown-item" tabindex="-1" data-toggle="tooltip" title="{{if Category.record}}Entfernen{{else}}Löschen{{/if}} " href="#">
                  <i class="glyphicons glyphicons glyphicons-bin"></i>
                  {{if Category.record}}Entfernen{{else}}Löschen{{/if}}
                </a>
            </div>
      </span>
        </div>
        <div class="titles">
            <div class="title">{{if title}}${$().name(title, 250)}{{/if}}</div>
            <div class="subtitle">
                {{if subtitle}}{{html $().name(subtitle, 1200)}}{{/if}}
            </div>
            {{if validUrl()}}
            <a href="${link}" target="_blank">{{/if}}
                <section class="info-badges">
                    <span class="cc {{if validUrl()}}valid{{else}}warning-badge{{/if}} link glyphicons glyphicons-link"></span>
                    <span class="dd price {{if price}}{{else}}warning-badge{{/if}}">€&nbsp;{{if price}}${price}{{else}}0,00{{/if}}</span>
                </section>
            {{if validUrl()}}
            </a>
            {{/if}}
        </div>
    </li>
</script>

<script id="productsTrashTemplate" type="text/html">
    <li id="${id}" data-id="${id}" data-drag-over="" data-model-name="Product" data-models-name="Photo" class="data item fade show {{if Category.record}}{{if ignored}}ignored{{/if}}{{/if}}" draggable="true">
        {{if favorite}}
        <i class="badge3"></i>
        {{/if}}
        <div class="thumbnail"></div>
        <div class="glyphicons-set right fade" style="">
            <span class="left">
                <a href="#" class="dropdown-toggle glyphicons glyphicons-white" data-toggle="dropdown"></a>
                <div class="dropdown-menu" aria-labelledby="dLabel">
                    <a class="opt-destroy dropdown-item" tabindex="-1" data-toggle="tooltip" title="endgültig Löschen" href="#">
                        <i class="glyphicons glyphicons glyphicons-bin"></i>Löschen
                    </a>
                    <a class="opt-recover dropdown-item" tabindex="-1" data-toggle="tooltip" title="Wiederherstellen" href="#">
                        <i class="glyphicons glyphicons glyphicons-repeat"></i>Wiederherstellen
                    </a>
                </div>
            </span>
        </div>
        <div class="titles">
            <div class="title">{{if title}}${$().name(title, 25)}{{/if}}</div>
            <div class="subtitle">{{if subtitle}}{{html $().name(subtitle, 120)}}{{/if}}</div>
            {{if link}}<a href="${link}" target="_blank">{{/if}}
            <section class="info-badges">
                <span class="cc link glyphicons glyphicons-link {{if link}}{{else}}warning-badge{{/if}}"></span>
                <span class="dd price {{if price}}{{else}}warning-badge{{/if}}">€&nbsp;{{if price}}${price}{{else}}0,00{{/if}}</span>
            </section>
            {{if link}}</a>{{/if}}
        </div>
    </li>
</script>

<script id="editProductTemplate" type="text/html">
    <div class="{{if ignored}}ignored{{/if}}">
        <div class="row">
            <div class="col-lg-9" style="">
                <div class="input-group" style="">
                    <span class="input-group-addon" id="basic-addon1">Titel</span>
                    <input type="text" class="form-control" placeholder="Produkttitel" aria-describedby="basic-addon1" name="title" value="{{html title}}">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default opt-ignored" aria-label="Help">
                            <span class="glyphicons glyphicons-eye-{{if ignored}}close{{else}}open{{/if}}"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3" style="">
                <div class="input-group" style="">
                    <span class="input-group-addon" id="basic-addon2">Preis (€)</span>
                    <input type="text" class="form-control" placeholder="Preis" aria-describedby="price" name="price" value="${price}" style="max-width: 170px;">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="input-group" style="">
                    <span class="input-group-addon" id="subtitle">Kurzbeschreibung</span>
                    <textarea type="text" class="form-control" placeholder="Kurzbeschreibung" aria-describedby="subtitle" name="subtitle" value="{{html subtitle}}">{{html subtitle}}</textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="input-group" style="">
                    <span class="input-group-addon" id="notes">Notizen</span>
                    <textarea type="text" class="form-control" aria-describedby="notes" placeholder="Notizen" name="notes">{{html notes}}</textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="input-group" style="">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default" aria-label="Help">
                            <span id="validLink" class="invalid glyphicons glyphicons-link"></span>
                        </button>
                    </div>
                    <input type="text" class="form-control" aria-describedby="link" placeholder="Link to Ebay" name="link" value="${link}">
                </div>
            </div>
        </div>
    </div>

</script>

<script id="validLinkTemplate" type="text/html">

</script>

<script id="editDescriptionTemplate" type="text/html">
    <div data-description-id="${id}" class="input-group data" draggable="true">
        <span class="input-group-addon" id="basic-addon1">${order}</span>
        <input class="form-control" placeholder="Beschreibung #${order}" aria-label="Text input with segmented button dropdown" name="description" value="{{html description}}">
        <div class="input-group-btn">
            <button type="button" class="btn btn-default opt-remove">-</button>
            <button type="button" class="btn btn-default opt-add">+</button>
        </div>
    </div>
</script>

<script id="editPhotoTemplate" type="text/html">
    <div class="input-group left">
        <span class="input-group-addon" id="basic-addon1">Titel</span>
        <input type="text" class="form-control" placeholder="Fototitel" aria-describedby="basic-addon1" name="title" value="{{html title}}">
    </div>
</script>

<script id="productSelectTemplate" type="text/html">
    <option {{if ((constructor.record) && (constructor.record.id== id))}}selected{{/if}} value="${id}">${title}</option>
</script>

<script id="headerCategoryTemplate" type="text/html">
    <section class="top viewheader fadeelement">
        <div class="left">
            <div class="header-title">
                <span class="btn-group btn-nav">
                    <button class="dark opt-ShowOverview">
                        <i class="glyphicons glyphicons-chevron-up nopad"></i>
                    </button>
                    <button class="dark opt-ShowProducts">
                        <i class="glyphicons glyphicons-chevron-down nopad"></i>
                    </button>
                </span>
                <span class="title-wrapper">
                    <div class="title-field">
                        <i class="glyphicons glyphicons-show-big-thumbnails"></i>
                        <span class="">Kategorien</span>
                    </div>
                </span>
            </div>
        </div>
        {{tmpl() "#categorySpecsTemplate"}}
    </section>
</script>


<script id="categorySpecsTemplate" type="text/html">
    <div class="right">
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Auswahl <span style="font-size:0.9em; text-transform: initial;">(Tasten ENTER ESC < >)</span>
            </legend>
            <span class="selection-title {{if Category.record}}active{{/if}}">
    <i class="glyphicons glyphicons-show-big-thumbnails"></i>
    <span>{{if Category.record}}{{if Category.record.screenname}}${$().name(Category.record.screenname,25)}{{else}}${$().name(Category.record.name,25)}{{/if}}{{/if}}</span>
    </span>
        </fieldset>
    </div>
</script>

<script id="headerProductTemplate" type="text/html">
    <section class="top viewheader fadeelement">
        <div class="left">
            <div class="header-title">
                <span class="btn-group btn-nav">
                    <button class="dark opt-ShowCategories">
                        <i class="glyphicons glyphicons-chevron-up nopad"></i>
                    </button>
                    <button class="dark opt-ShowPhotos">
                        <i class="glyphicons glyphicons-chevron-down nopad"></i>
                    </button>
                </span>
                <span class="title-wrapper">
                    {{if model.record}}
                    <div class="title-field">
                        <i class="glyphicons glyphicons-show-big-thumbnails"></i>
                        <span class="">{{if category}}{{if category.screenname}}${$().name(category.screenname, 10)}{{else}}${$().name(category.name, 10)}{{/if}}{{else}}...{{/if}}</span>
                    </div>
                    {{else}}
                    <div class="title-field">
                        <i class="glyphicons glyphicons-show-thumbnails"></i>
                        <span class="">Produkt-Katalog</span>
                    </div>
                    {{/if}}
                </span>
            </div>
        </div>
        {{tmpl() "#productSpecsTemplate"}}
    </section>
    <section class="hide">
        <span class="fadeelement breadcrumb">
            <li style="padding: 0px 19px;" class="opt-Prev">
                <div style="" class="go-up"></div>
            </li>
            <li class="gal">
                <a href="#">categories</a>
            </li>
            <li class="alb active">Products</li>
        </span>
    </section>
</script>

<script id="productSpecsTemplate" type="text/html">
    <div class="right">
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Auswahl <span style="font-size:0.9em; text-transform: initial;">(Tasten ENTER ESC < >)</span>
            </legend>
            <span class="selection-title {{if Product.record}}active{{/if}}">
                <i class="glyphicons glyphicons-show-thumbnails"></i>
                <span>${$().name(Product.record.title, 25)}</span>
            </span>
        </fieldset>
        <fieldset class="scheduler-border hide">
            <legend class="scheduler-border">Auswahl</legend>
            <span class="">
                <div class="opt-Select{{if model.details().sCount>0}}None deselect{{else}}All select{{/if}} btn btn-sm {{if model.details().sCount>0}}{{/if}}"><b
                        class=""><div>${model.details().sCount}</div></b></div>
            </span>
            <span class="selection-title">
                <i class="">${$().name(product.title, 25)}</i>
            </span>
        </fieldset>
    </div>
</script>

<script id="headerProductTrashTemplate" type="text/html">
    <section class="top viewheader fadeelement left">
        <div class="left">
            <div class="header-title">
                <span class="btn-group btn-nav">
                    <button class="dark opt-ShowProducts">
                        <i class="glyphicons glyphicons-chevron-up nopad"></i>
                    </button>
                    <button class="dark opt-ShowPhotosTrash">
                        <i class="glyphicons glyphicons-chevron-down nopad"></i>
                    </button>
                </span>
                <span class="title-wrapper">
                    <div class="title-field">
                        <i class="glyphicons glyphicons-bin"></i>
                        <span class="">Produkt Papierkorb</span>
                    </div>
                </span>
            </div>
        </div>
    </section>
    <section class="right">
        <button type="submit" class="dark opt-EmptyProductsTrash">
            <i class="glyphicons glyphicons-bin"></i>
            <span>Papierkorb leeren</span>
        </button>
    </section>
</script>

<script id="headerPhotosTemplate" type="text/html">
    <section class="top viewheader fadeelement">
        <div class="left">
            <div class="header-title">
                <span class="btn-group btn-nav">
                    <button class="dark opt-ShowProducts">
                        <i class="glyphicons glyphicons-chevron-up nopad"></i>
                    </button>
                    <button class="dark opt-ShowPhoto">
                        <i class="glyphicons glyphicons-chevron-down nopad"></i>
                    </button>
                </span>
                <span class="title-wrapper">
                    {{if product}}
                    <div class="title-field">
                        <i class="glyphicons glyphicons-show-big-thumbnails"></i>
                        <span class="">{{if category}}{{if category.screenname}}${$().name(category.screenname, 10)}{{else}}${$().name(category.name, 10)}{{/if}}{{else}}...{{/if}}</span>
                    </div>
                    <div class="title-field">
                        <i class="glyphicons glyphicons-show-thumbnails"></i>
                        <span class="{{if model.record}}{{else}}{{/if}}">{{if modelProduct.record}}{{if product.title}}${$().name(product.title, 15)}{{else}}...{{/if}}{{else}}None{{/if}}</span>
                    </div>
                    {{else}}
                    <div class="title-field">
                        <i class="glyphicons glyphicons-picture"></i>
                        <span class="">Foto-Katalog</span>
                    </div>
                    {{/if}}
                </span>
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

<script id="headerPhotosTrashTemplate" type="text/html">
    <section class="top viewheader fadeelement left">
        <div class="left">
            <div class="header-title">
                <span class="btn-group btn-nav">
                    <button class="dark opt-ShowProductsTrash">
                        <i class="glyphicons glyphicons-chevron-up nopad"></i>
                    </button>
                    <button class="dark disabled">
                        <i class="glyphicons glyphicons-chevron-down nopad"></i>
                    </button>
                </span>
                <span class="title-wrapper">
                    <div class="title-field">
                        <i class="glyphicons glyphicons-bin"></i>
                        <span class="">Foto Papierkorb</span>
                    </div>
                </span>
            </div>
        </div>
    </section>
    <section class="right">
        <button type="submit" class="dark opt-EmptyPhotosTrash">
            <i class="glyphicons glyphicons-bin"></i>
            <span>Papierkorb leeren</span>
        </button>
    </section>

</script>

<script id="headerPhotoTemplate" type="text/html">
    <section class="top viewheader fadeelement">
        <div class="left">
            <div class="header-title">
                <span class="btn-group btn-nav">
                    <button class="dark opt-ShowPhotos">
                        <i class="glyphicons glyphicons-chevron-up nopad"></i>
                    </button>
                    <button class="dark disabled">
                        <i class="glyphicons glyphicons-chevron-down nopad"></i>
                    </button>
                </span>
                <span class="title-wrapper">
                    {{if product}}
                    <div class="title-field">
                        <i class="glyphicons glyphicons-show-big-thumbnails"></i>
                        <span class="">{{if category}}{{if category.screenname}}${$().name(category.screenname, 10)}{{else}}${$().name(category.name, 10)}{{/if}}{{else}}...{{/if}}</span>
                    </div>
                    <div class="title-field">
                        <i class="glyphicons glyphicons-show-thumbnails"></i>
                        <span class="{{if model.record}}{{else}}{{/if}}">{{if modelProduct.record}}{{if product.title}}${$().name(product.title, 15)}{{else}}...{{/if}}{{else}}None{{/if}}</span>
                    </div>
                    {{else}}
                    <div class="title-field">
                        <i class="glyphicons glyphicons-picture"></i>
                        <span class="">Foto-Ansicht</span>
                    </div>
                    {{/if}}
                </span>
            </div>
        </div>
        {{tmpl() "#photoSpecsTemplate"}}
    </section>
    {{tmpl() "#photoBreadcrumbTemplate"}}
</script>

<script id="photoSpecsTemplate" type="text/html">
    <div class="right">
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Auswahl <span style="font-size:0.9em; text-transform: initial;">(Tasten ENTER ESC < >)</span>
            </legend>
            <span class="selection-title {{if Photo.record}}active{{/if}}">
    <i class="glyphicons glyphicons-picture"></i>
    <span>${$().name(Photo.record.src, 25)}</span>
    </span>
        </fieldset>
        <fieldset class="scheduler-border hide">
            <legend class="scheduler-border">Auswahl</legend>
            <span class="">
  <div class="opt-Select{{if model.details().sCount>0}}None deselect{{else}}All select{{/if}} btn btn-sm {{if model.details().sCount>0}}{{/if}}"><b
          class=""><div>${model.details().sCount}</div></b></div>
  </span>
            <span class="selection-title">
  <i class="">{{if Photo.record.title}}${$().name(modelPhoto.record.title, 25)}{{else}}${$().name(Photo.record.src, 25)}{{/if}}</i>
  </span>
        </fieldset>
    </div>
</script>

<script id="photosBreadcrumbTemplate" type="text/html">
    <section class="hide">
        <span class="fadeelement breadcrumb">
            <li style="padding: 0px 19px;" class="opt-Prev">
                <div style="" class="go-up"></div>
            </li>
            <li class="gal">
                <a href="#">categories</a>
            </li>
            <li class="alb">
                <a href="#">Products</a>
            </li>
            <li class="pho active">Photos</li>
        </span>
    </section>
</script>

<script id="photoBreadcrumbTemplate" type="text/html">
    <section class="hide">
        <span class="fadeelement breadcrumb">
            <li style="padding: 0px 19px;" class="opt-Prev">
                <div style="" class="go-up"></div>
            </li>
            <li class="gal">
                <a href="#">categories</a>
            </li>
            <li class="alb">
                <a href="#">Products</a>
            </li>
            <li class="pho">
                <a href="#">Photos</a>
            </li>
            <li class="active">{{if photo.src}}${photo.src}{{else}}deleted{{/if}}</li>
        </span>
    </section>
</script>

<script id="productCountTemplate" type="text/html">
    <span class="cta">€ ${price}</span>
</script>

<script id="productInfoTemplate_" type="text/html">
    <html>
    <head><!--[if IE]><style>iframe{zoom:0.2;}</style><![endif]-->
            <style>iframe {
                    width: 300px;
                    height: 200px;
                    border: none;
                    -moz-transform: scale(1);
                    -moz-transform-origin: 0 0;
                    -o-transform: scale(1);
                    -o-transform-origin: 0 0;
                    -webkit-transform: scale(1);
                    -webkit-transform-origin: 0 0;
                }</style>
        </head>
        <body>
            <iframe src="${link}+" /output=/A6XUVjK9W4o"></iframe></body>
    </html>
</script>

<script id="productInfoTemplate" type="text/html">
    <ul>
        <li class="tr name">
            <span class="td left">{{if title}}${title}{{else}}no title{{/if}} </span><span class="td"></span><span class="td right"> {{tmpl($item.data) "#productCountTemplate"}}</span>
        </li>
        <li class="tr italic">{{if photo}}
            <span class="td">Photo</span><span class="td">:</span><span class="td">${photo}</span>{{/if}}
        </li>
    </ul>
</script>

<script id="photosDetailsTemplate" type="text/html">
    Author:  <span class="label label-default">${author}</span>
    category:  <span class="label label-{{if category}}default{{else}}warning{{/if}}">{{if category}}{{if category.name}}${category.name}{{else}}no name{{/if}}{{else}}not found{{/if}}</span>
    <br>
    <h2>Photos in Product: </h2>
    <label class="h2 chopin">{{if product.title}}${product.title}{{else}}no title{{/if}}</label>
    <span class="active cta right">
        <h2>Total: ${count}</h2>
    </span>
</script>

<script id="photoDetailsTemplate" type="text/html">
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

<script id="photosTemplate" type="text/html">
    <li id="${id}" data-id="${id}" data-model-name="" data-models-name="Photo" class="item data fade show" draggable="true">
        {{tmpl() "#photosThumbnailTemplate"}}
        <div class="center order hide" style="color: aliceblue">{{if order}}${order}{{else}}0{{/if}}
        </div>
    </li>
</script>


<script id="photosThumbnailTemplate" type="text/html">
    <div class="thumbnail image left fade"></div>
    <div class="glyphicons-set right fade" style="">
        <span class="tooltips downloading glyphicons glyphicons-download-alt glyphicons-white hide left fade" data-toggle="tooltip"></span>
        <span class="left">
            <a href="#" class="dropdown-toggle glyphicons glyphicons-white" data-toggle="dropdown"></a>
            <div class="dropdown-menu" aria-labelledby="dLabel">
                <a class="zoom dropdown-item" tabindex="-1" data-toggle="tooltip" title="Öffnen" href="#">
                    <i class="tooltips glyphicons glyphicons-resize-full"></i>Öffnen
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-header disabled"><a role="menuitem" tabindex="-1" data-toggle="tooltip" title="Rotate" href="#">
                        <i class="tooltips"></i>Rotieren:
                    </a>
                    <a class="rotate-cw dropdown-item" tabindex="-1" data-toggle="tooltip" title="Im Uhrzeiger drehen" href="#">
                        <i class="tooltips glyphicons glyphicons glyphicons-circle-arrow-right"></i>Im Uhrzeiger
                    </a>
                    <a class="rotate-ccw dropdown-item" tabindex="-1" data-toggle="tooltip" title="Gegen Uhrzeiger drehen" href="#">
                        <i class="tooltips glyphicons glyphicons glyphicons-circle-arrow-left"></i>Gegen Uhrzeiger
                    </a>
                    <div class="dropdown-divider"></div>
                    {{if Product.record}}
                    <a class="original dropdown-item" tabindex="-1" data-toggle="tooltip" title="Im Katalog anzeigen" href="#">
                        <i class="glyphicons glyphicons glyphicons-file"></i>Im Katalog anzeigen
                    </a>
                    <div class="dropdown-divider"></div>
                    {{/if}}
                    <a class="delete dropdown-item" tabindex="-1" data-toggle="tooltip" title="{{if Product.record}}Entfernen{{else}}Löschen{{/if}}" href="#">
                        <i class="glyphicons glyphicons glyphicons-bin"></i>{{if Product.record}}Entfernen{{else}}Löschen{{/if}}
                    </a>
            </div>
        </span>
    </div>
</script>

<script id="photosTrashTemplate" type="text/html">
    <li id="${id}" data-id="${id}" data-model-name="" data-models-name="Photo" class="item data fade show">
        <div class="thumbnail image left fade"></div>
        <div class="glyphicons-set right fade" style="">
            <span class="tooltips downloading glyphicons glyphicons-download-alt glyphicons-white hide left fade" data-toggle="tooltip"></span>
            <span class="left">
                <a href="#" class="dropdown-toggle glyphicons glyphicons-white" data-toggle="dropdown"></a>
                <div class="dropdown-menu" aria-labelledby="dLabel">
                    <a class="opt-destroy dropdown-item" tabindex="-1" data-toggle="tooltip" title="Löschen" href="#">
                        <i class="glyphicons glyphicons glyphicons-bin"></i>Löschen
                    </a>
                    <a class="opt-recover dropdown-item" tabindex="-1" data-toggle="tooltip" title="Wiederherstellen" href="#">
                        <i class="glyphicons glyphicons glyphicons-repeat"></i>Wiederherstellen
                    </a>
                </div>
            </span>
        </div>
        <div class="center order hide" style="color: aliceblue">{{if order}}${order}{{else}}0{{/if}}</div>
    </li>
</script>

<script id="photosSlideshowTemplate" type="text/html">
    <li class="item data ">
        <a class="thumbnail image left fade show"></a>
    </li>
</script>

<script id="photoTemplate" type="text/html">
    <li data-id="${id}" class="item noborder" data-model-name="" data-models-name="Photo" draggable="true">
        {{tmpl() "#photoThumbnailTemplate"}}
    </li>
</script>

<script id="photoThumbnailTemplate" type="text/html">
    <div class="thumbnail image left"></div>
    <div class="glyphicons-set right fade" style="">
        <span class="tooltips downloading glyphicons glyphicons-download-alt glyphicons-white hide left fade" data-toggle="tooltip"></span>
        <span class="left">
            <a href="#" class="dropdown-toggle glyphicons glyphicons-white" data-toggle="dropdown"></a>
            <div class="dropdown-menu" aria-labelledby="dLabel">
                <a class="dropdown-header disabled dropdown-item" tabindex="-1" data-toggle="tooltip" title="Rotate" href="#">
                    <i class="tooltips"></i>Rotate:
                </a>
                <a class="rotate-cw dropdown-item" tabindex="-1" data-toggle="tooltip" title="Rotate cw" href="#">
                    <i class="tooltips glyphicons glyphicons-circle-arrow-right"></i>cw
                </a>
                <a class="rotate-ccw dropdown-item" tabindex="-1" data-toggle="tooltip" title="Rotate ccw" href="#">
                    <i class="tooltips glyphicons glyphicons-circle-arrow-left"></i>ccw
                </a>
                <div class="dropdown-divider"></div>
                <a class="delete dropdown-item" tabindex="-1" data-toggle="tooltip" title="{{if Product.record}}Entfernen{{else}}Löschen{{/if}}" href="#">
                    <i class="glyphicons glyphicons glyphicons-bin"></i>{{if Product.record}}Entfernen{{else}}Löschen{{/if}}
                </a>
            </div>
        </span>
    </div>
    <div class="center">{{if title}}${title.substring(0, 15)}{{else}}{{if src}}${src.substring(0, 15)}{{else}}no title{{/if}}{{/if}}</div>
</script>

<script id="photoThumbnailSimpleTemplate" type="text/html">
    <div class="opt- thumbnail image left" data-id="${id}"></div>
</script>

<script id="preloaderTemplate" type="text/html">
    <div class="preloader">
        <div class="content">
            <div></div>
        </div>
    </div>
</script>

<script id="photoInfoTemplate" type="text/html">
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

<script id="toolsTemplate" type="text/html">
    {{if dropdown}}
        {{tmpl(itemGroup) "#dropdownTemplate"}}
    {{else}}
    <li class="${klass}" {{if outerstyle}} style="${outerstyle}" {{/if}}{{if id}} id="${id}"{{/if}}>
    <{{if type}}${type} class="{{if icon}}symbol{{/if}} tb-name {{if innerklass}}${innerklass}{{/if}}"{{else}}button class="symbol dark {{if innerklass}}${innerklass}{{/if}}" {{if dataToggle}}data-toggle="dropdown"{{/if}}{{/if}}
    {{if innerstyle}} style="${innerstyle}"{{/if}}
    {{if disabled}}disabled{{/if}}>
    <i class="glyphicons glyphicons-{{if icon}}${icon}{{/if}} {{if iconcolor}}glyphicons-${iconcolor}{{/if}}"></i>
    <i class="glyphicons glyphicons-{{if icon2}}${icon2}{{/if}} {{if iconcolor}}glyphicons-${iconcolor}{{/if}}"></i>
    {{html name}}
    </{{if type}}${type}{{else}}button{{/if}}>
    </li>
    {{/if}}
</script>

<script id="dropdownTemplate" type="text/html">
    <div class="dropdown" {{if id}} id="${id}" {{/if}} >
        <button class="dropdown-toggle dark" data-toggle="dropdown">
            {{if icon}}<i class="glyphicons glyphicons-${icon}  {{if iconcolor}}glyphicons glyphicons-${iconcolor}{{/if}}"></i>{{/if}}
            {{html name}}
            <b class="caret"></b>
        </button>
        <div class="dropdown-menu">
            {{tmpl(content) "#dropdownListItemTemplate"}}
        </div>
    </div>
</script>

<script id="dropdownListItemTemplate" type="text/html">
    {{if devider}}
    <div class="dropdown-divider"></div>
    {{else}}
    <a {{if dataToggle}} data-toggle="${dataToggle}" {{/if}} class="dropdown-item ${klass} {{if disabled}}disabled{{/if}} {{if header}}dropdown-header{{/if}}">
        <i class="glyphicons glyphicons-{{if icon}}${icon} {{if iconcolor}}glyphicons glyphicons-${iconcolor}{{/if}}{{/if}}"></i>
        {{html name}}
        {{if shortcut}}
        <span class="label label-primary">{{html shortcut}}</span>
        {{/if}}
    </a>
    {{/if}}
</script>

<script id="testTemplate" type="text/html">
    {{if eval}}{{tmpl($item.data.eval()) "#testTemplate"}}{{/if}}
</script>

<script id="noSelectionTemplate" type="text/html">
    {{html type}}
</script>

<script id="loginTemplate" type="text/html">
    <div class="btn-group">
        <button type="button" class="dropdown-toggle dark clear" style="min-width: 180px;" data-toggle="dropdown">
            <i class="glyphicons glyphicons-user"></i>
            <span>${user.name}</span>
            <span class="caret"></span>
        </button>
        <div class="dropdown-menu">
            <a class="opt-logout dropdown-item" href="#">Logout</a>
            <div class="dropdown-divider"></div>
            <a class="opt-trace dropdown-item" href="#">
                <i class="glyphicons glyphicons-{{if trace}}check{{else}}unchecked{{/if}}"></i>Entwickler Modus
            </a>
        </div>
    </div>
</script>

<script id="overviewTemplate" type="text/html">
    <button type="button" class="close inverse right" aria-hidden="true">&times;</button>
    <div class="pricing--norbu--inverse carousel-background flex" style="z-index: 0;">
        <!--          The data-ride="carousel" attribute is used to mark a carousel as animating starting at page load.-->
        <!--          We can't use it here, since it must be triggered via the controller-->
        <div id="overview-carousel" class="carousel slide" data-ride="" data-interval="7000">

            <!-- Indicators -->
            <ol class="carousel-indicators">{{tmpl($item.data) '#overviewIndicatorsTemplate'}}</ol>
            <div class="carousel-inner">{{tmpl() '#overviewSlidesTemplate'}}</div>
            <!-- Controls -->
            <a class="left carousel-control" href="#overview-carousel" data-slide="prev">
                <span class="glyphicons glyphicons-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#overview-carousel" data-slide="next">
                <span class="glyphicons glyphicons-chevron-right"></span>
            </a>
            <div class="x-xl" style="">
                Übersicht
                <div class="x-xs hide" style="font-size:0.4em;">hit space (play/pause) or arrow keys (navigate)</div>
            </div>
        </div>
    </div>
</script>

<script id="overviewSlidesTemplate" type="text/html">
    <div class="summary active">
        <img src="/img/overview-background.png" style="">
        <div class="carousel-item active">
            {{tmpl($item.data.summary) "#overviewSummaryTemplate"}}
        </div>
        <div class="carousel-caption">
            <div class="flower"></div>
        </div>
    </div>
    <div class="carousel-item recents">
        <img src="/img/overview-background.png" style="">
        <div class="carousel-item">
            {{tmpl($item.data.photos) "#overviewPhotosTemplate"}}
        </div>
        <div class="carousel-caption">
            <h3>Letzte Fotos</h3>
            <p>zuletzt hochgeladene Fotos</p>
        </div>
    </div>
</script>

<script id="overviewIndicatorsTemplate" type="text/html">
    {{each counter}}
    <li data-target="#overview-carousel" data-slide-to="${$index}" class="active"></li>
    {{/each}}
</script>

<script id="overviewPreviewTemplate" type="text/html">
    <div class="item product">
        <img src="/img/overview-background.png" style="">
        <div class="carousel-item">
            {{tmpl() "#norbuPricingTemplate"}}
        </div>
        <div class="carousel-caption">
            <h3 class="hide">${$().name(product.title, 40)}</h3>
        </div>
    </div>
</script>

<script id="overviewPhotosTemplate" type="text/html">
    <div class="item">
        {{tmpl "#photoThumbnailSimpleTemplate"}}
    </div>
</script>

<script id="overviewSummaryTemplate" type="text/html">
    <table class="carousel table">
        <tbody>
        <tr>
            <td><a href="#/category" class=" opt-ShowAllCategories feature-list">Kategorien</a></td>
            <td>${categories.length}</td>
        </tr>
        <tr>
            <td><a href="#/category/" class=" opt-ShowAllProducts feature-list">Produkte (gesamt)</a></td>
            <td>${products.length}</td>
        </tr>
        <tr class="">
            <td><a href="#/category//" class=" opt-ShowAllPhotos feature-list">Fotos</a></td>
            <td>${photos.length}</td>
        </tr>
        <tr class="">
            <td class="feature-list">veröffentlichte Produkte</td>
            <td>${published.length}</td>
        </tr>
        <tr class="">
            <td class="feature-list">unveröffentlichte Produkte</td>
            <td>${unpublished.length}</td>
        </tr>
        <tr class="">
            <td class="feature-list">Produkte in anderen Kategorien</td>
            <td>${others.length}</td>
        </tr>
        <tr class="">
            <td><a href="#/trash/products/" class=" opt-ShowProductsTrash feature-list">Papierkorb</a></td>
            <td>${trashed.length}</td>
        </tr>
        </tbody>
    </table>
</script>

<script id="refreshTemplate" type="text/x-tmpl">
    <button class="opt-Refresh dark left">
        <i class="glyphicons glyphicons-${icon}" style="line-height: 1.5em; padding-left: 8px;"></i>
        <span></span>
    </button>
</script>

<script id="fileuploadTemplate" type="text/html">
    <span style="font-size: 0.6em;" class=" alert alert-success">
        <span style="font-size: 2.9em; font-family: cursive; margin-right: 20px;" class="alert alert-error">"</span>
        {{if product}}{{if product.title}}${product.title}{{else}}...{{/if}}{{else}}all photos{{/if}}
        <span style="font-size: 5em; font-family: cursive;  margin-left: 20px;" class="alert alert-block uploadinfo"></span>
    </span>
</script>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/html">
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
            <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                <div class="progress-bar" style="width:0%;"></div>
            </div>
            {% } %}
        </td>
        <td>
            {% if (!o.files.error && !i && !o.options.autoUpload) { %}
            <button class="dark start">
                <i class="glyphicons glyphicons-upload"></i>
                <span>Start</span>
            </button>
            {% } %}
            {% if (!i) { %}
            <button class="dark cancel">
                <i class="glyphicons glyphicons-ban-circle"></i>
                <span>Cancel</span>
            </button>
            {% } %}
        </td>
    </tr>
    {% } %}
</script>

<!-- The template to display files available for download -->
<script id="template-download" type="text/html">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade dark">
        <td>
            <button class="dark delete" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}" {% if
                    (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}' {% } %}>
                    <i class="glyphicons glyphicons-remove"></i>
                <span></span>
            </button>
        </td>
        <td>
            <span class="preview">
                {% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" class="category" download="{%=file.name%}"><img
                        src="{%=file.thumbnail_url%}"></a>
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

<script id="sidebarPreviewTemplate_" type="text/html">

</script>

<script id="norbuPricingTemplate" type="text/html">
    <div id="${id}" data-id="${id}" class="pricing__item">
        {{if favorite}}
        <i class="badge3"></i>
        {{/if}}
        <h3 class="pricing__title">${$().name(title, 60)}</h3>
        <p class="pricing__sentence">${$().name(subtitle, 80)}</p>
        <div class="pricing__price">
            <div class="price"><span class="pricing__currency">€</span>${price}</div>
            <div class="swiper-container-pricing swiper-container-horizontal">
                <div class="swiper-wrapper">
                    {{tmpl(p = photos())
                    "#norbuImageListTemplate" }}
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets">
                    <span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span>
                </div>
                <!-- Add Arrows -->
                <div class="swiper-button-next swiper-button-grey hidemobile"></div>
                <div class="swiper-button-prev swiper-button-grey hidemobile"></div>
            </div>
        </div>
        <div class="pricing__feature-list">
            <ul class="">{{tmpl(descriptions())
                "#norbuFeatureListTemplate" }}
            </ul>
        </div>
        <a href="{{if link}}${link}{{else}}#{{/if}}" target="_blank" class="pricing__action btn-dark" role="button" aria-disabled="{{if link}}${link}{{else}}false{{/if}}">Zum Shop</a>
    </div>
</script>

<script id="norbuImageListTemplate" type="text/html">
    <div class="swiper-slide">
        <div id="${id}" class="pricing__image"><img class="image load" src="/img/ajax-loader-66.gif"/></div>
    </div>
</script>

<script id="norbuFeatureListTemplate" type="text/html">
    <li data-description-id="${id}" class="pricing__feature">${description}</li>
</script>

<script id="trustamiTemplate" type="text/html">
    <li data-id="${id}" class="opt opt-SaveTrustami trustami" style="">
        <span class="trustami-wrapper">
            <span>
                <a href="https://app.trustami.com/trustami-card/57e573efcc96c5511c8b480e" target="_blank" title="Trustami Bewertungen und Erfahrungen von Handelsagentur Lehmann" class="trustami-badge"></a>
                <button type="submit" class="left opt-Count-Up dark glyphicons glyphicons-plus"></button>
                <button type="submit" class="right opt-Count-Down dark glyphicons glyphicons-minus"></button>
            </span>
            <input class="tmi" type="text" placeholder="Trustami" name="tmi" value="${tmi}">
        </span>
    </li>
</script>






