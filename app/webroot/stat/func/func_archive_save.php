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
include ( "../config/config.php" ); // include path to style
include ( "../".$language        ); // include language
//------------------------------------------------------------------------------
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">";
echo "<html>\n";
echo "<head>\n";
echo "<title>PHP Web Stat - Admin Center</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
echo "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=EmulateIE7\">\n";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../".$theme."style.css\" media=\"screen, projection\">\n";
echo "</head>\n";
echo "<body>\n";
echo "<style type=\"text/css\">\n";
echo "body { margin:0px; }\n";
echo "</style>\n";
echo "<table id=\"groundtable\" width=\"100%\" height=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"border:0px; -moz-border-radius:0px 0px 0px 0px; -webkit-border-radius:0px 0px 0px 0px; border-radius:0px 0px 0px 0px\">\n";
echo "<tr>\n";
  echo "<td  align=\"center\" valign=\"middle\">\n";
//------------------------------------------------------------------------------
// if the archive should be saved
if ( ( isset ( $_POST [ "from_timestamp" ] ) ) && ( isset ( $_POST [ "until_timestamp" ] ) ) )
 {
  //------------------------------------------------------------------
  if ( !is_numeric ( $_POST [ "from_timestamp"  ] ) ) { exit; }
  if ( !is_numeric ( $_POST [ "until_timestamp" ] ) ) { exit; }
  //------------------------------------------------------------------
  if ( $_SESSION [ "loggedin" ] == "admin" )
   {
    if ( !copy ( "../log/cache_visitors_archive.php" , "../log/archive/".$_POST [ "from_timestamp" ]."-".$_POST [ "until_timestamp" ].".php" ) )
     {
      echo "".$lang_archive[8]."\n";
     }
    else
     {
      echo "<b>".$lang_archive[9]."</b>\n";
      exit;
     }
   }
  else
   {
    echo "".$lang_archive[8]."\n";
   }
  //------------------------------------------------------------------
 }
else
 {
  //------------------------------------------------------------------
  // form to save the displayed archive
  echo "<form style=\"margin:0px;\" name=\"save\" action=\"func_archive_save.php\" method=\"post\">\n";
  echo "<input type=\"hidden\" name=\"from_timestamp\" value=\"".$_GET [ "from_timestamp" ]."\">\n";
  echo "<input type=\"hidden\" name=\"until_timestamp\" value=\"".$_GET [ "until_timestamp" ]."\">\n";
  echo "".$lang_archive[10]." &nbsp; <input type=\"submit\" class=\"submit\"  value=\"&nbsp;".$lang_archive[11]."&nbsp;\"></td>\n";
  echo "</form>\n";
  //------------------------------------------------------------------
 }
//------------------------------------------------------------------------------
  echo "</td>\n";
echo "</tr>\n";
echo "</table>\n";
echo "</body>\n";
echo "</html>\n";
//------------------------------------------------------------------------------
?>