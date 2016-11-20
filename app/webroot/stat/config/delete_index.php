<?php @session_start(); if ( $_SESSION [ "hidden_func" ] != md5_file ( "config.php" ) ) { $error_path = "../"; include ( "../func/func_error.php" ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.3.x                                                    #
# File-Release-Date:  10/03/09                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2010 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
include ( "config.php" ); // include path to style
include ( "../".substr ( $language , 0 , strpos ( $language , "." ) )."_admin.php" ); // include language vars
//------------------------------------------------------------------------------
include ( "../func/html_header.php" ); // include html header
//------------------------------------------------------------------------------
if ( $_POST [ "create_index" ] )
 {
  //------------------------------------------------------------------
  // empty the index_days.php
  $logfile = fopen ( "../log/index_days.php" , "w" );
   fwrite ( $logfile , "<?php \$index_days = array ( 0 ); ?>" );
  fclose ( $logfile );
  unset  ( $logfile );
  //------------------------------------------------------------------
  echo '
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="th2 bold center" style="height:34px; padding:2px; color:#CC0000; font-size:18px; border-bottom:1px solid #0D638A;"><img src="../images/alert.gif" border="0" alt="" title="">&nbsp; &nbsp; &nbsp;'.$lang_admin_sr[6].'&nbsp; &nbsp; &nbsp;<img src="../images/alert.gif" border="0" alt="" title=""></td>
  </tr>
  <tr>
    <td class="bg1 warning bold center" style="vertical-align:middle;">'.$lang_admin_ci[6].'</td>
  </tr>
  </table>
  ';
  echo "<script language=\"JavaScript\">top.frames['make_index'].location.href='../func/func_create_index.php'; </script>";
  //------------------------------------------------------------------
 }
else
 {
  //------------------------------------------------------------------
  echo '
  <form style="margin:0px" action="'.$_SERVER [ "PHP_SELF" ].'" method="post">
  <table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td class="th2 bold center" style="height:18px; padding:2px; border-bottom:1px solid #0D638A;">'.$lang_admin_ci[3].'</td>
  </tr>
  <tr>
    <td class="bg1" style="vertical-align:top; padding:5px;">
    '.$lang_admin_ci[4].'
    <input type="hidden" name="create_index" value="create_index">
    </td>
  </tr>
  <tr>
    <td class="th2 center" style="height:24px; padding:2px; border-top:1px solid #0D638A;">
    <input type="submit" style="border:1px solid #7F9DB9; color:#000000; font-family:Verdana,Arial,Sans-Serif; font-size:12px; background-color:#FEFEFE; padding: 1px 10px 1px 10px; width:auto; overflow:visible; cursor:pointer;" value="'.$lang_admin_ci[5].'">
    </td>
  </tr>
  </table>
  </form>
  ';
  //------------------------------------------------------------------
 }
//------------------------------------------------------------------------------
include ( "../func/html_footer.php" ); // include html footer
//------------------------------------------------------------------------------
?>