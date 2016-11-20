<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.9.x                                                    #
# File-Release-Date:  15/01/03                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2015 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
# call / include protection
$check_call = 0;
if ( strpos ( $_SERVER [ "PHP_SELF" ] , "index.php"         ) === FALSE ) { $check_call++; }
if ( strpos ( $_SERVER [ "PHP_SELF" ] , "cache_creator.php" ) === FALSE ) { $check_call++; }
if ( $check_call == 2 ) { exit; }
unset ( $check_all );
//------------------------------------------------------------------------------
// save all array entries to the cache file
if ( ( isset ( $write_cache ) ) && ( $write_cache == 1 ) )
 {
  $cache_visitors_file = fopen ( "log/cache_visitors.php" , "w+" );
  flock  ( $cache_visitors_file , 2 );
  fwrite ( $cache_visitors_file , "<?php\n" ); # php header
  //----------------------------------------------------------------------------
  if ( isset ( $visitor ) )
   {
    $temp_file_counter = 1;
    fwrite ( $cache_visitors_file , "\$visitor = array ( \n" ); # array header
    $count_array = count ( $visitor );
    foreach ( $visitor as $key => $value )
     {
      if ( $value >= strtotime ("-2 days" ) )
       {
        if ( $temp_file_counter == $count_array )
         {
          fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" );  # array values without ","
         }
        else
         {
          fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " );  # array values with "," at the end
         }
       }
      $temp_file_counter++;
     }
    fwrite ( $cache_visitors_file , "\n);\n\n" );  # array footer
   }
  //----------------------------------------------------------------------------
  if ( isset ( $visitor_hour ) )
   {
    $temp_file_counter = 1;
    fwrite ( $cache_visitors_file , "\$visitor_hour = array ( \n" ); # array header
    $count_array = count ( $visitor_hour );
    foreach ( $visitor_hour as $key => $value )
     {
      if ( $temp_file_counter == $count_array )
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" );  # array values without ","
       }
      else
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " );  # array values with "," at the end
       }
      $temp_file_counter++;
     }
    fwrite ( $cache_visitors_file , "\n);\n\n" );  # array footer
   }
   //----------------------------------------------------------------------------
   if ( isset ( $visitor_day ) )
    {
     $temp_file_counter = 1;
     fwrite ( $cache_visitors_file , "\$visitor_day = array ( \n" ); # array header
     $count_array = count ( $visitor_day );
     foreach ( $visitor_day as $key => $value )
      {
       if ( $temp_file_counter == $count_array )
        {
         fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" );  # array values without ","
        }
       else
        {
         fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " );  # array values with "," at the end
        }
       $temp_file_counter++;
      }
    fwrite ( $cache_visitors_file , "\n);\n\n" );  # array footer
   }
  //----------------------------------------------------------------------------
  if ( isset ( $visitor_weekday ) )
   {
    $temp_file_counter = 1;
    fwrite ( $cache_visitors_file , "\$visitor_weekday = array ( \n" ); # array header
    $count_array = count ( $visitor_weekday );
    foreach ( $visitor_weekday as $key => $value )
     {
      if ( $temp_file_counter == $count_array )
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" );  # array values without ","
       }
      else
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " );  # array values with "," at the end
       }
      $temp_file_counter++;
     }
    fwrite ( $cache_visitors_file , "\n);\n\n" );  # array footer
   }
  //----------------------------------------------------------------------------
  if ( isset ( $visitor_month ) )
   {
    $temp_file_counter = 1;
    fwrite ( $cache_visitors_file , "\$visitor_month = array ( \n" ); # array header
    $count_array = count ( $visitor_month );
    foreach ( $visitor_month as $key => $value )
     {
      if ( $temp_file_counter == $count_array )
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" );  # array values without ","
       }
      else
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " );  # array values with "," at the end
       }
      $temp_file_counter++;
     }
    fwrite ( $cache_visitors_file , "\n);\n\n" );  # array footer
   }
  //----------------------------------------------------------------------------
  if ( isset ( $visitor_year ) )
   {
    $temp_file_counter = 1;
    fwrite ( $cache_visitors_file , "\$visitor_year = array ( \n" ); # array header
    $count_array = count ( $visitor_year );
    foreach ( $visitor_year as $key => $value )
     {
      if ( $temp_file_counter == $count_array )
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" );  # array values without ","
       }
      else
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " );  # array values with "," at the end
       }
      $temp_file_counter++;
     }
    fwrite ( $cache_visitors_file , "\n);\n\n" );  # array footer
   }
  //----------------------------------------------------------------------------
  if ( isset ( $browser ) )
   {
    $temp_file_counter = 1;
    fwrite ( $cache_visitors_file , "\$browser = array ( \n" ); # array header
    $count_array = count ( $browser );
    foreach ( $browser as $key => $value )
     {
      $key = kill_special_chars ( $key );
      if ( $temp_file_counter == $count_array )
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" );  # array values without ","
       }
      else
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " );  # array values with "," at the end
       }
      $temp_file_counter++;
     }
    fwrite ( $cache_visitors_file , "\n);\n\n" );  # array footer
   }
  //----------------------------------------------------------------------------
  if ( isset ( $operating_system ) )
   {
    $temp_file_counter = 1;
    fwrite ( $cache_visitors_file , "\$operating_system = array ( \n" ); # array header
    $count_array = count ( $operating_system );
    foreach ( $operating_system as $key => $value )
     {
      $key = kill_special_chars ( $key );
      if ( $temp_file_counter == $count_array )
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" );  # array values without ","
       }
      else
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " );  # array values with "," at the end
       }
      $temp_file_counter++;
     }
    fwrite ( $cache_visitors_file , "\n);\n\n" );  # array footer
   }
  //----------------------------------------------------------------------------
  if ( isset ( $resolution ) )
   {
    $temp_file_counter = 1;
    fwrite ( $cache_visitors_file , "\$resolution = array ( \n" ); # array header
    $count_array = count ( $resolution );
    foreach ( $resolution as $key => $value )
     {
      if ( $temp_file_counter == $count_array )
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" );  # array values without ","
       }
      else
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " );  # array values with "," at the end
       }
      $temp_file_counter++;
     }
    fwrite ( $cache_visitors_file , "\n);\n\n" );  # array footer
   }
  //----------------------------------------------------------------------------
  if ( isset ( $color_depth ) )
   {
    $temp_file_counter = 1;
    fwrite ( $cache_visitors_file , "\$color_depth = array ( \n" ); # array header
    $count_array = count ( $color_depth );
    foreach ( $color_depth as $key => $value )
     {
      if ( $temp_file_counter == $count_array )
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" );  # array values without ","
       }
      else
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " );  # array values with "," at the end
       }
      $temp_file_counter++;
     }
    fwrite ( $cache_visitors_file , "\n);\n\n" );  # array footer
   }
  //----------------------------------------------------------------------------
  if ( isset ( $site_name ) )
   {
    $temp_file_counter = 1;
    fwrite ( $cache_visitors_file , "\$site_name = array ( \n" ); # array header
    $count_array = count ( $site_name );
    foreach ( $site_name as $key => $value )
     {
      $key = addslashes ( stripslashes ( $key ) );
      $key = kill_special_chars ( $key );
      if ( $temp_file_counter == $count_array )
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" );  # array values without ","
       }
      else
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " );  # array values with "," at the end
       }
      $temp_file_counter++;
     }
    fwrite ( $cache_visitors_file , "\n);\n\n" );  # array footer
   }
  //----------------------------------------------------------------------------
  if ( isset ( $referer ) )
   {
    $temp_file_counter = 1;
    fwrite ( $cache_visitors_file , "\$referer = array ( \n" ); # array header
    $count_array = count ( $referer );
    foreach ( $referer as $key => $value )
     {
      $key = addslashes ( stripslashes ( $key ) );
      $key = kill_special_chars ( $key );
      if ( $temp_file_counter == $count_array )
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" );  # array values without ","
       }
      else
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " );  # array values with "," at the end
       }
      $temp_file_counter++;
     }
    fwrite ( $cache_visitors_file , "\n);\n\n" );  # array footer
   }
  //----------------------------------------------------------------------------
  if ( isset ( $country ) )
   {
    $temp_file_counter = 1;
    fwrite ( $cache_visitors_file , "\$country = array ( \n" ); # array header
    $count_array = count ( $country );
    foreach ( $country as $key => $value )
     {
      $key = kill_special_chars ( $key );
      if ( $temp_file_counter == $count_array )
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" );  # array values without ","
       }
      else
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " );  # array values with "," at the end
       }
      $temp_file_counter++;
     }
    fwrite ( $cache_visitors_file , "\n);\n\n" );  # array footer
   }
  //----------------------------------------------------------------------------
  if ( isset ( $searchengines_archive  )
   {
    $temp_file_counter = 1;
    fwrite ( $cache_visitors_file , "\$searchengines_archive = array ( \n" ); # array header
    $count_array = count ( $searchengines_archive );
    foreach ( $searchengines_archive as $key => $value )
     {
      $key = kill_special_chars ( $key );
      if ( $temp_file_counter == $count_array )
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" );  # array values without ","
       }
      else
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " );  # array values with "," at the end
       }
      $temp_file_counter++;
     }
    fwrite ( $cache_visitors_file , "\n);\n\n" );  # array footer
   }
  //----------------------------------------------------------------------------
  if ( isset ( $searchwords_archive ) )
   {
    $temp_file_counter = 1;
    fwrite ( $cache_visitors_file , "\$searchwords_archive = array ( \n" ); # array header
    $count_array = count ( $searchwords_archive );
    foreach ( $searchwords_archive as $key => $value )
     {
     $key = addslashes ( stripslashes ( $key ) );
     $key = kill_special_chars ( $key );
      if ( $temp_file_counter == $count_array )
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" );  # array values without ","
       }
      else
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " );  # array values with "," at the end
       }
      $temp_file_counter++;
     }
    fwrite ( $cache_visitors_file , "\n);\n\n" );  # array footer
   }
  //----------------------------------------------------------------------------
  if ( isset ( $entrysite ) )
   {
    $temp_file_counter = 1;
    fwrite ( $cache_visitors_file , "\$entrysite = array ( \n" ); # array header
    $count_array = count ( $entrysite );
    foreach ( $entrysite as $key => $value )
     {
      $key = addslashes ( stripslashes ( $key ) );
      $key = kill_special_chars ( $key );
      if ( $temp_file_counter == $count_array )
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" );  # array values without ","
       }
      else
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " );  # array values with "," at the end
       }
      $temp_file_counter++;
     }
    fwrite ( $cache_visitors_file , "\n);\n\n" );  # array footer
   }
  //----------------------------------------------------------------------------
   fwrite ( $cache_visitors_file , "\n?>" ); # php footer
   flock  ( $cache_visitors_file , 3 );
  fclose ( $cache_visitors_file );
  unset  ( $cache_visitors_file );
  unset  ( $temp_file_counter   );
 }
//------------------------------------------------------------------------------
?>