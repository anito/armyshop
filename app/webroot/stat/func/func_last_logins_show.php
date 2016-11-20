<?php @session_start(); if ( $_SESSION [ "hidden_stat" ] != md5_file ( "../config/config.php" ) ) { $error_path = "../"; include ( "../func/func_error.php" ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.8.x                                                    #
# File-Release-Date:  14/07/06                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2014 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
error_reporting(0);
//------------------------------------------------------------------------------
include ( "../config/config.php" ); // check language
include ( "../".substr ( $language , 0 , strpos ( $language , "." ) )."_admin.php" ); // include language vars
//------------------------------------------------------------------------------
//check date form
if ( $language == "language/german.php" ) { $dateform = "d.m.Y"; $timeform = "H:i:s"; }
else { $dateform = "Y/m/d"; $timeform = "h:i a"; }
//------------------------------------------------------------------------------
include ( "html_header.php" ); // include html header
//------------------------------------------------------------------------------
$last_logins = array ( );
$last_login_logfile = fopen ( "../log/last_logins.dta" , "r" );
 while ( !FEOF ( $last_login_logfile ) )
  {
   $entry = fgetcsv ( $last_login_logfile , 6000 , "|" );
   if ( trim ( $entry [ 0 ] ) != "" )
    {
     $last_logins [ ] = $entry [ 0 ]."|".$entry [ 1 ]."|".$entry [ 2 ];
    }
  }
fclose ( $last_login_logfile );
unset  ( $last_login_logfile );
unset  ( $entry              );
unset  ( $counter            );

krsort ( $last_logins );
//------------------------------------------------------------------------------
if ( $_GET [ "action" ] == "reset" )
 {
  echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"height:110px;\">\n";
  echo "<tr>\n";
    echo "<td align=\"center\">";
    echo "<img src=\"../images/admin/done.png\" border=\"0\" width=\"32\" height=\"32\" style=\"vertical-align:middle;\" alt=\"\"> &nbsp; <b>".$lang_admin_i_l[7]."</b>";
    echo "<td>";
  echo "</td>";
  echo "</table>";
  echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\" style=\"position:absolute; top:116px; border-top:1px solid #707070;\">\n";
  echo "<tr>\n";
    echo "<td align=\"center\">";
    echo "<input type=\"submit\" class=\"submit\" onclick=\"location.href='func_last_logins_show.php?action=reset'\" value=\"".$lang_admin_i_l[6]."\">";
    echo "</td>\n";
  echo "</tr>\n";
  echo "</table>";
  // empty the stat Logins
  //----------------------
  $logfile = fopen ( "../log/last_logins.dta" , "w" );
  fclose ( $logfile );
  unset  ( $logfile );
  echo "<meta http-equiv=\"refresh\" content=\"3; URL=func_last_logins_show.php\">\n";
 }
else
 {
  echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">\n";

  if ( count ( $last_logins ) < 5 ) { $number = count ( $last_logins ); }
  else { $number = 5; }

  for ( $x = ( count ( $last_logins ) - 1 ) ; $x > ( count ( $last_logins ) - 1 - $number ) ; $x-- )
   {
    $parts = explode ( "|" , $last_logins [ $x ] );
    echo "<tr>\n";
     echo "<td>";
         if ( $parts [ 2 ] == "adminpassword" ) { echo $lang_admin_i_l[2]." <img src=\"../images/admin/key.gif\" border=\"0\" alt=\"\">"; }
     elseif ( $parts [ 2 ] == "userpassword"  ) { echo $lang_admin_i_l[3]." <img src=\"../images/admin/key.gif\" border=\"0\" alt=\"\">"; }
     elseif ( $parts [ 2 ] == "user"          ) { echo $lang_admin_i_l[3]."";  }
     echo "</td>\n";
     if ( strpos ( $parts [ 1 ] , ":" ) > 0 )
      {
       echo "<td><a class=\"ip\" href=\"".$whois_link.$parts [ 1 ]."\" target=\"_blank\">".substr ( $parts [ 1 ] , 0 , 20 )."...</a></td>\n";
      }
     else
      {
       echo "<td><a class=\"ip\" href=\"".$whois_link.$parts [ 1 ]."\" target=\"_blank\">".$parts [ 1 ]."</a></td>\n";
      }
     echo "<td>";
     if ( date ( $dateform , $parts [ 0 ] ) == date ( $dateform ) ) { echo "<b>".$lang_admin_i_l[4]."</b> ".$lang_admin_i_l[5]." ".date ( $timeform , $parts [ 0 ] ); }
     else { echo date ( $dateform , $parts [ 0 ] )." ".$lang_admin_i_l[5]." ".date ( $timeform , $parts [ 0 ] ); }
     echo "</td>\n";
    echo "</tr>\n";
   }
  echo "</table>\n";
  echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\" style=\"position:absolute; top:116px; border-top:1px solid #707070;\">\n";
  echo "<tr>\n";
    echo "<td align=\"center\">";
    echo "<input type=\"submit\" class=\"submit\" onclick=\"location.href='func_last_logins_show.php?action=reset'\" value=\"".$lang_admin_i_l[6]."\">";
    echo "</td>\n";
  echo "</tr>\n";
  echo "</table>";
 }
//------------------------------------------------------------------------------
include ( "html_footer.php" ); // include html footer
//------------------------------------------------------------------------------
?>