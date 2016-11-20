<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.9.x                                                    #
# File-Release-Date:  15/02/02                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2015 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
include ( 'config/config.php'   ); // include path to logfile
include ( 'func/func_crypt.php' ); // include password comparison function
//------------------------------------------------------------------------------
$strLanguageFile = "";
if ( isset( $_REQUEST [ "language" ] ) )
 {
  switch ( $_REQUEST [ "language" ] )
   {
    case "de": $strLanguageFile = "language/german.php";     $lang = "de"; break;
    case "en": $strLanguageFile = "language/english.php";    $lang = "en"; break;
    case "nl": $strLanguageFile = "language/dutch.php";      $lang = "nl"; break;
    case "it": $strLanguageFile = "language/italian.php";    $lang = "it"; break;
    case "es": $strLanguageFile = "language/spanish.php";    $lang = "es"; break;
    case "dk": $strLanguageFile = "language/danish.php";     $lang = "dk"; break;
    case "fr": $strLanguageFile = "language/french.php";     $lang = "fr"; break;
    case "tr": $strLanguageFile = "language/turkish.php";    $lang = "tr"; break;
    case "hu": $strLanguageFile = "language/hungarian.php";  $lang = "hu"; break;
    case "pt": $strLanguageFile = "language/portuguese.php"; $lang = "pt"; break;
    case "he": $strLanguageFile = "language/hebrew.php";     $lang = "he"; break;
    case "ru": $strLanguageFile = "language/russian.php";    $lang = "ru"; break;
    case "rs": $strLanguageFile = "language/serbian.php";    $lang = "rs"; break;
    case "fi": $strLanguageFile = "language/finnish.php";    $lang = "fi"; break;
    default:   $strLanguageFile = $language;  // include language vars from config file
  }
}
//-------------------------------
if ( file_exists ( $strLanguageFile ) )
 {
  include ( $strLanguageFile );
 }
else
 {
  include ( $language ); // include language vars from config file
 }
//------------------------------------------------------------------------------
$stat_version = file("index.php"); // include stat version
eval($stat_version[32]);
eval($stat_version[33]);
//------------------------------------------------------------------------------
// opt-out style
if ( isset ( $_REQUEST ['bgcolor'   ] ) ) { $bgcolor    = '#'.$_REQUEST ['bgcolor'   ];  } else { $bgcolor    = 'transparent'; }
if ( isset ( $_REQUEST ['color'     ] ) ) { $color      = '#'.$_REQUEST ['color'     ];  } else { $color      = '#000000';     }
if ( isset ( $_REQUEST ['fontsize'  ] ) ) { $fontsize   = $_REQUEST ['fontsize'  ].'px'; } else { $fontsize   = '12px';        }
if ( isset ( $_REQUEST ['stylesheet'] ) )
 {
  $stylesheet = "\n <link rel=\"stylesheet\" type=\"text/css\" href=\"".$_REQUEST ['stylesheet']."\" media=\"screen, projection\">";
 }
//------------------------------------------------------------------------------
// html header for opt-out
$html_header = '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>PHP Web Statistik '.$version_number.$revision_number.'</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <style type="text/css">
  body      { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: '.$fontsize.'; background-color: '.$bgcolor.'; color: '.$color.' }
  a, a:active      { color: '.$color.'; text-decoration: none }
  a:hover, a:focus { color: '.$color.'; text-decoration: underline; outline: 0 }
  .pagelink:link, .pagelink:active { color: '.$color.'; text-decoration: none }
  .pagelink:hover, .pagelink:focus { color: '.$color.'; text-decoration: underline; outline: 0 }
 </style>'.$stylesheet.'
</head>
<body>
';
//------------------------------------------------------------------------------
if ( isset ( $_GET ['action'] ) && $_GET ['action'] == 'opt-out' )
 {
  if ( isset ( $_POST ['setcookie'] ) )
   {
    if ( $_COOKIE ['dontcount'] != 'ja' )
     {
      setcookie ( 'dontcount', 'ja', time()+3600*24*365*5 , '/' );
      echo $html_header;
      echo $lang_setcookie[9].'<br><br>';
      echo '
      <form method="post" action="'.$_SERVER ["PHP_SELF"].'?action=opt-out">
       <input type="hidden" name="setcookie" value="1">';
       if ( isset ( $_REQUEST ['bgcolor'   ] ) ) { echo '<input type="hidden" name="bgcolor" value="'.substr ( $_REQUEST ['bgcolor'   ], 1, 6 ).'">'; }
       if ( isset ( $_REQUEST ['color'     ] ) ) { echo '<input type="hidden" name="color" value="'.substr ( $_REQUEST ['color'     ], 1, 6 ).'">'; }
       if ( isset ( $_REQUEST ['fontsize'  ] ) ) { echo '<input type="hidden" name="fontsize" value="'.substr ( $_REQUEST ['fontsize'  ], 0, 2 ).'">'; }
       if ( isset ( $_REQUEST ['language'  ] ) ) { echo '<input type="hidden" name="language" value="'.$_REQUEST ['language'  ].'">'; }
       if ( isset ( $_REQUEST ['stylesheet'] ) ) { echo '<input type="hidden" name="stylesheet" value="'.substr ( $_REQUEST ['stylesheet'], 47, -29 ).'">'; }
       echo '
       <input type="checkbox" id="stat-track" name="stat-track" onclick="this.form.submit()">
       <label for="stat-track"><b>'.$lang_setcookie[10].'</b></label>
      </form>
      </body>
      </html>';
     }
    else
     {
      setcookie ( 'dontcount', $_COOKIE ['dontcount'], time()-3600*24*365*5 , '/' );
      echo $html_header;
      echo $lang_setcookie[7].'<br><br>';
      echo '
      <form method="post" action="'.$_SERVER ["PHP_SELF"].'?action=opt-out">
       <input type="hidden" name="setcookie" value="0">';
       if ( isset ( $_REQUEST ['bgcolor'   ] ) ) { echo '<input type="hidden" name="bgcolor" value="'.substr ( $_REQUEST ['bgcolor'   ], 1, 6 ).'">'; }
       if ( isset ( $_REQUEST ['color'     ] ) ) { echo '<input type="hidden" name="color" value="'.substr ( $_REQUEST ['color'     ], 1, 6 ).'">'; }
       if ( isset ( $_REQUEST ['fontsize'  ] ) ) { echo '<input type="hidden" name="fontsize" value="'.substr ( $_REQUEST ['fontsize'  ], 0, 2 ).'">'; }
       if ( isset ( $_REQUEST ['language'  ] ) ) { echo '<input type="hidden" name="language" value="'.$_REQUEST ['language'  ].'">'; }
       if ( isset ( $_REQUEST ['stylesheet'] ) ) { echo '<input type="hidden" name="stylesheet" value="'.substr ( $_REQUEST ['stylesheet'], 47, -29 ).'">'; }
       echo '
       <input type="checkbox" id="stat-track" name="stat-track" onclick="this.form.submit()" checked="checked">
       <label for="stat-track"><b>'.$lang_setcookie[8].'</b></label>
      </form>
      </body>
      </html>';
     }
   }
  else
   {
    if ( $_COOKIE ['dontcount'] != 'ja' )
     {
      echo $html_header;
      echo $lang_setcookie[7].'<br><br>';
      echo '
      <form method="post" action="'.$_SERVER ["PHP_SELF"].'?action=opt-out">
       <input type="hidden" name="setcookie" value="0">';
       if ( isset ( $_REQUEST ['bgcolor'   ] ) ) { echo '<input type="hidden" name="bgcolor" value="'.substr ( $_REQUEST ['bgcolor'   ], 1, 6 ).'">'; }
       if ( isset ( $_REQUEST ['color'     ] ) ) { echo '<input type="hidden" name="color" value="'.substr ( $_REQUEST ['color'     ], 1, 6 ).'">'; }
       if ( isset ( $_REQUEST ['fontsize'  ] ) ) { echo '<input type="hidden" name="fontsize" value="'.substr ( $_REQUEST ['fontsize'  ], 0, 2 ).'">'; }
       if ( isset ( $_REQUEST ['language'  ] ) ) { echo '<input type="hidden" name="language" value="'.$_REQUEST ['language'  ].'">'; }
       if ( isset ( $_REQUEST ['stylesheet'] ) ) { echo '<input type="hidden" name="stylesheet" value="'.substr ( $_REQUEST ['stylesheet'], 47, -29 ).'">'; }
       echo '
       <input type="checkbox" id="stat-track" name="stat-track" onclick="this.form.submit()" checked="checked">
       <label for="stat-track"><b>'.$lang_setcookie[8].'</b></label>
      </form>
      </body>
      </html>';
     }
    else
     {
      echo $html_header;
      echo $lang_setcookie[9].'<br><br>';
      echo '
      <form method="post" action="'.$_SERVER ["PHP_SELF"].'?action=opt-out">
       <input type="hidden" name="setcookie" value="1">';
       if ( isset ( $_REQUEST ['bgcolor'   ] ) ) { echo '<input type="hidden" name="bgcolor" value="'.substr ( $_REQUEST ['bgcolor'   ], 1, 6 ).'">'; }
       if ( isset ( $_REQUEST ['color'     ] ) ) { echo '<input type="hidden" name="color" value="'.substr ( $_REQUEST ['color'     ], 1, 6 ).'">'; }
       if ( isset ( $_REQUEST ['fontsize'  ] ) ) { echo '<input type="hidden" name="fontsize" value="'.substr ( $_REQUEST ['fontsize'  ], 0, 2 ).'">'; }
       if ( isset ( $_REQUEST ['language'  ] ) ) { echo '<input type="hidden" name="language" value="'.$_REQUEST ['language'  ].'">'; }
       if ( isset ( $_REQUEST ['stylesheet'] ) ) { echo '<input type="hidden" name="stylesheet" value="'.substr ( $_REQUEST ['stylesheet'], 47, -29 ).'">'; }
       echo '
       <input type="checkbox" id="stat-track" name="stat-track" onclick="this.form.submit()">
       <label for="stat-track"><b>'.$lang_setcookie[10].'</b></label>
      </form>
      </body>
      </html>';
     }
   }
 }
else
 {
  //------------------------------------------------------------------------------
  if ( $cookiepassword_ask == 1 )
   {
    if ( $clientpassword == "" )
     {
      $clientpassword = md5 ( time ( ) );
     }
    if ( ( !isset ( $_POST ['password'] ) ) || ( ( passCrypt ( $_POST [ 'password' ] ) != $adminpassword ) && ( md5 ( $_POST [ 'password' ] ) != md5 ( $adminpassword ) ) && ( passCrypt ( $_POST [ 'password' ] ) != $clientpassword ) && ( md5 ( $_POST [ 'password' ] ) != md5 ( $clientpassword ) ) ) )
     {
  	  include ( 'func/html_header.php' ); // include html header
  	  // login
  	  echo '
      <form name="login" action="cookie.php" method="post">
      <table id="login" cellspacing="0" cellpadding="0">
      <tr><td class="li_td1">&nbsp;</td></tr>
      <tr><td class="li_td2">'.$lang_login[1].'</td></tr>
      <tr><td class="li_td3"></td></tr>
      <tr>
        <td class="li_td4">
        '.$lang_login[2].'
        <table border="0" cellspacing="0" cellpadding="0" align="center" style="color:#000000;">
        <tr><td style="height:50px; padding-right:20px;"><label for="password">'.$lang_login[3].'</label></td><td style="height:50px;"><input class="pw" type="password" name="password" id="password"></td></tr>
        <tr><td>&nbsp;</td><td><input style="cursor:pointer;" type="submit" name="login" value="'.$lang_login[4].'"> <input style="cursor:pointer;" type="button" onclick="history.back()" value="'.$lang_login[5].'"></td></tr>
        </table>
        </td>
      </tr>
      <tr><td class="li_td5">Copyright &copy; 2015 PHP Web Stat &nbsp;&middot;&nbsp; Version '.$version_number.$revision_number.'</td></tr>
      </table>
      </form>
      ';
   	  include ( 'func/html_footer.php' ); // include html footer
   	  exit;
     }
   }
  //------------------------------------------------------------------------------
  if ( $_COOKIE ['dontcount'] != 'ja' )
   {
    setcookie ( 'dontcount', 'ja', time()+3600*24*365*5 , '/' );
    $text = "<p>".$lang_setcookie[5]."</p><p>".$lang_setcookie[1]." <img src=\"images/dontcount.png\" border=\"0\" align=\"absmiddle\" alt=\"\" />";
   }
  else
   {
    setcookie ( 'dontcount', $_COOKIE ['dontcount'], time()-3600*24*365*5 , '/' );
    $text = "<p>".$lang_setcookie[6]."</p><p>".$lang_setcookie[3]." <img src=\"images/count.png\" border=\"0\" align=\"absmiddle\" alt=\"\" />";
   }
  //------------------------------------------------------------------------------
  echo'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>PHP Web Statistik '.$version_number.$revision_number.'</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="refresh" content="2; URL=index.php" />
    <link rel="stylesheet" type="text/css" href="'.$theme.'style.css" />
  </head>
  <body>
  <br /><br /><br /><br />
  <table class="stat_table" width="600" border="0" cellspacing="0" cellpadding="0" align="center" valign="middle">
  <tr>
    <td class="stat_header" align="center" style="padding:4px; font-size:14px;">Cookie Info!</td>
  </tr>
  <tr>
    <td class="stat_moduldata" align="center" style="padding:10px"><p><b>'.$text.'</b></p></td>
  </tr>
  </table>
  </body>
  </html>';
 }
//------------------------------------------------------------------------------
?>
