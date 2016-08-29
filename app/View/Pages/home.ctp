<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h1 class="display-3">Willkommen</h1>
    <div class="right"><a class="btn btn-primary btn-lg" href="#" role="button">Erfahren Sie mehr »</a></div>
  </div>
</div>

<div class="container">
  <!-- Example row of columns -->
  <ul class="row ca-menu">
    <li id="defense-item-menu" class="item-menu col-md-4">
        <a href="/pages//defense">
          <span class="flaticon-pepper-spray"></span>
          <div class="ca-content">
            <h2 class="ca-main">Security & Selbstschutz</h2>
            <h3 class="ca-sub">Fühlen Sie sich sicher?</h3>
          </div>
        </a>
    </li>
    <li id="outdoor-item-menu" class="item-menu col-md-4">
        <a href="/pages//outdoor">
          <span class="flaticon-hiking-up-2"></span>
          <div class="ca-content">
            <h2 class="ca-main">Outdoor & Fitness</h2>
            <h3 class="ca-sub">Bleiben Sie Gesund</h3>
          </div>
        </a>
   </li>
   <li id="goodies-item-menu" class="item-menu col-md-4">
        <a href="/pages/goodies">
          <span class="flaticon-sales-label"></span>
          <div class="ca-content">
            <h2 class="ca-main">Restposten & Specials</h2>
            <h3 class="ca-sub">24/7 Geld sparen</h3>
          </div>
        </a>
    </li>
  </ul>

</div> <!-- /container -->
<?php
  echo $this->Html->scriptStart();
    ?>
    var base_url = '<?php echo $this->Html->url('/home'); ?>';
    <?php
  echo $this->Html->scriptEnd();

?>



