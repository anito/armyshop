<?php
//------------------------------------------------------------------------------
if ( strpos ( strtolower ( $_SERVER [ "PHP_SELF" ] ) , "tracking_code.ctp" ) > 0 )
 {
  exit;
 }
else
 {
  echo '
  <script type="text/javascript" src="http://ha-lehmann.dev/stat/track.php?mode=js"></script>
  <noscript><img src="http://ha-lehmann.dev/stat/track.php?mode=img" border="0" alt="" width="1" height="1"></noscript>
  ';
 }
//------------------------------------------------------------------------------
?>