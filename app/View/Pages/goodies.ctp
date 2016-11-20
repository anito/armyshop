<div id="goodies" class="view active">
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3">Restposten & Specials</h1>
      <h5 class="h5 display-3">Günstige Angebote und Restposten</h5>
    </div>
  </div>
  <div class="items pricing pricing--norbu"></div>
</div>
<?php
  echo $this->Html->scriptStart();
    ?>
    var base_url = '<?php echo $this->Html->url('/'); ?>';
    
    Page = require("controllers/homepage_view");
    exports.HomePage = new Page({
      el: $("#goodies"),
      categoryName: 'goodies'
    });
    
    <?php
  echo $this->Html->scriptEnd();
  echo $this->element(STATCONFIG . 'tracking_code');