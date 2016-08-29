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

    echo $this->Html->css("bootstrap.min");
    echo $this->Html->css("component");
    echo $this->Html->css('/js/app/public/application_dummy');
    echo $this->Html->css("font");
    echo $this->Html->css("flaticon");
    echo $this->Html->css("demo");
    echo $this->Html->css("style7");
    echo $this->Html->css("jumbotron");
    
//    jQuery first, then Tether, then Bootstrap JS.
    echo $this->Html->script('jquery.min');
    echo $this->Html->script('tether.min');
    echo $this->Html->script('bootstrap.min');
    echo $this->Html->script('app/public/application');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body class="fade in">
  <header id="header">
    <nav class="navbar navbar-static-top navbar-dark bg-inverse">
      <a class="navbar-brand" href="/"><span class="flaticon-menu" style="font-size: 2.5em"></span></a>
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
          <a class="nav-link" href="/pages/goodies">Goodies</a>
        </li>
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
    <span><a href="#"></a>Impressum</span>
    <span><a href=""></a>Shop 1</span>
    <span><a href=""></a>Shop 2</span>
    <span><a href=""></a>Shop 3</span>
  </footer>

<?php echo $this->element('sql_dump'); ?>
<script charset="utf-8">

  var exports = this;
  jQuery(function(){
    var App = require("index");
    exports.app = new App({el: $("body")});
  });

</script>
</body>
</html>