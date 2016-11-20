<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.9.x                                                    #
# File-Release-Date:  15/01/17                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2015 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
function passCrypt ( $password )
 {
  return 'Pass_'.substr ( base64_encode ( sha1 ( $password ) ) , 0 , 25 );
 }
//------------------------------------------------------------------------------
?>