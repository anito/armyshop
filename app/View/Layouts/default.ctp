<?php
/** 
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'HA-Lehmann');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
    echo $this->Html->meta('viewport', array('width'=>'device-width', 'initial-scale'=>1, 'shrink-to-fit'=>'no'));
		echo $this->Html->meta('http-equiv', "x-ua-compatible");
		echo $this->Html->meta('icon');
		echo $this->Html->meta('keywords', array('Restposten', 'Ausverkauf', 'Schnäppchen', 'Aktion', 'Sale', 'Selbstschutz', 'Selbstverteidigung', 'Pfefferspray', 'Fitness', 'Outdoor'));
		echo $this->Html->meta('description', 'Der Versandhandel Ihres Vertrauens, HA-Lehmann, bietet Ihnen Artikel aus verschiedenen Branchen, wie Selbstschutz & Selbstverteidigung, Outdoor & Fitness sowie Alltagsrtikel & Restposten verschiedenster Art zu besonders günstigen Preisen an.');

//    echo $this->Html->css('jquery-ui-1.8.16.custom');
    echo $this->Html->css('bootstrap');
    echo $this->Html->css('bootstrap_glyphicons');
    echo $this->Html->css("websymbols");
    echo $this->Html->css("font");
    echo $this->Html->css("flaticon");
    echo $this->Html->css("muli");
    echo $this->Html->css("icons");
    echo $this->Html->css("lehmann");
    echo $this->Html->css("demo");
    echo $this->Html->css("style7");
    echo $this->Html->css("component");
    echo $this->Html->css("mobile_device", array('media' => 'only screen and (min-device-width : 320px) and (max-device-width : 667px) '));
    echo $this->Html->css("spine");
    
//    jQuery first, then Tether, then Bootstrap JS.
    echo $this->Html->script('app/public/application');
    echo $this->Html->script("app/lib/jquery.slides");

    echo $this->Html->scriptStart();
    ?>
    var base_url = '<?php echo $this->Html->url('/'); ?>';
    <?php
    echo $this->Html->scriptEnd();
    ?>

    <?php
    echo $this->Html->scriptStart();
    ?>
    var exports = this;
    $(function() {
      
      var isProduction = true
      
      
      var categories = <?php echo $this->Js->object($categories); ?>;
      var products = <?php echo $this->Js->object($products); ?>;
      var photos = <?php echo $this->Js->object($photos); ?>;
      var descriptions = <?php echo $this->Js->object($descriptions); ?>;
      
      var startScript = function() {
        setTimeout(function() {}, 2000)
      };
      
      require("lib/setup")
      Model = Spine.Model
      Spine.isProduction = (localStorage.isProduction != null) ? !(localStorage.isProduction === 'false') : isProduction
      
      Category = require('models/category')
      Product = require('models/product')
      Photo = require('models/photo')
      Description = require('models/description')
      
      User    = require("models/user");
      Main    = require("index");
      
      Spine.Route = require('spine/lib/route');
      
      exports.App = new Main({el: $("body")});
      //User.ping()
      
      Description.refresh(descriptions, {clear: true});
      Photo.refresh(photos, {clear: true});
      Product.refresh(products, {clear: true});
      Category.refresh(categories, {clear: true});
      
      Spine.Route.setup()
      
      startScript()
      
    });
    <?php
    
    echo $this->Html->scriptEnd();
    
    $this->log($this->fetch('meta'), LOG_DEBUG);
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body class="hal home fade in">
  <div class="logos">
    <div class="lehmann logo-1 hide"><span class="lehmann-01"></span><span class="lehmann-02"></span></div>
    <div class="logo logo-2 hide"></div>
  </div>
  <header id="header" class="header">
    <nav class="navbar navbar-sm navbar-static-top navbar-dark bg-inverse">
      <ul class="nav navbar-nav items">
        <li id="" class="nav-item home">
          <a class="nav-link flaticon-home-3" href="/pages/home/">Home<span class="sr-only">(current)</span></a>
        </li>
        <li id="" class="nav-item defense">
          <a class="nav-link flaticon-hiking-up-3" href="/pages/defense/">Outdoor</a>
        </li>
        <li id="" class="nav-item outdoor">
          <a class="nav-link flaticon-hiking-up-2" href="/pages/outdoor/">Fitness</a>
        </li>
        <li id="" class="nav-item goodies">
          <a class="nav-link flaticon-sales-label" href="/pages/goodies/">Specials</a>
        </li>
      </ul>
    </nav>
    <nav class="navbar navbar-lg navbar-static-top navbar-dark bg-inverse">
      <ul class="nav navbar-nav items">
        <li id="" class="nav-item home">
          <a class="nav-link flaticon-home-3" href="/pages/home/">Home <span class="sr-only">(current)</span></a>
        </li>
        <li id="" class="nav-item defense">
          <a class="nav-link nav-link flaticon-hiking-up-3" href="/pages/defense/">Outdoor</a>
        </li>
        <li id="" class="nav-item outdoor">
          <a class="nav-link flaticon-hiking-up-2" href="/pages/outdoor/">Fitness</a>
        </li>
        <li id="" class="nav-item goodies">
          <a class="nav-link flaticon-sales-label" href="/pages/goodies/">Specials</a>
        </li>
      </ul>
    </nav>
  </header>
  <div class="sidebar bg-inverse glinch">
    <div class="container">
    	<div class="table">
        <div class="tr">
          <div class="td"></div>
          <button type="button" class="btn btn-dark sm wide opt-close" aria-hidden="true">schliessen</button>
        </div>
        <div class="tr">
          <div class="td line"></div>
          <div class="td"></div>
        </div>
        <div class="tr">
          <div class="td"><img src="/img/dollar.png"></div>
          <div class="td">
            Bezahlen Sie bequem per PayPal in unserem Online-Partnershop. Informieren Sie sich auch über unsere anderen <a href="#" class=" opt-pay">Zahlungsmöglichkeiten</a>
          </div>
        </div>
        <div class="tr">
          <div class="td"></div>
          <div class="td line"></div>
        </div>
        <div class="tr">
          <div class="td"><img src="/img/truck.png"></div>
          <div class="td">Ab einem Bestellwert von <span style="color: white;">50€ </span>liefern wir innerhalb Österreichs <span style="color: white;">frei Haus.</span><br><a href="#" class=" opt-del"> Weitere Informationen zum Versand.</a></div>
        </div>
        <div class="tr">
          <div class="td"></div>
          <div class="td line"></div>
        </div>
        <div class="tr">
          <div class="td"><img src="/img/parcel.png"></div>
          <div class="rowgroup">
            <div class="td">Kosten für Verpackung und Versand nach Österreich</div>
            <div class="td">3, 90€</div>
          </div>
        </div>
        <div class="tr">
          <div class="td "></div>
          <div class="rowgroup">
            <div class="td">Kosten für Verpackung und Versand nach Deutschland</div>
            <div class="td">5, 90€</div>
          </div>
        </div>
        <div class="tr">
          <div class="td line"></div>
          <div class="td"></div>
        </div>
        <div class="trustami-badge"></div>
      </div>
    </div>
  </div>
  <div id="container" style="">
    <div id="content" class="views">

      <?php echo $this->fetch('content'); ?>
      <?php echo $this->element('sql_dump'); ?>
      
    </div>
  </div>
  <footer class="footer bg-inverse">
    <span class="nav-group">
      <span id="refresh" class="left-inline"></span>
      <span class="opt-reset" title="FSK 18 Hinweis zurücksetzen">© HA Lehman</span>
      <span><a href="#" class="opt-imp">Impressum</a></span>
      <span><a href="#" class="opt-agb">AGB</a></span>
      <span><a href="#" class="opt-pay">Zahlungsmöglichkeiten</a></span>
      <span><a href="#" class="opt-del">Versand</a></span>
      <span><a href="#" class="opt-stats stats">Statistik</a></span>
    </span>
  </footer>
  <iframe id="stats" frameborder="0" scrolling="no" class="fadeslow away"></iframe>
  <!-- modal-dialogue -->
  <div tabindex="0" id="modal-view" role="dialog" aria-labelledby="myModalLabel" class="modal fade" style="top: 65px;"></div>
  <!-- /.modal -->
</body>
</html>

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
  {{if !product.ignored}}
  <div id="${product.id}" class="pricing__item">
    <h3 class="pricing__title">${$().name(product.title, 60)}</h3>
    <p class="pricing__sentence">${$().name(product.subtitle, 80)}</p>
    <div class="pricing__price"><span class="pricing__currency">€</span>${product.price}
      <a href="{{if product.link}}${product.link}{{else}}#{{/if}}" target="_blank" class="slides" aria-disabled="{{if product.link}}${product.link}{{else}}false{{/if}}">
        {{tmpl($item.data.photos) "#norbuImageListTemplate" }}
      </a>
    </div>
    <div class="pricing__feature-list">
      <ul class="">{{tmpl($item.data.descriptions) "#norbuFeatureListTemplate" }}</ul>
    </div>
    <a href="{{if product.link}}${product.link}{{else}}#{{/if}}" target="_blank" class="pricing__action btn-dark" role="button" aria-disabled="{{if product.link}}${product.link}{{else}}false{{/if}}">Zum Shop</a>
  </div>
  {{/if}}
</script>

<script id="norbuImageListTemplate" type="text/x-tmpl">
  <div id="${id}" class="pricing__image"><img class="image load" src="/img/ajax-loader-66.gif"/></div>
</script>

<script id="norbuFeatureListTemplate" type="text/x-tmpl">
  <li class="pricing__feature">{{html description}}</li>
</script>

<script id="refreshTemplate" type="text/x-tmpl">
  <a href="${location.hash}" class="opt-Refresh"><i class="glyphicon glyphicon-${icon}"></i></a>
</script>

<script id="trustamiTemplate" type="text/x-tmpl">
  <a href="https://app.trustami.com/trustami-card/57e573efcc96c5511c8b480e" target="_blank" title="Trustami Bewertungen und Erfahrungen von Handelsagentur Lehmann">
    <div class="trustami-inner">
      <i class="trustami-image"></i>
      <span class="trustami-count">${tmi}</span>
    </div>
  </a>
</script>