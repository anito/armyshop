<?php
//-------------------------------------------------
// General Information
$plugin_version   = "1.1";
$plugin_release   = "16.06.2014";
$plugin_author    = "PHP Web Stat";
$plugin_website   = "http://www.php-web-statistik.de";
$plugin_security  = 1;
$plugin_directory = "onclick";
$plugin_database  = 1;

// Plugin Name Language Specific
if ( $language_plugin_select == "de" )
 {
  $plugin_name = "Klick-Z&auml;hler";
  $lang_user_txt[1] = "Um die Daten einsehen zu k&ouml;nnen, ist es erforderlich, das Admin/Client Passwort einzugeben.";
  $lang_user_txt[2] = "Passwort";
  $last_click_id = "Zuletzt geklickte ID war";
  $last_click_id_at = "am";
  $title_id = "Klick ID";
  $title_counts = "Klicks";
  $title_delete = "L&ouml;schen";
  $title_detail = "Details";
 }
else
 {
  $plugin_name = "Click Counter";
  $lang_user_txt[1] = "Click data will be shown after logged in as Client/Administrator.";
  $lang_user_txt[2] = "Password";
  $last_click_id = "Last clicked ID was";
  $last_click_id_at = "at";
  $title_id = "Click ID";
  $title_counts = "Counts";
  $title_delete = "Delete";
  $title_detail = "Details";
 }
//-------------------------------------------------
?>