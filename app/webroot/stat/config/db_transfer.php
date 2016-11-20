<?php @session_start(); if ( $_SESSION [ "hidden_func" ] != md5_file ( "config.php" ) ) { $error_path = "../"; include ( "../func/func_error.php" ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.9.x                                                    #
# File-Release-Date:  15/10/25                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2015 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
include ( "config.php" ); // include path to style
//------------------------------------------------------------------------------
$strLanguageFile = "";
if ( isset ( $_GET [ "lang" ] ) || isset ( $_POST [ "lang" ] ) )
 {
  switch ( ( isset ( $_POST [ "lang" ] ) ? $_POST [ "lang" ] : $_GET [ "lang" ] ) )
   {
    case "de":    $strLanguageFile = "../language/german_setup.php";     $lang = "de";    break;
    case "en":    $strLanguageFile = "../language/english_setup.php";    $lang = "en";    break;
    case "nl":    $strLanguageFile = "../language/dutch_setup.php";      $lang = "nl";    break;
    case "it":    $strLanguageFile = "../language/italian_setup.php";    $lang = "it";    break;
    case "es":    $strLanguageFile = "../language/spanish_setup.php";    $lang = "es";    break;
    case "es-ct": $strLanguageFile = "../language/catalan_setup.php";    $lang = "es-ct"; break;
    case "fa":    $strLanguageFile = "../language/farsi_setup.php";      $lang = "fa";    break;
    case "dk":    $strLanguageFile = "../language/danish_setup.php";     $lang = "dk";    break;
    case "fr":    $strLanguageFile = "../language/french_setup.php";     $lang = "fr";    break;
    case "tr":    $strLanguageFile = "../language/turkish_setup.php";    $lang = "tr";    break;
    case "hu":    $strLanguageFile = "../language/hungarian_setup.php";  $lang = "hu";    break;
    case "pt":    $strLanguageFile = "../language/portuguese_setup.php"; $lang = "pt";    break;
    case "he":    $strLanguageFile = "../language/hebrew_setup.php";     $lang = "he";    break;
    case "ru":    $strLanguageFile = "../language/russian_setup.php";    $lang = "ru";    break;
    case "rs":    $strLanguageFile = "../language/serbian_setup.php";    $lang = "rs";    break;
    case "fi":    $strLanguageFile = "../language/finnish_setup.php";    $lang = "fi";    break;
    default: $strLanguageFile = "../language/german_setup.php"; $lang = "de"; // include language vars from config file
   }
 }
//-------------------------------
if ( file_exists ( $strLanguageFile ) )
 {
  include ( $strLanguageFile );
 }
else
 {
  include ( "../language/german_setup.php" ); // include language vars
  $lang = "de";
 }
//------------------------------------------------------------------------------
##### !!! never change this value !!! #####
$transfer_version = "1.0";
//------------------------------------------------------------------------------
ob_start();
include ( "../func/html_header.php" ); // include html header
//------------------------------------------------------------------------------
function db_query ( $query, $switch, $cancel )
 {
  //--------------------------
  include ( "config_db.php" );
  //------------------------------
  $db_entries      = array ();
  $db_connection   = 0;
  $db_counter      = 0;
  $db_number_rows  = 0;
  $db_query_result = 0;
  $db_temp         = 0;
  $db_temp_counter = 0;
  $db_error        = 0;
  $mysqli          = 0; // set extension disabled
  //------------------------------
  if ( function_exists ( "mysqli_connect" ) ) // check for extension enabled
   {
    $mysqli = 1;
   }
  //--------------------------
  if ( $mysqli == 1 )
   {
    //--------------------------
    $db_connection = mysqli_connect ( $db_host , $db_user , $db_password , $db_name );
    //--------------------------
    if ( !$db_connection )
     {
      if ( $cancel == 1 ) { echo '<script language="JavaScript"> location.replace(\''.$_SERVER ["PHP_SELF"].'\'); </script>'; }
      else { $db_error = mysqli_error(); die ( $db_error ); }
     }
    //--------------------------
    if ( mysqli_connect_errno ( $db_connection ) )
     {
     	if ( $cancel == 1 ) { echo '<meta http-equiv="refresh" content="5; URL='.$_SERVER ["PHP_SELF"].'\">'; }
   	  else { $db_error = mysqli_error(); die ( $db_error ); }
     }
    //--------------------------
    $query_result = mysqli_query ( $db_connection , $query );
    //--------------------------
    if ( !$query_result ) { $db_error = mysqli_error(); die ( $db_error ); }
    //--------------------------
    if  ( $switch == 1 )
     {
      $db_number_rows = mysqli_num_rows ( $query_result );
      while ( $db_temp = mysqli_fetch_row ( $query_result ) )
       {
        for ( $db_temp_counter = 0 ; $db_temp_counter <= count ( $db_temp ) ; $db_temp_counter++ )
         {
          $db_entries [ $db_counter ] [ $db_temp_counter ] = $db_temp[ $db_temp_counter ];
         }
        $db_counter++;
       }
     }
    //--------------------------
    mysqli_close( $db_connection );
    return $db_entries;
    //--------------------------
   }
  else
   {
    //--------------------------
    $db_connection = mysql_pconnect ( $db_host , $db_user , $db_password );
    //--------------------------
    if ( !$db_connection )
     {
      if ( $cancel == 1 ) { echo '<script language="JavaScript"> location.replace(\''.$_SERVER ["PHP_SELF"].'\'); </script>'; }
      else { $db_error = mysql_error(); die ( $db_error ); }
     }
    //--------------------------
    // This function was used to check for upcoming errors. This is not more needed.
	  // Also this code lead to some access denied notices in some stats.
    // if ( !mysql_select_db ( $db_name , $db_connection ) ) { $db_error = mysql_error(); die ( $db_error ); }
    //--------------------------
    $query_result = mysql_query ( $query , $db_connection );
    //--------------------------
    if ( !$query_result ) { $db_error = mysql_error(); die ( $db_error ); }
    //--------------------------
    if  ( $switch == 1 )
     {
      $db_number_rows = mysql_num_rows ( $query_result );
      while ( $db_temp = mysql_fetch_row ( $query_result ) )
       {
        for ( $db_temp_counter = 0 ; $db_temp_counter <= count ( $db_temp ) ; $db_temp_counter++ )
         {
          $db_entries [ $db_counter ] [ $db_temp_counter ] = $db_temp[ $db_temp_counter ];
         }
        $db_counter++;
       }
     }
    //--------------------------
    mysql_close( $db_connection );
    return $db_entries;
   }
  //--------------------------
 }
//------------------------------------------------------------------------------
if ( ( $_GET [ "action" ] == "info" ) || ( !$_GET [ "action" ] ) )
 {
  echo '
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#808080"><tr><td align="center" valign="middle">
  <table width="440" height="260" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000000; background:#EBE8D8; font-size:11px; font-family:Arial;">
  <tr>
    <td colspan="2" height="60" style="background-image: url(\'../images/bg_system.gif\'); text-align:right; vertical-align:top; padding:10px 20px 0px 0px; color:#436783; font-family:Arial Black; font-size:13px;">Database Creator</td>
  </tr>
  <tr>
    <td colspan="2" height="150" align="left" valign="top" style="padding:15px 20px 0px 20px; border-top:1px solid #737373; color:#000000;">'.$lang_db_tables_1[1].'<br><br>'.$lang_db_tables_1[2].'</td>
  </tr>
  <tr>
    <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; color:#000000;">Database Creator v'.$transfer_version.'</td>
    <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; text-align:right;"><input type="button" onclick="location.href=\'db_transfer.php?action=create_tables_wait&lang='.$lang.'\'" value="'.$lang_db_tables[3].'"> <input type="button" onclick="window.close();" value="'.$lang_db_tables[2].'"></td>
  </tr>
  </table>
  </td></tr></table>
  ';
  include ( "../func/html_footer.php" ); // include html footer
  $output_buffer = ob_get_clean();
  echo ( $output_buffer );
  exit;
 }
//------------------------------------------------------------------------------
if ( $_GET [ "action" ] == "create_tables_wait" )
 {
  echo '
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#808080"><tr><td align="center" valign="middle">
  <table width="440" height="260" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000000; background:#EBE8D8; font-size:11px; font-family:Arial;">
  <tr>
    <td height="60" style="background-image: url(\'../images/bg_system.gif\'); text-align:right; vertical-align:top; padding:10px 20px 0px 0px; color:#436783; font-family:Arial Black; font-size:13px;">Database Creator</td>
  </tr>
  <tr>
    <td height="150" align="left" valign="top" style="padding:15px 20px 0px 20px; border-top:1px solid #737373; color:#000000;">'.$lang_db_tables_2[1].'<br><br><table width="100%" height="16" border="0" cellspacing="0" cellpadding="0" style="background-image: url(\'../images/progress_bar.gif\');"><tr><td align="center" style="font-size:11px; font-family:Arial;">&nbsp;</td></tr></table><br></td>
  </tr>
  <tr>
    <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; color:#000000;">Database Creator v'.$transfer_version.'</td>
  </tr>
  </table>
  </td></tr></table>
  <meta http-equiv="refresh" content="4; URL=db_transfer.php?action=create_tables&lang='.$lang.'">
  ';
  include ( "../func/html_footer.php" ); // include html footer
  $output_buffer = ob_get_clean();
  echo ( $output_buffer );
  exit;
 }
//------------------------------------------------------------------------------
if ( $_GET [ "action" ] == "create_tables" )
 {
 	//--------------------------
  include ( "config_db.php" );
  //--------------------------
  echo '
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#808080"><tr><td align="center" valign="middle">
  <table width="440" height="260" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000000; background:#EBE8D8; font-size:11px; font-family:Arial;">
  <tr>
    <td colspan="2" height="60" style="background-image: url(\'../images/bg_system.gif\'); text-align:right; vertical-align:top; padding:10px 20px 0px 0px; color:#436783; font-family:Arial Black; font-size:13px;">Database Creator</td>
  </tr>
  <tr>
    <td colspan="2" height="150" align="left" valign="top" style="padding:15px 20px 0px 20px; border-top:1px solid #737373; color:#000000;">
    <b>'.$lang_db_tables_2[2].'</b><br><br>';
    //-------------------------------------------------------------------
    $engine = "ENGINE = MYISAM";
    //-------------------------------------------------------------------
    $query  = "DROP TABLE IF EXISTS ".$db_prefix."_main";
    $result = db_query ( $query , 0 , 0 );

    $query  = "CREATE TABLE ".$db_prefix."_main ( id INTEGER AUTO_INCREMENT PRIMARY KEY, domain INTEGER, year INTEGER, month INTEGER, week INTEGER, day INTEGER, hour INTEGER, minute INTEGER, timestamp INTEGER, ip_address TEXT, browser INTEGER, operating_system INTEGER, site_name INTEGER, referrer INTEGER, resolution INTEGER, color_depth INTEGER, country_code TEXT )".$engine;
    $result = db_query ( $query , 0 , 0 );

    $query  = "ALTER TABLE ".$db_prefix."_main ADD FULLTEXT ( ip_address )";
    $result = db_query ( $query , 0 , 0 );

    $query  = "ALTER TABLE ".$db_prefix."_main ADD FULLTEXT ( country_code )";
    $result = db_query ( $query , 0 , 0 );

    $query  = "ALTER TABLE ".$db_prefix."_main ADD INDEX ( timestamp )";
    $result = db_query ( $query , 0 , 0 );

    $query  = "ALTER TABLE ".$db_prefix."_main ADD INDEX ( year )";
    $result = db_query ( $query , 0 , 0 );

    $query  = "ALTER TABLE ".$db_prefix."_main ADD INDEX ( month )";
    $result = db_query ( $query , 0 , 0 );

    $query  = "ALTER TABLE ".$db_prefix."_main ADD INDEX ( day )";
    $result = db_query ( $query , 0 , 0 );

    $query  = "ALTER TABLE ".$db_prefix."_main ADD INDEX ( hour )";
    $result = db_query ( $query , 0 , 0 );

    $query  = "ALTER TABLE ".$db_prefix."_main ADD INDEX ( minute )";
    $result = db_query ( $query , 0 , 0 );

    $query  = "ALTER TABLE ".$db_prefix."_main ADD INDEX ( referrer )";
    $result = db_query ( $query , 0 , 0 );
    //-------------------------------------------------------------------
    $query  = "DROP TABLE IF EXISTS ".$db_prefix."_domain";
    $result = db_query ( $query , 0 , 0 );

    $query = "CREATE TABLE ".$db_prefix."_domain ( id INTEGER AUTO_INCREMENT PRIMARY KEY, domain TEXT )".$engine;
    $result = db_query ( $query , 0 , 0 );


    $query  = "DROP TABLE IF EXISTS ".$db_prefix."_browser";
    $result = db_query ( $query , 0 , 0 );

    $query = "CREATE TABLE ".$db_prefix."_browser ( id  INTEGER AUTO_INCREMENT PRIMARY KEY, browser TEXT )".$engine;
    $result = db_query ( $query , 0 , 0 );

    $query = "INSERT INTO ".$db_prefix."_browser VALUES ('1', 'unknown')";
    $result = db_query ( $query , 0 , 0 );


    $query  = "DROP TABLE IF EXISTS ".$db_prefix."_operating_system";
    $result = db_query ( $query , 0 , 0 );

    $query = "CREATE TABLE ".$db_prefix."_operating_system ( id  INTEGER AUTO_INCREMENT PRIMARY KEY, operating_system TEXT )".$engine;
    $result = db_query ( $query , 0 , 0 );

    $query = "INSERT INTO ".$db_prefix."_operating_system VALUES ('1', 'unknown')";
    $result = db_query ( $query , 0 , 0 );


    $query  = "DROP TABLE IF EXISTS ".$db_prefix."_referrer";
    $result = db_query ( $query , 0 , 0 );

    $query = "CREATE TABLE ".$db_prefix."_referrer ( id  INTEGER AUTO_INCREMENT PRIMARY KEY, referrer TEXT )".$engine;
    $result = db_query ( $query , 0 , 0 );

    $query = "INSERT INTO ".$db_prefix."_referrer VALUES ('1', '---')";
    $result = db_query ( $query , 0 , 0 );


    $query  = "DROP TABLE IF EXISTS ".$db_prefix."_resolution";
    $result = db_query ( $query , 0 , 0 );

    $query = "CREATE TABLE ".$db_prefix."_resolution ( id  INTEGER AUTO_INCREMENT PRIMARY KEY, resolution TEXT )".$engine;
    $result = db_query ( $query , 0 , 0 );

    $query = "INSERT INTO ".$db_prefix."_resolution VALUES ('1', 'unknown')";
    $result = db_query ( $query , 0 , 0 );


    $query  = "DROP TABLE IF EXISTS ".$db_prefix."_site_name";
    $result = db_query ( $query , 0 , 0 );

    $query = "CREATE TABLE ".$db_prefix."_site_name ( id INTEGER AUTO_INCREMENT PRIMARY KEY, site_name TEXT )".$engine;
    $result = db_query ( $query , 0 , 0 );

    $query = "INSERT INTO ".$db_prefix."_site_name VALUES ('1', '---')";
    $result = db_query ( $query , 0 , 0 );
    //-------------------------------------------------------------------
    unset ( $query  );
    unset ( $result );
    //-------------------------------------------------------------------
    echo '
    '.$lang_db_tables_2[3].' \''.$db_prefix.'_browser\'...OK<br>
    '.$lang_db_tables_2[3].' \''.$db_prefix.'_domain\'...OK<br>
    '.$lang_db_tables_2[3].' \''.$db_prefix.'_main\'...OK<br>
    '.$lang_db_tables_2[3].' \''.$db_prefix.'_operating_system\'...OK<br>
    '.$lang_db_tables_2[3].' \''.$db_prefix.'_referrer\'...OK<br>
    '.$lang_db_tables_2[3].' \''.$db_prefix.'_resolution\'...OK<br>
    '.$lang_db_tables_2[3].' \''.$db_prefix.'_site_name\'...OK<br>
    </td>
  </tr>
  <tr>
    <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; color:#000000;">Database Creator v'.$transfer_version.'</td>
    <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; text-align:right;"><input type="button" onclick="location.href=\'db_transfer.php?action=check_logfile&lang='.$lang.'\'" value="'.$lang_db_tables[3].'"></td>
  </tr>
  </table>
  </td></tr></table>
  ';
  include ( "../func/html_footer.php" ); // include html footer
  $output_buffer = ob_get_clean();
  echo ( $output_buffer );
  exit;
 }
//------------------------------------------------------------------------------
// check logfile
if ( $_GET [ "action" ] == "check_logfile" )
 {
  $logfile       = fopen   ( "../log/logdb_backup.dta" , "r" );
  $logfile_entry = fgetcsv ( $logfile , 60000, "|" );
  if ( trim ( $logfile_entry [ 0 ] ) != "" )
   {
    echo '<meta http-equiv="refresh" content="0; URL=db_transfer.php?action=logfile_result_1&lang='.$lang.'">';
   }
  else
   {
    echo '<meta http-equiv="refresh" content="0; URL=db_transfer.php?action=logfile_result_0&lang='.$lang.'">';
   }
  fclose ( $logfile );
  unset  ( $logfile       );
  unset  ( $logfile_entry );
  include ( "../func/html_footer.php" ); // include html footer
  $output_buffer = ob_get_clean();
  echo ( $output_buffer );
  exit;
 }
//------------------------------------------------------------------------------
// are no data in logdb_backup
if ( $_GET [ "action" ] == "logfile_result_0" )
 {
  echo '
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#808080"><tr><td align="center" valign="middle">
  <table width="440" height="260" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000000; background:#EBE8D8; font-size:11px; font-family:Arial;">
  <tr>
    <td colspan="2" height="60" style="background-image: url(\'../images/bg_system.gif\'); text-align:right; vertical-align:top; padding:10px 20px 0px 0px; color:#436783; font-family:Arial Black; font-size:13px;">Database Creator</td>
  </tr>
  <tr>
    <td colspan="2" height="150" align="left" valign="top" style="padding:15px 20px 0px 20px; border-top:1px solid #737373; color:#000000;">
    '.$lang_db_tables_3[1].'<br><br>
    <big><b>'.$lang_db_tables_7[2].'</b></big>
    </td>
  </tr>
  <tr>
    <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; color:#000000;">Database Creator v'.$transfer_version.'</td>
    <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; text-align:right;"><input type="button" onclick="window.close();" value="'.$lang_db_tables[6].'"></td>
  </tr>
  </table>
  </td></tr></table>
  ';
  include ( "../func/html_footer.php" ); // include html footer
  $output_buffer = ob_get_clean();
  echo ( $output_buffer );
  exit;
 }
//------------------------------------------------------------------------------
// if exists data in logdb_backup
if ( $_GET [ "action" ] == "logfile_result_1" )
 {
  echo '
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#808080"><tr><td align="center" valign="middle">
  <table width="440" height="260" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000000; background:#EBE8D8; font-size:11px; font-family:Arial;">
  <tr>
    <td colspan="2" height="60" style="background-image: url(\'../images/bg_system.gif\'); text-align:right; vertical-align:top; padding:10px 20px 0px 0px; color:#436783; font-family:Arial Black; font-size:13px;">Database Creator</td>
  </tr>
  <tr>
    <td colspan="2" height="150" align="left" valign="top" style="padding:15px 20px 0px 20px; border-top:1px solid #737373; color:#000000;">
    '.$lang_db_tables_3[2].'<br><br>
    '.$lang_db_tables_3[3].'<br><br>
    '.$lang_db_tables_3[4].'
    </td>
  </tr>
  <tr>
    <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; color:#000000;">Database Creator v'.$transfer_version.'</td>
    <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; text-align:right;"><input type="button" onclick="location.href=\'db_transfer.php?action=pattern_transfer_wait&lang='.$lang.'\'" value="'.$lang_db_tables[3].'"> <input type="button" onclick="location.href=\'db_transfer.php?action=finished\'" value="'.$lang_db_tables[4].'"></td>
  </tr>
  </table>
  </td></tr></table>
  ';
  include ( "../func/html_footer.php" ); // include html footer
  $output_buffer = ob_get_clean();
  echo ( $output_buffer );
  exit;
 }
//------------------------------------------------------------------------------
if ( $_GET [ "action" ] == "pattern_transfer_wait" )
 {
  echo '
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#808080"><tr><td align="center" valign="middle">
  <table width="440" height="260" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000000; background:#EBE8D8; font-size:11px; font-family:Arial;">
  <tr>
    <td height="60" style="background-image: url(\'../images/bg_system.gif\'); text-align:right; vertical-align:top; padding:10px 20px 0px 0px; color:#436783; font-family:Arial Black; font-size:13px;">Database Creator</td>
  </tr>
  <tr>
    <td height="150" align="left" valign="top" style="padding:15px 20px 0px 20px; border-top:1px solid #737373; color:#000000;">'.$lang_db_tables_4[1].'<br><br><table width="100%" height="16" border="0" cellspacing="0" cellpadding="0" style="background-image: url(\'../images/progress_bar.gif\');"><tr><td align="center" style="font-size:11px; font-family:Arial;">&nbsp;</td></tr></table><br></td>
  </tr>
  <tr>
    <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; color:#000000;">Database Creator v'.$transfer_version.'</td>
  </tr>
  </table>
  </td></tr></table>
  <meta http-equiv="refresh" content="0; URL=db_transfer.php?action=pattern_transfer&lang='.$lang.'">
  ';
  include ( "../func/html_footer.php" ); // include html footer
  $output_buffer = ob_get_clean();
  echo ( $output_buffer );
  exit;
 }
//------------------------------------------------------------------------------
if ( $_GET [ "action" ] == "pattern_transfer" )
 {
  //--------------------------
  include ( "config_db.php" );
  //--------------------------
  echo '
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#808080"><tr><td align="center" valign="middle">
  <table width="440" height="260" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000000; background:#EBE8D8; font-size:11px; font-family:Arial;">
  <tr>
    <td height="60" style="background-image: url(\'../images/bg_system.gif\'); text-align:right; vertical-align:top; padding:10px 20px 0px 0px; color:#436783; font-family:Arial Black; font-size:13px;">Database Creator</td>
  </tr>
  <tr>
    <td height="150" align="left" valign="top" style="padding:15px 20px 0px 20px; border-top:1px solid #737373; color:#000000;">'.$lang_db_tables_4[1].'<br><br><table width="100%" height="16" border="0" cellspacing="0" cellpadding="0" style="background-image: url(\'../images/progress_bar.gif\');"><tr><td align="center" style="font-size:11px; font-family:Arial;">&nbsp;</td></tr></table><br></td>
  </tr>
  <tr>
    <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; color:#000000;">Database Creator v'.$transfer_version.'</td>';
  //--------------------------
  for ( $x = 0 ; $x <= 4 ; $x++ )
  {
  if ( $x == 0 ) { $pattern = "../log/pattern_browser.dta";          $table = "".$db_prefix."_browser";          }
  if ( $x == 1 ) { $pattern = "../log/pattern_operating_system.dta"; $table = "".$db_prefix."_operating_system"; }
  if ( $x == 2 ) { $pattern = "../log/pattern_referer.dta";          $table = "".$db_prefix."_referrer";         }
  if ( $x == 3 ) { $pattern = "../log/pattern_resolution.dta";       $table = "".$db_prefix."_resolution";       }
  if ( $x == 4 ) { $pattern = "../log/pattern_site_name.dta";        $table = "".$db_prefix."_site_name";        }

  $temp_pattern = array ( );
  $logfile = fopen ( $pattern , "r" );
  $entry = 1;
  $key   = 1;
  while ( !FEOF ( $logfile ) )
   {
    $logfile_entry = fgetcsv ( $logfile , 60000, "|" );
    if ( trim ( $logfile_entry [ 0 ] ) != "" )
     {
      if ( ( !array_key_exists ( $logfile_entry [ 1 ] , $temp_pattern ) ) && ( $logfile_entry [ 1 ] != "" ) )
       {
     	  if ( $key == "" ) { $logfile_entry [ 0 ] = $entry.$logfile_entry [ 0 ]; }
     	  $temp_pattern [ $logfile_entry [ 1 ] ] = 1;
        $insert_data = "INSERT INTO ".$table." VALUES (NULL,'".mysql_escape_string ( $logfile_entry[0] )."')";
        $result = db_query ( $insert_data , 0 , 0 );
       }
      $entry = $logfile_entry [ 0 ];
      $key   = $logfile_entry [ 1 ];
     }
   }
  fclose($logfile);

  unset ( $logfile       );
  unset ( $logfile_entry );
  unset ( $insert_data   );
  unset ( $temp_pattern  );
  }
  //--------------------------
  echo'
    </tr>
  </table>
  </td></tr></table>
  <meta http-equiv="refresh" content="0; URL=db_transfer.php?action=filling_1&lang='.$lang.'">
  ';
  include ( "../func/html_footer.php" ); // include html footer
  $output_buffer = ob_get_clean();
  echo ( $output_buffer );
  exit;
 }
//------------------------------------------------------------------------------
if ( $_GET [ "action" ] == "filling_1" )
 {
 	//--------------------------
  include ( "config_db.php" );
  //--------------------------
  if ( $_GET [ "number" ] )
   {
    $number    = strip_tags ( $_GET [ "number" ] );

    $query     = "SELECT MAX(timestamp) FROM ".$db_prefix."_main";
    $result    = db_query ( $query , 1 , 0 );
    $timestamp = $result[0][0];

    $count     = strip_tags ( $_GET [ "count" ] );
   }
  else
   {
    //-----------------------------
    $count = 0;
    $logfile_temp  = fopen ( "../log/logdb_backup.dta" , "r" );
    while ( !FEOF ( $logfile_temp ) )
     {
      $logfile_entry_temp = fgetcsv ( $logfile_temp , 60000 , "|" );
      $count++;
     }
    fclose( $logfile_temp       );
    unset ( $logfile_temp       );
    unset ( $logfile_entry_temp );
    //-----------------------------
    if ( $count <= 3 )
     {
      echo '
      <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#808080"><tr><td align="center" valign="middle">
      <table width="440" height="260" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000000; background:#EBE8D8; font-size:11px; font-family:Arial;">
      <tr>
        <td colspan="2" height="60" style="background-image: url(\'../images/bg_system.gif\'); text-align:right; vertical-align:top; padding:10px 20px 0px 0px; color:#436783; font-family:Arial Black; font-size:13px;">Database Creator</td>
      </tr>
      <tr>
        <td colspan="2" height="150" align="left" valign="top" style="padding:15px 20px 20px 20px; border-top:1px solid #737373; color:#000000;">
        '.$lang_db_tables_4[2].'
        </td>
      </tr>
      <tr>
        <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; color:#000000;">Database Creator v'.$transfer_version.'</td>
        <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; text-align:right;"><input type="button" onclick="window.close();" value="'.$lang_db_tables[4].'"></td>
      </tr>
      </table>
      </td></tr></table>
      ';
      include ( "../func/html_footer.php" ); // include html footer
     }
    else
     {
      // choose entries to write
      echo '
      <form style="margin:0px; text-align:center;" method="get" action="db_transfer.php">
      <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#808080"><tr><td align="center" valign="middle">
      <table width="440" height="260" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000000; background:#EBE8D8; font-size:11px; font-family:Arial;">
      <tr>
        <td colspan="2" height="60" style="background-image: url(\'../images/bg_system.gif\'); text-align:right; vertical-align:top; padding:10px 20px 0px 0px; color:#436783; font-family:Arial Black; font-size:13px;">Database Creator</td>
      </tr>
      <tr>
        <td colspan="2" height="150" align="left" valign="top" style="padding:15px 20px 20px 20px; border-top:1px solid #737373; color:#000000;">
        <b>'.$lang_db_tables_4[2].'</b><br><br>
        '.$lang_db_tables_4[3].'<br>
        '.$lang_db_tables_4[4].'<br>
        <center>
        <select name="number" size="1">
          <option value="500">500</option>
          <option value="1000">1.000</option>
          <option value="2000">2.000</option>
          <option value="4000" selected>4.000</option>
          <option value="8000">8.000</option>
          <option value="16000">16.000</option>
          <option value="32000">32.000</option>
        </select>
        </center>
        </td>
      </tr>
      <tr>
        <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; color:#000000;">Database Creator v'.$transfer_version.'</td>
        <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; text-align:right;"><input type="hidden" name="action" value="filling_2"><input type="hidden" name="lang" value="'.$lang.'"><input type="hidden" name="timestamp" value="0"><input type="hidden" name="count" value="'.$count.'"><input type="submit" style="cursor:pointer;" value="'.$lang_db_tables[3].'"></td>
      </tr>
      </table>
      </td></tr></table>
      </form>
      ';
      include ( "../func/html_footer.php" ); // include html footer
     }
    $output_buffer = ob_get_clean();
    echo ( $output_buffer );
    exit;
   }
  //-----------------------------
  // filling table main
  echo '
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#808080"><tr><td align="center" valign="middle">
  <table width="440" height="260" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000000; background:#EBE8D8; font-size:11px; font-family:Arial;">
  <tr>
    <td height="60" style="background-image: url(\'../images/bg_system.gif\'); text-align:right; vertical-align:top; padding:10px 20px 0px 0px; color:#436783; font-family:Arial Black; font-size:13px;">Database Creator</td>
  </tr>
  <tr>
    <td height="150" align="left" valign="top" style="padding:15px 20px 20px 20px; border-top:1px solid #737373; color:#000000;">
    '.$lang_db_tables_5[1].'<br><br>
    ';
  //-----------------------------
  include ( "../log/cache_memory_address.php" );
  $logfile  = fopen ( "../log/logdb_backup.dta" , "r" );
  fseek ( $logfile , $cache_memory_address );
  $counter  = 0;
  $new      = 0;
  while ( !FEOF ( $logfile ) )
   {
    $logfile_entry = fgetcsv ( $logfile , 60000 , "|" );

    if ( $logfile_entry [ 0 ] > $timestamp )
     {
      $counter++;

      if ( $counter <= $number )
       {
        $timestamp_new = $logfile_entry [ 0 ];
        $last_memory_address = ftell ( $logfile );
        $new = 1;

        $logfile_entry [ 2 ] = $logfile_entry [ 2 ] + 1; // browser + 1          ( line 187 )
        $logfile_entry [ 3 ] = $logfile_entry [ 3 ] + 1; // operating system + 1 ( line 197 )
        $logfile_entry [ 4 ] = $logfile_entry [ 4 ] + 1; // site_name + 1        ( line 227 )
        $logfile_entry [ 5 ] = $logfile_entry [ 5 ] + 1; // referrer + 1         ( line 207 )
        $logfile_entry [ 6 ] = $logfile_entry [ 6 ] + 1; // resolution + 1       ( line 217 )

        if ( trim ( $logfile_entry [ 2 ] ) == "" ) { $logfile_entry [ 2 ] = 1;         } // browser
        if ( trim ( $logfile_entry [ 3 ] ) == "" ) { $logfile_entry [ 3 ] = 1;         } // operating system
        if ( trim ( $logfile_entry [ 4 ] ) == "" ) { $logfile_entry [ 4 ] = 1;         } // site name
        if ( trim ( $logfile_entry [ 5 ] ) == "" ) { $logfile_entry [ 5 ] = 1;         } // referrer
        if ( trim ( $logfile_entry [ 6 ] ) == "" ) { $logfile_entry [ 6 ] = 1;         } // resolution
        if ( trim ( $logfile_entry [ 7 ] ) == "" ) { $logfile_entry [ 7 ] = 0;         } // js color
        if ( trim ( $logfile_entry [ 8 ] ) == "" ) { $logfile_entry [ 8 ] = "unknown"; } // country

        if ( trim ( $logfile_entry [ 1 ] ) != "" )
         {
          $query = "INSERT INTO ".$db_prefix."_main VALUES (NULL,1,".date("Y",$logfile_entry[0]).",".date("m",$logfile_entry[0]).",".date("W",$logfile_entry[0]).",".date("d",$logfile_entry[0]).",".date("H",$logfile_entry[0]).",".date("i",$logfile_entry[0]).",".$logfile_entry[0].",'".$logfile_entry[1]."',".$logfile_entry[2].",".$logfile_entry[3].",".$logfile_entry[4].",".$logfile_entry[5].",".$logfile_entry[6].",".$logfile_entry[7].",'".$logfile_entry[8]."')";
          $pws = db_query ( $query , 0 , 0 );
         }
       }
     }
   }
  fclose( $logfile       );
  unset ( $logfile       );
  unset ( $logfile_entry );
  //-----------------------------
  // save the last memory address
  $cache_time_stamp_file = fopen ( "../log/cache_memory_address.php" , "w+" );
   flock  ( $cache_time_stamp_file , 2 );
    fwrite ( $cache_time_stamp_file , "<?php \$cache_memory_address = \"".$last_memory_address."\";?>" ); // save the last read physical address of the logfile
   flock  ( $cache_time_stamp_file , 3 );
  fclose ( $cache_time_stamp_file );
  unset  ( $cache_time_stamp_file );
  //-----------------------------
  // transfer finished
  if ( $new == 0 )
   {
    echo '<meta http-equiv="refresh" content="0; URL=db_transfer.php?action=optimize_info&lang='.$lang.'">';
   }
  else
   {
    //-----------------------------
    $query = "SELECT COUNT(*) FROM ".$db_prefix."_main";
    $result = db_query ( $query , 1 , 0 );
    $entries = $result[0][0];
    //-----------------------------
    // show progress bar
    $percent = (int) round ( ( $entries/$count ) * 100 );
      echo '
      <div style="position: relative; margin: 0px auto; width: 398px; height: 16px; border: none;">';
      $percent_bar = (int) round ( ( $percent * 3.98 ) - 398 );
      echo '<div style="position: absolute; top: 0px; left: 0px;"><img src="../images/progress_bar_fg.gif" border="0" width="398" height="16" alt="" style="background: url(../images/progress_bar_bg.gif) top left no-repeat; padding: 0px; margin: 0px; background-position: '.$percent_bar.'px 0;"></div>
      <div style="position: absolute; top: 1px; left: 47%; font-size:12px; font-family:Arial;">'.$percent.' %</div>
      </div><br>
      <center><b><span style="font-size:14px">'.$entries.' '.$lang_db_tables_5[2].'</span></b><br><br>'.$lang_db_tables_5[3].': '.$count.'</center>
      </td>
    </tr>
    <tr>
      <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; color:#000000;">Database Creator v'.$transfer_version.'</td>
    </tr>
    </table>
    </td></tr></table>
    <meta http-equiv="refresh" content="1; URL=db_transfer.php?action=filling_1&number='.$number.'&count='.$count.'&timestamp='.$timestamp_new.'&lang='.$lang.'">
    ';
    include ( "../func/html_footer.php" ); // include html footer
   }
  $output_buffer = ob_get_clean();
  echo ( $output_buffer );
  exit;
 }
//-------------------------------------------------------------------------------
if ( $_GET [ "action" ] == "filling_2" )
 {
  echo '
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#808080"><tr><td align="center" valign="middle">
  <table width="440" height="260" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000000; background:#EBE8D8; font-size:11px; font-family:Arial;">
  <tr>
    <td height="60" style="background-image: url(\'../images/bg_system.gif\'); text-align:right; vertical-align:top; padding:10px 20px 0px 0px; color:#436783; font-family:Arial Black; font-size:13px;">Database Creator</td>
  </tr>
  <tr>
    <td height="150" align="left" valign="top" style="padding:15px 20px 20px 20px; border-top:1px solid #737373; color:#000000;">
    '.$lang_db_tables_5[1].'<br><br>
    <div style="position: relative; margin: 0px auto; width: 398px; height: 16px; border: none;">';
    $percent_bar = (int) round ( ( $percent * 3.98 ) - 398 );
    echo '<div style="position: absolute; top: 0px; left: 0px;"><img src="../images/progress_bar_fg.gif" border="0" width="398" height="16" alt="" style="background: url(../images/progress_bar_bg.gif) top left no-repeat; padding: 0px; margin: 0px; background-position: '.$percent_bar.'px 0;"></div>
    <div style="position: absolute; top: 1px; left: 47%; font-size:12px; font-family:Arial;">0 %</div>
    </div><br>
    <center><b><span style="font-size:14px">0 '.$lang_db_tables_5[2].'</span></b><br><br>'.$lang_db_tables_5[3].': '.strip_tags ( $_GET [ "count" ] ).'</center>
    </td>
  </tr>
  <tr>
    <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; color:#000000;">Database Creator v'.$transfer_version.'</td>
  </tr>
  </table>
  </td></tr></table>
  <meta http-equiv="refresh" content="1; URL=db_transfer.php?lang='.$lang.'&action=filling_1&number='.strip_tags ( $_GET [ "number" ] ).'&count='.strip_tags ( $_GET [ "count" ] ).'&timestamp='.strip_tags ( $_GET [ "timestamp_new" ] ).'">
  ';
  // set the memory address to zero
  $cache_timestamp_file = fopen ( "../log/cache_memory_address.php" , "w+" );
   fwrite ( $cache_timestamp_file , "<?php \$cache_memory_address = \"\";?>" ); // php header + footer
  fclose ( $cache_timestamp_file );
  unset  ( $cache_timestamp_file );
  include ( "../func/html_footer.php" ); // include html footer
  $output_buffer = ob_get_clean();
  echo ( $output_buffer );
  exit;
 }
//------------------------------------------------------------------------------
if ( $_GET [ "action" ] == "optimize_info" )
 {
  echo '
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#808080"><tr><td align="center" valign="middle">
  <table width="440" height="260" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000000; background:#EBE8D8; font-size:11px; font-family:Arial;">
  <tr>
    <td height="60" style="background-image: url(\'../images/bg_system.gif\'); text-align:right; vertical-align:top; padding:10px 20px 0px 0px; color:#436783; font-family:Arial Black; font-size:13px;">Database Creator</td>
  </tr>
  <tr>
    <td height="150" align="left" valign="top" style="padding:15px 20px 0px 20px; border-top:1px solid #737373; color:#000000;">'.$lang_db_tables_6[1].'<br><br><table width="100%" height="16" border="0" cellspacing="0" cellpadding="0" style="background-image: url(\'../images/progress_bar.gif\');"><tr><td align="center" style="font-size:11px; font-family:Arial;">&nbsp;</td></tr></table><br>'.$lang_db_tables_6[2].'</td>
  </tr>
  <tr>
    <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; color:#000000;">Database Creator v'.$transfer_version.'</td>
  </tr>
  </table>
  </td></tr></table>
  <meta http-equiv="refresh" content="5; URL=db_transfer.php?action=optimize&lang='.$lang.'">
  ';
  include ( "../func/html_footer.php" ); // include html footer
  $output_buffer = ob_get_clean();
  echo ( $output_buffer );
  exit;
 }
//-------------------------------------------------------------------------------
if ( $_GET [ "action" ] == "optimize" )
 {
 	//--------------------------
  include ( "config_db.php" );
  //--------------------------
  echo '
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#808080"><tr><td align="center" valign="middle">
  <table width="440" height="260" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000000; background:#EBE8D8; font-size:11px; font-family:Arial;">
  <tr>
    <td height="60" style="background-image: url(\'../images/bg_system.gif\'); text-align:right; vertical-align:top; padding:10px 20px 0px 0px; color:#436783; font-family:Arial Black; font-size:13px;">Database Creator</td>
  </tr>
  <tr>
    <td height="150" align="left" valign="top" style="padding:15px 20px 0px 20px; border-top:1px solid #737373; color:#000000;">'.$lang_db_tables_6[1].'<br><br><table width="100%" height="16" border="0" cellspacing="0" cellpadding="0" style="background-image: url(\'../images/progress_bar.gif\');"><tr><td align="center" style="font-size:11px; font-family:Arial;">&nbsp;</td></tr></table><br>'.$lang_db_tables_6[2].'</td>
  </tr>
  <tr>
    <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; color:#000000;">Database Creator v'.$transfer_version.'</td>
  </tr>
  </table>
  </td></tr></table>
  ';
  //-----------------------------
  // optimize db_tables
  $db_query = "OPTIMIZE TABLE ".$db_prefix."_browser , ".$db_prefix."_domain , ".$db_prefix."_main , ".$db_prefix."_operating_system , ".$db_prefix."_referrer , ".$db_prefix."_resolution , ".$db_prefix."_site_name";
  $result = db_query ( $db_query , 0 , 0 );
  //-----------------------------
  echo '
  <meta http-equiv="refresh" content="0; URL=db_transfer.php?action=finished&lang='.$lang.'">
  ';
  include ( "../func/html_footer.php" ); // include html footer
  $output_buffer = ob_get_clean();
  echo ( $output_buffer );
  exit;
 }
//-------------------------------------------------------------------------------
if ( $_GET [ "action" ] == "finished" )
 {
 	echo '
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#808080"><tr><td align="center" valign="middle">
  <table width="440" height="260" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000000; background:#EBE8D8; font-size:11px; font-family:Arial;">
  <tr>
    <td colspan="2" height="60" style="background-image: url(\'../images/bg_system.gif\'); text-align:right; vertical-align:top; padding:10px 20px 0px 0px; color:#436783; font-family:Arial Black; font-size:13px;">Database Creator</td>
  </tr>
  <tr>
    <td colspan="2" height="150" align="center" valign="middle" style="padding:15px 20px 20px 20px; border-top:1px solid #737373; color:#000000;">'.$lang_db_tables_7[1].'<br><br><big><b>'.$lang_db_tables_7[2].'</b></big></td>
  </tr>
  <tr>
    <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; color:#000000;">Database Creator v'.$transfer_version.'</td>
    <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; text-align:right;"><input type="button" onclick="db_transfer_finished();" value="'.$lang_db_tables[5].'"></td>
  </tr>
  </table>
  </td></tr></table>
  ';
  include ( "../func/html_footer.php" ); // include html footer
  // set the memory address to zero
  $cache_timestamp_file = fopen ( "../log/cache_memory_address.php" , "w+" );
   fwrite ( $cache_timestamp_file , "<?php \$cache_memory_address = \"\";?>" ); // php header + footer
  fclose ( $cache_timestamp_file );
  unset  ( $cache_timestamp_file );
  $output_buffer = ob_get_clean();
  echo ( $output_buffer );
  exit;
 }
//------------------------------------------------------------------------------
?>