<div class="outer-wrapper">
    <div class="content">
        <div class="page-sidebar">
            <div id="" class="page-header hide" style="">
                <div class="container">
                    <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
                        <!-- Breadcrumb NavXT 5.5.1 -->
                        <span property="itemListElement" typeof="ListItem">
                            <span property="name">Home</span>
                        </span>
                    </div>
                    <a href="#scrollhome" class="scroll">
                        <div class="row">
                            <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                                <i class="lnr-home"></i>
                                <h1>HHerzlich Willkommen</h1>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div id="home" class="view active">
                <!-- Main jumbotron for a primary marketing message or call to action -->
                <div class="jumbotron">
                    <div class="container">
                        <h1 class="h1 display-3 hidemobile">Handelsagentur<br>Lehmann</h1>
                        <h5 class="h5 display-3 hidemobile">Der Versandhändler Ihres Vertrauens</h5>
                    </div>
                </div>
                <div class="jumbotron brand hidemobile">
                    <div class="container">
                        <div class="brands display-5"></div>
                    </div>
                </div>
                <div class="inner hidemobile">
                    <!-- Example row of columns -->
                    <ul class="row ca-menu pricing">
                        <li id="outdoor-item-menu" class="item-menu  pricing__item outdoor category">
                            <a href="/pages/outdoor/">
                                <span class="lnr-sun"></span>
                                <div class="ca-content">
                                    <h2 class="ca-main">Outdoor</h2>
                                    <h3 class="ca-sub">Atmen Sie Durch</h3>
                                </div>
                            </a>
                        </li>
                        <li id="fitness-item-menu" class="item-menu  pricing__item fitness category">
                            <a href="/pages/fitness/">
                                <span class="lnr-bicycle"></span>
                                <div class="ca-content">
                                    <h2 class="ca-main">Fitness</h2>
                                    <h3 class="ca-sub">Bleiben Sie Gesund</h3>
                                </div>
                            </a>
                        </li>
                        <li id="tools-item-menu" class="item-menu  pricing__item tools category">
                            <a href="/pages/tools/">
                                <span class="lnr-diamond"></span>
                                <div class="ca-content">
                                    <h2 class="ca-main">Messer & Tools</h2>
                                    <h3 class="ca-sub">Messerscharfe Angebote</h3>
                                </div>
                            </a>
                        </li>
                        <li id="specials-item-menu" class="item-menu  pricing__item specials category">
                            <a href="/pages/specials/">
                                <span class="lnr-star"></span>
                                <div class="ca-content">
                                    <h2 class="ca-main">Specials</h2>
                                    <h3 class="ca-sub">24/7 Geld Sparen</h3>
                                </div>
                            </a>
                        </li>
                        <li id="defense-item-menu" class="item-menu  pricing__item defense category">
                            <a href="/pages/defense/">
                                <span class="lnr-hand"></span>
                                <div class="ca-content">
                                    <h2 class="ca-main">Defense</h2>
                                    <h3 class="ca-sub">Vorbereitet Sein</h3>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div> <!-- /container -->

            </div>
            <!-- page_header_hintergrundbild -->

            <div id="scrollhome" class="container hide"><!-- outer .container -->
                <!-- seitennavi_links -->
                <div class="row">
                    <div class="col-xs-12 col-md-5 col-lg-4">
                        <div class="inhaltsverzeichnis sticky-element affix-top" style="width: 285px; top: 140px;">
                            <span>Das sind unsere Rubriken</span>
                            <ul class="inhalt">
                                <li>
                                    <a href="/pages/outdoor" title="Outdoor" class="">Outdoor</a>
                                </li>
                                <li>
                                    <a href="/pages/fitness" title="Fitness" class="">Fitness</a>
                                </li>
                                <li>
                                    <a href="/pages/tools" title="Messer & Tools" class="">Messer & Tools</a>
                                </li>
                                <li>
                                    <a href="/pages/specials" title="Restposten & Specials" class="">Restposten & Specials</a>
                                </li>
                                <li>
                                    <a href="/pages/defense" title="Defense" class="">Defense</a>
                                </li>
                            </ul>
                            <span>Viel Spass beim Einkauf</span>
                        </div>
                    </div>
                </div>

            </div><!-- .content -->

</div>

<?php
echo $this->Html->scriptStart();
?>
var base_url = '<?php echo $this->Html->url('/'); ?>';
var cat = 'home'

Page = require("controllers/homepage_view");
exports.HomePage = new Page({
    el: $("#"+cat),
    categoryName: cat
});
<?php
echo $this->Html->scriptEnd();
echo $this->element(STATCONFIG . 'tracking_code');
