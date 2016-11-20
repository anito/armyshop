<div id="outdoor" class="view active">
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3">Outdoor & Fitness</h1>
      <h5 class="h5 display-3">Angebote für Sport und Freizeit</h5>
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
      el: $("#outdoor"),
      categoryName: 'outdoor'
    });
    
    <?php
  echo $this->Html->scriptEnd();
  echo $this->element('tracking_code');