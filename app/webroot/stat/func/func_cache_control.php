<?php @session_start(); if ( $_SESSION [ "hidden_stat" ] != md5_file ( "../config/config.php" ) ) { $error_path = "../"; include ( "../func/func_error.php" ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.9.x                                                    #
# File-Release-Date:  15/01/03                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2015 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
clearstatcache ();
//------------------------------------------------------------------------------
$bgcolor = "#F0F0EE";
$percent = 0;
//------------------------------------------------------------------------------
if ( isset ( $_GET [ "parameter" ] ) )
 {
  if ( $_GET [ "parameter" ] == "stat" )
   {
    $bgcolor = "#F0F0EE";
    include ( "../log/cache_memory_address.php" );
    $percent = ( int ) round ( $cache_memory_address / filesize ( "../log/logdb_backup.dta" ) * 100 );
   }
  //------------------------------------------------------------------------------
  if ( $_GET [ "parameter" ] == "archive" )
   {
    $bgcolor = "#F0F0EE";
    include ( "../log/cache_memory_address.php" );
    $percent = ( int ) round ( $cache_memory_address / filesize ( "../log/logdb_backup.dta" ) * 100 );
   }
  //------------------------------------------------------------------------------
  if ( $_GET [ "parameter" ] == "cache_panel" )
   {
    $bgcolor = "#EBE8D8";
    if ( !is_readable ( "../log/cache_memory_address.php" ) )
     { $percent = 0; }
    else
     {
      include ( "../log/cache_memory_address.php" );
      $percent = ( int ) round ( $cache_memory_address / filesize ( "../log/logdb_backup.dta" ) * 100 );
     }
   }
 }
//------------------------------------------------------------------------------
if ( ( isset ( $percent ) ) && ( $percent < 100 ) )
 {
  $refresh = "<meta http-equiv=\"refresh\" content=\"3; URL=func_cache_control.php?parameter=".strip_tags ( $_GET [ "parameter" ] )."\">\n";
 }
else
 { $refresh = ""; }
//------------------------------------------------------------------------------
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
echo "<html>\n";
echo "<head>\n";
echo "<title>PHP Web Stat - Check Timstamp</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
echo $refresh;
echo "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=EmulateIE7\">\n";
echo "<meta http-equiv=\"pragma\"  content=\"no-cache\">\n";
echo "<meta http-equiv=\"expires\" content=\"0\">\n";
echo "<style type=\"text/css\">";
echo "body { background-color:".$bgcolor."; margin:0px; }\n";
echo "</style>";
echo "</head>\n";
echo "<body>\n";
echo "<center>\n";
echo "<table width=\"398\" height=\"16\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "<tr>\n";
echo "<td>\n";
echo "<div style=\"position: relative; margin: 0px auto; width: 398px; height: 16px; border: none;\">\n";
$percent_bar = (int) round ( ( $percent * 3.98 ) - 398 );
echo "<div style=\"position: absolute; top: 0px; left: 0px;\"><img src=\"../images/progress_bar_fg.gif\" border=\"0\" width=\"398\" height=\"16\" alt=\"\" style=\"background: url(../images/progress_bar_bg.gif) top left no-repeat; padding: 0px; margin: 0px; background-position: ".$percent_bar."px 0;\"></div>\n";
echo "<div style=\"position: absolute; top: 1px; left: 50%; font-size:12px; font-family:Arial;\">".$percent." %</div>\n";
echo "</div>\n";
echo "</td>\n";
echo "</tr>\n";
echo "</table>\n";
echo "</center>\n";
echo "</body>\n";
echo "</html>\n";
//------------------------------------------------------------------------------
?>