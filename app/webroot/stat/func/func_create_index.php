<?php @session_start(); if ( $_SESSION [ "hidden_stat" ] != md5_file ( "../config/config.php" ) ) { $error_path = "../"; include ( "../func/func_error.php" ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.3.x                                                    #
# File-Release-Date:  10/02/28                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2010 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
error_reporting(0);
//------------------------------------------------------------------------------
include ( "../config/config.php" ); // check index_creator_namber
//------------------------------------------------------------------------------
$index_counter  = 0;
//------------------------------------------------------------------------------
// html header
echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>PHP Web Stat - Create Index</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
 <meta http-equiv="pragma"  content="no-cache" />
 <meta http-equiv="expires" content="0" />
 <style type="text/css">
  body { margin:0px; font-size: 9px; letter-spacing: 0.3mm; font-family: Arial, Verdana, Sanf Serif; }
  img  { border:none; }
 </style>
</head>
<body>
';
//------------------------------------------------------------------------------
include ( "../log/index_days.php"   );
//------------------------------------------------------------------------------
$log_file = fopen ( "../log/logdb_backup.dta" , "rb" );
fseek ( $log_file , max ( $index_days ) );
 while ( !FEOF ( $log_file ) && ( $index_counter <= $index_creator_number ) )
  {
   //-----------------------------------------------
   $log_file_address = ftell ( $log_file );
   $log_file_entry = fgetcsv ( $log_file , 6000 , "|" );
   $last_address = ftell ( $log_file );
   $index_counter++;
   //-----------------------------------------------
   if ( $log_file_entry [ 0 ] != "" )
    {
     $today = strtotime ( date ( "Y-m-d" , $log_file_entry [ 0 ] )." 0:0:0" );
     if ( !array_key_exists ( $today , $index_days ) ) { $index_days [ $today ]	= $log_file_address; }
    }
   //-----------------------------------------------
  }
fclose ( $log_file ); unset ( $log_file );
//------------------------------------------------------------------------------
$temp_file_counter = 1;
$count_array = count ( $index_days );
$index_file = fopen ( "../log/index_days.php" , "w+" );
 flock ( $index_file , 2 );
 fwrite ( $index_file , "<?php\n\$index_days = array (\n" );
 foreach ( $index_days as $key => $value )
  {
   //-----------------------------------------------
   if ( $temp_file_counter == $count_array ) { fwrite ( $index_file , "\"".$key."\" => \"".$value."\"\n" ); }
   else { fwrite ( $index_file , "\"".$key."\" => \"".$value."\",\n" ); }
   $temp_file_counter++;
 	 //-----------------------------------------------
  }
 fwrite ( $index_file , ");\n?>" );
 flock ( $index_file , 3 );
fclose ( $index_file ); unset ( $index_file );
//------------------------------------------------------------------------------
$percent = ( int ) round ( $last_address / filesize ( "../log/logdb_backup.dta" ) * 100 );
if ( $percent == 100 )
 {
  $reload_time = 180;
  echo '
  <img src="../images/create_index_ready.gif" width="76" height="11" alt="Index Status" title="Index Status" />
  ';
 }
else
 {
  $reload_time = 15;
  echo '
  <table width="76" border="0" cellspacing="0" cellpadding="0">
  <td style="padding:0px; background:#FFFFFF;"><img src="../images/create_index.gif" width="40" height="11" style="vertical-align:top;" alt="Index Status" title="Index Status" /></td>
  <td width="34" align="center" style="padding:0px; vertical-align:top; background:#888D78; color:#FFFFFF;">'.$percent.'%</td>
  </table>
  ';
 }
echo '<meta http-equiv="refresh" content="'.$reload_time.'; URL=func_create_index.php">';
//------------------------------------------------------------------------------
// html footer
echo '
</body>
</html>
';
//------------------------------------------------------------------------------
?>