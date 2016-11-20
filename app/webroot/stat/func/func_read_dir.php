<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.0.x                                                    #
# File-Release-Date:  06/08/08                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2009 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
function read_dir ( $path )
 {
  $result = array();
  $handle = opendir ( $path );
  if ( $handle )
   {
    while ( false !== ( $file = readdir ( $handle ) ) )
     {
      if ( $file != "." && $file != ".." )
       {
        $name = $path."/".$file;
        $result[] = $name;
       }
     }
   }
  closedir ( $handle );
  return $result;
 }
//------------------------------------------------------------------------------
?>