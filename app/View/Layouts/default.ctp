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
    echo $this->Html->css("component");
    echo $this->Html->css("font");
    echo $this->Html->css("flaticon");
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
<body class="fade in">
  <div class="lehmann"><span class="lehmann-01"></span><span class="lehmann-02"></span></div>
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
          <a class="nav-link" href="/pages/defense">Selbstschutz</a>
        </li>
        <li id="" class="nav-item outdoor">
          <a class="nav-link" href="/pages/outdoor">Outdoor</a>
        </li>
        <li id="" class="nav-item goodies">
          <a class="nav-link" href="/pages/goodies">Specials</a>
        </li>
        <div class="paypal"><img src="/img/paypal-logo.png" alt="Bezahlen mit PayPal"></img></div>
      </ul>
    </nav>
  </header>
  
  <div id="container" style="">
    <div id="content">


      <?php echo $this->fetch('content'); ?>
      <?php echo $this->element('sql_dump'); ?>

    </div>
  </div>
  <footer class="footer">
    <span>© HA Lehman</span>
    <span><a href="#" class="opt-imp">Impressum</a></span>
    <span><a href="#" class=" opt-agb">AGB</a></span>
    <span><a href="#" class=" opt-pay">Zahlungsmöglichkeiten</a></span>
  </footer>
  <!-- modal-dialogue -->
  <div tabindex="0" id="modal-view" role="dialog" aria-labelledby="myModalLabel" class="modal fade" style="top: 65px;"></div>
  <!-- /.modal -->
<?php echo $this->element('sql_dump'); ?>
<script charset="utf-8">

  var exports = this;
  jQuery(function(){
    var App = require("index");
    exports.app = new App({el: $("body")});
  });

</script>
<script id="modalSimpleTemplate" type="text/x-jquery-tmpl">
  <div class="modal-dialog {{if small}}modal-sm{{else}}modal-lg{{/if}}">
    <div class="modal-content bg-dark">
      {{if header}}
      <div class="modal-header dark">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="h3" style="padding-left: 26px;">${header}</h3>
      </div>
      {{/if}}
      {{if body}}
      <div class="modal-body dark">
        {{html body}}
      </div>
      {{if info}}
      <div class="modal-header label-info dark">
        <div class="label label-info">${info}</div>
      </div>
      {{/if}}
      {{/if}}
      {{if footer}}
      <div class="modal-footer dark" style="position: relative">
        <div class="" style="text-align: left; max-width: 90%">{{if footer}}{{html footer}}{{/if}} </div>
        <button class="btn btnClose dark" style="">{{if footerButtonText}}${footerButtonText}{{else}}Ok{{/if}}</button>
      </div>
      {{/if}}
    </div>
  </div>
</script>
</body>
</html>