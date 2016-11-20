<?php if ( !isset ( $_SERVER [ "PHP_SELF" ] ) || basename ( $_SERVER [ "PHP_SELF" ] ) == basename (__FILE__) ) { $error_path = "../"; include ( "func_error.php" ); exit; };
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.8.x                                                    #
# File-Release-Date:  14/07/24                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2014 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
error_reporting(0);
//------------------------------------------------------------------------------

// Include HTML Header
//------------------------------------------------------------------------------
// HTML Header (index)
if ( ( $loginpassword_ask == 1 ) && ( $autologout == 1 ) )
 {
  $logout_time = $autologout_time * 60;
  $logout_meta = "\n <meta http-equiv=\"refresh\" content=\"".$logout_time."; URL=index.php?parameter=autologout\" />";
 }

$html_header1 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>PHP Web Stat '.$version_number.$revision_number.'</title>'.$logout_meta.'
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
 <meta http-equiv="pragma"  content="no-cache" />
 <meta http-equiv="expires" content="0" />
 <link rel="stylesheet" type="text/css" href="'.$theme.'style.css" media="screen, projection" />
 <link rel="stylesheet" type="text/css" href="themes/layout.css" media="screen, projection" />
 <link rel="stylesheet" type="text/css" href="themes/print.css" media="print" />
 <link rel="stylesheet" type="text/css" href="func/floatbox/floatbox.css" media="screen, projection" />
 <script type="text/javascript" src="func/win_open.js"></script>
 <script type="text/javascript" src="func/change_id.js"></script>
 <script type="text/javascript" src="func/floatbox/floatbox.js"></script>
 <!--[if lt IE 7]>
  <script type="text/javascript" src="func/unitpngfix.js"></script>
 <![endif]-->
</head>
<body>
';
//------------------------------------------------------------------------------
// HTML Header (counter)
$html_header2 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>PHP Web Stat - Counter '.$version_number.'</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="pragma"  content="no-cache" />
 <meta http-equiv="expires" content="0" />
 <link rel="stylesheet" type="text/css" href="'.$theme.'counter.css" />
 <script type="text/javascript" src="func/ticker.js">
 /*
 Text and/or Image Crawler Script Â©2009 John Davenport Scheuer
 as first seen in http://www.dynamicdrive.com/forums/ username: jscheuer1
 This Notice Must Remain for Legal Use
 */
 </script>
</head>
<body>
';
//------------------------------------------------------------------------------
// HTML Header (last_hits)
if ( $language == "language/german.php" )
 {
  $calendar_lang = "de";
 }
else
 {
  $calendar_lang = "en";
 }

$html_header3 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>PHP Web Stat - Last Hits</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
 <meta http-equiv="pragma"  content="no-cache" />
 <meta http-equiv="expires" content="0" />
 <link rel="stylesheet" type="text/css" href="'.$theme.'style.css" media="screen, projection" />
 <link rel="stylesheet" type="text/css" href="themes/print.css" media="print" />
 <style type="text/css"> @import url("func/calendar/skins/aqua/theme.css");</style>
 <script type="text/javascript" src="func/table_sort_lh.js"></script>
 <script type="text/javascript" src="func/calendar/calendar.js"></script>
 <script type="text/javascript" src="func/calendar/calendar-setup.js"></script>
 <script type="text/javascript" src="func/calendar/lang/calendar-'.$calendar_lang.'.js"></script>
</head>
<body>
';
//------------------------------------------------------------------------------
// HTML Header (archive)
if ( $language == "language/german.php" )
 {
  $calendar_lang = "de";
 }
else
 {
  $calendar_lang = "en";
 }

$html_header4 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>PHP Web Stat</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
 <meta http-equiv="pragma"  content="no-cache" />
 <meta http-equiv="expires" content="0" />
 <link rel="stylesheet" type="text/css" href="'.$theme.'style.css" media="screen, projection" />
 <style type="text/css"> @import url("func/calendar/skins/aqua/theme.css");</style>
 <script type="text/javascript" src="func/win_open.js"></script>
 <script type="text/javascript" src="func/calendar/calendar.js"></script>
 <script type="text/javascript" src="func/calendar/calendar-setup.js"></script>
 <script type="text/javascript" src="func/calendar/lang/calendar-'.$calendar_lang.'.js"></script>
 <style type="text/css">
  body { margin:0px; }
 </style>
</head>
<body>
';
//------------------------------------------------------------------------------
// HTML Header (detail_view)
$html_header5 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>PHP Web Stat - Details</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
 <meta http-equiv="pragma"  content="no-cache" />
 <meta http-equiv="expires" content="0" />
 <link rel="stylesheet" type="text/css" href="'.$theme.'style.css" media="screen, projection" />
 <style type="text/css">
  body { margin-left: 5px; margin-right: 5px; }
 </style>
 <script type="text/javascript" src="func/table_sort_dv.js"></script>
</head>
<body>
';
//------------------------------------------------------------------------------
// HTML Header (cookie)
$html_header6 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>PHP Web Stat</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
 <meta http-equiv="pragma"  content="no-cache" />
 <meta http-equiv="expires" content="0" />
 <link rel="stylesheet" type="text/css" href="'.$theme.'style.css" media="screen, projection" />
 <link rel="stylesheet" type="text/css" href="themes/layout.css" media="screen, projection" />
 <link rel="stylesheet" type="text/css" href="themes/print.css" media="print" />
 <!--[if lt IE 7]>
  <script type="text/javascript" src="func/unitpngfix.js"></script>
 <![endif]-->
</head>
<body onload="document.login.password.focus(); document.login.password.select();">
';
//------------------------------------------------------------------------------
// HTML Header (sysinfo)
$html_header7 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>PHP Web Stat - Sysinfo</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
 <meta http-equiv="pragma"  content="no-cache" />
 <meta http-equiv="expires" content="0" />
 <link rel="stylesheet" type="text/css" href="'.$theme.'style.css" media="screen, projection" />
 <link rel="stylesheet" type="text/css" href="themes/print.css" media="print" />
 <link rel="stylesheet" type="text/css" href="func/floatbox/floatbox.css" media="screen, projection" />
 <script type="text/javascript" src="func/floatbox/floatbox.js"></script>
 <!--[if lt IE 7]>
  <script type="text/javascript" src="func/unitpngfix.js"></script>
 <![endif]-->
</head>
<body>
';
//------------------------------------------------------------------------------
// HTML Header (plugin_choose)
$html_header8 = '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>PHP Web Stat - Plugin</title>
 <meta charset="utf-8">
 <meta name="author" content="PHP Web Stat">
 <link rel="stylesheet" type="text/css" href="'.$theme.'style.css" media="screen, projection">
 <script type="text/javascript" src="func/win_open.js"></script>
 <style type="text/css">
  body { margin:0px; }
 </style>
</head>
<body>
';
//------------------------------------------------------------------------------
// HTML Header (plugin_loader)
if ( file_exists ( 'plugins/'.$_POST [ 'plugin' ].'/style.css' ) )
 {
 $stylesheet = '<link rel="stylesheet" type="text/css" href="'.$theme.'style.css" media="screen, projection">
 <link rel="stylesheet" type="text/css" href="plugins/'.$_POST [ "plugin" ].'/style.css" media="screen, projection">';
 }
else
 {
 $stylesheet = '<link rel="stylesheet" type="text/css" href="'.$theme.'style.css" media="screen, projection">';
 }
$html_header9 = '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>PHP Web Stat - Plugin</title>
 <meta charset="utf-8">
 <meta name="author" content="PHP Web Stat">
 '.$stylesheet.'
</head>
<body>
';
//------------------------------------------------------------------------------
// HTML Header (setup , admin)
$html_header11 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>PHP Web Stat - Admin-Center</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
 <meta http-equiv="pragma"  content="no-cache" />
 <meta http-equiv="expires" content="0" />
 <link rel="stylesheet" type="text/css" href="../'.$theme.'style.css" media="screen, projection" />
 <link rel="stylesheet" type="text/css" href="../themes/layout.css" media="screen, projection" />
 <!--[if lt IE 7]>
  <script type="text/javascript" src="../func/unitpngfix.js"></script>
 <![endif]-->
</head>
<body onload="document.login.password.focus(); document.login.password.select();">
';
//------------------------------------------------------------------------------
// HTML Header (cache_panel)
$html_header12 = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
 <title>PHP Web Stat</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
 <meta http-equiv="cache-control"  content="no-cache">
 <meta http-equiv="pragma"  content="no-cache">
 <meta http-equiv="expires" content="0">
 <link rel="stylesheet" type="text/css" href="'.$theme.'style.css" media="screen, projection">
 <style type="text/css">
  body { margin:0px; }
 </style>
</head>
<body>
';
//------------------------------------------------------------------------------
// HTML Header (db_transfer)
$html_header13 = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
 <title>PHP Web Stat</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
 <meta http-equiv="cache-control"  content="no-cache">
 <meta http-equiv="pragma"  content="no-cache">
 <meta http-equiv="expires" content="0">
 <link rel="stylesheet" type="text/css" href="../'.$theme.'style.css" media="screen, projection">
 <style type="text/css">
  body { background: #808080 url(../images/admin/bg_transfer.gif) center center no-repeat; background-attachment:fixed; margin:0px; }
 </style>
 <script type="text/javascript">
  function db_transfer_finished(){
   window.close();
   opener.location.href="setup.php?step=admincenter_database&lang='.$lang.'";
  }
 </script>
</head>
<body>
';
//------------------------------------------------------------------------------
// HTML Header (backup , delete_archive , delete_backup , delete_index , edit_css , edit_site_name , edit_string_replace , file_version , repair , reset)
$html_header14 = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
 <title>PHP Web Stat</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
 <meta http-equiv="pragma"  content="no-cache">
 <meta http-equiv="expires" content="0">
 <link rel="stylesheet" type="text/css" href="../themes/admin.css" media="screen, projection">
 <style type="text/css">
  body { margin:0px; }
 </style>
</head>
<body>
';
//------------------------------------------------------------------------------
// HTML Header (func_last_logins_show)
$html_header15 = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
 <title>PHP Web Stat</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
 <meta http-equiv="pragma"  content="no-cache">
 <meta http-equiv="expires" content="0">
 <link rel="stylesheet" type="text/css" href="../themes/admin.css" media="screen, projection">
 <style type="text/css">
  body { margin:0px; }
 </style>
</head>
<body>
';
//------------------------------------------------------------------------------
// HTML Header (syscheck)
$html_header16 = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
 <title>PHP Web Stat</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
 <meta http-equiv="pragma"  content="no-cache">
 <meta http-equiv="expires" content="0">
 <link rel="stylesheet" type="text/css" href="themes/admin.css" media="screen, projection">
 <style type="text/css">
  body { margin:0px; }
 </style>
</head>
<body>
';
//------------------------------------------------------------------------------
$file_name = pathinfo ( $_SERVER [ "PHP_SELF" ] );
if ( $file_name[ "basename" ] == "index.php"                 ) { echo $html_header1;  }
if ( $file_name[ "basename" ] == "counter.php"               ) { echo $html_header2;  }
if ( $file_name[ "basename" ] == "last_hits.php"             ) { echo $html_header3;  }
if ( $file_name[ "basename" ] == "archive.php"               ) { echo $html_header4;  }
if ( $file_name[ "basename" ] == "detail_view.php"           ) { echo $html_header5;  }
if ( $file_name[ "basename" ] == "cookie.php"                ) { echo $html_header6;  }
if ( $file_name[ "basename" ] == "sysinfo.php"               ) { echo $html_header7;  }
if ( $file_name[ "basename" ] == "plugin_choose.php"         ) { echo $html_header8;  }
if ( $file_name[ "basename" ] == "plugin_loader.php"         ) { echo $html_header9;  }
//------------------------------------------------------------------------------
if ( $file_name[ "basename" ] == "setup.php"                 ) { echo $html_header11; }
if ( $file_name[ "basename" ] == "admin.php"                 ) { echo $html_header11; }
if ( $file_name[ "basename" ] == "cache_panel.php"           ) { echo $html_header12; }
if ( $file_name[ "basename" ] == "db_transfer.php"           ) { echo $html_header13; }
if ( $file_name[ "basename" ] == "backup.php"                ) { echo $html_header14; }
if ( $file_name[ "basename" ] == "delete_archive.php"        ) { echo $html_header14; }
if ( $file_name[ "basename" ] == "delete_backup.php"         ) { echo $html_header14; }
if ( $file_name[ "basename" ] == "delete_index.php"          ) { echo $html_header14; }
if ( $file_name[ "basename" ] == "edit_css.php"              ) { echo $html_header14; }
if ( $file_name[ "basename" ] == "edit_site_name.php"        ) { echo $html_header14; }
if ( $file_name[ "basename" ] == "edit_string_replace.php"   ) { echo $html_header14; }
if ( $file_name[ "basename" ] == "file_version.php"          ) { echo $html_header14; }
if ( $file_name[ "basename" ] == "repair.php"                ) { echo $html_header14; }
if ( $file_name[ "basename" ] == "reset.php"                 ) { echo $html_header14; }
//------------------------------------------------------------------------------
if ( $file_name[ "basename" ] == "func_last_logins_show.php" ) { echo $html_header15; }
if ( $file_name[ "basename" ] == "syscheck.php"              ) { echo $html_header16; }
//------------------------------------------------------------------------------
?>
