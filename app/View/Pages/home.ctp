
<div id="home" class="view active">
  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="h1 display-3">Handelsagentur<br>Lehmann</h1>
      <h5 class="h5 display-3">Der Versandhändler Ihres Vertrauens</h5>
    </div>
  </div>
  <div class="">
    <!-- Example row of columns -->
    <ul class="row ca-menu pricing">
      <li id="defense-item-menu" class="item-menu  pricing__item defense category">
          <a href="/pages/defense/">
            <span class="flaticon-hiking-up-3"></span>
            <div class="ca-content">
              <h2 class="ca-main">Outdoor</h2>
              <h3 class="ca-sub">Atmen Sie durch</h3>
            </div>
          </a>
      </li>
      <li id="outdoor-item-menu" class="item-menu  pricing__item outdoor category">
          <a href="/pages/outdoor/">
            <span class="flaticon-hiking-up-2"></span>
            <div class="ca-content">
              <h2 class="ca-main">Fitness</h2>
              <h3 class="ca-sub">Bleiben Sie Gesund</h3>
            </div>
          </a>
     </li>
     <li id="goodies-item-menu" class="item-menu  pricing__item goodies category">
          <a href="/pages/goodies/">
            <span class="flaticon-sales-label"></span>
            <div class="ca-content">
              <h2 class="ca-main">Specials</h2>
              <h3 class="ca-sub">24/7 Geld sparen</h3>
            </div>
          </a>
      </li>
    </ul>
  </div> <!-- /container -->
  
</div>
<div id="defense" class="view">
  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <div class="inner">
        <h1 class="display-3">Outdoor</h1>
        <h5 class="h5 display-3">Angebote für Outdoor & Freizeit</h5>
        <div class="opt-hint hint"><a class="btn btn-primary btn-lg" href="#" role="button" style="font-size: 1rem;">Hinweis zu FSK18 Artikeln anzeigen»</a></div>
      </div>
    </div>
  </div>
  <div class="items  pricing pricing--norbu"></div>
</div>
<div id="outdoor" class="view">
  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3">Fitness</h1>
      <h5 class="h5 display-3">Angebote für Sport und Fitness</h5>
    </div>
  </div>
  <div class="items  pricing pricing--norbu"></div>
</div>
<div id="goodies" class="view">
  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3">Specials</h1>
      <h5 class="h5 display-3">Günstige Angebote und Restposten</h5>
    </div>
  </div>
  <div class="items  pricing pricing--norbu"></div>
</div>
<?php
  echo $this->Html->scriptStart();
    ?>
    var base_url = '<?php echo $this->Html->url('/'); ?>';
    <?php
  echo $this->Html->scriptEnd();
  echo $this->element(STATCONFIG . 'tracking_code');