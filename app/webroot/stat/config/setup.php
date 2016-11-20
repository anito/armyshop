<?php @session_start();
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
error_reporting(0);
//------------------------------------------------------------------------------
##### !!! never change this value !!! #####
$stat_version = file ( "../index.php" ); // include stat version
eval ( $stat_version [ 32 ] );
eval ( $stat_version [ 33 ] );
//------------------------------------------------------------------------------
/* Filter $_GET and $_POST Vars */
function array_map_R ( $func , $arr )
 {
	if ( is_array ( $arr ) )
	 {
    $newArr = array();
    foreach ( $arr as $key => $value )
     {
      $newArr [ $key ] = ( is_array ( $value ) ? array_map_R ( $func , $value ) : $func ( $value ) );
     }
    return $newArr;
   }
  else
   {
    return $func ( $arr );
   }
 }

$_POST = array_map_R ( 'strip_tags' , $_POST );
$_GET  = array_map_R ( 'strip_tags' , $_GET  );

if ( !get_magic_quotes_gpc() )
 {
	$_POST = array_map_R ( 'addslashes' , $_POST );
	$_GET  = array_map_R ( 'addslashes' , $_GET  );
	#$_POST = array_map_R ( 'mysql_real_escape_string' , $_POST );
	#$_GET  = array_map_R ( 'mysql_real_escape_string' , $_GET  );
 }
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
include ( 'config.php'             ); // include adminpassword
include ( '../func/func_crypt.php' ); // include password comparison function
//------------------------------------------------------------------------------
if ( ( !isset ( $_SESSION [ 'hidden_admin' ] ) ) && ( passCrypt ( $_POST [ 'password' ] ) != $adminpassword ) && ( md5 ( $_POST [ 'password' ] ) != md5 ( $adminpassword ) ) )
 {
  //------------------------------------------------------------------------------
  /* login */
  include ( "../func/html_header.php" ); // include html header
  echo '
  <form name="login" action="setup.php" method="post">
  <table id="login" cellspacing="0" cellpadding="0">
  <tr><td class="li_td1">&nbsp;</td></tr>
  <tr><td class="li_td2">'.$lang_login[1].'</td></tr>
  <tr><td class="li_td3"></td></tr>
  <tr>
    <td class="li_td4">
    '.$lang_login[2].'
    <table border="0" cellspacing="0" cellpadding="0" align="center" style="color:#000000;">
    <tr><td style="height:50px; padding-right:20px;">'.$lang_login[3].'</td><td style="height:50px;"><input class="pw" type="password" name="password" /></td></tr>
    <tr><td>&nbsp;</td><td><input style="cursor:pointer;" type="submit" name="login" value="'.$lang_login[4].'"> <input style="cursor:pointer;" type="button" onclick="window.close()" value="'.$lang_login[5].'" /><input type="hidden" name="lang" value="'.$lang.'" /><input type="hidden" name="step" value="check_chmod" /></td></tr>
    </table>
    </td>
  </tr>
  <tr><td class="li_td5">Copyright &copy; 2015 PHP Web Stat &nbsp;&middot;&nbsp; Version '.$version_number.$revision_number.'</td></tr>
  </table>
  </form>
  </body>
  </html>
  ';
  exit;
  //------------------------------------------------------------------------------
 }
else
 {
  //------------------------------------------------------------------------------
  /* if login successful */
  $_SESSION [ "hidden_admin" ] = md5 ( time ( ) );
  $_SESSION [ "hidden_func"  ] = md5_file ( "config.php" );
  $_SESSION [ "hidden_stat"  ] = md5_file ( "config.php" );
  //------------------------------------------------------------------------------
  echo '
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 transitional//EN">
  <html>
  <head>
   <title>PHP Web Stat - Setup</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
   <meta http-equiv="pragma" content="no-cache">
   <meta http-equiv="expires" content="0">
   <link rel="stylesheet" type="text/css" href="../themes/setup.css" media="screen, projection">
   <script language="JavaScript" type="text/javascript">
    function db_transfer(){
     myleft=(screen.width)?(screen.width-470)/2:100;mytop=(screen.height)?(screen.height-320)/2:100;
     settings="width=440,height=260,top=" + mytop + ",left=" + myleft + ",scrollbars=no,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=no,dependent=yes";
     win=window.open("db_transfer.php?lang='.$lang.'","import",settings);
     win.focus();
    }
   </script>
  </head>
  <body style="background: #70B1D1 url(../themes/standard/bg_body.gif) repeat-x;">
  <table id="groundtable" border="0" width="960" cellspacing="0" cellpadding="0" align="center"><tr><td>
  <table id="header" border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="140" align="center" valign="middle"><a href="http://www.php-web-statistik.de" target="_blank"><img src="../images/system.png" width="104" height="50" alt="PHP Web Stat" title="PHP Web Stat"></a></td>
    <td width="150" align="left" valign="middle"><span style="font-size:16px; font-family:Arial Black;">PHP Web Stat</span><br><span style="font-size:11px;"><b>Version '.$version_number.$revision_number.'</b></span></td>
    <td align="center" style="font-size:20px; font-family:Arial Black;">'.$lang_setup[1].'</td>
    <td width="140" align="center" valign="middle">&nbsp;</td>
  </tr>
  </table><br>
  <table id="content" border="0" width="100%" cellspacing="0" cellpadding="5">
  <tr>
    <td valign="top">';
  //------------------------------------------------------------------------------
  if ( $_GET [ "step" ] != "admincenter_database" )
   {
    if ( ( $_POST [ "step" ] == "check_chmod" )  || ( !$_POST [ "step" ] ) )
     {
      // check chmod
      echo '
      <form action="setup.php" method="post">
      <table class="standard" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th>'.$lang_setup[2].'</th>
      <tr>
        <td class="bg1" style="padding: 4px;">'.$lang_setup[3].'</td>
      </tr>
      </table>
      <br>
      <table class="standard" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td class="th2 bold center">'.$lang_chmod[1].'</th>
      </tr>
      <tr>
        <td class="bg1"  style="padding: 5px 15px 10px 15px;">';
        if (
            // config folder
            ( ( decoct ( fileperms ( "config.php"                ) ) == 100666 ) || ( decoct ( fileperms ( "config.php"                ) ) == 100660 ) ) &&
            ( ( decoct ( fileperms ( "config_db.php"             ) ) == 100666 ) || ( decoct ( fileperms ( "config_db.php"             ) ) == 100660 ) ) &&
            // log folder
            ( ( decoct ( fileperms ( "../log/"                   ) ) == 40777  ) || ( decoct ( fileperms ( "../log/" ) ) == 40775 ) || ( decoct ( fileperms ( "../log/" ) ) == 40770 ) ) &&
            ( ( decoct ( fileperms ( "../log/cache_visitors.php" ) ) == 100666 ) || ( decoct ( fileperms ( "../log/cache_visitors.php" ) ) == 100660 ) ) &&
            ( ( decoct ( fileperms ( "../log/logdb.dta"          ) ) == 100666 ) || ( decoct ( fileperms ( "../log/logdb.dta"          ) ) == 100660 ) ) &&
            ( ( decoct ( fileperms ( "../log/logdb_backup.dta"   ) ) == 100666 ) || ( decoct ( fileperms ( "../log/logdb_backup.dta"   ) ) == 100660 ) )
           )
         {
          echo '
            <img src="../images/admin/done.png" border="0" width="32" height="32" style="vertical-align:middle; margin:5px 15px 5px 0px;" alt=""> <b>'.$lang_chmod[2].'</b><br><br>
            '.$lang_chmod[3].' '.$lang_chmod[4].'<br><br>
            </td>
          </tr>
          <tr>
            <td class="th2 center">
            <input type="hidden" name="lang" value="'.$lang.'">
            <input type="hidden" name="step" value="choose">
            <input type="hidden" name="hidden_admin" value="'.$_SESSION [ "hidden_admin" ].'">
            <input type="submit" class="submit" value="'.$lang_footer[1].'"></td>
          </tr>';
         }
        else
         {
          echo '
            <img src="../images/admin/error.png" border="0" width="32" height="32" style="vertical-align:middle; margin:5px 15px 5px 0px;" alt=""><b><font color="#FF0000">'.$lang_chmod[5].'</font></b><br><br>
            '.$lang_chmod[6].'<br><br>'.$lang_chmod[7].'<br><br>'.$lang_chmod[8].'<br><br>
            </td>
          </tr>
          <tr>
            <td class="th2 center">
            <a style="text-decoration:none;" href="'.$_SERVER[ "PHP_SELF" ].'?lang='.$lang.'"><input type="button" value="'.$lang_footer[2].'"></a>
            <input type="hidden" name="lang" value="'.$lang.'">
            <input type="hidden" name="step" value="choose">
            <input type="hidden" name="hidden_admin" value="'.$_SESSION [ "hidden_admin" ].'">
            <input type="submit" class="submit" value="'.$lang_footer[1].'"></td>
          </tr>';
         }
      echo '
      </table>
      </form>';
     }
   }
  //------------------------------------------------------------------------------
  if ( $_POST [ "step" ] == "choose" )
   {
    // choose
    echo '
    <form action="setup.php" method="post">
    <table class="standard" width="100%" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td class="th2 bold center">'.$lang_choose[1].'</th>
    </tr>
    <tr>
      <td class="bg1">
      <table width="100%" border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td class="bg2">'.$lang_choose[2].'<br><div class="small">'.$lang_choose[3].'<br><br>'.$lang_choose[4].'<br><br>'.$lang_choose[5].'<br><br></div></td>
        <td class="bg3">
        <select name="step" size="1" style="width: 250px;">
         <option value="admincenter_textfile">'.$lang_choose[6].'</option>
         <option value="connection">'.$lang_choose[7].'</option>
        </select>
        <input type="hidden" name="lang" value="'.$lang.'">
        <input type="hidden" name="hidden_admin" value="'.$_SESSION [ "hidden_admin" ].'">
        </td>
      </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td class="th2 center"><input type="submit" class="submit" value="'.$lang_footer[1].'"></td>
    </tr>
    </table>
    </form>';
   }
  //------------------------------------------------------------------------------
  if ( $_POST [ "step" ] == "admincenter_textfile" )
   {
    $counter = 0;
    $file_save = file ( "config.php" );
    $config_file = fopen ( "config.php" , "w+" );
     foreach ( $file_save as $key => $value )
      {
       if ( $counter == 4 )
        {
         fwrite ( $config_file , " \$db_active                   = 0;\n" );
        }
       else
        {
         fwrite ( $config_file , $value );
        }
       $counter++;
      }
    fclose ( $config_file );

    // goadmin
    echo '
    <img src="../images/admin/done.png" border="0" width="32" height="32" style="vertical-align:middle; margin:5px 15px 5px 0px;" alt=""><b>'.$lang_goadmin[1].'</b><br><br>
    '.$lang_goadmin[2].'<br><br>'.$lang_goadmin[3].'<br><br><br>
    <center><input type="button" onclick="location.href=\'admin.php?action=settings&lang='.$lang.'\'" value="'.$lang_footer[1].'"></center>';
   }
  //------------------------------------------------------------------------------
  if ( $_GET [ "step" ] == "admincenter_database" )
   {
    // goadmin
    echo '
    <img src="../images/admin/done.png" border="0" width="32" height="32" style="vertical-align:middle; margin:5px 15px 5px 0px;" alt=""><b>'.$lang_goadmin[1].'</b><br><br>
    '.$lang_goadmin[2].'<br><br>'.$lang_goadmin[3].'<br><br><br>
    <center><input type="button" onclick="location.href=\'admin.php?action=settings&lang='.$lang.'\'" value="'.$lang_footer[1].'"></center>';
   }
  //------------------------------------------------------------------------------
  if  ( ( $_POST [ "step" ] == "connection" ) || ( $_POST [ "step" ] == "connection_save" ) )
   {
    if ( $_POST [ "step" ] == "connection_save" )
     {
      $config_file_db = fopen ( "config_db.php" , "w+" );
       flock  ( $config_file_db , 2 );
        fwrite ( $config_file_db , "<?php\n" );

        fwrite ( $config_file_db , "\n/* database connection */\n" );
        fwrite ( $config_file_db , " \$db_host     = \"".$_POST [ "db_host" ]."\";\n" );
        fwrite ( $config_file_db , " \$db_name     = \"".$_POST [ "db_name" ]."\";\n" );
        fwrite ( $config_file_db , " \$db_user     = \"".$_POST [ "db_user" ]."\";\n" );
        fwrite ( $config_file_db , " \$db_password = \"".$_POST [ "db_password" ]."\";\n" );

        fwrite ( $config_file_db , "\n/* database settings */\n" );
        fwrite ( $config_file_db , " \$db_prefix   = \"".$_POST [ "db_prefix" ]."\";\n" );

        fwrite ( $config_file_db , "\n?>" );
       flock  ( $config_file_db , 3 );
      fclose ( $config_file_db );
     }
    // ---------------------------------------------------------------------------
    // connection
    include ( "config_db.php" );
    echo '
    <form name="db_connection" action="setup.php" method="post">
    <table class="standard" width="100%" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td class="th2 bold center">'.$lang_db_connect[2].'</td>
    </tr>
    <tr>
      <td class="bg1">
      <table width="100%" border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td class="bg2">'.$lang_db_connect[3].'<br><div class="small">'.$lang_db_connect[4].'</div></td>
        <td class="bg3"><input type="text" name="db_host" size="40" value="'.$db_host.'" style="width:95%;"></td>
      </tr>
      <tr>
        <td class="bg2">'.$lang_db_connect[5].'<br><div class="small">'.$lang_db_connect[6].'</div></td>
        <td class="bg3"><input type="text" name="db_name" size="40" value="'.$db_name.'" style="width:95%;"></td>
      </tr>
      <tr>
        <td class="bg2">'.$lang_db_connect[7].'<br><div class="small">'.$lang_db_connect[8].'</div></td>
        <td class="bg3"><input type="text" name="db_user" size="40" value="'.$db_user.'" style="width:95%;"></td>
      </tr>
      <tr>
        <td class="bg2">'.$lang_db_connect[9].'<br><div class="small">'.$lang_db_connect[10].'</div></td>
        <td class="bg3"><input type="password" name="db_password" size="40" value="'.$db_password.'" style="width:95%;"></td>
      </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td class="th2 bold center">'.$lang_db_connect[1].'</td>
    </tr>
    <tr>
      <td class="bg1">
      <table width="100%" border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td class="bg2">'.$lang_db_prefix[1].'<br><div class="small">'.$lang_db_prefix[2].'<br><br></div></td>
        <td class="bg3"><input type="text" name="db_prefix" size="40" value="'.$db_prefix.'" style="width:95%;"></td>
      </tr>';
      // -------------------------------------------------------------------------
      /* check to exists the db_tables */
      $connection_error = 1;
      function db_query ( $query, $switch, $cancel )
       {
        //------------------------------
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
        //------------------------------
        if ( $mysqli == 1 )
         {
          //------------------------------
          $db_connection = mysqli_connect ( $db_host , $db_user , $db_password , $db_name );
          //------------------------------
          if ( !$db_connection )
           {
            if ( $cancel == 1 ) { echo '<script language="JavaScript"> location.replace(\''.$_SERVER ["PHP_SELF"].'\'); </script>'; }
            else { $db_error = mysqli_error(); $GLOBALS [ "connection_error" ] = 5; }
           }
          //------------------------------
          if ( mysqli_connect_errno ( $db_connection ) )
           {
     	      if ( $cancel == 1 ) { echo '<meta http-equiv="refresh" content="5; URL='.$_SERVER ["PHP_SELF"].'\">'; }
   	        else { $db_error = mysqli_error(); $GLOBALS [ "connection_error" ] = 5; }
           }
          //------------------------------
          $query_result = mysqli_query ( $db_connection , $query );
          //------------------------------
          if ( !$query_result ) { $db_error = mysqli_error(); $GLOBALS [ "connection_error" ] = 5; }
          //------------------------------
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
          //------------------------------
          mysqli_close( $db_connection );
          return $db_entries;
          //------------------------------
         }
        else
         {
          //------------------------------
          $db_connection = mysql_pconnect ( $db_host , $db_user , $db_password );
          //------------------------------
          if ( !$db_connection )
           {
            if ( $cancel == 1 ) { echo '<script language="JavaScript"> location.replace(\''.$_SERVER ["PHP_SELF"].'\'); </script>'; }
            else { $db_error = mysql_error(); $GLOBALS [ "connection_error" ] = 5; }
           }
          //------------------------------
          // This function was used to check for upcoming errors. This is not more needed.
	        // Also this code lead to some access denied notices in some stats.
          // if ( !mysql_select_db ( $db_name , $db_connection ) ) { $db_error = mysql_error(); $GLOBALS [ "connection_error" ] = 5; }
          //------------------------------
          $query_result = mysql_query ( $query , $db_connection );
          //------------------------------
          if ( !$query_result ) { $db_error = mysql_error(); $GLOBALS [ "connection_error" ] = 5; }
          //------------------------------
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
          //------------------------------
          mysql_close( $db_connection );
          return $db_entries;
         }
        //------------------------------
       }
      // -------------------------------------------------------------------------
      if ( $_POST [ "step" ] == "connection_save" )
       {
        $query        = "SHOW TABLES LIKE '".$db_prefix."_main'";
        $result       = db_query ( $query , 1 , 0 );
        $table_exists = count ( $result );

        if ( $connection_error == 5 )
         { }
        else
         {
          if ( $table_exists == 0 )
           {
            echo '<tr><td colspan="2" class="bg2 warning" style="height:130px; padding:10px 20px 10px 20px;"><img src="../images/alert.gif" border="0" alt="" style="margin:0px 20px 0px 0px;"><font size="2"><b>'.$lang_db_prefix[3].'</b></font><br><br>'.$lang_db_prefix[4].'<br><br><center><input type="button" onclick="db_transfer();" value="'.$lang_db_prefix[5].'"></center></td></tr>';
           }
         }
       }
      // -------------------------------------------------------------------------
      echo '
      </table>
      </td>
    </tr>';
    // ---------------------------------------------------------------------------
    if ( $_POST [ "step" ] == "connection_save" )
     {
      $counter = 0;
      $file_save = file ( "config.php" );
      $config_file = fopen ( "config.php" , "w+" );
       foreach ( $file_save as $key => $value )
        {
         if ( $counter == 4 )
          {
           fwrite ( $config_file , " \$db_active                   = 1;\n" );
          }
         else
          {
           fwrite ( $config_file , $value );
          }
         $counter++;
        }
      fclose ( $config_file );
      if ( $connection_error == 5 )
       {
        echo'
        <tr>
        <td class="th2 warning" style="padding: 5px 15px 10px 15px;">
        <img src="../images/admin/error.png" border="0" width="32" height="32" style="vertical-align:middle; margin:5px 15px 5px 0px;" alt=""><b>'.$lang_db_connect[13].'</b><br><br>
        '.$lang_db_connect[14].'
        </td>
        </tr>
        <tr>
        <td class="th2 center">
        <input type="hidden" name="step" value="connection_save">
        <input type="hidden" name="lang" value="'.$lang.'">
        <input type="hidden" name="hidden_admin" value="'.$_SESSION [ "hidden_admin" ].'">
        <input type="submit" class="submit" value="'.$lang_db_connect[12].'">
        </td>
        </tr>';
       }
      else
       {
        if ( $table_exists == 1 )
         {
          echo '
          <tr>
          <td class="th2 center">
          <div style="color:red;"><b>'.$lang_db_connect[11].'</b></div><br>
          <input type="hidden" name="step" value="admincenter_database">
          <input type="hidden" name="lang" value="'.$lang.'">
          <input type="hidden" name="hidden_admin" value="'.$_SESSION [ "hidden_admin" ].'">
          <input type="button" class="button" onclick="location.href=\'setup.php?step=admincenter_database&lang='.$lang.'\'" value="'.$lang_footer[1].'">
          </td>
          </tr>';
         }
       }
     }
    else
     {
      echo '
      <tr>
      <td class="th2 center">
      <input type="hidden" name="step" value="connection_save">
      <input type="hidden" name="lang" value="'.$lang.'">
      <input type="hidden" name="hidden_admin" value="'.$_SESSION [ "hidden_admin" ].'">
      <input type="submit" class="submit" value="'.$lang_db_connect[12].'">
      </td>
      </tr>';
     }
    // ---------------------------------------------------------------------------
      echo '
    </table>
    </form>';
   }
  //------------------------------------------------------------------------------
    echo '
    </td>
  </tr>
  </table>
  <table id="footer" border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle">Copyright &copy; 2015 <a href="http://www.php-web-statistik.de" target="_blank">PHP Web Stat</a></td>
  </tr>
  </table>
  </td></tr></table>';
 }
//------------------------------------------------------------------------------
include ( "../func/html_footer.php" ); // include html footer
//------------------------------------------------------------------------------
?>
