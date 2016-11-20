<?php @session_start(); if ( $_SESSION [ "hidden_func" ] != md5_file ( "config.php" ) ) { $error_path = "../"; include ( "../func/func_error.php" ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.1.x                                                    #
# File-Release-Date:  08/05/09                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2009 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
include ( "config.php" ); // include config
include ( "../".substr ( $language , 0 , strpos ( $language , "." ) )."_admin.php" ); // include language vars
include ( "../func/func_read_dir.php" ); // include read directory function
include ( "../func/html_header.php"   ); // include html header
//------------------------------------------------------------------------------
if ( $_POST [ "archive_delete" ] )
 {
  if ( ( strpos ( $_POST [ "archive_delete" ] , "../log/archive/" ) == 0 ) && ( strpos ( $_POST [ "archive_delete" ]  , ".." , 1 ) === false ) && ( file_exists ( $_POST [ "archive_delete" ] ) ) )
   {
    unlink ( $_POST [ "archive_delete" ] );
   }
 }
//------------------------------------------------------------------------------
$archive_files = read_dir ( "../log/archive" );
asort ( $archive_files );
echo '
<table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0">
<form style="margin:0px" action="'.$_SERVER [ "PHP_SELF" ].'" method="post">
<tr>
  <td colspan="2" class="th2 bold center" style="height:18px; padding:2px; border-bottom:1px solid #0D638A;">'.$lang_admin_dac[3].'</td>
</tr>
<tr>
  <td class="bg2">'.$lang_admin_dac[4].'<br><div class="small">'.$lang_admin_dac[5].'</div></td>
  <td class="bg3">
  <select name="archive_delete" size="1" style="width:250px;">
';
  foreach ( $archive_files as $value )
   {
    $temp = substr ( $value , strrpos ( $value , "/" ) + 1 );
    $temp = substr ( $temp , 0 , strlen ($temp ) - 4 );
    $temp = explode ( "-" , $temp );
    echo "<option value=\"".$value."\">".date ( "Y-m-d" , trim ( $temp [ 0 ] ) )." - ".date ( "Y-m-d" , trim ( $temp [ 1 ] )  )."</option>";
   }
echo '
  </td>
</tr>
<tr>
  <td colspan="2" class="th2 center" style="height:24px; padding:2px; border-top:1px solid #0D638A;">
  <input type="submit" style="border:1px solid #7F9DB9; color:#000000; font-family:Verdana,Arial,Sans-Serif; font-size:12px; background-color:#FEFEFE; padding: 1px 10px 1px 10px; width:auto; overflow:visible; cursor:pointer;" value="'.$lang_admin_dac[6].'">
  </td>
</tr>
</form>
</table>
';
//------------------------------------------------------------------------------
include ( "../func/html_footer.php" ); // include html footer
//------------------------------------------------------------------------------
?>