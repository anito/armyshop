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
    echo $this->Html->meta(array('name' => 'viewport', 'content'=> 'width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1'));
		echo $this->Html->meta('http-equiv', "x-ua-compatible");
		echo $this->Html->meta('icon');
		echo $this->Html->meta('keywords', $keywords);
		echo $this->Html->meta('description', 'Der Versandhandel Ihres Vertrauens, HA-Lehmann, bietet Ihnen Artikel aus verschiedenen Branchen, wie Selbstschutz, Selbstverteidigung, Outdoor, Fitness sowie Alltagsrtikel und Restposten verschiedenster Art zu besonders günstigen Preisen an.');
		echo $this->Html->meta('description', $meta);

//    echo $this->Html->css('jquery-ui-1.8.16.custom');
    echo $this->Html->css('bootstrap');
    echo $this->Html->css('bootstrap_glyphicons');
    echo $this->Html->css("websymbols");
    echo $this->Html->css("font");
    echo $this->Html->css("flaticon");
    echo $this->Html->css("muli");
    echo $this->Html->css("icons");
    echo $this->Html->css("lehmann");
    echo $this->Html->css("common");
    echo $this->Html->css("demo", array('media' => 'only screen and (min-device-width : 768px)'));
    echo $this->Html->css("style7", array('media' => 'only screen and (min-device-width : 768px)'));
    echo $this->Html->css("component", array('media' => 'only screen and (min-device-width : 768px)'));
    echo $this->Html->css("component_mobile", array('media' => 'only screen and (min-device-width : 320px) and (max-device-width : 767px) '));
//    echo $this->Html->css("mobile_device", array('media' => 'only screen and (min-device-width : 320px) and (max-device-width : 767px) '));
    echo $this->Html->css("touch", array('media' => 'only screen and (min-device-width : 320px) and (max-device-width : 767px) '));
    echo $this->Html->css("swiper/style", array('media' => 'only screen and (min-device-width : 320px) and (max-device-width : 767px) '));
    echo $this->Html->css("swiper/custom", array('media' => 'only screen and (min-device-width : 320px) and (max-device-width : 767px) '));
    echo $this->Html->css("swiper/swiper.min", array('media' => 'only screen and (min-device-width : 320px) and (max-device-width : 767px) '));
    echo $this->Html->css("spine");
    
//    jQuery first, then Tether, then Bootstrap JS.
    echo $this->Html->script('app/public/application');
    echo $this->Html->script("app/lib/swiper/script");
    echo $this->Html->script("app/lib/swiper/swiper.min");
    echo $this->Html->script("app/lib/swiper/swipe");

    echo $this->Html->scriptStart();
  ?>
    var base_url = '<?php echo $this->Html->url('/'); ?>';
    var exports = this;
    
    $(function() {
      
      var isProduction = false
      
      
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
  
  <?php echo $this->Html->scriptEnd(); ?>
    
  <?php
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
    
    echo $this->element('google-analytics');
	?>
</head>
<body class="hal hal-home fade in">
  <div class="logos hidemobile">
    <div class="lehmann logo-1 hide"><span class="lehmann-01"></span><span class="lehmann-02"></span></div>
    <div class="logo logo-2 hide"></div>
  </div>
  <header id="header" class="header hidemobile">
    <nav class="navbar navbar-static-top navbar-dark bg-inverse">
      <ul class="nav navbar-nav items">
        <li id="" class="nav-item">
          <a class="nav-link linearicons-home" href="/pages/home/">Home <span class="sr-only">(current)</span></a>
        </li>
        <li id="" class="nav-item outdoor">
          <a class="nav-link nav-link linearicons-outdoor" href="/pages/outdoor/">Outdoor</a>
        </li>
        <li id="" class="nav-item fitness">
          <a class="nav-link linearicons-fitness" href="/pages/fitness/">Fitness</a>
        </li>
        <li id="" class="nav-item tools">
          <a class="nav-link linearicons-tools" href="/pages/tools/">Messer & Tools</a>
        </li>
        <li id="" class="nav-item specials">
          <a class="nav-link linearicons-specials" href="/pages/specials/">Specials</a>
        </li>
      </ul>
    </nav>
  </header>
  <header class="main">
		 <!-- SPRACHWÄHLER -->
		<div class="main-header">
			<a href="/" rel="home" class="home-link">Handelagentur Lehmann</a>
			<div class="open-menu">
				<span></span>
				<span></span>
				<span></span>
				<span></span>
				<div>MENÜ</div>
			</div>
		</div>
	</header>
  
  <div id="container" style="">
    <div id="content" class="views">

      <?php echo $this->fetch('content'); ?>
      <?php echo $this->element('sql_dump'); ?>

    </div>
  </div>
  
  <footer class="mobile hide">
    <div class="bottom">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <p>© 2016 HA Lehmann</p>
            <a href="https://www.haendlerbund.de/mitglied/show.php?uuid=13b695f4-b7a3-11e6-8974-9c5c8e4fb375-3496146168" target="_blank">
              <i class="hb-badge-sw"></i>
            </a>
            <div class="menu-footer-menu-rechtliches-container">
              <ul id="" class="menu">
                <li id="" class=""><a href="#" class="opt-imp">Impressum</a></li>
                <li id="" class=""><a href="#" class="opt-del">Versand</a></li>
                <li id="" class=""><a href="#" class="opt-pay">Zahlungsmöglichkeiten</a></li>
                <li id="" class=""><a href="#" class="opt-privacy">Datenschutz</a></li>
                <li id="" class=""><a href="#" class="opt-revocation">Widerrufsbelehrung</a></li>
                <li id="" class=""><a href="#" class="opt-agb">AGB</a></li>
                <li id="" class="" id="refresh" class="left-inline"></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <nav id="menu-push-right" class="menu-push-right hide">
    <div class="language-selector-mobile"></div>
    <span class="menu-push-right-close menu-push-to-close"></span>
    <div class="menu-main-menu-container">
      <ul id="menu-main-menu" class="menu">
        <li id="" class="menu-item-has-children navigation"><a href="#">Navigation</a></li>
        <li id="" class=""><a href="/">Home</a></li>
        <li id="" class=""><a href="/pages/outdoor">Outdoor</a></li>
        <li id="" class=""><a href="/pages/fitness">Fitness</a></li>
        <li id="" class=""><a href="/pages/tools">Messer & Tools</a></li>
        <li id="" class=""><a href="/pages/specials">Restposten & Specials</a></li>
      </ul>
    </div>
    <div class="menu-seitenmenue-unten-container">
      <ul id="menu-seitenmenue-unten" class="menu">
        <li id="" class="menu-item-has-children misc"><a href="#">Rechtliches</a></li>
        <li id=""><a href="#" class="opt-imp menu-push-to-close">Impressum</a></li>
        <li id=""><a href="#" class="opt-del menu-push-to-close">Versand</a></li>
        <li id=""><a href="#" class="opt-pay menu-push-to-close">Zahlungsmöglichkeiten</a></li>
        <li id=""><a href="#" class="opt-privacy menu-push-to-close">Datenschutz</a></li>
        <li id=""><a href="#"  class="opt-revocation menu-push-to-close">Widerrufsbelehrung</a></li>
        <li id=""><a href="#"  class="opt-agb menu-push-to-close">AGB</a></li>
      </ul>
    </div>
  </nav>
  <div class="sidebar bg-inverse glinch hidemobile">
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
          <div class="td">Ab einem Bestellwert von <span style="color: white;">50€ </span>liefern wir innerhalb Österreichs <span style="color: white;">frei Haus.</span><i class="dpd-dhl-logo"></i><a href="#" class=" opt-del"> Weitere Informationen zum Versand.</a></div>
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
        <div class="hb-badge"></div>
      </div>
    </div>
  </div>
  
  <footer class="footer bg-inverse hidemobile">
    <span class="nav-group">
      <span class="fc-logo"><a href="https://www.haendlerbund.de/faircommerce" target="_blank"><img src="/img/fc_logo.gif"></img></a></span>
      <span class="opt-reset" title="FSK 18 Hinweis zurücksetzen">© HA Lehman</span>
      <span><a href="#" class="opt-imp">Impressum</a></span>
      <span><a href="#" class="opt-del">Versand</a></span>
      <span><a href="#" class="opt-pay">Zahlungsmöglichkeiten</a></span>
      <span><a href="#" class="opt-privacy">Datenschutz</a></span>
      <span><a href="#" class="opt-revocation">Widerrufsbelehrung</a></span>
      <span><a href="#" class="opt-agb">AGB</a></span>
      <span id="refresh" class="left-inline"></span>
      <span><a href="#" class="opt-stats stats">Statistik</a></span>
    </span>
  </footer>
  <iframe id="stats" frameborder="0" scrolling="no" class="fadeslow away hidemobile"></iframe>
  <!-- modal-dialogue -->
  <div tabindex="0" id="modal-view" role="dialog" aria-labelledby="myModalLabel" class="modal fade" style="z-index: 9999;"></div>
  <!-- /.modal -->
  <script>

	</script>
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
        <a class="opt-agreed" style="" role="button" data-dismiss="modal" data-toggle="button">{{if footer.footerButtonText}}${footer.footerButtonText}{{else}}Ok{{/if}}</button>
      </div>
      {{/if}}
    </div>
  </div>
</script>

<script id="norbuPricingDetailsTemplate" type="text/x-tmpl">
  <div class="">
    {{tmpl() "#norbuPricingDetailsTemplate_" }}
  </div>
</script>
  
<script id="norbuPricingDetailsTemplate_" type="text/x-tmpl">
  <div class="pricing--details pricing--norbu_">
    <div id="${id}" data-id="${id}" class="pricing__item">
      <p class="h5 pricing__sentence">{{if subtitle}}${$().name(subtitle, 80)}{{else}}<hr>{{/if}}</p>
      <div class="pricing__price"><div class="price"><span class="pricing__currency">€</span>${price}</div>
        {{if link}}<a href="${link}" target="_blank" class="slides" aria-disabled="false">{{/if}}
        {{tmpl($item.data.photos()) "#norbuImageListTemplate" }}
        {{if link}}</a>{{/if}}
      </div>
      <ul class="pricing__feature-list">{{tmpl($item.data.descriptions()) "#norbuFeatureListTemplate" }}</ul>
      {{if link}}
      <a href="${link}}" target="_blank" class="pricing__action ebay btn-dark col-md-6" role="button" aria-disabled=""><i class="ebay"></i>Zum Shop</a>
      {{/if}}
    </div>
  </div>
</script>

<script id="norbuPricingTemplate" type="text/x-tmpl">
  {{if !ignored}}
  <div id="${id}" data-id="${id}" class="pricing__item">
    <h3 class="pricing__title">${$().name(title, 60)}</h3>
    <p class="pricing__sentence">${$().name(subtitle, 80)}</p>
    <div class="pricing__price"><div class="price"><span class="pricing__currency">€</span>${price}</div>
      {{tmpl($item.data.photos()) "#norbuImageListTemplate" }}
    </div>
    <div class="pricing__feature-list">
      <ul class="">{{tmpl($item.data.descriptions()) "#norbuFeatureListTemplate" }}</ul>
    </div>
    <a href="{{if link}}${link}{{else}}#{{/if}}" target="_blank" class="pricing__action btn-dark" role="button" aria-disabled="{{if link}}${link}{{else}}false{{/if}}">Zum Shop</a>
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

<script id="hbTemplate" type="text/x-tmpl">
  <a href="https://www.haendlerbund.de/mitglied/show.php?uuid=13b695f4-b7a3-11e6-8974-9c5c8e4fb375-3496146168" target="_blank">
    <img src="/img/hbLogo.jpg" title="H&auml;ndlerbund Mitglied" alt="Mitglied im H&auml;ndlerbund" hspace="5" vspace="5" border="0" />
  </a>
</script>