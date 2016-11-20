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

//------------------------------------------------------------------------------
include ( 'config/config.php'                ); // include path to logfile
include ( $language                          ); // include language vars
include ( $language_patterns                 ); // include language country vars
include ( 'func/func_crypt.php'              ); // include password libary
//------------------------------------------------------------------------------
if ( $error_reporting == 0 ) { error_reporting(0); }
//------------------------------------------------------------------------------
// specifically function for multi-byte encodings
@mb_internal_encoding ( "UTF-8" );
//------------------------------------------------------------------------------
// check for admin session
if ( isset ( $_POST [ 'password' ] ) )
 {
  if ( strpos ( $adminpassword , 'Pass_' ) !== FALSE )
   {
    if ( passCrypt ( $_POST [ 'password' ] ) == $adminpassword )
     {
      $_SESSION [ 'loggedin' ] = 'admin';
     }
   }
  else // old plain text saved passwords
   {
    if ( md5 ( $_POST [ 'password' ] ) == md5 ( $adminpassword ) )
     {
      $_SESSION [ 'loggedin' ] = 'admin';
     }
   }
 }
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
include ( "func/func_timer.php"              ); // include stopwatch function
//------------------------------------------------------------------------------
$timer_start = timer_start();                   // start the stopwatch timer
//------------------------------------------------------------------------------
$last_hits_width = $last_hits_width -10;
//------------------------------------------------------------------------------
//check date form
    if ( $language == "language/german.php" ) { $dateform  = "d.m.Y"; $dateform1 = "d.m.y"; }
elseif ( $language == "language/french.php" ) { $dateform  = "d.m.Y"; $dateform1 = "d.m.y"; }
  else { $dateform  = "Y/m/d"; $dateform1 = "y/m/d"; }
//------------------------------------------------------------------------------
// if language not german and whois by geolocation.php-web-stathois, link to english geolocation site
if ( ( $language != "language/german.php" ) && ( $whois_link == "http://geolocation.php-web-statistik.de/index.php?address=" ) )
 {
  $whois_link = "http://geolocation.php-web-statistik.de/index_english.php?address=";
 }
//------------------------------------------------------------------------------
// Check for https referer
if ( isset ( $temp_referer ) )
 {
  if ( $temp_referer [4] == "s" ) { $position_http = 8; } else { $position_http = 7; }
 }
else { $position_http = 7; }
//------------------------------------------------------------------------------
include ( "func/html_header.php" ); // include html header
//------------------------------------------------------------------------------
echo '<style type="text/css">
.closebutton       { background: url(images/close.png); }
.closebutton:hover { background-position:0% -14px; }
</style>';
//------------------------------------------------------------------------------
// change to admin session
echo '<div id="showip" style="position:absolute; width:323px; height:193px; left:50%; top:50%; margin:-97px 0 0 -162px; background:url(images/bg_admin_status.png); z-index:10; display:none">
<div style="text-align:right; margin:17px 17px 5px 17px"><img class="closebutton" src="images/pixel.gif" onclick="showip()" width="13" height="13" alt="Close" title="Close" /></div>
<div style="width:283px; height:25px; background:#436783; color:#FFFFFF; font:bold 18px Arial,Verdana,Helvetica,Sans-Serif; text-align:center; margin:auto;"><p style="margin:0px; padding-top:2px">'.$lang_lasthits[18].'</p></div>
<div style="width:283px; margin:10px auto; letter-spacing:-0.01mm; word-spacing:0.4mm; text-align:left">
'.$lang_lasthits[19].'<br /><br />
<b>'.$lang_lasthits[20].'</b><br />
<form name="admin_status" action="#" method="post">
<input type="password" name="password" style="width:70%" value="" />
<input type="hidden" name="lang" value="'.$lang.'" />
<input type="submit" name="submit" value="OK" />
</form>
</div>
</div>';
//------------------------------------------------------------------------------
// sort the entries
if ( $db_active == 1 ) { } else { $cell_contents = array (); }
################################################################################
### date & number function ###
if ( $_GET [ "date" ] ) // if the script has got the date in the address field
 {
  //--------------------------------------------
  $date        = $_GET [ "date" ]; // get the date
  $actual_date = $date;            // actual date
  $last_date   = $date - 86400;    // yesterday
  $next_date   = $date + 86400;    // tomorrow
  //--------------------------------------------
 }
else
 {
  //--------------------------------------------
  if ( $_GET [ "loaddate" ] )
   {
    //--------------------------------------------
    $date        = mktime ( 0 , 0 , 0 , substr ( $_GET [ "loaddate" ] , 3 , 2 ) , substr ( $_GET [ "loaddate" ] , 0 , 2 ) , substr ( $_GET [ "loaddate" ] , 6 ) ); // get the date
    $actual_date = $date;          // actual date
    $last_date   = $date - 86400;  // yesterday
    $next_date   = $date + 86400;  // tomorrow
    //--------------------------------------------
   }
  else
   {
    //--------------------------------------------
    $actual_date = time ( ); // time today
    if ( $server_time == "+14h"    ) { $actual_date = $actual_date + 14 * 3600; }
    if ( $server_time == "+13,75h" ) { $actual_date = $actual_date + 13 * 3600 + 2700; }
    if ( $server_time == "+13h"    ) { $actual_date = $actual_date + 13 * 3600; }
    if ( $server_time == "+12,75h" ) { $actual_date = $actual_date + 12 * 3600 + 2700; }
    if ( $server_time == "+12h"    ) { $actual_date = $actual_date + 12 * 3600; }
    if ( $server_time == "+11,5h"  ) { $actual_date = $actual_date + 11 * 3600 + 1800; }
    if ( $server_time == "+11h"    ) { $actual_date = $actual_date + 11 * 3600; }
    if ( $server_time == "+10,5h"  ) { $actual_date = $actual_date + 10 * 3600 + 1800; }
    if ( $server_time == "+10h"    ) { $actual_date = $actual_date + 10 * 3600; }
    if ( $server_time == "+9,5h"   ) { $actual_date = $actual_date +  9 * 3600 + 1800; }
    if ( $server_time == "+9h"     ) { $actual_date = $actual_date +  9 * 3600; }
    if ( $server_time == "+8h"     ) { $actual_date = $actual_date +  8 * 3600; }
    if ( $server_time == "+7h"     ) { $actual_date = $actual_date +  7 * 3600; }
    if ( $server_time == "+6,5h"   ) { $actual_date = $actual_date +  6 * 3600 + 1800; }
    if ( $server_time == "+6h"     ) { $actual_date = $actual_date +  6 * 3600; }
    if ( $server_time == "+5,75h"  ) { $actual_date = $actual_date +  5 * 3600 + 2700; }
    if ( $server_time == "+5,5h"   ) { $actual_date = $actual_date +  5 * 3600 + 1800; }
    if ( $server_time == "+5h"     ) { $actual_date = $actual_date +  5 * 3600; }
    if ( $server_time == "+4,5h"   ) { $actual_date = $actual_date +  4 * 3600 + 1800; }
    if ( $server_time == "+4h"     ) { $actual_date = $actual_date +  4 * 3600; }
    if ( $server_time == "+3,5h"   ) { $actual_date = $actual_date +  3 * 3600 + 1800; }
    if ( $server_time == "+3h"     ) { $actual_date = $actual_date +  3 * 3600; }
    if ( $server_time == "+2h"     ) { $actual_date = $actual_date +  2 * 3600; }
    if ( $server_time == "+1h"     ) { $actual_date = $actual_date +  1 * 3600; }
    if ( $server_time == "-1h"     ) { $actual_date = $actual_date -  1 * 3600; }
    if ( $server_time == "-2h"     ) { $actual_date = $actual_date -  2 * 3600; }
    if ( $server_time == "-3h"     ) { $actual_date = $actual_date -  3 * 3600; }
    if ( $server_time == "-3,5h"   ) { $actual_date = $actual_date -  3 * 3600 - 1800; }
    if ( $server_time == "-4h"     ) { $actual_date = $actual_date -  4 * 3600; }
    if ( $server_time == "-4,5h"   ) { $actual_date = $actual_date -  4 * 3600 - 1800; }
    if ( $server_time == "-5h"     ) { $actual_date = $actual_date -  5 * 3600; }
    if ( $server_time == "-6h"     ) { $actual_date = $actual_date -  6 * 3600; }
    if ( $server_time == "-7h"     ) { $actual_date = $actual_date -  7 * 3600; }
    if ( $server_time == "-8h"     ) { $actual_date = $actual_date -  8 * 3600; }
    if ( $server_time == "-9h"     ) { $actual_date = $actual_date -  9 * 3600; }
    if ( $server_time == "-9,5h"   ) { $actual_date = $actual_date -  9 * 3600 - 1800; }
    if ( $server_time == "-10h"    ) { $actual_date = $actual_date - 10 * 3600; }
    if ( $server_time == "-11h"    ) { $actual_date = $actual_date - 11 * 3600; }
    if ( $server_time == "-12h"    ) { $actual_date = $actual_date - 12 * 3600; }
    $last_date   = $actual_date - 86400; // yesterday
    $next_date   = $actual_date + 86400; // time today
    //--------------------------------------------
   }
  //--------------------------------------------
 }
//----------------------------------------------------------------------------
if ( ( $_GET [ "number" ] ) && ( is_numeric ( $_GET [ "number" ] ) ) )
 {
  //--------------------------------------------
  $last_date_link = "last_hits.php?number=".$_GET [ "number" ]."&amp;date=".$last_date; // generate link yesterday
  $next_date_link = "last_hits.php?number=".$_GET [ "number" ]."&amp;date=".$next_date; // generate link tomorrow
  $number         = $_GET [ "number" ]; // number of entries that should be read
  //--------------------------------------------
 }
else
 {
  //--------------------------------------------
  $last_date_link = "last_hits.php?number=".$last_hits_number."&amp;date=".$last_date; // generate link yesterda
  $next_date_link = "last_hits.php?number=".$last_hits_number."&amp;date=".$next_date; // generate link tomorrow
  $number         = $last_hits_number;
  //--------------------------------------------
 }
################################################################################
### header (date info)###
echo '
<table id="groundtable" border="0" width="'.$last_hits_width.'" cellspacing="0" cellpadding="0" align="center"><tr><td>
<table id="header_lh" border="0" width="100%" cellspacing="0" cellpadding="0">
<tr>
  <td width="280" align="center" valign="middle" style="background:url('.$theme.'/bg_header-lh.png) left top no-repeat;">&nbsp;</td>
  <td valign="middle" style="background:url('.$theme.'/bg_header-lh_c.png) left top repeat-x; font-size:18px; font-weight:bold;">'.$lang_lasthits[1].'&nbsp;'.date ( $dateform , $actual_date ).'</td>
  <td width="280" align="right" valign="middle" style="background:url('.$theme.'/bg_header-lh.png) right top no-repeat;padding:10px 15px 0px 0px;">&nbsp;</td>
</tr>
</table>
';
################################################################################
### header only for print ###
echo '
<div id="print">
  <table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="140" align="center"><img src="images/system.gif" width="104" height="50" alt="PHP Web Stat" title="PHP Web Stat" /></td>
    <td align="center" valign="middle"><span style="font-size: 24px"><b>PHP Web Stat</b></span></td>
    <td width="140" valign="top">'.$lang_menue[1].'<br /><br />'.date ( $dateform , $actual_date ).'</td>
  </tr>
  </table>
</div>
';
################################################################################
### menue (functions) ###
echo '
<table class="lh_menue" border="0" width="100%" cellspacing="0" cellpadding="0" style="padding:0px; height:27px;">
<tr>
  <td style="background:url('.$theme.'/bg_header-lh.png) left bottom no-repeat; padding-left:10px; padding-right:10px; vertical-align:top; white-space:nowrap;">
  <div style="margin-top:3px;">
  <a href="last_hits.php"><img style="vertical-align:middle;" src="images/reload.png" width="18" height="18" alt="'.$lang_menue[4].'" title="'.$lang_menue[4].'" /></a>&nbsp;<a class="lh" href="last_hits.php">'.$lang_menue[4].'</a> &nbsp; &nbsp;
  <a href="'.$last_date_link.'"><img style="vertical-align:middle;" src="images/lh_arrow_left.png"  alt="1 '.$lang_lasthits[2].'" title="1 '.$lang_lasthits[2].'" /></a>&nbsp;<a class="lh" href="'.$last_date_link.'">'.$lang_lasthits[2].'</a>&nbsp; &nbsp;
  </div>
  </td>
  <td width="100%" align="left" style="background:url('.$theme.'/bg_header-lh_c.png) left bottom repeat-x; vertical-align:top;">
  <div style="margin-top:3px;">
  <a href="'.$next_date_link.'"><img style="vertical-align:middle;" src="images/lh_arrow_right.png" alt="1 '.$lang_lasthits[3].'" title="1 '.$lang_lasthits[3].'" /></a>&nbsp;<a class="lh" href="'.$next_date_link.'">'.$lang_lasthits[3].'</a>&nbsp; &nbsp;
  <form name="changedate" action="#" method="get">
  <img src="func/calendar/img.gif" id="f_trigger_a" style="border:1px solid black; vertical-align:middle; cursor:pointer;" onmouseover="this.style.background=\'red\';" onmouseout="this.style.background=\'\';" alt="'.$lang_lasthits[4].'" title="'.$lang_lasthits[4].'" />
  <input type="hidden" name="loaddate" id="f_date_a" size="10" />
  <script type="text/javascript">
    function dateChanged(calendar) {
       calendar.hide();
       document.changedate.submit();
     };

    Calendar.setup({
       button        :   "f_trigger_a",   // trigger for the calendar (button ID)
       inputField    :   "f_date_a",      // id of the input field
       align         :   "Br",            // alignment (defaults to "Bl")
       singleClick   :   true,            // singleClick
       onClose       :   dateChanged      // changed the date
    });
  </script>
  ';
  //--------------------------------------------
  if ( ( $_GET [ "number" ] ) && ( is_numeric ( $_GET [ "number" ] ) ) )
   {
    echo '<input type="hidden" name="number" value="'.$_GET["number"].'" />';
   }
  else
   {
    echo '<input type="hidden" name="number" value="'.$last_hits_number.'" />';
   }
  //--------------------------------------------
  echo '
  </form>
  '.$lang_lasthits[4].'&nbsp; &nbsp;
  <form name="lasthits" action="last_hits.php" method="get">
  <select name="number" size="1" onchange="document.lasthits.submit();" style="display:inline; width:80px; border:none; height:18px; vertical-align:middle; font-size:12px;">
  ';
  //--------------------------------------------
  if ( ( $_GET [ "number" ] ) && ( is_numeric ( $_GET [ "number" ] ) ) )
   {
    echo '<option value="'.$_GET[ "number" ].'" selected="selected">'.$_GET[ "number" ].'</option><option value="'.$_GET[ "number" ].'">-----</option>';
   }
  else
   {
    echo '<option value="'.$last_hits_number.'" selected="selected">'.$last_hits_number.'</option><option value="'.$last_hits_number.'">-----</option>';
   }
  //--------------------------------------------
  foreach(array(50, 100, 250, 500, 1000, 2500, 5000, 10000, 15000, 20000) as $var)
   {
    $selected = '';
    if ( $lasthits == $var ) $selected = 'selected';
    echo "<option value=\"$var\" $selected>$var</option>\n";
   }
  //--------------------------------------------
  echo '
  </select>';
  //--------------------------------------------
  if ( $_GET [ "date" ] )
   {
    echo '<input type="hidden" name="date" value="'.$_GET["date"].'" />';
   }
  echo'</form>'.$lang_lasthits[5];
  //--------------------------------------------
  if ( $_SESSION [ "loggedin" ] != "admin" )
   {
    echo '<img src="images/ip_unlock.png" width="18" height="18" style="vertical-align:middle; margin-left:20px; cursor:pointer" onclick="showip()" alt="'.$lang_lasthits[17].'" title="'.$lang_lasthits[17].'" />';
   }
  //--------------------------------------------
  echo '
  </div>
  </td>
  <td style="width:20px; background:url('.$theme.'/bg_header-lh.png) right bottom repeat-x; padding-left:10px; padding-right:10px; vertical-align:top;">
  <div style="margin-top:3px;"><img style="vertical-align:middle; cursor:pointer;" src="images/print.png" onclick="window.print();return false;" width="18" height="18" alt="'.$lang_lasthits[6].'" title="'.$lang_lasthits[6].'" /></div>
  </td>
  </tr>
  </table>
  <div style="width:8px; height:8px;"></div>';
  ##############################################################################
  ### write the last hits table (header) ###
  $lhh = $last_hits_height -154;
  echo '
  <div class="lh_input" style="height:'.$lhh.'px;">
  <table class="lh_table" border="0" width="100%" cellspacing="0" cellpadding="2">
  <thead>
    <tr>
      <th class="lh_header" style="width:74px;">'.$lang_lasthits[7].'</th>
      <th class="lh_header" style="width:140px;">'.$lang_lasthits[8].'</th>
      <th class="lh_header" style="width:45px;">Sys</th>
      <th class="lh_header" style="width:'.$last_hits_site_column.'px;">'.$lang_lasthits[9].'</th>
      <th class="lh_header">'.$lang_lasthits[10].'</th>
    </tr>
  </thead>
  <tbody>
  ';
  ##############################################################################
  ### get the entries ###
  $background_split = 1;
  //--------------------------------------------
  if ( $db_active == 1 )
   {
    //--------------------------------------------
    $query   = "SELECT COUNT(*) FROM ".$db_prefix."_main";
    $result  = db_query ( $query , 1 , 0 );
    $counter_all = $result[0][0];
    //--------------------------------------------
    $query   = "SELECT ".$db_prefix."_main.id,".$db_prefix."_main.timestamp,".$db_prefix."_main.ip_address,".$db_prefix."_browser.browser,".$db_prefix."_operating_system.operating_system,".$db_prefix."_site_name.site_name,".$db_prefix."_referrer.referrer,".$db_prefix."_resolution.resolution,".$db_prefix."_main.color_depth,".$db_prefix."_main.country_code FROM ".$db_prefix."_main,".$db_prefix."_browser,".$db_prefix."_operating_system,".$db_prefix."_site_name,".$db_prefix."_resolution,".$db_prefix."_referrer WHERE ".$db_prefix."_main.browser = ".$db_prefix."_browser.id AND ".$db_prefix."_main.operating_system = ".$db_prefix."_operating_system.id AND ".$db_prefix."_main.site_name = ".$db_prefix."_site_name.id AND ".$db_prefix."_main.referrer = ".$db_prefix."_referrer.id AND ".$db_prefix."_main.resolution = ".$db_prefix."_resolution.id AND ".$db_prefix."_main.year = ".date ( "Y" , $actual_date )." AND ".$db_prefix."_main.month = ".date ( "n" , $actual_date )." AND ".$db_prefix."_main.day = ".date ( "j" , $actual_date )." ORDER BY ".$db_prefix."_main.timestamp DESC LIMIT 0,".$number;
    $result  = db_query ( $query , 1 , 0 );
    $counter = count ( $result );
    $counter_found = count ( $result );
    //--------------------------------------------
    // if the last hits section is disabled within the admin center
    if ( ( $show_last_hits == 0 ) && ( $_SESSION [ "loggedin" ] == "user" ) )
     {
      $counter = 0;
     }
    //--------------------------------------------
    if ( $counter > 0 )
     {
      for ( $x = 0 ; $x <= count ( $result ) - 1 ; $x++ )
       {
        // 0    1            2                3               4                  5            6                       7            8             9
        // id   timestamp    ip_address       browser         operating_system   site_name    referrer                resolution   color_depth   country_code
        // 14   1200184067   xx.xxx.xxx.xxx   Firefox 2.0.0   Windows Vista      index.html   http://www.domain.com   1024x800     32            de
        //--------------------------------------------
        $temp_referer = $result[$x][6];
        $exception_domain_found = 0;
        //--------------------------------------------
        foreach ( $exception_domain as $value )
         {
          if ( strpos ( substr ( $temp_referer , 0 , strpos ( $temp_referer."/" , "/" , $position_http ) ) , $value ) !== FALSE )
           {
            $exception_domain_found = 1;
           }
         }
        //--------------------------------------------
        if ( $exception_domain_found == 1 )
         {
          $referer = pattern_matching_reverse ( "site_name_reverse" , substr ( strstr ( substr ( $result[$x][6] , $position_http ) , "/" ) , 1 ) );
          if ( strlen ( $referer ) > 60 )
           {
            $referer = substr ( $referer , 0 , 60 );
           }
         }
        else
         {
          if ( trim ( $temp_referer ) == "" )
           {
            $referer = "";
           }
          else
           {
            $temp_referer = kill_special_chars ( $temp_referer );

            if ( ( strpos ( $temp_referer , "google." ) > 0 ) && ( strpos ( $temp_referer , "url?q=" ) > 0 ) )
             {
              $temp_referer = str_replace ( "url?q=" , "search?q=" , $temp_referer );
             }

            if ( $temp_referer == "---" ) { $temp_referer = ""; }
            if ( strlen ( $temp_referer ) > $last_hits_referer_length )
             {
              $referer = '<a class="referer" href="'.$temp_referer.'" target="_blank">'.mb_substr ( $temp_referer , 0 , $last_hits_referer_length ).'...</a>';
             }
            else
             {
              $referer = '<a class="referer" href="'.$temp_referer.'" target="_blank">'.$temp_referer.'</a>';
             }
           }
         }
        //--------------------------------------------
        if ( trim ( $result[$x][9] ) != "" )
         {
          $country = "(".$result[$x][9].")";
          if ( $show_country_flags == 1 )
           {
            $country_flag = $result[$x][9].".png";
           }
         }
        else
         {
          $country = "";
          if ( $show_country_flags == 1 )
           {
            $country_flag = "unknown.png";
           }
         }
        //--------------------------------------------
        $temp_site_name = htmlentities ( pattern_matching_reverse ( "site_name_reverse" , $result[$x][5] ),ENT_COMPAT, 'UTF-8' );
        if ( strlen ( $temp_site_name ) > $last_hits_site_length )
         {
          $temp_site_name = mb_substr ( $temp_site_name , 0 , $last_hits_site_length )."...";
         }
        //--------------------------------------------
        if ( ( $background_split % 2 ) == 0 ) { $background = "lh_row1"; } else { $background = "lh_row2";  }
        echo '
        <tr class="'.$background.'">
          <td class="lh_time">'.date ( "H:i:s" , $result[$x][1] ).'</td>
          ';
          //--------------------------------------------
          if ( ( $_SESSION [ "loggedin" ] != "admin" ) && ( $show_ip_client == 0 ) ) { $result[$x][2] = ''; }
          if ( $_SESSION [ "loggedin" ] == "user" ) { $result[$x][2] = ''; }
          //--------------------------------------------
          if ( $show_country_flags == 1 )
           {
            if ( strpos ( $result[$x][2] , "." ) > 0 ) // ipv4
             {
              if ( strlen ( substr ( $result[$x][2] , strrpos ( $result[$x][2] , "." ) + 1 ) ) > 3 )
               {
                echo '<td class="lh_iphost"><img style="vertical-align:middle;" src="images/country_flags/'.$country_flag.'" width="20" height="13" alt="'.$country_array [ trim ( $result[$x][9] ) ].' '.$country.'" title="'.$country_array [ trim ( $result[$x][9] ) ].' '.$country.'" /> <a class="referer" href="'.htmlentities ( $whois_link ).substr ( $result[$x][2] , 0 , strrpos ( $result[$x][2] , "." ) + 1 ).'1" target="_blank">'.substr ( $result[$x][2] , 0 , strrpos ( $result[$x][2] , "." ) + 1 ).'*</a></td>';
               }
              else
               {
                echo '<td class="lh_iphost"><img style="vertical-align:middle;" src="images/country_flags/'.$country_flag.'" width="20" height="13" alt="'.$country_array [ trim ( $result[$x][9] ) ].' '.$country.'" title="'.$country_array [ trim ( $result[$x][9] ) ].' '.$country.'" /> <a class="referer" href="'.htmlentities ( $whois_link ).''.$result[$x][2].'" target="_blank">'.$result[$x][2].'</a></td>';
               }
             }
            else
             {
              if ( strpos ( $result[$x][2] , ":" ) > 0 ) // ipv6
               {
                echo '<td class="lh_iphost"><img style="vertical-align:middle;" src="images/country_flags/'.$country_flag.'" width="20" height="13" alt="'.$country_array [ trim ( $result[$x][9] ) ].' '.$country.'" title="'.$country_array [ trim ( $result[$x][9] ) ].' '.$country.'" /> <a class="referer" href="'.htmlentities ( $whois_link ).$result[$x][2].'" target="_blank" title="'.$result[$x][2].'">'.substr ( $result[$x][2] , 0 , 13 ).'...</a></td>';
               }
              else
               {
                echo '<td class="lh_iphost"><img style="vertical-align:middle;" src="images/country_flags/'.$country_flag.'" width="20" height="13" alt="'.$country_array [ trim ( $result[$x][9] ) ].' '.$country.'" title="'.$country_array [ trim ( $result[$x][9] ) ].' '.$country.'" /> '.$lang_lasthits[15].'</td>';
               }
             }
           }
          else
           {
            if ( strpos ( $result[$x][2] , "." ) > 0 ) // ipv4
             {
              if ( strlen ( substr ( $result[$x][2] , strrpos ( $result[$x][2] , "." ) + 1 ) ) > 3 )
               {
                echo '<td class="lh_iphost"><a class="referer" href="'.htmlentities ( $whois_link ).substr ( $result[$x][2] , 0 , strrpos ( $result[$x][2] , "." ) + 1 ).'1" target="_blank" title="'.$country_array [ trim ( $result[$x][9] ) ].' '.$country.'">'.substr ( $result[$x][2] , 0 , strrpos ( $result[$x][2] , "." ) + 1 ).'*</a></td>';
               }
              else
               {
                echo '<td class="lh_iphost"><a class="referer" href="'.htmlentities ( $whois_link ).$result[$x][2].'" target="_blank" title="'.$country_array [ trim ( $result[$x][9] ) ].' '.$country.'">'.$result[$x][2].'</a></td>';
               }
             }
            else
             {
              if ( strpos ( $result[$x][2] , ":" ) > 0 ) // ipv6
               {
                echo '<td class="lh_iphost"><a class="referer" href="'.htmlentities ( $whois_link ).$result[$x][2].'" target="_blank" title="'.$result[$x][2].'">'.substr ( $result[$x][2] , 0 , 13 ).'...</a></td>';
               }
              else
               {
                echo '<td class="lh_iphost">'.$lang_lasthits[15].'</td>';
               }
             }
           }
          //--------------------------------------------
          if ( $result[$x][8] != "" )
           {
            $mode = "(mode=js)";
           }
          else
           {
            $mode = "(mode=img)";
           }
          //--------------------------------------------
          if ( $result[$x][8] == "32" ) { $color_depth = $lang_colordepth [ 3 ]; }
          if ( $result[$x][8] == "16" ) { $color_depth = $lang_colordepth [ 4 ]; }
          if ( $result[$x][8] == "24" ) { $color_depth = $lang_colordepth [ 5 ]; }
          if ( $result[$x][8] == "8"  ) { $color_depth = $lang_colordepth [ 6 ]; }
          if ( $result[$x][8] == "4"  ) { $color_depth = $lang_colordepth [ 7 ]; }
          if ( $result[$x][8] == "2"  ) { $color_depth = $lang_colordepth [ 8 ]; }
          if ( $result[$x][8] == "0"  ) { $color_depth = $lang_module     [ 3 ]; }
          //--------------------------------------------
          echo '
          <td class="lh_os"><img style="vertical-align:bottom;" src="images/os_icons/'.os_matching ( $result[$x][4] ).'.png" width="14" height="14" alt="'.$result[$x][4].' - '.$result[$x][7].' - '.$color_depth.'" title="'.$result[$x][4].' - '.$result[$x][7].' - '.$color_depth.'" />&nbsp;&nbsp;<img style="vertical-align:bottom;" src="images/browser_icons/'.browser_matching ( $result[$x][3] ).'.png" width="14" height="14" alt="'.$result[$x][3].' &nbsp; '.$mode.'" title="'.$result[$x][3].' &nbsp; '.$mode.'" /></td>
          <td class="lh_site">'.$temp_site_name.'</td>
          <td class="lh_referer">'.$referer.'</td>
        </tr>
        ';
        $background_split++;
       }
     }
    //--------------------------------------------
    if ( $counter == 0 )
     {
      if ( ( $show_last_hits == 0 ) && ( $_SESSION [ "loggedin" ] == "user" ) )
       {
        echo '
        <tr>
          <td height="40" class="lh_referer lh_row2" colspan="5"><center>'.$lang_lasthits[16].'*'.$_SESSION [ "loggedin" ].'</center></td>
        </tr>
        </tbody>
        ';
       }
      else
       {
        echo '
        <tr>
          <td height="40" class="lh_referer lh_row2" colspan="5"><center>'.$lang_lasthits[11].'</center></td>
        </tr>
        </tbody>
        ';
       }
     }
    else
     {
      echo '</tbody>';
     }
    //--------------------------------------------
    $counter = $counter_all;
    //--------------------------------------------
   }
  else
   {
    //--------------------------------------------
    $counter       = 0; // if the first entry of the logfile is read, last hits table header
    $counter_found = 0; // number of entries to be read
    $data_found    = 0; // if there is no data
    //--------------------------------------------
    $logfile = fopen ( "log/logdb_backup.dta" , "rb" );   // open logfile
    if ( $_GET [ "loaddate" ] ) { $today = $actual_date; } else { $today = strtotime ( date ( "Y-m-d" , $actual_date )." 0:0:0" ); } // create date
    include ( "log/index_days.php" ); // include index days file
    if ( array_key_exists ( $today , $index_days ) ) { fseek ( $logfile , $index_days [ $today ] ); } else { fseek ( $logfile , max ( $index_days ) ); } // go to the correct address within the logfile
    while ( ( !FEOF ( $logfile ) ) && ( $logfile_entry [ 0 ] < ( $actual_date + 86400 ) ) ) // as long as there are entries
     {
      //--------------------------------------------
      $logfile_entry = fgetcsv ( $logfile , 60000 , "|" );   // read entry from logfile
      $counter++;
      //--------------------------------------------
      if ( ( trim ( $logfile_entry [ 0 ] ) != "" )  && ( date ( "d/m/Y" , $logfile_entry [ 0 ] ) == date ( "d/m/Y" , $actual_date ) ) ) // if timestamp != 0 and the date is the same to display
       {
        //--------------------------------------------
        $counter_found++;
        //--------------------------------------------
          $temp_referer = $pattern_referer [ $logfile_entry [ 5 ] ];
          $exception_domain_found = 0;
          //--------------------------------------------
          foreach ( $exception_domain as $value )
           {
            if ( strpos ( substr ( $temp_referer , 0 , strpos ( $temp_referer."/" , "/" , $position_http ) ) , $value ) !== FALSE )
             {
              $exception_domain_found = 1;
             }
           }
          //--------------------------------------------
          if ( $exception_domain_found == 1 )
           {
            $referer = htmlspecialchars ( pattern_matching_reverse ( "site_name_reverse" , substr ( strstr ( substr ( $pattern_referer [ $logfile_entry [ 5 ] ] , $position_http ) , "/" ) , 1 ) ), ENT_COMPAT, 'UTF-8' );
            if ( strlen ( $referer ) > 60 )
             {
              $referer = substr ( $referer , 0 , 60 );
             }
           }
          else
           {
            if ( trim ( $temp_referer ) == "" )
             {
              $referer = "";
             }
            else
             {
              if ( ( strpos ( $temp_referer , "google." ) > 0 ) && ( strpos ( $temp_referer , "url?q=" ) > 0 ) )
               {
                $temp_referer = str_replace ( "url?q=" , "search?q=" , $temp_referer );
               }
              if ( strlen ( $temp_referer ) > $last_hits_referer_length )
               {
                $referer = '<a class="referer" href="'.htmlspecialchars ( $temp_referer, ENT_COMPAT, 'UTF-8').'" target="_blank">'.mb_substr ( htmlentities ( $temp_referer , ENT_COMPAT, 'UTF-8' ) , 0 , $last_hits_referer_length ).'...</a>';
               }
              else
               {
                $referer = '<a class="referer" href="'.htmlspecialchars ( $temp_referer , ENT_COMPAT, 'UTF-8').'" target="_blank">'.htmlentities ( $temp_referer , ENT_COMPAT, 'UTF-8' ).'</a>';
               }
             }
           }
          //--------------------------------------------
          if ( trim ( $logfile_entry [ 8 ] ) != "" )
           {
            $country = "(".strtolower ( $logfile_entry [ 8 ] ).")";
            if ( $show_country_flags == 1 )
             {
              $country_flag = strtolower ( $logfile_entry [ 8 ] ).".png";
             }
           }
          else
           {
            $country = "";
            if ( $show_country_flags == 1 )
             {
              $country_flag = "unknown.png";
             }
           }
          //--------------------------------------------
          $temp_site_name = htmlentities ( pattern_matching_reverse ( "site_name_reverse" , $pattern_site_name [ $logfile_entry [ 4 ] ] ),ENT_COMPAT ,'UTF-8' );
          if ( strlen ( $temp_site_name ) > $last_hits_site_length )
           {
            $temp_site_name = mb_substr ( $temp_site_name , 0 , $last_hits_site_length )."...";
           }
          //--------------------------------------------
          $cell_content = "";
          $cell_content .= '<td class="lh_time">'.date ( "H:i:s" , $logfile_entry [ 0 ] ).'</td>';
          //--------------------------------------------
          if ( ( $_SESSION [ "loggedin" ] != "admin" ) && ( $show_ip_client == 0 ) ) { $logfile_entry [ 1 ] = ''; }
          if ( $_SESSION [ "loggedin" ] == "user" ) { $logfile_entry [ 1 ] = ''; }
          //--------------------------------------------
          if ( $show_country_flags == 1 )
           {
            if ( strpos ( $logfile_entry [ 1 ] , "." ) > 0 ) // ipv4
             {
              if ( strlen ( substr ( $logfile_entry [ 1 ] , strrpos ( $logfile_entry [ 1 ] , "." ) + 1 ) ) > 3 )
               {
                $cell_content .= '<td class="lh_iphost"><img style="vertical-align:middle;" src="images/country_flags/'.$country_flag.'" width="20" height="13" alt="'.$country_array [ trim ( $logfile_entry [ 8 ] ) ].' '.$country.'" title="'.$country_array [ trim ( $logfile_entry [ 8 ] ) ].' '.$country.'" /> <a class="referer" href="'.htmlentities ( $whois_link ).substr ( $logfile_entry [ 1 ] , 0 , strrpos ( $logfile_entry [ 1 ] , "." ) + 1 ).'1" target="_blank">'.substr ( $logfile_entry [ 1 ] , 0 , strrpos ( $logfile_entry [ 1 ] , "." ) + 1 ).'*</a></td>';
               }
              else
               {
                $cell_content .= '<td class="lh_iphost"><img style="vertical-align:middle;" src="images/country_flags/'.$country_flag.'" width="20" height="13" alt="'.$country_array [ trim ( $logfile_entry [ 8 ] ) ].' '.$country.'" title="'.$country_array [ trim ( $logfile_entry [ 8 ] ) ].' '.$country.'" /> <a class="referer" href="'.htmlentities ( $whois_link ).$logfile_entry [ 1 ].'" target="_blank">'.$logfile_entry [ 1 ].'</a></td>';
               }
             }
            else
             {
              if ( strpos ( $logfile_entry [ 1 ] , ":" ) > 0 ) // ipv6
               {
                $cell_content .= '<td class="lh_iphost"><img style="vertical-align:middle;" src="images/country_flags/'.$country_flag.'" width="20" height="13" alt="'.$country_array [ trim ( $logfile_entry [ 8 ] ) ].' '.$country.'" title="'.$country_array [ trim ( $logfile_entry [ 8 ] ) ].' '.$country.'" /> <a class="referer" href="'.htmlentities ( $whois_link ).$logfile_entry [ 1 ].'" target="_blank" title="'.$logfile_entry [ 1 ].'">'.substr ( $logfile_entry [ 1 ] , 0 , 13 ).'...</a></td>';
               }
              else // ipv4
               {
                $cell_content .= '<td class="lh_iphost"><img style="vertical-align:middle;" src="images/country_flags/'.$country_flag.'" width="20" height="13" alt="'.$country_array [ trim ( $logfile_entry [ 8 ] ) ].' '.$country.'" title="'.$country_array [ trim ( $logfile_entry [ 8 ] ) ].' '.$country.'" /> '.$lang_lasthits[15].'</td>';
               }
             }
           }
          else
           {
            if ( strpos ( $logfile_entry [ 1 ] , "." ) > 0 ) // ipv4
             {
              if ( strlen ( substr ( $logfile_entry [ 1 ] , strrpos ( $logfile_entry [ 1 ] , "." ) + 1 ) ) > 3 )
               {
                $cell_content .= '<td class="lh_iphost"><a class="referer" href="'.htmlentities ( $whois_link ).substr ( $logfile_entry [ 1 ] , 0 , strrpos ( $logfile_entry [ 1 ] , "." ) + 1 ).'1" target="_blank" title="'.$country_array [ trim ( $logfile_entry [ 8 ] ) ].' '.$country.'">'.substr ( $logfile_entry [ 1 ] , 0 , strrpos ( $logfile_entry [ 1 ] , "." ) + 1 ).'*</a></td>';
               }
              else
               {
                $cell_content .= '<td class="lh_iphost"><a class="referer" href="'.htmlentities ( $whois_link ).$logfile_entry [ 1 ].'" target="_blank" title="'.$country_array [ trim ( $logfile_entry [ 8 ] ) ].' '.$country.'">'.$logfile_entry [ 1 ].'</a></td>';
               }
             }
            else
             {
              if ( strpos ( $logfile_entry [ 1 ] , ":" ) > 0 ) // ipv6
               {
                $cell_content .= '<td class="lh_iphost"><a class="referer" href="'.htmlentities ( $whois_link ).$logfile_entry [ 1 ].'" target="_blank" title="'.$logfile_entry [ 1 ].'">'.substr ( $logfile_entry [ 1 ] , 0 , 13 ).'...</a></td>';
               }
              else
               {
                $cell_content .= '<td class="lh_iphost">'.$lang_lasthits[15].'</td>';
               }
             }
           }
          //--------------------------------------------
          if ( $logfile_entry [ 7 ] != "" )
           {
            $mode = "(mode=js)";
           }
          else
           {
            $mode = "(mode=img)";
           }
          //--------------------------------------------
          if ( $logfile_entry [ 7 ] == "32"  ) { $color_depth = $lang_colordepth [ 3 ]; }
          if ( $logfile_entry [ 7 ] == "16"  ) { $color_depth = $lang_colordepth [ 4 ]; }
          if ( $logfile_entry [ 7 ] == "24"  ) { $color_depth = $lang_colordepth [ 5 ]; }
          if ( $logfile_entry [ 7 ] == "8"   ) { $color_depth = $lang_colordepth [ 6 ]; }
          if ( $logfile_entry [ 7 ] == "4"   ) { $color_depth = $lang_colordepth [ 7 ]; }
          if ( $logfile_entry [ 7 ] == "2"   ) { $color_depth = $lang_colordepth [ 8 ]; }
          if ( trim ( $logfile_entry [ 7 ] ) == "" ) { $color_depth = $lang_module [ 3 ]; }
          //--------------------------------------------
          $cell_content .= '<td class="lh_os"><img style="vertical-align:bottom;" src="images/os_icons/'.os_matching ( $pattern_operating_system [ $logfile_entry [ 3 ] ] ).'.png" width="14" height="14" alt="'.$pattern_operating_system [ $logfile_entry [ 3 ] ].' - '.$pattern_resolution [ $logfile_entry [ 6 ] ].' - '.$color_depth.'" title="'.$pattern_operating_system [ $logfile_entry [ 3 ] ].' - '.$pattern_resolution [ $logfile_entry [ 6 ] ].' - '.$color_depth.'" />&nbsp;&nbsp;<img style="vertical-align:bottom;" src="images/browser_icons/'.browser_matching ( $pattern_browser [ $logfile_entry [ 2 ] ] ).'.png" width="14" height="14" alt="'.$pattern_browser [ $logfile_entry [ 2 ] ].' &nbsp; '.$mode.'" title="'.$pattern_browser [ $logfile_entry [ 2 ] ].' &nbsp; '.$mode.'" /></td>';
          $cell_content .= '<td class="lh_site">'.$temp_site_name.'</td>';
          $cell_content .= '<td class="lh_referer">'.$referer.'</td>';
          if ( ( $background_split % 2 ) == 0 ) { $background = "lh_row1"; } else { $background = "lh_row2";  }
          $cell_contents[] = "<tr class='".$background."'>".$cell_content."</tr>";
          //--------------------------------------------
          $data_found = 1; // if really data have been found
       }
      //--------------------------------------------
      $background_split++;
     }
    fclose ( $logfile );
    unset  ( $logfile );
    //--------------------------------------------
    if ( $data_found == 1 )
     {
       //--------------------------------------------
       if ( ( $show_last_hits == 0 ) && ( $_SESSION [ "loggedin" ] == "user" ) )
        {
        echo '
        <tr>
          <td height="40" class="lh_referer lh_row2" colspan="5"><center>'.$lang_lasthits[16].'</center></td>
        </tr>
        </tbody>
        ';
        }
       else
        {
         krsort ( $cell_contents );
         $cell_contents = array_slice ( $cell_contents , 0 , $number );
         foreach ( $cell_contents as $value )
          {
           echo $value."\n";
          }
         echo '</tbody>';
        }
      //--------------------------------------------
     }
    else
     {
      //--------------------------------------------
        echo '
         <tr>
           <td height="40" class="lh_referer lh_row2" colspan="5"><center>'.$lang_lasthits[11].'</center></td>
         </tr>
         </tbody>
         ';
      //--------------------------------------------
     }
    //--------------------------------------------
   }
echo '
</table>
</div>';
################################################################################
### write the last hits table (footer) ###
if ( $db_active == 1 )
 {
  echo '
  <table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td class="lh_footer">'.$number.' '.$lang_lasthits[12].' &middot; '.$counter_found.' '.$lang_lasthits[13].' &middot; '.$counter.' '.$lang_lasthits[14].'</td>
  </tr>
  </table>';
 }
else
 {
  echo '
  <table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td class="lh_footer">'.$number.' '.$lang_lasthits[12].' &middot; '.$counter_found.' '.$lang_lasthits[13].'</td>
  </tr>
  </table>';
 }
################################################################################
### footer (copyright, loading time, W3C ) ###
echo '
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td><img src="images/pixel.gif" width="2" height="5" alt="" /></td></tr>
<tr>
  <td height="26" align="center" valign="middle">Copyright &copy; 2015 <a href="http://www.php-web-statistik.de" target="_blank">PHP Web Stat</a> &nbsp; <b>&middot;</b> &nbsp; '.$lang_footer[1].' '.timer_stop($timer_start).' '.$lang_footer[2].'.</td><td width="240" align="center" valign="middle"><a href="http://validator.w3.org/check?uri=referer" target="_blank"><img style="vertical-align:middle;" src="images/w3c-xhtml.gif" width="80" height="15" alt="Valid XHTML 1.0 Transitional" title="Valid XHTML 1.0 Transitional" /></a> &nbsp; <a href="http://jigsaw.w3.org/css-validator/validator?uri='.$script_domain.'/'.$script_path.''.$theme.'style.css"  target="_blank"><img style="vertical-align:middle;" src="images/w3c-css.gif" width="80" height="15" alt="Valid CSS!" title="Valid CSS!" /></a></td>
</tr>
</table>
</td></tr></table>
<script type="text/javascript">
<!-- //
function showip()
 {
	var showip = document.getElementById(\'showip\')
	if (showip.style.display == \'none\')
	 {
		showip.style.display = \'\';
		document.admin_status.password.focus();
	 }
	else
	 {
		showip.style.display = \'none\'
	 }
 }
// -->
</script>
</body>
';
//------------------------------------------------------------------------------
include ( "func/html_footer.php" ); // include html footer
//------------------------------------------------------------------------------
?>