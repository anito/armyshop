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
        echo $this->Html->meta(array('name' => 'robots', 'content' => 'noindex, nofollow'));
        echo $this->Html->meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1'));
        echo $this->Html->meta('http-equiv', "x-ua-compatible");
        echo $this->Html->meta('icon');
        echo $this->Html->meta('keywords', $keywords);
        echo $this->Html->meta('description', 'Der Versandhandel Ihres Vertrauens, HA-Lehmann, bietet Ihnen Artikel aus verschiedenen Branchen, wie Selbstschutz, Selbstverteidigung, Outdoor, Fitness sowie Alltagsrtikel und Restposten verschiedenster Art zu besonders günstigen Preisen an.');
        echo $this->Html->meta('description', $meta);

//    echo $this->Html->css('jquery-ui-1.8.16.custom');
        echo $this->Html->css('bootstrap/bootstrap');
        echo $this->Html->css('bootstrap_glyphicons');
        echo $this->Html->css("websymbols");
        echo $this->Html->css("font");
        echo $this->Html->css("flaticon");
        echo $this->Html->css("muli");
        echo $this->Html->css("icons");
        echo $this->Html->css("linearicons");
        echo $this->Html->css("lehmann");
        echo $this->Html->css("common");
        echo $this->Html->css("demo", array('media' => 'only screen and (min-width : 320px)'));
        echo $this->Html->css("style7", array('media' => 'only screen and (min-width : 320px)'));
        echo $this->Html->css("custom", array('media' => 'only screen and (min-width : 320px) and (max-width : 767px) '));
        echo $this->Html->css("component", array('media' => 'only screen and (min-width : 768px)'));
        echo $this->Html->css("component_mobile", array('media' => 'only screen and (min-width : 320px) and (max-width : 767px) '));
//    echo $this->Html->css("mobile_device", array('media' => 'only screen and (min-width : 320px) and (max-width : 767px) '));
        echo $this->Html->css("touch", array('media' => 'only screen and (min-width : 320px) and (max-width : 767px) '));
        echo $this->Html->css("style", array('media' => 'only screen and (min-width : 320px) and (max-width : 767px) '));
        echo $this->Html->css("swiper/myswipe"); //, array('media' => 'only screen and (min-width : 320px) and (max-width : 767px) '));
        echo $this->Html->css("swiper/swiper"); //, array('media' => 'only screen and (min-width : 320px) and (max-width : 767px) '));
        echo $this->Html->css("spine");

//    jQuery first, then Tether, then Bootstrap JS.
        echo $this->Html->script('app/public/application');

        echo $this->Html->scriptStart();
        ?>
        var base_url = '<?php echo $this->Html->url('/'); ?>';
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

        <?php echo $this->Html->scriptEnd(); ?>

        <?php
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');

        echo $this->element('google-analytics'); #set the ga-ID in bootstrap.php
        ?>
    </head>
    <body class="hal hal-home show">
        <div class="logos hidemobile">
            <div class="lehmann logo-1"><span class="lehmann-01"></span><span class="lehmann-02"></span></div>
        </div>
        <header id="header" class="header hidemobile">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <i class="badge1"></i>
                <i class="favorite-badge opt-favorite" title="Produkt des Tages"></i>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="nav navbar-nav items">
                        <li id="" class="nav-item home">
                            <a class="nav-link lnr-home" href="/pages/home/">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li id="" class="nav-item outdoor">
                            <a class="nav-link lnr-sun" href="/pages/outdoor/">Outdoor</a>
                        </li>
                        <li id="" class="nav-item fitness">
                            <a class="nav-link lnr-bicycle" href="/pages/fitness/">Fitness</a>
                        </li>
                        <li id="" class="nav-item tools">
                            <a class="nav-link lnr-diamond" href="/pages/tools/">Messer & Tools</a>
                        </li>
                        <li id="" class="nav-item specials">
                            <a class="nav-link lnr-star" href="/pages/specials/">Specials</a>
                        </li>
                        <li id="" class="nav-item defense">
                            <a class="nav-link lnr-hand" href="/pages/defense/">Defense</a>
                        </li>
                    </ul>
                </div>
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
                    <li id="" class=""><a href="/pages/defense">Defense</a></li>
                </ul>
            </div>
            <div class="menu-seitenmenue-unten-container">
                <ul id="menu-seitenmenue-unten" class="menu">
                    <li id="" class="menu-item-has-children misc"><a href="#">Rechtliches</a>
                        <ul class="sub-menu">
                            <li id=""><a href="#" class="opt-imp menu-push-to-close">Impressum</a></li>
                            <li id=""><a href="#" class="opt-del menu-push-to-close">Versand</a></li>
                            <li id=""><a href="#" class="opt-pay menu-push-to-close">Zahlungsmöglichkeiten</a></li>
                            <li id=""><a href="#" class="opt-privacy menu-push-to-close">Datenschutz</a></li>
                            <li id=""><a href="#"  class="opt-revocation menu-push-to-close">Widerrufsbelehrung</a></li>
                            <li id=""><a href="#"  class="opt-agb menu-push-to-close">AGB</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="sidebar bg-dark glinch hidemobile">
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

        <footer class="footer bg-dark hidemobile">
            <span class="nav-group">
                <span class="fc-logo"><a href="https://www.haendlerbund.de/faircommerce" target="_blank"><img src="/img/fc_logo.gif"></img></a></span>
                <span class="opt-reset" title="FSK 18 Hinweis zurücksetzen">© HA Lehman</span>
                <span><a href="#" class="opt-imp" data-toggle="modal" data-target="#modal-view">Impressum</a></span>
                <span><a href="#" class="opt-del" data-toggle="modal" data-target="#modal-view">Versand</a></span>
                <span><a href="#" class="opt-pay" data-toggle="modal" data-target="#modal-view">Zahlungsmöglichkeiten</a></span>
                <span><a href="#" class="opt-privacy" data-toggle="modal" data-target="#modal-view">Datenschutz</a></span>
                <span><a href="#" class="opt-revocation" data-toggle="modal" data-target="#modal-view">Widerrufsbelehrung</a></span>
                <span><a href="#" class="opt-agb" data-toggle="modal" data-target="#modal-view">AGB</a></span>
                <span id="refresh" class="left-inline"></span>
                <span><a href="#" class="opt-stats stats">Statistik</a></span>
            </span>
        </footer>
        <iframe id="stats" frameborder="0" scrolling="no" class="fade hidemobile"></iframe>
        <!-- modal-dialogue -->
        <div class="modal fade" id="modal-simple" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 100001;">
            <div class="modal-dialog" role="document">needed by Modal</div>
        </div>
        <!-- /.modal -->
    </body>
</html>

<script id="modalSimpleTemplate" type="text/html">
    <div class="modal-dialog default {{if small}}modal-sm{{else}}modal-lg{{/if}} {{if css}}{{html css}}{{/if}}" role="document">
        <div class="modal-content">
            {{if header}}
            <div class="modal-header">
                <div><h3 class="h3" style="padding-left: 26px;">${header}</h3></div>
                <button type="button" class="" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            {{/if}}
            {{if body}}
            <div class="modal-body">
                {{html body}}
            </div>
            {{/if}}
            {{if info}}
            <div class="modal-header label-info">
                <div class="label label-info">${info}</div>
            </div>
            {{/if}}
            {{if (typeof footer != 'undefined' && footer.footerButtonText)}}
            <div class="modal-footer" style="position: relative">
                <button class="opt-agreed" style="" role="button" data-dismiss="modal" data-toggle="button">
                {{if footer.footerButtonText}}${footer.footerButtonText}{{else}}Ok{{/if}}</button>
            </div>
            {{/if}}
        </div>
    </div>
</script>

<script id="norbuPricingDetailsTemplate" type="text/html">
    <div class="">
    {{tmpl() "#norbuPricingDetailsTemplate_" }}
    </div>
</script>

<script id="norbuPricingDetailsTemplate_" type="text/html">
    <div class="pricing--details pricing--norbu_">
    <div id="${id}" data-id="${id}" class="pricing__item">
    {{if favorite}}
    <i class="badge2-modal"></i>
    {{/if}}
    <p class="h5 pricing__sentence">{{if subtitle}}${$().name(subtitle, 80)}{{else}}<hr>{{/if}}</p>
    <div class="pricing__price"><div class="price"><span class="pricing__currency">€</span>${price}</div>
    {{if link}}<a href="${link}" target="_blank" class="slides" aria-disabled="false">{{/if}}
    <div class="swiper-container-details swiper-container-horizontal">
    <div class="swiper-wrapper">
    {{tmpl(p=photos()) "#norbuImageListTemplate" }}
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets">
    <span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span>
    </div>
    <!-- Add Arrows -->
    <div class="swiper-button-next swiper-button-grey hidemobile"></div>
    <div class="swiper-button-prev swiper-button-grey hidemobile"></div>
    </div>
    {{if link}}</a>{{/if}}
    </div>
    <ul class="pricing__feature-list">{{tmpl(descriptions()) "#norbuFeatureListTemplate" }}</ul>
    {{if link}}
    <a href="${link}}" target="_blank" class="btn btn-light pricing__action ebay" role="button" aria-disabled=""><i class="ebay"></i>Zum Shop</a>
    {{/if}}
    </div>
    </div>
</script>

<script id="norbuPricingTemplate" type="text/html">
    <div id="${id}" data-id="${id}" class="pricing__item">
    {{if favorite}}
    <i class="badge3"></i>
    {{/if}}
    <h3 class="pricing__title">${$().name(title, 60)}</h3>
    <p class="pricing__sentence">${$().name(subtitle, 80)}</p>
    <div class="pricing__price"><div class="price"><span class="pricing__currency">€</span>${price}</div>
    <div class="swiper-container-pricing swiper-container-horizontal">
    <div class="swiper-wrapper">
    {{tmpl(p=photos()) "#norbuImageListTemplate" }}
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets">
    <span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span>
    </div>
    <!-- Add Arrows -->
    <div class="swiper-button-next swiper-button-grey hidemobile"></div>
    <div class="swiper-button-prev swiper-button-grey hidemobile"></div>
    </div>
    </div>
    <div class="pricing__feature-list">
    <ul class="">{{tmpl(descriptions()) "#norbuFeatureListTemplate" }}</ul>
    </div>
    <a href="{{if link}}${link}{{else}}#{{/if}}" target="_blank" class="pricing__action btn-dark" role="button" aria-disabled="{{if link}}${link}{{else}}false{{/if}}">Zum Shop</a>
    </div>
</script>

<script id="norbuImageListTemplate" type="text/html">
    <div class="swiper-slide">
    <div id="${id}" class="pricing__image"><img class="image load" src="/img/ajax-loader-66.gif"/></div>
    </div>
</script>

<script id="norbuFeatureListTemplate" type="text/html">
    <li class="pricing__feature">{{html description}}</li>
</script>

<script id="refreshTemplate" type="text/html">
    <a href="${location.hash}" class="opt-Refresh lnr lnr-${icon}"></a>
</script>

<script id="trustamiTemplate" type="text/html">
    <a href="https://app.trustami.com/trustami-card/57e573efcc96c5511c8b480e" target="_blank" title="Trustami Bewertungen und Erfahrungen von Handelsagentur Lehmann">
    <div class="trustami-inner">
    <i class="trustami-image"></i>
    <span class="trustami-count">${tmi}</span>
    </div>
    </a>
</script>

<script id="hbTemplate" type="text/html">
    <a href="https://www.haendlerbund.de/mitglied/show.php?uuid=13b695f4-b7a3-11e6-8974-9c5c8e4fb375-3496146168" target="_blank">
    <img src="/img/hbLogo.jpg" title="H&auml;ndlerbund Mitglied" alt="Mitglied im H&auml;ndlerbund" hspace="5" vspace="5" border="0" />
    </a>
</script>
