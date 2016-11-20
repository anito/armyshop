<?php header ( "Cache-Control: no-cache, must-revalidate" ); header ( "Expires: Sat, 26 Jul 2000 05:00:00 GMT" );
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.9.x                                                    #
# File-Release-Date:  15/09/07                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2015 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
error_reporting(0);
//------------------------------------------------------------------------------
clearstatcache(); // empty the filecache to get the real live data
//------------------------------------------------------------------------------
include ( "config/config.php" ); // include path to logfile
//------------------------------------------------------------------------------
if ( $_COOKIE [ "dontcount" ] ) { exit; }
//------------------------------------------------------------------------------
if ( $script_activity != 1 ) { exit; } // if stat is set to maintenance mode
//------------------------------------------------------------------------------
if ( $db_active == 1 )
 {
  include ( "config/config_db.php" ); // include db prefix
  include ( "db_connect.php"       ); // include database connection
 }
################################################################################
### get ip address ###
    if ( $get_ip_address == 1 )  { $ip_address = $_SERVER [ "REMOTE_ADDR"            ]; }
elseif ( $get_ip_address == 2 )  { $ip_address = $_SERVER [ "HTTP_X_REMOTECLIENT_IP" ]; }
elseif ( $get_ip_address == 3 )  { $ip_address = $_SERVER [ "HTTP_X_FORWARDED_FOR"   ]; }
elseif ( $get_ip_address == 4 )  { $ip_address = $_SERVER [ "HTTP_CLIENT_IP"         ]; }
elseif ( $get_ip_address == 5 )  { $ip_address = getenv   ( "REMOTE_ADDR"            ); }
elseif ( $get_ip_address == 6 )  { $ip_address = getenv   ( "HTTP_X_REMOTECLIENT_IP" ); }
elseif ( $get_ip_address == 7 )  { $ip_address = getenv   ( "HTTP_X_FORWARDED_FOR"   ); }
elseif ( $get_ip_address == 8 )  { $ip_address = getenv   ( "HTTP_CLIENT_IP"         ); }
  else { $ip_address = $_SERVER [ "REMOTE_ADDR" ]; }
//------------------------------------------------------------------------------
// check for ip-address exclude
if ( strpos ( $ip_address , ":" ) > 0 ) // ipv6
 {
  // ipv6 detection will be included in future versions
 }
else // ipv4
 {
  for ( $x = 0 ; $x < count ( $exception_ip_addresses ) ; $x++ )
   {
    $ip_pattern = preg_replace( "/\./" , "\." , $exception_ip_addresses [ $x ] );
    $ip_pattern = preg_replace( "/\*/" , ".*" , $ip_pattern );
    if ( preg_match ( "/".$ip_pattern."/" , $ip_address ) ) { exit; }
   }
 }
unset ( $ip_pattern );
//------------------------------------------------------------------------------
### check tracking mode ###
//------------------------------------------------------------------------------
// if javascript tracking
if ( $_GET [ 'mode' ] == "js" )
 {
  //------------------------------------------------------------------
  // SSL Fix by www.ct-designs.de
  if ( $_SERVER [ "HTTPS" ] == "on" ) { $script_domain = str_replace ( "http:" , "https:" , $script_domain ); }
  //------------------------------------------------------------------
  foreach ( $exception_domain as $value ) // check if the call comes from within
   {
    $arrUrl = parse_url ( strtolower ( $_SERVER [ "HTTP_REFERER" ] ) );
    if ( preg_match ("/\.".strtolower ( $value )."$/", ".".$arrUrl [ "host" ] ) )
     {
      header("content-type: text/javascript"); // send javascript to browser
      if ( $frames == 0 ) { echo "f='' + escape(document.referrer);";     }
      if ( $frames == 1 ) { echo "f='' + escape(top.document.referrer);"; }
      echo "\nw=screen.width;\nh=screen.height;\nv=navigator.appName;\n";
      echo "if (v != 'Netscape') {var c=screen.colorDepth;}\nelse {var c=screen.pixelDepth;}\n";
      echo 'jsinfo = "'.$script_domain.'/'.$script_path.'track.php?js_resolution=" + w + "x" + h + "&js_referer=" + f + "&js_color=" + c + "&js_url=" + escape(document.URL);';
      echo "\ntry {\nvar script = document.createElementNS('http://www.w3.org/1999/xhtml','script');\n";
      echo "script.setAttribute('type', 'text/javascript');\n";
      echo "script.setAttribute('src', jsinfo);\n";
      echo "document.getElementsByTagName('body')[0].appendChild(script);\n";
      echo "}\ncatch(e) {\n";
      echo 'str = "<script type=\"text/javascript\" src=\""+jsinfo+"\"></script>"';
      echo "\n".'document.write(str+""); }';
      exit;
     }
   }
  exit;
  //------------------------------------------------------------------
 }
//------------------------------------------------------------------------------
// if image tracking
if ( $_GET [ "mode" ] == "img" )
 {
  //------------------------------------------------------------------
  $found = 0;
  $url_complete = $_SERVER [ "HTTP_REFERER" ];

  // check if the call comes from within
  $arrUrl = parse_url ( strtolower ( $url_complete ) );
	foreach ( $exception_domain as $value ) { if ( preg_match ("/\.".strtolower ( $value )."$/", ".".$arrUrl [ "host" ] ) ) { $found = 1; } }

  // if the call does not come from within
  if ( $found == 0 ) { exit; }

  // if the script was called directly
  if ( basename ( $_SERVER [ "HTTP_REFERER" ] ) == basename(__FILE__) ) { exit; }
  //------------------------------------------------------------------
 }
else
 { if ( ( strpos ( strtolower ( $_SERVER [ "PHP_SELF" ] ) , "track.php" ) > 0 ) && ( !$_GET [ "js_url" ] ) ) { exit; } }
################################################################################
### if no cookie and no javascript, go on ###
//------------------------------------------------------------------
function track_kill_chars ( $value )
 {
  $search_pattern [ ] = '/\|/';
  $search_pattern [ ] = '/\%7C/';
  $search_pattern [ ] = '/\%7c/';
  $search_pattern [ ] = '/\$/';
  $search_pattern [ ] = '/\[/';
  $search_pattern [ ] = '/\]/';
  $search_pattern [ ] = '/\%5B/';
  $search_pattern [ ] = '/\%5D/';
  $search_pattern [ ] = '/\%24/';
  return preg_replace ( $search_pattern , '' , addslashes ( strip_tags ( $value ) ) );
 }
//------------------------------------------------------------------
$js_resolution = track_kill_chars ( $_GET [ "js_resolution" ] );
$js_color      = track_kill_chars ( $_GET [ "js_color"      ] );
//------------------------------------------------------------------
if ( $_GET [ "mode" ] == "img" )
 {
  #$js_referer = "";
  $js_referer = track_kill_chars ( urldecode ( $_GET [ "ref" ] ) );
  $js_url     = track_kill_chars ( $url_complete );
 }
else
 {
  $js_referer = track_kill_chars ( $_GET [ "js_referer" ] );
  $js_url     = track_kill_chars ( $_GET [ "js_url"     ] );
 }
//------------------------------------------------------------------
// check for referer exclude
if ( trim ( $js_referer ) != "" )
 {
  $referer_original = $js_referer;
 }
if ( isset ( $referer_original ) && isset ( $block_referer ) )
 {
  //--------------------------------------------
  if ( ( trim ( $referer_original ) != '' ) && ( $block_referer != '' ) )
   {
    $temp_block_referer = strtolower ( parse_url ( $referer_original , PHP_URL_HOST ) );

    foreach ( $block_referer as $value )
     {
      if ( strpos ( $temp_block_referer , strtolower ( $value ) ) !== FALSE )
       {
        exit;
       }
     }
     unset ( $value );
     unset ( $temp_block_referer );
   }
  //--------------------------------------------
 }
unset ( $referer_original );
//------------------------------------------------------------------
// check for bot exclude
if ( isset ( $block_bots ) )
 {
  foreach ( $block_bots as $value )
   {
    if ( strpos ( strtolower ( $_SERVER [ "HTTP_USER_AGENT" ] ) , strtolower ( $value ) ) !== FALSE )
     {
      exit;
     }
   }
   unset ( $value );
 }
//------------------------------------------------------------------
if ( ( strpos ( strtolower ( $js_referer ) , "images.google"  ) !== false ) && ( $google_images == 0 ) ) { exit; } // exit if google image search
if ( ( strpos ( strtolower ( $js_referer ) , "gclid"          ) !== false ) && ( $google_adwords == 0 ) ) { exit; } // exit if google adwords referer
if ( strpos ( strtolower ( $js_url     ) , "searchindex.html" ) !== false ) { exit; } // exit if google cache
if ( strpos ( strtolower ( $js_url     ) , "translate_cindex" ) !== false ) { exit; } // exit if google translate
if ( strpos ( strtolower ( $js_url     ) , "cseindex.htm"     ) !== false ) { exit; } // exit if google custom search
####################################################################
### country detection ###
require_once ( 'func/func_geoip.inc' );
if ( strpos ( $ip_address , ':' ) > 0 ) // ipv6
 {
  $temp_ipv6 = geoip_open ( 'func/geoip/GeoIPv6.dat' , GEOIP_STANDARD );
  $country = geoip_country_code_by_addr_v6 ( $temp_ipv6 , $ip_address );
  geoip_close ( $temp_ipv6 );
 }
else // ipv4
 {
  $temp_ipv4 = geoip_open ( 'func/geoip/GeoIP.dat' , GEOIP_STANDARD );
  $country = geoip_country_code_by_addr ( $temp_ipv4 , $ip_address );
  geoip_close ( $temp_ipv4 );
 }
if ( $country != '' ) { $country = strtolower ( $country ); }
####################################################################
### sitename detection ###
//------------------------------------------------------------------
include ( "func/func_pattern_matching.php" ); // include pattern maching detection
//------------------------------------------------------------------
// convert all slashes ('/') after the first ? to '%2F'
// Fix by hr3
function convert_slashes ( $value )
 {
  if ( strpos ( $value , "?" ) == FALSE ) { return $value; }
  else { return substr ( $value , 0 , strpos ( $value , "?" ) ).str_replace ( "/" , "%2F" , substr ( $value , strpos ( $value , "?" ) ) ); }
 }

 $js_url     = convert_slashes ( $js_url     );
 $js_referer = convert_slashes ( $js_referer );
//------------------------------------------------------------------
$temp_site_name   = substr ( strstr ( substr ( $js_url , 7 ) , "/" ) , 1 );
if ( substr ( $temp_site_name , 0 , 1 ) == "?" ) { $temp_site_name = $home_site_name.$temp_site_name; }
$temp_url = parse_url ( $js_url );
parse_str ( $temp_url [ "query" ] , $temp_parameter );
$temp_check_name_value = 0;
if ( dirname ( $temp_site_name ) != "." ) { $temp_dir_name = dirname ( $temp_site_name )."/"; }
else { $temp_dir_name = substr ( dirname ( $temp_site_name ) , 1 ); }
$temp_name = $temp_dir_name.substr ( basename ( $js_url ) , 0 , strpos ( basename ( $js_url ) , "?" ) );
foreach ( $temp_parameter as $key=>$value )
 {
  if ( in_array ( $key , $url_parameter ) )
   {
    $temp_check_name.= $key."=".$value."&";
    $temp_check_name_value = 1;
   }
 }
if ( $temp_check_name_value == 1 )
 {
  $temp_check_name = $temp_name."?".substr ( $temp_check_name , 0 , strlen ( $temp_check_name ) - 1 );
  $site_name = pattern_matching ( "site_name" , $temp_check_name ); // check site name
 }
if ( $temp_check_name_value == 0 )
 {
  if ( strpos ( $temp_site_name , "?" ) > 0 ) { $temp_site_name = substr ( $temp_site_name , 0 , strpos ( $temp_site_name , "?" ) ); }
  if ( strpos ( $temp_site_name , "." ) === FALSE ) { $temp_site_name = $temp_site_name.$home_site_name; }
  $site_name = pattern_matching ( "site_name" , $temp_site_name ); // check site name
 }
unset ( $temp_url ); unset ( $temp_parameter ); unset ( $temp_name ); unset ( $temp_site_name ); unset ( $temp_check_name ); unset ( $temp_check_name_value );
####################################################################
### referer detection ###
$inside_referer = 0;
foreach ( $exception_domain as $value_referer )
 {
  if ( strpos ( substr ( $js_referer , 0 , strpos ( $js_referer."/" , "/" , 7 ) ) , $value_referer ) !== FALSE )
   {
    $temp_site_name   = substr ( strstr ( substr ( $js_referer , 7 ) , "/" ) , 1 );
    if ( substr ( $temp_site_name , 0 , 1 ) == "?" ) { $temp_site_name = $home_site_name.$temp_site_name; }
    $temp_url = parse_url ( $js_referer );
    parse_str ( $temp_url [ "query" ] , $temp_parameter );
    $temp_check_name_value = 0;
    if ( dirname ( $temp_site_name ) != "." ) { $temp_dir_name = dirname ( $temp_site_name )."/"; }
    else { $temp_dir_name = substr ( dirname ( $temp_site_name ) , 1 ); }
    $temp_name = $temp_dir_name.substr ( basename ( $js_referer ) , 0 , strpos ( basename ( $js_referer ) , "?" ) );
    foreach ( $temp_parameter as $key=>$value )
     {
      if ( in_array ( $key , $url_parameter ) )
       {
        $temp_check_name.= $key."=".$value."&";
        $temp_check_name_value = 1;
       }
     }
    if ( $temp_check_name_value == 1 )
     {
      $temp_check_name = $temp_name."?".substr ( $temp_check_name , 0 , strlen ( $temp_check_name ) - 1 );
      $js_referer = "http://www.".$value_referer."/".$temp_check_name;
     }
    if ( $temp_check_name_value == 0 )
     {
      if ( strpos ( $temp_site_name , "?" ) > 0 )       { $temp_site_name = substr ( $temp_site_name , 0 , strpos ( $temp_site_name , "?" ) ); }
      if ( strpos ( $temp_site_name , "." ) === FALSE ) { $temp_site_name = $temp_site_name.$home_site_name; }
      $js_referer = "http://www.".$value_referer."/".$temp_site_name;
     }
    $inside_referer = 1;
    unset ( $temp_url ); unset ( $temp_parameter ); unset ( $temp_name ); unset ( $temp_site_name ); unset ( $temp_check_name ); unset ( $temp_check_name_value );
   }
 }
####################################################################
### external referer detection ###
if ( $inside_referer == 0 )
 {
  $special_referer_url = $js_referer;
  $special_referer_url_parameter = array ( "q" , "search" , "query" , "ask" , "terms" , "key" , "qkw" , "su" , "dt" , "Keywords" , "origq" , "catId" );
  $special_referer_temp_site_name   = substr ( strstr ( substr ( $special_referer_url , 7 ) , "/" ) , 1 );
  $special_referer_temp_url = parse_url ( $special_referer_url );
  parse_str ( $special_referer_temp_url [ "query" ] , $special_referer_temp_parameter );
  $special_referer_temp_check_name_value = 0;
  $special_referer_temp_name = substr ( basename ( $special_referer_url ) , 0 , strpos ( basename ( $special_referer_url ) , "?" ) );
  foreach ( $special_referer_temp_parameter as $key=>$value )
   {
    if ( in_array ( $key , $special_referer_url_parameter ) )
     {
      $special_referer_temp_check_name.= $key."=".$value."&";
      $special_referer_temp_check_name_value = 1;
     }
   }
  if ( $special_referer_temp_check_name_value == 1 )
   {
    $js_referer = dirname ( $special_referer_url )."/".$special_referer_temp_name."?".substr ( $special_referer_temp_check_name , 0 , strlen ( $special_referer_temp_check_name ) - 1 );
   }
  unset ( $special_referer_temp_check_name ); unset ( $special_referer_temp_check_name_value ); unset ( $special_referer_temp_name );
  unset ( $special_referer_temp_url ); unset ( $special_referer_temp_site_name ); unset ( $special_referer_url ); unset ( $special_referer_url_parameter );
 }
//------------------------------------------------------------------
// if referer is not empty, saving
if ( $db_active == 1 )
 {
  if ( trim ( $js_referer ) != "" )
   {
    if ( strpos ( $js_referer , "translate.google" ) > 0 ) { $referer = pattern_matching ( "referrer" , "http://translate.google.com" ); } // check pattern referer
    else { $referer = pattern_matching ( "referrer" , mysql_escape_string ( $js_referer ) ); } // check pattern referer
   }
  else { $referer = pattern_matching ( "referrer" , "---" ); } // if referer emty, referer = ---
 }
else
 {
  if ( trim ( $js_referer ) != "" )
   {
    if ( strpos ( $js_referer , "translate.google" ) > 0 ) { $referer = pattern_matching ( "referer" , "http://translate.google.com" ); } // check pattern referer
    else { $referer = pattern_matching ( "referer" , $js_referer ); } // check pattern referer
   }
  else { $referer = ""; }
 }
####################################################################
### os and browser detection ###
//------------------------------------------------------------------
include ( "func/func_browser.php"          ); // include browser detection
include ( "func/func_operating_system.php" ); // include operating detection
//------------------------------------------------------------------
$browser          = strip_tags ( browser_detection          ( $_SERVER [ "HTTP_USER_AGENT" ] ) ); // get browser
$operating_system = strip_tags ( operating_system_detection ( $_SERVER [ "HTTP_USER_AGENT" ] ) ); // get operating system
$browser          = pattern_matching ( "browser"          , $browser          ); // check pattern browser
$operating_system = pattern_matching ( "operating_system" , $operating_system ); // check pattern operating system
$resolution       = pattern_matching ( "resolution"       , $js_resolution    ); // check pattern resolution
//------------------------------------------------------------------
// check if the call comes from within
$write_logfile_entry = 0;
foreach ( $exception_domain as $value )
 {
 	if ( strpos ( $js_url , $value ) > 0     ) { $write_logfile_entry = 1; }
 	if ( substr ( $value , 0 , 4 ) == "xn--" ) { $write_logfile_entry = 1; }
 }
//------------------------------------------------------------------
// timestamp detection
$time_stamp = time ();
if ( $server_time == "+14h"    ) { $time_stamp = $time_stamp + 14 * 3600; }
if ( $server_time == "+13,75h" ) { $time_stamp = $time_stamp + 13 * 3600 + 2700; }
if ( $server_time == "+13h"    ) { $time_stamp = $time_stamp + 13 * 3600; }
if ( $server_time == "+12,75h" ) { $time_stamp = $time_stamp + 12 * 3600 + 2700; }
if ( $server_time == "+12h"    ) { $time_stamp = $time_stamp + 12 * 3600; }
if ( $server_time == "+11,5h"  ) { $time_stamp = $time_stamp + 11 * 3600 + 1800; }
if ( $server_time == "+11h"    ) { $time_stamp = $time_stamp + 11 * 3600; }
if ( $server_time == "+10,5h"  ) { $time_stamp = $time_stamp + 10 * 3600 + 1800; }
if ( $server_time == "+10h"    ) { $time_stamp = $time_stamp + 10 * 3600; }
if ( $server_time == "+9,5h"   ) { $time_stamp = $time_stamp +  9 * 3600 + 1800; }
if ( $server_time == "+9h"     ) { $time_stamp = $time_stamp +  9 * 3600; }
if ( $server_time == "+8h"     ) { $time_stamp = $time_stamp +  8 * 3600; }
if ( $server_time == "+7h"     ) { $time_stamp = $time_stamp +  7 * 3600; }
if ( $server_time == "+6,5h"   ) { $time_stamp = $time_stamp +  6 * 3600 + 1800; }
if ( $server_time == "+6h"     ) { $time_stamp = $time_stamp +  6 * 3600; }
if ( $server_time == "+5,75h"  ) { $time_stamp = $time_stamp +  5 * 3600 + 2700; }
if ( $server_time == "+5,5h"   ) { $time_stamp = $time_stamp +  5 * 3600 + 1800; }
if ( $server_time == "+5h"     ) { $time_stamp = $time_stamp +  5 * 3600; }
if ( $server_time == "+4,5h"   ) { $time_stamp = $time_stamp +  4 * 3600 + 1800; }
if ( $server_time == "+4h"     ) { $time_stamp = $time_stamp +  4 * 3600; }
if ( $server_time == "+3,5h"   ) { $time_stamp = $time_stamp +  3 * 3600 + 1800; }
if ( $server_time == "+3h"     ) { $time_stamp = $time_stamp +  3 * 3600; }
if ( $server_time == "+2h"     ) { $time_stamp = $time_stamp +  2 * 3600; }
if ( $server_time == "+1h"     ) { $time_stamp = $time_stamp +  1 * 3600; }
if ( $server_time == "-1h"     ) { $time_stamp = $time_stamp -  1 * 3600; }
if ( $server_time == "-2h"     ) { $time_stamp = $time_stamp -  2 * 3600; }
if ( $server_time == "-3h"     ) { $time_stamp = $time_stamp -  3 * 3600; }
if ( $server_time == "-3,5h"   ) { $time_stamp = $time_stamp -  3 * 3600 - 1800; }
if ( $server_time == "-4h"     ) { $time_stamp = $time_stamp -  4 * 3600; }
if ( $server_time == "-4,5h"   ) { $time_stamp = $time_stamp -  4 * 3600 - 1800; }
if ( $server_time == "-5h"     ) { $time_stamp = $time_stamp -  5 * 3600; }
if ( $server_time == "-6h"     ) { $time_stamp = $time_stamp -  6 * 3600; }
if ( $server_time == "-7h"     ) { $time_stamp = $time_stamp -  7 * 3600; }
if ( $server_time == "-8h"     ) { $time_stamp = $time_stamp -  8 * 3600; }
if ( $server_time == "-9h"     ) { $time_stamp = $time_stamp -  9 * 3600; }
if ( $server_time == "-9,5h"   ) { $time_stamp = $time_stamp -  9 * 3600 - 1800; }
if ( $server_time == "-10h"    ) { $time_stamp = $time_stamp - 10 * 3600; }
if ( $server_time == "-11h"    ) { $time_stamp = $time_stamp - 11 * 3600; }
if ( $server_time == "-12h"    ) { $time_stamp = $time_stamp - 12 * 3600; }
################################################################################
### write the log entries ###
if ( strpos ( $ip_address , ":" ) > 0 ) // ipv6
 {
  if ( $hash_ip_address == 1 ) { $ip_address = substr ( $ip_address , 0 , strpos ( $ip_address , ":" , 5 ) + 1 ).substr ( md5 ( $ip_address ) , 0 , 10 ); }
  if ( $hash_ip_address == 2 ) { $ip_address = substr ( md5 ( $ip_address ) , 0 , 15 ); }
 }
else // ipv4
 {
  if ( $hash_ip_address == 1 ) { $ip_address = substr ( $ip_address , 0 , strrpos ( $ip_address , "." ) + 1 ).substr ( md5 ( $ip_address ) , 0 , 5 ); }
  if ( $hash_ip_address == 2 ) { $ip_address = substr ( md5 ( $ip_address ) , 0 , 15 ); }
 }
//------------------------------------------------------------------
if ( $write_logfile_entry == 1 )
 {
  if ( $db_active == 1 )
   {
    //------------------------------------------------------------------
    if ( $browser          == "" ) { $browser          = "1";       } // 1 = unknown
    if ( $operating_system == "" ) { $operating_system = "1";       } // 1 = unknown
    if ( $site_name        == "" ) { $site_name        = "1";       } // 1 = ---
    if ( $resolution       == "" ) { $resolution       = "1";       } // 1 = unknown
    if ( $js_color         == "" ) { $js_color         = "0";       } // 0 = unknown
    if ( $country          == "" ) { $country          = "unknown"; }
    // write the same entry into the database
    $query = "INSERT INTO ".$db_prefix."_main VALUES (NULL,1,".date("Y",$time_stamp).",".date("m",$time_stamp).",".date("W",$time_stamp).",".date("d",$time_stamp).",".date("H",$time_stamp).",".date("i",$time_stamp).",".$time_stamp.",'".$ip_address."',".$browser.",".$operating_system.",".$site_name.",".$referer.",".$resolution.",".$js_color.",'".$country."')";
    $result = db_query ( $query , 0 , 0 );
    //------------------------------------------------------------------
   }
  else
   {
    //------------------------------------------------------------------
    // write the same entry into the logdb file
    $log_file = fopen ( "log/logdb.dta" , "a+" );
     fwrite ( $log_file , $time_stamp."|".$ip_address."|".$browser."|".$operating_system."|".$site_name."|".$referer."|".$resolution."|".$js_color."|".$country."\n" ); # write log entry
    fclose ( $log_file ); unset ( $log_file );

    // write the same entry into the logdb_backup file
    $log_file = fopen ( "log/logdb_backup.dta" , "a+" );
     fwrite ( $log_file , $time_stamp."|".$ip_address."|".$browser."|".$operating_system."|".$site_name."|".$referer."|".$resolution."|".$js_color."|".$country."\n" ); # write log entry
    fclose ( $log_file ); unset ( $log_file );

    // write the last timestamp to last_timestamp.dta
    $log_file = fopen ( "log/last_timestamp.dta" , "w+" );
     fwrite ( $log_file , $time_stamp );
    fclose ( $log_file ); unset ( $log_file );
    //------------------------------------------------------------------
   }
 }
################################################################################
### show image if javascript disabled ###
### cache update check ###
if ( $_GET [ "mode" ] == "img" )
 {
  //------------------------------------------------------------------
  Header   ( "Content-type: image/gif" );
  readfile ( "images/pixel.gif"        );
  //------------------------------------------------------------------
 }
else
 {
  //------------------------------------------------------------------
  // Check for Cache Update (if enabled in Admincenter)
  if ( $cache_update == 0 ) { }
  else
   {
    //------------------------------------------------------------------
    // Get the latest timestamp of the cachecreator execution
    $timestamp_cache_update_file = fopen ( "log/timestamp_cache_update.dta" , "r" );
     $timestamp_cache_update_file_entry = fgets ( $timestamp_cache_update_file , 6000 );
    fclose ( $timestamp_cache_update_file );
    unset ( $timestamp_cache_update_file );

    // Run the Cache Update if the time difference matchtes
    $cache_update_frequency = $cache_update * 60;
    if ( ( time () - $timestamp_cache_update_file_entry ) > $cache_update_frequency )
     {
      //------------------------------------------------------------------
      // set the timestamp for cache updates
      $cache_timestamp_file = fopen ( "log/timestamp_cache_update.dta" , "w+" );
       fwrite ( $cache_timestamp_file , time() );
      fclose ( $cache_timestamp_file );
      unset  ( $cache_timestamp_file );
      //------------------------------------------------------------------
      // send javascript to browser for automatic cache update
	    header("content-type: text/javascript");
      echo 'jsinfo = "'.$script_domain.'/'.$script_path.'cache_creator.php?pw=update";';
      echo "\ntry {\nvar script = document.createElementNS('http://www.w3.org/1999/xhtml','script');\n";
      echo "script.setAttribute('type', 'text/javascript');\n";
      echo "script.setAttribute('src', jsinfo);\n";
      echo "document.getElementsByTagName('body')[0].appendChild(script);\n";
      echo "}\ncatch(e) {\n";
      echo 'str = "<script type=\"text/javascript\" src=\""+jsinfo+"\"></script>"';
      echo "\n".'document.write(str+""); }';
      //------------------------------------------------------------------
     }
    //------------------------------------------------------------------
   }
  //------------------------------------------------------------------
  // Check for Plugins
  if ( file_exists ( "plugins/mail/mail_function.php" ) )
   {
    include ( "plugins/mail/mail_function.php" );
   }
  //--------------------------------------------
  if ( file_exists ( "plugins/geoip/geoip_function.php" ) )
   {
    include ( "plugins/geoip/geoip_function.php" );
   }
  //------------------------------------------------------------------
 }
//------------------------------------------------------------------------------
?>