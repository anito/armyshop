<div id="main" class="view vbox flex">
  <header id="title" class="">
    <div class="left" style="position: relative;">
      <h1 class="" style="line-height: 3em;"><a style="font-size: 3em;" href="/"><span class="chopin">Photo Director</span></a></h1>
      <span style="position: absolute; top: 10px; right: 67px;"><a href="http://glyphicons.com/" target="_blank" style="font-size: 0.7em;" class="anim-link" title="GLYPHICONS is a library of precisely prepared monochromatic icons and symbols, created with an emphasis on simplicity and easy orientation.">GLYPHICONS.com</a></span>
    </div>
    <div id="login" class="right" style="margin: 15px 5px;"></div>
  </header>
  <div id="wrapper" class="hbox flex">
    
    <div id="content" class="views bg-medium vbox flex">
      <div tabindex="1" id="show" class="view canvas bg-dark vbox flex fade">
        <div id="modal-action" class="modal fade"></div>
        <div id="modal-addAlbum" class="modal fade"></div>
        <div id="modal-addPhoto" class="modal fade"></div>
        <ul class="options hbox">
          <ul class="toolbarOne hbox nav"></ul>
          <li class="splitter disabled flex"></li>
          <ul class="toolbarTwo hbox nav"></ul>
        </ul>
        <div class="contents views vbox flex deselector" style="height: 0;">
          <div class="header views vbox">
            <div class="galleries view vbox"></div>
            <div class="albums view vbox"></div>
            <div class="photos view vbox"></div>
            <div class="photo view vbox"></div>
            <div class="overview view"></div>
          </div>
          <div class="view wait content vbox flex autoflow" style=""></div>
          <div class="view  galleries opt-SelectNone content vbox flex data parent autoflow" style="">
            <div class="items fadein">Galleries</div>
          </div>
          <div class="view albums opt-SelectNone content vbox flex data parent autoflow fadeelement" style="">
            <div class="hoverinfo fadeslow"></div>
            <div class="items flex fadein">Albums</div>
          </div>
          <div class="view photos opt-SelectNone content vbox flex data parent autoflow fadeelement" style="">
            <div class="hoverinfo fadeslow"></div>
            <div class="items flex fadein" data-toggle="modal-gallery" data-target="#modal-gallery" data-selector="a">Photos</div>
          </div>
          <div tabindex="1" class="view photo content vbox flex data parent autoflow fadeelement nopad" style="">
            <div class="hoverinfo fadeslow"></div>
            <div class="items flex fade nopad">Photo</div>
          </div>
          <div id="slideshow" class="view content vbox flex data parent autoflow">
            <div class="items flex" data-toggle="blueimp-gallery" data-target="#blueimp-gallery" data-selector="a.thumbnail"></div>
          </div>
        </div>
        <div id="views" class="settings bg-light hbox autoflow bg-medium">
          
        </div>
      </div>
      <div tabindex="1" id="overview" class=" content vbox flex data parent fade" style="position: relative;">
        <div class="carousel-background bg-medium flex" style="z-index: 0;">
<!--          The data-ride="carousel" attribute is used to mark a carousel as animating starting at page load.-->
<!--          We can't use it here, since it must be triggered via the controller-->
          <div class="xxl" style="color: rgba(156, 156, 156, 0.99); top: 260px;">
            Overview
            <div style="font-size: 0.3em; color: rgba(156, 156, 156, 0.59); line-height: 30px;">hit space (play/pause) or arrow keys (navigate)</div>
          </div>
        </div>
        
      </div>
      
      
    </div>
  </div>
</div>