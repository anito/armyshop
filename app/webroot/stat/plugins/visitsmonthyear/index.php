<?php
//------------------------------------------------------------------------------
if ( !isset ( $_SERVER [ "PHP_SELF" ] ) || basename ( $_SERVER [ "PHP_SELF" ] ) == basename (__FILE__) ) { $error_path = "../../"; include ( "../../func/func_error.php" ); exit; };
//------------------------------------------------------------------------------
if ( $plugin_security == 1 ) // Security Check
 {
  @session_start(); if ( $_SESSION [ "hidden_stat" ] != md5_file ( "config/config.php" ) ) { include ( "func/func_error.php" ); exit; }
 }
################################################################################
### plugin code ###
include ( "plugins/".$plugin_directory."/google_charts.php" );
include ( "log/cache_visitors.php" );
//------------------------------------------------------------------------------
// Plugin Language Specific
    if ( $language_plugin_select == "de" ) { }
elseif ( $language_plugin_select == "en" ) { }
elseif ( $language_plugin_select == "nl" ) { }
elseif ( $language_plugin_select == "it" ) { }
elseif ( $language_plugin_select == "sp" ) { }
elseif ( $language_plugin_select == "es" ) { }
elseif ( $language_plugin_select == "fa" ) { }
elseif ( $language_plugin_select == "dk" ) { }
elseif ( $language_plugin_select == "fr" ) { }
elseif ( $language_plugin_select == "tu" ) { }
else { }
//------------------------------------------------------------------------------
echo '
<table id="content" style="width:100%; border-collapse:collapse; border-spacing:0">
<tr>
  <td style="padding:10px 0px 10px 0px; text-align:center; vertical-align:top">'."\n";

  echo "<b>".$lang_month[1]."</b><br>";
  google_charts ( $visitor_month );

  echo "<br /><br /><b>".$lang_year[1]."</b><br>";
  google_charts ( $visitor_year );

  echo '
  </td>
</tr>
</table>
';
################################################################################
?>