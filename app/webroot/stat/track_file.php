<?php header ( "Cache-Control: no-cache, must-revalidate" ); header ( "Expires: Sat, 26 Jul 2000 05:00:00 GMT" );
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.8.x                                                    #
# File-Release-Date:  14/05/15                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2014 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
error_reporting(0);
//------------------------------------------------------------------------------
// Check for exception domain
include ( "config/config.php" ); // include path to logfile
$found = 0;
$url_complete = $_SERVER [ "HTTP_REFERER" ];

// check if the call comes from within
$arrUrl = parse_url ( strtolower ( $url_complete ) );
foreach ( $exception_domain as $value ) { if ( preg_match ("/\.".strtolower ( $value )."$/", ".".$arrUrl [ "host" ] ) ) { $found = 1; } }

// if the call does not come from within
if ( $found == 0 ) { exit; }
//------------------------------------------------------------------------------
if ( isset ( $_GET [ "file_name" ] ) )
 {
  //------------------------------------------------------------------------------
  // kill all special chars
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
    $search_pattern [ ] = '/\</';
    $search_pattern [ ] = '/\>/';
    $search_pattern [ ] = '/\§/';
    return preg_replace ( $search_pattern , '' , addslashes ( strip_tags ( $value ) ) );
   }
  $parameter_file_name = trim ( track_kill_chars ( $_GET [ "file_name" ] ) );
  if ( $parameter_file_name == "" ) { exit; }
  //------------------------------------------------------------------------------
  $track_file_names = unserialize ( file_get_contents ( "log/logdb_track_file.dta" ) );
  $track_file_names [ $parameter_file_name ] [ 0 ]++;
  $track_file_names [ $parameter_file_name ] [ date ( "Y-m" ) ]++;
  $track_file_names [ "last-download"    ] [ 0 ] = time();
  $track_file_names [ "last-download"    ] [ 1 ] = $parameter_file_name;
  #@file_put_contents ( "log/logdb_track_file.dta" ,  serialize ( $track_file_names ) );
  $logfile = fopen ( "log/logdb_track_file.dta" , "w+" );
   fwrite ( $logfile , serialize ( $track_file_names ) );
  fclose ( $logfile );
  unset ( $logfile );
  exit;
  //------------------------------------------------------------------------------
 }
//------------------------------------------------------------------------------
if ( !isset ( $_GET [ "file_name" ] ) )
 {
  //------------------------------------------------------------------------------
  //include ( "config/config.php" ); // include path to logfile
  //------------------------------------------------------------------------------
  //SSL Fix by www.ct-designs.de
  if ( $_SERVER [ "HTTPS" ] == "on" ) { $script_domain = str_replace ( "http:" , "https:" , $script_domain ); }
  //------------------------------------------------------------------------------
  header("content-type: text/javascript");
  echo '
   function track_file(file_name)
    {
     if (window.XMLHttpRequest) { myAjax = new XMLHttpRequest(); }
     else { myAjax = new ActiveXObject("Microsoft.XMLHTTP"); }
     var url_target = "'.$script_domain.'/'.$script_path.'track_file.php?file_name=" + file_name;

     myAjax.open("GET",url_target,true);
     myAjax.send();
    }
   ';
  //------------------------------------------------------------------------------
 }
//------------------------------------------------------------------------------
?>