<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.9.x                                                    #
# File-Release-Date:  15/04/26                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright � 2015 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
/*
This program is free software; you can redistribute it and/or modify it under the
terms of the GNU General Public License as published by the Free Software
Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this
program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth
Floor, Boston, MA 02110, USA
*/
//------------------------------------------------------------------------------
error_reporting(0);
@ini_set ( "max_execution_time","false" ); // set the script time
//------------------------------------------------------------------------------
### !!! never change this value !!! ###
$version_number  = "2.7";
//------------------------------------------------------------------------------
include ( "config/config.php"           ); // include path to logfile
if ( $db_active == 1 )
 {
  include ( "config/config_db.php" ); // include db prefix
  include ( "db_connect.php"       ); // include database connectivity
 }
//------------------------------------------------------------------------------
$strLanguageFile = "";
if ( isset( $_GET [ "language" ] ) )
 {
  switch ( $_GET [ "language" ] )
   {
    case "de":    $strLanguageFile = "language/german.php";     break;
    case "en":    $strLanguageFile = "language/english.php";    break;
    case "nl":    $strLanguageFile = "language/dutch.php";      break;
    case "it":    $strLanguageFile = "language/italian.php";    break;
    case "es":    $strLanguageFile = "language/spanish.php";    break;
    case "es-ct": $strLanguageFile = "language/catalan.php";    break;
    case "fa":    $strLanguageFile = "language/farsi.php";      break;
    case "dk":    $strLanguageFile = "language/danish.php";     break;
    case "fr":    $strLanguageFile = "language/french.php";     break;
    case "tr":    $strLanguageFile = "language/turkish.php";    break;
    case "hu":    $strLanguageFile = "language/hungarian.php";  break;
    case "pt":    $strLanguageFile = "language/portuguese.php"; break;
    case "he":    $strLanguageFile = "language/hebrew.php";     break;
    case "ru":    $strLanguageFile = "language/russian.php";    break;
    case "rs":    $strLanguageFile = "language/serbian.php";    break;
    case "fi":    $strLanguageFile = "language/finnish.php";    break;
    default: $strLanguageFile = $language;  // include language vars from config file
  }
}
//-------------------------------
if ( file_exists ( $strLanguageFile ) )
 {
  include ( $strLanguageFile );
 }
else
 {
  include ( $language ); // include language vars from config file
 }
//------------------------------------------------------------------------------
if ( ( $_GET [ "language" ] == "de" ) || ( !isset ( $_GET [ "language" ] ) ) ) { $dateform1  = "d.m.Y"; $dateform2 = "d.m.y"; }
else { $dateform1  = "Y/m/d"; $dateform2 = "y/m/d"; }
//------------------------------------------------------------------------------
$home_time = 0;
if ( $server_time == "+14h"    ) { $home_time = 14 * 3600; }
if ( $server_time == "+13,75h" ) { $home_time = 13 * 3600 + 2700; }
if ( $server_time == "+13h"    ) { $home_time = 13 * 3600; }
if ( $server_time == "+12,75h" ) { $home_time = 12 * 3600 + 2700; }
if ( $server_time == "+12h"    ) { $home_time = 12 * 3600; }
if ( $server_time == "+11,5h"  ) { $home_time = 11 * 3600 + 1800; }
if ( $server_time == "+11h"    ) { $home_time = 11 * 3600; }
if ( $server_time == "+10,5h"  ) { $home_time = 10 * 3600 + 1800; }
if ( $server_time == "+10h"    ) { $home_time = 10 * 3600; }
if ( $server_time == "+9,5h"   ) { $home_time =  9 * 3600 + 1800; }
if ( $server_time == "+9h"     ) { $home_time =  9 * 3600; }
if ( $server_time == "+8h"     ) { $home_time =  8 * 3600; }
if ( $server_time == "+7h"     ) { $home_time =  7 * 3600; }
if ( $server_time == "+6,5h"   ) { $home_time =  6 * 3600 + 1800; }
if ( $server_time == "+6h"     ) { $home_time =  6 * 3600; }
if ( $server_time == "+5,75h"  ) { $home_time =  5 * 3600 + 2700; }
if ( $server_time == "+5,5h"   ) { $home_time =  5 * 3600 + 1800; }
if ( $server_time == "+5h"     ) { $home_time =  5 * 3600; }
if ( $server_time == "+4,5h"   ) { $home_time =  4 * 3600 + 1800; }
if ( $server_time == "+4h"     ) { $home_time =  4 * 3600; }
if ( $server_time == "+3,5h"   ) { $home_time =  3 * 3600 + 1800; }
if ( $server_time == "+3h"     ) { $home_time =  3 * 3600; }
if ( $server_time == "+2h"     ) { $home_time =  2 * 3600; }
if ( $server_time == "+1h"     ) { $home_time =  1 * 3600; }
if ( $server_time == "-1h"     ) { $home_time =  1 * 3600; }
if ( $server_time == "-2h"     ) { $home_time =  2 * 3600; }
if ( $server_time == "-3h"     ) { $home_time =  3 * 3600; }
if ( $server_time == "-3,5h"   ) { $home_time =  3 * 3600 - 1800; }
if ( $server_time == "-4h"     ) { $home_time =  4 * 3600; }
if ( $server_time == "-4,5h"   ) { $home_time =  4 * 3600 - 1800; }
if ( $server_time == "-5h"     ) { $home_time =  5 * 3600; }
if ( $server_time == "-6h"     ) { $home_time =  6 * 3600; }
if ( $server_time == "-7h"     ) { $home_time =  7 * 3600; }
if ( $server_time == "-8h"     ) { $home_time =  8 * 3600; }
if ( $server_time == "-9h"     ) { $home_time =  9 * 3600; }
if ( $server_time == "-9,5h"   ) { $home_time =  9 * 3600 - 1800; }
if ( $server_time == "-10h"    ) { $home_time = 10 * 3600; }
if ( $server_time == "-11h"    ) { $home_time = 11 * 3600; }
if ( $server_time == "-12h"    ) { $home_time = 12 * 3600; }
//------------------------------------------------------------------------------
function display_overview ( $title , &$text1 , &$module1 , &$text2 , &$module2 , &$text3 , &$module3 , &$text4 , &$module4 , &$text5 , &$module5 , &$text6 , $module6 , &$text7 , &$module7 , &$text8 , &$module8 , $footer, $text9, $module9, $text10, $module10 )
 {
  //-------------------------------
  include ( "config/config.php" ); // include path to logfile
  //-------------------------------
//  echo "<table class=\"counter_table\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
//  echo "<tr>\n";
//  echo "<td class=\"header_l\"><img src=\"images/pixel.gif\" alt=\"\" /></td>\n";
//  echo "<td class=\"header_r\">".$title."</td>\n";
//  echo "</tr>\n";
//  echo "</table>\n";
  //-------------------------------
  echo "<table class=\"counter_table data\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
  if ( $counter_display_show_visitors_online == 1 ) { echo "<tr><td class=\"module\">".$text1."</td><td class=\"hits\">".number_format ( $module1 , 0 , "," , "." )."</td></tr>\n"; }
  if ( $counter_display_show_today == 1           ) { echo "<tr><td class=\"module\">".$text2."</td><td class=\"hits\">".number_format ( $module2 , 0 , "," , "." )."</td></tr>\n"; }
  if ( $counter_display_show_yesterday == 1       ) { echo "<tr><td class=\"module\">".$text3."</td><td class=\"hits\">".number_format ( $module3 , 0 , "," , "." )."</td></tr>\n"; }
  if ( $counter_display_show_this_month == 1      ) { echo "<tr><td class=\"module\">".$text4."</td><td class=\"hits\">".number_format ( $module4 , 0 , "," , "." )."</td></tr>\n"; }
  if ( $counter_display_show_last_month == 1      ) { echo "<tr><td class=\"module\">".$text5."</td><td class=\"hits\">".number_format ( $module5 , 0 , "," , "." )."</td></tr>\n"; }
  if ( $counter_display_show_max == 1             ) { echo "<tr><td class=\"module\">".$text6."</td><td class=\"hits\">".number_format ( $module6 , 0 , "," , "." )."</td></tr>\n"; }
  if ( $counter_display_show_average == 1         ) { echo "<tr><td class=\"module\">".$text7."</td><td class=\"hits\">".number_format ( $module7 , 0 , "," , "." )."</td></tr>\n"; }
  if ( $counter_display_show_total == 1           ) { echo "<tr><td class=\"module\">".$text8."</td><td class=\"hits\">".number_format ( ($module8+$counter_add_visitors) , 0 , "," , "." )."</td></tr>\n"; }
//                                                      echo "<tr><td colspan=\"2\">&nbsp;</td></tr>\n";
//                                                      echo "<tr><td class=\"module\">".$text9."</td><td class=\"hits\">".number_format ( $module9 , 0 , "," , "." )."</td></tr>\n";
//                                                      echo "<tr><td class=\"module\">".$text10."</td><td class=\"hits\">".$module10."</td></tr>\n";
  echo "</table>\n";
  //-------------------------------
  if ( $counter_display_show_footer == 1 )
   {
    echo "<table class=\"counter_table\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "<tr>\n";
    echo "<td class=\"footer_l\"><img src=\"images/pixel.gif\" alt=\"\" /></td>\n";
    if ( $counter_display_show_footer_ticker == 1 )
     {
      echo "<td class=\"footer_r\"><div class=\"marquee\" id=\"mycrawler\">".$footer."</div></td>\n";
     }
    else
     {
      echo "<td class=\"footer_r\" style=\"font-size:9px; padding:3px 7px 0px 0px;\">".$footer."</td>\n";
     }
    echo "</tr>\n";
    echo "</table>\n";
   }
  //-------------------------------
 }
################################################################################
### null entries for days and years ###
// get the actual day & the amount of days this month
$temp_month           = date ( "m" );
$temp_count_day_month = date ( "t" );
$temp_year            = date ( "y" );
//------------------------------
// set the days values to zero
for ( $x = 1 ; $x <= $temp_count_day_month ; $x++ )
 {
  //------------------------------
  if ( $x <= 9 )
   {
    $visitor_day [ $temp_year."/".$temp_month."/0".$x ] = 0;
   }
  else
   {
    $visitor_day [ $temp_year."/".$temp_month."/".$x  ] = 0;
   }
  //------------------------------
 }
//------------------------------
unset ( $temp_month           );
unset ( $temp_count_day_month );
unset ( $temp_year            );
//----------------------------------------------------------------------------
// get the actual year
$temp_year = date ( "Y" );
// set the month values to zero
for ( $x = 1 ; $x <= 12 ; $x++ )
 {
  //------------------------------
  if ( $x <= 9 )
   {
    $visitor_month [ $temp_year."/0".$x ] = 0;
   }
  else
   {
    $visitor_month [ $temp_year."/".$x  ] = 0;
   }
  //------------------------------
 }
//----------------------------------------------------------------------------
unset ( $temp_year );
//------------------------------------------------------------------------------
include ( "log/cache_visitors_counter.php" ); // include the saved arrays
if ( $db_active != 1 ) { include ( "log/index_days.php" ); } // include physical address of last read entry
//------------------------------------------------------------------------------
if ( !$visitor_online )
 {
  $visitor_online = array ( );
 }
################################################################################
### get the starting date ###
if ( $db_active == 1 )
 {
  //------------------------------------------------------------------
  // get the real first tracking timestamp
  $query                = "SELECT MIN(timestamp) FROM ".$db_prefix."_main";
  $result               = db_query ( $query , 1 , 0 );
  $real_first_timestamp = $result[0][0];
  //------------------------------------------------------------------
  if ( isset ( $starting_date ) )
   {
    if ( $starting_date == "TT.MM.YYYY" )
     {
      //--------------------------------
      $query                  = "SELECT MIN(timestamp) FROM ".$db_prefix."_main";
      $result                 = db_query ( $query , 1 , 0 );
      $first_timestamp        = date ( $dateform1 , $result[0][0] );
      $first_timestamp_ticker = date ( $dateform2 , $result[0][0] );
      //--------------------------------
     }
    else
     {
      //--------------------------------
      $first_timestamp = $starting_date;
      $first_timestamp_ticker = $starting_date;
      //--------------------------------
     }
   }
  else
   {
    //--------------------------------
    $query                  = "SELECT MIN(timestamp) FROM ".$db_prefix."_main";
    $result                 = db_query ( $query , 1 , 0 );
    $first_timestamp        = date ( $dateform1 , $result[0][0] );
    $first_timestamp_ticker = date ( $dateform2 , $result[0][0] );
    //--------------------------------
   }
  //------------------------------------------------------------------
 }
else
 {
  //------------------------------------------------------------------
  // get the real first tracking timestamp
  $logfile_first_timestamp = fopen ( "log/logdb_backup.dta" , "r" ); // open logfile
  $logfile_real_first_timestamp = fgetcsv ( $logfile_first_timestamp , 60000 , "|" );
  $real_first_timestamp = $logfile_real_first_timestamp [ 0 ];

  // if the first line in the logfile is empty, we take the second line
  if ( $real_first_timestamp == 0 )
   {
    $logfile_real_first_timestamp = fgetcsv ( $logfile_first_timestamp , 60000 , "|" );
    $real_first_timestamp = $logfile_real_first_timestamp [ 0 ];
   }

  fclose ( $logfile_first_timestamp ); // close logfile
  unset  ( $logfile_first_timestamp );
 //------------------------------------------------------------------
  if ( isset ( $starting_date ) )
   {
    if ( $starting_date == "TT.MM.YYYY" )
     {
      //--------------------------------
      $logfile_first_timestamp = fopen ( "log/logdb_backup.dta" , "r" ); // open logfile
      $logfile_entry_first_timestamp = fgetcsv ( $logfile_first_timestamp , 300 , "|" ); // read entry from logfile
      $first_timestamp        = date ( $dateform1 , $logfile_entry_first_timestamp [ 0 ] );
      $first_timestamp_ticker = date ( $dateform2 , $logfile_entry_first_timestamp [ 0 ] );
      fclose ( $logfile_first_timestamp       ); // close logfile
      unset  ( $logfile_first_timestamp       );
      unset  ( $logfile_entry_first_timestamp );
      //--------------------------------
     }
    else
     {
      //--------------------------------
      $first_timestamp = $starting_date;
      $first_timestamp_ticker = $starting_date;
      //--------------------------------
     }
   }
  else
   {
    //--------------------------------
    $logfile_first_timestamp = fopen ( "log/logdb_backup.dta" , "r" ); // open logfile
    $logfile_entry_first_timestamp = fgetcsv ( $logfile_first_timestamp , 300 , "|" ); // read entry from logfile
    $first_timestamp        = date ( $dateform1 , $logfile_entry_first_timestamp [ 0 ] );
    $first_timestamp_ticker = date ( $dateform2 , $logfile_entry_first_timestamp [ 0 ] );
    fclose ( $logfile_first_timestamp       ); // close logfile
    unset  ( $logfile_first_timestamp       );
    unset  ( $logfile_entry_first_timestamp );
    //--------------------------------
   }
  //------------------------------------------------------------------
 }
################################################################################
// get the number of online visitors
if ( $db_active == 1 )
 {
  //------------------------------------------------------------------
  $query           = "SELECT DISTINCT ".$db_prefix."_main.ip_address FROM ".$db_prefix."_main WHERE ".$db_prefix."_main.timestamp BETWEEN ".( time() - ( $online_recount_time * 60 ) )." AND ".time();
  $result_online   = db_query ( $query , 1 , 0 );
  $visitors_online = count ( $result_online );
  //------------------------------------------------------------------
 }
else
 {
	//------------------------------------------------------------------
	$logfile = fopen ( "log/logdb_backup.dta" , "rb" ); // open logfile
	fseek ( $logfile , max ( $index_days ) ); // go to the last read physical address
	while ( !FEOF ( $logfile ) ) // as long as there are entries
	{
	 //----------------------------------------
	 $logfile_entry = fgetcsv ( $logfile , 6000 , "|" ); // read entry from logfile
	 //----------------------------------------
	 if ( ( trim ( $logfile_entry [ 0 ] ) != "" ) && ( $logfile_entry [ 0 ] >= date ( "U" , strtotime ( "-".$online_recount_time." minutes" ) ) ) && ( !$visitor_online [ $logfile_entry [ 1 ] ] ) )
	  {
	   $visitor_online [ $logfile_entry [ 1 ] ]++; // save the ip address
	   $visitors_online++;                         // increase the amount of visitors that are online in the last x minutes
	  }
	 //----------------------------------------
	}
	fclose ( $logfile       ); // close logfile
	unset  ( $logfile       );
	unset  ( $logfile_entry );
	//------------------------------------------------------------------
 }
//------------------------------------------------------------------
// get the average amount of visitors
if ( $real_first_timestamp == 0 )
 { $average = 0; }
else
 {
  $average = ( int ) round ( array_sum ( $visitor_day ) / ( ( int ) round ( ( time () - $real_first_timestamp ) / 86400 ) + 1 ) );
 }
//------------------------------------------------------------------
### set no visitors to zero ###
// if there is no visitor today
if ( !$visitor_day [ date ( "y/m/d" , time () + $home_time ) ] )
 {
  $visitor_day [ date ( "y/m/d" , time () + $home_time ) ] = 0;
 }

// if there is no visitor yesterday
if ( $visitor_day [ date ( "y/m/d" , strtotime ( "-1 day" ) + $home_time ) ] )
 {
  $visitor_yesterday = $visitor_day [ date ( "y/m/d" , strtotime ( "-1 day" ) + $home_time ) ];
 }
else
 {
  $visitor_yesterday = 0;
 }

// if there is no visitor last month
$visitor_lastmonth_count = date ( "j" ) + 1;
$visitor_lastmonth_count = "-".$visitor_lastmonth_count." days";
if ( $visitor_month [ date ( "Y/m" , strtotime ( $visitor_lastmonth_count ) + $home_time ) ] )
 {
  $visitor_lastmonth = $visitor_month [ date ( "Y/m" , strtotime ( $visitor_lastmonth_count ) + $home_time ) ];
 }
else
 {
  $visitor_lastmonth = 0;
 }

// if there is no visitor this month
if ( $visitor_month [ date ( "Y/m" , time ( ) + $home_time ) ] == "" ) { $visitor_month [ date ( "Y/m" , time ( ) + $home_time ) ] = 0; }
################################################################################
### create footer content ###
// last cache update time
//------------------------------------------------------------------------------
$cache_update_time = file ( "log/timestamp_cache_update.dta" );
$cache_update_time[0] = $cache_update_time[0] + $home_time;
if ( date ( "d.m.Y" , $cache_update_time[0] ) == date ( "d.m.Y", time () + $home_time ) ) { $last_cache_update = strftime ( "%H:%M ".$lang_counter[11], $cache_update_time[0] ); }
else { $last_cache_update = strftime ( "%d.%m.%y - %H:%M ".$lang_counter[11], $cache_update_time[0] ); }
//------------------------------------------------------------------------------
// function page impressions
function file_row_size_big ( $file )
 {
  $counter = trim( `wc --lines < $file` );   // only Unix/Linux server
  if ( $counter != "" ) { return $counter; }
  $counter = 0;
  $logfile = fopen ( $file , "r" );
  if ( $logfile == FALSE ) { return $counter; }
  while ( !FEOF ( $logfile ) )
   {
    $logfile_entry = fgets ( $logfile , 60000 );
    $counter++;
   }
  fclose ( $logfile       );
  unset  ( $logfile       );
  unset  ( $logfile_entry );

  return $counter;
 }
//------------------------------------------------------------------------------
// page impressions
if ( $db_active == 1 )
 {
  //------------------------------------------------------------------
  $query          = "SELECT COUNT(*) from ".$db_prefix."_main";
  $result         = db_query ( $query , 1 , 0 );
  $pageimpression = $result[0][0];
  //------------------------------------------------------------------
 }
else
 {
  $pageimpression = file_row_size_big ( "log/logdb_backup.dta" );
 }
//------------------------------------------------------------------------------
// function month trend
$average_visitors_this_month = (int) round ( $visitor_month [ date ( "Y/m" ) ] / date ( "j" ) );

$visitor_lastmonth_count = date ( "j" );
$visitor_lastmonth_count = "-".$visitor_lastmonth_count." days";

$visitors_last_month = $visitor_month [ date ( "Y/m" , strtotime ( $visitor_lastmonth_count ) + $home_time ) ];
$number_of_days_last_month = date ( "t" , strtotime ( $visitor_lastmonth_count ) + $home_time );
$average_visitors_last_month = (int) round ( $visitors_last_month / date ( "t" , strtotime ( $visitor_lastmonth_count ) + $home_time ) );

if ( $average_visitors_this_month >= $average_visitors_last_month )
 {
  $month_trend = "<img src=\"images/counter_trend_up.png\" style=\"vertical-align:bottom;\" alt=\"\" /> +".(int) round ( ( ( $average_visitors_this_month - $average_visitors_last_month) / $average_visitors_last_month ) *100 )."%";
 }
else
 {
  $month_trend = "<img src=\"images/counter_trend_down.png\" style=\"vertical-align:bottom;\" alt=\"\" /> ".(int) round ( ( ( $average_visitors_this_month - $average_visitors_last_month) / $average_visitors_last_month ) *100 )."%";
 }
//------------------------------------------------------------------------------
// make footer content
$middot = " &nbsp;&nbsp;&nbsp;<font size=\"1\">&loz;&nbsp;&loz;&nbsp;&loz;</font>&nbsp;&nbsp;&nbsp; ";

if ( $counter_display_show_footer_ticker == 1 )
 {
  if ( $counter_display_show_footer_info1 == 1 )
   {
    $footer_content1 = $middot.$lang_counter[9].": ".$first_timestamp_ticker;
   }
  if ( $counter_display_show_footer_info2 == 1 )
   {
    $footer_content2 = $middot.$lang_counter[10].": ".$last_cache_update;
   }
  if ( $counter_display_show_footer_info3 == 1 )
   {
    $footer_content3 = $middot.$lang_counter[12].": ".number_format ( $pageimpression , 0 , "," , "." );
   }
  if ( $counter_display_show_footer_info4 == 1 )
   {
    $footer_content4 = $middot.$lang_counter[13].": ".$month_trend;
   }
  $footer_content = "<script type=\"text/javascript\">/* <![CDATA[ */ document.write('".$footer_content1.$footer_content2.$footer_content3.$footer_content4."'); /*  ]]> */</script><noscript>".$lang_counter[8].": ".$first_timestamp."</noscript>";
 }
else
 {
  $footer_content = $lang_counter[8].": ".$first_timestamp;
 }
//------------------------------------------------------------------------------
include ( "func/html_header.php" ); // include html header
//------------------------------------------------------------------------------
echo "<center>\n";
################################################################################
### display the stat modules ###
if ( $visitor_year )
 {
  $visitor_per_year = array_sum ( $visitor_year ) ;
 }
else
 {
  $visitor_per_year = 0;
 }
//------------------------------------------------------------------------------
if ( !$visitors_online ) // if no visitors online have been counted
 {
  $visitors_online = 0;
 }
//------------------------------------------------------------------------------
display_overview ( "<div class=\"counter_user\">Besucher</div>" ,
                   $lang_counter[2],
                   $visitors_online ,
                   $lang_counter[3] ,
                   $visitor_day [ date ( "y/m/d" , time ( ) + $home_time ) ] ,
                   $lang_counter[4] ,
                   $visitor_yesterday ,
                   date ( "m/Y" , time ( ) + $home_time ),
                   $visitor_month [ date ( "Y/m" , time ( ) + $home_time ) ] ,
                   date ( "m/Y" , strtotime ( $visitor_lastmonth_count ) + $home_time ) ,
                   $visitor_lastmonth ,
                   $lang_counter[5] ,
                   max ( $visitor_day ),
                   $lang_counter[6] ,
                   $average ,
                   $lang_counter[7] ,
                   $visitor_per_year ,
                   $footer_content,
                   "Seitenaufrufe" ,
                   $pageimpression,
                   $lang_counter[8],
                   $first_timestamp );
//------------------------------------------------------------------------------
echo '</center>';
//------------------------------------------------------------------------------
echo "
<script type=\"text/javascript\">
marqueeInit({
	uniqueid: 'mycrawler',
	style: {
		'padding': '0px',
		'width': '100%',
		'background': 'transparent'
	},
	inc: 2, //speed - pixel increment for each iteration of this marquee's movement
	mouse: 'cursor driven', //mouseover behavior ('pause' 'cursor driven' or false)
	moveatleast: 2,
	neutral: 150,
	savedirection: true
});
</script>";
################################################################################
include ( "func/html_footer.php" ); // include html footer
################################################################################
?>