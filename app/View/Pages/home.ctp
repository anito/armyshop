<div id="home" class="view active">
  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="h1 display-3">Handelsagentur<br>Lehmann</h1>
      <h5 class="h5 display-3">Der Versandhändler Ihres Vertrauens</h5>
    </div>
  </div>
  <div class="jumbotron brand">
    <div class="container">
      <div class="brands display-5"></div>
    </div>
  </div>
  <div class="inner">
    <!-- Example row of columns -->
    <ul class="row ca-menu pricing">
      <li id="outdoor-item-menu" class="item-menu  pricing__item outdoor category">
          <a href="/pages/outdoor/">
            <span class="flaticon-hiking-up-3"></span>
            <div class="ca-content">
              <h2 class="ca-main">Outdoor</h2>
              <h3 class="ca-sub">Atmen Sie durch</h3>
            </div>
          </a>
      </li>
      <li id="fitness-item-menu" class="item-menu  pricing__item fitness category">
          <a href="/pages/fitness/">
            <span class="flaticon-fitness_center"></span>
            <div class="ca-content">
              <h2 class="ca-main">Fitness</h2>
              <h3 class="ca-sub">Bleiben Sie Gesund</h3>
            </div>
          </a>
     </li>
     <li id="tools-item-menu" class="item-menu  pricing__item tools category">
          <a href="/pages/tools/">
            <span class="flaticon-knife"></span>
            <div class="ca-content">
              <h2 class="ca-main">Messer & Tools</h2>
              <h3 class="ca-sub">Messerscharfe Angebote</h3>
            </div>
          </a>
      </li>
     <li id="specials-item-menu" class="item-menu  pricing__item specials category">
          <a href="/pages/specials/">
            <span class="flaticon-sales-label-1"></span>
            <div class="ca-content">
              <h2 class="ca-main">Specials</h2>
              <h3 class="ca-sub">24/7 Geld sparen</h3>
            </div>
          </a>
      </li>
    </ul>
  </div> <!-- /container -->
  
</div>

<?php
  echo $this->Html->scriptStart();
    ?>
    var base_url = '<?php echo $this->Html->url('/'); ?>';
    <?php
  echo $this->Html->scriptEnd();
  echo $this->element(STATCONFIG . 'tracking_code');