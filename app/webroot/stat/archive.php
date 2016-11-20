<?php @session_start(); if ( $_SESSION [ "hidden_stat" ] != md5_file ( "config/config.php" ) ) { include ( "func/func_error.php" ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.5.x                                                    #
# File-Release-Date:  11/09/14                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2011 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
error_reporting(0);
//------------------------------------------------------------------------------
include ( "config/config.php"      ); // include config
include ( $language                ); // include language
include ( "func/func_read_dir.php" ); // include read directory function
include ( "func/html_header.php"   ); // include html header
//------------------------------------------------------------------------------
echo '
<div style="width:438px; height:60px; border:1px solid #000000; border-bottom:1px solid #737373; background: url(images/bg_system.gif); text-align:right; color:#436783; font-family:Arial Black; font-size:13px;">
  <p style="margin:0px; padding:10px 20px 0px 0px;">'.$lang_archive[3].'</p>
</div>
<div style="width:438px; height:150px; border-left:1px solid #000000; border-right:1px solid #000000; background:#EBE8D8; color:#000000; font-family:Arial; font-size:11px">
  <p style="margin:0px; padding:10px 10px 0px 10px;">'.$lang_archive[4].'</p>
  <form action="index.php" method="post"  target="index">
  <p style="margin:0px; padding:10px 10px 0px 10px;">
  <input type="text" name="from_timestamp" id="f_date_a" style="width:150px;" />
  <input type="text" name="until_timestamp" id="f_calcdate" style="width:150px;" />
  <input type="hidden" name="archive" value="1" />
  <input type="submit" onclick="show_archive();" value="'.$lang_archive[5].'" />
  </p>
  </form>
  ';
  $archive_files = read_dir ( "log/archive" );
  asort ( $archive_files );
  echo '
  <p style="margin:0px; padding:15px 10px 0px 10px;">'.$lang_archive[6].'</p>
  <form action="index.php" method="get" target="index">
  <p style="margin:0px; padding:10px 10px 0px 10px;">
  <select name="archive_save" size="1" style="width:220px;">';
  foreach ( $archive_files as $value )
   {
    $temp = substr ( $value , strrpos ( $value , "/" ) + 1 );
    $temp = substr ( $temp , 0 , strlen ($temp ) - 4 );
    $temp = explode ( "-" , $temp );
    echo "<option value=\"".$value."\">".date ( "Y-m-d" , trim ( $temp [ 0 ] ) )." - ".date ( "Y-m-d" , trim ( $temp [ 1 ] )  )."</option>";
   }
  echo '
  </select>
  <input type="hidden" name="parameter" value="finished" />
  <input type="submit" onclick="show_archive();" value="'.$lang_archive[7].'" />
  </p>
  </form>
</div>
<div style="width:438px; height:46px; border:1px solid #000000; border-top:1px solid #A7A7A7; background:#EBE8D8; text-align:right;">
  <p style="margin:0px; padding:10px 20px 0px 0px;"><input type="button" onclick="location.href=\'archive.php\'" value="'.$lang_menue[4].'"></p>
</div>

<script type="text/javascript">
    Calendar.setup({
        inputField     :    "f_date_a",    // id of the input field
        align          :    "cr",          // alignment (defaults to "Bl")
        ifFormat       :    "%d-%m-%Y"     // format of the input field
    });
    Calendar.setup({
        inputField     :    "f_calcdate",  // id of the input field
        align          :    "cl",          // alignment (defaults to "Bl")
        ifFormat       :    "%d-%m-%Y"     // format of the input field
    });
</script>
';
//------------------------------------------------------------------------------
include ( "func/html_footer.php" ); // include html footer
//------------------------------------------------------------------------------
?>