<?php @session_start(); if ( $_SESSION [ "hidden_stat" ] != md5_file ( "../config/config.php" ) ) { $error_path = "../"; include ( "../func/func_error.php" ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.4.x                                                    #
# File-Release-Date:  10/11/05                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2010 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
include ( "../config/config.php" ); // check language
//------------------------------------------------------------------------------
$bgcolor = "#F0F0EE";
$check_file = "cache_time_stamp.php";
//------------------------------------------------------------------------------
if ( $language == "language/german.php" )
 {
  $dateform  = "d.m.Y - H:i:s";
 }
else
 {
  $dateform  = "Y/m/d - h:i a";
 }
//------------------------------------------------------------------------------
if ( $_GET [ "parameter" ] == "stat" )
 {
  $bgcolor = "#F0F0EE";
  $check_file = "cache_time_stamp.php";
 }
//------------------------------------------------------------------------------
if ( $_GET [ "parameter" ] == "archive" )
 {
  $bgcolor = "#F0F0EE";
  $check_file = "cache_time_stamp_archive.php";
 }
//------------------------------------------------------------------------------
if ( $_GET [ "parameter" ] == "cache_panel" )
 {
  $bgcolor = "#EBE8D8";
  $check_file = "cache_time_stamp.php";
 }
//------------------------------------------------------------------------------
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
echo "<html>\n";
echo "<head>\n";
echo "<title>PHP Web Stat - Check Timstamp</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
echo "<meta http-equiv=\"refresh\" content=\"3; URL=func_timestamp_control.php?parameter=".strip_tags ( $_GET [ "parameter" ] )."\">\n";
echo "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=EmulateIE7\">\n";
echo "<meta http-equiv=\"pragma\"  content=\"no-cache\">\n";
echo "<meta http-equiv=\"expires\" content=\"0\">\n";
echo "<style type=\"text/css\">";
echo "body { background-color:".$bgcolor."; margin:0px; }\n";
echo "</style>";
echo "</head>\n";
echo "<body>\n";
echo "<table border=\"0\" width=\"100%\" height=\"100%\" cellspacing=\"0\" cellpading=\"0\">\n";
echo "<tr>\n";
  echo "<td valign=\"middle\" align=\"center\" style=\"font-family:Arial, Verdana, Helvetica, sans serif; font-weight:bold; font-size:16px;\">";
  include ( "../log/".$check_file );
  if ( ( $_GET [ "parameter" ] == "cache_panel" ) || ( $_GET [ "parameter" ] == "cache_panel_counter" ) )
   {
    if ( $cache_time_stamp != "" ) { echo date ( $dateform , $cache_time_stamp ); } else { echo "<img src=\"../images/load_indicator2.gif\" width=\"24\" height=\"24\" style=\"vertical-align:middle;\" alt=\"\"> loading..."; }
   }
  else
   {
    if ( $cache_time_stamp != "" ) { echo date ( $dateform , $cache_time_stamp ); } else { echo "loading..."; }
   }
  echo "</td>\n";
echo "</tr>\n";
echo "</table>\n";
echo "</body>\n";
echo "</html>\n";
//------------------------------------------------------------------------------
?>