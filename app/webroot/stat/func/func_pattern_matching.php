<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.7.x                                                    #
# File-Release-Date:  13/02/09                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2013 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
function pattern_matching ( $meta , $value )
 {
  //------------------------------------------------------------------
  // Replace all sitename and referer values to the pattern strings coming from the file config/pattern_string_replace.inc
  if ( ( $meta == "site_name" ) || ( $meta == "referer" ) ) { $value = str_replace ( $GLOBALS [ "replace_from" ] , $GLOBALS [ "replace_to" ] , $value ); }
  //------------------------------------------------------------------
	if ( $GLOBALS [ "db_active" ] == 1 )
	 {
	  //----------------------------------------------------------------
	  if ( $meta == "site_name"         ) { $table = "".$GLOBALS [ "db_prefix" ]."_site_name";        }
	  if ( $meta == "resolution"        ) { $table = "".$GLOBALS [ "db_prefix" ]."_resolution";       }
	  if ( $meta == "browser"           ) { $table = "".$GLOBALS [ "db_prefix" ]."_browser";          }
	  if ( $meta == "operating_system"  ) { $table = "".$GLOBALS [ "db_prefix" ]."_operating_system"; }
	  if ( $meta == "referrer"          ) { $table = "".$GLOBALS [ "db_prefix" ]."_referrer";         }
	  //----------------------------------------------------------------
	  $query  = "SELECT id FROM ".$table." WHERE ".$meta."='".$value."'";
		$result = db_query ( $query , 1 , 0 );
		//----------------------------------------------------------------
		if ( count ( $result ) != 0 ) // if entry is found
		 {
		 	$pattern = $result[0][0];
		 }
		else // a new entry has to be saved
	   {
	    $query  = "INSERT INTO ".$table." VALUES ( NULL , '".$value."' )";
		  $result = db_query ( $query , 0 , 0 );

		  $query  = "SELECT id FROM ".$table." WHERE ".$meta."='".$value."'";
		  $result = db_query ( $query , 1 , 0 );
		  $pattern = $result[0][0];
	   }
	  //----------------------------------------------------------------
	  return $pattern; // return pattern name
    //----------------------------------------------------------------
   }
  else
   {
	  //----------------------------------------------------------------
	  if ( $meta == "site_name"         ) { $pattern_file_name = "log/pattern_site_name.dta";        }
	  if ( $meta == "site_name_reverse" ) { $pattern_file_name = "config/pattern_site_name.inc";     }
	  if ( $meta == "resolution"        ) { $pattern_file_name = "log/pattern_resolution.dta";       }
	  if ( $meta == "browser"           ) { $pattern_file_name = "log/pattern_browser.dta";          }
	  if ( $meta == "operating_system"  ) { $pattern_file_name = "log/pattern_operating_system.dta"; }
	  if ( $meta == "referer"           ) { $pattern_file_name = "log/pattern_referer.dta";          }
    //----------------------------------------------------------------
	  $write_new_entry = 1; // flag to check if an entry is not found
    //----------------------------------------------------------------
	  $pattern_file = fopen ( $pattern_file_name , "r" );
	  while ( !FEOF ( $pattern_file ) )
	   {
	    $pattern_file_entry = fgetcsv ( $pattern_file , 6000 , "|" );

	    if ( $pattern_file_entry [ 0 ] == $value ) // if entry is found
	     {
	      $pattern = $pattern_file_entry [ 1 ]; // get the pattern name
	      $write_new_entry = 0; // set flag to not write a new entry
	     }
	   }
	  fclose ( $pattern_file );
	  unset  ( $pattern_file );
    //----------------------------------------------------------------
	  if ( ( $write_new_entry == 1 ) && ( $meta == "site_name_reverse" ) )
	   {
	    $pattern = $value; // if meta = site_name, the former value will be given back
	   }
    //----------------------------------------------------------------
	  if ( ( $write_new_entry == 1 ) && ( $meta != "site_name_reverse" ) )  // if flag has not been changed, a new entry has to be saved
	   {
	    $pattern_file = fopen ( $pattern_file_name , "a+" );
	     flock  ( $pattern_file , 2 );
	      fwrite ( $pattern_file , "\n".$value."|".( $pattern_file_entry [ 1 ] + 1 ) ); // the last entry in the pattern has been read. so we can take the number and add a 1
	     flock  ( $pattern_file , 3 );
	    fclose ( $pattern_file );
	    unset  ( $pattern_file );
	    $pattern = ( $pattern_file_entry [ 1 ] + 1); // return the new pattern
	   }
    //----------------------------------------------------------------
	  return $pattern; // return pattern name
	  //----------------------------------------------------------------
	 }
 }
//------------------------------------------------------------------------------
// get all pattern names and put them in a global array

// the following lines kill special characters by reading the file
// thats why we added the other lines below (PHP ERROR ?!?)

/*
$global_site_names_reverse = array ();
$pattern_file = fopen ( "config/pattern_site_name.inc" , "r" );
 while ( !FEOF ( $pattern_file ) )
  {
   $pattern_file_entry = fgetcsv ( $pattern_file , 6000 , "|" );
   if ( $pattern_file_entry [ 0 ] != "" )
    {
     $global_site_names_reverse [ $pattern_file_entry [ 0 ] ] = $pattern_file_entry [ 1 ];
    }
  }
fclose ( $pattern_file );
unset  ( $pattern_file );
*/
//------------------------------------------------------------------------------
$pattern_file = file ( "config/pattern_site_name.inc" );
foreach ( $pattern_file as $line )
 {
   $temp_line = explode ( "|" , $line );
    if ( $temp_line [ 0 ] != "" )
    {
     $global_site_names_reverse [ $temp_line [ 0 ] ] = $temp_line [ 1 ];
    }
 }
unset  ( $pattern_file );
unset ( $temp_line );
//------------------------------------------------------------------------------
function pattern_matching_reverse ( $meta , $value ) // only for site_name_reverse
 {
  //------------------------------------------------------------------
  if ( @array_key_exists ( $value , $GLOBALS [ "global_site_names_reverse" ] ) )
   { return $GLOBALS [ "global_site_names_reverse" ] [ $value ]; }
  else
   { return $value; }
  //------------------------------------------------------------------
 }
//------------------------------------------------------------------------------
// get all replace names and put them in global array's
$i = -1;
$pattern_file = fopen ( "config/pattern_string_replace.inc" , "r" );
while ( !FEOF ( $pattern_file ) )
 {
  $pattern_file_entry = fgetcsv ( $pattern_file , 6000 , "|" );
  if ( $pattern_file_entry [ 0 ] != "" )
   {
    $i++;
    $replace_from [ $i ] = $pattern_file_entry [ 0 ];
    $replace_to   [ $i ] = $pattern_file_entry [ 1 ];
   }
 }
fclose ( $pattern_file );
unset  ( $pattern_file );
//------------------------------------------------------------------------------
?>