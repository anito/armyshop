<?php @session_start(); @setcookie('sysinfo');
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
error_reporting(0);
//------------------------------------------------------------------------------
include ( "config/config.php"  );     // include config
//------------------------------------------------------------------------------
if ( $db_active == 1 )
 {
  include ( "config/config_db.php" ); // include db prefix
  include ( "db_connect.php"       ); // include database connectivity
 }
//------------------------------------------------------------------------------
$stat_version = file ( "index.php" ); // include stat version
$sysinfo_vers = "2.4";                // sysinfo version
//------------------------------------------------------------------------------
//check date form
  if ( $language == "language/german.php" ) { $last_log_dateform = "d.m.Y H:i:s"; }
else { $last_log_dateform = "Y/m/d g:i a"; }
//------------------------------------------------------------------------------
$geoip_version = file ( "func/geoip/GeoIPversion.dat" );   // include geoip version
//------------------------------------------------------------------------------
// enabled & disabled variables
$enabled  = "<img src=\"images/sysinfo_on.png\" title=\"enabled\" alt=\"enabled\">";
$disabled = "OFF";
//------------------------------------------------------------------------------
function file_perms ( $file, $octal = false )
 {
  if ( !file_exists ( $file ) ) return false;
  $perms = fileperms ( $file );
  $cut = $octal ? 2 : 3;
  return substr( decoct( $perms), $cut );
 }
//-----------------------------
function folder_perms ( $file, $octal = false )
 {
  if ( !file_exists ( $file ) ) return false;
  $perms = fileperms ( $file );
  $cut = $octal ? 1 : 2;
  return substr ( decoct ( $perms ), $cut );
 }
//-----------------------------
function file_size ( $file )
 {
  if ( !file_exists ( $file ) ) return false;
  return number_format ( ( filesize ( $file ) / 1024 ) , 2 , "," , "." );
 }
//-----------------------------
function file_row_size_small ( $file )
 {
  return count ( file ( $file ) );
 }
//-----------------------------
function file_row_size_big ( $file )
 {
  $counter = trim( `wc --lines < $file` );   // only Unix/Linux server
  if ( $counter != "" ) { return number_format( $counter , 0 , "," , "." ); }
  $counter = 0;
  $logfile = fopen ( $file , "r" );
  if ( $logfile == FALSE ) { return number_format( $counter , 0 , "," , "." ); }
  while ( !FEOF ( $logfile ) )
   {
    $logfile_entry = fgets ( $logfile , 60000 );
    $counter++;
   }
  fclose ( $logfile       );
  unset  ( $logfile       );
  unset  ( $logfile_entry );

  return number_format ( $counter , 0 , "," , "." );
 }
//------------------------------------------------------------------------------
// check script_domain
if ( ( ( $script_domain == "http://localhost" ) && ( $_SERVER ['HTTP_HOST'] == "localhost" ) ) || ( ( substr ( $script_domain , 0 , 11 ) == "http://www." ) && ( substr ( $script_domain , 11 ) == $_SERVER ['HTTP_HOST'] ) ) || ( ( substr ( $script_domain , 0 , 7 ) == "http://" ) && ( substr ( $script_domain , 7 ) == $_SERVER ['HTTP_HOST'] ) ) || ( ( substr ( $script_domain , 0 , 12 ) == "https://www." ) && ( substr ( $script_domain , 12 ) == $_SERVER ['HTTP_HOST'] ) ) || ( ( substr ( $script_domain , 0 , 8 ) == "https://" ) && ( substr ( $script_domain , 8 ) == $_SERVER ['HTTP_HOST'] ) ) )
 { }
else
 {
  $script_domain = "<font color=\"red\">".$script_domain."</font>";
 }
//------------------------------------------------------------------------------
// check script_path
if ( $script_path == substr ( dirname ( $_SERVER ['PHP_SELF'] ) , 1 )."/" )
 { }
else
 {
  $script_path = "<font color=\"red\">".$script_path."</font>";
 }
//------------------------------------------------------------------------------
// check exception_domain
$temp_exception_domain = "";
foreach ( $exception_domain as $value )
 {
  if ( ( $value != "localhost" ) && ( !@fsockopen ( $value , "80" , $errno , $errstr , 5 ) ) )
   {
	  $temp_exception_domain = $temp_exception_domain.'<font color="red">'.$value.'</font><br />';
   }
  else
   {
    $temp_exception_domain = $temp_exception_domain.$value.'<br />';
   }
 }
unset ( $exception_domain );
$exception_domain = $temp_exception_domain;
unset ( $temp_exception_domain );
//------------------------------------------------------------------------------
$temp_url_parameter = "";
foreach ( $url_parameter as $value )
 {
  $temp_url_parameter = $temp_url_parameter."<br />".$value;
 }
$temp_url_parameter = substr ( $temp_url_parameter , 6 , strlen ( $temp_url_parameter ) - 1 );
unset ( $url_parameter );
$url_parameter = $temp_url_parameter;
unset ( $temp_url_parameter );
//------------------------------------------------------------------------------
// check last log entry
if ( $db_active == 1 )
 {
  $query              = "SELECT MAX(timestamp) FROM ".$db_prefix."_main";
  $result             = db_query ( $query , 1 , 0 );
  $last_log_timestamp = $result[0][0];
 }
else
 {
  include ( "log/index_days.php" );
  $max_memory_address = max ( $index_days );

  $logfile = fopen ( "log/logdb_backup.dta" , "r" );
    @fseek ( $logfile , $max_memory_address );
    while ( !FEOF ( $logfile ) )
     {
      $logfile_entry = fgetcsv ( $logfile , 60000 , "|" );
      if ( trim ( $logfile_entry [ 0 ] ) != "" ) { $last_log_timestamp = $logfile_entry [ 0 ]; }
     }
  fclose ( $logfile );

  unset ( $logfile       );
  unset ( $logfile_entry );
 }
//------------------------------------------------------------------------------
include ( "func/html_header.php" ); // include html header
//------------------------------------------------------------------------------
echo "<table id=\"groundtable\" width=\"790\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"-moz-border-radius:0px 0px 0px 0px;\"><tr><td align=\"center\">\n";
################################################################################
### topmenu ###
echo '
<table width="100%" border="0" cellspacing="0" cellpadding="3" style="background-color:#FFFFFF; border:1px solid #000000; font-size:12px; font-family:arial,verdana,helvetica,sans-serif;">
<tr>
  <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="140" height="60" align="center" valign="middle">
      <a href="http://www.php-web-statistik.de" target="_blank"><img src="images/system.gif" width="104" height="50" alt="www.php-web-statistik.de" title="www.php-web-statistik.de" /></a>
    </td>
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="24" colspan="2" valign="middle" align="left" style="padding:0px 0px 0px 20px; font-size:18px; font-family:arial,verdana,sans-serif; color:#0D638A; letter-spacing: 1.0mm;"><b>PHP Web Stat</b></td>
      </tr>
      <tr>
        <td valign="middle" align="left" style="padding:0px 0px 0px 20px; font-size:14px; color:#505050; font-family:arial,verdana,sans-serif; letter-spacing: 1.0mm;"><u><i><b>SysInfo v'.$sysinfo_vers.'</b></i></u></td>
        <td align="right" style="padding:0px 10px 5px 0px;">
        <input type="button" style="padding-left:10px; padding-right:10px; width:auto; overflow:visible; cursor:pointer;" onclick="location.href=\'index.php?action=backtostat\'" value="Stat" />
        <a href="counter.php" rel="floatbox.counter" rev="width:150 height:150" style="text-decoration:none" title="Counter"><input type="button" style="padding-left:10px; padding-right:10px; width:auto; overflow:visible; cursor:pointer;" value="Counter" /></a>
        <a href="config/file_version.php" rel="floatbox.fileversion" rev="width:680 height:530" style="text-decoration:none" title="File Version"><input type="button" style="padding-left:10px; padding-right:10px; width:auto; overflow:visible; cursor:pointer;" value="File Version" /></a>
        <input type="button" style="padding-left:10px; padding-right:10px; width:auto; overflow:visible; cursor:pointer;" onclick="location.href=\'config/admin.php\'" value="Admin-Center" />
        </td>
      </tr>
      </table>
    </td>
  </tr>
  </table>
  </td>
</tr>
</table>
';
################################################################################
### stat info and file check table ###
echo '
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td width="55%" valign="top" style="padding:10px 10px 5px 0px;">
  <!--// stat info //-->
  <table class="stat_table" border="0" width="100%" cellspacing="0" cellpadding="3">
  <tr>
    <td class="stat_header" colspan="2">Stat Info</td>
  </tr>
  <tr>
    <td width="120" align="left">Script Version</td>
    ';
    eval($stat_version[32]);
    eval($stat_version[33]);
    echo '
    <td align="left">'.$version_number.$revision_number.'</td>
  </tr>
  <tr>
    <td align="left">Script Activitiy</td>
    ';
    if ( $script_activity == 1 ) { echo "<td align=\"left\">".$enabled."</td>\n"; } else { echo "<td align=\"left\"><span style=\"background:#F9FBE0; color:#CC0000; text-decoration:blink;\">&nbsp;Maintenance Mode&nbsp;</span></td>\n"; }
     echo '
  </tr>
  <tr>
    <td align="left">DB Active</td>
    ';
    if ( $db_active == 1 ) { echo "<td align=\"left\">".$enabled."</td>\n"; } else { echo "<td align=\"left\">".$disabled."</td>\n"; }
     echo '
  </tr>
  <tr>
    <td align="left">Script Domain</td>
    <td align="left">'.$script_domain.'</td>
  </tr>
  <tr>
    <td align="left">Script Path</td>
    <td align="left">'.$script_path.'</td>
  </tr>
  <tr>
    <td align="left">Starting Page</td>
    <td align="left">'.$home_site_name.'</td>
  </tr>
  <tr>
    <td valign="top" align="left">Domain(s)</td>
    <td valign="top" align="left">'.$exception_domain.'</td>
  </tr>
  <tr>
    <td valign="top" align="left">URL Parameter</td>
    <td valign="top" align="left">'.$url_parameter.'</td>
  </tr>
  <tr>
    <td align="left">Frames</td>
    ';
    if ( $frames == 1 ) { echo "<td align=\"left\">".$enabled."</td>\n"; } else { echo "<td align=\"left\">".$disabled."</td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left">IP Recount Time</td>
    <td valign="top" align="left">'.$ip_recount_time.' min.</td>
  </tr>
  <tr>
    <td align="left">Update Check</td>
    ';
    if ( $auto_update_check == 1 ) { echo "<td align=\"left\">".$enabled."</td>\n"; } else { echo "<td align=\"left\">".$disabled."</td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left">Error Reporting</td>
    ';
    if ( $error_reporting == 1 ) { echo "<td align=\"left\">".$enabled."</td>\n"; } else { echo "<td align=\"left\">".$disabled."</td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left">Log htaccess</td>
    ';
    if ( $set_htaccess == 1 ) { echo "<td align=\"left\">".$enabled."</td>\n"; } else { echo "<td align=\"left\">".$disabled."</td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left">Creator Number</td>
    <td align="left">'.number_format ( $creator_number , 0 , "," , "." ).'</td>
  </tr>
  <tr>
    <td align="left">Referer Cut</td>
    <td align="left">'.$creator_referer_cut.'</td>
  </tr>
  <tr>
    <td align="left">Index Number</td>
    <td align="left">'.number_format ( $index_creator_number , 0 , "," , "." ).'</td>
  </tr>
  <tr>
    <td align="left">Cache Update</td>
    <td align="left">'; if ( $cache_update != 0 ) { echo $cache_update." min."; } else { echo "OFF"; } echo '</td>
  </tr>
  <tr>
    <td align="left">Country detection</td>
    <td align="left">'; if ( file_exists ( "func/geoip/GeoIPversion.dat" ) )  { echo trim ( $geoip_version [0] ); } echo '</td>
  </tr>
  <tr>
    <td align="left">Last log entry</td>
    <td align="left">'.date( $last_log_dateform , $last_log_timestamp ).'</td>
  </tr>
  </table>

  <br />

  <!--// server info //-->
  <table class="stat_table" border="0" width="100%" cellspacing="0" cellpadding="3">
  <tr>
    <td class="stat_header" colspan="2">Server Info</td>
  </tr>
  <tr>
    <td width="120" valign="top" align="left">Server Host</td>
    <td align="left">'.gethostbyaddr ( gethostbyname ( $_SERVER[ "SERVER_NAME" ] ) ).'</td>
  </tr>
  <tr>
    <td width="120" valign="top" align="left">Server OS</td>
    <td align="left">'.$_SERVER[ "SERVER_SOFTWARE" ].'</td>
  </tr>
  <tr>
    <td width="120" valign="top" align="left">PHP Version</td>
    <td align="left">'.phpversion().'</td>
  </tr>
  <tr>
    <td width="120" valign="top" align="left">Max Execution T.</td>
    <td align="left">'.ini_get ( "max_execution_time" ).' sec.</td>
  </tr>
  <tr>
    <td width="120" valign="top" align="left">Memory Limit</td>
    <td align="left">'.ini_get ( "memory_limit" ).'B</td>
  </tr>
  <tr>
    <td align="left">Session Support</td>
    ';
    if ( isset ( $_SESSION ) )
     {
     	$temp = "<img src=\"images/sysinfo_on.png\" title=\"enabled\" alt=\"enabled\">";
     }
    else
     {
     	$temp = "<img src=\"images/sysinfo_off.png\" title=\"disabled\" alt=\"disabled\">";
     }
    echo '
    <td align="left">'.$temp.'</td>
    ';
    unset ( $temp );
    echo '
  </tr>
  <tr>
    <td align="left">Cookie Support</td>
    ';
    if ( isset ( $_SERVER [ 'HTTP_COOKIE' ] ) )
     {
     	$temp = "<img src=\"images/sysinfo_on.png\" title=\"enabled\" alt=\"enabled\">";
     }
    else
     {
     	$temp = "<img src=\"images/sysinfo_off.png\" title=\"disabled\" alt=\"disabled\">";
     }
    echo '
    <td align="left">'.$temp.'</td>
    ';
    unset ( $temp );
    echo '
  </tr>
  </table>
  <!--// end server info //-->
  </td>
  <td width="45%" valign="top" style="padding:10px 0px 5px 10px;">
  <!--// file check //-->
  ';
  function read_files ( $path )
   {
    $result = array();
    $handle = opendir ( $path );
     if ($handle)
      {
       while ( false !== ( $file = readdir ( $handle ) ) )
        {
         if ( $file != "." && $file != ".." )
          {
           if ( !is_dir ( $path."/".$file ) && ( substr ( $file , 0 , 1) != "." ) )
            {
             $result[] = $file;
            }
          }
        }
     }
     closedir ( $handle );
     return $result;
   }
  //-----------------------------
  function checker ( $files_path , $actual_version )
   {
    $files_read = read_files ( $files_path );
    asort ( $files_read );
    foreach ( $files_read as $value )
     {
      if (
           // folder config
           ( $value != "config.php"                  ) &&
           ( $value != "config_db.php"               ) &&
           ( $value != "delete_archive.php"          ) &&
           ( $value != "delete_backup.php"           ) &&
           ( $value != "delete_index.php"            ) &&
           ( $value != "db_transfer.php"             ) &&
           ( $value != "edit_css.php"                ) &&
           ( $value != "edit_db.php"                 ) &&
           ( $value != "edit_site_name.php"          ) &&
           ( $value != "edit_string_replace.php"     ) &&
           ( $value != "file_version.php"            ) &&
           ( $value != "pattern_site_name.inc"       ) &&
           ( $value != "pattern_string_replace.inc"  ) &&
           ( $value != "repair.php"                  ) &&
           ( $value != "tracking_code.php"           ) &&
           // folder func
           ( $value != "change_id.js"                ) &&
           ( $value != "checkversion.dta"            ) &&
           ( $value != "func_archive_save.php"       ) &&
           ( $value != "func_cache_control.php"      ) &&
           ( $value != "func_checkversion.php"       ) &&
           ( $value != "func_create_index.php"       ) &&
           ( $value != "func_crypt.php"              ) &&
           ( $value != "func_display_trends.php"     ) &&
           ( $value != "func_error.php"              ) &&
           ( $value != "func_geoip.inc"              ) &&
           ( $value != "func_kill_special_chars.php" ) &&
           ( $value != "func_last_logins.php"        ) &&
           ( $value != "func_last_logins_show.php"   ) &&
           ( $value != "func_pattern_icons.php"      ) &&
           ( $value != "func_read_dir.php"           ) &&
           ( $value != "func_refresh.php"            ) &&
           ( $value != "func_timer.php"              ) &&
           ( $value != "func_timestamp_control.php"  ) &&
           ( $value != "html_footer.php"             ) &&
           ( $value != "table_sort_dv.js"            ) &&
           ( $value != "table_sort_lh.js"            ) &&
           ( $value != "ticker.js"                   ) &&
           ( $value != "tooltip.js"                  ) &&
           ( $value != "unitpngfix.js"               ) &&
           ( $value != "win_open.js"                 ) &&
           // main folder
           ( $value != "checkversion.php"            ) &&
           ( $value != "db_connect.php"              ) &&
           ( $value != "detail_view.php"             ) &&
           ( $value != "plugin_choose.php"           ) &&
           ( $value != "update.php"                  ) &&
           ( $value != "update_info.txt"             )
         )
       {
        echo '
        <tr>
          <td align="left" style="padding:0px; padding-left:3px; height:18px;">'.$files_path.$value.'</td>
          <td align="center" style="padding:0px; height:18px;">
          ';

        $md5_file_content = md5_file ( $files_path.$value );

        $version_file = fopen ( "func/checkversion.dta" , "r" );
         while ( !FEOF ( $version_file ) )
          {
           $version_file_entry = fgetcsv ( $version_file , 60000 , "|" );   // read entry from logfile
           if ( $version_file_entry [ 1 ] == $value )
            {
             if ( trim($version_file_entry [ 2 ]) != $md5_file_content )
              {
               echo '<img src="images/sysinfo_error.png" width="16" height="16" title="Check FTP upload method or uploaded file" alt="Check FTP upload method or uploaded file" />';
              }
             else
              {
               echo '<img src="images/sysinfo_ok.png" width="16" height="16" alt="" />';
              }
            }
          }
        fclose ( $version_file );
        unset  ( $version_file );

        echo '
        </td>
        </tr>
        ';
       }
     }
   }
  //-----------------------------
  $actual_version = $version_number.$revision_number;
  echo '
  <table class="stat_table" border="0" width="100%" cellspacing="0" cellpadding="1">
  <tr>
    <td class="stat_header" colspan="2">File Check</td>
  </tr>
  <tr>
    <td class="stat_footer" style="border-top:0px;">File</td>
    <td width="50" class="stat_footer" style="border-top:0px;">Version</td>
  </tr>
  ';
  checker ( "config/"   , $version );
  checker ( "func/"     , $version );
  checker ( "./"        , $version );
  if ( file_exists ( "update.php" ) ) { echo '<td align="left" style="padding:0px; padding-left:3px; height:18px;">./update.php</td><td align="center" style="padding:0px; height:18px;"><img src="images/sysinfo_warning.png" width="16" height="16" alt="delete after updating" title="delete after updating">'; }
  echo '
  </table>
  </td>
</tr>
</table>

<hr color="#000000" size="1" />

<!--// file status table //-->';
################################################################################
### file status table ###
echo '
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td style="padding:5px 0px 10px 0px;">

  <table class="stat_table" border="0" width="100%" cellspacing="0" cellpadding="1">
  <tr>
    <td class="stat_header" colspan="5">File CHMOD Status</td>
  </tr>
  <tr>
    <td class="stat_footer" style="border-top:0px;">File</td>
    <td width="100" class="stat_footer" style="border-top:0px; padding-right:20px; text-align:right">Size</td>
    <td width="80" class="stat_footer" style="border-top:0px; padding-right:20px; text-align:right">Rows</td>
    <td width="50" class="stat_footer" style="border-top:0px; text-align:center">CHMOD</td>
    <td width="50" class="stat_footer" style="border-top:0px; text-align:center">Status</td>
  </tr>
  <tr>
    <td colspan="3" align="left" style="padding-left:3px;">backup/</td>
    <td align="center">'.folder_perms('backup/').'</td>
    ';
    if ( ( decoct ( fileperms ( "backup/" ) ) == 40777 ) || ( decoct ( fileperms ( "backup/" ) ) == 40775 ) || ( decoct ( fileperms ( "backup/" ) ) == 40770 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td colspan="3" align="left" style="padding-left:3px;">log/</td>
    <td align="center">'.folder_perms('log/').'</td>
    ';
    if ( ( decoct ( fileperms ( "log/" ) ) == 40777 ) || ( decoct ( fileperms ( "log/" ) ) == 40775 ) || ( decoct ( fileperms ( "log/" ) ) == 40770 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td colspan="3" align="left" style="padding-left:3px; border-bottom:1px solid #000000">log/archive/</td>
    <td align="center" style="border-bottom:1px solid #000000">'.folder_perms('log/archive/').'</td>
    ';
    if ( ( decoct ( fileperms ( "log/archive/" ) ) == 40777 ) || ( decoct ( fileperms ( "log/archive/" ) ) == 40775 ) || ( decoct ( fileperms ( "log/archive/" ) ) == 40770 ) ) { echo "<td align=\"center\" style=\"border-bottom:1px solid #000000\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; } else { echo "<td align=\"center\" style=\"border-bottom:1px solid #000000\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td colspan="3" align="left" style="padding-left:3px;">config/config.php</td>
    <td align="center">'.file_perms('config/config.php').'</td>
    ';
    if ( ( decoct ( fileperms ( "config/config.php" ) ) != 100666 ) && ( decoct ( fileperms ( "config/config.php" ) ) != 100660 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td colspan="3" align="left" style="padding-left:3px; border-bottom:1px solid #000000">config/config_db.php</td>
    <td align="center" style="border-bottom:1px solid #000000">'.file_perms('config/config_db.php').'</td>
    ';
    if ( ( decoct ( fileperms ( "config/config_db.php" ) ) != 100666 ) && ( decoct ( fileperms ( "config/config_db.php" ) ) != 100660 ) ) { echo "<td align=\"center\" style=\"border-bottom:1px solid #000000\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; } else { echo "<td align=\"center\" style=\"border-bottom:1px solid #000000\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left" style="padding-left:3px;"><a class="referer" style="text-decoration:underline;" href="config/pattern_site_name.inc" target="_blank">config/pattern_site_name.inc</a></td>
    <td align="right" style="padding-right:20px">'.file_size("config/pattern_site_name.inc").' KB</td>
    <td align="right" style="padding-right:20px;">'.file_row_size_small("config/pattern_site_name.inc").'</td>
    <td align="center">'.file_perms('config/pattern_site_name.inc').'</td>
    ';
    if ( ( decoct ( fileperms ( "config/pattern_site_name.inc" ) ) != 100666 ) && ( decoct ( fileperms ( "config/pattern_site_name.inc" ) ) != 100660 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left" style="padding-left:3px;"><a class="referer" style="text-decoration:underline;" href="config/pattern_string_replace.inc" target="_blank">config/pattern_string_replace.inc</a></td>
    <td align="right" style="padding-right:20px">'.file_size("config/pattern_string_replace.inc").' KB</td>
    <td align="right" style="padding-right:20px;">'.file_row_size_small("config/pattern_string_replace.inc").'</td>
    <td align="center">'.file_perms('config/pattern_string_replace.inc').'</td>
    ';
    if ( ( decoct ( fileperms ( "config/pattern_string_replace.inc" ) ) != 100666 ) && ( decoct ( fileperms ( "config/pattern_string_replace.inc" ) ) != 100660 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left" style="padding-left:3px;">config/tracking_code.php</td>
    <td align="right" style="padding-right:20px">'.file_size("config/tracking_code.php").' KB</td>
    <td align="right" style="padding-right:20px;">'.file_row_size_small("config/tracking_code.php").'</td>
    <td align="center">'.file_perms('config/tracking_code.php').'</td>
    ';
    if ( ( decoct ( fileperms ( "config/config/tracking_code.php" ) ) != 100666 ) && ( decoct ( fileperms ( "config/tracking_code.php" ) ) != 100660 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left" style="padding-left:3px;">cache_time_stamp.php</td>
    <td align="right" style="padding-right:20px">'.file_size("log/cache_time_stamp.php").' KB</td>
    <td align="right" style="padding-right:20px;">1</td>
    <td align="center">'.file_perms('log/cache_time_stamp.php').'</td>
    ';
    if ( ( decoct ( fileperms ( "log/cache_time_stamp.php" ) ) != 100666 ) && ( decoct ( fileperms ( "log/cache_time_stamp.php" ) ) != 100660 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left" style="padding-left:3px;">cache_time_stamp_archive.php</td>
    <td align="right" style="padding-right:20px">'.file_size("log/cache_time_stamp_archive.php").' KB</td>
    <td align="right" style="padding-right:20px;">1</td>
    <td align="center">'.file_perms('log/cache_time_stamp_archive.php').'</td>
    ';
    if ( ( decoct ( fileperms ( "log/cache_time_stamp_archive.php" ) ) != 100666 ) && ( decoct ( fileperms ( "log/cache_time_stamp_archive.php" ) ) != 100660 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left" style="padding-left:3px;">cache_visitors.php</td>
    <td align="right" style="padding-right:20px">'.file_size("log/cache_visitors.php").' KB</td>
    <td align="right" style="padding-right:20px;">'.file_row_size_big("log/cache_visitors.php").'</td>
    <td align="center">'.file_perms('log/cache_visitors.php').'</td>
    ';
    if ( ( decoct ( fileperms ( "log/cache_visitors.php" ) ) != 100666 ) && ( decoct ( fileperms ( "log/cache_visitors.php" ) ) != 100660 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left" style="padding-left:3px;">cache_visitors_archive.php</td>
    <td align="right" style="padding-right:20px">'.file_size("log/cache_visitors_archive.php").' KB</td>
    <td align="right" style="padding-right:20px;">'.file_row_size_big("log/cache_visitors_archive.php").'</td>
    <td align="center">'.file_perms('log/cache_visitors_archive.php').'</td>
    ';
    if ( ( decoct ( fileperms ( "log/cache_visitors_archive.php" ) ) != 100666 ) && ( decoct ( fileperms ( "log/cache_visitors_archive.php" ) ) != 100660 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left" style="padding-left:3px;"><a class="referer" style="text-decoration:underline;" href="log/logdb.dta" target="_blank">logdb.dta</a></td>
    <td align="right" style="padding-right:20px">'.file_size("log/logdb.dta").' KB</td>
    <td align="right" style="padding-right:20px;">'.file_row_size_big("log/logdb.dta").'</td>
    <td align="center">'.file_perms('log/logdb.dta').'</td>
    ';
    if ( ( decoct ( fileperms ( "log/logdb.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/logdb.dta" ) ) != 100660 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left" style="padding-left:3px;"><a class="referer" style="text-decoration:underline;" href="log/logdb_backup.dta" target="_blank">logdb_backup.dta</a></td>
    <td align="right" style="padding-right:20px">'.file_size("log/logdb_backup.dta").' KB</td>
    <td align="right" style="padding-right:20px;">'.file_row_size_big("log/logdb_backup.dta").'</td>
    <td align="center">'.file_perms('log/logdb_backup.dta').'</td>
    ';
    if ( ( decoct ( fileperms ( "log/logdb_backup.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/logdb_backup.dta" ) ) != 100660 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left" style="padding-left:3px;"><a class="referer" style="text-decoration:underline;" href="log/logdb_temp.dta" target="_blank">logdb_temp.dta</a></td>
    <td align="right" style="padding-right:20px">'.file_size("log/logdb_temp.dta").' KB</td>
    <td align="right" style="padding-right:20px;">'.file_row_size_big("log/logdb_temp.dta").'</td>
    <td align="center">'.file_perms('log/logdb_temp.dta').'</td>
    ';
    if ( ( decoct ( fileperms ( "log/logdb_temp.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/logdb_temp.dta" ) ) != 100660 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left" style="padding-left:3px;"><a class="referer" style="text-decoration:underline;" href="log/logdb_track_file.dta" target="_blank">logdb_track_file.dta</a></td>
    <td align="right" style="padding-right:20px">'.file_size("log/logdb_track_file.dta").' KB</td>
    <td align="right" style="padding-right:20px;">'.file_row_size_small("log/logdb_track_file.dta").'</td>
    <td align="center">'.file_perms('log/logdb_track_file.dta').'</td>
    ';
    if ( ( decoct ( fileperms ( "log/logdb_track_file.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/logdb_track_file.dta" ) ) != 100660 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left" style="padding-left:3px;"><a class="referer" style="text-decoration:underline;" href="log/pattern_browser.dta" target="_blank">pattern_browser.dta</a></td>
    <td align="right" style="padding-right:20px">'.file_size("log/pattern_browser.dta").' KB</td>
    <td align="right" style="padding-right:20px;">'.file_row_size_small("log/pattern_browser.dta").'</td>
    <td align="center">'.file_perms('log/pattern_browser.dta').'</td>
    ';
    if ( ( decoct ( fileperms ( "log/pattern_browser.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/pattern_browser.dta" ) ) != 100660 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left" style="padding-left:3px;"><a class="referer" style="text-decoration:underline;" href="log/pattern_operating_system.dta" target="_blank">pattern_operating_system.dta</a></td>
    <td align="right" style="padding-right:20px">'.file_size("log/pattern_operating_system.dta").' KB</td>
    <td align="right" style="padding-right:20px;">'.file_row_size_small("log/pattern_operating_system.dta").'</td>
    <td align="center">'.file_perms('log/pattern_operating_system.dta').'</td>
    ';
    if ( ( decoct ( fileperms ( "log/pattern_operating_system.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/pattern_operating_system.dta" ) ) != 100660 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left" style="padding-left:3px;"><a class="referer" style="text-decoration:underline;" href="log/pattern_referer.dta" target="_blank">pattern_referer.dta</a></td>
    <td align="right" style="padding-right:20px">'.file_size("log/pattern_referer.dta").' KB</td>
    <td align="right" style="padding-right:20px;">'.file_row_size_big("log/pattern_referer.dta").'</td>
    <td align="center">'.file_perms('log/pattern_referer.dta').'</td>
    ';
    if ( ( decoct ( fileperms ( "log/pattern_referer.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/pattern_referer.dta" ) ) != 100660 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left" style="padding-left:3px;"><a class="referer" style="text-decoration:underline;" href="log/pattern_resolution.dta" target="_blank">pattern_resolution.dta</a></td>
    <td align="right" style="padding-right:20px">'.file_size("log/pattern_resolution.dta").' KB</td>
    <td align="right" style="padding-right:20px;">'.file_row_size_small("log/pattern_resolution.dta").'</td>
    <td align="center">'.file_perms('log/pattern_resolution.dta').'</td>
    ';
    if ( ( decoct ( fileperms ( "log/pattern_resolution.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/pattern_resolution.dta" ) ) != 100660 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; }
    echo '
  </tr>
  <tr>
    <td align="left" style="padding-left:3px;"><a class="referer" style="text-decoration:underline;" href="log/pattern_site_name.dta" target="_blank">pattern_site_name.dta</a></td>
    <td align="right" style="padding-right:20px">'.file_size("log/pattern_site_name.dta").' KB</td>
    <td align="right" style="padding-right:20px;">'.file_row_size_big("log/pattern_site_name.dta").'</td>
    <td align="center">'.file_perms('log/pattern_site_name.dta').'</td>';
    if ( ( decoct ( fileperms ( "log/pattern_site_name.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/pattern_site_name.dta" ) ) != 100660 ) ) { echo "<td align=\"center\"><img src=\"images/sysinfo_error.png\" width=\"16\" height=\"16\" title=\"Check CHMOD\" alt=\"Check CHMOD\" /></td>\n"; } else { echo "<td align=\"center\"><img src=\"images/sysinfo_ok.png\" width=\"16\" height=\"16\" alt=\"\" /></td>\n"; }
    echo '
  </tr>
  </table>

  </td>
</tr>
</table>

<hr color="#000000" size="1" />

Copyright &copy; 2015 <a href="http://www.php-web-statistik.de" target="_blank">PHP Web Stat</a>

</td></tr></table>
';
//------------------------------------------------------------------------------
include ( "func/html_footer.php" ); // include html footer
//------------------------------------------------------------------------------
?>