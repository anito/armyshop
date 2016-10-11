
<div id="home" class="view">
  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="h1 display-3">Handelsagentur<br>Lehmann</h1>
      <h5 class="h5 display-3">Der Versandhändler Ihres Vertrauens</h5>
    </div>
  </div>
  <div class="container">
    <!-- Example row of columns -->
    <ul class="row ca-menu pricing">
      <li id="defense-item-menu" class="item-menu  pricing__item">
          <a href="/#/defense/">
            <span class="flaticon-pepper-spray"></span>
            <div class="ca-content">
              <h2 class="ca-main">Selbstschutz & Security</h2>
              <h3 class="ca-sub">Fühlen Sie sich sicher?</h3>
            </div>
          </a>
      </li>
      <li id="outdoor-item-menu" class="item-menu  pricing__item">
          <a href="/#/outdoor/">
            <span class="flaticon-hiking-up-2"></span>
            <div class="ca-content">
              <h2 class="ca-main">Outdoor & Fitness</h2>
              <h3 class="ca-sub">Bleiben Sie Gesund</h3>
            </div>
          </a>
     </li>
     <li id="goodies-item-menu" class="item-menu  pricing__item">
          <a href="/#/goodies/">
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
<div id="defense" class="view">
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
<div id="outdoor" class="view">
  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3">Outdoor & Fitness</h1>
      <h5 class="h5 display-3">Angebote für Sport und Freizeit</h5>
    </div>
  </div>
  <div class="items  pricing pricing--norbu"></div>
</div>
<div id="goodies" class="view">
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
<script id="modalSimpleTemplate" type="text/x-jquery-tmpl">
  <div class="modal-dialog {{if small}}modal-sm{{else}}modal-lg{{/if}}">
    <div class="modal-content">
      {{if header}}
      <div class="modal-header {{if css}}{{html css}}{{/if}}">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="h3" style="padding-left: 26px;">${header}</h3>
      </div>
      {{/if}}
      {{if body}}
      <div class="modal-body">
        {{html body}}
      </div>
      {{if info}}
      <div class="modal-header label-info">
        <div class="label label-info">${info}</div>
      </div>
      {{/if}}
      {{/if}}
      {{if (typeof footer != 'undefined' && footer.footerButtonText)}}
      <div class="modal-footer" style="position: relative">
        <div class="" style="text-align: left; max-width: 90%">{{if footer.footerBody}}{{html footer.footerBody}}{{/if}} </div>
        <button class="btn btn-dark opt-agreed" style="" data-dismiss="modal" data-toggle="button">{{if footer.footerButtonText}}${footer.footerButtonText}{{else}}Ok{{/if}}</button>
      </div>
      {{/if}}
    </div>
  </div>
</script>

<script id="norbuPricingTemplate" type="text/x-tmpl">
  <div class="pricing__item">
    <h3 class="pricing__title">${product.title}</h3>
    <p class="pricing__sentence">${product.subtitle}</p>
    <div class="pricing__price"><span class="pricing__currency">€</span>${product.price}
      <a href="{{if product.link}}${product.link}{{else}}#{{/if}}" target="_blank" class="" aria-disabled="{{if product.link}}${product.link}{{else}}false{{/if}}">
        {{tmpl($item.data.photo) "#norbuImageListTemplate" }}
      </a>
    </div>
    <div class="pricing__feature-list">
      <ul class="">{{tmpl($item.data.descriptions) "#norbuFeatureListTemplate" }}</ul>
    </div>
    <a href="{{if product.link}}${product.link}{{else}}#{{/if}}" target="_blank" class="pricing__action btn btn-dark btn-lg" role="button" aria-disabled="{{if product.link}}${product.link}{{else}}false{{/if}}">Zum Shop</a>
  </div>
</script>

<script id="norbuImageListTemplate" type="text/x-tmpl">
  <div id="${id}" class="pricing__image"><img class="image" src="/img/semperfi.png"/></div>
</script>

<script id="norbuFeatureListTemplate" type="text/x-tmpl">
  <li class="pricing__feature">{{html description}}</li>
</script>


