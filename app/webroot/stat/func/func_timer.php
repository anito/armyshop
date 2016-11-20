<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.0.x                                                    #
# File-Release-Date:  07/09/06                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2009 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
function microtime_float ()
 {
  list($usec, $sec) = explode(" ", microtime());
  return ((float)$usec + (float)$sec);
 }
//------------------------------------------------------------------------------
function timer_start ()
 {
  return microtime_float();
 }
//------------------------------------------------------------------------------
function timer_stop ( $value )
 {
  $timer_end = microtime_float();
  return round ( ( $timer_end - $value ) , 2 );
 }
//------------------------------------------------------------------------------
?>