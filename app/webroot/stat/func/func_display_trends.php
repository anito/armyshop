<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.4.x                                                    #
# File-Release-Date:  10/11/13                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2010 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
function display_trends ( &$data , &$data_average , $parameter )
 {
  //----------------------------------------------------------------------------
  include ( "config/config.php" ); // include path to logfile
  include ( $language           ); // include language vars
  //----------------------------------------------------------------------------
  $trend_value         = 0;
  $trend_value_average = 0;

  foreach ( $data as $key => $value )
   {
    //--------------------------------------------------------------------------
    if ( $parameter == 1 ) { $key = " ".$key." "; }

    if ( ( $key % 2 ) == 0 ) { $background = "lh_row2"; } else { $background = "lh_row1"; }
    echo "<tr class=\"".$background."\">";
    echo "<td class=\"stat_module_data\">".$key."</td>";

    $difference         = ( int ) round ( $value - $trend_value );
    $difference_average = ( int ) round ( $data_average [ $key ] - $trend_value_average );

    if ( $trend_value == 0 ) { $difference_percent = 100; }
    else { $difference_percent = ( int ) round ( ( $value - $trend_value ) / $trend_value  * 100 ); }

    if ( $trend_value_average == 0 ) { $difference_percent_average = 100; }
    else { $difference_percent_average = ( int ) round ( ( $data_average [ $key ] - $trend_value_average ) / $trend_value_average  * 100 ); }

    //$howmuch_1 = $value;
    //$howmuch_2 = 100 - $value;
    //$howmuch_3 = $value - 100;

    $sum_total         = max ( $data         );

    $howmuch_1 = ( int ) round ( $value / $sum_total * 100 );
    $howmuch_2 = ( int ) 100 - ( $value / $sum_total * 100 );
    $howmuch_3 = ( int ) round ( $value / $sum_total * 100 -100 );

    echo "<td class=\"stat_slidebar\">";
    if ( trim ( $howmuch_2 ) == "100" )
     {
      echo "<img class=\"percent\" src=\"".$theme."percentimage_front.gif\" border=\"0\" width=\"102\" height=\"10\" alt=\"0%\" title=\"0%\" style=\"vertical-align: middle; background: url('images/trendimage_plus.gif') top left no-repeat; background-position: -100px 0pt;\">";
     }
    else
     {
      if ( trim ( $howmuch_2 ) == "0" )
       {
        echo "<img class=\"percent\" src=\"".$theme."percentimage_front.gif\" border=\"0\" width=\"102\" height=\"10\" alt=\"100%\" title=\"100%\" style=\"vertical-align: middle; background: url('images/trendimage_plus.gif') top left no-repeat; background-position: 0px 0pt;\">";
       }
      else
       {
        if ( $difference > 0 )
         {
          echo "<img class=\"percent\" src=\"".$theme."percentimage_front.gif\" border=\"0\" width=\"102\" height=\"10\" alt=\"".$howmuch_1."%\" title=\"".$howmuch_1."%\" style=\"vertical-align: middle; background: url('images/trendimage_plus.gif') top left no-repeat; background-position: ".$howmuch_3."px 0pt;\">";
         }
        else
         {
         	echo "<img class=\"percent\" src=\"".$theme."percentimage_front.gif\" border=\"0\" width=\"102\" height=\"10\" alt=\"".$howmuch_1."%\" title=\"".$howmuch_1."%\" style=\"vertical-align: middle; background: url('images/trendimage_minus.gif') top left no-repeat; background-position: ".$howmuch_3."px 0pt;\">";
         }
       }
     }

    echo "</td>";

    if ( $parameter == 1 )
     {
      echo "<td class=\"stat_hits\">".number_format ( $difference , 0 , "," , "." )."</td>";
      echo "<td class=\"stat_hits\">".number_format ( $value , 0 , "," , "." )."</td>";
      echo "<td class=\"stat_percent\" style=\"border-right:1px outset #6F6F6F;\">".$difference_percent."%</td>";
      echo "<td class=\"stat_hits\" style=\"width:75px;\">".number_format ( $difference_average , 0 , "," , "." )."</td>";
      echo "<td class=\"stat_hits\" style=\"width:80px;\">".number_format ( $data_average [ $key ] , 0 , "," , "." )."</td>";
      echo "<td class=\"stat_percent\">".$difference_percent_average."%</td>";
     }
    else
     {
      echo "<td class=\"stat_hits\">".number_format ( $difference_average , 0 , "," , "." )."</td>";
      echo "<td class=\"stat_hits\">".number_format ( $data_average [ $key ] , 0 , "," , "." )."</td>";
      echo "<td class=\"stat_percent\" style=\"border-right:1px outset #6F6F6F;\">".$difference_percent_average."%</td>";
      echo "<td class=\"stat_hits\" style=\"width:75px;\">".number_format ( $difference , 0 , "," , "." )."</td>";
      echo "<td class=\"stat_hits\" style=\"width:80px;\">".number_format ( $value , 0 , "," , "." )."</td>";
      echo "<td class=\"stat_percent\">".$difference_percent."%</td>";
     }

    echo "</tr>\n";

    $trend_value         = $value;
    $trend_value_average = $data_average [ $key ];
    //--------------------------------------------------------------------------
   }
 }
//------------------------------------------------------------------------------
?>