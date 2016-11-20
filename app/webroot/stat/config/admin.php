<?php @session_start();
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.9.x                                                    #
# File-Release-Date:  15/10/25                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2015 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
error_reporting(0);
//------------------------------------------------------------------------------
##### !!! never change this value !!! #####
$stat_version = file("../index.php"); // include stat version
eval($stat_version[32]);
eval($stat_version[33]);
$last_edit = "2015";
//------------------------------------------------------------------------------
##### !!! never change this value !!! #####
$admin_version = "1.7";
//------------------------------------------------------------------------------
if ( $_GET [ "logout" ] )
 {
  //-----------------------------------
  session_destroy ();
  @session_start();
  //-----------------------------------
 }
//------------------------------------------------------------------------------
/* Filter $_GET and $_POST Vars */
function array_map_R ( $func , $arr )
 {
  if ( is_array ( $arr ) )
   {
    $newArr = array();
    foreach ( $arr as $key => $value )
     {
      $newArr [ $key ] = ( is_array ( $value ) ? array_map_R ( $func , $value ) : $func ( $value ) );
     }
    return $newArr;
   }
  else
   {
    return $func ( $arr );
   }
 }

$_POST = array_map_R ( 'strip_tags' , $_POST );
$_GET  = array_map_R ( 'strip_tags' , $_GET  );

if ( !get_magic_quotes_gpc() )
 {
  $_POST = array_map_R ( 'addslashes' , $_POST );
  $_GET  = array_map_R ( 'addslashes' , $_GET  );
  #$_POST = array_map_R ( 'mysql_real_escape_string' , $_POST );
  #$_GET  = array_map_R ( 'mysql_real_escape_string' , $_GET  );
 }
//------------------------------------------------------------------------------
$strLanguageFile = "";
if ( isset ( $_GET [ "lang" ] ) || isset ( $_POST [ "lang" ] ) )
 {
  switch ( ( isset ( $_POST [ "lang" ] ) ? $_POST [ "lang" ] : $_GET [ "lang" ] ) )
   {
    case "de":    $strLanguageFile = "../language/german_admin.php";     $lang = "de";    break;
    case "en":    $strLanguageFile = "../language/english_admin.php";    $lang = "en";    break;
    case "nl":    $strLanguageFile = "../language/dutch_admin.php";      $lang = "nl";    break;
    case "it":    $strLanguageFile = "../language/italian_admin.php";    $lang = "it";    break;
    case "es":    $strLanguageFile = "../language/spanish_admin.php";    $lang = "es";    break;
    case "es-ct": $strLanguageFile = "../language/catalan_admin.php";    $lang = "es-ct"; break;
    case "fa":    $strLanguageFile = "../language/farsi_admin.php";      $lang = "fa";    break;
    case "dk":    $strLanguageFile = "../language/danish_admin.php";     $lang = "dk";    break;
    case "fr":    $strLanguageFile = "../language/french_admin.php";     $lang = "fr";    break;
    case "tr":    $strLanguageFile = "../language/turkish_admin.php";    $lang = "tr";    break;
    case "hu":    $strLanguageFile = "../language/hungarian_admin.php";  $lang = "hu";    break;
    case "pt":    $strLanguageFile = "../language/portuguese_admin.php"; $lang = "pt";    break;
    case "he":    $strLanguageFile = "../language/hebrew_admin.php";     $lang = "he";    break;
    case "ru":    $strLanguageFile = "../language/russian_admin.php";    $lang = "ru";    break;
    case "rs":    $strLanguageFile = "../language/serbian_admin.php";    $lang = "rs";    break;
    case "fi":    $strLanguageFile = "../language/finnish_admin.php";    $lang = "fi";    break;
    default: $strLanguageFile = "../language/german_admin.php"; $lang = "de"; // include language vars from config file
   }
 }
//-------------------------------
if ( file_exists ( $strLanguageFile ) )
 {
  include ( $strLanguageFile );
 }
else
 {
  include ( "../language/german_admin.php" ); // include language vars
  $lang = "de";
 }
//------------------------------------------------------------------------------
if ( ( $_POST [ "hidden_admin" ] == $_SESSION [ "hidden_admin" ] ) && ( trim ( $_POST [ "hidden_admin" ] ) != "" ) )
 {
  //------------------------------
  if ( $_POST [ "frames" ] == "x" ) { $frames = 1; } else { $frames = 0; }
  if ( $_POST [ "loginpassword_ask" ] == "x" ) { $loginpassword_ask = 1; } else { $loginpassword_ask = 0; }
  if ( $_POST [ "cookiepassword_ask" ] == "x" ) { $cookiepassword_ask = 1; } else { $cookiepassword_ask = 0; }
  if ( $_POST [ "auto_update_check" ] == "x" ) { $auto_update_check = 1; } else { $auto_update_check = 0; }
  if ( $_POST [ "error_reporting" ] == "x" ) { $error_reporting = 1; } else { $error_reporting = 0; }
  if ( $_POST [ "google_images" ] == "x" ) { $google_images = 1; } else { $google_images = 0; }
  if ( $_POST [ "google_adwords" ] == "x" ) { $google_adwords = 1; } else { $google_adwords = 0; }
  if ( $_POST [ "show_detailed_os" ] == "x" ) { $show_detailed_os = 1; } else { $show_detailed_os = 0; }
  if ( $_POST [ "show_detailed_referer" ] == "x" ) { $show_detailed_referer = 1; } else { $show_detailed_referer = 0; }
  if ( $_POST [ "show_country_flags" ] == "x" ) { $show_country_flags = 1; } else { $show_country_flags = 0; }
  if ( $_POST [ "show_browser_icons" ] == "x" ) { $show_browser_icons = 1; } else { $show_browser_icons = 0; }
  if ( $_POST [ "show_os_icons" ] == "x" ) { $show_os_icons = 1; } else { $show_os_icons = 0; }
  if ( $_POST [ "show_last_hits" ] == "x" ) { $show_last_hits = 1; } else { $show_last_hits = 0; }
  if ( $_POST [ "show_ip_client" ] == "x" ) { $show_ip_client = 1; } else { $show_ip_client = 0; }

  if ( $_POST [ "set_htaccess" ] == "x" ) { $set_htaccess = 1; if ( file_exists ( "../log/htaccess" ) ) { rename ("../log/htaccess" , "../log/.htaccess"); } } else { $set_htaccess = 0; if ( file_exists ( "../log/.htaccess" ) ) { rename ("../log/.htaccess" , "../log/htaccess"); } }
  if ( $_POST [ "autologout" ] == "x" ) { $autologout = 1; } else { $autologout = 0; }

  if ( $_POST [ "display_show_hour" ] == "x" ) { $display_show_hour = 1; } else { $display_show_hour = 0; }
  if ( $_POST [ "display_show_day" ] == "x" ) { $display_show_day = 1; } else { $display_show_day = 0; }
  if ( $_POST [ "display_show_weekday" ] == "x" ) { $display_show_weekday = 1; } else { $display_show_weekday = 0; }
  if ( $_POST [ "display_show_month" ] == "x" ) { $display_show_month = 1; } else { $display_show_month = 0; }
  if ( $_POST [ "display_show_year" ] == "x" ) { $display_show_year = 1; } else { $display_show_year = 0; }
  if ( $_POST [ "display_show_browser" ] == "x" ) { $display_show_browser = 1; } else { $display_show_browser = 0; }
  if ( $_POST [ "display_show_os" ] == "x" ) { $display_show_os = 1; } else { $display_show_os = 0; }
  if ( $_POST [ "display_show_resolution" ] == "x" ) { $display_show_resolution = 1; } else { $display_show_resolution = 0; }
  if ( $_POST [ "display_show_colordepth" ] == "x" ) { $display_show_colordepth = 1; } else { $display_show_colordepth = 0; }
  if ( $_POST [ "display_show_javascript_status" ] == "x" ) { $display_show_javascript_status = 1; } else { $display_show_javascript_status = 0; }
  if ( $_POST [ "display_show_site" ] == "x" ) { $display_show_site = 1; } else { $display_show_site = 0; }
  if ( $_POST [ "display_show_referer" ] == "x" ) { $display_show_referer = 1; } else { $display_show_referer = 0; }
  if ( $_POST [ "display_show_entrysite" ] == "x" ) { $display_show_entrysite = 1; } else { $display_show_entrysite = 0; }
  if ( $_POST [ "display_show_searchengines" ] == "x" ) { $display_show_searchengines = 1; } else { $display_show_searchengines = 0; }
  if ( $_POST [ "display_show_searchwords" ] == "x" ) { $display_show_searchwords = 1; } else { $display_show_searchwords = 0; }
  if ( $_POST [ "display_show_cc" ] == "x" ) { $display_show_cc = 1; } else { $display_show_cc = 0; }

  if ( $_POST [ "counter_display_show_visitors_online" ] == "x" ) { $counter_display_show_visitors_online = 1; } else { $counter_display_show_visitors_online = 0; }
  if ( $_POST [ "counter_display_show_today" ] == "x" ) { $counter_display_show_today = 1; } else { $counter_display_show_today = 0; }
  if ( $_POST [ "counter_display_show_yesterday" ] == "x" ) { $counter_display_show_yesterday = 1; } else { $counter_display_show_yesterday = 0; }
  if ( $_POST [ "counter_display_show_this_month" ] == "x" ) { $counter_display_show_this_month = 1; } else { $counter_display_show_this_month = 0; }
  if ( $_POST [ "counter_display_show_last_month" ] == "x" ) { $counter_display_show_last_month = 1; } else { $counter_display_show_last_month = 0; }
  if ( $_POST [ "counter_display_show_max" ] == "x" ) { $counter_display_show_max = 1; } else { $counter_display_show_max = 0; }
  if ( $_POST [ "counter_display_show_average" ] == "x" ) { $counter_display_show_average = 1; } else { $counter_display_show_average = 0; }
  if ( $_POST [ "counter_display_show_total" ] == "x" ) { $counter_display_show_total = 1; } else { $counter_display_show_total = 0; }
  if ( $_POST [ "counter_display_show_footer" ] == "x" ) { $counter_display_show_footer = 1; } else { $counter_display_show_footer = 0; }
  if ( $_POST [ "counter_display_show_footer_ticker" ] == "x" ) { $counter_display_show_footer_ticker = 1; } else { $counter_display_show_footer_ticker = 0; }
  if ( $_POST [ "counter_display_show_footer_info1" ] == "x" ) { $counter_display_show_footer_info1 = 1; } else { $counter_display_show_footer_info1 = 0; }
  if ( $_POST [ "counter_display_show_footer_info2" ] == "x" ) { $counter_display_show_footer_info2 = 1; } else { $counter_display_show_footer_info2 = 0; }
  if ( $_POST [ "counter_display_show_footer_info3" ] == "x" ) { $counter_display_show_footer_info3 = 1; } else { $counter_display_show_footer_info3 = 0; }
  if ( $_POST [ "counter_display_show_footer_info4" ] == "x" ) { $counter_display_show_footer_info4 = 1; } else { $counter_display_show_footer_info4 = 0; }

  if ( trim ( $_POST [ "script_activity" ] ) == "" ) { $script_activity = 0; } else { $script_activity = $_POST [ "script_activity" ]; }
  if ( trim ( $_POST [ "db_active" ] ) == "" ) { $db_active = 0; } else { $db_active = $_POST [ "db_active" ]; }
  if ( trim ( $_POST [ "ip_recount_time" ] ) == "" ) { $ip_recount_time = 1440; } else { $ip_recount_time = $_POST [ "ip_recount_time" ]; }
  if ( trim ( $_POST [ "stat_add_visitors" ] ) == "" ) { $stat_add_visitors = 0; } else { $stat_add_visitors = $_POST [ "stat_add_visitors" ]; }
  if ( trim ( $_POST [ "starting_date" ] ) == "" ) { $starting_date = "\"TT.MM.YYYY\""; } else { $starting_date = "\"".$_POST [ "starting_date" ]."\""; }
  if ( trim ( $_POST [ "online_recount_time" ] ) == "" ) { $online_recount_time = 0; } else { $online_recount_time = $_POST [ "online_recount_time" ]; }
  if ( trim ( $_POST [ "last_hits_width" ] ) == "" ) { $last_hits_width = 970; } else { $last_hits_width = $_POST [ "last_hits_width" ]; }
  if ( trim ( $_POST [ "last_hits_height" ] ) == "" ) { $last_hits_height = 595; } else { $last_hits_height = $_POST [ "last_hits_height" ]; }
  if ( trim ( $_POST [ "last_hits_site_column" ] ) == "" ) { $last_hits_site_column = 230; } else { $last_hits_site_column = $_POST [ "last_hits_site_column" ]; }
  if ( trim ( $_POST [ "last_hits_site_length" ] ) == "" ) { $last_hits_site_length = 30; } else { $last_hits_site_length = $_POST [ "last_hits_site_length" ]; }
  if ( trim ( $_POST [ "last_hits_referer_length" ] ) == "" ) { $last_hits_referer_length = 50; } else { $last_hits_referer_length = $_POST [ "last_hits_referer_length" ]; }
  if ( trim ( $_POST [ "counter_add_visitors" ] ) == "" ) { $counter_add_visitors = 0; } else { $counter_add_visitors = $_POST [ "counter_add_visitors" ]; }

  if ( trim ( $_POST [ "display_width_overview" ] ) == "" ) { $display_width_overview = 0; } else { $display_width_overview = $_POST [ "display_width_overview" ]; }
  if ( trim ( $_POST [ "display_width_hour" ] ) == "" ) { $display_width_hour = 0; } else { $display_width_hour = $_POST [ "display_width_hour" ]; }
  if ( trim ( $_POST [ "display_width_day" ] ) == "" ) { $display_width_day = 0; } else { $display_width_day = $_POST [ "display_width_day" ]; }
  if ( trim ( $_POST [ "display_width_weekday" ] ) == "" ) { $display_width_weekday = 0; } else { $display_width_weekday = $_POST [ "display_width_weekday" ]; }
  if ( trim ( $_POST [ "display_width_month" ] ) == "" ) { $display_width_month = 0; } else { $display_width_month = $_POST [ "display_width_month" ]; }
  if ( trim ( $_POST [ "display_width_year" ] ) == "" ) { $display_width_year = 0; } else { $display_width_year = $_POST [ "display_width_year" ]; }
  if ( trim ( $_POST [ "display_width_browser" ] ) == "" ) { $display_width_browser = 0; } else { $display_width_browser = $_POST [ "display_width_browser" ]; }
  if ( trim ( $_POST [ "display_width_os" ] ) == "" ) { $display_width_os = 0; } else { $display_width_os = $_POST [ "display_width_os" ]; }
  if ( trim ( $_POST [ "display_width_resolution" ] ) == "" ) { $display_width_resolution = 0; } else { $display_width_resolution = $_POST [ "display_width_resolution" ]; }
  if ( trim ( $_POST [ "display_width_colordepth" ] ) == "" ) { $display_width_colordepth = 0; } else { $display_width_colordepth = $_POST [ "display_width_colordepth" ]; }
  if ( trim ( $_POST [ "display_width_javascript_status" ] ) == "" ) { $display_width_javascript_status = 0; } else { $display_width_javascript_status = $_POST [ "display_width_javascript_status" ]; }
  if ( trim ( $_POST [ "display_width_site" ] ) == "" ) { $display_width_site = 0; } else { $display_width_site = $_POST [ "display_width_site" ]; }
  if ( trim ( $_POST [ "display_width_referer" ] ) == "" ) { $display_width_referer = 0; } else { $display_width_referer = $_POST [ "display_width_referer" ]; }
  if ( trim ( $_POST [ "display_width_entrysite" ] ) == "" ) { $display_width_entrysite = 0; } else { $display_width_entrysite = $_POST [ "display_width_entrysite" ]; }
  if ( trim ( $_POST [ "display_width_searchengines" ] ) == "" ) { $display_width_searchengines = 0; } else { $display_width_searchengines = $_POST [ "display_width_searchengines" ]; }
  if ( trim ( $_POST [ "display_width_searchwords" ] ) == "" ) { $display_width_searchwords = 0; } else { $display_width_searchwords = $_POST [ "display_width_searchwords" ]; }
  if ( trim ( $_POST [ "display_width_cc" ] ) == "" ) { $display_width_cc = 0; } else { $display_width_cc = $_POST [ "display_width_cc" ]; }

  if ( trim ( $_POST [ "display_count_year" ] ) == "" ) { $display_count_year = 0; } else { $display_count_year = $_POST [ "display_count_year" ]; }
  if ( trim ( $_POST [ "display_count_browser" ] ) == "" ) { $display_count_browser = 0; } else { $display_count_browser = $_POST [ "display_count_browser" ]; }
  if ( trim ( $_POST [ "display_count_os" ] ) == "" ) { $display_count_os = 0; } else { $display_count_os = $_POST [ "display_count_os" ]; }
  if ( trim ( $_POST [ "display_count_resolution" ] ) == "" ) { $display_count_resolution = 0; } else { $display_count_resolution = $_POST [ "display_count_resolution" ]; }
  if ( trim ( $_POST [ "display_count_colordepth" ] ) == "" ) { $display_count_colordepth = 0; } else { $display_count_colordepth = $_POST [ "display_count_colordepth" ]; }
  if ( trim ( $_POST [ "display_count_site" ] ) == "" ) { $display_count_site = 0; } else { $display_count_site = $_POST [ "display_count_site" ]; }
  if ( trim ( $_POST [ "display_count_referer" ] ) == "" ) { $display_count_referer = 0; } else { $display_count_referer = $_POST [ "display_count_referer" ]; }
  if ( trim ( $_POST [ "display_count_entrysite" ] ) == "" ) { $display_count_entrysite = 0; } else { $display_count_entrysite = $_POST [ "display_count_entrysite" ]; }
  if ( trim ( $_POST [ "display_count_searchengines" ] ) == "" ) { $display_count_searchengines = 0; } else { $display_count_searchengines = $_POST [ "display_count_searchengines" ]; }
  if ( trim ( $_POST [ "display_count_searchwords" ] ) == "" ) { $display_count_searchwords = 0; } else { $display_count_searchwords = $_POST [ "display_count_searchwords" ]; }
  if ( trim ( $_POST [ "display_count_cc" ] ) == "" ) { $display_count_cc = 0; } else { $display_count_cc = $_POST [ "display_count_cc" ]; }
  //------------------------------
  if ( trim ( $_POST [ "exception_ip_addresses" ] ) != "" )
   {
    if ( strpos ( $_POST [ "exception_ip_addresses" ] , "\n" ) == TRUE )
     {
      $temp_exception_ip_addresses = explode ( "\n" , $_POST [ "exception_ip_addresses" ] );
      foreach ( $temp_exception_ip_addresses as $value )
       {
        if ( trim ( $value ) != "" )
         {
          $value = str_replace ( "," , "" , $value );
          $temp_string = $temp_string.",\"".trim ( $value )."\"";
         }
       }
      $temp_string = substr ( $temp_string , 1 , strlen ( $temp_string ) - 1 );
      $exception_ip_addresses = $temp_string;
      unset ( $temp_string );
     }
    else
     {
      $temp_string = str_replace ( "," , "" , $_POST [ "exception_ip_addresses" ] );
      $exception_ip_addresses = "\"".$temp_string."\"";
      unset ( $temp_string );
     }
   }
  else
   {
    $exception_ip_addresses = "";
   }
  //------------------------------
  if ( trim ( $_POST [ "block_referer" ] ) != "" )
   {
    if ( strpos ( $_POST [ "block_referer" ] , "\n" ) == TRUE )
     {
      $temp_block_referer = explode ( "\n" , $_POST [ "block_referer" ] );
      foreach ( $temp_block_referer as $value )
       {
        if ( trim ( $value ) != "" )
         {
          $value = str_replace ( "http://" , "" , $value );
          $value = str_replace ( "www."    , "" , $value );
          $value = str_replace ( "," , "" , $value );
          $temp_string = $temp_string.",\"".trim ( $value )."\"";
         }
       }
      $temp_string = substr ( $temp_string , 1 , strlen ( $temp_string ) - 1 );
      $block_referer = $temp_string;
      unset ( $temp_string );
     }
    else
     {
      $temp_string = str_replace ( "," , "" , $_POST [ "block_referer" ] );
      $block_referer = "\"".$temp_string."\"";
      unset ( $temp_string );
     }
   }
  else
   {
    $block_referer = "";
   }
  //------------------------------
  if ( trim ( $_POST [ "block_bots" ] ) != "" )
   {
    if ( strpos ( $_POST [ "block_bots" ] , "\n" ) == TRUE )
     {
      $temp_block_bots = explode ( "\n" , $_POST [ "block_bots" ] );
      foreach ( $temp_block_bots as $value )
       {
        if ( trim ( $value ) != "" )
         {
          $value = str_replace ( "," , "" , $value );
          $temp_string = $temp_string.",\"".trim ( $value )."\"";
         }
       }
      $temp_string = substr ( $temp_string , 1 , strlen ( $temp_string ) - 1 );
      $block_bots = $temp_string;
      unset ( $temp_string );
     }
    else
     {
      $temp_string = str_replace ( "," , "" , $_POST [ "block_bots" ] );
      $block_bots = "\"".$temp_string."\"";
      unset ( $temp_string );
     }
   }
  else
   {
    $block_bots = "";
   }
  //------------------------------
  if ( trim ( $_POST [ "exception_domain" ] ) != "" )
   {
    if ( strpos ( $_POST [ "exception_domain" ] , "\n" ) == TRUE )
     {
      $temp_exception_domain = explode ( "\n" , $_POST [ "exception_domain" ] );
      foreach ( $temp_exception_domain as $value )
       {
        if ( trim ( $value ) != "" )
         {
          $value = str_replace ( "http://" , "" , $value );
          $value = str_replace ( "www."    , "" , $value );
          $value = str_replace ( ","       , "" , $value );
          $temp_string = $temp_string.",\"".trim ( $value )."\"";
         }
       }
      $temp_string = substr ( $temp_string , 1 , strlen ( $temp_string ) - 1 );
      $exception_domain = $temp_string;
      unset ( $temp_string );
     }
    else
     {
      $temp_string = str_replace ( "http://" , "" , $_POST [ "exception_domain" ] );
      $temp_string = str_replace ( "www."    , "" , $temp_string );
      $temp_string = str_replace ( ","       , "" , $temp_string );
      $exception_domain = "\"".$temp_string."\"";
      unset ( $temp_string );
     }
   }
  else
   {
    $exception_domain = "";
   }
  //------------------------------
  if ( trim ( $_POST [ "url_parameter" ] ) != "" )
   {
    if ( strpos ( $_POST [ "url_parameter" ] , "\n" ) == TRUE )
     {
      $temp_url_parameter = explode ( "\n" , $_POST [ "url_parameter" ] );
      foreach ( $temp_url_parameter as $value )
       {
        if ( trim ( $value ) != "" )
         {
          $value = str_replace ( "," , "" , $value );
          $temp_string = $temp_string.",\"".trim ( $value )."\"";
         }
       }
      $temp_string = substr ( $temp_string , 1 , strlen ( $temp_string ) - 1 );
      $url_parameter = $temp_string;
      unset ( $temp_string );
     }
    else
     {
      $temp_string = str_replace ( "," , "" , $_POST [ "url_parameter" ] );
      $url_parameter = "\"".$temp_string."\"";
      unset ( $temp_string );
     }
   }
  else
   {
    $url_parameter = "";
   }
  //------------------------------
  // password comparison function
  function passCrypt ( $password )
   {
    if ( strpos ( $password , 'Pass_' ) !== FALSE )
     {
      return $password;
     }
    else
     {
      return 'Pass_'.substr ( base64_encode ( sha1 ( $password ) ) , 0 , 25 );
     }
   }
  //------------------------------
  /* write config file */
  $config_file = fopen ( "config.php" , "w+" );
   flock  ( $config_file , 2 );
    fwrite ( $config_file , "<?php @header(\"content-type: text/html; charset=utf-8\");\n" );

    fwrite ( $config_file , "\n/* general configuration */\n" );
    fwrite ( $config_file , " \$script_activity             = ".$script_activity.";\n" );
    fwrite ( $config_file , " \$db_active                   = ".$db_active.";\n" );
    fwrite ( $config_file , " \$script_domain               = \"".$_POST [ "script_domain" ]."\";\n" );
    fwrite ( $config_file , " \$home_site_name              = \"".$_POST [ "home_site_name" ]."\";\n" );
    fwrite ( $config_file , " \$script_path                 = \"".$_POST [ "script_path" ]."\";\n" );
    fwrite ( $config_file , " \$exception_domain            = array ( ".$exception_domain." );\n" );
    fwrite ( $config_file , " \$stat_name                   = \"".$_POST [ "stat_name" ]."\";\n" );
    fwrite ( $config_file , " \$language                    = \"".$_POST [ "language" ]."\";\n" );
    fwrite ( $config_file , " \$language_patterns           = \"".$_POST [ "language_patterns" ]."\";\n" );
    fwrite ( $config_file , " \$url_parameter               = array ( ".$url_parameter." );\n" );

    fwrite ( $config_file , "\n/* advanced configuration */\n" );
    fwrite ( $config_file , "// general ---------------//\n" );
    fwrite ( $config_file , " \$exception_ip_addresses      = array ( ".$exception_ip_addresses." );\n" );
    fwrite ( $config_file , " \$block_referer               = array ( ".$block_referer." );\n" );
    fwrite ( $config_file , " \$block_bots                  = array ( ".$block_bots." );\n" );
    fwrite ( $config_file , " \$server_time                 = \"".$_POST [ "server_time" ]."\";\n" );
    fwrite ( $config_file , " \$frames                      = ".$frames.";\n" );
    fwrite ( $config_file , " \$ip_recount_time             = ".$ip_recount_time.";\n" );
    fwrite ( $config_file , " \$auto_update_check           = ".$auto_update_check.";\n" );
    fwrite ( $config_file , " \$starting_date               = ".$starting_date.";\n" );
    fwrite ( $config_file , " \$stat_add_visitors           = ".$stat_add_visitors.";\n" );
    fwrite ( $config_file , " \$get_ip_address              = ".$_POST [ "get_ip_address" ].";\n" );
    fwrite ( $config_file , " \$hash_ip_address             = ".$_POST [ "hash_ip_address" ].";\n" );
    fwrite ( $config_file , " \$error_reporting             = ".$error_reporting.";\n" );
    fwrite ( $config_file , " \$google_images               = ".$google_images.";\n" );
    fwrite ( $config_file , " \$google_adwords              = ".$google_adwords.";\n" );
    fwrite ( $config_file , " \$creator_number              = ".$_POST [ "creator_number" ].";\n" );
    fwrite ( $config_file , " \$creator_referer_cut         = ".$_POST [ "creator_referer_cut" ].";\n" );
    fwrite ( $config_file , " \$index_creator_number        = ".$_POST [ "index_creator_number" ].";\n" );
    fwrite ( $config_file , " \$cache_update                = ".$_POST [ "cache_update" ].";\n" );
    fwrite ( $config_file , "// security --------------//\n" );
    fwrite ( $config_file , " \$adminpassword               = \"".passCrypt ( $_POST [ "adminpassword" ] )."\";\n" );
    fwrite ( $config_file , " \$clientpassword              = \"".passCrypt ( $_POST [ "clientpassword" ] )."\";\n" );
    fwrite ( $config_file , " \$loginpassword_ask           = ".$loginpassword_ask.";\n" );
    fwrite ( $config_file , " \$cookiepassword_ask          = ".$cookiepassword_ask.";\n" );
    fwrite ( $config_file , " \$set_htaccess                = ".$set_htaccess.";\n" );
    fwrite ( $config_file , " \$autologout                  = ".$autologout.";\n" );
    fwrite ( $config_file , " \$autologout_time             = ".$_POST [ "autologout_time" ].";\n" );
    fwrite ( $config_file , "// display ---------------//\n" );
    fwrite ( $config_file , " \$theme                       = \"".$_POST [ "theme" ]."\";\n" );
    fwrite ( $config_file , " \$show_detailed_browser       = ".$_POST [ "show_detailed_browser" ].";\n" );
    fwrite ( $config_file , " \$show_detailed_os            = ".$show_detailed_os.";\n" );
    fwrite ( $config_file , " \$show_detailed_referer       = ".$show_detailed_referer.";\n" );
    fwrite ( $config_file , " \$show_country_flags          = ".$show_country_flags.";\n" );
    fwrite ( $config_file , " \$show_browser_icons          = ".$show_browser_icons.";\n" );
    fwrite ( $config_file , " \$show_os_icons               = ".$show_os_icons.";\n" );
    fwrite ( $config_file , " \$percentbar_max_value_1      = \"".$_POST [ "percentbar_max_value_1" ]."\";\n" );
    fwrite ( $config_file , " \$percentbar_max_value_2      = \"".$_POST [ "percentbar_max_value_2" ]."\";\n" );
    fwrite ( $config_file , " \$show_last_hits              = ".$show_last_hits.";\n" );
    fwrite ( $config_file , " \$show_ip_client              = ".$show_ip_client.";\n" );
    fwrite ( $config_file , " \$last_hits_width             = ".$last_hits_width.";\n" );
    fwrite ( $config_file , " \$last_hits_height            = ".$last_hits_height.";\n" );
    fwrite ( $config_file , " \$last_hits_site_column       = ".$last_hits_site_column.";\n" );
    fwrite ( $config_file , " \$last_hits_site_length       = ".$last_hits_site_length.";\n" );
    fwrite ( $config_file , " \$last_hits_referer_length    = ".$last_hits_referer_length.";\n" );
    fwrite ( $config_file , " \$last_hits_number            = ".$_POST [ "last_hits_number" ].";\n" );
    fwrite ( $config_file , " \$whois_link                  = \"".$_POST [ "whois_link" ]."\";\n" );

    fwrite ( $config_file , "\n/* show module */\n" );
    fwrite ( $config_file , " \$display_show_hour              = ".$display_show_hour.";\n" );
    fwrite ( $config_file , " \$display_show_day               = ".$display_show_day.";\n" );
    fwrite ( $config_file , " \$display_show_weekday           = ".$display_show_weekday.";\n" );
    fwrite ( $config_file , " \$display_show_month             = ".$display_show_month.";\n" );
    fwrite ( $config_file , " \$display_show_year              = ".$display_show_year.";\n" );
    fwrite ( $config_file , " \$display_show_browser           = ".$display_show_browser.";\n" );
    fwrite ( $config_file , " \$display_show_os                = ".$display_show_os.";\n" );
    fwrite ( $config_file , " \$display_show_resolution        = ".$display_show_resolution.";\n" );
    fwrite ( $config_file , " \$display_show_colordepth        = ".$display_show_colordepth.";\n" );
    fwrite ( $config_file , " \$display_show_javascript_status = ".$display_show_javascript_status.";\n" );
    fwrite ( $config_file , " \$display_show_site              = ".$display_show_site.";\n" );
    fwrite ( $config_file , " \$display_show_referer           = ".$display_show_referer.";\n" );
    fwrite ( $config_file , " \$display_show_entrysite         = ".$display_show_entrysite.";\n" );
    fwrite ( $config_file , " \$display_show_searchengines     = ".$display_show_searchengines.";\n" );
    fwrite ( $config_file , " \$display_show_searchwords       = ".$display_show_searchwords.";\n" );
    fwrite ( $config_file , " \$display_show_cc                = ".$display_show_cc.";\n" );

    fwrite ( $config_file , "\n/* module width in pixel */\n" );
    fwrite ( $config_file , " \$display_width_overview          = ".$display_width_overview.";\n" );
    fwrite ( $config_file , " \$display_width_hour              = ".$display_width_hour.";\n" );
    fwrite ( $config_file , " \$display_width_day               = ".$display_width_day.";\n" );
    fwrite ( $config_file , " \$display_width_weekday           = ".$display_width_weekday.";\n" );
    fwrite ( $config_file , " \$display_width_month             = ".$display_width_month.";\n" );
    fwrite ( $config_file , " \$display_width_year              = ".$display_width_year.";\n" );
    fwrite ( $config_file , " \$display_width_browser           = ".$display_width_browser.";\n" );
    fwrite ( $config_file , " \$display_width_os                = ".$display_width_os.";\n" );
    fwrite ( $config_file , " \$display_width_resolution        = ".$display_width_resolution.";\n" );
    fwrite ( $config_file , " \$display_width_colordepth        = ".$display_width_colordepth.";\n" );
    fwrite ( $config_file , " \$display_width_javascript_status = ".$display_width_javascript_status.";\n" );
    fwrite ( $config_file , " \$display_width_site              = ".$display_width_site.";\n" );
    fwrite ( $config_file , " \$display_width_referer           = ".$display_width_referer.";\n" );
    fwrite ( $config_file , " \$display_width_entrysite         = ".$display_width_entrysite.";\n" );
    fwrite ( $config_file , " \$display_width_searchengines     = ".$display_width_searchengines.";\n" );
    fwrite ( $config_file , " \$display_width_searchwords       = ".$display_width_searchwords.";\n" );
    fwrite ( $config_file , " \$display_width_cc                = ".$display_width_cc.";\n" );

    fwrite ( $config_file , "\n/* number of module entries */\n" );
    fwrite ( $config_file , " \$display_count_year              = ".$display_count_year.";\n" );
    fwrite ( $config_file , " \$display_count_browser           = ".$display_count_browser.";\n" );
    fwrite ( $config_file , " \$display_count_os                = ".$display_count_os.";\n" );
    fwrite ( $config_file , " \$display_count_resolution        = ".$display_count_resolution.";\n" );
    fwrite ( $config_file , " \$display_count_colordepth        = ".$display_count_colordepth.";\n" );
    fwrite ( $config_file , " \$display_count_site              = ".$display_count_site.";\n" );
    fwrite ( $config_file , " \$display_count_referer           = ".$display_count_referer.";\n" );
    fwrite ( $config_file , " \$display_count_entrysite         = ".$display_count_entrysite.";\n" );
    fwrite ( $config_file , " \$display_count_searchengines     = ".$display_count_searchengines.";\n" );
    fwrite ( $config_file , " \$display_count_searchwords       = ".$display_count_searchwords.";\n" );
    fwrite ( $config_file , " \$display_count_cc                = ".$display_count_cc.";\n" );

    fwrite ( $config_file , "\n/* counter settings */\n" );
    fwrite ( $config_file , "// display ---------//\n" );
    fwrite ( $config_file , " \$counter_display_show_visitors_online  = ".$counter_display_show_visitors_online.";\n" );
    fwrite ( $config_file , " \$counter_display_show_today            = ".$counter_display_show_today.";\n" );
    fwrite ( $config_file , " \$counter_display_show_yesterday        = ".$counter_display_show_yesterday.";\n" );
    fwrite ( $config_file , " \$counter_display_show_this_month       = ".$counter_display_show_this_month.";\n" );
    fwrite ( $config_file , " \$counter_display_show_last_month       = ".$counter_display_show_last_month.";\n" );
    fwrite ( $config_file , " \$counter_display_show_max              = ".$counter_display_show_max.";\n" );
    fwrite ( $config_file , " \$counter_display_show_average          = ".$counter_display_show_average.";\n" );
    fwrite ( $config_file , " \$counter_display_show_total            = ".$counter_display_show_total.";\n" );
    fwrite ( $config_file , " \$counter_display_show_footer           = ".$counter_display_show_footer.";\n" );
    fwrite ( $config_file , " \$counter_display_show_footer_ticker    = ".$counter_display_show_footer_ticker.";\n" );
    fwrite ( $config_file , " \$counter_display_show_footer_info1     = ".$counter_display_show_footer_info1.";\n" );
    fwrite ( $config_file , " \$counter_display_show_footer_info2     = ".$counter_display_show_footer_info2.";\n" );
    fwrite ( $config_file , " \$counter_display_show_footer_info3     = ".$counter_display_show_footer_info3.";\n" );
    fwrite ( $config_file , " \$counter_display_show_footer_info4     = ".$counter_display_show_footer_info4.";\n" );
    fwrite ( $config_file , "// settings --------//\n" );
    fwrite ( $config_file , " \$online_recount_time                   = ".$online_recount_time.";\n" );
    fwrite ( $config_file , " \$counter_add_visitors                  = ".$counter_add_visitors.";\n" );

    fwrite ( $config_file , "\n?>" );
   flock  ( $config_file , 3 );
  fclose ( $config_file );
  //------------------------------
  /* write config_db file */
  if ( $db_active == 1 )
   {
    $config_file_db = fopen ( "config_db.php" , "w+" );
     flock  ( $config_file_db , 2 );
      fwrite ( $config_file_db , "<?php\n" );

      fwrite ( $config_file_db , "\n/* database connection */\n" );
      fwrite ( $config_file_db , " \$db_host     = \"".$_POST [ "db_host" ]."\";\n" );
      fwrite ( $config_file_db , " \$db_name     = \"".$_POST [ "db_name" ]."\";\n" );
      fwrite ( $config_file_db , " \$db_user     = \"".$_POST [ "db_user" ]."\";\n" );
      fwrite ( $config_file_db , " \$db_password = \"".$_POST [ "db_password" ]."\";\n" );

      fwrite ( $config_file_db , "\n/* database settings */\n" );
      fwrite ( $config_file_db , " \$db_prefix   = \"".$_POST [ "db_prefix" ]."\";\n" );

      fwrite ( $config_file_db , "\n?>" );
     flock  ( $config_file_db , 3 );
    fclose ( $config_file_db );
  }
  //------------------------------
  /* write tracking_code file */
  $tracking_code_file = fopen ( "tracking_code.php" , "w+" );
   flock  ( $tracking_code_file , 2 );
    fwrite ( $tracking_code_file , "<?php\n" );
    fwrite ( $tracking_code_file , "//------------------------------------------------------------------------------\n" );
    fwrite ( $tracking_code_file , "if ( strpos ( strtolower ( \$_SERVER [ \"PHP_SELF\" ] ) , \"tracking_code.php\" ) > 0 )\n" );
    fwrite ( $tracking_code_file , " {\n" );
    fwrite ( $tracking_code_file , "  exit;\n" );
    fwrite ( $tracking_code_file , " }\n" );
    fwrite ( $tracking_code_file , "else\n" );
    fwrite ( $tracking_code_file , " {\n" );
    fwrite ( $tracking_code_file , "  echo '\n" );
    fwrite ( $tracking_code_file , "  <script type=\"text/javascript\" src=\"".$_POST [ "script_domain" ]."/".$_POST [ "script_path" ]."track.php?mode=js\"></script>\n" );
    fwrite ( $tracking_code_file , "  <noscript><img src=\"".$_POST [ "script_domain" ]."/".$_POST [ "script_path" ]."track.php?mode=img\" border=\"0\" alt=\"\" width=\"1\" height=\"1\"></noscript>\n" );
    fwrite ( $tracking_code_file , "  ';\n" );
    fwrite ( $tracking_code_file , " }\n" );
    fwrite ( $tracking_code_file , "//------------------------------------------------------------------------------\n" );
    fwrite ( $tracking_code_file , "?>" );
   flock  ( $tracking_code_file , 3 );
  fclose ( $tracking_code_file );
  //------------------------------
  unset ( $config_file );
  unset ( $_SESSION [ "hidden_admin" ] );
  //----------
  unset ( $script_activity        );
  unset ( $db_active              );
  unset ( $script_domain          );
  unset ( $home_site_name         );
  unset ( $script_path            );
  unset ( $exception_domain       );
  unset ( $stat_name              );
  unset ( $language               );
  unset ( $language_patterns      );
  unset ( $url_parameter          );
  //----------
  unset ( $exception_ip_addresses );
  unset ( $block_referer          );
  unset ( $block_bots             );
  unset ( $server_time            );
  unset ( $frames                 );
  unset ( $ip_recount_time        );
  unset ( $auto_update_check      );
  unset ( $starting_date          );
  unset ( $stat_add_visitors      );
  unset ( $get_ip_address         );
  unset ( $hash_ip_address        );
  unset ( $error_reporting        );
  unset ( $google_images          );
  unset ( $google_adwords         );
  unset ( $creator_number         );
  unset ( $creator_referer_cut    );
  unset ( $index_creator_number   );
  unset ( $cache_update           );
  //----------
  unset ( $adminpassword          );
  unset ( $clientpassword         );
  unset ( $loginpassword_ask      );
  unset ( $cookiepassword_ask     );
  unset ( $set_htaccess           );
  unset ( $autologout             );
  unset ( $autologout_time        );
  //----------
  unset ( $theme                    );
  unset ( $show_detailed_browser    );
  unset ( $show_detailed_os         );
  unset ( $show_detailed_referer    );
  unset ( $show_country_flags       );
  unset ( $show_browser_icons       );
  unset ( $show_os_icons            );
  unset ( $percentbar_max_value_1   );
  unset ( $percentbar_max_value_2   );
  unset ( $show_last_hits           );
  unset ( $show_ip_client           );
  unset ( $last_hits_width          );
  unset ( $last_hits_height         );
  unset ( $last_hits_site_column    );
  unset ( $last_hits_site_length    );
  unset ( $last_hits_referer_length );
  unset ( $last_hits_number         );
  unset ( $whois_link               );
  //----------
  unset ( $display_show_hour               );
  unset ( $display_show_day                );
  unset ( $display_show_weekday            );
  unset ( $display_show_month              );
  unset ( $display_show_year               );
  unset ( $display_show_browser            );
  unset ( $display_show_os                 );
  unset ( $display_show_resolution         );
  unset ( $display_show_colordepth         );
  unset ( $display_show_javascript_status  );
  unset ( $display_show_site               );
  unset ( $display_show_referer            );
  unset ( $display_show_entrysite          );
  unset ( $display_show_searchengines      );
  unset ( $display_show_searchwords        );
  unset ( $display_show_cc                 );
  //----------
  unset ( $display_width_overview          );
  unset ( $display_width_hour              );
  unset ( $display_width_day               );
  unset ( $display_width_weekday           );
  unset ( $display_width_month             );
  unset ( $display_width_year              );
  unset ( $display_width_browser           );
  unset ( $display_width_os                );
  unset ( $display_width_resolution        );
  unset ( $display_width_colordepth        );
  unset ( $display_width_javascript_status );
  unset ( $display_width_site              );
  unset ( $display_width_referer           );
  unset ( $display_width_entrysite         );
  unset ( $display_width_searchengines     );
  unset ( $display_width_searchwords       );
  unset ( $display_width_cc                );
  //----------
  unset ( $display_count_year              );
  unset ( $display_count_browser           );
  unset ( $display_count_os                );
  unset ( $display_count_resolution        );
  unset ( $display_count_colordepth        );
  unset ( $display_count_javascript_status );
  unset ( $display_count_site              );
  unset ( $display_count_referer           );
  unset ( $display_count_entrysite         );
  unset ( $display_count_searchengines     );
  unset ( $display_count_searchwords       );
  unset ( $display_count_cc                );
  //----------
  unset ( $counter_display_show_visitors_online );
  unset ( $counter_display_show_today           );
  unset ( $counter_display_show_yesterday       );
  unset ( $counter_display_show_this_month      );
  unset ( $counter_display_show_last_month      );
  unset ( $counter_display_show_max             );
  unset ( $counter_display_show_average         );
  unset ( $counter_display_show_total           );
  unset ( $counter_display_show_footer          );
  unset ( $counter_display_show_footer_ticker   );
  unset ( $counter_display_show_footer_info1    );
  unset ( $counter_display_show_footer_info2    );
  unset ( $counter_display_show_footer_info3    );
  unset ( $counter_display_show_footer_info4    );
  //----------
  unset ( $online_recount_time                  );
  unset ( $counter_add_visitors                 );
  //------------------------------
  if ( $db_active == 1 )
   {
    unset ( $config_file_db );  unset ( $db_host   );
    unset ( $db_name        );  unset ( $db_user   );
    unset ( $db_password    );  unset ( $db_prefix );
   }
 }
else
 {
  if ( $_GET [ "action" ] == "autologout" )
   {
    /* autologout */
    include ( "config.php" );
    include ( "../func/html_header.php" );   // include html header
    echo '
    <div id="autologout">
      <div id="autologout_info">
        '.$lang_admin_as_s[10].' <a href="admin.php?lang='.$lang.'">LOGIN</a>
      </div>
      <div style="height: 43px; vertical-align: top; text-align: center; padding-top: 18px; font-size: 10px;">
        Copyright © '.$last_edit.' PHP Web Stat &nbsp;&middot;&nbsp; Version '.$version_number.$revision_number.'
      </div>
    </div>
    ';
    include ( "../func/html_footer.php" );   // include html footer
    session_unset();
    session_destroy();
    exit;
   }
  else
   {
    /* login */
    include ( 'config.php'             );   // include adminpassword
    include ( '../func/func_crypt.php' );   // include password comparison function
    if ( ( !isset ( $_SESSION [ 'hidden_admin' ] ) ) && ( passCrypt ( $_POST [ 'password' ] ) != $adminpassword ) && ( md5 ( $_POST [ 'password' ] ) != md5 ( $adminpassword ) ) )
    #if ( ( md5 ( $_POST [ "password" ] ) != md5 ( $adminpassword ) ) && ( !$_SESSION [ "hidden_admin" ] ) )
     {
      include ( '../func/html_header.php' );   // include html header
      echo '
      <form name="login" action="admin.php" method="post">
      <table id="login" cellspacing="0" cellpadding="0">
      <tr><td class="li_td1">&nbsp;</td></tr>
      <tr><td class="li_td2">'.$lang_login[1].'</td></tr>
      <tr><td class="li_td3"></td></tr>
      <tr>
        <td class="li_td4">
        '.$lang_login[2].'
        <table border="0" cellspacing="0" cellpadding="0" align="center" style="color:#000000;">
        <tr><td style="height:50px; padding-right:20px;"><label for="password">'.$lang_login[3].'</label></td><td style="height:50px;"><input type="hidden" name="lang" value="'.$lang.'"><input class="pw" type="password" name="password" id="password" /></td></tr>
        <tr><td>&nbsp;</td><td><input style="cursor:pointer;" type="submit" name="login" value="'.$lang_login[4].'"> <input style="cursor:pointer;" type="button" onclick="window.history.back();" value="'.$lang_login[5].'" /></td></tr>
        </table>
        </td>
      </tr>
      <tr><td class="li_td5">Copyright &copy; '.$last_edit.' PHP Web Stat &nbsp;&middot;&nbsp; Version '.$version_number.$revision_number.'</td></tr>
      </table>
      </form>
      ';
      include ( '../func/html_footer.php' );   // include html footer
      exit;
     }
   }
 }
//------------------------------------------------------------------------------
include ( "config.php" );
$_SESSION [ "loggedin" ] = "admin";
if ( $db_active == 1 ) { include ( "config_db.php" ); }
//------------------------------------------------------------------------------
if ( !$url_parameter ) { $url_parameter = array(); }
//--------------------
function checker ( $var ) { if ( !isset ( $var ) ) { return "checked"; } if ( !empty ( $var ) ) { return "checked"; } }
//--------------------
function checker_percentbar_max_value_1_0 ( ) { if ( $GLOBALS [ "percentbar_max_value_1" ] == 0 ) { return "checked"; } }
function checker_percentbar_max_value_1_1 ( ) { if ( $GLOBALS [ "percentbar_max_value_1" ] == 1 ) { return "checked"; } }
function checker_percentbar_max_value_2_0 ( ) { if ( $GLOBALS [ "percentbar_max_value_2" ] == 0 ) { return "checked"; } }
function checker_percentbar_max_value_2_1 ( ) { if ( $GLOBALS [ "percentbar_max_value_2" ] == 1 ) { return "checked"; } }
//--------------------
function selecter_language            ( $var ) { if ( $var == $GLOBALS [ "language"              ] ) { return "selected"; } }
function selecter_language_patterns   ( $var ) { if ( $var == $GLOBALS [ "language_patterns"     ] ) { return "selected"; } }
//--------------------
function selecter_server_time         ( $var ) { if ( $var == $GLOBALS [ "server_time"           ] ) { return "selected"; } }
function selecter_get_ip_address      ( $var ) { if ( $var == $GLOBALS [ "get_ip_address"        ] ) { return "selected"; } }
function selecter_hash_ip_address     ( $var ) { if ( $var == $GLOBALS [ "hash_ip_address"       ] ) { return "selected"; } }
function selecter_creator             ( $var ) { if ( $var == $GLOBALS [ "creator_number"        ] ) { return "selected"; } }
function selecter_creator_referer_cut ( $var ) { if ( $var == $GLOBALS [ "creator_referer_cut"   ] ) { return "selected"; } }
function selecter_index_creator       ( $var ) { if ( $var == $GLOBALS [ "index_creator_number"  ] ) { return "selected"; } }
function selecter_cache_update        ( $var ) { if ( $var == $GLOBALS [ "cache_update"          ] ) { return "selected"; } }
function selecter_autologout_time     ( $var ) { if ( $var == $GLOBALS [ "autologout_time"       ] ) { return "selected"; } }
//--------------------
function selecter_theme               ( $var ) { if ( $var == $GLOBALS [ "theme"                 ] ) { return "selected"; } }
function selecter_detailed_browser    ( $var ) { if ( $var == $GLOBALS [ "show_detailed_browser" ] ) { return "selected"; } }
function selecter_lh_number           ( $var ) { if ( $var == $GLOBALS [ "last_hits_number"      ] ) { return "selected"; } }
function selecter_whois               ( $var ) { if ( $var == $GLOBALS [ "whois_link"            ] ) { return "selected"; } }
//--------------------
function selecter_activity            ( $var ) { if ( $var == $GLOBALS [ "script_activity"       ] ) { return "selected"; } }
//--------------------
function read_files ( $path )
 {
  $result = array();
  $handle = opendir ( $path );
  if ( $handle ) { while ( false !== ( $file = readdir ( $handle ) ) ) { if ( $file != "." && $file != ".." ) { if ( !is_dir ( $path."/".$file ) && ( substr ( $file , 0 , 1) != "." ) ) { $result[] = $file; } } } }
  closedir ( $handle );
  return $result;
 }
$language_files_read = read_files ( "../language/" );
asort ( $language_files_read );
$language_files_found = array ();
$country_files_found  = array ();
foreach ( $language_files_read as $value )
 {
  if ( strpos ( $value , "_country" ) > 1 ) { $country_files_found [] = $value; }
  else { if ( strpos ( $value , "_" ) > 1 ) { } else { $language_files_found [] = $value; } }
 }
unset ( $language_files_read );
//--------------------
function read_dir ( $path )
 {
  $result = array();
  $handle = opendir ( $path );
  if ( $handle ) { while ( false !== ( $file = readdir ( $handle ) ) ) { if ( $file != "." && $file != ".." ) { if ( is_dir ( $path."/".$file ) ) { $result[] = $file; } } } }
  closedir ( $handle );
  return $result;
 }
$theme_dir_read = read_dir ( "../themes/" );
asort ( $theme_dir_read );
//--------------------
$temp_exception_domain = "";
foreach ( $exception_domain as $value )
 {
  $temp_exception_domain = $temp_exception_domain."\n".$value;
 }
 $temp_exception_domain = substr ( $temp_exception_domain , 1 , strlen ( $temp_exception_domain ) - 1 );
 unset ( $exception_domain );
 $exception_domain = $temp_exception_domain;
 unset ( $temp_exception_domain );
//--------------------
$temp_url_parameter = "";
foreach ( $url_parameter as $value )
 {
  $temp_url_parameter = $temp_url_parameter."\n".$value;
 }
 $temp_url_parameter = substr ( $temp_url_parameter , 1 , strlen ( $temp_url_parameter ) - 1 );
 unset ( $url_parameter );
 $url_parameter = $temp_url_parameter;
 unset ( $temp_url_parameter );
//--------------------
$temp_exception_ip_addresses = "";
foreach ( $exception_ip_addresses as $value )
 {
  $temp_exception_ip_addresses = $temp_exception_ip_addresses."\n".$value;
 }
 $temp_exception_ip_addresses = substr ( $temp_exception_ip_addresses , 1 , strlen ( $temp_exception_ip_addresses ) - 1 );
 unset ( $exception_ip_addresses );
 $exception_ip_addresses = $temp_exception_ip_addresses;
 unset ( $temp_exception_ip_addresses );
//--------------------
$temp_block_referer = "";
foreach ( $block_referer as $value )
 {
  $temp_block_referer = $temp_block_referer."\n".$value;
 }
 $temp_block_referer = substr ( $temp_block_referer , 1 , strlen ( $temp_block_referer ) - 1 );
 unset ( $block_referer );
 $block_referer = $temp_block_referer;
 unset ( $temp_block_referer );
//--------------------
$temp_block_bots = "";
foreach ( $block_bots as $value )
 {
  $temp_block_bots = $temp_block_bots."\n".$value;
 }
 $temp_block_bots = substr ( $temp_block_bots , 1 , strlen ( $temp_block_bots ) - 1 );
 unset ( $block_bots );
 $block_bots = $temp_block_bots;
 unset ( $temp_block_bots );
//------------------------------------------------------------------------------
$display_index               = "block";
$display_syscheck            = "none";
$display_settings            = "none";
$display_advanced_settings   = "none";
$display_db_config           = "none";
$display_module              = "none";
$display_edit_site_name      = "none";
$display_edit_string_replace = "none";
$display_counter             = "none";
$display_maintenance_mode    = "none";
$display_del_cache           = "none";
$display_del_index           = "none";
$display_repair              = "none";
$display_del_archive_cache   = "none";
$display_backup              = "none";
$display_restart             = "none";
$display_css_edit            = "none";
$display_file_version        = "none";
//------------------------------------------------------------------------------
if ( $_GET [ "action" ] == "syscheck"            ) { $display_syscheck = "block"; $display_index = "none"; } else { $display_syscheck = "none"; }
//------------------------------------------------------------------------------
if ( $_GET [ "action" ] == "settings"            ) { $display_settings = "block"; $display_index = "none"; $class = "gc1"; } else { $display_settings = "none"; }
if ( $_GET [ "action" ] == "advanced_settings"   ) { $display_advanced_settings = "block"; $display_index = "none"; $class = "gc2"; } else { $display_advanced_settings = "none"; }
if ( $_GET [ "action" ] == "db_config"           ) { $display_db_config = "block"; $display_index = "none"; $class = "gc3"; } else { $display_db_contig = "none"; }
if ( $_GET [ "action" ] == "module"              ) { $display_module = "block"; $display_index = "none"; $class = "as1"; } else { $display_module = "none"; }
if ( $_GET [ "action" ] == "edit_site_name"      ) { $display_edit_site_name = "block"; $display_index = "none"; $class = "as2"; } else { $display_edit_site_name = "none"; }
if ( $_GET [ "action" ] == "edit_string_replace" ) { $display_edit_string_replace = "block"; $display_index = "none"; $class = "as3"; } else { $display_edit_string_replace = "none"; }
if ( $_GET [ "action" ] == "counter"             ) { $display_counter = "block"; $display_index = "none"; $class = "as4"; } else { $display_counter = "none"; }
if ( $_GET [ "action" ] == "maintenance_mode"    ) { $display_maintenance_mode = "block"; $display_index = "none"; $class = "mt1"; } else { $display_maintenance_mode = "none"; }
if ( $_GET [ "action" ] == "del_cache"           ) { $display_del_cache = "block"; $display_index = "none"; $class = "mt2"; } else { $display_del_cache = "none"; }
if ( $_GET [ "action" ] == "del_index"           ) { $display_del_index = "block"; $display_index = "none"; $class = "mt3"; } else { $display_del_index = "none"; }
if ( $_GET [ "action" ] == "repair"              ) { $display_repair = "block"; $display_index = "none"; $class = "mt4"; } else { $display_repair = "none"; }
if ( $_GET [ "action" ] == "del_archive_cache"   ) { $display_del_archive_cache = "block"; $display_index = "none"; $class = "mt5"; } else { $display_del_archive_cache = "none"; }
if ( $_GET [ "action" ] == "db_edit"             ) { $display_db_edit = "block"; $display_index = "none"; $class = "mt6"; } else { $display_db_edit = "none"; }
if ( $_GET [ "action" ] == "backup"              ) { $display_backup = "block"; $display_index = "none"; $class = "mt7"; } else { $display_backup = "none"; }
if ( $_GET [ "action" ] == "restart"             ) { $display_restart = "block"; $display_index = "none"; $class = "mt8"; } else { $display_restart = "none"; }
if ( $_GET [ "action" ] == "css_edit"            ) { $display_css_edit = "block"; $display_index = "none"; $class = "af1"; } else { $display_css_edit = "none"; }
if ( $_GET [ "action" ] == "file_version"        ) { $display_file_version = "block"; $display_index = "none"; $class = "af2"; } else { $display_file_version = "none"; }
//------------------------------------------------------------------------------
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 transitional//EN\">\n";
echo "<html>\n";
echo "<head>\n";
echo "<title>PHP Web Stat - Admin Center</title>\n";
if ( $autologout == 1 )
 {
  $logout_time = $autologout_time * 60;
  echo "<meta http-equiv=\"refresh\" content=\"".$logout_time."; URL=admin.php?action=autologout&lang=".$lang."\">\n";
 }
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
echo "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=EmulateIE7\" />\n";
echo "<meta http-equiv=\"pragma\" content=\"no-cache\">\n";
echo "<meta http-equiv=\"expires\" content=\"0\">\n";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/admin.css\" media=\"screen, projection\">\n";
echo "<script language=\"javascript\" type=\"text/javascript\" src=\"../func/win_open.js\"></script>\n";
echo '<script type="text/javascript">
<!--
function setclass(id) {
  obj_class = document.getElementById(id);
  obj_class.className = "current";
}
//-->
</script>';
echo "\n";
echo "</head>\n";
echo "<body class=\"body_ac\">\n";
echo "<form style=\"margin:0px;\" name=\"admin_save\" action=\"admin.php?action=".$_GET [ "action" ]."&lang=".$lang."\" onsubmit=\"undisableAll(this);\" method=\"post\">";
echo '<img src="../images/admin/adminlogo.gif" id="adminlogo" alt="">
<!-- ---------- start left-menu ---------- -->
<div id="menu_left">
  <div style="width:170px; margin:8px 0px 0px 4px; text-align:center; color:#0D638A; font-size:11px;"><b>Version '.$admin_version.'</b></div>';
  if ( $db_active == 1 ) { }
  else { echo '<div style="width:170px; margin:8px 0px 0px 4px; text-align:center;"><table border="0" cellspacing="0" cellpadding="0" align="center"><tr><td style="border:1px solid #666666; background:#FFFFFF; padding:1px;"><iframe src="../func/func_create_index.php" width="76" height="11" name="make_index" id="make_index" scrolling="no" marginheight="0" marginwidth="0" frameborder="0"></iframe></td></tr></table></div>'; }
  if ( $script_activity == 0 )
   {
    echo '<div style="width:170px; margin:8px 0px 0px 4px; border:1px solid #CC0000; padding:2px; background:#F9FBE0; color:#CC0000; text-align:center; font-size:13px;"><img src="../images/alert.gif" border="0" alt="" title=""><br><b>'.$lang_admin_mm[1].'</b></div>';
   }
  echo '
  <h3>'.$lang_admin_lm[1].'</h3>
    <ul>
      <li><a id="gc1" class="null" href="admin.php?action=settings&lang='.$lang.'">'.$lang_admin_gs[1].'</a></li>
      <li><a id="gc2" class="null" href="admin.php?action=advanced_settings&lang='.$lang.'">'.$lang_admin_as[1].'</a></li>';
      if ( $db_active == 1 )
       {
        echo '<li><a id="gc3" class="null" href="admin.php?action=db_config&lang='.$lang.'">'.$lang_db_connect[1].'</a></li>';
       }
      echo '
    </ul>
  <h3>'.$lang_admin_lm[2].'</h3>
    <ul>
      <li><a id="as1" class="null" href="admin.php?action=module&lang='.$lang.'">'.$lang_admin_ms[1].'</a></li>
      <li><a id="as2" class="null" href="admin.php?action=edit_site_name&lang='.$lang.'">'.$lang_admin_pe[1].'</a></li>
      <li><a id="as3" class="null" href="admin.php?action=edit_string_replace&lang='.$lang.'">'.$lang_admin_re[1].'</a></li>
      <li><a id="as4" class="null" href="admin.php?action=counter&lang='.$lang.'">'.$lang_admin_cs[1].'</a></li>
    </ul>
  <h3>'.$lang_admin_lm[3].'</h3>
    <ul>
      <li><a id="mt1" class="null" href="admin.php?action=maintenance_mode&lang='.$lang.'">'.$lang_admin_mm[1].'</a></li>
      <li><a id="mt2" class="null" href="admin.php?action=del_cache&lang='.$lang.'" onclick="cache();">'.$lang_admin_dc[1].'</a></li>
      ';
      if ( $db_active == 0 )
       {
        echo '<li><a id="mt3" class="null" href="admin.php?action=del_index&lang='.$lang.'">'.$lang_admin_ci[1].'</a></li>';
        echo '<li><a id="mt4" class="null" href="admin.php?action=repair&lang='.$lang.'">'.$lang_admin_lr[1].'</a></li>';
       }
      echo '
      <li><a id="mt5" class="null" href="admin.php?action=del_archive_cache&lang='.$lang.'">'.$lang_admin_dac[1].'</a></li>';
      if ( ( $db_active == 1 ) && ( file_exists ( "edit_db.php" ) ) )
       {
        echo '<li><a id="mt6" class="null" href="admin.php?action=db_edit&lang='.$lang.'">'.$lang_admin_db_e[1].'</a></li>';
       }
      echo '
      <li><a id="mt7" class="null" href="admin.php?action=backup&lang='.$lang.'">'.$lang_admin_cb[1].'</a></li>
      <li><a id="mt8" class="null" href="admin.php?action=restart&lang='.$lang.'">'.$lang_admin_sr[1].'</a></li>
    </ul>
  <h3>'.$lang_admin_lm[4].'</h3>
    <ul>
      <li><a id="af1" class="null" href="admin.php?action=css_edit&lang='.$lang.'">'.$lang_admin_ce[1].'</a></li>
      <li><a id="af2" class="null" href="admin.php?action=file_version&lang='.$lang.'">'.$lang_admin_fv[1].'</a></li>
    </ul>
</div>
<!-- ---------- start top-menu ---------- -->
<div id="menu_top">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding-left:220px;">
    <a href="../index.php?action=backtostat">'.$lang_admin_tm[1].'</a>
    <a href="admin.php?lang='.$lang.'">'.$lang_admin_tm[2].'</a>
    <a href="javascript:void(0)" onclick="sysinfo();">'.$lang_admin_tm[3].'</a>
    <a href="admin.php?action=syscheck&lang='.$lang.'">'.$lang_admin_tm[4].'</a> ';
    if ( $language != "language/german.php" ) { echo '<a href="javascript:void(0)" onclick="manual_en();">'.$lang_admin_tm[5].'</a>'; } else { echo '<a href="javascript:void(0)" onclick="manual_de();">'.$lang_admin_tm[5].'</a>'; }
    echo '
    <a href="http://support.php-web-statistik.de/" target="_blank">'.$lang_admin_tm[6].'</a> &nbsp;&nbsp;
    <a href="admin.php?lang='.$lang.'&amp;logout=1">'.$lang_admin_tm[7].'</a>
    </td>
  </tr>
  </table>
</div>
<!-- ---------- start content ---------- -->
<div id="content">';
  //----------------------------------------
  /* index */
  echo "<div style=\"display:".$display_index.";\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_i[1]."</th>
  </tr>
  <tr>
    <td class=\"bg1\" style=\"padding:4px;\">
    ".$lang_admin_i[2]."<br><br>
    ".$lang_admin_i[3]."<br><br>
    ".$lang_admin_i[4]."
    </td>
  </tr>
  </table>
  <br>
  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td width=\"50%\" valign=\"top\" style=\"padding-right: 10px;\">
    <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
    <tr>
      <th colspan=\"2\">".$lang_admin_i_vi[1]."</th>
    </tr>
      <script language=\"javascript\" type=\"text/javascript\">
      <!-- //hide from dinosaurs
      var STABLE;
      // -->
      </script>
      <script language=\"javascript\" src=\"http://www.php-web-statistik.de/checkversion.js\" type=\"text/javascript\"></script>
      <script language=\"javascript\" type=\"text/javascript\">
      <!-- //hide from dinosaurs
      document.write('<tr><td class=\"bg1\" style=\"padding:3px;\">".$lang_admin_i_vi[2]."</td><td class=\"bg1\" style=\"padding:3px;\"><b>".$version_number.$revision_number."</b></td></tr>');
      if (!STABLE)
       {
        document.write('<tr><td class=\"bg1\" style=\"padding:3px;\">".$lang_admin_i_vi[4]."</td><td class=\"bg1\" style=\"padding:3px;\">&nbsp;</td></tr>');
        document.write('<tr><td class=\"bg1\" style=\"padding:3px;\">".$lang_admin_i_vi[5]."</td><td class=\"bg1\" style=\"padding:3px;\">&nbsp;</td></tr>');
        document.write('<tr><td colspan=\"2\" class=\"bg1\" style=\"padding:3px;\"><br /><b>".$lang_admin_i_vi[3]."</b><br /><br /></td></tr>');
       }
      else
       {
       document.write('<tr><td class=\"bg1\" style=\"padding:3px;\">".$lang_admin_i_vi[4]."</td><td class=\"bg1\" style=\"padding:3px;\"><b>'+STABLE+'</b></td></tr>');
       document.write('<tr><td class=\"bg1\" style=\"padding:3px;\">".$lang_admin_i_vi[5]."</td><td class=\"bg1\" style=\"padding:3px;\"><b>'+BETA+'</b></td></tr>');
        if (STABLE > \"".$version_number.$revision_number."\")
         {
          document.write('<tr><td colspan=\"2\" class=\"bg1\" style=\"padding:3px;\" valign=\"middle\"><br /><b><font color=\"red\">".$lang_admin_i_vi[6]."</font></b><br />".$lang_admin_i_vi[7]." (<b>'+STABLE+'</b>) ".$lang_admin_i_vi[8]."<br /><a href=\"http://www.php-web-statistik.de\" target=\"_blank\" title=\"php web statistik, webstat, besucher statistik, stat, counter, tracker\">http://www.php-web-statistik.de</a><br /><br /></td></tr>');
         }
        else
         {
          document.write('<tr><td colspan=\"2\" class=\"bg1\" style=\"padding:3px;\" valign=\"middle\"><br />".$lang_admin_i_vi[9]."<br /><br /></td></tr>');
         }
        }
      // -->
      </script>
      <noscript>".$lang_admin_i_vi[10]."</noscript>
    </table>
    <br>
    <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
    <tr>
      <th>".$lang_admin_i_l[1]."</th>
    </tr>
    <tr>
      <td class=\"bg1\" style=\"padding:4px; height:160px; vertical-align:top;\">
      <iframe src=\"../func/func_last_logins_show.php\" width=\"100%\" height=\"152\" name=\"last_login\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" frameborder=\"0\">Sorry but your browser does not support iframes</iframe>
      </td>
    </tr>
    </table>

    </td>
    <td width=\"50%\" valign=\"top\" style=\"padding-left: 10px;\">

    <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
    <tr>
      <th>".$lang_admin_i_i[1]."</th>
    </tr>
    <tr>
      <td class=\"bg1\" style=\"padding:4px; height:111px; vertical-align:top;\">
      <script language=\"JavaScript\" type=\"text/javascript\">
      <!-- //hide from dinosaurs
      var INFO;
      // -->
      </script>
      <script language=\"javascript\" src=\"http://www.php-web-statistik.de/checkinfo.js\" type=\"text/javascript\"></script>
      <script language=\"JavaScript\" type=\"text/javascript\">
      <!-- //hide from dinosaurs
      if (!INFO)
       {
        document.write('<b>".$lang_admin_i_vi[3]."</b>');
       }
      else
       {
        ";
        if ( $language == "language/german.php" )
         {
          echo "document.write(''+INFO_DE+'');";
         }
        else
         {
           echo "document.write(''+INFO_EN+'');";
         }
        echo "
       }
      // -->
      </script>
      <noscript>".$lang_admin_i_vi[10]."</noscript>
      </td>
    </tr>
    </table>
    <br>
    <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
    <tr>
      <th>".$lang_admin_i_thx[1]."</th>
    </tr>
    <tr>
      <td class=\"bg1\" style=\"padding:4px; height:160px; vertical-align:top;\">
      ".$lang_admin_i_thx[2]."
      <div class=\"small\">
      <script language=\"JavaScript\" type=\"text/javascript\">
      <!-- //hide from dinosaurs
      if (!INFO)
       {
        document.write('<br><b>".$lang_admin_i_vi[3]."</b>');
       }
      else
       {
        document.write('<br><b>Support:</b><br>'+CON_SUPPORT+'<br><b>Translation:</b><br>'+CON_TRANSLATORS+'<br><b>Code Review:</b><br>'+CON_CODEREVIEW+'');
       }
      // -->
      </script>
      <noscript>".$lang_admin_i_vi[10]."</noscript>
      </div>
      </td>
    </tr>
    </table>
    <br>
    </td>
  </tr>
  </table>
  <br>
  </div>";
  //----------------------------------------
  /* syscheck */
  echo "<div style=\"display:".$display_syscheck.";\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_sc[1]."</th>
  </tr>
  <tr>
    <td class=\"bg1\" style=\"padding:4px;\">
    ".$lang_admin_sc[2]."<br>
    ".$lang_admin_sc[3]."
    </td>
  </tr>
  </table>
  <br>
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
  <tr>
    <td class=\"bg1\">
    <iframe name=\"syscheck\" src=\"../syscheck.php\" style=\"width:100%; height:535px;\" frameborder=\"0\" scrolling=\"no\">Sorry but your browser does not support iframes</iframe>
    </td>
  </tr>
  </table>
  <br>
  </div>";
  //----------------------------------------
  /* general settings */
  echo "<div style=\"display:".$display_settings.";\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_lm[1]."</th>
  </tr>
  <tr>
    <td class=\"th2 bold center\">".$lang_admin_gs[1]."</td>
  </tr>
  <tr>
    <td class=\"bg1\">
    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
    <tr>
      <td class=\"bg2\">".$lang_admin_gs[2]."<br><div class=\"small\">".$lang_admin_gs[3]."</div></td>
      <td class=\"bg3\" style=\"vertical-align:middle;\">";
      if ( $db_active == 1 )
       {
        echo "<span style=\"border:1px solid #7F9DB9; padding:2px; background:#FFFFFF; font-size:12px;\">&nbsp;".$lang_admin_gs[5]."&nbsp;</span><input type=\"hidden\" name=\"db_active\" size=\"3\" value=\"".$db_active."\">";
       }
      else
       {
        echo "<span style=\"border:1px solid #7F9DB9; padding:2px; background:#FFFFFF; font-size:12px;\">&nbsp;".$lang_admin_gs[4]."&nbsp;</span><input type=\"hidden\" name=\"db_active\" size=\"3\" value=\"".$db_active."\">";
       }
      echo "
      </td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_gs[6]."<br><div class=\"small\">".$lang_admin_gs[7]."</div></td>
      <td class=\"bg3\"><input type=\"text\" name=\"script_domain\" size=\"40\" value=\"".$script_domain."\" style=\"width:95%;\"></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_gs[8]."<br><div class=\"small\">".$lang_admin_gs[9]."</div></td>
      <td class=\"bg3\"><input type=\"text\" name=\"home_site_name\" size=\"40\" value=\"".$home_site_name."\" style=\"width:95%;\"></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_gs[10]."<br><div class=\"small\">".$lang_admin_gs[11]."</div></td>
      <td class=\"bg3\"><input type=\"text\" name=\"script_path\" size=\"40\" value=\"".$script_path."\" style=\"width:95%;\"></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_gs[12]."<br><div class=\"small\">".$lang_admin_gs[13]."</div></td>
      <td class=\"bg3\"><textarea name=\"exception_domain\" rows=\"5\" size=\"40\" style=\"width:95%;\">".$exception_domain."</textarea></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_gs[14]."<br><div class=\"small\">".$lang_admin_gs[15]."</div></td>
      <td class=\"bg3\"><input type=\"text\" name=\"stat_name\" size=\"40\" value=\"".$stat_name."\" style=\"width:95%;\"></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_gs[16]."<br><div class=\"small\">".$lang_admin_gs[17]."</div></td>
      <td class=\"bg3\"><table width=\"96%\" border=\"0\" cellspacing=\"0\" callpadding=\"0\"><tr><td><select name=\"language\" size=\"1\" style=\"width:100%;\">";
      foreach ( $language_files_found as $value )
       {
        echo "<option value=\"language/".$value."\" ".selecter_language("language/".$value)."> ".substr ( $value , 0 , strlen ( $value ) -4 );
       }
      echo "</select></td></tr></table></td>";
      unset ( $language_files_found );
      echo "
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_gs[18]."<br><div class=\"small\">".$lang_admin_gs[19]."</div></td>
      <td class=\"bg3\"><table width=\"96%\" border=\"0\" cellspacing=\"0\" callpadding=\"0\"><tr><td><select name=\"language_patterns\" size=\"1\" style=\"width:100%;\">";
      foreach ( $country_files_found as $value )
       {
        echo "<option value=\"language/".$value."\" ".selecter_language_patterns("language/".$value)."> ".substr ( $value , 0 , strpos ( $value , "_" ) );
       }
      echo "</select></td></tr></table></td>";
      unset ( $country_files_found );
    echo "
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_gs[20]."<br><div class=\"small\">".$lang_admin_gs[21]."</div></td>
      <td class=\"bg3\"><textarea name=\"url_parameter\" rows=\"5\" size=\"40\" style=\"width:95%;\">".$url_parameter."</textarea></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td class=\"th2 center\"><input type=\"submit\" class=\"submit\" value=\"".$lang_admin_f[1]."\"></td>
  </tr>
  </table>
  <br>
  </div>";
  //----------------------------------------
  /* advanced settings */
  echo "<div style=\"display:".$display_advanced_settings.";\">
  <ul id=\"tablist1\">
    <li id=\"button_general\" onclick=\"changeToTab('general'); return false;\">&nbsp;".$lang_admin_as[2]."&nbsp;</li>
    <li id=\"button_security\" onclick=\"changeToTab('security'); return false;\">&nbsp;".$lang_admin_as[3]."&nbsp;</li>
    <li id=\"button_display\" onclick=\"changeToTab('display'); return false;\">&nbsp;".$lang_admin_as[4]."&nbsp;</li>
  </ul>
  <div class=\"section\" id=\"tab_general\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th style=\"border-left:none;\">".$lang_admin_as[1]."</th>
  </tr>
  <tr>
    <td class=\"th2 bold center\">".$lang_admin_as[2]."</td>
  </tr>
  <tr>
    <td class=\"bg1\">
    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
    <tr>
      <td class=\"bg2\">".$lang_admin_as_g[1]."<br><div class=\"small\">".$lang_admin_as_g[2]."</div></td>
      <td class=\"bg3\"><textarea name=\"exception_ip_addresses\" rows=\"3\" size=\"40\" style=\"width:95%;\">".$exception_ip_addresses."</textarea></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_g[37]."<br><div class=\"small\">".$lang_admin_as_g[38]."</div></td>
      <td class=\"bg3\"><textarea name=\"block_referer\" rows=\"5\" size=\"40\" style=\"width:95%;\">".$block_referer."</textarea></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_g[39]."<br><div class=\"small\">".$lang_admin_as_g[40]."</div></td>
      <td class=\"bg3\"><textarea name=\"block_bots\" rows=\"5\" size=\"40\" style=\"width:95%;\">".$block_bots."</textarea></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_g[3]."<br><div class=\"small\">".$lang_admin_as_g[4]."</div></td>
      <td class=\"bg3\"><table width=\"96%\" border=\"0\" cellspacing=\"0\" callpadding=\"0\"><tr><td width=\"25%\"><span id=\"time\" style=\"font-size:14px; font-weight:bold;\"></span></td><td width=\"75%\"><select name=\"server_time\" size=\"1\" style=\"width:100%;\"><option value=\"+14h\" ".selecter_server_time("+14h")."> +14 ".$lang_admin_as_g[6]."<option value=\"+13,75h\" ".selecter_server_time("+13,75h")."> +13,75 ".$lang_admin_as_g[6]."<option value=\"+13h\" ".selecter_server_time("+13h")."> +13 ".$lang_admin_as_g[6]."<option value=\"+12,75h\" ".selecter_server_time("+12,75h")."> +12,75 ".$lang_admin_as_g[6]."<option value=\"+12h\" ".selecter_server_time("+12h")."> +12 ".$lang_admin_as_g[6]."<option value=\"+11,5h\" ".selecter_server_time("+11,5h")."> +11,5 ".$lang_admin_as_g[6]."<option value=\"+11h\" ".selecter_server_time("+11h")."> +11 ".$lang_admin_as_g[6]."<option value=\"+10,5h\" ".selecter_server_time("+10,5h")."> +10,5 ".$lang_admin_as_g[6]."<option value=\"+10h\" ".selecter_server_time("+10h")."> +10 ".$lang_admin_as_g[6]."<option value=\"+9,5h\" ".selecter_server_time("+9,5h")."> +9,5 ".$lang_admin_as_g[6]."<option value=\"+9h\" ".selecter_server_time("+9h")."> +9 ".$lang_admin_as_g[6]."<option value=\"+8h\" ".selecter_server_time("+8h")."> +8 ".$lang_admin_as_g[6]."<option value=\"+7h\" ".selecter_server_time("+7h")."> +7 ".$lang_admin_as_g[6]."<option value=\"+6,5h\" ".selecter_server_time("+6,5h")."> +6,5 ".$lang_admin_as_g[6]."<option value=\"+6h\" ".selecter_server_time("+6h")."> +6 ".$lang_admin_as_g[6]."<option value=\"+5,75h\" ".selecter_server_time("+5,75h")."> +5,75 ".$lang_admin_as_g[6]."<option value=\"+5,5h\" ".selecter_server_time("+5,5h")."> +5,5 ".$lang_admin_as_g[6]."<option value=\"+5h\" ".selecter_server_time("+5h")."> +5 ".$lang_admin_as_g[6]."<option value=\"+4,5h\" ".selecter_server_time("+4,5h")."> +4,5 ".$lang_admin_as_g[6]."<option value=\"+4h\" ".selecter_server_time("+4h")."> +4 ".$lang_admin_as_g[6]."<option value=\"+3,5h\" ".selecter_server_time("+3,5h")."> +3,5 ".$lang_admin_as_g[6]."<option value=\"+3h\" ".selecter_server_time("+3h")."> +3 ".$lang_admin_as_g[6]."<option value=\"+2h\" ".selecter_server_time("+2h")."> +2 ".$lang_admin_as_g[6]."<option value=\"+1h\" ".selecter_server_time("+1h")."> +1 ".$lang_admin_as_g[5]."<option value=\"+0h\" ".selecter_server_time("+0h")."> +0 ".$lang_admin_as_g[6]."<option value=\"-1h\" ".selecter_server_time("-1h")."> -1 ".$lang_admin_as_g[5]."<option value=\"-2h\" ".selecter_server_time("-2h")."> -2 ".$lang_admin_as_g[6]."<option value=\"-3h\" ".selecter_server_time("-3h")."> -3 ".$lang_admin_as_g[6]."<option value=\"-3,5h\" ".selecter_server_time("-3,5h")."> -3,5 ".$lang_admin_as_g[6]."<option value=\"-4h\" ".selecter_server_time("-4h")."> -4 ".$lang_admin_as_g[6]."<option value=\"-4,5h\" ".selecter_server_time("-4,5h")."> -4,5 ".$lang_admin_as_g[6]."<option value=\"-5h\" ".selecter_server_time("-5h")."> -5 ".$lang_admin_as_g[6]."<option value=\"-6h\" ".selecter_server_time("-6h")."> -6 ".$lang_admin_as_g[6]."<option value=\"-7h\" ".selecter_server_time("-7h")."> -7 ".$lang_admin_as_g[6]."<option value=\"-8h\" ".selecter_server_time("-8h")."> -8 ".$lang_admin_as_g[6]."<option value=\"-9h\" ".selecter_server_time("-9h")."> -9 ".$lang_admin_as_g[6]."<option value=\"-9,5h\" ".selecter_server_time("-9,5h")."> -9,5 ".$lang_admin_as_g[6]."<option value=\"-10h\" ".selecter_server_time("-10h")."> -10 ".$lang_admin_as_g[6]."<option value=\"-11h\" ".selecter_server_time("-11h")."> -11 ".$lang_admin_as_g[6]."<option value=\"-12h\" ".selecter_server_time("-12h")."> -12 ".$lang_admin_as_g[6]."</select></td></tr></table></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_g[7]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"frames\" value=\"x\" ".checker($frames)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_g[8]."</td>
      <td class=\"bg3\"><input type=\"text\" name=\"ip_recount_time\" size=\"4\" value=\"".$ip_recount_time."\"> <span class=\"small\">1440</span></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_g[9]."<br><div class=\"small\">".$lang_admin_as_g[10]."</div></td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"auto_update_check\" value=\"x\" ".checker($auto_update_check)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_g[11]."<br><div class=\"small\">".$lang_admin_as_g[12]."</div></td>
      <td class=\"bg3\"><input type=\"text\" name=\"starting_date\" size=\"10\" maxlength=\"10\" value=\"".$starting_date."\"></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_g[13]."<br><div class=\"small\">".$lang_admin_as_g[14]."</div></td>
      <td class=\"bg3\"><input type=\"text\" name=\"stat_add_visitors\" size=\"6\" value=\"".$stat_add_visitors."\"></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_g[23]."<br><div class=\"small\">".$lang_admin_as_g[24]."</div></td>
      <td class=\"bg3\"><select name=\"get_ip_address\" size=\"1\" style=\"width:60%;\"><option value=\"1\" ".selecter_get_ip_address("1")."> \$SERVER - REMOTE_ADDR <option value=\"2\" ".selecter_get_ip_address("2")."> \$SERVER - HTTP_X_REMOTECLIENT_IP <option value=\"3\" ".selecter_get_ip_address("3")."> \$SERVER - HTTP_X_FORWARDED_FOR <option value=\"4\" ".selecter_get_ip_address("4")."> \$SERVER - HTTP_CLIENT_IP <option value=\"5\" ".selecter_get_ip_address("5")."> getenv - REMOTE_ADDR <option value=\"6\" ".selecter_get_ip_address("6")."> getenv - HTTP_X_REMOTECLIENT_IP <option value=\"7\" ".selecter_get_ip_address("7")."> getenv - HTTP_X_FORWARDED_FOR <option value=\"8\" ".selecter_get_ip_address("8")."> getenv - HTTP_CLIENT_IP </select></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_g[25]."<br><div class=\"small\">".$lang_admin_as_g[26]."</div></td>
      <td class=\"bg3\"><select name=\"hash_ip_address\" size=\"1\" style=\"width:60%;\"><option value=\"0\" ".selecter_hash_ip_address("0")."> ".$lang_admin_as_g[27]." <option value=\"1\" ".selecter_hash_ip_address("1")."> ".$lang_admin_as_g[28]." <option value=\"2\" ".selecter_hash_ip_address("2")."> ".$lang_admin_as_g[29]."</select></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_g[17]."<br><div class=\"small\">".$lang_admin_as_g[18]."</div></td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"error_reporting\" value=\"x\" ".checker($error_reporting)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_g[19]."<br><div class=\"small\">".$lang_admin_as_g[20]."</div></td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"google_images\" value=\"x\" ".checker($google_images)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_g[21]."<br><div class=\"small\">".$lang_admin_as_g[22]."</div></td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"google_adwords\" value=\"x\" ".checker($google_adwords)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_g[15]."<br><div class=\"small\">".$lang_admin_as_g[16]."</div></td>
      <td class=\"bg3\"><select name=\"creator_number\" size=\"1\" style=\"width:20%;\"><option value=\"500\" ".selecter_creator("500")."> 500 <option value=\"1000\" ".selecter_creator("1000")."> 1000 <option value=\"2500\" ".selecter_creator("2500")."> 2500 <option value=\"5000\" ".selecter_creator("5000")."> 5000 <option value=\"10000\" ".selecter_creator("10000")."> 10000 <option value=\"15000\" ".selecter_creator("15000")."> 15000</select></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_g[35]."<br><div class=\"small\">".$lang_admin_as_g[36]."</div></td>
      <td class=\"bg3\"><select name=\"creator_referer_cut\" size=\"1\" style=\"width:20%;\"><option value=\"0\" ".selecter_creator_referer_cut("0")."> 0 <option value=\"1\" ".selecter_creator_referer_cut("1")."> 1 <option value=\"2\" ".selecter_creator_referer_cut("2")."> 2</select></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_g[30]."<br><div class=\"small\">".$lang_admin_as_g[31]."</div></td>
      <td class=\"bg3\"><select name=\"index_creator_number\" size=\"1\" style=\"width:20%;\"><option value=\"20000\" ".selecter_index_creator("20000")."> 20000 <option value=\"30000\" ".selecter_index_creator("30000")."> 30000 <option value=\"50000\" ".selecter_index_creator("50000")."> 50000 <option value=\"80000\" ".selecter_index_creator("80000")."> 80000 <option value=\"100000\" ".selecter_index_creator("100000")."> 100000</select></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_g[32]."<br><div class=\"small\">".$lang_admin_as_g[33]."</div></td>
      <td class=\"bg3\"><select name=\"cache_update\" size=\"1\" style=\"width:40%;\"><option value=\"0\" ".selecter_cache_update("0")."> ".$lang_admin_as_g[34]." <option value=\"15\" ".selecter_cache_update("15")."> 15 <option value=\"30\" ".selecter_cache_update("30")."> 30 <option value=\"60\" ".selecter_cache_update("60")."> 60 <option value=\"180\" ".selecter_cache_update("180")."> 180 <option value=\"360\" ".selecter_cache_update("360")."> 360 <option value=\"720\" ".selecter_cache_update("720")."> 720</select></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td class=\"th2 center\"><input type=\"submit\" class=\"submit\" value=\"".$lang_admin_f[1]."\"></td>
  </tr>
  </table>
  </div>

  <div class=\"section\" id=\"tab_security\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_as[1]."</th>
  </tr>
  <tr>
    <td class=\"th2 bold center\">".$lang_admin_as[3]."</td>
  </tr>
  <tr>
    <td class=\"bg1\">
    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
    <tr>
      <td class=\"bg2\">".$lang_admin_as_s[1]."<br><div class=\"small\">".$lang_admin_as_s[2]."</div></td>
      <td class=\"bg3\"><input type=\"password\" name=\"adminpassword\" size=\"40\" value=\"".$adminpassword."\" style=\"width:95%;\"></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_s[3]."<br><div class=\"small\">".$lang_admin_as_s[4]."</div></td>
      <td class=\"bg3\"><input type=\"password\" name=\"clientpassword\" size=\"40\" value=\"".$clientpassword."\" style=\"width:95%;\"></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_s[5]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"loginpassword_ask\" value=\"x\" ".checker($loginpassword_ask)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_s[6]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"cookiepassword_ask\" value=\"x\" ".checker($cookiepassword_ask)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_s[7]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"set_htaccess\" value=\"x\" ".checker($set_htaccess)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_s[8]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"autologout\" value=\"x\" ".checker($autologout)."></td>
    </tr>
    <tr>
      <td class=\"bg2\"><div class=\"small\">".$lang_admin_as_s[9]."</div></td>
      <td class=\"bg3\"><select name=\"autologout_time\" size=\"1\" style=\"width:20%;\" disabled=\"disabled\"><option value=\"15\" ".selecter_autologout_time("15")."> 15 <option value=\"30\" ".selecter_autologout_time("30")."> 30 <option value=\"45\" ".selecter_autologout_time("45")."> 45 <option value=\"60\" ".selecter_autologout_time("60")."> 60</select></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td class=\"th2 center\"><input type=\"submit\" class=\"submit\" value=\"".$lang_admin_f[1]."\"></td>
  </tr>
  </table>
  </div>

  <div class=\"section\" id=\"tab_display\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_as[1]."</th>
  </tr>
  <tr>
    <td class=\"th2 bold center\">".$lang_admin_as[4]."</td>
  </tr>
  <tr>
    <td class=\"bg1\">
    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
    <tr>
      <td class=\"bg2\">".$lang_admin_as_d[1]."<br><div class=\"small\">".$lang_admin_as_d[2]."</div></td>
      <td class=\"bg3\"><table width=\"96%\" border=\"0\" cellspacing=\"0\" callpadding=\"0\"><tr><td><select name=\"theme\" size=\"1\" style=\"width:100%;\">";
      foreach ( $theme_dir_read as $value )
       {
        echo "<option value=\"themes/".$value."/\" ".selecter_theme("themes/".$value."/")."> ".$value;
       }
      echo "</select></td></tr></table></td>";
      unset ( $theme_dir_read );
      echo "
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_d[3]."<br><div class=\"small\">".$lang_admin_as_d[30]."</div></td>
      <td class=\"bg3\"><select name=\"show_detailed_browser\" size=\"1\" style=\"width:60%;\"><option value=\"0\" ".selecter_detailed_browser("0")."> ".$lang_admin_as_d[31]." <option value=\"1\" ".selecter_detailed_browser("1")."> ".$lang_admin_as_d[32]." <option value=\"2\" ".selecter_detailed_browser("2")."> ".$lang_admin_as_d[33]."</select></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_d[16]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"show_detailed_os\" value=\"x\" ".checker($show_detailed_os)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_d[4]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"show_detailed_referer\" value=\"x\" ".checker($show_detailed_referer)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_d[5]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"show_country_flags\" value=\"x\" ".checker($show_country_flags)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_d[6]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"show_browser_icons\" value=\"x\" ".checker($show_browser_icons)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_d[7]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"show_os_icons\" value=\"x\" ".checker($show_os_icons)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_d[8]."<br><div class=\"small\">".$lang_admin_as_d[9]."</div></td>
      <td class=\"bg3\">1 <input type=\"radio\" name=\"percentbar_max_value_1\" value=\"0\" ".checker_percentbar_max_value_1_0()."> &nbsp; &nbsp; &nbsp; 2 <input type=\"radio\" name=\"percentbar_max_value_1\" value=\"1\" ".checker_percentbar_max_value_1_1()."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_d[10]."<br><div class=\"small\">".$lang_admin_as_d[11]."</div></td>
      <td class=\"bg3\">1 <input type=\"radio\" name=\"percentbar_max_value_2\" value=\"0\" ".checker_percentbar_max_value_2_0()."> &nbsp; &nbsp; &nbsp; 2 <input type=\"radio\" name=\"percentbar_max_value_2\" value=\"1\" ".checker_percentbar_max_value_2_1()."></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td class=\"th2 bold center\">".$lang_admin_as_d[17]."</td>
  </tr>
  <tr>
    <td class=\"bg1\">
    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
    <tr>
      <td class=\"bg2\">".$lang_admin_as_d[25]."<br><div class=\"small\">".$lang_admin_as_d[26]."</div></td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"show_last_hits\" value=\"x\" ".checker($show_last_hits)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_d[27]."<br><div class=\"small\">".$lang_admin_as_d[28]."</div></td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"show_ip_client\" value=\"x\" ".checker($show_ip_client)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_d[18]."</td>
      <td class=\"bg3\"><input type=\"text\" name=\"last_hits_width\" size=\"4\" value=\"".$last_hits_width."\">  &nbsp;x&nbsp; <input type=\"text\" name=\"last_hits_height\" size=\"4\" value=\"".$last_hits_height."\"> <span class=\"small\">970 x 587</span></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_d[19]."<br><div class=\"small\">".$lang_admin_as_d[20]."</div></td>
      <td class=\"bg3\"><input type=\"text\" name=\"last_hits_site_column\" size=\"4\" value=\"".$last_hits_site_column."\"> <span class=\"small\">230</span></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_d[21]."<br><div class=\"small\">".$lang_admin_as_d[22]."</div></td>
      <td class=\"bg3\"><input type=\"text\" name=\"last_hits_site_length\" size=\"3\" value=\"".$last_hits_site_length."\"> <span class=\"small\">30</span></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_d[23]."<br><div class=\"small\">".$lang_admin_as_d[24]."</div></td>
      <td class=\"bg3\"><input type=\"text\" name=\"last_hits_referer_length\" size=\"3\" value=\"".$last_hits_referer_length."\"> <span class=\"small\">50</span></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_d[12]."<br><div class=\"small\">".$lang_admin_as_d[13]."</div></td>
      <td class=\"bg3\"><select name=\"last_hits_number\" size=\"1\" style=\"width:20%;\"><option value=\"50\" ".selecter_lh_number("50")."> 50 <option value=\"100\" ".selecter_lh_number("100")."> 100 <option value=\"250\" ".selecter_lh_number("250")."> 250 <option value=\"500\" ".selecter_lh_number("500")."> 500 <option value=\"1000\" ".selecter_lh_number("1000")."> 1000 <option value=\"2500\" ".selecter_lh_number("2500")."> 2500 <option value=\"5000\" ".selecter_lh_number("5000")."> 5000 <option value=\"10000\" ".selecter_lh_number("10000")."> 10000 <option value=\"15000\" ".selecter_lh_number("15000")."> 15000 <option value=\"20000\" ".selecter_lh_number("20000")."> 20000</select></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_as_d[14]."<br><div class=\"small\">".$lang_admin_as_d[15]."</div></td>
      <td class=\"bg3\"><select name=\"whois_link\" size=\"1\" style=\"width:100%;\"><option value=\"http://geolocation.php-web-statistik.de/index.php?address=\" ".selecter_whois("http://geolocation.php-web-statistik.de/index.php?address=")."> http://geolocation.php-web-statistik.de <option value=\"http://www.infosniper.net/index.php?ip_address=\" ".selecter_whois("http://www.infosniper.net/index.php?ip_address=")."> http://www.infosniper.net <option value=\"http://www.dnsstuff.com/tools/whois.ch?ip=\" ".selecter_whois("http://www.dnsstuff.com/tools/whois.ch?ip=")."> http://www.dnsstuff.com <option value=\"http://www.utrace.de/?query=\" ".selecter_whois("http://www.utrace.de/?query=")."> http://www.utrace.de <option value=\"http://petrosilius.de/map.php?IP=\" ".selecter_whois("http://petrosilius.de/map.php?IP=")."> http://petrosilius.de</select></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td class=\"th2 center\"><input type=\"submit\" class=\"submit\" value=\"".$lang_admin_f[1]."\"></td>
  </tr>
  </table>
  </div>
  <br>
  </div>";
  //----------------------------------------
  if ( $db_active == 1 )
   {
    /* database connection */
    echo "<div style=\"display:".$display_db_config.";\">
    <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
    <tr>
      <th>".$lang_admin_lm[1]."</th>
    </tr>
    <tr>
      <td class=\"th2 bold center\">".$lang_db_connect[2]."</td>
    </tr>
    <tr>
      <td class=\"bg1\">
      <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
      <tr>
        <td class=\"bg2\">".$lang_db_connect[3]."<br><div class=\"small\">".$lang_db_connect[4]."</div></td>
        <td class=\"bg3\"><input type=\"text\" name=\"db_host\" size=\"40\" value=\"".$db_host."\" style=\"width:95%;\"></td>
      </tr>
      <tr>
        <td class=\"bg2\">".$lang_db_connect[5]."<br><div class=\"small\">".$lang_db_connect[6]."</div></td>
        <td class=\"bg3\"><input type=\"text\" name=\"db_name\" size=\"40\" value=\"".$db_name."\" style=\"width:95%;\"></td>
      </tr>
      <tr>
        <td class=\"bg2\">".$lang_db_connect[7]."<br><div class=\"small\">".$lang_db_connect[8]."</div></td>
        <td class=\"bg3\"><input type=\"text\" name=\"db_user\" size=\"40\" value=\"".$db_user."\" style=\"width:95%;\"></td>
      </tr>
      <tr>
        <td class=\"bg2\">".$lang_db_connect[9]."<br><div class=\"small\">".$lang_db_connect[10]."</div></td>
        <td class=\"bg3\"><input type=\"password\" name=\"db_password\" size=\"40\" value=\"".$db_password."\" style=\"width:95%;\"></td>
      </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td class=\"th2 bold center\">".$lang_db_connect[1]."</td>
    </tr>
    <tr>
      <td class=\"bg1\">
      <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
      <tr>
        <td class=\"bg2\">".$lang_db_prefix[1]."<br><div class=\"small\">".$lang_db_prefix[2]."<br><br></div></td>
        <td class=\"bg3\"><input type=\"text\" name=\"db_prefix\" size=\"40\" value=\"".$db_prefix."\" style=\"width:95%;\"></td>
      </tr>
      ";
      /* check to exists the db_tables */
      function db_query ( $query, $switch, $cancel )
       {
        //--------------------------
        include ( "config_db.php" );
        //------------------------------
        $db_entries      = array ();
        $db_connection   = 0;
        $db_counter      = 0;
        $db_number_rows  = 0;
        $db_query_result = 0;
        $db_temp         = 0;
        $db_temp_counter = 0;
        $db_error        = 0;
        $mysqli          = 0; // set extension disabled
        //------------------------------
        if ( function_exists ( "mysqli_connect" ) ) // check for extension enabled
         {
          $mysqli = 1;
         }
        //--------------------------
        if ( $mysqli == 1 )
         {
          //--------------------------
          $db_connection = mysqli_connect ( $db_host , $db_user , $db_password , $db_name );
          //--------------------------
          if ( !$db_connection )
           {
            if ( $cancel == 1 ) { echo '<script language="JavaScript"> location.replace(\''.$_SERVER ["PHP_SELF"].'\'); </script>'; }
            else { $db_error = mysqli_error(); die ( $db_error ); }
           }
          //--------------------------
          if ( mysqli_connect_errno ( $db_connection ) )
           {
           	if ( $cancel == 1 ) { echo '<meta http-equiv="refresh" content="5; URL='.$_SERVER ["PHP_SELF"].'\">'; }
         	  else { $db_error = mysqli_error(); die ( $db_error ); }
           }
          //--------------------------
          $query_result = mysqli_query ( $db_connection , $query );
          //--------------------------
          if ( !$query_result ) { $db_error = mysqli_error(); die ( $db_error ); }
          //--------------------------
          if  ( $switch == 1 )
           {
            $db_number_rows = mysqli_num_rows ( $query_result );
            while ( $db_temp = mysqli_fetch_row ( $query_result ) )
             {
              for ( $db_temp_counter = 0 ; $db_temp_counter <= count ( $db_temp ) ; $db_temp_counter++ )
               {
                $db_entries [ $db_counter ] [ $db_temp_counter ] = $db_temp[ $db_temp_counter ];
               }
              $db_counter++;
             }
           }
          //--------------------------
          mysqli_close( $db_connection );
          return $db_entries;
          //--------------------------
         }
        else
         {
          //--------------------------
          $db_connection = mysql_pconnect ( $db_host , $db_user , $db_password );
          //--------------------------
          if ( !$db_connection )
           {
            if ( $cancel == 1 ) { echo '<script language="JavaScript"> location.replace(\''.$_SERVER ["PHP_SELF"].'\'); </script>'; }
            else { $db_error = mysql_error(); die ( $db_error ); }
           }
          //--------------------------
          // This function was used to check for upcoming errors. This is not more needed.
          // Also this code lead to some access denied notices in some stats.
          // if ( !mysql_select_db ( $db_name , $db_connection ) ) { $db_error = mysql_error(); die ( $db_error ); }
          //--------------------------
          $query_result = mysql_query ( $query , $db_connection );
          //--------------------------
          if ( !$query_result ) { $db_error = mysql_error(); die ( $db_error ); }
          //--------------------------
          if  ( $switch == 1 )
           {
            $db_number_rows = mysql_num_rows ( $query_result );
            while ( $db_temp = mysql_fetch_row ( $query_result ) )
             {
              for ( $db_temp_counter = 0 ; $db_temp_counter <= count ( $db_temp ) ; $db_temp_counter++ )
               {
                $db_entries [ $db_counter ] [ $db_temp_counter ] = $db_temp[ $db_temp_counter ];
               }
              $db_counter++;
             }
           }
          //--------------------------
          mysql_close( $db_connection );
          return $db_entries;
         }
        //--------------------------
       }
      //--------------------------
      include ( "config_db.php" );
      //--------------------------
      $query        = "SHOW TABLES LIKE '".$db_prefix."_main'";
      $result       = db_query ( $query , 1 , 0 );
      $table_exists = count ( $result );
      if ( $table_exists == 1 ) { }
      else { echo "<tr><td colspan=\"2\" class=\"bg2 warning\" style=\"height:130px; padding:10px 20px 10px 20px;\"><img src=\"../images/alert.gif\" border=\"0\" alt=\"\" title=\"\" style=\"margin:0px 20px 0px 0px;\"><font size=\"2\"><b>".$lang_db_prefix[3]."</b></font><br><br>".$lang_db_prefix[4]."<br><br><center><input type=\"button\" onclick=\"db_transfer();\" value=\"".$lang_db_prefix[5]."\"></center></td></tr>"; }
      echo "
      </table>
      </td>
    </tr>
    <tr>
      <td class=\"th2 center\"><input type=\"submit\" class=\"submit\" value=\"".$lang_admin_f[1]."\"></td>
    </tr>
    </table>
    <br>
    </div>";
   }
  //----------------------------------------
  /* module settings */
  echo "<div style=\"display:".$display_module.";\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_ms[1]."</th>
  </tr>
  <tr>
    <td class=\"th2 bold center\">".$lang_admin_ms[2]."</td>
  </tr>
  <tr>
    <td class=\"bg1\">
    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
    <tr>
      <td class=\"bg1\" style=\"width:50%;\">
      <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
      <tr><td class=\"bg2 center bold h28\">".$lang_admin_ms[3]."</td></tr>
      <tr><td class=\"bg2 h28\">".$lang_admin_ms[7]."</td></tr>
      <tr><td class=\"bg2 h28\">".$lang_admin_ms[8]."</td></tr>
      <tr><td class=\"bg2 h28\">".$lang_admin_ms[9]."</td></tr>
      <tr><td class=\"bg2 h28\">".$lang_admin_ms[10]."</td></tr>
      <tr><td class=\"bg2 h28\">".$lang_admin_ms[11]."</td></tr>
      <tr><td class=\"bg2 h28\">".$lang_admin_ms[12]."</td></tr>
      <tr><td class=\"bg2 h28\">".$lang_admin_ms[13]."</td></tr>
      <tr><td class=\"bg2 h28\">".$lang_admin_ms[14]."</td></tr>
      <tr><td class=\"bg2 h28\">".$lang_admin_ms[15]."</td></tr>
      <tr><td class=\"bg2 h28\">".$lang_admin_ms[16]."</td></tr>
      <tr><td class=\"bg2 h28\">".$lang_admin_ms[23]."</td></tr>
      <tr><td class=\"bg2 h28\">".$lang_admin_ms[17]."</td></tr>
      <tr><td class=\"bg2 h28\">".$lang_admin_ms[18]."</td></tr>
      <tr><td class=\"bg2 h28\">".$lang_admin_ms[19]."</td></tr>
      <tr><td class=\"bg2 h28\">".$lang_admin_ms[20]."</td></tr>
      <tr><td class=\"bg2 h28\">".$lang_admin_ms[21]."</td></tr>
      <tr><td class=\"bg2 h28\">".$lang_admin_ms[22]."</td></tr>
      </table>
      </td>
      <td class=\"bg1\">
      <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
      <tr>
        <td class=\"bg3 bold h28\" style=\"width:0%; padding-top:4px;\">".$lang_admin_ms[4]."</td>
        <td class=\"bg3 bold h28\" style=\"width:0%; padding-top:4px;\">".$lang_admin_ms[5]."</td>
        <td class=\"bg3 bold h28\" style=\"width:0%; padding-top:4px;\">".$lang_admin_ms[6]."</td>
      </tr>
      <tr>
        <td class=\"bg3 h28\" style=\"width:0%\"><div class=\"small\" style=\"padding-top:4px;\">FIXED</div></td>
        <td class=\"bg3 h28\" style=\"width:0%\"><input class=\"input\" type=\"text\" name=\"display_width_overview\" size=\"3\" value=\"".$display_width_overview."\"> <span class=\"small\">290</span></td>
        <td class=\"bg3 h28\" style=\"width:0%\"><div class=\"small\" style=\"padding-top:4px;\">FIXED</div></td>
      </tr>
      <tr>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input type=\"checkbox\" name=\"display_show_hour\" value=\"x\" ".checker($display_show_hour)."></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_width_hour\" size=\"3\" value=\"".$display_width_hour."\"> <span class=\"small\">290</span></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><div class=\"small\" style=\"padding-top:4px;\">FIXED</div></td>
      </tr>
      <tr>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input type=\"checkbox\" name=\"display_show_day\" value=\"x\" ".checker($display_show_day)."></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_width_day\" size=\"3\" value=\"".$display_width_day."\"> <span class=\"small\">290</span></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><div class=\"small\" style=\"padding-top:4px;\">FIXED</div></td>
      </tr>
      <tr>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input type=\"checkbox\" name=\"display_show_weekday\" value=\"x\" ".checker($display_show_weekday)."></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_width_weekday\" size=\"3\" value=\"".$display_width_weekday."\"> <span class=\"small\">300</span></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><div class=\"small\" style=\"padding-top:4px;\">FIXED</div></td>
      </tr>
      <tr>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input type=\"checkbox\" name=\"display_show_month\" value=\"x\" ".checker($display_show_month)."></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_width_month\" size=\"3\" value=\"".$display_width_month."\"> <span class=\"small\">300</span></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><div class=\"small\" style=\"padding-top:4px;\">FIXED</div></td>
      </tr>
      <tr>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input type=\"checkbox\" name=\"display_show_year\" value=\"x\" ".checker($display_show_year)."></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_width_year\" size=\"3\" value=\"".$display_width_year."\"> <span class=\"small\">300</span></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_count_year\" size=\"3\" value=\"".$display_count_year."\"></td>
      </tr>
      <tr>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input type=\"checkbox\" name=\"display_show_browser\" value=\"x\" ".checker($display_show_browser)."></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_width_browser\" size=\"3\" value=\"".$display_width_browser."\"> <span class=\"small\">490</span></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_count_browser\" size=\"3\" value=\"".$display_count_browser."\"></td>
      </tr>
      <tr>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input type=\"checkbox\" name=\"display_show_os\" value=\"x\" ".checker($display_show_os)."></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_width_os\" size=\"3\" value=\"".$display_width_os."\"> <span class=\"small\">490</span></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_count_os\" size=\"3\" value=\"".$display_count_os."\"></td>
      </tr>
      <tr>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input type=\"checkbox\" name=\"display_show_resolution\" value=\"x\" ".checker($display_show_resolution)."></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_width_resolution\" size=\"3\" value=\"".$display_width_resolution."\"> <span class=\"small\">400</span></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_count_resolution\" size=\"3\" value=\"".$display_count_resolution."\"></td>
      </tr>
      <tr>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input type=\"checkbox\" name=\"display_show_colordepth\" value=\"x\" ".checker($display_show_colordepth)."></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_width_colordepth\" size=\"3\" value=\"".$display_width_colordepth."\"> <span class=\"small\">400</span></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_count_colordepth\" size=\"3\" value=\"".$display_count_colordepth."\"></td>
      </tr>
      <tr>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input type=\"checkbox\" name=\"display_show_javascript_status\" value=\"x\" ".checker($display_show_javascript_status)."></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_width_javascript_status\" size=\"3\" value=\"".$display_width_javascript_status."\"> <span class=\"small\">400</span></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><div class=\"small\" style=\"padding-top:4px;\">FIXED</div></td>
      </tr>
      <tr>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input type=\"checkbox\" name=\"display_show_site\" value=\"x\" ".checker($display_show_site)."></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_width_site\" size=\"3\" value=\"".$display_width_site."\"> <span class=\"small\">700</span></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_count_site\" size=\"3\" value=\"".$display_count_site."\"></td>
      </tr>
      <tr>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input type=\"checkbox\" name=\"display_show_referer\" value=\"x\" ".checker($display_show_referer)."></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_width_referer\" size=\"3\" value=\"".$display_width_referer."\"> <span class=\"small\">800</span></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_count_referer\" size=\"3\" value=\"".$display_count_referer."\"></td>
      </tr>
      <tr>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input type=\"checkbox\" name=\"display_show_entrysite\" value=\"x\" ".checker($display_show_entrysite)."></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_width_entrysite\" size=\"3\" value=\"".$display_width_entrysite."\"> <span class=\"small\">700</span></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_count_entrysite\" size=\"3\" value=\"".$display_count_entrysite."\"></td>
      </tr>
      <tr>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input type=\"checkbox\" name=\"display_show_searchengines\" value=\"x\" ".checker($display_show_searchengines)."></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_width_searchengines\" size=\"3\" value=\"".$display_width_searchengines."\"> <span class=\"small\">410</span></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_count_searchengines\" size=\"3\" value=\"".$display_count_searchengines."\"></td>
      </tr>
      <tr>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input type=\"checkbox\" name=\"display_show_searchwords\" value=\"x\" ".checker($display_show_searchwords)."></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_width_searchwords\" size=\"3\" value=\"".$display_width_searchwords."\"> <span class=\"small\">480</span></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_count_searchwords\" size=\"3\" value=\"".$display_count_searchwords."\"></td>
      </tr>
      <tr>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input type=\"checkbox\" name=\"display_show_cc\" value=\"x\" ".checker($display_show_cc)."></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_width_cc\" size=\"3\" value=\"".$display_width_cc."\"> <span class=\"small\">500</span></td>
        <td class=\"bg3 h28\" style=\"width:0%;\"><input class=\"input\" type=\"text\" name=\"display_count_cc\" size=\"3\" value=\"".$display_count_cc."\"></td>
      </tr>
      </table>
      </td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td class=\"th2 center\"><input type=\"submit\" class=\"submit\" value=\"".$lang_admin_f[1]."\"></td>
  </tr>
  </table>
  <br>
  </div>";
  //----------------------------------------
  /* pattern site name */
  echo "<div style=\"display:".$display_edit_site_name.";\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_pe[1]."</th>
  </tr>
  <tr>
    <td class=\"th2 bold center\">".$lang_admin_pe[2]."</td>
  </tr>
  <tr>
    <td class=\"bg1\" style=\"padding:4px;\">
    ".$lang_admin_pe[3]."
    </td>
  </tr>
  <tr>
    <td class=\"bg1\">
    <iframe name=\"edit_site_name\" src=\"edit_site_name.php\" style=\"width:100%; height:460px;\" frameborder=\"0\" scrolling=\"no\">Sorry but your browser does not support iframes</iframe>
    </td>
  </tr>
  </table>
  <br>
  </div>";
  //----------------------------------------
  /* pattern replace */
  echo "<div style=\"display:".$display_edit_string_replace.";\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_re[1]."</th>
  </tr>
  <tr>
    <td class=\"th2 bold center\">".$lang_admin_re[2]."</td>
  </tr>
  <tr>
    <td class=\"bg1\" style=\"padding:4px;\">
    ".$lang_admin_re[3]."
    </td>
  </tr>
  <tr>
    <td class=\"bg1\">
    <iframe name=\"edit_string_replace\" src=\"edit_string_replace.php\" style=\"width:100%; height:460px;\" frameborder=\"0\" scrolling=\"no\">Sorry but your browser does not support iframes</iframe>
    </td>
  </tr>
  </table>
  <br>
  </div>";
  //----------------------------------------
  /* counter settings */
  echo "<div style=\"display:".$display_counter.";\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_cs[1]."</th>
  </tr>
  <tr>
    <td class=\"th2 bold center\">".$lang_admin_cs[2]."</td>
  </tr>
  <tr>
    <td class=\"bg1\">
    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
    <tr>
      <td class=\"bg2 center bold\">".$lang_admin_cs[3]."</td>
      <td class=\"bg3 bold\" style=\"padding-top:4px;\">".$lang_admin_cs[4]."</td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_cs_d[1]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"counter_display_show_visitors_online\" value=\"x\" ".checker($counter_display_show_visitors_online)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_cs_d[2]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"counter_display_show_today\" value=\"x\" ".checker($counter_display_show_today)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_cs_d[3]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"counter_display_show_yesterday\" value=\"x\" ".checker($counter_display_show_yesterday)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_cs_d[4]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"counter_display_show_this_month\" value=\"x\" ".checker($counter_display_show_this_month)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_cs_d[5]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"counter_display_show_last_month\" value=\"x\" ".checker($counter_display_show_last_month)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_cs_d[6]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"counter_display_show_max\" value=\"x\" ".checker($counter_display_show_max)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_cs_d[7]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"counter_display_show_average\" value=\"x\" ".checker($counter_display_show_average)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_cs_d[8]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"counter_display_show_total\" value=\"x\" ".checker($counter_display_show_total)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_cs_d[9]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"counter_display_show_footer\" value=\"x\" ".checker($counter_display_show_footer)."></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_cs_d[10]."<br><div class=\"small\">".$lang_admin_cs_d[11]."</div></td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"counter_display_show_footer_ticker\" value=\"x\" ".checker($counter_display_show_footer_ticker)." disabled=\"disabled\"></td>
    </tr>
    <tr>
      <td class=\"bg2\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$lang_admin_cs_d[12]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"counter_display_show_footer_info1\" value=\"x\" ".checker($counter_display_show_footer_info1)." disabled=\"disabled\"></td>
    </tr>
    <tr>
      <td class=\"bg2\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$lang_admin_cs_d[13]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"counter_display_show_footer_info2\" value=\"x\" ".checker($counter_display_show_footer_info2)." disabled=\"disabled\"></td>
    </tr>
    <tr>
      <td class=\"bg2\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$lang_admin_cs_d[14]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"counter_display_show_footer_info3\" value=\"x\" ".checker($counter_display_show_footer_info3)." disabled=\"disabled\"></td>
    </tr>
    <tr>
      <td class=\"bg2\"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$lang_admin_cs_d[15]."</td>
      <td class=\"bg3\"><input type=\"checkbox\" name=\"counter_display_show_footer_info4\" value=\"x\" ".checker($counter_display_show_footer_info4)." disabled=\"disabled\"></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td class=\"th2 bold center\">".$lang_admin_cs_s[1]."</td>
  </tr>
  <tr>
    <td class=\"bg1\">
    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
    <tr>
      <td class=\"bg2\">".$lang_admin_cs_s[2]."<br><div class=\"small\">".$lang_admin_cs_s[3]."</div></td>
      <td class=\"bg3\"><input class=\"input\" type=\"text\" name=\"online_recount_time\" size=\"3\" value=\"".$online_recount_time."\"></td>
    </tr>
    <tr>
      <td class=\"bg2\">".$lang_admin_cs_s[4]."<br><div class=\"small\">".$lang_admin_cs_s[5]."</div></td>
      <td class=\"bg3\"><input class=\"input\" type=\"text\" name=\"counter_add_visitors\" size=\"6\" value=\"".$counter_add_visitors."\"></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td class=\"th2 center\"><input type=\"submit\" class=\"submit\" value=\"".$lang_admin_f[1]."\"></td>
  </tr>
  </table>
  <br>
  </div>";
  //----------------------------------------
  /* cache panel */
  echo "<div style=\"display:".$display_del_cache.";\">
  ".$lang_admin_dc[2]." <a href=\"../cache_panel.php\" target=\"_blank\">".$lang_admin_dc[3]."</a>.
  <br>
  </div>";
  //----------------------------------------
  /* delete archive cache */
  echo "<div style=\"display:".$display_del_archive_cache.";\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_dac[1]."</th>
  </tr>
  <tr>
    <td class=\"bg1\" style=\"padding:4px;\">
    ".$lang_admin_dac[2]."
    </td>
  </tr>
  </table>
  <br>
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <td class=\"bg1\">
    <iframe name=\"delete_archive\" src=\"delete_archive.php\" style=\"width:100%; height:140px;\" frameborder=\"0\" scrolling=\"no\">Sorry but your browser does not support iframes</iframe>
    </td>
  </tr>
  </table>
  <br>
  </div>";
  //----------------------------------------
  /* create index */
  echo "<div style=\"display:".$display_del_index.";\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_ci[1]."</th>
  </tr>
  <tr>
    <td class=\"bg1\" style=\"padding:4px;\">
    ".$lang_admin_ci[2]."
    </td>
  </tr>
  </table>
  <br>
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <td class=\"bg1\">
    <iframe name=\"create_index\" src=\"delete_index.php\" style=\"width:100%; height:140px;\" frameborder=\"0\" scrolling=\"no\">Sorry but your browser does not support iframes</iframe>
    </td>
  </tr>
  </table>
  <br>
  </div>";
  //----------------------------------------
    /* repair */
  echo "<div style=\"display:".$display_repair.";\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_lr[1]."</th>
  </tr>
  <tr>
    <td class=\"bg1\" style=\"padding:4px;\">
    ".$lang_admin_lr[2]."
    </td>
  </tr>
  </table>
  <br>
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
  <tr>
    <td class=\"bg1\">
    <iframe name=\"repair\" src=\"repair.php\" style=\"width:100%; height:500px;\" frameborder=\"0\" scrolling=\"no\">Sorry but your browser does not support iframes</iframe>
    </td>
  </tr>
  </table>
  </div>";
  //----------------------------------------
  /* maintenance mode */
  echo "<div style=\"display:".$display_maintenance_mode.";\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_mm[1]."</th>
  </tr>
  <tr>
    <td class=\"bg1\" style=\"padding:4px;\">
    ".$lang_admin_mm[2]."
    </td>
  </tr>
  </table>
  <br>
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <td class=\"th2 bold center\">".$lang_admin_mm[3]."</td>
  </tr>
  <tr>
    <td class=\"bg1\">
    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">
    <tr>
      <td class=\"bg2\">".$lang_admin_mm[4]."<br><div class=\"small\">".$lang_admin_mm[5]."</div></td>
      <td class=\"bg3\"><select name=\"script_activity\" size=\"1\" style=\"width:250px;\"><option value=\"1\" ".selecter_activity("1")."> ".$lang_admin_mm[6]." <option value=\"0\" ".selecter_activity("0")."> ".$lang_admin_mm[1]."</select></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td class=\"th2 center\"><input type=\"submit\" class=\"submit\" value=\"".$lang_admin_mm[7]."\"></td>
  </tr>
  </table>
  <br>
  </div>";
  //----------------------------------------
  /* backup */
  echo "<div style=\"display:".$display_backup.";\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_cb[1]."</th>
  </tr>
  <tr>
    <td class=\"bg1\" style=\"padding:4px;\">
    ".$lang_admin_cb[2]."
    </td>
  </tr>
  </table>
  <br>
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <td class=\"bg1\">
    <iframe name=\"backup\" src=\"backup.php\" style=\"width:100%; height:200px;\" frameborder=\"0\" scrolling=\"no\">Sorry but your browser does not support iframes</iframe>
    </td>
  </tr>
  </table>
  <br>
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <td class=\"bg1\">
    <iframe name=\"delete_backup\" src=\"delete_backup.php\" style=\"width:100%; height:120px;\" frameborder=\"0\" scrolling=\"no\">Sorry but your browser does not support iframes</iframe>
    </td>
  </tr>
  </table>
  <br>
  </div>";
  //----------------------------------------
  /* restart */
  echo "<div style=\"display:".$display_restart.";\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_sr[1]."</th>
  </tr>
  <tr>
    <td class=\"bg1\">
    <iframe name=\"restart\" src=\"reset.php\" style=\"width:100%; height:250px;\" frameborder=\"0\" scrolling=\"no\">Sorry but your browser does not support iframes</iframe>
    </td>
  </tr>
  </table>
  <br>
  </div>";
  //----------------------------------------
  /* db_editor */
  if ( $db_active == 1 )
   {
    echo "<div style=\"display:".$display_db_edit.";\">
    <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
    <tr>
      <th>".$lang_admin_db_e[1]."</th>
    </tr>
    <tr>
      <td class=\"bg1 warning\" style=\"padding:4px;\">".$lang_admin_db_e[2]."<br>".$lang_admin_db_e[3]."</td>
    </tr>
    <tr>
      <td class=\"bg1\">
      <iframe name=\"db_editor\" src=\"edit_db.php\" style=\"width:100%; height:170px;\" frameborder=\"0\" scrolling=\"no\">Sorry but your browser does not support iframes</iframe>
      </td>
    </tr>
    </table>
    <br>
    </div>";
   }
  //----------------------------------------
  /* css editor */
  echo "<div style=\"display:".$display_css_edit.";\">
  <ul id=\"tablist2\">
    <li id=\"button_stat\" onclick=\"changeToTab2('stat'); return false;\">&nbsp;".$lang_admin_ce[2]."&nbsp;</li>
    <li id=\"button_counter\" onclick=\"changeToTab2('counter'); return false;\">&nbsp;".$lang_admin_ce[3]."&nbsp;</li>
    <li id=\"button_admin\" onclick=\"changeToTab2('admin'); return false;\">&nbsp;".$lang_admin_ce[4]."&nbsp;</li>
    <li id=\"button_print\" onclick=\"changeToTab2('print'); return false;\">&nbsp;".$lang_admin_ce[5]."&nbsp;</li>
  </ul>
  <div class=\"section2\" id=\"tab2_stat\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th style=\"border-left:none;\">".$lang_admin_ce[1]."</th>
  </tr>
  <tr>
    <td class=\"bg1\" style=\"padding:4px;\">
    ".$lang_admin_ce[6]."<br>".$lang_admin_ce[7]."
    </td>
  </tr>
  <tr>
    <td class=\"th2 bold center\">../".$theme."style.css</td>
  </tr>
  <tr>
    <td class=\"bg1\">
    <iframe name=\"edit_stat_css\" src=\"edit_css.php?action=stat\" style=\"width:100%; height:440px;\" frameborder=\"0\" scrolling=\"no\">Sorry but your browser does not support iframes</iframe>
    </td>
  </tr>
  </table>
  </div>
  <div class=\"section2\" id=\"tab2_counter\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_ce[1]."</th>
  </tr>
  <tr>
    <td class=\"bg1\" style=\"padding:4px;\">
    ".$lang_admin_ce[6]."<br>".$lang_admin_ce[7]."
    </td>
  </tr>
  <tr>
    <td class=\"th2 bold center\">../".$theme."counter.css</td>
  </tr>
  <tr>
    <td class=\"bg1\">
    <iframe name=\"edit_counter_css\" src=\"edit_css.php?action=counter\" style=\"width:100%; height:440px;\" frameborder=\"0\" scrolling=\"no\">Sorry but your browser does not support iframes</iframe>
    </td>
  </tr>
  </table>
  </div>
  <div class=\"section2\" id=\"tab2_admin\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_ce[1]."</th>
  </tr>
  <tr>
    <td class=\"bg1\" style=\"padding:4px;\">
    ".$lang_admin_ce[6]."
    </td>
  </tr>
  <tr>
    <td class=\"th2 bold center\">../themes/admin.css</td>
  </tr>
  <tr>
    <td class=\"bg1\">
    <iframe name=\"edit_admin_css\" src=\"edit_css.php?action=admin\" style=\"width:100%; height:440px;\" frameborder=\"0\" scrolling=\"no\">Sorry but your browser does not support iframes</iframe>
    </td>
  </tr>
  </table>
  </div>
  <div class=\"section2\" id=\"tab2_print\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_ce[1]."</th>
  </tr>
  <tr>
    <td class=\"bg1\" style=\"padding:4px;\">
    ".$lang_admin_ce[6]."
    </td>
  </tr>
  <tr>
    <td class=\"th2 bold center\">../themes/print.css</td>
  </tr>
  <tr>
    <td class=\"bg1\">
    <iframe name=\"edit_print_css\" src=\"edit_css.php?action=print\" style=\"width:100%; height:440px;\" frameborder=\"0\" scrolling=\"no\">Sorry but your browser does not support iframes</iframe>
    </td>
  </tr>
  </table>
  </div>
  <br>
  </div>";
  //----------------------------------------
  /* file version */
  echo "<div style=\"display:".$display_file_version.";\">
  <table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
  <tr>
    <th>".$lang_admin_lm[4]."</th>
  </tr>
  <tr>
    <td class=\"th2 bold center\">".$lang_admin_fv[2]."</td>
  </tr>
  <tr>
    <td class=\"bg1\" style=\"padding:4px;\">
    <script language=\"JavaScript\" type=\"text/javascript\">
    <!-- //hide from dinosaurs
    document.write('".$lang_admin_i_vi[2]." <b>".$version_number.$revision_number."</b><br />');
    if (!STABLE)
     {
      document.write('".$lang_admin_i_vi[4]." <b>".$lang_admin_i_vi[3]."</b><br />');
      document.write('".$lang_admin_i_vi[5]." <b>".$lang_admin_i_vi[3]."</b><br />');
     }
    else
     {
      document.write('".$lang_admin_i_vi[4]." <b>'+STABLE+'</b><br />');
      document.write('".$lang_admin_i_vi[5]." <b>'+BETA+'</b><br />');
     }
    // -->
    </script>
    <noscript>".$lang_admin_i_vi[10]."</noscript>
    </td>
  <tr>
    <td class=\"bg1\">
    <iframe name=\"file_version\" src=\"file_version.php\" style=\"width:100%; height:450;\" frameborder=\"0\" scrolling=\"auto\">Sorry but your browser does not support iframes</iframe>
    </td>
  </tr>
  </table>
  <br>
  </div>";
  //----------------------------------------
echo "<script type=\"text/javascript\" language=\"javascript\"> setclass('".$class."') </script>";
echo "</div>\n";
//------------------------------------------------------------------------------
echo '<script type="text/javascript">
<!--
var digital = new Date("'.strftime("%b, %d %Y %H:%M:%S").'");

function clock() {
  if (!document.all && !document.getElementById) return;
  var day = digital.getDate();
  var month = digital.getMonth() + 1;
  var year = digital.getFullYear();
  var hours = digital.getHours();
  var minutes = digital.getMinutes();
  var seconds = digital.getSeconds();
  digital.setSeconds( seconds+1 );
  if (day <= 9) day = "0" + day;
  if (month <= 9) month = "0" + month;
  if (hours <= 9) hours = "0" + hours;
  if (minutes <= 9) minutes = "0" + minutes;
  if (seconds <= 9) seconds = "0" + seconds;
  dispTime = hours + ":" + minutes + ":" + seconds;
  if (document.getElementById)
    document.getElementById("time").innerHTML = dispTime;
  else if (document.all)
    time.innerHTML = dispTime;
  setTimeout("clock()", 1000);
}

function getElementsByClass(searchClass,node,tag) {
  var classElements = new Array();
  if ( node == null )
    node = document;
  if ( tag == null )
    tag = \'*\';
  var els = node.getElementsByTagName(tag);
  var elsLen = els.length;
  var pattern = new RegExp(\'(^|\s)\'+searchClass+\'(\s|$)\');
  for (i = 0, j = 0; i < elsLen; i++) {
    if ( pattern.test(els[i].className) ) {
      classElements[j] = els[i];
      j++;
    }
  }
  return classElements;
}

function changeToTab(tab) {
  var elements = getElementsByClass(\'section\');
  var i;
  for(i = 0; i < elements.length; i++) {
    if(elements[i].id == \'tab_\' + tab) {
      elements[i].style.display = \'\';
    }
    else {
      elements[i].style.display = \'none\';
    }
  }
  var elm = getElementsByClass(\'curtab1\')[0];
  if(elm) {
    elm.className = \'\';
  }
  document.getElementById(\'button_\' + tab).className = \'curtab1\';
}
var removables = getElementsByClass(\'js_remove_me\');
var i;
for(i = 0; i < removables.length; i++) {
  removables[i].innerHTML = \'\';
}
changeToTab(\'general\'); // Focus default tab

function changeToTab2(tab2) {
  var elements = getElementsByClass(\'section2\');
  var i;
  for(i = 0; i < elements.length; i++) {
    if(elements[i].id == \'tab2_\' + tab2) {
      elements[i].style.display = \'\';
    }
    else {
      elements[i].style.display = \'none\';
    }
  }
  var elm = getElementsByClass(\'curtab2\')[0];
  if(elm) {
    elm.className = \'\';
  }
  document.getElementById(\'button_\' + tab2).className = \'curtab2\';
}
var removables = getElementsByClass(\'js_remove_me\');
var i;
for(i = 0; i < removables.length; i++) {
  removables[i].innerHTML = \'\';
}
changeToTab2(\'stat\'); // Focus default tab2

function checkDependent(eid) {
  var elm = document.getElementsByName(eid)[0];

  if (eid == "autologout_time" && (document.getElementsByName("autologout")[0].checked)) {
			elm.disabled = false;
		} else if (eid == "autologout_time") {
			elm.disabled = true;
		}

  if (eid == "counter_display_show_footer_ticker" && (document.getElementsByName("counter_display_show_footer")[0].checked)) {
    elm.disabled = false;
  } else if (eid == "counter_display_show_footer_ticker") {
    elm.disabled = true;
  }

  if (eid == "counter_display_show_footer_info1" && (document.getElementsByName("counter_display_show_footer_ticker")[0].checked && document.getElementsByName("counter_display_show_footer")[0].checked)) {
    elm.disabled = false;
  } else if (eid == "counter_display_show_footer_info1") {
    elm.disabled = true;
  }

  if (eid == "counter_display_show_footer_info2" && (document.getElementsByName("counter_display_show_footer_ticker")[0].checked && document.getElementsByName("counter_display_show_footer")[0].checked)) {
    elm.disabled = false;
  } else if (eid == "counter_display_show_footer_info2") {
    elm.disabled = true;
  }

  if (eid == "counter_display_show_footer_info3" && (document.getElementsByName("counter_display_show_footer_ticker")[0].checked && document.getElementsByName("counter_display_show_footer")[0].checked)) {
    elm.disabled = false;
  } else if (eid == "counter_display_show_footer_info3") {
    elm.disabled = true;
  }

  if (eid == "counter_display_show_footer_info4" && (document.getElementsByName("counter_display_show_footer_ticker")[0].checked && document.getElementsByName("counter_display_show_footer")[0].checked)) {
    elm.disabled = false;
  } else if (eid == "counter_display_show_footer_info4") {
    elm.disabled = true;
  }

  if (eid == "show_last_hits" && (!document.getElementsByName("loginpassword_ask")[0].checked)) {
    elm.disabled = false;
  } else if (eid == "show_last_hits") {
    elm.disabled = true;
  }
}

function handleDependent_autologout() {
  var isChecked = document.getElementsByName("autologout")[0].checked;
  var itemValue = document.getElementsByName("autologout")[0].value;
  checkDependent("autologout_time");
  };

document.getElementsByName("autologout")[0].onclick = handleDependent_autologout;
document.getElementsByName("autologout")[0].onkeyup = handleDependent_autologout;

function handleDependent_counter_display_show_footer() {
  var isChecked = document.getElementsByName("counter_display_show_footer")[0].checked;
  var itemValue = document.getElementsByName("counter_display_show_footer")[0].value;
  checkDependent("counter_display_show_footer_ticker");
  checkDependent("counter_display_show_footer_info1");
  checkDependent("counter_display_show_footer_info2");
  checkDependent("counter_display_show_footer_info3");
  checkDependent("counter_display_show_footer_info4");
  };

document.getElementsByName("counter_display_show_footer")[0].onclick = handleDependent_counter_display_show_footer;
document.getElementsByName("counter_display_show_footer")[0].onkeyup = handleDependent_counter_display_show_footer;

function handleDependent_counter_display_show_footer_ticker() {
  var isChecked = document.getElementsByName("counter_display_show_footer_ticker")[0].checked;
  var itemValue = document.getElementsByName("counter_display_show_footer_ticker")[0].value;
  checkDependent("counter_display_show_footer_info1");
  checkDependent("counter_display_show_footer_info2");
  checkDependent("counter_display_show_footer_info3");
  checkDependent("counter_display_show_footer_info4");
  };

document.getElementsByName("counter_display_show_footer_ticker")[0].onclick = handleDependent_counter_display_show_footer_ticker;
document.getElementsByName("counter_display_show_footer_ticker")[0].onkeyup = handleDependent_counter_display_show_footer_ticker;

function handleDependent_loginpassword_ask() {
  var isChecked = document.getElementsByName("loginpassword_ask")[0].checked;
  var itemValue = document.getElementsByName("loginpassword_ask")[0].value;
  checkDependent("show_last_hits");
  };

document.getElementsByName("loginpassword_ask")[0].onclick = handleDependent_loginpassword_ask;
document.getElementsByName("loginpassword_ask")[0].onkeyup = handleDependent_loginpassword_ask;

function undisableAll(node) {
  var elements = document.getElementsByTagName("input");
  for(var i = 0; i < elements.length; i++) {
    elements[i].disabled = false;
  }
  var elements = document.getElementsByTagName("textarea");
  for(var i = 0; i < elements.length; i++) {
    elements[i].disabled = false;
  }
  var elements = document.getElementsByTagName("select");
  for(var i = 0; i < elements.length; i++) {
    elements[i].disabled = false;
  }
}

window.onload = function(){ clock(); handleDependent_autologout(); handleDependent_counter_display_show_footer(); handleDependent_counter_display_show_footer_ticker(); handleDependent_loginpassword_ask(); };

// -->
</script>
';
//------------------------------------------------------------------------------
$_SESSION [ "hidden_admin" ] = md5 ( time ( ) );
$_SESSION [ "hidden_func"  ] = md5_file ( "config.php" );
$_SESSION [ "hidden_stat"  ] = md5_file ( "config.php" );
echo "<input type=\"hidden\" name=\"hidden_admin\" value=\"".$_SESSION [ "hidden_admin" ]."\">\n";
echo "<input type=\"hidden\" name=\"lang\" value=\"".$lang."\">\n";
echo "</form>\n";
echo "</body>\n";
echo "</html>\n";
//------------------------------------------------------------------------------
?>