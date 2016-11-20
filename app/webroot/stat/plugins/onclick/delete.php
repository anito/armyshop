<?php @session_start(); if ( $_SESSION [ "hidden_stat" ] != md5_file ( "../../config/config.php" ) ) { include ( "../../func/func_error.php" ); exit; }
//------------------------------------------------------------------------------
// HTML Header
echo '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>Delete Onclick ID</title>
 <meta charset="utf-8" />
 <meta name="robots" content="noindex,nofollow" />
 <style type="text/css">
  body { margin:0px; }
 </style>
</head>
<body onload="window.close();self.opener.focus();self.opener.location.reload();return false;">
';
//------------------------------------------------------------------------------
$kill_id = $_GET [ "kill_id" ];
//------------------------------------------------------------------------------
if ( isset ( $kill_id ) )
 {
  $track_file_names = unserialize ( file_get_contents ( "../../log/logdb_track_file.dta" ) );
  if ( array_key_exists ( $kill_id , $track_file_names ) )
   {
    unset ( $track_file_names [ $kill_id ] );
    @file_put_contents ( "../../log/logdb_track_file.dta" , serialize ( $track_file_names ) );
   }
 }
//------------------------------------------------------------------------------
// HTML Footer
echo '
</body>
</html>
';
//------------------------------------------------------------------------------
?>