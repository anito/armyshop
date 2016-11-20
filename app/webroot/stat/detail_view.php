<?php @session_start(); if ( $_SESSION [ "hidden_stat" ] != md5_file ( "config/config.php" ) ) { include ( "func/func_error.php" ); exit; }
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
error_reporting(0);
//------------------------------------------------------------------------------
include ( "config/config.php"                ); // include path to logfile
include ( $language                          ); // include language vars
include ( $language_patterns                 ); // include language country vars
//------------------------------------------------------------------------------
if ( $db_active == 1 )
 {
  include ( "db_connect.php"                 ); // include database connectivity
  include ( "config/config_db.php"           ); // include db_prefix
 }
//------------------------------------------------------------------------------
include ( "func/func_pattern_reverse.php"    ); // include pattern reverse function
include ( "func/func_pattern_matching.php"   ); // include pattern matching function
include ( "func/func_pattern_icons.php"      ); // include pattern icons function
include ( "func/func_kill_special_chars.php" ); // include umlaut function
include ( "func/func_display.php"            ); // include display function
$detail_logfile  = $_GET [ "detail_logfile"  ]; // which module details should be shown
//------------------------------------------------------------------------------
// include the saved arrays, depending on archive yes or no
if ( isset ( $_GET [ "archive_save" ] ) )
 {
  if ( substr ( $_GET [ "archive_save" ] , 0 , 3 ) == "log" ) { include ( $_GET [ "archive_save" ] ); }
 }
elseif ( $_GET [ "archive" ] == 1 )
 {
  include ( "log/cache_visitors_archive.php" );
 }
else { include ( "log/cache_visitors.php" ); }
//------------------------------------------------------------------------------
include ( "func/html_header.php"             ); // include html header with table sorting
//------------------------------------------------------------------------------
// browser
if ( $detail_logfile == "pattern_browser.dta" )
 {
  if ( count ( $browser ) != 0 )
   {
    // check if details of every browser should be displayed
    if ( ( $show_detailed_browser == 0 ) && ( $browser ) )
     {
      foreach ( $browser as $key => $value )
       {
        $browser_simple [ trim ( substr ( $key , 0 , strrpos ( $key , " " ) ) ) ] = $browser_simple [ trim ( substr ( $key , 0 , strrpos ( $key , " " ) ) ) ] + $value;
       }
      $browser = $browser_simple;
     }
	  // consolidates browser version to one minor version
	  if ( ( $show_detailed_browser == 1 ) && ( $browser ) )
	   {
	    foreach ( $browser as $key => $value )
	     {
	  	  if ( ( strpos ( $key , "." ) ) === false )
	  	   {
	  	    $browser_simple [ trim ( $key ) ] = $browser_simple [ trim ( $key ) ] + $value;
	  	   }
	  	  else
	  	   {
	  	    $browser_simple [ trim ( substr ( $key , 0 , strpos ( $key , "." ) + 2 ) ) ] = $browser_simple [ trim ( substr ( $key , 0 , strpos ( $key , "." ) + 2 ) ) ] + $value;
	  	   }
	     }
	    $browser = $browser_simple;
	   }
	  unset ( $browser_simple );
    $max_value = array_sum ( $browser );
    arsort ( $browser );
    display ( "<div class=\"stat_user\">".$lang_browser[1]."</div>" , $lang_browser[2] , $lang_module[1] , $lang_module[2] , $browser , "100%" , count( $browser ) , $lang_module[3] , $delete_year , $max_value , "y" , 0 , 1 , 0 , 0 );
   }
  include ( "func/html_footer.php" );
  exit;
 }
//--------------------------------------------------------------------
// os
if ( $detail_logfile == "pattern_operating_system.dta" )
 {
  if ( count ( $operating_system ) != 0 )
   {
    // check if details of every operating system should be displayed
    if ( ( $show_detailed_os == 0 ) && ( $operating_system ) )
	   {
	    foreach ( $operating_system as $key => $value )
	     {
	  	  $operating_system_simple [ trim ( substr ( $key , 0 , strrpos ( $key , " " ) ) ) ] = $operating_system_simple [ trim ( substr ( $key , 0 , strrpos ( $key , " " ) ) ) ] + $value;
	     }
	    $operating_system = $operating_system_simple;
	   }
	  unset ( $operating_system_simple );
    $max_value = array_sum ( $operating_system );
    arsort ( $operating_system );
    display ( "<div class=\"stat_user\">".$lang_os[1]."</div>" , $lang_os[2] , $lang_module[1] , $lang_module[2] , $operating_system , "100%" , count( $operating_system ) , $lang_module[3] , $delete_year , $max_value , "y" , 0 , 0 , 1 , 0 );
   }
  include ( "func/html_footer.php" );
  exit;
 }
//--------------------------------------------------------------------
// resolotion
if ( $detail_logfile == "pattern_resolution.dta" )
 {
  if ( count ( $resolution ) != 0 )
   {
    $max_value = array_sum ( $resolution );
    arsort ( $resolution );
    display ( "<div class=\"stat_user\">".$lang_resolution[1]."</div>" , $lang_resolution[2] , $lang_module[1] , $lang_module[2] , $resolution , "100%" , count( $resolution ) , $lang_module[3] , $delete_year , $max_value , "y" , 0 , 0 , 0 , 0 );
   }
  include ( "func/html_footer.php" );
  exit;
 }
//--------------------------------------------------------------------
// referer
if ( $detail_logfile == "referer" )
 {
  if ( count ( $referer ) != 0 )
   {
    $max_value = array_sum ( $referer );
    arsort ( $referer );
    display ( "<div class=\"stat_user\">".$lang_referer[1]."</div>" , $lang_referer[2] , $lang_module[1] , $lang_module[2] , $referer , "100%" , 1000 , $lang_module[3] , $delete_year , $max_value , "y" , 0 , 0 , 0 , 0 );
   }
  include ( "func/html_footer.php" );
  exit;
 }
//--------------------------------------------------------------------
// sitename
if ( $detail_logfile == "site_name" )
 {
  if ( count ( $site_name ) != 0 )
   {
    $max_value = array_sum ( $site_name );
    $temp_site_name_array = array ();
    foreach ( $site_name as $key => $value )
     {
      if ( $db_active == 1 )
       {
        $temp_site_name_array [ kill_special_chars ( pattern_matching_reverse ( "site_name_reverse" , $pattern_site_name [ $key ] ) ) ] += $value;
       }
      else
       {
        $temp_site_name_array [ kill_special_chars ( pattern_matching_reverse ( "site_name_reverse" , $pattern_site_name [ $key ] ) ) ] += $value;
       }
     }
    $site_name = $temp_site_name_array;
    unset ( $temp_site_name_array );
    arsort ( $site_name );
    display ( "<div class=\"stat_user\">".$lang_site[1]."</div>" , $lang_site[2] , $lang_module[1] , $lang_module[2] , $site_name , "100%" , count( $site_name ) , $lang_module[3] , $delete_year , $max_value , "y" , 0 , 0 , 0 , 0 );
   }
  include ( "func/html_footer.php" );
  exit;
 }
//--------------------------------------------------------------------
// entrysite
if ( $detail_logfile == "entrysite" )
 {
  if ( count ( $entrysite ) != 0 )
   {
    $max_value = array_sum ( $entrysite );
    $temp_entrysite_array = array ();
    foreach ( $entrysite as $key => $value )
     {
      if ( $db_active == 1 )
       {
        $temp_entrysite_array [ kill_special_chars ( pattern_matching_reverse ( "site_name_reverse" , $pattern_site_name [ $key ] ) ) ] += $value;
       }
      else
       {
        $temp_entrysite_array [ kill_special_chars ( pattern_matching_reverse ( "site_name_reverse" , $pattern_site_name [ $key ] ) ) ] += $value;
       }
     }
    $entrysite = $temp_entrysite_array;
    unset ( $temp_entrysite_array );
    arsort ( $entrysite );
    display ( "<div class=\"stat_user\">".$lang_entrysite[1]."</div>" , $lang_entrysite[2] , $lang_module[1] , $lang_module[2] , $entrysite , "100%" , count( $entrysite ) , $lang_module[3] , $delete_year , $max_value , "y" , 0 , 0 , 0 , 0 );
   }
  include ( "func/html_footer.php" );
  exit;
 }
//--------------------------------------------------------------------
// searchengines_archive
if ( $detail_logfile == "searchengines_archive" )
 {
  if ( count ( $searchengines_archive ) != 0 )
   {
    $max_value = array_sum ( $searchengines_archive );
    arsort ( $searchengines_archive );
    display ( "<div class=\"stat_user\">".$lang_searchengine[1]."</div>" , $lang_searchengine[2] , $lang_module[1] , $lang_module[2] , $searchengines_archive , "100%" , count( $searchengines_archive ) , $lang_module[3] , $delete_year , $max_value , "y" , 0 , 0 , 0 , 0 );
   }
  include ( "func/html_footer.php" );
  exit;
 }
//--------------------------------------------------------------------
// searchwords_special
if ( $detail_logfile == "searchwords_archive_special" )
 {
  if ( count ( $searchwords_archive ) != 0 )
   {
    $searchwords_archive_temp = array ();
     foreach ( $searchwords_archive as $key => $value )
      {
       $key = str_replace( "&quot;" , "" , $key );
       $temp_split = explode ( " " , $key );
       foreach ( $temp_split as $splitted )
        {
         if ( trim ( $splitted ) != "" )
          {
           if ( array_key_exists ( $splitted , $searchwords_archive_temp ) )
            {
             $searchwords_archive_temp [ $splitted ] += $value;
            }
           else
            {
             $searchwords_archive_temp [ $splitted ] = $value;
            }
          }
        }
      }
    $searchwords_archive =  $searchwords_archive_temp;
    unset ( $searchwords_archive_temp );

    $max_value = array_sum ( $searchwords_archive );
    arsort ( $searchwords_archive );
    display ( "<div class=\"stat_user\">".$lang_searchwords[1]."</div>" , $lang_searchwords[2] , $lang_module[1] , $lang_module[2] , $searchwords_archive , "100%" , count( $searchwords_archive ) , $lang_module[3], $delete_year , $max_value , "y"  , 0 , 0 , 0 , 0 );
   }
  include ( "func/html_footer.php" );
  exit;
 }
//--------------------------------------------------------------------
// searchwords
if ( $detail_logfile == "searchwords_archive" )
 {
  if ( count ( $searchwords_archive ) != 0 )
   {
    $max_value = array_sum ( $searchwords_archive );
    arsort ( $searchwords_archive );
    display ( "<div class=\"stat_user\">".$lang_searchwords[1]."</div>" , $lang_searchwords[2] , $lang_module[1] , $lang_module[2] , $searchwords_archive , "100%" , count( $searchwords_archive ) , $lang_module[3], $delete_year , $max_value , "y"  , 0 , 0 , 0 , 0 );
   }
  include ( "func/html_footer.php" );
  exit;
 }
//--------------------------------------------------------------------
// visitors per day
if ( $detail_logfile == "visitors_per_day" )
 {
  if ( count ( $visitor_day ) != 0 )
   {
    $max_value = array_sum ( $visitor_day );
    ksort ( $visitor_day );
    display ( "<div class=\"stat_user\">".$lang_day[3]."</div>" , $lang_day[2] , $lang_module[1] , $lang_module[2] , $visitor_day , "100%" , count( $visitor_day ) , $lang_module[3] , $delete_year , $max_value , "y" , 0 , 0 , 0 , 0 );
   }
  include ( "func/html_footer.php" );
  exit;
 }
//--------------------------------------------------------------------
// visitors per month
if ( $detail_logfile == "visitors_per_month" )
 {
  if ( count ( $visitor_month ) != 0 )
   {
    $max_value = array_sum ( $visitor_month );
    ksort ( $visitor_month );
    display ( "<div class=\"stat_user\">".$lang_month[1]."</div>" , $lang_month[2] , $lang_module[1] , $lang_module[2] , $visitor_month , "100%" , count( $visitor_month ) , $lang_module[3] , $delete_year , $max_value , "y" , 0 , 0 , 0 , 0 );
   }
  include ( "func/html_footer.php" );
  exit;
 }
//--------------------------------------------------------------------
// trends per month
if ( $detail_logfile == "trends_month" )
 {
  include ( "func/func_display_trends.php" );

  if ( count ( $visitor_month ) != 0 )
   {
    //------------------------------------------------------
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
    //---
    //how many days exist in the first year/month the tracking started
    if ( date ( "Y/m" , $real_first_timestamp ) == date ( "Y/m" ) )
     {
      $month_first = ( int ) round ( ( time ( ) - $real_first_timestamp ) / 86400 );
     }
    else
     {
      $month_first = ( int ) round ( ( mktime ( 23 , 59 , 59 , date ( "m" , $real_first_timestamp ) , date ( "t" , $real_first_timestamp ) , date ( "Y" , $real_first_timestamp ) ) - $real_first_timestamp ) / 86400 );
     }
    //---
    foreach ( $visitor_month as $key => $value )
     {
      // if the year/month of the stat start == actual year/month
      if ( date ( "Y/m" , $real_first_timestamp ) == date ( "Y/m" , $key ) )
       {
        $month_complete [ $key ] = ( int ) round ( ( $value / $month_first ) );
       }
      else
       {
        if ( date ( "Y/m" ) == date ( "Y/m" , $key ) )
         {
          if ( date ( "Y/m" ) == date ( "Y/m" , $real_first_timestamp ) )
           {
            $month_complete [ $key ] = ( int ) round ( ( $value / $month_first ) );
           }
          else
           {
            $temp = ( int ) round ( ( time ( ) - mktime ( 0 , 0 , 1 , date ( "m" ) , 1 , date ( "Y" ) ) ) / 86400 );
            $month_complete [ $key ] = ( int ) round ( ( $value / $temp ) );
            unset ( $temp );
           }
         }
        else
         {
          $month_complete [ $key ] = ( int ) round ( ( $value / date ( "t" , mktime ( 22 , 00 , 00 , substr ( $key , 5 , 2 ) , 15 , substr ( $key , 0 , 4 ) ) ) ) );
         }
       }
     }
    //------------------------------------------------------
    echo '
    <table class="stat_table" width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
    <tr>
      <td class="stat_header" colspan="8">'.$lang_trend[2].'</td>
    </tr>
    </thead>
    <tr>
      <td class="stat_module_data"><b>'.$lang_month[2].'</b></td>
      <td class="stat_slidebar" style="text-align: center;"><b>'.$lang_module[2].'</b></td>
      <td class="stat_hits" style="text-align: right;"><b>'.$lang_trend[1].'</b></td>
      <td class="stat_hits" style="text-align: right;"><b>'.$lang_counter[6].'</b></td>
      <td class="stat_percent" style="border-right:1px outset #6F6F6F;"><b>&nbsp;</b></td>
      <td class="stat_hits" style="text-align: right;"><b>'.$lang_trend[1].'</b></td>
      <td class="stat_hits" style="text-align: right;"><b>'.$lang_overview[1].'</b></td>
      <td class="stat_percent"><b>&nbsp;</b></td>
    </tr>
    <tbody>
    ';
    ksort ( $visitor_month  );
    ksort ( $month_complete );
    display_trends ( $visitor_month , $month_complete , 0 );
    echo '
    </tbody>
    <tr>
      <td class="stat_footer" colspan="8">&nbsp;</td>
    </tr>
    </table>
    ';
   }
  include ( "func/html_footer.php" );
  exit;
 }
//--------------------------------------------------------------------
// trends per year
if ( $detail_logfile == "trends_year" )
 {
  include ( "func/func_display_trends.php" );
  //-----
  if ( count ( $visitor_year ) != 0 )
   {
    //------------------------------------------------------
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
    //-----
    //how many days exist in the first year the tracking started
    if ( date ( "Y" , $real_first_timestamp ) == date ( "Y" ) )
     {
      $year_first = ( int ) round ( ( time ( ) - $real_first_timestamp ) / 86400 );
     }
    else
     {
      $year_first = ( int ) round ( ( mktime ( 23 , 59 , 59 , 12 , 31 , date ( "Y" , $real_first_timestamp ) ) - $real_first_timestamp ) / 86400 );
     }
    //-----
    $year_complete = array ( );
    foreach ( $visitor_year as $key => $value )
     {
      // the key value in the cache_visitors array is set to " 2007 ", thats why the trim function
      $key = trim ( $key );

      // if the year of the stat start == actual year
      if ( date ( "Y" , $real_first_timestamp ) == date ( "Y" , $key ) )
       {
        $year_complete [ $key ] = ( int ) round ( ( $value / $year_first ) );
       }
      else
       {
        if ( date ( "Y" ) == date ( "Y" , $key ) )
         {
          if ( date ( "Y" ) == date ( "Y" , $real_first_timestamp ) )
           {
            $year_complete [ $key ] = ( int ) round ( ( $value / $year_first ) );
           }
          else
           {
            $temp = ( int ) round ( ( time ( ) - mktime ( 23 , 59 , 59 , 1 , 1 , date ( "Y" ) ) ) / 86400 );
            $year_complete [ $key ] = ( int ) round ( ( $value / $temp ) );
            unset ( $temp );
           }
         }
        else
         {
          $year_complete [ $key ] = ( int ) round ( ( $value / 365 ) );
         }
       }
     }
    //---------------------------------------------------
    echo '
    <table class="stat_table" width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
    <tr>
      <td class="stat_header" colspan="8">'.$lang_trend[3].'</td>
    </tr>
    </thead>
    <tr>
     <td class="stat_modul_data"><b>'.$lang_year[2].'</b></td>
     <td class="stat_slidebar" style="text-align: center;"><b>'.$lang_module[2].'</b></td>
     <td class="stat_hits" style="text-align: right;"><b>'.$lang_trend[1].'</b></td>
     <td class="stat_hits" style="text-align: right;"><b>'.$lang_counter[6].'</b></td>
     <td class="stat_percent" style="border-right:1px outset #6F6F6F;"><b>&nbsp;</b></td>
     <td class="stat_hits" style="text-align: right;"><b>'.$lang_trend[1].'</b></td>
     <td class="stat_hits" style="text-align: right;"><b>'.$lang_overview[1].'</b></td>
     <td class="stat_percent"><b>&nbsp;</b></td>
    </tr>
    <tbody>
    ';
    ksort ( $visitor_year  );
    ksort ( $year_complete );
    display_trends ( $year_complete , $visitor_year , 1 );
    echo '
    </tbody>
    <tr>
      <td class="stat_footer" colspan="8">&nbsp;</td>
    </tr>
    </table>
    ';
   }
  include ( "func/html_footer.php" );
  exit;
 }
//--------------------------------------------------------------------
// country
if ( $detail_logfile == "country" )
 {
  if ( count ( $country ) != 0 )
   {
    $country_full = array ();
    foreach ( $country as $key => $value )
     {
      //--------------------------------
      if ( $key == "unknown" )
       {
        $country_full [ $lang_module[3] ] = $value;
       }
      else
       {
        $country_full [ $country_array [ $key ]." (".$key.")" ] = $value;
       }
      //--------------------------------
     }
    $max_value = array_sum ( $country_full );
    arsort ( $country_full );
    display ( "<div class=\"stat_user\">".$lang_country[1]."</div>" , $lang_country[2] , $lang_module[1] , $lang_module[2] , $country_full , "100%" , count( $country_full ) , $lang_module[3] , $delete_year , $max_value , "y" , 1 , 0 , 0 , 0 );
   }
  include ( "func/html_footer.php" );
  exit;
 }
################################################################################
### display the details ###
if ( $db_active == 1 )
 {
  //----------------------------------------------------------------------------
  // db version
  //--------------------------------------------
  echo "<table class=\"stat_table\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n";
  echo "<thead>\n";
  echo "<tr>\n";
    echo "<th class=\"stat_header\" style=\"width:30px; text-align:center;\">Nr</th>\n";
    if ( ( $show_browser_icons == 1 ) || ( $show_os_icons == 1 ) )
     {
      echo "<th class=\"stat_header\" style=\"width:14px;\">&nbsp;</th>\n";
     }
    //--------------------------------------------
    $table = "";
    $row   = "";
    if     ( $detail_logfile == "pattern_resolution.dta"       ) { $table = "".$db_prefix."_resolution"; $row = "resolution"; echo "<th class=\"stat_header\" style=\"text-align:center;\">".$lang_resolution[2]."</th>"; }
    elseif ( $detail_logfile == "pattern_operating_system.dta" ) { $table = "".$db_prefix."_operating_system"; $row = "operating_system"; echo "<th class=\"stat_header\" style=\"text-align:center;\">".$lang_os[2]."</th>"; }
    elseif ( $detail_logfile == "pattern_browser.dta"          ) { $table = "".$db_prefix."_browser"; $row = "browser"; echo "<th class=\"stat_header\" style=\"text-align:center;\">".$lang_browser[2]."</th>"; }
    else { $table = "".$db_prefix."_resolution"; $row = "resolution"; echo "<th class=\"stat_header\" style=\"text-align:center;\">".$lang_resolution[2]."</th>"; }
    //--------------------------------------------
  echo "</tr>\n";
  echo "</thead>\n";
  echo "<tbody>\n";
  //--------------------------------------------
  $counter = 0;
  $query   = "SELECT DISTINCT ".$row." FROM ".$table." ORDER BY ".$row;
  $result  = db_query ( mysql_escape_string ( $query ) , 1 , 0 );
  //--------------------------------------------
  if ( count ( $result ) > 0 )
   {
    //--------------------------------------------
    for ( $x = 0 ; $x <= count ( $result ) - 1 ; $x++ )
     {
      //--------------------------------------------
      $counter++;
      echo "<tr>";
        echo "<td class=\"stat_hits\" style=\"width:30px;\">".$counter."</td>";
        //--------------------------------------------
        if ( strlen ( $result[$x][0] ) > 80 ) { $entry = substr ( $result[$x][0] , 0, 80 )."..."; }
        else { $entry = $result[$x][0]; }
        //--------------------------------------------
        if ( ( $show_browser_icons == 1 ) && ( $detail_logfile == "pattern_browser.dta" ) )
         {
          echo "<td style=\"text-align:right; padding-right:6px;\">";
          echo '<img src="images/browser_icons/'.browser_matching ( $entry ).'.png" width="14" height="14" style="vertical-align:middle;" alt="" />';
          echo "</td>";
         }
        if ( ( $show_os_icons == 1 ) && ( $detail_logfile == "pattern_operating_system.dta" ) )
         {
          echo "<td style=\"text-align:right; padding-right:6px;\">";
          echo '<img src="images/os_icons/'.os_matching ( $entry ).'.png" width="14" height="14" style="vertical-align:middle;" alt="" />';
          echo "</td>";
         }
        //--------------------------------------------
        echo "<td class=\"stat_module_data\">".$entry."</td>";
      echo "</tr>\n";
      //--------------------------------------------
     }
    //--------------------------------------------
   }
  else
   {
    //--------------------------------------------
    echo "<tr>";
     echo "<td height=\"40\" class=\"stat_module_data\" colspan=\"2\">&nbsp;</td>";
    echo "</tr>\n";
    //--------------------------------------------
   }
  //--------------------------------------------
  echo "</tbody>\n";
  //----------------------------------------------------------------------------
 }
else
 {
  //----------------------------------------------------------------------------
  // dta version
  //--------------------------------------------
  if ( !in_array ( $detail_logfile  , array ( "pattern_site_name.dta" , "pattern_resolution.dta" , "pattern_operating_system.dta" , "pattern_browser.dta" , "pattern_referer.dta" ) ) ) { exit; };
  $counter    = 0; // if the first entry of the logfile is read, write the html header
  $data_found = 0; // if there is no data
  //--------------------------------------------
  $logfile = fopen ( "log/".$detail_logfile , "r" );     // open logfile
   while ( !FEOF ( $logfile ) )                           // as long as there are entries
    {
     $logfile_entry = fgetcsv ( $logfile , 60000 , "|" ); // read entry from logfile
     $counter++;
     //--------------------------------------------
     if ( $counter == 1 ) // write html header
      {
       //--------------------------------------------
       echo "<table class=\"stat_table\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n";
       echo "<thead>\n";
       echo "<tr>\n";
         echo "<th class=\"stat_header\" style=\"width:30px; text-align:center;\">Nr</th>\n";
         if ( ( $show_browser_icons == 1 ) || ( $show_os_icons == 1 ) )
          {
           echo "<th class=\"stat_header\" style=\"width:14px;\">&nbsp;</th>\n";
          }
         //--------------------------------------------
         if ( $detail_logfile == "pattern_site_name.dta"        ) { echo "<th class=\"stat_header\" style=\"text-align:center;\">".$lang_site[2]."</th>\n"; }
         if ( $detail_logfile == "pattern_resolution.dta"       ) { echo "<th class=\"stat_header\" style=\"text-align:center;\">".$lang_resolution[2]."</th>\n"; }
         if ( $detail_logfile == "pattern_operating_system.dta" ) { echo "<th class=\"stat_header\" style=\"text-align:center;\">".$lang_os[2]."</th>\n"; }
         if ( $detail_logfile == "pattern_browser.dta"          ) { echo "<th class=\"stat_header\" style=\"text-align:center;\">".$lang_browser[2]."</th>\n"; }
         //--------------------------------------------
       echo "</tr>\n";
       echo "</thead>\n";
       echo "<tbody>\n";
       //--------------------------------------------
      }
     //--------------------------------------------
     echo "<tr>";
     echo "<td class=\"stat_hits\" style=\"width:30px;\">".$logfile_entry[1]."</td>";

     if ( strlen ( $logfile_entry[0] ) > 80 ) { $entry = substr ( $logfile_entry[0] , 0, 80 )."..."; }
     else { $entry = $logfile_entry[0]; }

     if ( substr ( $entry , 0 , 4 ) == "http" )
      {
       echo "<td class=\"lh_referer\"><a target=\"_blank\" class=\"referer\" href=\"".$logfile_entry[0]."\">".$entry."</a></td>";
      }
     else
      {
       //--------------------------------------------
       if ( ( $show_browser_icons == 1 ) && ( $detail_logfile == "pattern_browser.dta" ) )
        {
         echo "<td style=\"text-align:right; padding-right:6px;\">";
         echo '<img src="images/browser_icons/'.browser_matching ( $entry ).'.png" width="14" height="14" style="vertical-align:middle;" alt="" />';
         echo "</td>";
        }
       if ( ( $show_os_icons == 1 ) && ( $detail_logfile == "pattern_operating_system.dta" ) )
        {
         echo "<td style=\"text-align:right; padding-right:6px;\">";
         echo '<img src="images/os_icons/'.os_matching ( $entry ).'.png" width="14" height="14" style="vertical-align:middle;" alt="" />';
         echo "</td>";
        }
       //--------------------------------------------
       echo "<td class=\"stat_module_data\">".$entry."</td>";
      }
     echo "</tr>\n";
     //--------------------------------------------

     //--------------------------------------------
     $data_found = 1; // if really data have been found
    }
  fclose ( $logfile );
  unset  ( $logfile );
  unset  ( $counter );
  echo "</tbody>\n";
  //----------------------------------------------------------------------------
  if ( $data_found == 0 )
   {
    echo "<tr>";
      echo "<td height=\"40\" class=\"stat_mudule_data\" colspan=\"2\">&nbsp;</td>";
    echo "</tr>\n";
   }
  else
   {
    if ( ( $show_browser_icons == 1 ) || ( $show_os_icons == 1 ) )
     {
      echo "<tr>";
        echo "<td class=\"stat_footer\" colspan=\"3\">&nbsp;</td>";
      echo "</tr>\n";
     }
    else
     {
      echo "<tr>";
        echo "<td class=\"stat_footer\" colspan=\"2\">&nbsp;</td>";
      echo "</tr>\n";
     }
   }
  //----------------------------------------------------------------------------
 }
echo "</table>";
//------------------------------------------------------------------------------
include ( "func/html_footer.php" ); // include html footer
//------------------------------------------------------------------------------
?>