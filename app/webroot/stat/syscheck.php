<?php @session_start(); if ( $_SESSION [ "hidden_func" ] != md5_file ( "config/config.php" ) ) { include ( "func/func_error.php" ); exit; }
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
include ( "config/config.php" ); // include path to config
include ( substr ( $language , 0 , strpos ( $language , "." ) )."_admin.php" ); // include language vars
//------------------------------------------------------------------------------
if ( $language == "language/german.php"     ) { $lang = "de";    }
if ( $language == "language/english.php"    ) { $lang = "en";    }
if ( $language == "language/dutch.php"      ) { $lang = "nl";    }
if ( $language == "language/italian.php"    ) { $lang = "it";    }
if ( $language == "language/spanish.php"    ) { $lang = "es";    }
if ( $language == "language/catalan.php"    ) { $lang = "es-ct"; }
if ( $language == "language/farsi.php"      ) { $lang = "fa";    }
if ( $language == "language/danish.php"     ) { $lang = "dk";    }
if ( $language == "language/french.php"     ) { $lang = "fr";    }
if ( $language == "language/turkish.php"    ) { $lang = "tr";    }
if ( $language == "language/hungarian.php"  ) { $lang = "hu";    }
if ( $language == "language/portuguese.php" ) { $lang = "pt";    }
if ( $language == "language/hebrew.php"     ) { $lang = "he";    }
if ( $language == "language/russian.php"    ) { $lang = "ru";    }
if ( $language == "language/serbian.php"    ) { $lang = "rs";    }
if ( $language == "language/finnish.php"    ) { $lang = "fi";    }
//------------------------------------------------------------------------------
// Function file perms
function file_perms ( $file, $octal = false )
 {
  if ( !file_exists ( $file ) ) return false;
  $perms = fileperms ( $file );
  $cut = $octal ? 2 : 3;
  return substr( decoct( $perms), $cut );
 }
//------------------------------------------------------------------------------
// Function folder perms
function folder_perms ( $file, $octal = false )
 {
  if ( !file_exists ( $file ) ) return false;
  $perms = fileperms ( $file );
  $cut = $octal ? 1 : 2;
  return substr ( decoct ( $perms ), $cut );
 }
//------------------------------------------------------------------------------
// Function for displaying errors
function display_error ( $x )
 {
  global $error_counter;
  $error_counter++;
  echo "<font color='#CC0000'>&nbsp; - $x.</font><br>\n";
 }
//------------------------------------------------------------------------------
// Function for linkcheck
function checklink ( $loc )
 {
  global $lang_admin_sc;
  $x = head ( $loc );
  if ( $x != 200 )
   {
    display_error ( $lang_admin_sc[37]." ($x), $loc ".$lang_admin_sc[38]."" ) ;
   }
 }
//------------------------------------------------------------------------------
// Function for Socket Server Availability
function head ( $location )
 {
  $location = trim ( preg_replace ( "/^http:\/\//i" , "" , $location ) );

  $c = strpos ( $location , "/" );

  if ( !$c ) { $host = $location; $pfad = "/"; } else { $host = substr ( $location , 0 , $c ); $pfad = substr ( $location , $c ); }

  $fp = @fsockopen ( $host, 80, $errno, $errstr, 5 );

  if ( $fp )
   {
    fputs ( $fp , "HEAD $pfad HTTP/1.0\r\n" );
    fputs ( $fp , "Host: $host\r\n" );
    fputs ( $fp , "User-Agent: PHP/StatusCheck V0.2\r\n" );
    fputs ( $fp , "\r\n" );

    while ( !feof ( $fp ) )
     {
      $c = fgets ( $fp , 133 );
      if ( strlen ( $c ) == 2 ) break;
      if ( $verbose ) echo htmlentities ( $c )."<br>\n";
      if ( preg_match ( "/^HTTP.*? ([0-9]{3})/i" , $c , $match ) ) $status = 0 + $match [ 1 ];
      if ( preg_match ( "/^Location: (.*)$/i" , $c , $match ) ) $newLocation = $match [ 1 ];
     }

    if ( ( $status == 302 || $status == 301 ) && $newLocation ) return ( head ( $newLocation ) ); else return ( $status );

    fclose ( $fp );
   }
  else
   {
    return 0;
   }
 }
//------------------------------------------------------------------------------
// Function for Database Row Output
function f ( $row )
 {
  global $t , $value_n , $last_n;
  if ( !$t )
   {
    $t = true;
    echo '<table border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC"><tr>'."\n";
    foreach ( $row as $key => $value )
     {
      echo '<th bgcolor="#CCCCCC">'.str_replace( '_' , ' ', $key ).'</th>'."\n";
     }
    echo '</tr>'."\n";
   }
  if ( ( $value_n ) && ( $value_n != $last_n ) )
   {
    $last_n = $value_n; echo '<tr><td COLSPAN='.count ( $row ).'><b>'.$value_n.'</td></tr>'."\n";
   }
  echo '<tr>'."\n";
  foreach ( $row as $key => $value )
   {
    echo '<td';
    if ( is_numeric ( $value ) )
     {
      echo ' align="right"';
     }
    echo '>'.$value.'&nbsp;</td>'."\n";
   }
  echo '</tr>'."\n";
 }
//------------------------------------------------------------------------------
// Function for Database Row Output
function f_exit ( $t )
 {
  if ( $t ){ echo '<b><font color="#CC0000">'.$t.'</font></b><hr>'."\n";} else { echo '<br>'."\n"; }
  $t = 'GLOBAL VARIABLES';
  echo '<b>'.$t.'</b>'.'<br>'."\n";
  $result = mysql_query ( $t );
  if ( !$result ) { echo mysql_error().'<br>'."\n"; } else { while ( $row = mysql_fetch_assoc ( $result ) ) { f1 ( $row ); } }
  $t = 'SESSION VARIABLES';
  echo '<hr><b>'.$t.'</b>'.'<br>'."\n";
  $result = mysql_query ( $t );
  if ( !$result ) { echo mysql_error().'<br>'."\n"; } else { while ( $row = mysql_fetch_assoc ( $result ) ) { f1 ( $row ); } }
  echo '<hr>';
  if ( $t ) { exit; }
 }
//------------------------------------------------------------------------------
function f1( $row ) { echo $row [ 'Variable_name' ].': '.$row [ 'Value' ].'<br>'."\n"; }
//------------------------------------------------------------------------------
include ( "func/html_header.php" ); // include html header
//------------------------------------------------------------------------------
echo '
<div id="syscheck_menu" style="height:65px; background:#DFE4E9">
<form name="check" action="syscheck.php" method="post">
<table border="0" cellspacing="0" cellpadding="3">
<tr>
  <td style="border:none; font-size:100%; font-family:Verdana"><b>'.$lang_admin_sc[4].':</b></td>
  <td style="border:none; font-size:100%; font-family:Verdana">
      <input type="submit" class="frame_menu" name="parameter" value="'.$lang_admin_sc[5].'">
      <input type="submit" class="frame_menu" name="parameter" value="'.$lang_admin_sc[6].'">
      <input type="submit" class="frame_menu" name="parameter" value="'.$lang_admin_sc[7].'">
  </td>
</tr>
<tr>
  <td style="border:none; font-size:100%; font-family:Verdana"><b>'.$lang_admin_sc[10].':</b></td>
  <td style="border:none; font-size:100%; font-family:Verdana">
      <input type="submit" class="frame_menu" name="parameter" value="'.$lang_admin_sc[11].'">
      <input type="submit" class="frame_menu" name="parameter" value="'.$lang_admin_sc[12].'">
      <input type="submit" class="frame_menu" name="parameter" value="'.$lang_admin_sc[13].'">
      <input type="submit" class="frame_menu" name="parameter" value="'.$lang_admin_sc[14].'">
      <input type="submit" class="frame_menu" name="parameter" value="'.$lang_admin_sc[15].'">
  </td>
</tr>
</table>
</form>
</div>';
//------------------------------------------------------------------------------
echo '
<div style="border:1px solid #0D638A; height:468px; overflow: auto;">
<table border="0" width="100%" cellspacing="0" cellpadding="0">';
if ( ! $_POST [ "parameter" ] )
 {
  echo '
  <tr>
    <td class="bg1" valign="top" style="padding:10px;">
    '.$lang_admin_sc[18].'
    </td>
  </tr>';
 }
else
 {
  echo '
  <tr>
    <td class="th2 bold center" style="height:18px; padding:2px; border:none; border-bottom:1px solid #0D638A;">'.$lang_admin_sc[19].'</td>
  </tr>';
 }
echo '
<tr>
  <td class="bg1" valign="top" style="padding:10px; border:none;">';
//------------------------------------------------------------------------------
// get function
if ( $_POST [ "parameter" ] == "phpinfo" )
 {
  phpinfo();
 }
elseif ( $_POST [ "parameter" ] == "$lang_admin_sc[6]" )
 {
  echo '<table border="1" cellspacing="0" cellpadding="3" bordercolor="#CCCCCC">';
  foreach ( $_SERVER as $key => $value )
   {
    echo '<tr><td width="180" bgcolor="#CCCCCC">'.$key.'</td><td>'; if ( $value == "" ) { echo '&nbsp;'; } else { echo $value; } echo '</td></tr>';
   }
  echo '</table>';
 }
elseif ( $_POST [ "parameter" ] == "$lang_admin_sc[7]" )
 {
  echo '<table border="1" cellspacing="0" cellpadding="3" bordercolor="#CCCCCC">';
  echo '<tr><td width="210" bgcolor="#CCCCCC">session_cache_expire</td><td>'.@session_cache_expire().'</td></tr>';
  echo '<tr><td bgcolor="#CCCCCC">session_cache_limiter</td><td>'.@session_cache_limiter().'</td></tr>';
  echo '<tr><td valign="top" bgcolor="#CCCCCC">session_get_cookie_params</td><td><pre>'; print_r(@session_get_cookie_params()).'</pre></td></tr>';
  echo '<tr><td bgcolor="#CCCCCC">session_id</td><td>'.@session_id().'</td></tr>';
  echo '<tr><td bgcolor="#CCCCCC">session_is_registered</td><td>'; if ( @session_is_registered ( 'hidden_stat' ) ) { echo 'true'; } else { echo 'false'; }; echo '</td></tr>';
  echo '<tr><td bgcolor="#CCCCCC">session_module_name</td><td>'.@session_module_name().'</td></tr>';
  echo '<tr><td bgcolor="#CCCCCC">session_name</td><td>'.@session_name().'</td></tr>';
  echo '<tr><td bgcolor="#CCCCCC">session_save_path</td><td>'.@session_save_path().'</td></tr>';
  echo '<tr><td valign="top" bgcolor="#CCCCCC">$_SESSION</td><td><pre>'; print_r ( $_SESSION ).'</pre></td></tr>';
  echo '</table>';
 }
elseif ( $_POST [ "parameter" ] == "$lang_admin_sc[11]" )
 {
  echo'<pre>';
  echo '$_SERVER [ "SERVER_ADDR"            ]: '.$_SERVER [ "SERVER_ADDR"            ].'<hr>';
  echo '$_SERVER [ "REMOTE_ADDR"            ]: '.$_SERVER [ "REMOTE_ADDR"            ].'<br>';
  echo '$_SERVER [ "HTTP_X_REMOTECLIENT_IP" ]: '.$_SERVER [ "HTTP_X_REMOTECLIENT_IP" ].'<br>';
  echo '$_SERVER [ "HTTP_X_FORWARDED_FOR"   ]: '.$_SERVER [ "HTTP_X_FORWARDED_FOR"   ].'<br>';
  echo '$_SERVER [ "HTTP_CLIENT_IP"         ]: '.$_SERVER [ "HTTP_CLIENT_IP"         ].'<br>';
  echo 'getenv   ( "REMOTE_ADDR"            ): '.getenv   ( "REMOTE_ADDR"            ).'<br>';
  echo 'getenv   ( "HTTP_X_REMOTECLIENT_IP" ): '.getenv   ( "HTTP_X_REMOTECLIENT_IP" ).'<br>';
  echo 'getenv   ( "HTTP_X_FORWARDED_FOR"   ): '.getenv   ( "HTTP_X_FORWARDED_FOR"   ).'<br>';
  echo 'getenv   ( "HTTP_CLIENT_IP"         ): '.getenv   ( "HTTP_CLIENT_IP"         ).'<br>';
  echo'</pre>';
 }
elseif ( $_POST [ "parameter" ] == "$lang_admin_sc[12]" )
 {
  include ( 'config/config_db.php' );

  echo '<pre>';
  echo 'mysql_stat:              '.mysql_stat()."\n";
  echo 'mysql_get_client_info:   '.mysql_get_client_info()."\n";
  echo 'mysql_get_host_info:     '.mysql_get_host_info()."\n";
  echo 'mysql_get_server_info:   '.mysql_get_server_info()."\n";
  echo 'mysql_get_proto_info:    '.mysql_get_proto_info()."\n";
  echo 'mysql_client_encoding:   '.mysql_client_encoding()."\n";
  echo '<hr>';
  echo '<table border="0" cellspacing="0" cellpadding="1">';
  echo '<tr><td style="padding-right:20px">'.$lang_admin_sc[20].':</td><td>'.$db_host.'</td></tr>';
  echo '<tr><td style="padding-right:20px">'.$lang_admin_sc[21].':</td><td>'.$db_name.'</td></tr>';
  echo '<tr><td style="padding-right:20px">'.$lang_admin_sc[22].':</td><td>'.$db_user.'</td></tr>';
  echo '<tr><td style="padding-right:20px">'.$lang_admin_sc[23].':</td><td>'; for ( $i = 1 ; $i <= strlen ( $db_password ); $i++ ) { echo '*'; } echo '</td></tr>';
  echo '<tr><td style="padding-right:20px">'.$lang_admin_sc[24].':</td><td>'.$db_prefix.'</td></tr>';
  echo '</table>';
  echo '<hr>';
  echo '</pre>';

  $link = mysql_connect ( $db_host , $db_user , $db_password );
  if ( !$link ) { f_exit ( $lang_admin_sc[25].'!' ); }

  $db_selected = mysql_select_db ( $db_name );
  if ( !$db_selected ) { f_exit ( mysql_error ( ) ); }
  $result = mysql_query ( 'SHOW TABLE STATUS' );

  while ( $row = mysql_fetch_assoc ( $result ) ) { f ( $row ); $n [ ] = $row [ 'Name' ]; }
  echo '</table><br>'."\n";
  $t = false;

  foreach ( $n as $value_n )
   {
    $result = mysql_query ( 'SHOW COLUMNS FROM '.$value_n );
    if ( !$result ) { echo mysql_error().'<br>'."\n"; }
    else
     {
      $result1 = mysql_query ( 'select * from '.$value_n );
      $i = 0;
      while ( $row = mysql_fetch_assoc ( $result ) )
       {
        $row = array_merge ( array ( 'Table' => '' ) , $row , array ( '&nbsp;' => '' ) );
        $meta = mysql_fetch_field ( $result1 , $i );
        $i++;

        foreach ( $meta as $key => $value )
         {
          if ( ( $key != 'name' ) && ( $key != 'table' ) )
           {
            $row [ $key ] = $value;
           }
         }
        f ( $row );
       }
     }
   }

  echo '</table>'.'<br>'."\n";
  $t = false;

  foreach( $n as $value_n )
   {
    $result = mysql_query ( 'SHOW INDEX FROM '.$value_n );
    if ( !$result ) { echo mysql_error().'<br>'."\n"; }
    else
     {
      while ( $row = mysql_fetch_assoc ( $result ) )
       {
        $row [ 'Table' ] = '';
        f ( $row );
       }
     }
   }
  echo '</table>';
  f_exit ( '' );
 }
elseif ( $_POST [ "parameter" ] == "$lang_admin_sc[13]" )
 {
  echo '<table border="0" width="400" cellspacing="0" cellpadding="1">';
  if ( ( decoct ( fileperms ( "backup/"                           ) ) == 40777  ) || ( decoct ( fileperms ( "backup/"      ) ) == 40775 ) || ( decoct ( fileperms ( "backup/"      ) ) == 40770 ) ) { echo '<tr><td>backup</td><td>'.folder_perms ( "backup/" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>backup</td><td>'.folder_perms ( "backup/" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/"                              ) ) == 40777  ) || ( decoct ( fileperms ( "log/"         ) ) == 40775 ) || ( decoct ( fileperms ( "log/"         ) ) == 40770 ) ) { echo '<tr><td>log</td><td>'.folder_perms ( "log/" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>log</td><td>'.folder_perms ( "log/" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/archive/"                      ) ) == 40777  ) || ( decoct ( fileperms ( "log/archive/" ) ) == 40775 ) || ( decoct ( fileperms ( "log/archive/" ) ) == 40770 ) ) { echo '<tr><td style="border-bottom:1px solid #000000">log/archive</td><td style="border-bottom:1px solid #000000">'.folder_perms ( "log/archive/" ).'</td><td style="border-bottom:1px solid #000000"><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td style="border-bottom:1px solid #000000">log/archive</td><td style="border-bottom:1px solid #000000">'.folder_perms ( "log/archive/" ).'</td><td style="border-bottom:1px solid #000000"><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "config/config.php"                 ) ) == 100666 ) || ( decoct ( fileperms ( "config/config.php"                 ) ) == 100660 ) ) { echo '<tr><td>config/config.php</td><td>'.file_perms ( "config/config.php" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>config/config.php</td><td>'.file_perms ( "config/config.php" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "config/config_db.php"              ) ) == 100666 ) || ( decoct ( fileperms ( "config/config_db.php"              ) ) == 100660 ) ) { echo '<tr><td style="border-bottom:1px solid #000000">config/config_db.php</td><td style="border-bottom:1px solid #000000">'.file_perms ( "config/config_db.php" ).'</td><td style="border-bottom:1px solid #000000"><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td style="border-bottom:1px solid #000000">config/config_db.php</td><td style="border-bottom:1px solid #000000">'.file_perms ( "config/config_db.php" ).'</td><td style="border-bottom:1px solid #000000"><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "config/pattern_site_name.inc"      ) ) == 100666 ) || ( decoct ( fileperms ( "config/pattern_site_name.inc"      ) ) == 100660 ) ) { echo '<tr><td>config/pattern_site_name.inc</td><td>'.file_perms ( "config/pattern_site_name.inc" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>config/pattern_site_name.inc</td><td>'.file_perms ( "config/pattern_site_name.inc" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "config/pattern_string_replace.inc" ) ) == 100666 ) || ( decoct ( fileperms ( "config/pattern_string_replace.inc" ) ) == 100660 ) ) { echo '<tr><td style="border-bottom:1px solid #000000">config/pattern_string_replace.inc</td><td style="border-bottom:1px solid #000000">'.file_perms ( "config/pattern_string_replace.inc" ).'</td><td style="border-bottom:1px solid #000000"><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td style="border-bottom:1px solid #000000">config/pattern_string_replace.inc</td><td style="border-bottom:1px solid #000000">'.file_perms ( "config/pattern_string_replace.inc" ).'</td><td style="border-bottom:1px solid #000000"><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "config/tracking_code.php"          ) ) == 100666 ) || ( decoct ( fileperms ( "config/tracking_code.php"          ) ) == 100660 ) ) { echo '<tr><td style="border-bottom:1px solid #000000">config/tracking_code.php</td><td style="border-bottom:1px solid #000000">'.file_perms ( "config/tracking_code.php" ).'</td><td style="border-bottom:1px solid #000000"><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td style="border-bottom:1px solid #000000">config/tracking_code.php</td><td style="border-bottom:1px solid #000000">'.file_perms ( "config/tracking_code.php" ).'</td><td style="border-bottom:1px solid #000000"><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/cache_memory_address.php"      ) ) == 100666 ) || ( decoct ( fileperms ( "log/cache_memory_address.php"      ) ) == 100660 ) ) { echo '<tr><td>log/cache_memory_address.php</td><td>'.file_perms ( "log/cache_memory_address.php" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>log/cache_memory_address.php</td><td>'.file_perms ( "log/cache_memory_address.php" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/cache_time_stamp.php"          ) ) == 100666 ) || ( decoct ( fileperms ( "log/cache_time_stamp.php"          ) ) == 100660 ) ) { echo '<tr><td>log/cache_time_stamp.php</td><td>'.file_perms ( "log/cache_time_stamp.php" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>log/cache_time_stamp.php</td><td>'.file_perms ( "log/cache_time_stamp.php" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/cache_time_stamp_archive.php"  ) ) == 100666 ) || ( decoct ( fileperms ( "log/cache_time_stamp_archive.php"  ) ) == 100660 ) ) { echo '<tr><td>log/cache_time_stamp_archive.php</td><td>'.file_perms ( "log/cache_time_stamp_archive.php" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>log/cache_time_stamp_archive.php</td><td>'.file_perms ( "log/cache_time_stamp_archive.php" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/cache_visitors.php"            ) ) == 100666 ) || ( decoct ( fileperms ( "log/cache_visitors.php"            ) ) == 100660 ) ) { echo '<tr><td>log/cache_visitors.php</td><td>'.file_perms ( "log/cache_visitors.php" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>log/cache_visitors.php</td><td>'.file_perms ( "log/cache_visitors.php" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/cache_visitors_archive.php"    ) ) == 100666 ) || ( decoct ( fileperms ( "log/cache_visitors_archive.php"    ) ) == 100660 ) ) { echo '<tr><td>log/cache_visitors_archive.php</td><td>'.file_perms ( "log/cache_visitors_archive.php" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>log/cache_visitors_archive.php</td><td>'.file_perms ( "log/cache_visitors_archive.php" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/cache_visitors_counter.php"    ) ) == 100666 ) || ( decoct ( fileperms ( "log/cache_visitors_counter.php"    ) ) == 100660 ) ) { echo '<tr><td>log/cache_visitors_counter.php</td><td>'.file_perms ( "log/cache_visitors_counter.php" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>log/cache_visitors_counter.php</td><td>'.file_perms ( "log/cache_visitors_counter.php" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/index_days.php"                ) ) == 100666 ) || ( decoct ( fileperms ( "log/index_days.php"                ) ) == 100660 ) ) { echo '<tr><td>log/index_days.php</td><td>'.file_perms ( "log/index_days.php" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>log/index_days.php</td><td>'.file_perms ( "log/index_days.php" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/last_timestamp.dta"            ) ) == 100666 ) || ( decoct ( fileperms ( "log/last_timestamp.dta"            ) ) == 100660 ) ) { echo '<tr><td>log/last_timestamp.dta</td><td>'.file_perms ( "log/last_timestamp.dta" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>log/last_timestamp.dta</td><td>'.file_perms ( "log/last_timestamp.dta" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/logdb.dta"                     ) ) == 100666 ) || ( decoct ( fileperms ( "log/logdb.dta"                     ) ) == 100660 ) ) { echo '<tr><td>log/logdb.dta</td><td>'.file_perms ( "log/logdb.dta" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>log/logdb.dta</td><td>'.file_perms ( "log/logdb.dta" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/logdb_backup.dta"              ) ) == 100666 ) || ( decoct ( fileperms ( "log/logdb_backup.dta"              ) ) == 100660 ) ) { echo '<tr><td>log/logdb_backup.dta</td><td>'.file_perms ( "log/logdb_backup.dta" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>log/logdb_backup.dta</td><td>'.file_perms ( "log/logdb_backup.dta" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/logdb_temp.dta"                ) ) == 100666 ) || ( decoct ( fileperms ( "log/logdb_temp.dta"                ) ) == 100660 ) ) { echo '<tr><td>log/logdb_temp.dta</td><td>'.file_perms ( "log/logdb_temp.dta" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>log/logdb_temp.dta</td><td>'.file_perms ( "log/logdb_temp.dta" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/pattern_browser.dta"           ) ) == 100666 ) || ( decoct ( fileperms ( "log/pattern_browser.dta"           ) ) == 100660 ) ) { echo '<tr><td>log/pattern_browser.dta</td><td>'.file_perms ( "log/pattern_browser.dta" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>log/pattern_browser.dta</td><td>'.file_perms ( "log/pattern_browser.dta" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/pattern_operating_system.dta"  ) ) == 100666 ) || ( decoct ( fileperms ( "log/pattern_operating_system.dta"  ) ) == 100660 ) ) { echo '<tr><td>log/pattern_operating_system.dta</td><td>'.file_perms ( "log/pattern_operating_system.dta" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>log/pattern_operating_system.dta</td><td>'.file_perms ( "log/pattern_operating_system.dta" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/pattern_referer.dta"           ) ) == 100666 ) || ( decoct ( fileperms ( "log/pattern_referer.dta"           ) ) == 100660 ) ) { echo '<tr><td>log/pattern_referer.dta</td><td>'.file_perms ( "log/pattern_referer.dta" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>log/pattern_referer.dta</td><td>'.file_perms ( "log/pattern_referer.dta" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/pattern_resolution.dta"        ) ) == 100666 ) || ( decoct ( fileperms ( "log/pattern_resolution.dta"        ) ) == 100660 ) ) { echo '<tr><td>log/pattern_resolution.dta</td><td>'.file_perms ( "log/pattern_resolution.dta" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>log/pattern_resolution.dta</td><td>'.file_perms ( "log/pattern_resolution.dta" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/pattern_site_name.dta"         ) ) == 100666 ) || ( decoct ( fileperms ( "log/pattern_site_name.dta"         ) ) == 100660 ) ) { echo '<tr><td>log/pattern_site_name.dta</td><td>'.file_perms ( "log/pattern_site_name.dta" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>log/pattern_site_name.dta</td><td>'.file_perms ( "log/pattern_site_name.dta" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  if ( ( decoct ( fileperms ( "log/timestamp_cache_update.dta"    ) ) == 100666 ) || ( decoct ( fileperms ( "log/timestamp_cache_update.dta"    ) ) == 100660 ) ) { echo '<tr><td>log/timestamp_cache_update.dta</td><td>'.file_perms ( "log/timestamp_cache_update.dta" ).'</td><td><img src="images/sysinfo_ok.png" style="vertical-align:middle" alt=""></td></tr>'; } else { echo '<tr><td>log/timestamp_cache_update.dta</td><td>'.file_perms ( "log/timestamp_cache_update.dta" ).'</td><td><img src="images/sysinfo_error.png" style="vertical-align:middle" alt=""></td></tr>'; }
  echo '</table>';
 }
elseif ( ( $_POST [ "parameter" ] == "$lang_admin_sc[14]" ) || ( $_POST [ "parameter" ] == "$lang_admin_sc[15]" ) )
 {
  $error_counter = 0;
  //------------------------------------------------------------------------------
  // Message
  if ( $_POST [ "parameter" ] == "$lang_admin_sc[15]" )
   {
    echo '<div style="width:99%; height:28px; margin:4px 0px 10px 0px; border:1px solid #CC0000; padding:2px; background:#F9FBE0; color:#CC0000; text-align:left; font-size:11px;"><img src="images/alert.gif" border="0" style="margin:2px 15px 0px 10px; float:left" alt="" title="">'.$lang_admin_sc[40].'</div>';
   }
  //------------------------------------------------------------------------------
  // check Server operating system + authority
  @error_reporting ( 3 );
  echo $lang_admin_sc[28].': '.php_uname().'<br>'.$lang_admin_sc[29].' config/config.php: ';
  $handle = @fopen ( 'config/config.php' , 'a' );
  if ( $handle ) { fclose ( $handle ); echo '<b><font color="green">'.$lang_admin_sc[30].'</font></b>';} else { echo '<b><font color="#CC0000">'.$lang_admin_sc[31].'</font></b>'; }
  echo '<hr>';
  //------------------------------------------------------------------------------
  // check script_domain
  echo '<b><pre>$script_domain:    '.$script_domain.'</pre></b>'."\n";
  if ( ( substr ( $script_domain , 0 , 7 ) != 'http://' ) && ( substr ( $script_domain , 0 , 8 ) != 'https://' ) ) { display_error ( $lang_admin_sc[33] ); }
  if ( ( ( substr ( $script_domain , 7 ) != $_SERVER [ 'HTTP_HOST' ] ) && ( substr ( $script_domain , 7 ) != 'www.'.$_SERVER [ 'HTTP_HOST' ] ) ) && ( ( substr ( $script_domain , 8 ) != $_SERVER [ 'HTTP_HOST' ] ) && ( substr ( $script_domain , 8 ) != 'www.'.$_SERVER [ 'HTTP_HOST' ] ) ) ) { display_error ( ''.$lang_admin_sc[34].' "<font color="green">'.$_SERVER [ "HTTP_HOST" ].'</font>"' ); }
  if ( substr_count ( $script_domain , '/' ) != 2 ) { display_error ( $lang_admin_sc[35] ); }
  checklink ( $script_domain );
  //------------------------------------------------------------------------------
  // check script_path
  echo '<b><pre>$script_path:      '.$script_path.'</pre></b>'."\n";
  if ( substr ( dirname ( $_SERVER [ 'SCRIPT_NAME' ] ) , 1 ).substr ( dirname ( $_SERVER [ 'SCRIPT_NAME' ] ) , 0 , 1 ) != $script_path ) { display_error ( $lang_admin_sc[36] ); }
  checklink ( $script_domain.'/'.$script_path );
  checklink ( $script_domain.'/'.$script_path."track.php" );
  //------------------------------------------------------------------------------
  // check exception_domain
  echo '<b><pre>$exception_domain: ';print_r ( $exception_domain ); echo '</pre></b>'."\n";
  foreach ( $exception_domain as $value )
   {
    checklink ( $value );
   }
  //------------------------------------------------------------------------------
  // error result
  echo '<center><b><font color="';
  if ( $error_counter == 0 ) { echo 'green'; } else { echo '#CC0000'; }
  echo '">'.$error_counter.' '.$lang_admin_sc[39].'</font></b></center><br>'."\n";
  //------------------------------------------------------------------------------
  // create javascript & image-code
  #A# Script immer ausgeben, execute + Abfrage-/Verarbeitungs-Folge + $exception_ip_address + 2 Befehlstasten
  echo '
  <hr>
  <b>JavaScript & Image-Code</b><br><span style="font-size:12px">
  &lt;script type="text/javascript" src="'.$script_domain.'/'.$script_path.'track.php?mode=js">&lt;/script&gt;<br>
  &lt;noscript&gt;&lt;img src="'.$script_domain.'/'.$script_path.'track.php?mode=img" style="border:none; width:1px; height:1px" alt=""&gt;&lt;/noscript&gt;</span>'."\n";
  //------------------------------------------------------------------------------
  // Logging-Test
  if ( $_POST [ "parameter" ] == "$lang_admin_sc[15]" )
   {
    echo '<hr><b>Logging-Test</b><br><ul>';
    ################################################################################
    ### get ip address ###
    if     ( $get_ip_address == 1 )  { $ip_address = $_SERVER [ "REMOTE_ADDR"            ]; }
    elseif ( $get_ip_address == 2 )  { $ip_address = $_SERVER [ "HTTP_X_REMOTECLIENT_IP" ]; }
    elseif ( $get_ip_address == 3 )  { $ip_address = $_SERVER [ "HTTP_X_FORWARDED_FOR"   ]; }
    elseif ( $get_ip_address == 4 )  { $ip_address = $_SERVER [ "HTTP_CLIENT_IP"         ]; }
    elseif ( $get_ip_address == 5 )  { $ip_address = getenv   ( "REMOTE_ADDR"            ); }
    elseif ( $get_ip_address == 6 )  { $ip_address = getenv   ( "HTTP_X_REMOTECLIENT_IP" ); }
    elseif ( $get_ip_address == 7 )  { $ip_address = getenv   ( "HTTP_X_FORWARDED_FOR"   ); }
    elseif ( $get_ip_address == 8 )  { $ip_address = getenv   ( "HTTP_CLIENT_IP"         ); }
    else   { $ip_address = $_SERVER [ "REMOTE_ADDR" ]; }
    //------------------------------------------------------------------------------
    // check for ip-address exclude
    $exception_ip_address_ok = false;

    for ( $x = 0 ; $x < count ( $exception_ip_addresses ) ; $x++ )
     {
      $ip_pattern = preg_replace( "/\./" , "\." , $exception_ip_addresses [ $x ] );
      $ip_pattern = preg_replace( "/\*/" , ".*" , $ip_pattern );
      if ( preg_match ( "/".$ip_pattern."/" , $ip_address ) ) { $exception_ip_address_ok = true; break; }
     }

    $arrUrl [ "host" ] = strtolower ( $_SERVER [ 'HTTP_HOST' ]);
    $exception_domain_ok = false;

    foreach ( $exception_domain as $value )
     {
      if ( preg_match ( "/\.".strtolower ( $value )."$/",".".$arrUrl [ "host" ] ) ) { $exception_domain_ok=true; break; }
     }

    if ( $exception_ip_address_ok )
     {
      echo '<b><font color="#CC0000">'.$lang_admin_sc[47].'</font></b></center>';
     }
    elseif ( $_COOKIE [ "dontcount" ] )
     {
      echo '<b><font color="#CC0000">'.$lang_admin_sc[48].'</font></b></center>';
     }
    elseif ( ! $exception_domain_ok )
     {
      echo '<b><font color="#CC0000">'.$lang_admin_sc[49].'</font></b></center>';
     }
    else
     {
      echo '
      <script type="text/javascript" src="'.$script_domain.'/'.$script_path.'track.php?mode=js"></script>
      <img src="'.$script_domain.'/'.$script_path.'track.php?mode=img&ref='.$lang_admin_sc[41].' img" border="0" alt="" width="0" height="0">

      <script type="text/javascript">document.write("<font color=\"green\">'.$lang_admin_sc[42].'.</font><br>&nbsp;'.$lang_admin_sc[44].'");</script>
      <noscript><font color="#CC0000">'.$lang_admin_sc[43].'!</font><br>&nbsp;'.$lang_admin_sc[45].'</noscript>
      <br><br>
      <a href="last_hits.php" target="_blank">'.$lang_admin_sc[46].'</a></ul>';

      $_GET [ 'mode' ] = 'img';
      $_GET [ 'ref'  ] = $lang_admin_sc[41].' include';
      $_SERVER [ 'HTTP_REFERER' ] = 'http://'.$_SERVER [ 'HTTP_HOST' ].'syscheck.php?'.$_SERVER [ 'QUERY_STRING' ]; // site_name
      error_reporting ( 0 );
      ob_start();
      include('track.php');
      ob_end_clean();
     }
   }
 }
//------------------------------------------------------------------------------
echo '
</td>
</tr>
</table>
</div>';
//------------------------------------------------------------------------------
include ( "func/html_footer.php" ); // include html footer
//------------------------------------------------------------------------------
?>
