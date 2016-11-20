<?php @session_start();
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.9.x                                                    #
# File-Release-Date:  15/10/29                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2015 by PHP Web Stat - All Rights Reserved.                      #
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
@ini_set ( "max_execution_time","false"      ); // set the script time
//@set_time_limit ( 0 );
//------------------------------------------------------------------------------
##### !!! never change this value !!! #####
$version_number  = '4.9';
$revision_number = '.15';
$last_edit       = '2015';
//------------------------------------------------------------------------------
// logout
if ( isset ( $_GET [ 'parameter' ] ) && $_GET [ 'parameter' ] == 'logout' ) { session_destroy(); session_start(); }
//------------------------------------------------------------------------------
include ( 'config/config.php'                ); // include path to logfile
include ( $language                          ); // include language vars
include ( $language_patterns                 ); // include language country vars
//------------------------------------------------------------------------------
if ( $error_reporting == 0 ) { error_reporting(0); }
//------------------------------------------------------------------------------
if ( $db_active == 1 )
 {
  include ( 'config/config_db.php'           ); // include db prefix
  include ( 'db_connect.php'                 ); // include database connection
 }
//------------------------------------------------------------------------------
include ( 'func/func_pattern_reverse.php'    ); // include pattern reverse function
include ( 'func/func_pattern_matching.php'   ); // include pattern matching function
include ( 'func/func_pattern_icons.php'      ); // include pattern icons function
include ( 'func/func_kill_special_chars.php' ); // include umlaut function
include ( 'func/func_display.php'            ); // include display function
include ( 'func/func_read_dir.php'           ); // include read directory function
include ( 'func/func_timer.php'              ); // include stopwatch function
include ( 'func/func_last_logins.php'        ); // include last login log function
include ( 'func/func_crypt.php'              ); // include password comparison function
//------------------------------------------------------------------------------
//check date form
    if ( $language == "language/german.php" ) { $dateform  = "d.m.Y"; $dateform1 = "d.m.y"; }
elseif ( $language == "language/french.php" ) { $dateform  = "d.m.Y"; $dateform1 = "d.m.y"; }
  else { $dateform  = "Y/m/d"; $dateform1 = "y/m/d"; }
//------------------------------------------------------------------------------
if ( $_GET [ "parameter" ] == "autologout" )
 {
  echo '<!doctype html>
  <html>
  <head>
   <title>PHP Web Stat '.$version_number.$revision_number.'</title>
   <meta charset="utf-8">
   <link rel="stylesheet" type="text/css" href="'.$theme.'style.css" media="screen, projection">
   <link rel="stylesheet" type="text/css" href="themes/layout.css" media="screen, projection">
   <!--[if lt IE 7]>
     <script type="text/javascript" src="func/unitpngfix.js"></script>
   <![endif]-->
  </head>
  <body>
  <div id="autologout">
    <div id="autologout_info">
      '.$lang_autologout[1].' <a href="index.php">LOGIN</a>
    </div>
    <div style="height: 43px; vertical-align: top; text-align: center; padding-top: 18px; font-size: 10px;">
      Copyright &copy; '.$last_edit.' PHP Web Stat &nbsp;&middot;&nbsp; Version '.$version_number.$revision_number.'
    </div>
  </div>';
  include ( "func/html_footer.php" ); // include html footer
  session_unset();
  session_destroy();
  exit;
 }
//------------------------------------------------------------------------------
if ( ( $loginpassword_ask == 1 ) && ( $_SESSION [ "hidden_stat" ] != md5_file ( "config/config.php" ) ) )
 {
  if ( $clientpassword == "" )
   {
    for ( $i = 0; $i < 20; $i++ ) { $clientpassword = $clientpassword . chr( rand( 33,90 ) ); }
   }
  if ( ( !isset ( $_POST ['password'] ) ) || ( ( passCrypt ( $_POST [ 'password' ] ) != $adminpassword ) && ( md5 ( $_POST [ 'password' ] ) != md5 ( $adminpassword ) ) && ( passCrypt ( $_POST [ 'password' ] ) != $clientpassword ) && ( md5 ( $_POST [ 'password' ] ) != md5 ( $clientpassword ) ) ) )
   {
    //----------------------------------------------------------------
    // login
    echo '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
     <title>PHP Web Stat '.$version_number.$revision_number.'</title>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
     <meta http-equiv="pragma"  content="no-cache" />
     <meta http-equiv="expires" content="0" />
     <link rel="stylesheet" type="text/css" href="'.$theme.'style.css" media="screen, projection" />
     <link rel="stylesheet" type="text/css" href="themes/layout.css" media="screen, projection" />
     <!--[if lt IE 7]>
       <script type="text/javascript" src="func/unitpngfix.js"></script>
     <![endif]-->
    </head>
    <body onload="document.login.password.focus(); document.login.password.select();">
    <form name="login" action="index.php" method="post">
    <table id="login" cellspacing="0" cellpadding="0">
    <tr><td class="li_td1"><img src="images/refresh.png" width="1" height="1" alt="" /></td></tr>
    <tr><td class="li_td2">'.$lang_login[1].'</td></tr>
    <tr><td class="li_td3"></td></tr>
    <tr>
      <td class="li_td4">
      '.$lang_login[2].'
      <table border="0" cellspacing="0" cellpadding="0" align="center" style="color:#000000;">
      <tr><td style="height:50px; padding-right:20px;"><label for="password">'.$lang_login[3].'</label></td><td style="height:50px;"><input class="pw" type="password" name="password" id="password" /></td></tr>
      <tr><td>&nbsp;</td><td><input style="cursor:pointer;" type="submit" name="login" value="'.$lang_login[4].'" /> <input style="cursor:pointer;" type="button" onclick="window.close()" value="'.$lang_login[5].'" /></td></tr>
      </table>
      </td>
    </tr>
    <tr><td class="li_td5">Copyright &copy; '.$last_edit.' PHP Web Stat &nbsp;&middot;&nbsp; Version '.$version_number.$revision_number.'</td></tr>
    </table>
    </form>
    ';
    include ( "func/html_footer.php" ); // include html footer
    exit;
    //----------------------------------------------------------------
   }
 }
//------------------------------------------------------------------------------
$_SESSION [ "hidden_stat" ] = md5_file ( "config/config.php" );
//------------------------------------------------------------------------------
// log login
if ( ( $_GET [ "parameter" ] != "finished" ) && ( $_GET [ "action" ] != "backtostat" ) && ( $_POST [ "archive" ] != "1" ) )
 {
  if     ( ( passCrypt ( $_POST [ 'password' ] ) == $adminpassword ) || ( md5 ( $_POST [ "password" ] ) == md5 ( $adminpassword ) ) ) { last_login_log ( 'adminpassword' ); $_SESSION [ "loggedin" ] = "admin"; }
  elseif ( ( ( passCrypt ( $_POST [ 'password' ] ) == $clientpassword ) || ( md5 ( $_POST [ "password" ] ) == md5 ( $clientpassword ) ) ) && ( $clientpassword != "" ) ) { last_login_log ( "userpassword"  ); $_SESSION [ "loggedin" ] = "client"; }
  else   { last_login_log ( "user" ); $_SESSION [ "loggedin" ] = "user"; }
 }
//------------------------------------------------------------------------------
// cache refresh
if ( $_GET [ "parameter" ] != "finished" )
 {
  if ( $_POST [ "archive" ] )
   {
    if ( $_POST [ "from_timestamp" ] && $_POST [ "until_timestamp" ] )
     {
      //--------------------------------
      $time_stamp_generate = mktime ( 0 , 0 , 0 , substr ( $_POST [ "from_timestamp" ] , 3 , 2 ) , substr ( $_POST [ "from_timestamp" ] , 0 , 2 ) , substr ( $_POST [ "from_timestamp" ] , 6 ) )."-".mktime ( 23 , 59 , 59 , substr ( $_POST [ "until_timestamp" ] , 3 , 2 ) , substr ( $_POST [ "until_timestamp" ] , 0 , 2 ) , substr ( $_POST [ "until_timestamp" ] , 6 ) ) ;
      $load_logfile = "cache_creator.php?loadfile=2&archive=".$time_stamp_generate;
      unset ( $time_stamp_generate );
      //--------------------------------
      $cache_timestamp_file = fopen ( "log/cache_time_stamp_archive.php" , "w+" );
      fwrite ( $cache_timestamp_file , "<?php ?>" ); // php header + footer
      fclose ( $cache_timestamp_file );
      unset  ( $cache_timestamp_file );
      //--------------------------------
      $cache_visitors_file = fopen ( "log/cache_visitors_archive.php" , "w+" );
      fwrite ( $cache_visitors_file , "<?php ?>" ); // php header + footer
      fclose ( $cache_visitors_file );
      unset  ( $cache_visitors_file );
      //--------------------------------
     }
    else
     {
      //--------------------------------
      if ( ! is_numeric ( $_POST [ "archive" ] ) ) { $_POST [ "archive" ] = 1; }
      $load_logfile = "cache_creator.php?loadfile=2&archive=".$_POST [ "archive" ];
      //--------------------------------
      $cache_timestamp_file = fopen ( "log/cache_time_stamp_archive.php" , "w+" );
      fwrite ( $cache_timestamp_file , "<?php ?>" ); // php header + footer
      fclose ( $cache_timestamp_file );
      unset  ( $cache_timestamp_file );
      //--------------------------------
      $cache_visitors_file = fopen ( "log/cache_visitors_archive.php" , "w+" );
      fwrite ( $cache_visitors_file , "<?php ?>" ); // php header + footer
      fclose ( $cache_visitors_file );
      unset  ( $cache_visitors_file );
      //--------------------------------
     }
   }
  else
   {
    if ( ( $_GET [ "from_timestamp" ] ) && ( $_GET [ "until_timestamp" ] ) )
     {
      //--------------------------------
      $time_stamp_generate = mktime ( 0 , 0 , 0 , substr ( $_GET [ "from_timestamp" ] , 3 , 2 ) , substr ( $_GET [ "from_timestamp" ] , 0 , 2 ) , substr ( $_GET [ "from_timestamp" ] , 6 ) )."-".mktime ( 23 , 59 , 59 , substr ( $_GET [ "until_timestamp" ] , 3 , 2 ) , substr ( $_GET [ "until_timestamp" ] , 0 , 2 ) , substr ( $_GET [ "until_timestamp" ] , 6 ) ) ;
      $load_logfile = "cache_creator.php?loadfile=2&archive=".$time_stamp_generate;
      unset ( $time_stamp_generate );
      //--------------------------------
      $cache_timestamp_file = fopen ( "log/cache_time_stamp_archive.php" , "w+" );
      fwrite ( $cache_timestamp_file , "<?php ?>" ); // php header + footer
      fclose ( $cache_timestamp_file );
      unset  ( $cache_timestamp_file );
      //--------------------------------
      $cache_visitors_file = fopen ( "log/cache_visitors_archive.php" , "w+" );
      fwrite ( $cache_visitors_file , "<?php ?>" ); // php header + footer
      fclose ( $cache_visitors_file );
      unset  ( $cache_visitors_file );
      //--------------------------------
     }
    else
     {
      //--------------------------------
      // set the physical address to zero
      $cache_timestamp_file = fopen ( "log/cache_memory_address.php" , "w+" );
 	     fwrite ( $cache_timestamp_file , "<?php \$cache_memory_address = \"\";?>" ); // php header + footer
 	    fclose ( $cache_timestamp_file );
 	    unset  ( $cache_timestamp_file );
 	    //--------------------------------
      $load_logfile = "func/func_load_creator.php?parameter=update_stat_cache";
      //--------------------------------
     }
   }
  //------------------------------------------------------------------
  // refresh box
  include ( "func/html_header.php" ); // include html header
  echo '
  <div id="refresh">
   <div id="rf_header"><p style="margin: 0px; padding-top: 2px;">'.$lang_refresh[1].'</p></div>
   <div style="width: 283px; margin: auto;">
   <div id="rf_indicator"><p style="margin: 0px; padding-top: 15px;"><img src="images/load_indicator.gif" alt="loading" title="loading" /><br /><iframe src="'.$load_logfile.'" width="10" height="10" name="creator" scrolling="no" marginheight="0" marginwidth="0" frameborder="0"></iframe></p></div>
   <div id="rf_text">
    ';
    if ( ( $_POST [ "archive" ] ) || ( $_GET [ "from_timestamp" ] ) )
     {
      echo '<p style="margin: 0px; padding-top: 15px;">'.$lang_archive[1].'<br />'.$lang_archive[2].'</p>';
     }
    else
     {
      echo '<p style="margin: 0px; padding-top: 15px;">'.$lang_refresh[2].'<br />'.$lang_refresh[3].'</p>';
     }
    echo '
   </div>
   </div>
   <div id="rf_co_th">'.$lang_refresh[4].'</div>
   <div id="rf_co_iframe">
    ';
    if ( ( $_POST [ "archive" ] ) || ( $_GET [ "from_timestamp" ] ) )
     {
      echo '<p style="margin: 0px; padding-top: 4px;"><iframe name="timestamp_control_archive" src="func/func_timestamp_control.php?parameter=archive" style="width:200px; height:20px;" frameborder="0" scrolling="no">Sorry but your browser does not support iframes</iframe></p>';
     }
    else
     {
      echo '<p style="margin: 0px; padding-top: 4px;"><iframe name="timestamp_control_stat" src="func/func_timestamp_control.php?parameter=stat" style="width:200px; height:20px;" frameborder="0" scrolling="no">Sorry but your browser does not support iframes</iframe></p>';
     }
    echo '
   </div>
  </div>
  ';
  include ( "func/html_footer.php" ); // include html footer
  exit;
  //------------------------------------------------------------------
 }
//------------------------------------------------------------------------------
$timer_start = timer_start(); // start the stopwatch timer
//------------------------------------------------------------------------------
if ( ( isset ( $_GET [ "archive" ] ) ) || ( isset ( $_GET [ "archive_save" ] ) ) )
 {
  //--------------------------------
  if ( $_GET [ "archive" ] )
   {
    include ( "log/cache_time_stamp_archive.php" ); // include the last timestamp
    include ( "log/cache_visitors_archive.php"   ); // include the saved arrays
   }
  //--------------------------------
  if ( $_GET [ "archive_save" ] )
   {
    if ( ( strpos ( $_GET [ "archive_save" ]  , "log/archive/" ) != 0 ) || ( strpos( $_GET [ "archive_save" ] , ".." ) === true) || ( !file_exists ( $_GET [ "archive_save" ] ) ) )
     {
      exit;
     }
    else
     {
      include ( $_GET [ "archive_save" ] ); // include the saved arrays
     }
   }
  //--------------------------------
 }
else
 {
  //--------------------------------
  include ( "log/cache_time_stamp.php" ); // include the last timestamp
  include ( "log/cache_visitors.php"   ); // include the saved arrays
  //--------------------------------
 }
//------------------------------------------------------------------------------
//take the first timestamp

// if database version
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
      $query           = "SELECT MIN(timestamp) FROM ".$db_prefix."_main";
      $result          = db_query ( $query , 1 , 0 );
      $first_timestamp = date ( $dateform , $result[0][0] );
      //--------------------------------
     }
    else
     {
      //--------------------------------
      $first_timestamp = $starting_date;
      //--------------------------------
     }
   }
  else
   {
    //--------------------------------
    $query           = "SELECT MIN(timestamp) FROM ".$db_prefix."_main";
    $result          = db_query ( $query , 1 , 0 );
    $first_timestamp = date ( $dateform , $result[0][0] );
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
      $logfile_entry_first_timestamp = fgetcsv ( $logfile_first_timestamp , 60000 , "|" ); // read entry from logfile
      $first_timestamp = date ( $dateform , $logfile_entry_first_timestamp [ 0 ] );

      fclose ( $logfile_first_timestamp       ); // close logfile
      unset  ( $logfile_first_timestamp       );
      unset  ( $logfile_entry_first_timestamp );
      //--------------------------------
     }
    else
     {
      //--------------------------------
      $first_timestamp = $starting_date;
      //--------------------------------
     }
   }
  else
   {
    //--------------------------------
    $logfile_first_timestamp = fopen ( "log/logdb_backup.dta" , "r" ); // open logfile
    $logfile_entry_first_timestamp = fgetcsv ( $logfile_first_timestamp , 60000 , "|" ); // read entry from logfile
    $first_timestamp = date ( $dateform , $logfile_entry_first_timestamp [ 0 ] );
    fclose ( $logfile_first_timestamp       ); // close logfile
    unset  ( $logfile_first_timestamp       );
    unset  ( $logfile_entry_first_timestamp );
    //--------------------------------
   }
  //------------------------------------------------------------------
 }
//------------------------------------------------------------------------------
clearstatcache(); // empty the filecache to get the real live data
//------------------------------------------------------------------------------
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
//------------------------------------------------------------------------------
// check if details of every operating system should be displayed
if ( ( $show_detailed_os == 0 ) && ( $operating_system ) )
 {
  foreach ( $operating_system as $key => $value )
   {
    if ( strpos ( $key , " - " ) > 0 )
     {
      $operating_system_simple [ trim ( substr ( $key , 0 , strrpos ( $key , " - " ) ) ) ] = $operating_system_simple [ trim ( substr ( $key , 0 , strrpos ( $key , " - " ) ) ) ] + $value;
     }
    else
     {
      $operating_system_simple [ trim ( substr ( $key , 0 , strrpos ( $key , " " ) ) ) ] = $operating_system_simple [ trim ( substr ( $key , 0 , strrpos ( $key , " " ) ) ) ] + $value;
     }
   }
  $operating_system = $operating_system_simple;
 }
unset ( $operating_system_simple );
//------------------------------------------------------------------------------
include ( "func/html_header.php"  ); // include html header
//------------------------------------------------------------------------------
// include refresh funktion
if ( ( $_GET [ "archive" ] ) || ( $_GET [ "archive_save" ] ) )
 {
 }
else
 {
  include ( "func/func_refresh.php" ); // include function refresh
  echo "<script type=\"text/javascript\"> refresh_display()</script>\n";
 }
//------------------------------------------------------------------------------
if ( $_COOKIE['dontcount'])
 {
  $cookie = "<a href=\"cookie.php\"><img style=\"vertical-align:middle;\" src=\"".$theme."/menu/dontcount.png\" alt=\"\" onmouseover=\"Tip('".$lang_setcookie[1]."&lt;br /&gt;&lt;br /&gt;".$lang_setcookie[2]."', WIDTH, 200, OFFSETX, -60, OFFSETY, 22, OPACITY, 90, TITLEALIGN, 'center', TITLE, 'Info', SHADOW, true, BGIMG, 'images/tooltip_bg.gif', FADEIN, 200, FADEOUT, 900);\" onmouseout=\"UnTip();\" /></a><img style=\"vertical-align:middle;\" src=\"images/pixel.gif\" width=\"12\" height=\"12\" alt=\"\" />";
 }
else
 {
  $cookie = "<a href=\"cookie.php\"><img style=\"vertical-align:middle;\" src=\"".$theme."/menu/count.png\" alt=\"\" onmouseover=\"Tip('".$lang_setcookie[3]."&lt;br /&gt;&lt;br /&gt;".$lang_setcookie[4]."', WIDTH, 200, OFFSETX, -60, OFFSETY, 22, OPACITY, 90, TITLEALIGN, 'center', TITLE, 'Info', SHADOW, true, BGIMG, 'images/tooltip_bg.gif', FADEIN, 200, FADEOUT, 900);\" onmouseout=\"UnTip();\" /></a><img style=\"vertical-align:middle;\" src=\"images/pixel.gif\" width=\"12\" height=\"12\" alt=\"\" />";
 }
//------------------------------------------------------------------------------
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"func/tooltip.js\"></script>\n";
if ( ( $_GET [ "archive" ] ) || ( $_GET [ "archive_save" ] ) )
 {
  echo "<a id=\"top\" name=\"top\"><img src=\"images/pixel.gif\" width=\"1\" height=\"1\" alt=\"\"></a>\n";
 }
echo "<table id=\"groundtable\" border=\"0\" width=\"960\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\"><tr><td>\n";
//------------------------------------------------------------------------------
if ( ( $_GET [ "archive" ] ) || ( $_GET [ "archive_save" ] ) )
 {
  //------------------------------------------------------------------
  // display the archive header
  if ( $_GET [ "archive_save" ] )
   {
    $temp = substr ( $_GET [ "archive_save" ] , strrpos ( $_GET [ "archive_save" ] , "/" ) + 1 );
    $temp = substr ( $temp , 0 , strlen ($temp ) - 4 );
    $temp = explode ( "-" , $temp );
    $from_timestamp  = $temp [ 0 ];
    $until_timestamp = $temp [ 1 ];
    unset ( $temp );
   }
  else
   {
    $from_timestamp  = strip_tags ( $_GET [ "from_timestamp"  ] );
    $until_timestamp = strip_tags ( $_GET [ "until_timestamp" ] );
   }
  echo '
  <table id="header_archive" border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="140" align="center" valign="middle">
    <a href="http://www.php-web-statistik.de" target="_blank"><img src="images/system.png" width="104" height="50" alt="PHP Web Stat" title="PHP Web Stat" /></a>
    </td>
    <td align="center" valign="middle" style="padding-left:110px;">
    ';
    if ( $_GET [ "archive" ] )
     {
      if ( $_SESSION [ "loggedin" ] == "admin" )
       {
        echo '<iframe src="func/func_archive_save.php?from_timestamp='.$from_timestamp.'&until_timestamp='.$until_timestamp.'" width="500" height="30" name="creator" scrolling="no" marginheight="0" marginwidth="0" frameborder="0"></iframe>';
       }
      else
       {
        echo '<b><big><big>'.$lang_archive[3].'</big></big></b>';
       }
     }
    else
     {
      $archive_files = read_dir ( "log/archive" );
      asort ( $archive_files );
      echo '
      <form style="margin:0px" action="index.php" method="get">
      <select name="archive_save" size="1" style="width:220px;">';
      foreach ( $archive_files as $value )
       {
        $temp = substr ( $value , strrpos ( $value , "/" ) + 1 );
        $temp = substr ( $temp , 0 , strlen ($temp ) - 4 );
        $temp = explode ( "-" , $temp );
        echo '<option value="'.$value.'">'.date ( "Y-m-d" , trim ( $temp [ 0 ] ) ).' - '.date ( "Y-m-d" , trim ( $temp [ 1 ] )  ).'</option>';
       }
      echo '
      </select>
      <input type="hidden" name="parameter" value="finished" />
      <input type="submit" class="submit" onclick="show_archive();" value="'.$lang_archive[7].'" />
      </form>
      ';
     }
    echo '
    </td>
    <td width="250" align="center" valign="top">
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
      <td height="35" align="right" style="padding:0px 15px 0px 0px"><a href="javascript:void(0)" onclick="window.close();">'.$lang_footer[3].'</a></td>
    </tr>
    <tr>
      <td height="24" align="right" style="padding:0px 15px 0px 0px"><input type="button" class="button" onclick="window.print();return false;" value="&nbsp;'.$lang_menue[6].'&nbsp;" /></td>
    </tr>
    </table>
    </td>
  </tr>
  </table>

  <div id="print">
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
      <td width="140" align="center"><img src="images/system.gif" width="104" height="50" alt="PHP Web Stat" title="PHP Web Stat" /></td>
      <td align="center"><span style="font-size: 24px"><b>PHP Web Stat</b></span><br />'.$lang_stat[2].' <b>'.$stat_name.'</b></td>
      <td width="140" align="right" valign="top" style="padding-right: 20px;">
      ';
      if ( $language == "language/german.php" )
       {
        echo ''.date("d.m.Y").'';
       }
      else
       {
       	echo ''.date("Y/m/d").'';
       }
      echo '
      </td>
    </tr>
    </table>
  </div>

  <table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" align="center">
    <div class="lh_headline">'.$lang_archive[12].' '.date ( "d.m.Y - H:i:s " , $from_timestamp ).' '.$lang_archive[13].' '.date ( "d.m.Y - H:i:s " , $until_timestamp ).'</div>
    </td>
  </tr>
  </table>
  ';
  //------------------------------------------------------------------
 }
else
 {
  //------------------------------------------------------------------
  // display the stat header
  echo '
  <table id="header1_stat" border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="140" align="center" valign="middle">
    ';
    if ( $auto_update_check == 1 ) {
    echo '
    <script language="JavaScript" type="text/javascript">
    <!-- //hide from dinosaurs
    var STABLE;
    // -->
    </script>
    <script language="javascript" src="http://www.php-web-statistik.de/checkversion.js" type="text/javascript"></script>
    <script language="JavaScript" type="text/javascript">
    <!-- //hide from dinosaurs
    if ( !STABLE )
     {
      document.write(\'<a href="http://www.php-web-statistik.de" target="_blank"><img src="images/system.png" width="104" height="50" alt="PHP Web Stat" title="PHP Web Stat" /><\/a>\');
     }
    else
     {
     document.write(\'\');
      if ( STABLE > "'.$version_number.$revision_number.'" )
       {
        document.write(\'<a href="http://www.php-web-statistik.de" target="_blank"><img src="images/update.png" width="60" height="50" alt="www.php-web-statistik.de" title="www.php-web-statistik.de" /><\/a>\');
       }
      else
       {
        document.write(\'<a href="http://www.php-web-statistik.de" target="_blank"><img src="images/system.png" width="104" height="50" alt="PHP Web Stat" title="PHP Web Stat" /><\/a>\');
       }
      }
    // -->
    </script>
    <noscript><a href="http://www.php-web-statistik.de" target="_blank"><img src="images/system.png" width="104" height="50" alt="PHP Web Stat" title="PHP Web Stat" /></a></noscript>
    ';
     }
    else
     {
      echo "<a href=\"http://www.php-web-statistik.de\" target=\"_blank\"><img src=\"images/system.png\" style=\"vertical-align:middle;\"  width=\"104\" height=\"50\" alt=\"PHP Web Stat\" title=\"PHP Web Stat\" /></a>";
     }
    echo '
    </td>

    <td width="140" align="left" valign="middle">
    <span style="font-size:18px; font-family:Helvetica, Verdana, Arial, sans-serif"><b>PHP Web Stat</b></span><br />
    ';
    if ( $auto_update_check == 1 ) {
    echo '
    <script language="JavaScript" type="text/javascript">
    <!-- //hide from dinosaurs
    if ( !STABLE )
     {
      document.write(\'<b>Version '.$version_number.$revision_number.'<\/b>\');
     }
    else
     {
     document.write(\'\');
      if ( STABLE > "'.$version_number.$revision_number.'" )
       {
        document.write(\'<b>Update \'+STABLE+\'<\/b>\');
       }
      else
       {
        document.write(\'<b>Version '.$version_number.$revision_number.'<\/b>\');
       }
      }
    // -->
    </script>
    <noscript><b>Version '.$version_number.$revision_number.'</b></noscript>
    ';
     }
    else
     {
      echo '<b>Version '.$version_number.$revision_number.'</b>';
     }
    echo '
    </td>

    <td align="center" style="padding-right:6px;">';
    //--------------------------------
    if ( $script_activity != 1 )
     {
      echo '<div style="width: 94%; border: 1px solid #CC0000; padding: 2px; background: #F9FBE0; color: CC0000;">'.$lang_stat[4].'</div>';
     }
    else
     {
      echo '&nbsp;';
     }
    //--------------------------------
    echo '
    </td>

    <td width="450" valign="top">
    <table id="navmenu" border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
      <td height="40" align="right" valign="top" style="padding:4px 0px 0px 0px;">
      <a href="last_hits.php" rel="floatbox.lasthits" rev="width:'.$last_hits_width.' height:'.$last_hits_height.'" title="'.$lang_menue[1].'"><img style="vertical-align:middle;" src="'.$theme.'/menu/last_hits.png" alt="" onmouseover="Tip(\''.$lang_menue[1].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />
      <a href="archive.php" rel="floatbox.archive" rev="width:440 height:260" title="'.$lang_menue[2].'"><img style="vertical-align:middle;" src="'.$theme.'/menu/archive.png" alt="" onmouseover="Tip(\''.$lang_menue[2].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />
      <a href="plugin_choose.php" rel="floatbox.plugins" rev="width:440 height:260" title="'.$lang_menue[3].'"><img style="vertical-align:middle;" src="'.$theme.'/menu/plugin.png" alt="" onmouseover="Tip(\''.$lang_menue[3].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />
      <a href="javascript:void(0);" onclick="start(creator_iframe,control_iframe);"><img style="vertical-align:middle;" src="'.$theme.'/menu/refresh.png" alt="" onmouseover="Tip(\''.$lang_menue[4].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />
      ';
           //--------------------------------
           if ( $language == "language/german.php"     ) { echo '<a href="config/admin.php?lang=de"   ><img style="vertical-align:middle;" src="'.$theme.'/menu/admin.png" alt="" onmouseover="Tip(\''.$lang_menue[5].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />'; }
           if ( $language == "language/english.php"    ) { echo '<a href="config/admin.php?lang=en"   ><img style="vertical-align:middle;" src="'.$theme.'/menu/admin.png" alt="" onmouseover="Tip(\''.$lang_menue[5].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />'; }
           if ( $language == "language/dutch.php"      ) { echo '<a href="config/admin.php?lang=nl"   ><img style="vertical-align:middle;" src="'.$theme.'/menu/admin.png" alt="" onmouseover="Tip(\''.$lang_menue[5].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />'; }
           if ( $language == "language/italian.php"    ) { echo '<a href="config/admin.php?lang=it"   ><img style="vertical-align:middle;" src="'.$theme.'/menu/admin.png" alt="" onmouseover="Tip(\''.$lang_menue[5].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />'; }
           if ( $language == "language/spanish.php"    ) { echo '<a href="config/admin.php?lang=es"   ><img style="vertical-align:middle;" src="'.$theme.'/menu/admin.png" alt="" onmouseover="Tip(\''.$lang_menue[5].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />'; }
           if ( $language == "language/catalan.php"    ) { echo '<a href="config/admin.php?lang=es-ct"><img style="vertical-align:middle;" src="'.$theme.'/menu/admin.png" alt="" onmouseover="Tip(\''.$lang_menue[5].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />'; }
           if ( $language == "language/farsi.php"      ) { echo '<a href="config/admin.php?lang=fa"   ><img style="vertical-align:middle;" src="'.$theme.'/menu/admin.png" alt="" onmouseover="Tip(\''.$lang_menue[5].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />'; }
           if ( $language == "language/danish.php"     ) { echo '<a href="config/admin.php?lang=dk"   ><img style="vertical-align:middle;" src="'.$theme.'/menu/admin.png" alt="" onmouseover="Tip(\''.$lang_menue[5].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />'; }
           if ( $language == "language/french.php"     ) { echo '<a href="config/admin.php?lang=fr"   ><img style="vertical-align:middle;" src="'.$theme.'/menu/admin.png" alt="" onmouseover="Tip(\''.$lang_menue[5].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />'; }
           if ( $language == "language/turkish.php"    ) { echo '<a href="config/admin.php?lang=tr"   ><img style="vertical-align:middle;" src="'.$theme.'/menu/admin.png" alt="" onmouseover="Tip(\''.$lang_menue[5].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />'; }
           if ( $language == "language/hungarian.php"  ) { echo '<a href="config/admin.php?lang=hu"   ><img style="vertical-align:middle;" src="'.$theme.'/menu/admin.png" alt="" onmouseover="Tip(\''.$lang_menue[5].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />'; }
           if ( $language == "language/portuguese.php" ) { echo '<a href="config/admin.php?lang=pt"   ><img style="vertical-align:middle;" src="'.$theme.'/menu/admin.png" alt="" onmouseover="Tip(\''.$lang_menue[5].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />'; }
           if ( $language == "language/hebrew.php"     ) { echo '<a href="config/admin.php?lang=he"   ><img style="vertical-align:middle;" src="'.$theme.'/menu/admin.png" alt="" onmouseover="Tip(\''.$lang_menue[5].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />'; }
           if ( $language == "language/russian.php"    ) { echo '<a href="config/admin.php?lang=ru"   ><img style="vertical-align:middle;" src="'.$theme.'/menu/admin.png" alt="" onmouseover="Tip(\''.$lang_menue[5].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />'; }
           if ( $language == "language/serbian.php"    ) { echo '<a href="config/admin.php?lang=rs"   ><img style="vertical-align:middle;" src="'.$theme.'/menu/admin.png" alt="" onmouseover="Tip(\''.$lang_menue[5].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />'; }
           if ( $language == "language/finnish.php"    ) { echo '<a href="config/admin.php?lang=fi"   ><img style="vertical-align:middle;" src="'.$theme.'/menu/admin.png" alt="" onmouseover="Tip(\''.$lang_menue[5].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />'; }
           //--------------------------------
      echo '
      <a href="index.php?parameter=finished&amp;print=1"><img style="vertical-align:middle;" src="'.$theme.'/menu/print.png" alt="" onmouseover="Tip(\''.$lang_menue[6].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="12" height="12" alt="" />
      <a href="index.php?parameter=logout"><img style="vertical-align:middle;" src="'.$theme.'/menu/logout.png" alt="" onmouseover="Tip(\''.$lang_menue[7].'\', OFFSETX, -20, OFFSETY, 22, OPACITY, 90, SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 500, FADEOUT, 400);" onmouseout="UnTip();" /></a><img style="vertical-align:middle;" src="images/pixel.gif" width="26" height="26" alt="" />
      '.$cookie.'
      <img style="vertical-align:middle; margin-right:20px;" src="'.$theme.'/menu/info.png" alt="" onmouseover="Tip(\''.$lang_stat[2].' &lt;b&gt;'.$stat_name.'&lt;/b&gt;&lt;br /&gt;&lt;br /&gt;'.$lang_stat[3].' &lt;b&gt;'.$first_timestamp.'&lt;/b&gt;\', WIDTH, 200, OFFSETX, -60, OFFSETY, 22, OPACITY, 90, TITLEALIGN, \'center\', TITLE, \'Info\', SHADOW, true, BGIMG, \'images/tooltip_bg.gif\', FADEIN, 200, FADEOUT, 900);" onmouseout="UnTip();" />
      </td>
    </tr>
    </table>
    </td>
  </tr>
  </table>

  <div id="print">
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
      <td width="140" align="center"><img src="images/system.gif" width="104" height="50" alt="www.php-web-statistik.de" title="www.php-web-statistik.de" /></td>
      <td align="center"><span style="font-size: 24px"><b>PHP Web Stat</b></span><br />'.$lang_stat[2].' <b>'.$stat_name.'</b></td>
      <td width="140" align="right" valign="top" style="padding-right: 20px;">
      ';
      if ( $language == "language/german.php" )
       {
        echo ''.date("d.m.Y").'';
       }
      else
       {
       	echo ''.date("Y/m/d").'';
       }
      echo '
      </td>
    </tr>
    </table>
  </div>

  <table id="header2_stat" border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="bottom">
    <div id="tabs">
      <ul>
        <li id="current"><a href="javascript:void()" onclick="hideTAB(); showTAB(\'tab1\'); change(this);return false"><span>'.$lang_tab[1].'</span></a></li>
        <li><a href="javascript:void()" onclick="hideTAB(); showTAB(\'tab2\'); change(this);return false"><span>'.$lang_tab[2].'</span></a></li>
        <li><a href="javascript:void()" onclick="hideTAB(); showTAB(\'tab3\'); change(this);return false"><span>'.$lang_tab[3].'</span></a></li>
        <li><a href="javascript:void()" onclick="hideTAB(); showTAB(\'tab4\'); change(this);return false"><span>'.$lang_tab[4].'</span></a></li>
        <li><a href="javascript:void()" onclick="hideTAB(); showTAB(\'tab5\'); change(this);return false"><span>'.$lang_tab[5].'</span></a></li>
        <li><a href="javascript:void()" onclick="hideTAB(); showTAB(\'tab6\'); change(this);return false"><span>'.$lang_tab[6].'</span></a></li>
      </ul>
    </div>
    </td>
  </tr>
  </table>
  ';
  //------------------------------------------------------------------
 }
//------------------------------------------------------------------------------
// display the stat modules
echo '
<table id="content" border="0" width="100%" cellspacing="0" cellpadding="0">
<tr>
  <td valign="top">
  ';
  ##############################################################################
  ### tab overview ###
  if ( ( $_GET [ "archive" ] ) || ( $_GET [ "archive_save" ] ) )
   {
   }
  else
   {
    echo '<div class="changetab" id="tab1">
    ';
   }
  echo '
  <table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top">
    ';
    //----------------------------------------------------------------
    if ( $visitor_year )
     {
      $visitor_per_year = array_sum ( $visitor_year ) ;
     }
    else
     {
      $visitor_per_year = 0;
     }
    //----------------------------------------------------------------
    if ( ( $_GET [ "archive" ] ) || ( $_GET [ "archive_save" ] ) )
     {
     }
    else
     {
      if ( $visitor_day )
       {
        //--------------------------------
        if ( $real_first_timestamp == 0 )
         { $average = 0; }
        else
         {
          $average = ( int ) round ( array_sum ( $visitor_day ) / ( ( int ) round ( ( time () - $real_first_timestamp ) / 86400 ) + 1 ) );
         }
        //--------------------------------
       }
      else
       {
        //--------------------------------
        $average = 0;
        //--------------------------------
       }
      //------------
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
      //------------
      // if there is no visitor today
      if ( $visitor_day [ date ( "y/m/d" , $time_stamp_temp ) ] )
       {
       }
      else
       {
        $visitor_day [ date ( "y/m/d" , $time_stamp_temp ) ] = 0;
       }
      //------------
      // if there is no visitor yesterday
      if ( $visitor_day [ date ( "y/m/d" , strtotime ( "-1 day" , $time_stamp_temp ) ) ] )
       {
        $visitor_yesterday = $visitor_day [ date ( "y/m/d" , strtotime ( "-1 day" , $time_stamp_temp ) ) ];
       }
      else
       {
        $visitor_yesterday = 0;
       }
      //------------
      // if there is no visitor this month
      if ( $visitor_month [ date ( "Y/m" , $time_stamp_temp ) ] )
       {
       }
      else
       {
        $visitor_month [ date ( "Y/m" , $time_stamp_temp ) ] = 0;
       }
      //------------
      // if there is no visitor last month
      $visitor_lastmonth_count = date ( "j" , $time_stamp_temp ) + 1;
      $visitor_lastmonth_count = "-".$visitor_lastmonth_count." days";
      if ( $visitor_month [ date ( "Y/m" , strtotime ( $visitor_lastmonth_count ) ) ] )
       {
        $visitor_lastmonth = $visitor_month [ date ( "Y/m" , strtotime ( $visitor_lastmonth_count ) ) ];
       }
      else
       {
        $visitor_lastmonth = 0;
       }
      //------------

      //------------
     display_overview ( "<div class=\"stat_user\">".$lang_overview[1]."</div>" ,
                      $lang_overview[2] ,
                      $visitor_per_year ,
                      $lang_overview[3] ,
                      $visitor_day [ date ( "y/m/d" , $time_stamp_temp ) ] ,
                      $lang_overview[4] ,
                      $visitor_yesterday ,
                      $lang_overview[5] ,
                      $visitor_month [ date ( "Y/m" , $time_stamp_temp ) ] ,
                      $lang_overview[6] ,
                      $visitor_lastmonth ,
                      $lang_overview[7] ,
                      max ( $visitor_day ) ,
                      $lang_overview[8] ,
                      $average ,
                      $display_width_overview );
      //--------------------------------
      unset ( $average );
      unset ( $visitor_yesterday );
      unset ( $visitor_lastmonth );
      unset ( $visitor_per_year  );
      //-----------------------------
      // delete the year in visitor_day
      $delete_year = 0;
      //-----------------------------
      echo '<br />';
     }
    //--------------------------------
    if ( ( $display_show_hour != 0 ) && ( count ( $visitor_hour ) >= 1 ) )
     {
      //--------------------------------
      $max_value = array_sum ( $visitor_hour );
      ksort ( $visitor_hour );
      display ( "<div class=\"stat_user\">".$lang_hour[1]."</div>" , $lang_hour[2] , $lang_module[1] , $lang_module[2] , $visitor_hour , $display_width_hour , 24 , $lang_module[3] , $delete_year , $max_value , "x" , 0 , 0 , 0 , 0);
      unset ( $max_value );
      //--------------------------------
     }
    //--------------------------------
    echo '
    </td>
    <td align="center" valign="top">
    ';
    //--------------------------------
    if ( ( $display_show_day != 0 ) && ( count ( $visitor_day ) >= 1 ) )
    {
     if ( ( $_GET [ "archive" ] ) || ( $_GET [ "archive_save" ] ) )
      {
       //-------------------------------
       $delete_year = 1; # the year has to be deleted
       //-------------------------------
       $max_value = array_sum ( $visitor_day );
       ksort ( $visitor_day );
       display ( "<div class=\"stat_user\">".$lang_day[1]."</div>" , $lang_day[2] , $lang_module[1] , $lang_module[2] , $visitor_day , $display_width_day , count($visitor_day) , $lang_module[3] , $delete_year , $max_value , "x" , 0 , 0 , 0 , 0 );
       unset ( $max_value );
       $delete_year = 0;
       //-------------------------------
      }
     else
      {
       //-------------------------------
       $delete_year = 1; # the year has to be deleted
       //-------------------------------
       // get the actual day & the amount of days this month
       $temp_month           = date ( "m" );
       $temp_count_day_month = date ( "t" );
       $temp_year            = date ( "y" );
       //--------------------------------
       // set the days values to zero
       for ( $x = 1 ; $x <= $temp_count_day_month ; $x++ )
        {
         //--------------------------------
         if ( ( $x <= 9 ) && ( !$visitor_day [ $temp_year."/".$temp_month."/0".$x ] ) )
          {
           $visitor_day [ $temp_year."/".$temp_month."/0".$x ] = 0;
          }
         if ( ( $x > 9 ) && ( !$visitor_day [ $temp_year."/".$temp_month."/".$x ] ) )
          {
           $visitor_day [ $temp_year."/".$temp_month."/".$x  ] = 0;
          }
         //--------------------------------
        }
       unset ( $temp_month           );
       unset ( $temp_count_day_month );
       unset ( $temp_year            );
       //-------------------------------
       krsort ( $visitor_day );
       $temp_count_day_month = date ( "t" , time () );
       $max_value = array_sum ( $visitor_day );
       $visitor_day = array_slice ( $visitor_day , 0 , $temp_count_day_month );
       ksort ( $visitor_day );
       display ( "<div class=\"stat_user\">".$lang_day[1]."</div>" , $lang_day[2] , $lang_module[1] , $lang_module[2] , $visitor_day , $display_width_day , $temp_count_day_month , $lang_module[3] , $delete_year , $max_value , "visitors_per_day" , 0 , 0 , 0 , 0 );
       unset ( $temp_count_day_month );
       unset ( $max_value            );
       $delete_year = 0;
       //-------------------------------
      }
    }
    //--------------------------------
    echo '
    </td>
    <td align="right" valign="top">
    ';
    //--------------------------------
    if ( ( $display_show_weekday != 0 ) && ( count ( $visitor_weekday ) >= 1 ) )
    {
     //--------------------------------
     // sort the weekdays
     $sort_weekday = array (
     $lang_weekday [ 3 ] => $visitor_weekday [ "1" ],
     $lang_weekday [ 4 ] => $visitor_weekday [ "2" ],
     $lang_weekday [ 5 ] => $visitor_weekday [ "3" ],
     $lang_weekday [ 6 ] => $visitor_weekday [ "4" ],
     $lang_weekday [ 7 ] => $visitor_weekday [ "5" ],
     $lang_weekday [ 8 ] => $visitor_weekday [ "6" ],
     $lang_weekday [ 9 ] => $visitor_weekday [ "0" ]
     );
     //--------------------------------
     $visitor_weekday = $sort_weekday;
     if ( !$visitor_weekday [ $lang_weekday [ 9 ] ] ) { $visitor_weekday [ $lang_weekday [ 9 ] ] = 0; }
     if ( !$visitor_weekday [ $lang_weekday [ 3 ] ] ) { $visitor_weekday [ $lang_weekday [ 3 ] ] = 0; }
     if ( !$visitor_weekday [ $lang_weekday [ 4 ] ] ) { $visitor_weekday [ $lang_weekday [ 4 ] ] = 0; }
     if ( !$visitor_weekday [ $lang_weekday [ 5 ] ] ) { $visitor_weekday [ $lang_weekday [ 5 ] ] = 0; }
     if ( !$visitor_weekday [ $lang_weekday [ 6 ] ] ) { $visitor_weekday [ $lang_weekday [ 6 ] ] = 0; }
     if ( !$visitor_weekday [ $lang_weekday [ 7 ] ] ) { $visitor_weekday [ $lang_weekday [ 7 ] ] = 0; }
     if ( !$visitor_weekday [ $lang_weekday [ 8 ] ] ) { $visitor_weekday [ $lang_weekday [ 8 ] ] = 0; }
     unset ( $sort_weekday );
     $max_value = array_sum ( $visitor_weekday );
     display ( "<div class=\"stat_user\">".$lang_weekday[1]."</div>" , $lang_weekday[2] , $lang_module[1] , $lang_module[2] , $visitor_weekday , $display_width_weekday , 7 , $lang_module[3] , $delete_year , $max_value , "x" , 0 , 0 , 0 , 0 );
     echo '<img src="images/pixel.gif" width="21" height="21" alt="" />';
     unset ( $max_value );
     //--------------------------------
    }
    if ( ( $display_show_month != 0 ) && ( count ( $visitor_month ) >= 1 ) )
    {
     if ( ( $_GET [ "archive" ] ) || ( $_GET [ "archive_save" ] ) )
      {
       //--------------------------------
       $max_value = array_sum ( $visitor_month );
       ksort ( $visitor_month );
       display ( "<div class=\"stat_user\">".$lang_month[1]."</div>" , $lang_month[2] , $lang_module[1] , $lang_module[2] , $visitor_month , $display_width_month , 12 , $lang_module[3] , $delete_year , $max_value , "visitors_per_month" , 0 , 0 , 0 , 0 );
       echo '<img src="images/pixel.gif" width="21" height="21" alt="" />';
       unset ( $max_value   );
       //--------------------------------
      }
     else
      {
       //--------------------------------
       $max_value = array_sum ( $visitor_month );
       // to change the year of month values in the display function
       $delete_year = 2;

       // get the actual year
       $temp_year = date ( "Y" );

       // set the month values to zero
       for ( $x = 1 ; $x <= 12 ; $x++ )
        {
         if ( ( $x <= 9 ) && ( !$visitor_month [ $temp_year."/0".$x ] ) )
          {
           $visitor_month [ $temp_year."/0".$x ] = 0;
          }
         if ( ( $x > 9 ) &&  ( !$visitor_month [ $temp_year."/".$x ] ) )
          {
           $visitor_month [ $temp_year."/".$x ] = 0;
          }
        }
       unset ( $temp_year );
       krsort ( $visitor_month );
       $visitor_month = array_slice ( $visitor_month , 0 , 12 );
       ksort ( $visitor_month );
       display ( "<div class=\"stat_user\">".$lang_month[1]."</div>" , $lang_month[2] , $lang_module[1] , $lang_module[2] , $visitor_month , $display_width_month , 12 , $lang_module[3] , $delete_year , $max_value , "visitors_per_month" , 0 , 0 , 0 , 0 );
       echo '<img src="images/pixel.gif" width="21" height="21" alt="" />';
       unset ( $max_value   );
       unset ( $delete_year );
       //--------------------------------
      }
     //--------------------------------
    }
    if ( ( $display_show_year != 0 ) && ( count ( $visitor_year ) >= 1 ) )
    {
     //--------------------------------
     $max_value = array_sum ( $visitor_year );
     ksort ( $visitor_year );
     $count_year=count($visitor_year);
     if ( $count_year > $display_count_year ) { $count_year = $display_count_year; }
     display ( "<div class=\"stat_user\">".$lang_year[1]."</div>" , $lang_year[2] , $lang_module[1] , $lang_module[2] , $visitor_year , $display_width_year , $count_year , $lang_module[3] , $delete_year , $max_value , "trends_year" , 0 , 0 , 0 , 1 );
     unset ( $max_value   );
     //--------------------------------
    }
  //--------------------------------
    echo '
    </td>
  </tr>
  </table>
  ';
################################################################################
### tab user data ###
if ( ( $_GET [ "archive" ] ) || ( $_GET [ "archive_save" ] ) )
 {
  echo '<br />';
  echo '<hr>';
 }
else
 {
  echo '
  </div>
  <div class="changetab page-break" id="tab2">
  ';
 }
  echo '
  <table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top">
    ';
    //--------------------------------
    if ( ( $display_show_browser != 0 ) && ( count ( $browser ) >= 1 ) )
    {
     //--------------------------------
     $max_value = array_sum ( $browser );
     arsort ( $browser );
     display ( "<div class=\"stat_user\">".$lang_browser[1]."</div>" , $lang_browser[2] , $lang_module[1] , $lang_module[2] , $browser , $display_width_browser , $display_count_browser , $lang_module[3] , $delete_year , $max_value , "pattern_browser.dta" , 0 , 1 , 0 , 0 );
     echo '<img src="images/pixel.gif" width="21" height="21" alt="" />';
     unset ( $max_value   );
     //--------------------------------
    }
    //--------------------------------
    if ( ( $display_show_os != 0 ) && ( count ( $operating_system ) >= 1 ) )
    {
     //--------------------------------
     $max_value = array_sum ( $operating_system );
     arsort ( $operating_system );
     display ( "<div class=\"stat_user\">".$lang_os[1]."</div>" , $lang_os[2] , $lang_module[1] , $lang_module[2] , $operating_system , $display_width_os , $display_count_os , $lang_module[3], $delete_year , $max_value , "pattern_operating_system.dta" , 0 , 0 , 1 , 0 );
     unset ( $max_value   );
     //--------------------------------
    }
    //--------------------------------
    echo '
    </td>
    <td align="right" valign="top">
    ';
    //--------------------------------
    if ( ( $display_show_resolution != 0 ) && ( count ( $resolution ) >= 1 ) )
    {
     //--------------------------------
     $max_value = array_sum ( $resolution );
     arsort ( $resolution );
     display ( "<div class=\"stat_user\">".$lang_resolution[1]."</div>" , $lang_resolution[2] , $lang_module[1] , $lang_module[2] , $resolution , $display_width_resolution , $display_count_resolution , $lang_module[3] , $delete_year , $max_value , "pattern_resolution.dta" , 0 , 0 , 0 , 0 );
     echo '<img src="images/pixel.gif" width="21" height="21" alt="" />';
     unset ( $max_value   );
     //--------------------------------
    }
    //--------------------------------
    if ( ( $display_show_colordepth != 0 ) && ( count ( $color_depth ) >= 1 ) )
    {
     //--------------------------------
     $max_value = array_sum ( $color_depth );
     arsort ( $color_depth );
     display ( "<div class=\"stat_user\">".$lang_colordepth[1]."</div>" , $lang_colordepth[2] , $lang_module[1] , $lang_module[2] , $color_depth , $display_width_colordepth , $display_count_colordepth , $lang_module[3], $delete_year , $max_value , "x" , 0 , 0 , 0 , 0 );
     echo '<img src="images/pixel.gif" width="24" height="24" alt="" />';
     unset ( $max_value   );
     //--------------------------------
    }
    //--------------------------------
    if ( ( $display_show_javascript_status != 0 ) && ( count ( $javascript_status ) >= 1 ) )
    {
     //--------------------------------
     $max_value = array_sum ( $javascript_status );
     display ( "<div class=\"stat_user\">".$lang_javascript[1]."</div>" , $lang_javascript[2] , $lang_module[1] , $lang_module[2] , $javascript_status , $display_width_javascript_status , 2 , $lang_module[3], $delete_year , $max_value , "x" , 0 , 0 , 0 , 0 );
     unset ( $max_value   );
     //--------------------------------
    }
    //--------------------------------
    echo '
    </td>
  </tr>
  </table>
  ';
################################################################################
### tab site visits ###
if ( ( $_GET [ "archive" ] ) || ( $_GET [ "archive_save" ] ) )
 {
  echo '<br />';
  echo '<hr>';
 }
else
 {
  echo '
  </div>
  <div class="changetab page-break" id="tab3">
  ';
 }
  echo '
  <table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top">
    ';
    //--------------------------------
    if ( ( $display_show_site != 0 ) && ( count ( $site_name ) >= 1 ) )
    {
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

     $max_value = array_sum ( $site_name );
     arsort ( $site_name );
     display ( "<div class=\"stat_user\">".$lang_site[1]."</div>" , $lang_site[2] , $lang_module[1] , $lang_module[2] , $site_name , $display_width_site , $display_count_site , $lang_module[3] , $delete_year , $max_value , "site_name" , 0 , 0 , 0 , 0 );
     echo '<img src="images/pixel.gif" width="21" height="21" alt="" />';
     unset ( $max_value   );
    }
    //--------------------------------
    if ( ( $display_show_entrysite != 0 ) && ( count ( $entrysite ) >= 1 ) )
    {
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

     $max_value = array_sum ( $entrysite );
     arsort ( $entrysite );
     display ( "<div class=\"stat_user\">".$lang_entrysite[1]."</div>" , $lang_entrysite[2] , $lang_module[1] , $lang_module[2] , $entrysite , $display_width_entrysite , $display_count_entrysite , $lang_module[3] , $delete_year , $max_value , "entrysite" , 0 , 0 , 0 , 0 );
     unset ( $max_value   );
    }
    //--------------------------------
    echo '
    </td>
  </tr>
  </table>
  ';
################################################################################
### tab site referers ###
if ( ( $_GET [ "archive" ] ) || ( $_GET [ "archive_save" ] ) )
 {
  echo '<br />';
  echo '<hr>';
 }
else
 {
  echo '
  </div>
  <div class="changetab page-break" id="tab4">
  ';
 }
  echo '
  <table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top">
    ';
    //--------------------------------
    if ( ( $display_show_referer != 0 ) && ( count ( $referer ) >= 1 ) )
    {
     $max_value = array_sum ( $referer );
     arsort  ( $referer );
     display ( "<div class=\"stat_user\">".$lang_referer[1]."</div>" , $lang_referer[2] , $lang_module[1] , $lang_module[2] , $referer , $display_width_referer , $display_count_referer , $lang_module[3] , $delete_year , $max_value , "referer" , 0 , 0 , 0 , 0 );
     unset ( $max_value   );
    }
    //--------------------------------
    echo '
    </td>
  </tr>
  </table>
  ';
################################################################################
### tab search engines ###
if ( ( $_GET [ "archive" ] ) || ( $_GET [ "archive_save" ] ) )
 {
   echo '<br />';
   echo '<hr>';
 }
else
 {
  echo '
  </div>
  <div class="changetab page-break" id="tab5">
  ';
 }
  echo '
  <table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top">
    ';
    //--------------------------------
    if ( ( $display_show_searchengines != 0 ) && ( count ( $searchengines_archive ) >= 1 ) )
    {
     $max_value = array_sum ( $searchengines_archive );
     arsort ( $searchengines_archive );
     display ( "<div class=\"stat_user\">".$lang_searchengine[1]."</div>" , $lang_searchengine[2] , $lang_module[1] , $lang_module[2] , $searchengines_archive , $display_width_searchengines , $display_count_searchengines , $lang_module[3] , $delete_year , $max_value , "searchengines_archive" , 0 , 0 , 0 , 0 );
     echo '<img src="images/pixel.gif" width="21" height="21" alt="" />';
     unset ( $max_value   );
    }
    //--------------------------------
    echo '
    </td>
    <td align="right" valign="top">
    ';
    //--------------------------------
    if ( ( $display_show_searchwords != 0 ) && ( count ( $searchwords_archive ) >= 1 ) )
    {
     $max_value = array_sum ( $searchwords_archive );
     arsort ( $searchwords_archive );
     display ( "<div class=\"stat_user\">".$lang_searchwords[1]."</div>" , $lang_searchwords[2] , $lang_module[1] , $lang_module[2] , $searchwords_archive , $display_width_searchwords , $display_count_searchwords , $lang_module[3], $delete_year , $max_value , "searchwords_archive"  , 0 , 0 , 0 , 0 );
     unset ( $max_value   );
    }
    //--------------------------------
    echo '
    </td>
  </tr>
  </table>
  ';
################################################################################
### tab country of origin ###
if ( ( $_GET [ "archive" ] ) || ( $_GET [ "archive_save" ] ) )
 {
   echo '<br />';
   echo '<hr>';
 }
else
 {
  echo '
  </div>
  <div class="changetab page-break" id="tab6">
  ';
 }
  echo '
  <table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top">
    ';
    //--------------------------------
    if ( ( $display_show_cc != 0 ) && ( count ( $country ) >= 1 ) )
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
     display ( "<div class=\"stat_user\">".$lang_country[1]."</div>" , $lang_country[2] , $lang_module[1] , $lang_module[2] , $country_full , $display_width_cc , $display_count_cc , $lang_module[3] , $delete_year , $max_value , "country" , 1 , 0 , 0 , 0 );
     unset ( $max_value   );
    }
    //--------------------------------
    echo '
    </td>
  </tr>
  </table>
  ';
################################################################################
if ( ( $_GET [ "archive" ] ) || ( $_GET [ "archive_save" ] ) )
 {
 }
else
 {
  echo '
  </div>
  <script type="text/javascript"> showTAB(\'tab1\')</script>';
 }
  echo '
  </td>
</tr>
</table>
';
################################################################################
### footer ###
if ( $db_active == 1 )
 {
	echo '
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr><td><img src="images/pixel.gif" width="2" height="5" alt="" /></td></tr>
	<tr>
	  <td height="26" align="center" valign="middle">Copyright &copy; '.$last_edit.' <a href="http://www.php-web-statistik.de" target="_blank">PHP Web Stat</a> &nbsp;<b>&middot;</b>&nbsp; '.$lang_footer[1].' '.timer_stop($timer_start).' '.$lang_footer[2].'.</td>
	  <td width="240" align="center" valign="middle"><a href="http://validator.w3.org/check?uri=referer" target="_blank"><img style="vertical-align:middle;" src="images/w3c-xhtml.gif" width="80" height="15" alt="Valid XHTML 1.0 Transitional" title="Valid XHTML 1.0 Transitional" /></a> &nbsp; <a href="http://jigsaw.w3.org/css-validator/validator?uri='.$script_domain.'/'.$script_path.''.$theme.'style.css"  target="_blank"><img style="vertical-align:middle;" src="images/w3c-css.gif" width="80" height="15" alt="Valid CSS!" title="Valid CSS!" /></a></td>
	</tr>
	</table>
	</td></tr></table>';
 }
else
 {
  if ( ( $_GET [ "archive" ] ) || ( $_GET [ "archive_save" ] ) )
   {
    echo '
	  <table border="0" width="100%" cellspacing="0" cellpadding="0">
	  <tr><td><img src="images/pixel.gif" width="2" height="5" alt="" /></td></tr>
	  <tr>
	    <td height="26" align="center" valign="middle">Copyright &copy; '.$last_edit.' <a href="http://www.php-web-statistik.de" target="_blank">PHP Web Stat</a> &nbsp;<b>&middot;</b>&nbsp; '.$lang_footer[1].' '.timer_stop($timer_start).' '.$lang_footer[2].'.</td>
	    <td width="240" align="center" valign="middle"><a href="http://validator.w3.org/check?uri=referer" target="_blank"><img style="vertical-align:middle;" src="images/w3c-xhtml.gif" width="80" height="15" alt="Valid XHTML 1.0 Transitional" title="Valid XHTML 1.0 Transitional" /></a> &nbsp; <a href="http://jigsaw.w3.org/css-validator/validator?uri='.$script_domain.'/'.$script_path.''.$theme.'style.css"  target="_blank"><img style="vertical-align:middle;" src="images/w3c-css.gif" width="80" height="15" alt="Valid CSS!" title="Valid CSS!" /></a></td>
	  </tr>
	  </table>
	  </td></tr></table>';
   }
  else
   {
	  echo '
	  <table border="0" width="100%" cellspacing="0" cellpadding="0">
	  <tr><td><img src="images/pixel.gif" width="2" height="5" alt="" /></td></tr>
	  <tr>
	    <td width="140" align="center" valign="middle">
	      <table border="0" cellspacing="1" cellpadding="0" style="background:#666666;">
	      <tr><td height="13" valign="middle" style="padding-right:1px; padding-left:1px; background:#FFFFFF;"><iframe src="func/func_create_index.php" width="76" height="11" name="make_index" scrolling="no" marginheight="0" marginwidth="0" frameborder="0"></iframe></td></tr>
	      </table>
	    </td>
	    <td height="26" align="center" valign="middle">Copyright &copy; '.$last_edit.' <a href="http://www.php-web-statistik.de" target="_blank">PHP Web Stat</a> &nbsp;<b>&middot;</b>&nbsp; '.$lang_footer[1].' '.timer_stop($timer_start).' '.$lang_footer[2].'.</td>
	    <td width="238" align="center" valign="middle"><a href="http://validator.w3.org/check?uri=referer" target="_blank"><img style="vertical-align:middle;" src="images/w3c-xhtml.gif" width="80" height="15" alt="Valid XHTML 1.0 Transitional" title="Valid XHTML 1.0 Transitional" /></a> &nbsp; <a href="http://jigsaw.w3.org/css-validator/validator?uri='.$script_domain.'/'.$script_path.''.$theme.'style.css"  target="_blank"><img style="vertical-align:middle;" src="images/w3c-css.gif" width="80" height="15" alt="Valid CSS!" title="Valid CSS!" /></a></td>
	  </tr>
	  </table>
	  </td></tr></table>';
	 }
 }
################################################################################
### print ###
if ( $_GET [ "print" ] == 1 )
 {
 	echo <<<CSS
  <style type="text/css">
    @media print {
      #groundtable { border: none; }
      #content     { border: none; }
      #print       { border-bottom: 2px solid black; }
      .changetab   { display: block; }
      .page-break  { page-break-before: always; }
    }
  </style>

CSS;
  echo '<script type="text/javascript"> window.onload = window.print; window.print();</script>';
 }
//------------------------------------------------------------------------------
include ( "func/html_footer.php" ); // include html footer
//------------------------------------------------------------------------------
// kill all vars
unset ( $visitor               );
unset ( $visitor_hour          );
unset ( $visitor_day           );
unset ( $visitor_weekday       );
unset ( $visitor_month         );
unset ( $visitor_year          );
unset ( $browser               );
unset ( $operating_system      );
unset ( $resolution            );
unset ( $color_depth           );
unset ( $javascript_status     );
unset ( $site_name             );
unset ( $referer               );
unset ( $country               );
unset ( $country_full          );
unset ( $searchengines_archive );
unset ( $searchwords_archive   );
unset ( $entrysite             );
//------------------------------------------------------------------------------
?>