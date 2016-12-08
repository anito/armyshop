
<div id="home" class="view">
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
      <li id="outdoor-item-menu" class="item-menu  pricing__item">
          <a href="/#/outdoor/">
            <span class="flaticon-pepper-spray"></span>
            <div class="ca-content">
              <h2 class="ca-main">Selbstschutz & Security</h2>
              <h3 class="ca-sub">Fühlen Sie sich sicher?</h3>
            </div>
          </a>
      </li>
      <li id="fitness-item-menu" class="item-menu  pricing__item">
          <a href="/#/fitness/">
            <span class="flaticon-hiking-up-2"></span>
            <div class="ca-content">
              <h2 class="ca-main">Fitness & Fitness</h2>
              <h3 class="ca-sub">Bleiben Sie Gesund</h3>
            </div>
          </a>
     </li>
     <li id="specials-item-menu" class="item-menu  pricing__item">
          <a href="/#/specials/">
            <span class="flaticon-sales-label"></span>
            <div class="ca-content">
              <h2 class="ca-main">Restposten & Specials</h2>
              <h3 class="ca-sub">24/7 Geld sparen</h3>
            </div>
          </a>
      </li>
    </ul>
  </div> <!-- /container -->
  
</div>
<div id="outdoor" class="view">
  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <div class="inner">
        <h1 class="display-3">Selbstschutz & Security</h1>
        <h5 class="h5 display-3">Schützen Sie sich und Ihre Mitmenschen vor möglichen Gefahren</h5>
        <div class="opt-hint hint"><a class="btn btn-primary btn-lg" href="#" role="button" style="font-size: 1rem;">Hinweis zu FSK18 Artikeln anzeigen»</a></div>
      </div>
    </div>
  </div>
  <div class="items  pricing pricing--norbu"></div>
</div>
<div id="fitness" class="view">
  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3">Fitness & Fitness</h1>
      <h5 class="h5 display-3">Angebote für Sport und Freizeit</h5>
    </div>
  </div>
  <div class="items  pricing pricing--norbu"></div>
</div>
<div id="specials" class="view">
  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3">Restposten & Specials</h1>
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

?>

<!--@media screen and (min-width:320px) and (max-width:480px){
-->
}