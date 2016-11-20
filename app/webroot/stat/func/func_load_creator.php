<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.4.x                                                    #
# File-Release-Date:  10/11/01                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2010 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
if ( $_GET [ "parameter" ] == "update_stat_cache" )
 {
  echo "<meta http-equiv=\"refresh\" content=\"0; URL=../cache_creator.php?loadfile=1\">";
 }
//------------------------------------------------------------------------------
if ( $_GET [ "parameter" ] == "create_stat_cache" )
 {
  echo "<meta http-equiv=\"refresh\" content=\"0; URL=../cache_creator.php?loadfile=2\">";
 }
//------------------------------------------------------------------------------
?>