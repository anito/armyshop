<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.0.x                                                    #
# File-Release-Date:  08/11/16                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2009 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
function kill_special_chars ( $value )
 {
 	$value = str_replace( "ß"    , "&szlig;" , $value ); // replace ß
  $value = str_replace( "ÃŸ"   , "&szlig;" , $value ); // replace ß
  $value = str_replace( "ãŸ"   , "&szlig;" , $value ); // replace ß
  //--------------------
  $value = str_replace( "Ä"    , "&Auml;"  , $value ); // replace Ä
  $value = str_replace( "ä"    , "&auml;"  , $value ); // replace ä
  $value = str_replace( "Ã¤"   , "&auml;"  , $value ); // replace Ä
  $value = str_replace( "ã¤"   , "&auml;"  , $value ); // replace ä
  $value = str_replace( "Â¼"   , "&auml;"  , $value ); // replace Ä
  $value = str_replace( "â¼"   , "&auml;"  , $value ); // replace ä
  //--------------------
  $value = str_replace( "Ö"    , "&Ouml;"  , $value ); // replace Ö
  $value = str_replace( "ö"    , "&ouml;"  , $value ); // replace ö
  $value = str_replace( "Ã¶"   , "&ouml;"  , $value ); // replace Ö
  $value = str_replace( "ã¶"   , "&ouml;"  , $value ); // replace ö
  //--------------------
  $value = str_replace( "Ü"    , "&Uuml;"  , $value ); // replace Ü
  $value = str_replace( "ü"    , "&uuml;"  , $value ); // replace ü
  $value = str_replace( "Ã?"   , "&uuml;"  , $value ); // replace Ü
  $value = str_replace( "ã?"   , "&uuml;"  , $value ); // replace ü
  $value = str_replace( "Ã¼"   , "&uuml;"  , $value ); // replace Ü
  $value = str_replace( "ã¼"   , "&uuml;"  , $value ); // replace ü
  //--------------------
  $value = str_replace( "\""   , "&quot;"  , $value ); // replace "
  $value = str_replace( "\\"   , ""        , $value ); // delete  \
  $value = str_replace( "<"    , ""        , $value ); // delete  <
  $value = str_replace( ">"    , ""        , $value ); // delete  >
  return $value;
 }
//------------------------------------------------------------------------------
#function kill_special_chars_track ( $value )
# {
#  $value = str_replace( "\""   , ""        , $value ); // delete  "
# 	$value = str_replace( "'"    , ""        , $value ); // delete  '
#  $value = str_replace( "\\"   , ""        , $value ); // delete  \
#  return $value;
# }
//------------------------------------------------------------------------------
?>