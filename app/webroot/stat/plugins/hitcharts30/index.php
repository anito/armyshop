<?php
//------------------------------------------------------------------------------
if ( !isset ( $_SERVER [ "PHP_SELF" ] ) || basename ( $_SERVER [ "PHP_SELF" ] ) == basename (__FILE__) ) { $error_path = "../../"; include ( "../../func/func_error.php" ); exit; };
//------------------------------------------------------------------------------
if ( $plugin_security == 1 ) // Security Check
 {
  @session_start(); if ( $_SESSION [ "hidden_stat" ] != md5_file ( "config/config.php" ) ) { include ( "func/func_error.php" ); exit; }
 }
################################################################################
### plugin code ###
include ( "plugins/".$plugin_directory."/google_charts.php" );
//------------------------------------------------------------------------------
// Plugin Language Specific
    if ( $language_plugin_select == "de" ) { }
elseif ( $language_plugin_select == "en" ) { }
elseif ( $language_plugin_select == "nl" ) { }
elseif ( $language_plugin_select == "it" ) { }
elseif ( $language_plugin_select == "sp" ) { }
elseif ( $language_plugin_select == "es" ) { }
elseif ( $language_plugin_select == "fa" ) { }
elseif ( $language_plugin_select == "dk" ) { }
elseif ( $language_plugin_select == "fr" ) { }
elseif ( $language_plugin_select == "tu" ) { }
else { }
//------------------------------------------------------------------------------
include ( "log/index_days.php" );
$last_month = strtotime ( date ( "Y-m-d" , strtotime ( "-30 days" ) )." 0:0:0" );
$hits_per_day = array ();
$logfile = fopen ( "log/logdb_backup.dta" , "r" );
fseek ( $logfile , $index_days [ $last_month ] );
 while ( !FEOF ( $logfile ) )
  {
   $logfile_entry = fgetcsv ( $logfile , 60000 , "|" );
   if ( $logfile_entry [ 0 ] != "" )
    {
     $date_day = date ( "Y-m-d" , $logfile_entry [ 0 ] );
     if ( array_key_exists ( $date_day , $hits_per_day ) ) { $hits_per_day [ $date_day ]++; }
     else { $hits_per_day [ $date_day ] = 1; }
    }
  }
fclose ( $logfile ); unset ( $logfile );
//------------------------------------------------------------------------------
echo '
<table id="content" style="width:100%; border-collapse:collapse; border-spacing:0">
<tr>
  <td style="padding:10px 0px 10px 0px; text-align:center; vertical-align:top">'."\n";

  echo "<b>".$plugin_name."</b><br>";
  google_charts ( $hits_per_day );

  echo '
  </td>
</tr>
</table>
';
################################################################################
?>