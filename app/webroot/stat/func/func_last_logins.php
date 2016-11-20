<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.7.x                                                    #
# File-Release-Date:  13/04/17                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2013 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
function last_login_log ( $who )
 {
  //--------------------------------
  include ( "config/config.php" ); // include server time
  //--------------------------------
  $actual_date = time ( ); // time today
  if ( $server_time == "+14h"    ) { $actual_date = $actual_date + 14 * 3600; }
  if ( $server_time == "+13,75h" ) { $actual_date = $actual_date + 13 * 3600 + 2700; }
  if ( $server_time == "+13h"    ) { $actual_date = $actual_date + 13 * 3600; }
  if ( $server_time == "+12,75h" ) { $actual_date = $actual_date + 12 * 3600 + 2700; }
  if ( $server_time == "+12h"    ) { $actual_date = $actual_date + 12 * 3600; }
  if ( $server_time == "+11,5h"  ) { $actual_date = $actual_date + 11 * 3600 + 1800; }
  if ( $server_time == "+11h"    ) { $actual_date = $actual_date + 11 * 3600; }
  if ( $server_time == "+10,5h"  ) { $actual_date = $actual_date + 10 * 3600 + 1800; }
  if ( $server_time == "+10h"    ) { $actual_date = $actual_date + 10 * 3600; }
  if ( $server_time == "+9,5h"   ) { $actual_date = $actual_date +  9 * 3600 + 1800; }
  if ( $server_time == "+9h"     ) { $actual_date = $actual_date +  9 * 3600; }
  if ( $server_time == "+8h"     ) { $actual_date = $actual_date +  8 * 3600; }
  if ( $server_time == "+7h"     ) { $actual_date = $actual_date +  7 * 3600; }
  if ( $server_time == "+6,5h"   ) { $actual_date = $actual_date +  6 * 3600 + 1800; }
  if ( $server_time == "+6h"     ) { $actual_date = $actual_date +  6 * 3600; }
  if ( $server_time == "+5,75h"  ) { $actual_date = $actual_date +  5 * 3600 + 2700; }
  if ( $server_time == "+5,5h"   ) { $actual_date = $actual_date +  5 * 3600 + 1800; }
  if ( $server_time == "+5h"     ) { $actual_date = $actual_date +  5 * 3600; }
  if ( $server_time == "+4,5h"   ) { $actual_date = $actual_date +  4 * 3600 + 1800; }
  if ( $server_time == "+4h"     ) { $actual_date = $actual_date +  4 * 3600; }
  if ( $server_time == "+3,5h"   ) { $actual_date = $actual_date +  3 * 3600 + 1800; }
  if ( $server_time == "+3h"     ) { $actual_date = $actual_date +  3 * 3600; }
  if ( $server_time == "+2h"     ) { $actual_date = $actual_date +  2 * 3600; }
  if ( $server_time == "+1h"     ) { $actual_date = $actual_date +  1 * 3600; }
  if ( $server_time == "-1h"     ) { $actual_date = $actual_date -  1 * 3600; }
  if ( $server_time == "-2h"     ) { $actual_date = $actual_date -  2 * 3600; }
  if ( $server_time == "-3h"     ) { $actual_date = $actual_date -  3 * 3600; }
  if ( $server_time == "-3,5h"   ) { $actual_date = $actual_date -  3 * 3600 - 1800; }
  if ( $server_time == "-4h"     ) { $actual_date = $actual_date -  4 * 3600; }
  if ( $server_time == "-4,5h"   ) { $actual_date = $actual_date -  4 * 3600 - 1800; }
  if ( $server_time == "-5h"     ) { $actual_date = $actual_date -  5 * 3600; }
  if ( $server_time == "-6h"     ) { $actual_date = $actual_date -  6 * 3600; }
  if ( $server_time == "-7h"     ) { $actual_date = $actual_date -  7 * 3600; }
  if ( $server_time == "-8h"     ) { $actual_date = $actual_date -  8 * 3600; }
  if ( $server_time == "-9h"     ) { $actual_date = $actual_date -  9 * 3600; }
  if ( $server_time == "-9,5h"   ) { $actual_date = $actual_date -  9 * 3600 - 1800; }
  if ( $server_time == "-10h"    ) { $actual_date = $actual_date - 10 * 3600; }
  if ( $server_time == "-11h"    ) { $actual_date = $actual_date - 11 * 3600; }
  if ( $server_time == "-12h"    ) { $actual_date = $actual_date - 12 * 3600; }
  //--------------------------------
  $last_login_logfile = fopen ( "log/last_logins.dta" , "a+" );
   fwrite ( $last_login_logfile , $actual_date."|".$_SERVER [ "REMOTE_ADDR" ]."|".$who."\n" );
  fclose ( $last_login_logfile );
  unset  ( $last_login_logfile );
  //--------------------------------
 }
//------------------------------------------------------------------------------
?>