<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.8.x                                                    #
# File-Release-Date:  14/06/10                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2014 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>PHP Web Stat</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
 <style type="text/css">
  body     { margin: 20px 80px 0px 80px; background: #FFFFFF url('.strip_tags ( $error_path ).'images/error_bg.png) repeat-x; font-size: 14px; font-weight: bold; }
  #info    { font-size: 24px; color: #446D8C; font-family: Arial, Verdana, Sans Serif; }
  .site    { color: #CC0000; }
  #info_de { width: 100%; border: 1px solid #BEDCE7; background: #EAF2F5; color: #446D8C; padding: 10px; }
  #info_en { width: 100%; border: 1px solid #BEDCE7; background: #EAF2F5; color: #446D8C; padding: 10px; }
  .info    { margin-right: 20px; }
  .flag    { margin-right: 20px; margin-bottom: 20px; float: left; }
  #copy    { position:absolute; bottom: 0px; left: 50%; width: 500px; height: 30px; text-align: center; margin-left: -250px; }
  a:link, a:visited, a:active a:hover, a:focus { color: #000000; }
  </style>
</head>

<body>
<div id="content">
 <div id="info">
  <img class="info" src="'.strip_tags ( $error_path ).'images/error_info.png" border="0" width="64" height="64" alt="" />
  Access Denied
 </div>
 <br />
 <div id="info_de">
  <img class="flag" src="'.strip_tags ( $error_path ).'images/error_flag_de.jpg" border="0" width="34" height="17" alt="" />
  Sie sind nicht berechtigt die von Ihnen aufgerufene Seite <span class="site">'.basename ( $_SERVER [ "PHP_SELF" ] ).'</span> zu betreten.
 </div>
 <br />
 <div id="info_en">
  <img class="flag" src="'.strip_tags ( $error_path ).'images/error_flag_gb.jpg" border="0" width="34" height="17" alt="" />
  You are not authorized to access the selected page <span class="site">'.basename ( $_SERVER [ "PHP_SELF" ] ).'</span>.
 </div>
</div>
<div id="copy">
 &copy; Copyright '.date ( "Y" ).' <a href="http://www.php-web-statistik.de">PHP Web Stat</a> All Rights Reserved
</div>
</body>
</html>
';
//------------------------------------------------------------------------------
?>