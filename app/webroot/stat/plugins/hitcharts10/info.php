<?php
 //-------------------------------------------------
 // General Information
 $plugin_version   = "0.2";
 $plugin_release   = "24.07.2014";
 $plugin_author    = "Reimar Hoven";
 $plugin_website   = "http://www.php-web-statistik.de";
 $plugin_security  = 0;
 $plugin_directory = "hitcharts10";
 $plugin_database  = 0;

 // Plugin Name Language Specific
     if ( $language_plugin_select == "de" ) { $plugin_name = "Zugriffe der letzten 10 Tage"; }
 elseif ( $language_plugin_select == "en" ) { $plugin_name = "Visitor Hits of last 10 days"; }
 else { $plugin_name = "Visitor Hits of the last 10 days"; }
 //-------------------------------------------------
?>