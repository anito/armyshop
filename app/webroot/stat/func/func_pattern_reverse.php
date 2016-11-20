<?php
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

//------------------------------------------------------------------------------
function pattern_reverse ( $value )
 {
  if ( $GLOBALS [ "db_active" ] == 1 )
   {
    //------------------------------
    $query  = "SELECT * FROM ".$value;
    $result = db_query ( $query , 1 , 0 );
    //------------------------------
    for ( $x = 0 ; $x <= count ( $result ) - 1 ; $x++ )
     {
      $temp_array [ $result[$x][0] ] = $result[$x][1];
     }
    //------------------------------
    return $temp_array;
    //------------------------------
   }
  else
   {
    //------------------------------
    $pattern_file = fopen ( $value , "r" );
    //------------------------------
    while ( !FEOF ( $pattern_file ) )
     {
      $pattern_file_entry = fgetcsv ( $pattern_file , 60000 , "|" );
       if ( count ( $pattern_file_entry ) > 1 )
        {
         $temp_array [ $pattern_file_entry [ 1 ] ] = &$pattern_file_entry [ 0 ];
        }
     }
    fclose ( $pattern_file );
    unset  ( $pattern_file );
    //------------------------------
    return $temp_array;
    //------------------------------
   }
 }
//------------------------------------------------------------------------------
if ( $GLOBALS [ "db_active" ] == 1 )
 {
  $pattern_browser          = pattern_reverse ( $db_prefix."_browser"          );
  $pattern_operating_system = pattern_reverse ( $db_prefix."_operating_system" );
  $pattern_referer          = pattern_reverse ( $db_prefix."_referrer"         );
  $pattern_site_name        = pattern_reverse ( $db_prefix."_site_name"        );
  $pattern_resolution       = pattern_reverse ( $db_prefix."_resolution"       );
 }
else
 {
  $pattern_browser          = pattern_reverse ( "log/pattern_browser.dta"          );
  $pattern_operating_system = pattern_reverse ( "log/pattern_operating_system.dta" );
  $pattern_referer          = pattern_reverse ( "log/pattern_referer.dta"          );
  $pattern_site_name        = pattern_reverse ( "log/pattern_site_name.dta"        );
  $pattern_resolution       = pattern_reverse ( "log/pattern_resolution.dta"       );
 }
//------------------------------------------------------------------------------
?>