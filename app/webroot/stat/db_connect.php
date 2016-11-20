<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.9.x                                                    #
# File-Release-Date:  15/10/25                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2015 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
function db_query ( $query, $switch, $cancel )
 {
  //----------------------------------------------------------------------------
  include ( "config/config_db.php" ); // include db prefix
  //----------------------------------------------------------------------------
  $db_entries      = array ();
  $db_connection   = 0;
  $db_counter      = 0;
  $db_number_rows  = 0;
  $db_query_result = 0;
  $db_temp         = 0;
  $db_temp_counter = 0;
  $db_error        = 0;
  $mysqli          = 0; // set extension disabled
  //----------------------------------------------------------------------------
  if ( function_exists ( "mysqli_connect" ) ) // check for extension enabled
   {
    $mysqli = 1;
   }
  //----------------------------------------------------------------------------
  if ( $mysqli == 1 )
   {
    //----------------------------------------------------------------------------
    $db_connection = mysqli_connect ( $db_host , $db_user , $db_password , $db_name );
    //----------------------------------------------------------------------------
    if ( mysqli_connect_errno ( $db_connection ) )
     {
     	if ( $cancel == 1 )
   	   {
   	    echo '<meta http-equiv="refresh" content="5; URL='.$_SERVER ["PHP_SELF"].'\">';
   	   }
   	  else
   	   {
   	    $db_error = mysqli_error();
        die ( $db_error );
       }
     }
    //----------------------------------------------------------------------------
    $query_result = mysqli_query ( $db_connection , $query );
    //----------------------------------------------------------------------------
    if ( !$query_result )
     {
      $db_error = mysqli_error();
      die ( $db_error );
     }
    //----------------------------------------------------------------------------
    if  ( $switch == 1 )
     {
      $db_number_rows = mysqli_num_rows ( $query_result );
      while ( $db_temp = mysqli_fetch_row ( $query_result ) )
       {
        for ( $db_temp_counter = 0 ; $db_temp_counter <= count ( $db_temp ) ; $db_temp_counter++ )
         {
          $db_entries [ $db_counter ] [ $db_temp_counter ] = $db_temp[ $db_temp_counter ];
         }
        $db_counter++;
       }
     }
    //----------------------------------------------------------------------------
    mysqli_close( $db_connection );
    return $db_entries;
    //----------------------------------------------------------------------------
   }
  else
   {
    //----------------------------------------------------------------------------
    $db_connection = mysql_pconnect ( $db_host , $db_user , $db_password );
    //----------------------------------------------------------------------------
    if ( !$db_connection )
     {
     	if ( $cancel == 1 )
     	 {
     	  echo '<meta http-equiv="refresh" content="5; URL='.$_SERVER ["PHP_SELF"].'\">';
     	 }
     	else
     	 {
     	  $db_error = mysql_error();
        die ( $db_error );
       }
     }
    //----------------------------------------------------------------------------
    // This function was used to check for upcoming errors. This is not more needed.
	  // Also this code lead to some access denied notices in some stats.
	  // if ( !mysql_select_db ( $db_name , $db_connection ) )
    //  {
    //   $db_error = mysql_error();
    //   die ( $db_error );
    //  }
    //----------------------------------------------------------------------------
    $query_result = mysql_query ( $query , $db_connection );
    //----------------------------------------------------------------------------
    if ( !$query_result )
     {
      $db_error = mysql_error();
      die ( $db_error );
     }
    //----------------------------------------------------------------------------
    if  ( $switch == 1 )
     {
      $db_number_rows = mysql_num_rows ( $query_result );
      while ( $db_temp = mysql_fetch_row ( $query_result ) )
       {
        for ( $db_temp_counter = 0 ; $db_temp_counter <= count ( $db_temp ) ; $db_temp_counter++ )
         {
          $db_entries [ $db_counter ] [ $db_temp_counter ] = $db_temp[ $db_temp_counter ];
         }
        $db_counter++;
       }
     }
    //----------------------------------------------------------------------------
    mysql_close( $db_connection );
    return $db_entries;
    //----------------------------------------------------------------------------
   }
 }
//------------------------------------------------------------------------------
?>