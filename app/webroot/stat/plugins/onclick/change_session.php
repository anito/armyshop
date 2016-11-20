<?php @session_start(); if ( $_SESSION [ "hidden_stat" ] != md5_file ( "../../config/config.php" ) ) { include ( "../../func/func_error.php" ); exit; }
//------------------------------------------------------------------------------
include ( "../../config/config.php"); // include adminpassword
//------------------------------------------------------------------------------
// check for password for change session
if ( md5 ( $_POST [ "password" ] ) == md5 ( $adminpassword ) )
 {
  $_SESSION [ "loggedin" ] = "admin";
 }
if ( md5 ( $_POST [ "password" ] ) == md5 ( $clientpassword ) )
 {
  $_SESSION [ "loggedin" ] = "client";
 }
//------------------------------------------------------------------------------
// HTML Header
echo '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>Change Session</title>
 <meta charset="utf-8" />
 <meta name="robots" content="noindex,nofollow" />
 <style type="text/css">
  body { margin:0px; }
 </style>
</head>
<body onload="window.close();self.opener.focus();self.opener.location.reload();return false;">';
//------------------------------------------------------------------------------
// HTML Footer
echo '
</body>
</html>
';
//------------------------------------------------------------------------------
?>