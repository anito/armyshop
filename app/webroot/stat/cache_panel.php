<?php @session_start(); if ( $_SESSION [ "hidden_func" ] != md5_file ( "config/config.php" ) ) { include ( "func/func_error.php" ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.5.x                                                    #
# File-Release-Date:  11/06/25                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2011 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
error_reporting(0);
//------------------------------------------------------------------------------
include ( "config/config.php"    ); // include path to logfile
include ( "".substr ( $language , 0 , strpos ( $language , "." ) )."_admin.php" ); // include language vars
//------------------------------------------------------------------------------
include ( "func/html_header.php" ); // include html header
//------------------------------------------------------------------------------
if ( $_GET [ "parameter" ] == "cache_finished" )
 {
  //--------------------------------  
  echo '
  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="height: 100%; background: #808080;"><tr><td align="center" valign="middle">
  <table width="440" border="0" cellspacing="0" cellpadding="0" style="height: 260px; border:1px solid #000000; background:#EBE8D8; font-size:11px; font-family:Arial;">
  <tr>
    <td height="60" colspan="2" style="background-image: url(images/bg_system.gif); text-align:right; vertical-align:top; padding:10px 20px 0px 0px; color:#436783; font-family:Arial Black; font-size:13px;">Cache Creator</td>
  </tr>
  <tr>
    <td height="150" colspan="2" valign="top" style="padding:15px 20px 20px 20px; border-top:1px solid #737373; color:#000000;">
    '.$lang_admin_cc[9].'
    </td>
  </tr>
  <tr>
    <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; color:#000000;">Creator v2.3</td>
    <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; text-align:right;"><input type="button" onclick="window.close();" value="'.$lang_admin_cc[11].'"></td>
  </tr>
  </table>
  </td></tr></table>
  ';
  exit;
  //--------------------------------
 }
//------------------------------------------------------------------------------
// create cache with iframe of the cache_creator
if ( $_POST [ "hidden_panel" ] )
 {
  if ( $_POST [ "hidden_panel" ] == $_SESSION [ "hidden_panel" ] )
   {
    //--------------------------------
 	$cache_timestamp_file = fopen ( "log/cache_time_stamp.php" , "w+" );
 	fwrite ( $cache_timestamp_file , "<?php ?>" ); // php header + footer
 	fclose ( $cache_timestamp_file );
 	unset  ( $cache_timestamp_file );
 	//--------------------------------
 	$cache_timestamp_file = fopen ( "log/cache_memory_address.php" , "w+" );
 	fwrite ( $cache_timestamp_file , "<?php \$cache_memory_address = \"\";?>" ); // php header + footer
 	fclose ( $cache_timestamp_file );
 	unset  ( $cache_timestamp_file );
 	//--------------------------------
 	$cache_visitors_file = fopen ( "log/cache_visitors.php" , "w+" );
 	fwrite ( $cache_visitors_file , "<?php ?>" ); // php header + footer
 	fclose ( $cache_visitors_file );
 	unset  ( $cache_visitors_file );
 	//-------------------------------- 	
 	echo '
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="height: 100%; background: #808080;"><tr><td align="center" valign="middle">
      <table width="440" border="0" cellspacing="0" cellpadding="0" style="height: 260px; border:1px solid #000000; background:#EBE8D8; font-size:11px; font-family:Arial;">
      <tr>
        <td height="60" colspan="2" style="background-image: url(images/bg_system.gif); text-align:right; vertical-align:bottom;"><iframe src="func/func_load_creator.php?parameter=create_stat_cache" width="8" height="8" name="creator" scrolling="no" marginheight="0" marginwidth="0" frameborder="0"></iframe></td>
      </tr>
      <tr>
        <td height="150" colspan="2" valign="top" style="padding:15px 20px 0px 20px; border-top:1px solid #737373; color:#000000;">
        '.$lang_admin_cc[6].'<br>';
        if ( $db_active == 1 )
         {
          echo '<img src="images/progress_bar.gif" alt="">';
         }
        else
         {
          echo '<iframe name="cache_control" src="func/func_cache_control.php?parameter=cache_panel" style="width:398; height:16;" frameborder="0" scrolling="no">Sorry but your browser does not support iframes</iframe>';
         }
        echo '
        <br><br>
        '.$lang_admin_cc[7].'<br>'.$lang_admin_cc[8].'<br><br>
        <table width="100%" height="26" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="right" style="color:#000000;">&nbsp;</td><td width="200" align="left"><iframe name="timestamp_control" src="func/func_timestamp_control.php?parameter=cache_panel" style="width:200; height:26;" frameborder="0" scrolling="no">Sorry but your browser does not support iframes</iframe></td>
        </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; color:#000000;">Creator v2.3</td>
        <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; text-align:right;">&nbsp;</td>
      </tr>
      </table>
      </td></tr></table>
      ';
      //--------------------------------
    }
   }
  else
   {
    //--------------------------------
    // form to confirm cache creation
    $_SESSION [ "hidden_panel" ] = md5 ( date ( "Yzda" ) );
    echo '
    <form style="margin:0px;" name="admin" action="'.$_SERVER [ "PHP_SELF" ].'" method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="height: 100%; background: #808080;"><tr><td align="center" valign="middle">
    <table width="440" border="0" cellspacing="0" cellpadding="0" style="height: 260px; border:1px solid #000000; background:#EBE8D8; font-size:11px; font-family:Arial;">
    <tr>
      <td height="60" colspan="2" style="background-image: url(images/bg_system.gif); text-align:right; vertical-align:top; padding:10px 20px 0px 0px; color:#436783; font-family:Arial Black; font-size:13px;">Cache Creator</td>
    </tr>
    <tr>
      <td height="150" colspan="2" valign="top" style="padding:15px 20px 20px 20px; border-top:1px solid #737373; color:#000000;">
      '.$lang_admin_cc[1].'<br><br>
      '.$lang_admin_cc[2].'<br><br>
      '.$lang_admin_cc[3].'      
      <input type="hidden" name="hidden_panel" value="'.$_SESSION [ "hidden_panel" ].'">
      </td>
    </tr>
    <tr>
      <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; color:#000000;">Creator v2.3</td>
      <td style="padding:10px 20px 10px 20px; border-top:1px solid #A7A7A7; text-align:right;"><input type="submit" value="'.$lang_admin_cc[4].'"> <input type="button" onclick="window.close();" value="'.$lang_admin_cc[5].'"></td>
    </tr>
    </table>
    </td></tr></table>
    </form>
    ';
    //--------------------------------
   }
//------------------------------------------------------------------------------
include ( "func/html_footer.php" ); // include html footer
//------------------------------------------------------------------------------
?>