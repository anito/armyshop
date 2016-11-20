<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.9.x                                                    #
# File-Release-Date:  15/10/27                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2015 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
function display_overview ( $title , &$text1 , &$module1 , &$text2 , &$module2 , &$text3 , &$module3 , &$text4 , &$module4 , &$text5 , &$module5 , &$text6 , $module6 , &$text7 , &$module7 , &$width )
 {
  include ( "config/config.php" ); // include path to logfile
  //----------------------------------------------------------------------------
  // timestamp detection
  $time_stamp_temp = time ();
  if ( $server_time == "+14h"    ) { $time_stamp_temp = $time_stamp_temp + 14 * 3600; }
  if ( $server_time == "+13,75h" ) { $time_stamp_temp = $time_stamp_temp + 13 * 3600 + 2700; }
  if ( $server_time == "+13h"    ) { $time_stamp_temp = $time_stamp_temp + 13 * 3600; }
  if ( $server_time == "+12,75h" ) { $time_stamp_temp = $time_stamp_temp + 12 * 3600 + 2700; }
  if ( $server_time == "+12h"    ) { $time_stamp_temp = $time_stamp_temp + 12 * 3600; }
  if ( $server_time == "+11,5h"  ) { $time_stamp_temp = $time_stamp_temp + 11 * 3600 + 1800; }
  if ( $server_time == "+11h"    ) { $time_stamp_temp = $time_stamp_temp + 11 * 3600; }
  if ( $server_time == "+10,5h"  ) { $time_stamp_temp = $time_stamp_temp + 10 * 3600 + 1800; }
  if ( $server_time == "+10h"    ) { $time_stamp_temp = $time_stamp_temp + 10 * 3600; }
  if ( $server_time == "+9,5h"   ) { $time_stamp_temp = $time_stamp_temp +  9 * 3600 + 1800; }
  if ( $server_time == "+9h"     ) { $time_stamp_temp = $time_stamp_temp +  9 * 3600; }
  if ( $server_time == "+8h"     ) { $time_stamp_temp = $time_stamp_temp +  8 * 3600; }
  if ( $server_time == "+7h"     ) { $time_stamp_temp = $time_stamp_temp +  7 * 3600; }
  if ( $server_time == "+6,5h"   ) { $time_stamp_temp = $time_stamp_temp +  6 * 3600 + 1800; }
  if ( $server_time == "+6h"     ) { $time_stamp_temp = $time_stamp_temp +  6 * 3600; }
  if ( $server_time == "+5,75h"  ) { $time_stamp_temp = $time_stamp_temp +  5 * 3600 + 2700; }
  if ( $server_time == "+5,5h"   ) { $time_stamp_temp = $time_stamp_temp +  5 * 3600 + 1800; }
  if ( $server_time == "+5h"     ) { $time_stamp_temp = $time_stamp_temp +  5 * 3600; }
  if ( $server_time == "+4,5h"   ) { $time_stamp_temp = $time_stamp_temp +  4 * 3600 + 1800; }
  if ( $server_time == "+4h"     ) { $time_stamp_temp = $time_stamp_temp +  4 * 3600; }
  if ( $server_time == "+3,5h"   ) { $time_stamp_temp = $time_stamp_temp +  3 * 3600 + 1800; }
  if ( $server_time == "+3h"     ) { $time_stamp_temp = $time_stamp_temp +  3 * 3600; }
  if ( $server_time == "+2h"     ) { $time_stamp_temp = $time_stamp_temp +  2 * 3600; }
  if ( $server_time == "+1h"     ) { $time_stamp_temp = $time_stamp_temp +  1 * 3600; }
  if ( $server_time == "-1h"     ) { $time_stamp_temp = $time_stamp_temp -  1 * 3600; }
  if ( $server_time == "-2h"     ) { $time_stamp_temp = $time_stamp_temp -  2 * 3600; }
  if ( $server_time == "-3h"     ) { $time_stamp_temp = $time_stamp_temp -  3 * 3600; }
  if ( $server_time == "-3,5h"   ) { $time_stamp_temp = $time_stamp_temp -  3 * 3600 - 1800; }
  if ( $server_time == "-4h"     ) { $time_stamp_temp = $time_stamp_temp -  4 * 3600; }
  if ( $server_time == "-4,5h"   ) { $time_stamp_temp = $time_stamp_temp -  4 * 3600 - 1800; }
  if ( $server_time == "-5h"     ) { $time_stamp_temp = $time_stamp_temp -  5 * 3600; }
  if ( $server_time == "-6h"     ) { $time_stamp_temp = $time_stamp_temp -  6 * 3600; }
  if ( $server_time == "-7h"     ) { $time_stamp_temp = $time_stamp_temp -  7 * 3600; }
  if ( $server_time == "-8h"     ) { $time_stamp_temp = $time_stamp_temp -  8 * 3600; }
  if ( $server_time == "-9h"     ) { $time_stamp_temp = $time_stamp_temp -  9 * 3600; }
  if ( $server_time == "-9,5h"   ) { $time_stamp_temp = $time_stamp_temp -  9 * 3600 - 1800; }
  if ( $server_time == "-10h"    ) { $time_stamp_temp = $time_stamp_temp - 10 * 3600; }
  if ( $server_time == "-11h"    ) { $time_stamp_temp = $time_stamp_temp - 11 * 3600; }
  if ( $server_time == "-12h"    ) { $time_stamp_temp = $time_stamp_temp - 12 * 3600; }
  //----------------------------------------------------------------------------
  echo "\n<table class=\"overview_table\" width=\"".$width."\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
  echo "<tr><td class=\"overview_header\" colspan=\"2\"><img src=\"images/pixel.gif\" height=\"13\" align=\"right\" alt=\"\" title=\"\" />".$title."</td></tr>\n";
  echo "<tr><td class=\"overview_data\">".$text1."</td><td class=\"overview_hits\">".number_format ( ($module1+$stat_add_visitors) , 0 , "," , "." )."</td></tr>";
  echo "<tr><td class=\"overview_data\"><a href=\"javascript:void(0)\" onclick=\"quick_archive('index.php?action=backtostat&from_timestamp=".date ( "d-m-Y" , $time_stamp_temp )."&until_timestamp=".date ( "d-m-Y" , $time_stamp_temp )."');\" title=\"\">".$text2."</a></td><td class=\"overview_hits\">".number_format ( $module2 , 0 , "," , "." )."</td></tr>\n";
  echo "<tr><td class=\"overview_data\"><a href=\"javascript:void(0)\" onclick=\"quick_archive('index.php?action=backtostat&from_timestamp=".date ( "d-m-Y" , strtotime ( "-1 day" , $time_stamp_temp ) )."&until_timestamp=".date ( "d-m-Y" , strtotime ( "-1 day" , $time_stamp_temp ) )."');\" title=\"\">".$text3."</a></td><td class=\"overview_hits\">".number_format ( $module3 , 0 , "," , "." )."</td></tr>\n";
  echo "<tr><td class=\"overview_data\"><a href=\"javascript:void(0)\" onclick=\"quick_archive('index.php?action=backtostat&from_timestamp=".date ( "d-m-Y" , mktime ( 0 , 0 , 0 , date ( "m" , $time_stamp_temp ) , 1 , date ( "Y" , $time_stamp_temp ) ) )."&until_timestamp=".date ( "d-m-Y" , mktime ( 23 , 59 , 59 , date ( "m" , $time_stamp_temp ) , date ( "t" , $time_stamp_temp ) , date ( "Y" , $time_stamp_temp ) ) )."');\" title=\"\">".$text4."</a></td><td class=\"overview_hits\">".number_format ( $module4 , 0 , "," , "." )."</td></tr>\n";
  echo "<tr><td class=\"overview_data\"><a href=\"javascript:void(0)\" onclick=\"quick_archive('index.php?action=backtostat&from_timestamp=".date ( "d-m-Y" , mktime ( 0 , 0 , 0 , date ( "m" , $time_stamp_temp ) -1 , 1 , date ( "Y" , $time_stamp_temp ) ) )."&until_timestamp=".date ( "d-m-Y" , mktime ( 23 , 59 , 59 , date ( "m" , $time_stamp_temp ) , ( date ( "d" , $time_stamp_temp ) - date ( "d" , $time_stamp_temp ) ) , date ( "Y" , $time_stamp_temp ) ) )."');\" title=\"\">".$text5."</a></td><td class=\"overview_hits\">".number_format ( $module5 , 0 , "," , "." )."</td></tr>\n";
  echo "<tr><td class=\"overview_data\">".$text6."</td><td class=\"overview_hits\">".number_format ( $module6 , 0 , "," , "." )."</td></tr>\n";
  echo "<tr><td class=\"overview_data\">".$text7."</td><td class=\"overview_hits\">".number_format ( $module7 , 0 , "," , "." )."</td></tr>\n";
  echo "</table>\n";
 }
//------------------------------------------------------------------------------
function display ( $title , &$title2 , &$hits , &$bar , &$module_data , $width , $count , &$unknown , &$value_change , $value_max , $detail_link , $flags , $browser_icons , $os_icons , $year_sort )
 {
  include ( "config/config.php" ); // include path to logfile
  include ( $language           ); // include language vars
  //----------------------------------------------------------------------------
  $count_all   = count ( $module_data ); // amount of array lines
  if ( $year_sort == 1 ) { krsort ( $module_data ); } // desc sort for years module
  $module_data = array_slice ( $module_data , 0 , $count ); // slice the array, cause you want only see x entries
  if ( $year_sort == 1 ) { ksort ( $module_data ); } // asc sort for years module
  //----------------------------------------------------------------------------
  // cut after x chars
  if ( $detail_link == "y" )
   {
    if ( strpos ( $_SERVER [ "HTTP_USER_AGENT" ] , "MSIE" ) > 0 ) { $width_cut = 90; }
    else { $width_cut = 83; }
   }
  else
   {
    if ($width > 300)
     {
      if ( strpos ( $_SERVER [ "HTTP_USER_AGENT" ] , "MSIE" ) > 0 ) { $width_cut = ( $width - 236 ) / 7.7; }
      else { $width_cut = ( $width - 236 ) / 7.5; }
     }
    else { $width_cut = $width - 236; }
   }
  //----------------------------------------------------------------------------
  echo "\n<table class=\"stat_table\" width=\"".$width."\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
  //----------------------------------------------------------------------------
  if ( $detail_link == "x" )
   {
    if ( ( $_GET [ "archive" ] ) || ( $_GET [ "archive_save" ] ) )
     {
     	echo "<tr><td class=\"stat_header\" colspan=\"4\"><a href=\"#top\"><img src=\"images/top.png\" align=\"right\" width=\"16\" height=\"13\" alt=\"Top\" title=\"Top\" /></a>".$title."</td></tr>\n";
     }
    else
     {
     	echo "<tr><td class=\"stat_header\" colspan=\"4\">".$title."</td></tr>\n";
     }
   }
  else
   {
    if ( $detail_link == "y" )
     {
      echo "<thead>\n<tr><td class=\"stat_header\" colspan=\"4\"><img src=\"images/pixel.gif\" height=\"13\" align=\"right\" alt=\"\" title=\"\" />".$title."</td></tr>\n</thead>\n";
     }
    else
     {
      if ( $detail_link == "referer"                      ) { $window_size = "width:900 height:550"; $window_title = "".$lang_detail[2].""; }
      if ( $detail_link == "site_name"                    ) { $window_size = "width:900 height:550"; $window_title = "".$lang_detail[2].""; }
      if ( $detail_link == "pattern_resolution.dta"       ) { $window_size = "width:400 height:550"; $window_title = "".$lang_detail[2].""; }
      if ( $detail_link == "pattern_operating_system.dta" ) { $window_size = "width:550 height:550"; $window_title = "".$lang_detail[2].""; }
      if ( $detail_link == "pattern_browser.dta"          ) { $window_size = "width:500 height:550"; $window_title = "".$lang_detail[2].""; }
      if ( $detail_link == "visitors_per_day"             ) { $window_size = "width:350 height:550"; $window_title = "".$lang_detail[2].""; }
      if ( $detail_link == "visitors_per_month"           ) { $window_size = "width:350 height:550"; $window_title = "".$lang_detail[2].""; }
      if ( $detail_link == "trends_year"                  ) { $window_size = "width:590 height:200"; $window_title = "Trends" ; }
      if ( $detail_link == "country"                      ) { $window_size = "width:600 height:550"; $window_title = "".$lang_detail[2].""; }
      if ( $detail_link == "searchwords_archive"          ) { $window_size = "width:800 height:550"; $window_title = "".$lang_detail[2].""; }
      if ( $detail_link == "searchengines_archive"        ) { $window_size = "width:600 height:550"; $window_title = "".$lang_detail[2].""; }
      if ( $detail_link == "entrysite"                    ) { $window_size = "width:900 height:550"; $window_title = "".$lang_detail[2].""; }

      if ( $detail_link == "searchwords_archive" )
       {
       	if ( ( $_GET [ "archive" ] ) || ( $_GET [ "archive_save" ] ) )
         {
          if ( substr ( $_GET [ "archive_save" ] , 0 , 3 ) == "log" )
           {
            echo "<tr><td class=\"stat_header\" colspan=\"4\"><a href=\"#top\"><img src=\"images/top.png\" align=\"right\" width=\"16\" height=\"13\" alt=\"Top\" title=\"Top\" /></a><a href=\"detail_view.php?archive_save=".$_GET [ "archive_save" ]."&detail_logfile=searchwords_archive_special\" rel=\"floatboxFoobar\" rev=\"showItemNumber:false navType:none ".$window_size."\" title=\"".$window_title."\"><img src=\"images/detail2.png\" align=\"right\" width=\"21\" height=\"13\" alt=\"".$lang_detail[4]."\" title=\"".$lang_detail[4]."\" /></a><a href=\"detail_view.php?archive_save=".$_GET [ "archive_save" ]."&detail_logfile=".$detail_link."\" rel=\"floatboxFoobar\" rev=\"showItemNumber:false navType:none ".$window_size."\" title=\"".$window_title."\"><img src=\"images/detail.png\" align=\"right\" width=\"21\" height=\"13\" alt=\"".$lang_detail[3]."\" title=\"".$lang_detail[3]."\" /></a>".$title."</td></tr>\n";
           }
          else // if there is  no archive saved, kill the detail
           {
            echo "<tr><td class=\"stat_header\" colspan=\"4\"><a href=\"#top\"><img src=\"images/top.png\" align=\"right\" width=\"16\" height=\"13\" alt=\"Top\" title=\"Top\" /></a><a href=\"detail_view.php?archive=1&detail_logfile=searchwords_archive_special\" rel=\"floatboxFoobar\" rev=\"showItemNumber:false navType:none ".$window_size."\" title=\"".$window_title."\"><img src=\"images/detail2.png\" align=\"right\" width=\"21\" height=\"13\" alt=\"".$lang_detail[4]."\" title=\"".$lang_detail[4]."\" /></a><a href=\"detail_view.php?archive=1&detail_logfile=".$detail_link."\" rel=\"floatboxFoobar\" rev=\"showItemNumber:false navType:none ".$window_size."\" title=\"".$window_title."\"><img src=\"images/detail.png\" align=\"right\" width=\"21\" height=\"13\" alt=\"".$lang_detail[3]."\" title=\"".$lang_detail[3]."\" /></a>".$title."</td></tr>\n";
           }
         }
        else
         {
       	  echo "<tr><td class=\"stat_header\" colspan=\"4\"><a href=\"detail_view.php?detail_logfile=searchwords_archive_special\" rel=\"floatboxFoobar\" rev=\"showItemNumber:false navType:none ".$window_size."\" title=\"".$window_title."\"><img src=\"images/detail2.png\" align=\"right\" width=\"21\" height=\"13\" alt=\"".$lang_detail[4]."\" title=\"".$lang_detail[4]."\" /></a><a href=\"detail_view.php?detail_logfile=".$detail_link."\" rel=\"floatboxFoobar\" rev=\"showItemNumber:false navType:none ".$window_size."\" title=\"".$window_title."\"><img src=\"images/detail.png\" align=\"right\" width=\"21\" height=\"13\" alt=\"".$lang_detail[3]."\" title=\"".$lang_detail[3]."\" /></a>".$title."</td></tr>\n";
         }
       }
      else
       {
       	if ( ( $_GET [ "archive" ] ) || ( $_GET [ "archive_save" ] ) )
         {
          if ( substr ( $_GET [ "archive_save" ] , 0 , 3 ) == "log" )
           {
            echo "<tr><td class=\"stat_header\" colspan=\"4\"><a href=\"#top\"><img src=\"images/top.png\" align=\"right\" width=\"16\" height=\"13\" alt=\"Top\" title=\"Top\" /></a><a href=\"detail_view.php?archive_save=".$_GET [ "archive_save" ]."&detail_logfile=".$detail_link."\" rel=\"floatboxFoobar\" rev=\"showItemNumber:false navType:none ".$window_size."\" title=\"".$window_title."\"><img src=\"images/detail.png\" align=\"right\" width=\"21\" height=\"13\" alt=\"".$lang_detail[1]."\" title=\"".$lang_detail[1]."\" /></a>".$title."</td></tr>\n";
           }
          else // if there is  no archive saved, kill the detail
           {
            echo "<tr><td class=\"stat_header\" colspan=\"4\"><a href=\"#top\"><img src=\"images/top.png\" align=\"right\" width=\"16\" height=\"13\" alt=\"Top\" title=\"Top\" /></a><a href=\"detail_view.php?archive=1&detail_logfile=".$detail_link."\" rel=\"floatboxFoobar\" rev=\"showItemNumber:false navType:none ".$window_size."\" title=\"".$window_title."\"><img src=\"images/detail.png\" align=\"right\" width=\"21\" height=\"13\" alt=\"".$lang_detail[1]."\" title=\"".$lang_detail[1]."\" /></a>".$title."</td></tr>\n";
           }
         }
        else
         {
         	if ( ( $detail_link == "visitors_per_month" ) || ( $detail_link == "trends_year" ) )
         	 {
         	  if ( $detail_link == "visitors_per_month" )
         	   {
         	    echo "<tr><td class=\"stat_header\" colspan=\"4\"><a href=\"detail_view.php?detail_logfile=trends_month\" rel=\"floatboxFoobar\" rev=\"showItemNumber:false navType:none width:610 height:550\" title=\"Trends\"><img src=\"images/trend.png\" align=\"right\" width=\"16\" height=\"13\" alt=\"Trends\" title=\"Trends\" /></a><a href=\"detail_view.php?detail_logfile=".$detail_link."\" rel=\"floatboxFoobar\" rev=\"showItemNumber:false navType:none ".$window_size."\" title=\"".$window_title."\"><img src=\"images/detail.png\" align=\"right\" width=\"21\" height=\"13\" alt=\"".$lang_detail[1]."\" title=\"".$lang_detail[1]."\" /></a>".$title."</td></tr>\n";
         	   }
         	  if ( $detail_link == "trends_year" )
         	   {
         	    echo "<tr><td class=\"stat_header\" colspan=\"4\"><a href=\"detail_view.php?detail_logfile=".$detail_link."\" rel=\"floatboxFoobar\" rev=\"showItemNumber:false navType:none ".$window_size."\" title=\"".$window_title."\"><img src=\"images/trend.png\" align=\"right\" width=\"16\" height=\"13\" alt=\"Trends\" title=\"Trends\" /></a>".$title."</td></tr>\n";
         	   }
         	 }
         	else
         	 {
         	  echo "<tr><td class=\"stat_header\" colspan=\"4\"><a href=\"detail_view.php?detail_logfile=".$detail_link."\" rel=\"floatboxFoobar\" rev=\"showItemNumber:false navType:none ".$window_size."\" title=\"".$window_title."\"><img src=\"images/detail.png\" align=\"right\" width=\"21\" height=\"13\" alt=\"".$lang_detail[1]."\" title=\"".$lang_detail[1]."\" /></a>".$title."</td></tr>\n";
         	 }
         }
       }
     }
   }
  //----------------------------------------------------------------------------
  echo "<tbody>\n";
  echo "<tr><td class=\"stat_module_data\"><b>".$title2."</b></td><td class=\"stat_hits\"><b>".$hits."</b></td><td class=\"stat_slidebar\"><center><b>".$bar."</b></center></td><td class=\"stat_percent\">&nbsp;</td></tr>\n";
  //----------------------------------------------------------------------------
  $max_value = max ( $module_data ); // get the maximum value of the array
  //----------------------------------------------------------------------------
  foreach ( $module_data as $key => $value )
   {
    // if visitor_day module, delete the year
    if ( $value_change == 1 )
     {
      $key = substr ( $key , 3 );
     }
    //--------------------------------------
    // if visitor_month module, first the month, then the year
    if ( $value_change == 2 )
     {
      $key = substr ( $key , 5 )."/".substr ( $key , 0 , 4 );
     }
    //--------------------------------------
    echo "<tr><td class=\"stat_module_data\">";
    if ( ( trim ( $key ) == "" ) || ( $key == "unknown" ) || ( $key == "Unknown" ) || ( $key == "---" ) )
     {
      if ( $value == $max_value ) { echo "<span class=\"display_max_style\">"; }
      //--------------------------------------
      if ( ( $show_browser_icons == 1 ) && ( $detail_link == "pattern_browser.dta" ) )
       {
        echo '<img src="images/browser_icons/'.browser_matching ( $key ).'.png" width="14" height="14" style="vertical-align:middle;" alt="" />&nbsp;';
       }
      if ( ( $show_browser_icons == 1 ) && ( $_GET [ "detail_logfile" ] == "pattern_browser.dta" ) )
       {
        echo '<img src="images/browser_icons/'.browser_matching ( $key ).'.png" width="14" height="14" style="vertical-align:middle;" alt="" />&nbsp;';
       }
      //--------------------------------------
      if ( ( $show_os_icons == 1 ) && ( $detail_link == "pattern_operating_system.dta" ) )
       {
        echo '<img src="images/os_icons/'.os_matching ( $key ).'.png" width="14" height="14" style="vertical-align:middle;" alt="" />&nbsp;';
       }
      if ( ( $show_os_icons == 1 ) && ( $_GET [ "detail_logfile" ] == "pattern_operating_system.dta" ) )
       {
        echo '<img src="images/os_icons/'.os_matching ( $key ).'.png" width="14" height="14" style="vertical-align:middle;" alt="" />&nbsp;';
       }
      //--------------------------------------
      echo $unknown;
      if ( $value == $max_value ) { echo "</span>"; }
     }
    else
     {
      if ( substr ( $key , 0 , 4 ) == "http" )
       {
        if ( ( strpos ( $key , "google." ) > 0 ) && ( strpos ( $key , "url?q=" ) > 0 ) )
         {
          $key = str_replace ( "url?q=" , "search?q=" , $key );
         }
        echo "<a class=\"referer\" href=\"".$key."\" target=\"_blank\">";
        if ( strlen ( $key ) > $width_cut )
         {
          if ( $value == $max_value ) { echo "<span class=\"display_max_style\">"; }
          echo substr ( $key , 0 , $width_cut )."...";
          if ( $value == $max_value ) { echo "</span>"; }
          echo "</a>";
         }
        else
         {
          if ( $value == $max_value ) { echo "<span class=\"display_max_style\">"; }
          echo $key;
        if ( $value == $max_value ) { echo "</span>"; }
          echo "</a>";
         }
       }
      else
       {
        if ( strlen ( $key ) > $width_cut )
         {
          if ( $value == $max_value ) { echo "<span class=\"display_max_style\">"; }
          //--------------------------------------
          if ( ( $show_country_flags == 1 ) && ( $flags == 1 ) )
           {
            if ( $key == $lang_module[3] )
             {
              echo "<img src=\"images/country_flags/unknown.png\" width=\"20\" height=\"13\" alt=\"\" />&nbsp;";
             }
            else
             {
              echo "<img src=\"images/country_flags/".str_replace ( ")" , "" , substr ( strrchr ( $key , "(" ) , 1 ) ).".png\" width=\"20\" height=\"13\" alt=\"\" />&nbsp;";
             }
           }
          //--------------------------------------
          if ( ( $show_browser_icons == 1 ) && ( $browser_icons == 1 ) )
           {
            echo '<img src="images/browser_icons/'.browser_matching ( $key ).'.png" width="14" height="14" style="vertical-align:middle;" alt="" />&nbsp;';
           }
          //--------------------------------------
          if ( ( $show_os_icons == 1 ) && ( $os_icons == 1 ) )
           {
            echo '<img src="images/os_icons/'.os_matching ( $key ).'.png" width="14" height="14" style="vertical-align:middle;" alt="" />&nbsp;';
           }
          //--------------------------------------
          echo substr ( $key , 0, $width_cut)."...";
          if ( $value == $max_value ) { echo "</span>"; }
         }
        else
         {
          if ( $value == $max_value ) { echo "<span class=\"display_max_style\">"; }
          //--------------------------------------
          if ( ( $show_country_flags == 1 ) && ( $flags == 1 ) )
           {
            if ( $key == $lang_module[3] )
             {
              echo "<img src=\"images/country_flags/unknown.png\" width=\"20\" height=\"13\" alt=\"\" />&nbsp;";
             }
            else
             {
              echo "<img src=\"images/country_flags/".str_replace ( ")" , "" , substr ( strrchr ( $key , "(" ) , 1 ) ).".png\" width=\"20\" height=\"13\" alt=\"\" />&nbsp;";
             }
           }
          //--------------------------------------
          if ( ( $show_browser_icons == 1 ) && ( $browser_icons == 1 ) )
           {
            echo '<img src="images/browser_icons/'.browser_matching ( $key ).'.png" width="14" height="14" style="vertical-align:middle;" alt="" />&nbsp;';
           }
          //--------------------------------------
          if ( ( $show_os_icons == 1 ) && ( $os_icons == 1 ) )
           {
            echo '<img src="images/os_icons/'.os_matching ( $key ).'.png" width="14" height="14" style="vertical-align:middle;" alt="" />&nbsp;';
           }
          //--------------------------------------
          echo $key;
          if ( $value == $max_value ) { echo "</span>"; }
         }
       }
     }
    echo "</td>";
    //--------------------------------------
    echo "<td class=\"stat_hits\">";
    if ( $value == $max_value ) { echo "<span class=\"display_max_style\">"; }
    echo number_format ( $value , 0 , "," , "." );
    if ( $value == $max_value ) { echo "</span>"; }
    echo "</td>";
    //--------------------------------------
    if ( $value_max == 0 )
     {
      $howmuch_1 = 0;
      $howmuch_2 = 100;
     }
    else
     {
      if ( $percentbar_max_value_1 == 0 ) { $sum_total = $value_max; }
      if ( $percentbar_max_value_1 == 1 ) { $sum_total = array_sum ( $module_data ); }

      $howmuch_1 = ( int ) round ( $value / $sum_total * 100 );
      $howmuch_2 = ( int ) 100 - ( $value / $sum_total * 100 );

      if ( $percentbar_max_value_2 == 1 )
       {
        $pos_bg_img = ( int ) round ( $value / max ( $module_data ) * 100 - 100 );
        $width_print_img1 = ( int ) round ( $value / max ( $module_data ) * 100 );
        $width_print_img2 = ( int ) 100 - round ( $value / max ( $module_data ) * 100 );
        $pos_print_img2 = ( int ) round ( $value / max ( $module_data ) * 100 + 1 );
       }
      else
       {
        $pos_bg_img = ( int ) round ( $value / $sum_total * 100 - 100 );
        $width_print_img1 = ( int ) round ( $value / $sum_total * 100 );
        $width_print_img2 = ( int ) 100 - round ( $value / $sum_total * 100 );
        $pos_print_img2 = ( int ) round ( $value / $sum_total * 100 + 1 );
       }
     }
    //--------------------------------------
    echo "<td class=\"stat_slidebar\">";
    if ( trim ( $howmuch_2 ) == "100" )
     {
       echo "<div style=\"position: relative; margin: 0px auto; width: 102px; height: 10px; border: none;\"><div style=\"position: absolute; top: 0px; left: 0px;\"><img class=\"percent\" src=\"".$theme."percentimage_front.gif\" width=\"102\" height=\"10\" alt=\"0%\" title=\"0%\" style=\"background-position: -100px 0pt;\" /></div><div class=\"print\" style=\"position: absolute; top: 1px; left: 1px;\"><img src=\"".$theme."percentimage_print1.gif\" width=\"0\" height=\"8\" alt=\"\" /></div><div class=\"print\" style=\"position: absolute; top: 1px; left: 1px;\"><img src=\"".$theme."percentimage_print2.gif\" width=\"100\" height=\"8\" alt=\"\" /></div></div>";
     }
    else
     {
      if ( trim ( $howmuch_2 ) == "0" )
       {
        echo "<div style=\"position: relative; margin: 0px auto; width: 102px; height: 10px; border: none;\"><div style=\"position: absolute; top: 0px; left: 0px;\"><img class=\"percent\" src=\"".$theme."percentimage_front.gif\" width=\"102\" height=\"10\" alt=\"100%\" title=\"100%\" style=\"background-position: 0px 0pt;\" /></div><div class=\"print\" style=\"position: absolute; top: 1px; left: 1px;\"><img src=\"".$theme."percentimage_print1.gif\" width=\"100\" height=\"8\" alt=\"\" /></div><div class=\"print\" style=\"position: absolute; top: 1px; left: 101px;\"><img src=\"".$theme."percentimage_print2.gif\" width=\"0\" height=\"8\" alt=\"\" /></div></div>";
       }
      else
       {
        echo "<div style=\"position: relative; margin: 0px auto; width: 102px; height: 10px; border: none;\"><div style=\"position: absolute; top: 0px; left: 0px;\"><img class=\"percent\" src=\"".$theme."percentimage_front.gif\" width=\"102\" height=\"10\" alt=\"".$howmuch_1."%\" title=\"".$howmuch_1."%\" style=\"background-position: ".$pos_bg_img."px 0pt;\" /></div><div class=\"print\" style=\"position: absolute; top: 1px; left: 1px;\"><img src=\"".$theme."percentimage_print1.gif\" width=\"".$width_print_img1."\" height=\"8\" alt=\"\" /></div><div class=\"print\" style=\"position: absolute; top: 1px; left: ".$pos_print_img2."px;\"><img src=\"".$theme."percentimage_print2.gif\" width=\"".$width_print_img2."\" height=\"8\" alt=\"\" /></div></div>";
       }
     }
    echo "</td>";
    //--------------------------------------
    echo "<td class=\"stat_percent\">";
    if ( $value == $max_value ) echo "<span class=\"display_max_style\">";
    echo $howmuch_1."%";
    if ( $value == $max_value ) echo "</span>";
    echo "</td></tr>\n";
   }
  //----------------------------------------------------------------------------
  if ( ( $db_active == 1 ) && ( $detail_link == "pattern_resolution.dta" ) ) { $count_all--; } // kill the first ID from pattern table resolution
  echo "</tbody>\n";

  $site_visits = (int) round ( $value_max  / array_sum ( $GLOBALS [ "visitor_year" ] ) );
  echo "<tr><td class=\"stat_footer\" colspan=\"4\">";
  echo "<div style=\"width: 33%; float:left; text-align: left;\">(".number_format ( array_sum ( $module_data ) , 0 , "," , "." )."/".number_format ( $value_max , 0 , "," , "." ).")</div>";
  echo "<div style=\"width: 34%; float:left; text-align: center;\">"; if ( $detail_link == "site_name" ) { echo "&#216; ".$site_visits." ".$lang_site[1]." / ".$lang_overview[1].""; } else { echo "&nbsp;"; } echo "</div>";
  echo "<div style=\"width: 33%; float:left; text-align: right;\">(".number_format ( $count , 0 , "," , "." )."/".number_format ( $count_all , 0 , "," , "." ).")</div>";
  echo "</td></tr>\n";
  echo "</table>\n";
  //----------------------------------------------------------------------------
 }
//------------------------------------------------------------------------------
?>