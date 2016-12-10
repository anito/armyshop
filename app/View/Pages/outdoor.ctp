<?php
$this->Html->meta('description', array('block' => 'meta'));
?>
<div id="outdoor" class="view active">
  <div class="jumbotron">
    <div class="container">
      <div class="inner">
        <h1 class="display-3">Outdoor</h1>
        <h5 class="h5 display-3">Angebote für Outdoor & Freizeit</h5>
      </div>
    </div>
  </div>
  <div class="jumbotron brand">
    <div class="container">
      <div class="brands display-5"></div>
    </div>
  </div>
  <div class="items  pricing pricing--norbu"></div>
</div>
    
<?php
  echo $this->Html->scriptStart();
    ?>
    var base_url = '<?php echo $this->Html->url('/'); ?>';
    var cat = 'outdoor'
    
    Page = require("controllers/homepage_view");
    exports.HomePage = new Page({
      el: $("#"+cat),
      categoryName: cat
    });
    
    <?php
  echo $this->Html->scriptEnd();
  echo $this->element(STATCONFIG . 'tracking_code');