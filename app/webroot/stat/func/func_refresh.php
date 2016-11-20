<?php if ( !isset ( $_SERVER [ "PHP_SELF" ] ) || basename ( $_SERVER [ "PHP_SELF" ] ) == basename (__FILE__) ) { $error_path = "../"; include ( "func_error.php" ); exit; };
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.0.x                                                    #
# File-Release-Date:  09/05/08                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2009 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
echo"
<script type=\"text/javascript\">
/* <![CDATA[ */
creator_iframe=\"func/func_load_creator.php?parameter=update_stat_cache\"
control_iframe=\"func/func_timestamp_control.php?parameter=stat\"

//check browser
ie=0
ns4=0
dom=0
if(document.getElementById)
dom=1
if(document.layers)
ns4=1

//write display
function refresh_display()
 {
  if(ns4)
  document.write('<layer name=\"refresh\" z-Index=\"10\" width=\"323\" height=\"196\" visibility=\"show\">')
  else
  document.write('<div id=\"refresh\" style=\"visibility:hidden\">')

  document.write('<div id=\"rf_header\"><p style=\"margin: 0px; padding-top: 2px;\">".$lang_refresh[1]."</p></div>')
  document.write('<div style=\"width: 283px; margin: auto;\">')
  document.write('<div id=\"rf_indicator\"><p style=\"margin: 0px; padding-top: 15px;\"><img src=\"images/load_indicator.gif\" border=\"0\" alt=\"loading\" title=\"loading\" /><br />')
  document.write('<iframe name=\"creator\" src=\"\" width=\"10\" height=\"10\" frameborder=\"0\" scrolling=\"no\"></iframe></p></div>')
  document.write('<div id=\"rf_text\"><p style=\"margin: 0px; padding-top: 15px;\">".$lang_refresh[2]."<br />".$lang_refresh[3]."</p></div>')
  document.write('</div>')
  document.write('<div id=\"rf_co_th\">".$lang_refresh[4]."</div>')
  document.write('<div id=\"rf_co_iframe\"><p style=\"margin: 0px; padding-top: 4px;\"><iframe name=\"control\" src=\"\" width=\"200\" height=\"20\" frameborder=\"0\" scrolling=\"no\"></iframe></p></div>')

  if(ns4)
  document.write('<\/layer>')
  else
  document.write('<\/div>')
 }

function getobj(obj)
 {
  return(ns4?document.layers[obj]:document.getElementById(obj).style)
 }

function start(iframe1,iframe2)
 {
  //show refresh display
  ns4?getobj('refresh').visibility=\"show\":getobj('refresh').visibility=\"visible\"
  if(self.frames[\"creator\"].location.href.indexOf(\"xyz.html\") <0)
  self.frames[\"creator\"].location.href=iframe1
  if(self.frames[\"control\"].location.href.indexOf(\"xyz.html\") <0)
  self.frames[\"control\"].location.href=iframe2
 }
/* ]]> */
</script>
";
//------------------------------------------------------------------------------
?>