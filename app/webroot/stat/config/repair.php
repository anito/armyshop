<?php @session_start(); if ( $_SESSION [ "hidden_func" ] != md5_file ( "config.php" ) ) { $error_path = "../"; include ( "../func/func_error.php" ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.3.x                                                    #
# File-Release-Date:  10/03/07                                                 #
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
// css
echo '
<style type="text/css">
body { background: #DFE4E9; }
</style>
';
//------------------------------------------------------------------------------
// html content
if ( $script_activity == 1 )
 {
  echo '
  <table border="0" width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #0D638A;">
  <tr>
    <td class="th2 bold center" style="height:18px; padding:2px; border-bottom:1px solid #0D638A;">'.$lang_admin_lr[4].'</td>
  </tr>
  <tr>
    <td class="bg1 warning bold center" style="vertical-align:middle;"><br>'.$lang_admin_lr[5].'<br><br>'.$lang_admin_lr[6].'<br><br></td>
  </tr>
  </table>';
 }
else
 {
  //------------------------------------------------------------------
  if ( !isset ( $_POST [ "file" ] ) )
   {
    echo '
    <form method="post" action="'.$_SERVER[ "PHP_SELF" ].'">
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #0D638A;">
    <tr>
      <td class="th2 bold center" style="height:18px; padding:2px; border-bottom:1px solid #0D638A;">'.$lang_admin_lr[7].'</td>
    </tr>
    <tr>
      <td class="bg1">
      <table width="100%" border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td class="bg2">'.$lang_admin_lr[8].'</td>
        <td class="bg3">
        <input type="radio" name="file" value="1"> logbdb.dta<br>
        <input type="radio" name="file" value="2"> logbdb_backup.dta<br>
        <input type="radio" name="file" value="3"> pattern_browser.dta<br>
        <input type="radio" name="file" value="4"> pattern_operating_system.dta<br>
        <input type="radio" name="file" value="5"> pattern_referer.dta<br>
        <input type="radio" name="file" value="6"> pattern_resolution.dta<br>
        <input type="radio" name="file" value="7"> pattern_site_name.dta<br>
        <br>
        </td>
      </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td class="th2 center">
      <input type="hidden" name="language" value="'.$language.'">
      <input type="submit" value="'.$lang_admin_lr[9].'" style="cursor:pointer;">
      </td>
    </tr>
    </table>
    </form>
    </body>
    </html>';
    exit;
   }
  //------------------------------------------------------------------
  if ( isset ( $_POST [ "file" ] ) )
   {
    //------------------------------------------------------------------
    // logfile type choose
    $pattern = 0;

    // logfile choose
    if ( $_POST [ "file" ] == 1 ) { $file = "../log/logdb.dta"; }
    if ( $_POST [ "file" ] == 2 ) { $file = "../log/logdb_backup.dta"; }
    if ( $_POST [ "file" ] == 3 ) { $file = "../log/pattern_browser.dta"; $pattern = 1; }
    if ( $_POST [ "file" ] == 4 ) { $file = "../log/pattern_operating_system.dta"; $pattern = 1; }
    if ( $_POST [ "file" ] == 5 ) { $file = "../log/pattern_referer.dta"; $pattern = 1; }
    if ( $_POST [ "file" ] == 6 ) { $file = "../log/pattern_resolution.dta"; $pattern = 1; }
    if ( $_POST [ "file" ] == 7 ) { $file = "../log/pattern_site_name.dta"; $pattern = 1; }

    if ( $_POST [ "file" ] == "../log/logdb.dta" ) { $file = "../log/logdb.dta"; }
    if ( $_POST [ "file" ] == "../log/logdb_backup.dta" ) { $file = "../log/logdb_backup.dta"; }
    if ( $_POST [ "file" ] == "../log/pattern_browser.dta" ) { $file = "../log/pattern_browser.dta"; $pattern = 1; }
    if ( $_POST [ "file" ] == "../log/pattern_operating_system.dta" ) { $file = "../log/pattern_operating_system.dta"; $pattern = 1; }
    if ( $_POST [ "file" ] == "../log/pattern_referer.dta" ) { $file = "../log/pattern_referer.dta"; $pattern = 1; }
    if ( $_POST [ "file" ] == "../log/pattern_resolution.dta" ) { $file = "../log/pattern_resolution.dta"; $pattern = 1; }
    if ( $_POST [ "file" ] == "../log/pattern_site_name.dta" ) { $file = "../log/pattern_site_name.dta"; $pattern = 1; }

    // mode choose
    if ( $_POST [ "mode" ] == "check" ) { $mode = "check"; }
    elseif ( $_POST [ "mode" ] == "repair" ) { $mode = "repair"; }
    else { $mode = "check"; }
    //------------------------------------------------------------------
    if ( file_exists ( $file ) )
     {
      //------------------------------------------------------------------------------
      $write                  = 1;
      $count_errors           = 0;
      $line_number            = 0;
      $number_of_lines        = 0;
      $lines_empty            = array ();
      $lines_delimiters       = array ();
      $lines_double           = array ();
      $lines_timestamp        = array ();
      $lines_timestamp_parts  = array ();
      $pattern_numbers        = array ();
      //------------------------------------------------------------------------------
      $logfile     = fopen ( $file , "r"  );
      $logfile_new = fopen ( "../log/logdb_temp.dta" , "w+" );
      while ( !FEOF ( $logfile ) )
       {
        //------------------------------------------------------------------------------
        $logfile_entry = fgetcsv ( $logfile , 6000 , "|" );
        $line_number++;
        //------------------------------------------------------------------------------
        if ( trim ( implode ( "" , $logfile_entry ) ) == "" )
         {
          $write = 0; $count_errors++; $lines_empty [] = $line_number;
         }
        else
         {
          //------------------------------------------------------------------------------
          if ( $pattern == 1 )
           {
            if ( count ( $logfile_entry ) != 2 ) { $write = 0; $count_errors++; $lines_delimiters [] = $line_number; }
            if ( array_key_exists ( $logfile_entry [ 1 ] , $pattern_numbers ) ) { $write = 0; $count_errors++; $lines_double [] = $line_number; }
            else { $pattern_numbers [ $logfile_entry [ 1 ] ] = 1; }
           }
          else
           {
            if ( count ( $logfile_entry ) != 9 ) { $write = 0; $count_errors++; $lines_delimiters [] = $line_number; }
            if ( $logfile_entry [ 0 ] < $logfile_entry_timestamp ) { $write = 0; $count_errors++; $lines_timestamp [] = $line_number; }
            if ( strlen ( $logfile_entry [ 0 ] ) != 10 ) { $write = 0; $count_errors++; $lines_timestamp_parts [] = $line_number; }
          	}
          //------------------------------------------------------------------------------
         }
        //------------------------------------------------------------------------------
        if ( ( $write == 1 ) && ( $mode == "repair" ) ) { fwrite ( $logfile_new , implode ( "|" , $logfile_entry ) ); }
        if ( ( $write == 1 ) && ( $mode == "repair" ) && ( !FEOF ( $logfile ) ) ) { fwrite ( $logfile_new , "\n" ); }
        //------------------------------------------------------------------------------
        $logfile_entry_timestamp = $logfile_entry [ 0 ];
        $write = 1;
        //------------------------------------------------------------------------------
       }
      fclose ( $logfile     );
      fclose ( $logfile_new );
      //------------------------------------------------------------------------------
      if ( $mode == "repair" ) { copy ( "../log/logdb_temp.dta" , $file ); }
      //------------------------------------------------------------------------------
      if ( $mode == "check" )
       {
       	//------------------------------------------------------------------
       	echo '
        <table class="standard" width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr>
          <td class="th2 bold center">'.$lang_admin_lr[7].'</th>
        </tr>
        <tr>
          <td class="bg1" style="padding: 5px 15px 10px 15px;"><br>';
       	  echo "<center>".$lang_admin_lr[11].": <b>".$file."</b><br><br></center>\n";
       	  echo "<table width=\"400\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" align=\"center\">\n";
          if ( $pattern != 1 ) { unset ( $lines_empty [ 0 ] ); $count_errors = $count_errors - 1; echo "<tr><td style=\"height: 30px; vertical-align: top; text-align: left; border-bottom: 1px solid #000000;\"><b>".$lang_admin_lr[12].":</b></td><td style=\"height: 30px; vertical-align: top; text-align: left; padding-left: 15px; border-bottom: 1px solid #000000;\"><b>".$count_errors."</b></td></tr>\n"; }
       	  else { echo "<tr><td style=\"height: 30px; vertical-align: top; text-align: left; border-bottom: 1px solid #000000;\"><b>".$lang_admin_lr[12].":</b></td><td style=\"height: 30px; vertical-align: top; text-align: left; padding-left: 15px; border-bottom: 1px solid #000000;\"><b>".$count_errors."</b></td></tr>\n"; }
       	  echo "<tr><td style=\"padding-top: 8px;\">".$lang_admin_lr[13].":</td><td style=\"padding-top: 8px; padding-left: 15px;\">".count ( $lines_empty )."</td></tr>\n<tr><td colspan=\"2\" style=\"padding: 5px; background: #E0E0E0;\">"; foreach ( $lines_empty as $value ) { echo $value." "; } echo "</td></tr>\n";
       	  echo "<tr><td>".$lang_admin_lr[14].":</td><td style=\"padding-left: 15px;\">".count ( $lines_delimiters )."</td></tr>\n<tr><td colspan=\"2\" style=\"padding: 5px; background: #E0E0E0;\">"; foreach ( $lines_delimiters as $value ) { echo $value." "; } echo "</td></tr>\n";
          if ( $pattern == 1 ) { echo "<tr><td>".$lang_admin_lr[15].":</td><td style=\"padding-left: 15px;\">".count ( $lines_double )."</td></tr>\n<tr><td colspan=\"2\" style=\"padding: 5px; background: #E0E0E0;\">"; foreach ( $lines_double as $value ) { echo $value." "; } echo "</td></tr>\n"; }
       	  if ( $pattern != 1 ) { echo "<tr><td>".$lang_admin_lr[16].":</td><td style=\"padding-left: 15px;\">".count ( $lines_timestamp )."</td></tr>\n<tr><td colspan=\"2\" style=\"padding: 5px; background: #E0E0E0;\">"; foreach ( $lines_timestamp as $value ) { echo $value." "; } if ( count ( $lines_timestamp ) > 0 ) { echo "<div class=\"warning\" style=\"border: 1px solid #CC0000; margin-top: 5px; padding: 3px; font-size: 9px;\">".$lang_admin_lr[18]."</div>"; } echo "</td></tr>\n"; }
       	  if ( $pattern != 1 ) { echo "<tr><td>".$lang_admin_lr[17].":</td><td style=\"padding-left: 15px;\">".count ( $lines_timestamp_parts )."</td></tr>\n<tr><td colspan=\"2\" style=\"padding: 5px; background: #E0E0E0;\">"; foreach ( $lines_timestamp_parts as $value ) { echo $value." "; } echo "</td></tr>\n"; }
          echo "</table>\n";
          echo "<br>\n";
       	  echo '
       	  </td>
        </tr>';
        //------------------------------------------------------------------
       	if ( ( $count_errors ) > 0 )
       	 {
       	  echo '
       	  <tr>
            <td class="th2 center">
  			    <form method="post" action="'.$_SERVER[ "PHP_SELF" ].'">
  			     <input type="hidden" name="file" value="'.$file.'">
  			     <input type="hidden" name="mode" value="repair">
  			     <input type="hidden" name="language" value="'.$language.'">
  			     <input type="submit" value="'.$lang_admin_lr[19].'" style="cursor:pointer;" />
  			    </form>
  			    <form method="post" action="'.$_SERVER[ "PHP_SELF" ].'">
  			     <input type="hidden" name="mode" value="check">
  			     <input type="hidden" name="language" value="'.$language.'">
  			     <input type="submit" value="'.$lang_admin_lr[20].'" style="cursor:pointer;" />
  			    </form>
            </td>
          </tr>
          </table>
          </body>
          </html>';
          exit;
       	 }
       	else
       	 {
       	  echo '
       	  <tr>
            <td class="th2 center">
  			    <form method="post" action="'.$_SERVER[ "PHP_SELF" ].'">
  			     <input type="hidden" name="mode" value="check">
  			     <input type="hidden" name="language" value="'.$language.'">
  			     <input type="submit" value="'.$lang_admin_lr[20].'" style="cursor:pointer;" />
  			    </form>
            </td>
          </tr>';
       	 }
       	//------------------------------------------------------------------
       }
      else
       {
       	//------------------------------------------------------------------
       	echo '
       	<table class="standard" width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr>
          <td class="bg1"  style="padding: 5px 15px 10px 15px;">
          <img src="../images/admin/done.png" border="0" width="32" height="32" style="vertical-align:middle; margin:5px 15px 5px 0px;" alt=""> <b>'.$lang_admin_lr[21].'</b><br><br>
          '.$lang_admin_lr[22].'<br><br>
          </td>
        </tr>
        <tr>
          <td class="th2 center">
          <form method="post" action="'.$_SERVER[ "PHP_SELF" ].'">
  			  <input type="hidden" name="mode" value="check">
  			  <input type="hidden" name="language" value="'.$language.'">
  			  <input type="submit" value="'.$lang_admin_lr[20].'" style="cursor:pointer;" />
  			  </form>
  			  </td>
        </tr>';
       	//------------------------------------------------------------------
       }
      //------------------------------------------------------------------------------
     }
    else
     {
      echo '
      <table class="standard" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td class="bg1"  style="padding: 5px 15px 10px 15px;">
        <img src="images/admin/error.png" border="0" width="32" height="32" style="vertical-align:middle; margin:5px 15px 5px 0px;" alt=""> <b>'.$lang_admin_lr[23].'</b><br><br>
        </td>
      </tr>
      <tr>
        <td class="th2 center">
        <form method="post" action="'.$_SERVER[ "PHP_SELF" ].'">
  		  <input type="hidden" name="mode" value="check">
  		  <input type="hidden" name="language" value="'.$language.'">
  		  <input type="submit" value="'.$lang_admin_lr[20].'" style="cursor:pointer;" />
  		  </form>
  		  </td>
      </tr>';
     }
    //------------------------------------------------------------------------------
   }
  //------------------------------------------------------------------------------
 }
//------------------------------------------------------------------------------
// html footer
echo '</table>';
//-------------------------------------------------------------------------------
include ( "../func/html_footer.php" ); // include html footer
//-------------------------------------------------------------------------------
?>