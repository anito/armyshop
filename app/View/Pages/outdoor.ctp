<div class="outer-wrapper">
		<div class="content">
      <div class="page-sidebar">

        <div class="page-header hide" style="">
          <div class="container">
            
            
            
            
            <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
              <!-- Breadcrumb NavXT 5.5.1 -->
              <span property="itemListElement" typeof="ListItem">
                <a property="item" typeof="WebPage" title="Go to rankingCHECK." href="/" class="home">
                  <span property="name">Home</span>
                </a>
              </span> » <span property="itemListElement" typeof="ListItem">
                  <span property="name">Outdoor</span>
                </span>
            </div>
            <a href="#scrolloutdoor" class="scroll">
            <div class="row">
              <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                <i class="linearicons linearicons-outdoor"></i>
                <h1>Outdoor</h1>
              </div>
            </div>
            </a>
          </div>
        </div>
        
        <div id="outdoor" class="view active">
          <div class="jumbotron">
            <div class="container">
              <div class="inner">
                <h1 class="display-3 hidemobile">Outdoor</h1>
                <h2 class="hide">Angebote für Outdoor & Freizeit</h2>
                <h5 class="h5 display-3 hidemobile">Angebote für Outdoor & Freizeit</h5>
              </div>
            </div>
          </div>
          <div class="jumbotron brand hidemobile">
            <div class="container">
              <div class="brands display-5"></div>
            </div>
          </div>
          <div id="scrolloutdoor" class="items tile pricing pricing--norbu"></div>
        </div>
        <!-- page_header_hintergrundbild -->
      </div>
      
    </div><!-- .content -->

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