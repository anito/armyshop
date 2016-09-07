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

    echo $this->Html->css('/js/app/public/application_dummy');
    echo $this->Html->css('jquery-ui-1.8.16.custom');
    echo $this->Html->css("bootstrap.min");
    echo $this->Html->css("websymbols");
    echo $this->Html->css("component");
    echo $this->Html->css("font");
    echo $this->Html->css("flaticon");
    echo $this->Html->css("muli");
    echo $this->Html->css("icons");
    echo $this->Html->css("lehmann");
    echo $this->Html->css("demo");
    echo $this->Html->css("style7");
    echo $this->Html->css("jumbotron");
    
//    jQuery first, then Tether, then Bootstrap JS.
    echo $this->Html->script('app/public/application');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body class="hal fade in">
  <div class="logos">
    <div class="lehmann logo-1 hide"><span class="lehmann-01"></span><span class="lehmann-02"></span></div>
    <div class="logo hide logo-2 hide"></div>
  </div>
  <header id="header" class="header">
    <nav class="navbar navbar-static-top navbar-dark bg-inverse">
      <a class="navbar-brand" href="/">
        <span class="flaticon-menu hide" style="font-size: 2.5em"></span>
      </a>
      <ul class="nav navbar-nav items">
        <li id="" class="nav-item home">
          <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
        </li>
        <li id="" class="nav-item defense">
          <a class="nav-link" href="/pages/defense">Selbstschutz & Security</a>
        </li>
        <li id="" class="nav-item outdoor">
          <a class="nav-link" href="/pages/outdoor">Outdoor & Fitness</a>
        </li>
        <li id="" class="nav-item goodies">
          <a class="nav-link" href="/pages/goodies">Restposten & Specials</a>
        </li>
      </ul>
      <ul class="nav navbar-nav items">
        <li id="" class="nav-item opt-sidebar">
          <a class="nav-link hide" href="#">Lieferung</a>
        </li>
      </ul>
    </nav>
  </header>
  <div class="sidebar bg-inverse glinch">
    <div class="container">
    	<div class="table">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #fff;">×</button>
        <div class="tr">
          <div class="td"></div>
          <div class="td line"></div>
        </div>
        <div class="tr">
          <div class="td"><img src="/img/dolar.png"></div>
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
          <div class="td">Ab einem Bestellwert von <span style="color: white;">50€ </span>liefern wir innerhalb Österreichs frei Haus. <a href="#" class=" opt-del"> Weitere Informationen zum Versand.</a></div>
        </div>
        <div class="tr">
          <div class="td"></div>
          <div class="td line"></div>
        </div>
        <div class="group">
  	  <div class="tr">
            <div class="td"><img src="/img/parcel.png"></div>
            <div class="td">Kosten für Verpackung und Versand nach Österreich</div>
            <div class="td">3, 90€</div>
          </div>
        </div>
        <div class="group">
          <div class="tr">
            <div class="td"></div>
            <div class="td">Kosten für Verpackung und Versand nach Deutschland</div>
            <div class="td">5, 90€</div>
          </div>
        </div>
        <div class="tr">
          <div class="td"></div>
          <div class="td line"></div>
        </div>
      </div>
    </div>
  </div>
  <div id="container" style="">
    <div id="content">


      <?php echo $this->fetch('content'); ?>
      <?php echo $this->element('sql_dump'); ?>

    </div>
  </div>
  <footer class="footer bg-inverse">
    <span class="opt-reset" title="Reset Hinweis">© HA Lehman</span>
    <span><a href="#" class="opt-imp">Impressum</a></span>
    <span><a href="#" class=" opt-agb">AGB</a></span>
    <span><a href="#" class=" opt-pay">Zahlungsmöglichkeiten</a></span>
    <span><a href="#" class=" opt-del">Versand</a></span>
  </footer>
  <!-- modal-dialogue -->
  <div tabindex="0" id="modal-view" role="dialog" aria-labelledby="myModalLabel" class="modal fade" style="top: 65px;"></div>
  <!-- /.modal -->
<?php echo $this->element('sql_dump'); ?>
<script charset="utf-8">

  var exports = this;
  jQuery(function(){
    var App = require("index");
    exports.App = new App({el: $("body")});
  });

</script>
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
        <button class="btn btn-primary opt-agreed" style="" data-dismiss="modal" data-toggle="button">{{if footer.footerButtonText}}${footer.footerButtonText}{{else}}Ok{{/if}}</button>
      </div>
      {{/if}}
    </div>
  </div>
</script>
</body>
</html>
