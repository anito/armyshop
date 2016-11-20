<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.8.x                                                    #
# File-Release-Date:  13/07/14                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2013 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
//------------------------------------------------------------------------------
include ( "config/config.php"                 ); // include path to logfile
//------------------------------------------------------------------------------
// check if the cronjob parameter (password) is given, else check for the session
$loggedin = 0;
#if ( !$_GET [ "pw" ] )
if ( !isset ( $_GET [ "pw" ] ) )
 {
  @session_start(); if ( $_SESSION [ "hidden_stat" ] != md5_file ( "config/config.php" ) ) { include ( "func/func_error.php" ); exit; }
 }
else
 {
  if ( ( md5 ( $adminpassword ) != md5 ( $_GET [ "pw" ] ) ) && ( $_GET [ "pw" ] != "update" ) )
   {
    include ( "func/func_error.php" );
    exit;
   }
  else { $loggedin = 1; }
 }
//------------------------------------------------------------------------------
@ini_set ( "max_execution_time","false"       ); // set the script time
//@set_time_limit ( 0 );
//------------------------------------------------------------------------------
include ( "config/config.php"                 ); // include path to logfile
include ( $language                           ); // include language vars
include ( $language_patterns                  ); // include language country vars
//------------------------------------------------------------------------------
if ( $error_reporting == 0 ) { error_reporting(0); }
//------------------------------------------------------------------------------
if ( $db_active == 1 )
 {
  include ( "config/config_db.php"            ); // include db prefix
  include ( "db_connect.php"                  ); // include database connection
 }
 //------------------------------------------------------------------------------
include ( "func/func_pattern_reverse.php"     ); // include pattern reverse function
include ( "func/func_pattern_matching.php"    ); // include pattern matching function
include ( "func/func_kill_special_chars.php"  ); // include umlaut function
//------------------------------------------------------------------------------
if ( $db_active == 1 )
 {  }
else
 {
  if ( $loggedin == 1 ) { $logfile_choosed = "log/logdb.dta"; }
  else
   {
        if ( $_GET [ "loadfile" ] == 1 ) { $logfile_choosed = "log/logdb.dta";        }
    elseif ( $_GET [ "loadfile" ] == 2 ) { $logfile_choosed = "log/logdb_backup.dta"; }
      else { $logfile_choosed = "log/logdb.dta"; }
   }
 }
//------------------------------------------------------------------------------
$write_cache          = 0;
$last_logfile_entry   = 0;
$last_memory_address  = 0;
$cache_memory_address = 0;
//------------------------------------------------------------------------------
// set the hour values to zero
for ( $x = 0 ; $x < 24 ; $x++ )
 {
  if ( $x <= 9 ) { $visitor_hour [ "0".$x.":00" ] = 0; }
  else { $visitor_hour [ $x.":00"     ] = 0; }
 }
################################################################################
### archive function ###
if ( $_GET [ "archive" ] )
 {
  include ( "log/cache_time_stamp_archive.php" );           // include the last timestamp
  include ( "log/cache_visitors_archive.php"   );           // include the saved arrays
  $temp_interval   = explode ( "-" , strip_tags ( $_GET [ "archive" ] ) ); // get the posted interval
  $from_timestamp  = trim ( $temp_interval [ 0 ] );         // from timestamp
  $until_timestamp = trim ( $temp_interval [ 1 ] );         // until timestamp
  if ( $db_active == 1 )
   {
    if ( !$cache_time_stamp ) { $cache_time_stamp = 0; }
   }
  else
   {
    include ( "log/index_days.php" );
    if ( array_key_exists ( $from_timestamp , $index_days ) ) { $cache_memory_address = $index_days [ $from_timestamp ]; } else { $cache_memory_address = 0; }
   }
 }
else
 {
  if ( $db_active != 1 ) { include ( "log/cache_memory_address.php" ); } // include physical address of last read entry
  include ( "log/cache_time_stamp.php" ); // include the last timestamp
  include ( "log/cache_visitors.php"   ); // include the saved arrays
  $from_timestamp  = 1;                   // from timestamp
  if ( $db_active == 1 )
   {
    //------------------------------
    $query           = "SELECT MAX(timestamp) FROM ".$db_prefix."_main";
    $result          = db_query ( $query , 1 , 0 );
    $until_timestamp = $result[0][0];
    if ( !$cache_time_stamp ) { $cache_time_stamp = 0; }
    //------------------------------
   }
  else
   {
    //------------------------------
    $until_timestamp = 999999999999999999;  // until timestamp
    //------------------------------
   }
 }
################################################################################
### fill values ###
if ( !$visitor )
 {
  $visitor = array ( );
 }
//--------------
if ( !$javascript_status )
 {
  $javascript_status = array ( );
 }
################################################################################
### search engine terms ###
function get_search_terms ( $value )
 {
   //----------------------------------------------------------------------------
  parse_str ( str_replace ( "?" , "&" , "___url_http_referer=".$value ) , $vars );
  $searchengine = "";
  $altterms     = "";
  //--------------
  if ( !array_key_exists ( "su"            , $vars) ) $vars [ "su"            ] = "";   // WEB.de
  if ( !array_key_exists ( "catId"         , $vars) ) $vars [ "catId"         ] = "";   // AOL Katalog
  if ( !array_key_exists ( "dt"            , $vars) ) $vars [ "dt"            ] = "";   // Google Syndication
  //--------------
  if ( !array_key_exists ( "q"             , $vars) ) $vars [ "q"             ] = "";
  if ( !array_key_exists ( "p"             , $vars) ) $vars [ "p"             ] = "";
  if ( !array_key_exists ( "query"         , $vars) ) $vars [ "query"         ] = "";
  if ( !array_key_exists ( "search"        , $vars) ) $vars [ "search"        ] = "";
  if ( !array_key_exists ( "Keywords"      , $vars) ) $vars [ "Keywords"      ] = "";
  if ( !array_key_exists ( "ask"           , $vars) ) $vars [ "ask"           ] = "";
  if ( !array_key_exists ( "qkw"           , $vars) ) $vars [ "qkw"           ] = "";
  if ( !array_key_exists ( "searchfor"     , $vars) ) $vars [ "searchfor"     ] = "";
  if ( !array_key_exists ( "terms"         , $vars) ) $vars [ "terms"         ] = "";
  if ( !array_key_exists ( "search_string" , $vars) ) $vars [ "search_string" ] = "";   //webinfo fi
  //--------------
  if ( preg_match ("/http.+216.239\..+\/.+/"            ,$vars["___url_http_referer"] ) ) { $searchengine = "Google";              $terms = $vars [ "q"             ]; }
  if ( preg_match ("/http.+216.239\..+\/.+/"            ,$vars["___url_http_referer"] ) ) { $searchengine = "Google";              $terms = $vars [ "search"        ]; }
  if ( preg_match ("/http.+64.233\..+\/.+/"             ,$vars["___url_http_referer"] ) ) { $searchengine = "Google";              $terms = $vars [ "q"             ]; }
  if ( preg_match ("/http.+64.233\..+\/.+/"             ,$vars["___url_http_referer"] ) ) { $searchengine = "Google";              $terms = $vars [ "search"        ]; }
  if ( preg_match ("/http.+\.about\..+\/.+/"            ,$vars["___url_http_referer"] ) ) { $searchengine = "About";               $terms = $vars [ "terms"         ]; }
  if ( preg_match ("/http.+alltheweb\..+\/.+/"          ,$vars["___url_http_referer"] ) ) { $searchengine = "AllTheWeb";           $terms = $vars [ "q"             ]; }
  if ( preg_match ("/http.+\.aol\..+\/.+/"              ,$vars["___url_http_referer"] ) ) { $searchengine = "AOL";                 $terms = $vars [ "q"             ]; }
  if ( preg_match ("/http.+\.aolsvc\..+\/.+/"           ,$vars["___url_http_referer"] ) ) { $searchengine = "AOL Katalog";         $terms = $vars [ "catId"         ]; }
  if ( preg_match ("/http.+altavista\..+\/.+/"          ,$vars["___url_http_referer"] ) ) { $searchengine = "Altavista";           $terms = $vars [ "q"             ]; }
  if ( preg_match ("/http.+\.ask\..+\/.+/"              ,$vars["___url_http_referer"] ) ) { $searchengine = "Ask.com";             $terms = $vars [ "q"             ]; }
  if ( preg_match ("/http.+\.bing\..+\/.+/"             ,$vars["___url_http_referer"] ) ) { $searchengine = "Bing";                $terms = $vars [ "q"             ]; }
  if ( preg_match ("/http.+clusty\..+\/.+/"             ,$vars["___url_http_referer"] ) ) { $searchengine = "Clusty";              $terms = $vars [ "query"         ]; }
  if ( preg_match ("/http.+\.dmoz\..+\/.+/"             ,$vars["___url_http_referer"] ) ) { $searchengine = "dmoz";                $terms = $vars [ "search"        ]; }
  if ( preg_match ("/http.+duckduckgo\..+\/.+/"         ,$vars["___url_http_referer"] ) ) { $searchengine = "DuckDuckGo";          $terms = $vars [ "q"             ]; }
  if ( preg_match ("/http.+\.excite\..+\/.+/"           ,$vars["___url_http_referer"] ) ) { $searchengine = "Excite";              $terms = $vars [ "qkw"           ]; }
  if ( preg_match ("/http.+\.exactseek\..+\/.+/"        ,$vars["___url_http_referer"] ) ) { $searchengine = "ExactSeek";           $terms = $vars [ "q"             ]; }
  if ( preg_match ("/http.+fireball\..+\/.+/"           ,$vars["___url_http_referer"] ) ) { $searchengine = "FireBall";            $terms = $vars [ "query"         ]; }
  if ( preg_match ("/http.+\.gigablast\..+\/.+/"        ,$vars["___url_http_referer"] ) ) { $searchengine = "GigaBlast";           $terms = $vars [ "q"             ]; }
  if ( preg_match ("/http.+google\..+\/.+/"             ,$vars["___url_http_referer"] ) ) { $searchengine = "Google";              $terms = $vars [ "q"             ]; }
  if ( preg_match ("/http.+googlesyndication\..+\/.+/"  ,$vars["___url_http_referer"] ) ) { $searchengine = "Google Syndication";  $terms = $vars [ "dt"            ]; }
  if ( preg_match ("/http.+hotbot\..+\/+/"              ,$vars["___url_http_referer"] ) ) { $searchengine = "HotBot";              $terms = $vars [ "query"         ]; }
  if ( preg_match ("/http.+\.iwon\.com.+\/.+/"          ,$vars["___url_http_referer"] ) ) { $searchengine = "IWon";                $terms = $vars [ "searchfor"     ]; }
  if ( preg_match ("/http.+\.Ixquick\..+\/.+/"          ,$vars["___url_http_referer"] ) ) { $searchengine = "Ixquick";             $terms = $vars [ "q"             ]; }
  if ( preg_match ("/http.+\.jayde\..+\/.+/"            ,$vars["___url_http_referer"] ) ) { $searchengine = "Jayde";               $terms = $vars [ "query"         ]; }
  if ( preg_match ("/http.+\.looksmart\..+\/.+/"        ,$vars["___url_http_referer"] ) ) { $searchengine = "LookSmart";           $terms = $vars [ "key"           ]; }
  if ( preg_match ("/http.+\.lycos\..+\/.+/"            ,$vars["___url_http_referer"] ) ) { $searchengine = "Lycos";               $terms = $vars [ "query"         ]; }
  if ( preg_match ("/http.+mamma.com\/+/"               ,$vars["___url_http_referer"] ) ) { $searchengine = "Mamma";               $terms = $vars [ "query"         ]; }
  if ( preg_match ("/http.+\.msn\..+\/.+/"              ,$vars["___url_http_referer"] ) ) { $searchengine = "MSN";                 $terms = $vars [ "q" ]; $altterms = $vars [ "origq" ]; }
  if ( preg_match ("/http.+netscape\..+\/.+/"           ,$vars["___url_http_referer"] ) ) { $searchengine = "Netscape";            $terms = $vars [ "query"         ]; }
  if ( preg_match ("/http.+\.overture\..+\/.+/"         ,$vars["___url_http_referer"] ) ) { $searchengine = "Overture";            $terms = $vars [ "Keywords"      ]; }
  if ( preg_match ("/http.+\.live\..+\/.+/"             ,$vars["___url_http_referer"] ) ) { $searchengine = "Windows Live Search"; $terms = $vars [ "q"             ]; }
  if ( preg_match ("/http.+search.com\/+/"              ,$vars["___url_http_referer"] ) ) { $searchengine = "Search";              $terms = $vars [ "q"             ]; }
  if ( preg_match ("/http.+\.teoma\..+\/.+/"            ,$vars["___url_http_referer"] ) ) { $searchengine = "Teoma";               $terms = $vars [ "query"         ]; }
  if ( preg_match ("/http.+\.web\.de.+\/.+/"            ,$vars["___url_http_referer"] ) ) { $searchengine = "WEB.de";              $terms = $vars [ "su"            ]; }
  if ( preg_match ("/http.+\.webcrawler\.com.+\/.+/"    ,$vars["___url_http_referer"] ) ) { $searchengine = "WebCrawler";          $terms = $vars [ "qkw"           ]; }
  if ( preg_match ("/http.+\.whatuseek\..+\/.+/"        ,$vars["___url_http_referer"] ) ) { $searchengine = "WhatUSeek";           $terms = $vars [ "q"             ]; }
  if ( preg_match ("/http.+wisenut\..+\/.+/"            ,$vars["___url_http_referer"] ) ) { $searchengine = "WiseNet";             $terms = $vars [ "q"             ]; }
  if ( preg_match ("/http.+\.yahoo\..+\/.+/"            ,$vars["___url_http_referer"] ) ) { $searchengine = "Yahoo";               $terms = $vars [ "p"             ]; }
  if ( preg_match ("/http.+\.rambler\..+\/.+/"          ,$vars["___url_http_referer"] ) ) { $searchengine = "Rambler";             $terms = $vars [ "words"         ]; }
  if ( preg_match ("/http.+\.yandex\..+\/.+/"           ,$vars["___url_http_referer"] ) ) { $searchengine = "Yandex";              $terms = $vars [ "text"          ]; }
  if ( preg_match ("/http.+go\.mail\..+\/.+/"           ,$vars["___url_http_referer"] ) ) { $searchengine = "Mail.ru Search";      $terms = $vars [ "q"             ]; }
  if ( preg_match ("/http.+\.eniro\..+\/.+/"            ,$vars["___url_http_referer"] ) ) { $searchengine = "Eniro.fi";            $terms = $vars [ "query"         ]; }
  if ( preg_match ("/http.+haku2\.webinfo\..+\/.+/"     ,$vars["___url_http_referer"] ) ) { $searchengine = "Webinfo.fi";          $terms = $vars [ "search_string" ]; }
  //--------------
  $terms = strtolower  ( $terms );             // string to lower
  $terms = str_replace ( "+" , " " , $terms ); // replace + with space
  $terms = str_replace ( "-" , " " , $terms ); // replace - with space
  //--------------
  if ( $searchengine )
   {
    //--------------
    $message    = $searchengine;
    $termarray  = preg_split ( "/ /" , $terms );
    $search_words_temp = "";
    //--------------
    while ( list ( $key , $value ) = each ( $termarray ) )
     {
      $message.= " ".$value;
      $search_words_temp.= $value." ";
     }
    //--------------
    if( $altterms )
     {
      $termarray = preg_split("/ /",$altterms );
      while ( list  ( $key , $value) = each ( $termarray ) )
       {
        $message.= " ".$value;
        $search_words_temp.= $value." ";
       }
     }
    //--------------
   }
  //--------------
  $search_back = array ();
  $search_back [ 0 ] = $searchengine;
  $search_back [ 1 ] = $search_words_temp;
  return $search_back;
   //----------------------------------------------------------------------------
 }
################################################################################
### core function ###
if ( $db_active == 1 )
 {
  //----------------------------------------------------------------------------
  // get the data from the stat_main table
  if ( $_GET [ "archive" ] )
   {
    $query = "SELECT ".$db_prefix."_main.timestamp,".$db_prefix."_main.ip_address,".$db_prefix."_main.browser,".$db_prefix."_main.operating_system,".$db_prefix."_main.site_name,".$db_prefix."_main.referrer,".$db_prefix."_main.resolution,".$db_prefix."_main.color_depth,".$db_prefix."_main.country_code FROM ".$db_prefix."_main WHERE ".$db_prefix."_main.timestamp > ".$cache_time_stamp." AND ".$db_prefix."_main.timestamp BETWEEN ".$from_timestamp." AND ".$until_timestamp." ORDER BY ".$db_prefix."_main.timestamp LIMIT 0,".$creator_number;
   }
  else
   {
    $query = "SELECT ".$db_prefix."_main.timestamp,".$db_prefix."_main.ip_address,".$db_prefix."_main.browser,".$db_prefix."_main.operating_system,".$db_prefix."_main.site_name,".$db_prefix."_main.referrer,".$db_prefix."_main.resolution,".$db_prefix."_main.color_depth,".$db_prefix."_main.country_code FROM ".$db_prefix."_main WHERE ".$db_prefix."_main.timestamp > ".$cache_time_stamp." ORDER BY ".$db_prefix."_main.timestamp LIMIT 0,".$creator_number;
   }

  $result  = db_query ( $query , 1 , 0 );
  $counter = count ( $result );
  //------------------------------------------------------------------------------
  // 0            1               2               3                 4           5                                   6           7             8
  // timestamp     ip_address       browser         operating_system   site_name   referrer                             resolution   color_depth   country_code
  // 1200183752   80.137.211.116   Firefox 2.0.0   Windows Vista     index.html   http://www.bluecay.com/index.html   1280x800     32             de
  //------------------------------------------------------------------------------
  if ( $counter == 0 )
   {
    $loader_finished = 1;
   }
  else
   {
    //------------------------------------------------------------------
    for ( $x = 0 ; $x <= count ( $result ) - 1 ; $x++ )
     {
      //------------------------------------------------------------------
      #echo $result[$x][0]."-".$result[$x][1]."-".$result[$x][2]."-".$result[$x][3]."-".$result[$x][4]."-".$result[$x][5]."-".$result[$x][6]."-".$result[$x][7]."-".$result[$x][8]."<br>";
      //------------------------------------------------------------------
      $write_cache = 1;                           // if new entries are found
      $last_logfile_entry = $result [ $x ] [ 0 ]; // last logfile entry for the cache
      $site_name [ $result [ $x ] [ 4 ] ]++;      // count site_name without timestamp
      //-----------------------
      $exception_domain_found = 0;
      foreach ( $exception_domain as $value )
       {
        if ( strpos ( substr ( $pattern_referer [ $result[$x][5] ] , 0 , strpos ( $pattern_referer [ $result[$x][5] ]."/" , "/" , 7 ) ) , $value ) !== FALSE )
         {
          $exception_domain_found = 1;
         }
       }
      //-----------------------
      if ( ( $pattern_referer [ $result[$x][5] ] != "---" ) && ( $exception_domain_found == 0 ) ) // if there is no referer and the referer is not found in the exception domain array
       {
        //---------------------------
        $exception_domain_found = 0; // set back that it is an internal referer
        //---------------------------
        // get search engine and search engine terms
        $temp_back_array = array ();
        $temp_back_array = get_search_terms ( $pattern_referer [ $result[$x][5] ] );
        $searchengine = $temp_back_array [ 0 ];
        $search_words_temp = kill_special_chars ( $temp_back_array [ 1 ] );
        unset ( $temp_back_array );
        //---------------------------------------------------------------------
        if ( trim ( $searchengine ) != "" )
         {
          $searchengines_archive [ $searchengine ]++;
         }
        if ( trim ( $search_words_temp ) != "" )
         {
          $searchwords_archive [ trim ( $search_words_temp ) ]++;
         }
        //---------------------------------------------------------------------
        if ( $show_detailed_referer == 0 )
         {
          $referer [ substr ( $pattern_referer [ $result[$x][5] ] , 0 , strpos ( substr ( $pattern_referer [ $result[$x][5] ] , 7 ) , "/" ) + 7 ) ]++;
         }
        else
         {
          $special_referer_url           = $pattern_referer [ $result[$x][5] ];
          $special_referer_url_parameter = array ( "q" , "search" , "query" , "ask" , "terms" , "key" , "qkw" , "su" , "dt" , "Keywords" , "origq" , "catId" );

          $special_referer_temp_site_name   = substr ( strstr ( substr ( $special_referer_url , 7 ) , "/" ) , 1 );
          $special_referer_temp_url = parse_url ( $special_referer_url );
          parse_str ( $special_referer_temp_url [ "query" ] , $special_referer_temp_parameter );
          $special_referer_temp_check_name_value = 0;
          $special_referer_temp_name = substr ( basename ( $special_referer_url ) , 0 , strpos ( basename ( $special_referer_url ) , "?" ) );
          foreach ( $special_referer_temp_parameter as $key=>$value )
           {
            if ( in_array ( $key , $special_referer_url_parameter ) )
             {
              $special_referer_temp_check_name.= $key."=".$value."&";
              $special_referer_temp_check_name_value = 1;
             }
           }
          if ( $special_referer_temp_check_name_value == 1 )
           {
            $special_referer_temp_check_name = dirname ( $special_referer_url )."/".$special_referer_temp_name."?".substr ( $special_referer_temp_check_name , 0 , strlen ( $special_referer_temp_check_name ) - 1 );
           }
          if ( $special_referer_temp_check_name_value == 0 )
           {
            $special_referer_temp_check_name = $pattern_referer [ $result[$x][5] ];
           }

          $referer [ $special_referer_temp_check_name ]++; // count referer without timestamp

          unset ( $special_referer_temp_check_name );
          unset ( $special_referer_temp_check_name_value );
          unset ( $special_referer_temp_name );
          unset ( $special_referer_temp_url );
          unset ( $special_referer_temp_site_name );
          unset ( $special_referer_url );
          unset ( $special_referer_url_parameter );
         }
        $entrysite [ $result[$x][4] ]++; // save the entry site
       }
      unset ( $message           );
      unset ( $search_words_temp );
      unset ( $term_array        );
      unset ( $terms             );
      unset ( $altterms          );
      unset ( $vars              );
      //------------------------------------------------------------------
      // if ip-address found and timestamp <= timestamp+recount_time
      if ( ( array_key_exists ( $result [ $x ] [ 1 ] , $visitor ) )  && ( $result [ $x ] [ 0 ] <= $visitor [ $result [ $x ] [ 1 ] ] ) )
       {  }
      else
       {
        //------------------------------------------------------------------
        $visitor      [ $result [ $x ] [ 1 ] ] =  $result [ $x ] [ 0 ] + ( $ip_recount_time * 60 );
        $visitor_hour [ date ( "H:00"  , $result[$x][0] ) ]++;
        $visitor_day  [ date ( "y/m/d" , $result[$x][0] ) ]++;
        //-------------
        $temp_weekday = date ( "w" , $result[$x][0] );
         if ( $temp_weekday == 0 ) { $visitor_weekday  [ "0" ]++; }
         if ( $temp_weekday == 1 ) { $visitor_weekday  [ "1" ]++; }
         if ( $temp_weekday == 2 ) { $visitor_weekday  [ "2" ]++; }
         if ( $temp_weekday == 3 ) { $visitor_weekday  [ "3" ]++; }
         if ( $temp_weekday == 4 ) { $visitor_weekday  [ "4" ]++; }
         if ( $temp_weekday == 5 ) { $visitor_weekday  [ "5" ]++; }
         if ( $temp_weekday == 6 ) { $visitor_weekday  [ "6" ]++; }
        unset ( $temp_weekday );
        //-------------
        $visitor_month    [ date ( "Y/m"   , $result[$x][0] ) ]++;
        $visitor_year     [ date ( " Y "   , $result[$x][0] ) ]++;
        $browser          [ $pattern_browser          [ $result[$x][2] ] ]++;
        $operating_system [ $pattern_operating_system [ $result[$x][3] ] ]++;
        $resolution       [ $pattern_resolution       [ $result[$x][6] ] ]++;
        //-------------
        if ( trim ( $pattern_resolution [ $result[$x][6] ] ) == "unknown" )
         {
          $javascript_status [ "Off" ]++;
         }
        else
         {
          $javascript_status [ "On" ]++;
         }
        //-------------
        if ( trim ( $result[$x][8] ) != "unknown" )
         {
          $country [ $result[$x][8] ]++;
         }
        else
         {
          $country [ "unknown" ]++;
         }
        //-------------
        if ( $result[$x][7] == "32" ) { $color_depth [ $lang_colordepth [ 3 ] ]++; }
        if ( $result[$x][7] == "16" ) { $color_depth [ $lang_colordepth [ 4 ] ]++; }
        if ( $result[$x][7] == "24" ) { $color_depth [ $lang_colordepth [ 5 ] ]++; }
        if ( $result[$x][7] == "8"  ) { $color_depth [ $lang_colordepth [ 6 ] ]++; }
        if ( $result[$x][7] == "4"  ) { $color_depth [ $lang_colordepth [ 7 ] ]++; }
        if ( $result[$x][7] == "2"  ) { $color_depth [ $lang_colordepth [ 8 ] ]++; }
        if ( $result[$x][7] == "0"  ) { $color_depth [ $lang_module     [ 3 ] ]++; }
        //------------------------------------------------------------------
       }
       //------------------------------------------------------------------
     }
    //------------------------------------------------------------------
   }
  //----------------------------------------------------------------------------
 }
else
 {
  //----------------------------------------------------------------------------
  // get the data from logfile
  $loader_counter_now = 0; // set the amount of lines read to zero

  $logfile = fopen ( $logfile_choosed , "rb" ); // open logfile
  @fseek ( $logfile , $cache_memory_address );
  while ( !FEOF ( $logfile ) && ( $loader_counter_now <= $creator_number ) ) // as long as there are entries
   {
    //------------------------------------------------------------------
    $logfile_entry = fgetcsv ( $logfile , 60000 , "|" ); // read entry from logfile

    if ( ( trim ( $logfile_entry [ 0 ] ) != "" ) && ( trim ( $logfile_entry [ 0 ] ) >= trim ( $until_timestamp ) ) )
     {
      $loader_finished = 1;
     }

    if ( ( trim ( $logfile_entry [ 0 ] ) != "" ) && ( $logfile_entry [ 0 ] > $cache_time_stamp ) && ( $loader_counter_now <= $creator_number ) && ( $logfile_entry [ 0 ] >= $from_timestamp ) && ( $logfile_entry [ 0 ] <= $until_timestamp ) )
     {
      //------------------------------------------------------------------
      $loader_counter_now++;                               // increase the amount of lines count
      $write_cache = 1;                                    // if new entries are found
      $last_logfile_entry  = $logfile_entry [ 0 ];         // last logfile entry for the cache
      $last_memory_address = ftell ( $logfile );           // last physical address of the last read entry for the cache
      $site_name [ $logfile_entry [ 4 ] ]++;               // count site_name without timestamp
      $temp_referer = $pattern_referer [ $logfile_entry [ 5 ] ];

      $exception_domain_found = 0;
      if ( !empty ( $temp_referer ) )
       {
        foreach ( $exception_domain as $value )
         {
          if ( strpos ( substr ( $temp_referer , 0 , strpos ( $temp_referer."/" , "/" , 7 ) ) , $value ) !== FALSE )
           {
            $exception_domain_found = 1;
           }
         }
       }

      if ( ( trim ( $logfile_entry [ 5 ] ) != "" ) && ( $exception_domain_found == 0 ) ) // if there is no referer and the referer is not found in the exception domain array
       {
        //---------------------------
        $exception_domain_found = 0; // set back that it is an internal referer
        //---------------------------
        // get search engine and search engine terms
        $temp_back_array = array ();
        $temp_back_array = get_search_terms ( $temp_referer );
        $searchengine = $temp_back_array [ 0 ];
        $search_words_temp = kill_special_chars ( $temp_back_array [ 1 ] );
        unset ( $temp_back_array );
        //---------------------------------------------------------------------
        if ( trim ( $searchengine ) != "" )
         {
          $searchengines_archive [ $searchengine ]++;
         }
        if ( trim ( $search_words_temp ) != "" )
         {
          $searchwords_archive [ trim ( $search_words_temp ) ]++;
         }
        //---------------------------------------------------------------------
        if ( $show_detailed_referer == 0 )
         {
          $referer [ substr ( $temp_referer , 0 , strpos ( substr ( $temp_referer , 7 ) , "/" ) + 7 ) ]++;
         }
        else
         {
          $special_referer_url           = $temp_referer;
          $special_referer_url_parameter = array ( "q" , "search" , "query" , "ask" , "terms" , "key" , "qkw" , "su" , "dt" , "Keywords" , "origq" , "catId" );

          $special_referer_temp_site_name   = substr ( strstr ( substr ( $special_referer_url , 7 ) , "/" ) , 1 );
          $special_referer_temp_url = parse_url ( $special_referer_url );
          parse_str ( $special_referer_temp_url [ "query" ] , $special_referer_temp_parameter );
          $special_referer_temp_check_name_value = 0;
          $special_referer_temp_name = substr ( basename ( $special_referer_url ) , 0 , strpos ( basename ( $special_referer_url ) , "?" ) );
          foreach ( $special_referer_temp_parameter as $key=>$value )
           {
            if ( in_array ( $key , $special_referer_url_parameter ) )
             {
              $special_referer_temp_check_name.= $key."=".$value."&";
              $special_referer_temp_check_name_value = 1;
             }
           }
          if ( $special_referer_temp_check_name_value == 1 )
           {
            $special_referer_temp_check_name = dirname ( $special_referer_url )."/".$special_referer_temp_name."?".substr ( $special_referer_temp_check_name , 0 , strlen ( $special_referer_temp_check_name ) - 1 );
           }
          if ( $special_referer_temp_check_name_value == 0 )
           {
            $special_referer_temp_check_name = $temp_referer;
           }

          $referer [ $special_referer_temp_check_name ]++; // count referer without timestamp

          unset ( $special_referer_temp_check_name );
          unset ( $special_referer_temp_check_name_value );
          unset ( $special_referer_temp_name );
          unset ( $special_referer_temp_url );
          unset ( $special_referer_temp_site_name );
          unset ( $special_referer_url );
          unset ( $special_referer_url_parameter );
         }
        $entrysite [ $logfile_entry [ 4 ] ]++; // save the entry site
       }
      unset ( $temp_referer      );
      unset ( $message           );
      unset ( $search_words_temp );
      unset ( $term_array        );
      unset ( $terms             );
      unset ( $altterms          );
      unset ( $vars              );
      //------------------------------------------------------------------
      // if ip-address found and timestamp <= timestamp+recount_time
      if ( ( array_key_exists ( $logfile_entry [ 1 ] , $visitor ) )  && ( $logfile_entry [ 0 ]  <= $visitor [ $logfile_entry [ 1 ] ]  ) )
       {  }
      else
       {
        //------------------------------------------------------------------
        $visitor      [ $logfile_entry [ 1 ] ] =  $logfile_entry [ 0 ] + ( $ip_recount_time * 60 );
        $visitor_hour [ date ( "H:00"  , $logfile_entry  [ 0 ] ) ]++;
        $visitor_day  [ date ( "y/m/d" , $logfile_entry  [ 0 ] ) ]++;
        //-------------
        $temp_weekday = date ( "w" , $logfile_entry  [ 0 ] );
         if ( $temp_weekday == 0 ) { $visitor_weekday  [ "0" ]++; }
         if ( $temp_weekday == 1 ) { $visitor_weekday  [ "1" ]++; }
         if ( $temp_weekday == 2 ) { $visitor_weekday  [ "2" ]++; }
         if ( $temp_weekday == 3 ) { $visitor_weekday  [ "3" ]++; }
         if ( $temp_weekday == 4 ) { $visitor_weekday  [ "4" ]++; }
         if ( $temp_weekday == 5 ) { $visitor_weekday  [ "5" ]++; }
         if ( $temp_weekday == 6 ) { $visitor_weekday  [ "6" ]++; }
        unset ( $temp_weekday );
        //-------------
        $visitor_month    [ date ( "Y/m"   , $logfile_entry  [ 0 ] ) ]++;
        $visitor_year     [ date ( " Y "   , $logfile_entry  [ 0 ] ) ]++;
        $browser          [ $pattern_browser          [ $logfile_entry [ 2 ] ] ]++;
        $operating_system [ $pattern_operating_system [ $logfile_entry [ 3 ] ] ]++;
        $resolution       [ $pattern_resolution       [ $logfile_entry [ 6 ] ] ]++;
        //-------------
        if ( trim ( $logfile_entry [ 6 ] ) == "" )
         {
          $javascript_status [ "Off" ]++;
         }
        else
         {
          $javascript_status [ "On" ]++;
         }
        //-------------
        if ( trim ( $logfile_entry [ 8 ] ) != "" )
         {
          $country [ strtolower ( $logfile_entry [ 8 ] ) ]++;
         }
        else
         {
          $country [ "unknown" ]++;
         }
        //-------------
        if ( $logfile_entry [ 7 ] == "32"  ) { $color_depth [ $lang_colordepth [ 3 ] ]++; }
        if ( $logfile_entry [ 7 ] == "16"  ) { $color_depth [ $lang_colordepth [ 4 ] ]++; }
        if ( $logfile_entry [ 7 ] == "24"  ) { $color_depth [ $lang_colordepth [ 5 ] ]++; }
        if ( $logfile_entry [ 7 ] == "8"   ) { $color_depth [ $lang_colordepth [ 6 ] ]++; }
        if ( $logfile_entry [ 7 ] == "4"   ) { $color_depth [ $lang_colordepth [ 7 ] ]++; }
        if ( $logfile_entry [ 7 ] == "2"   ) { $color_depth [ $lang_colordepth [ 8 ] ]++; }
        if ( trim ( $logfile_entry [ 7 ] ) == "" ) { $color_depth [ $lang_module [ 3 ] ]++; }
        //------------------------------------------------------------------
       }
      //------------------------------------------------------------------
     }
    //------------------------------------------------------------------
   }
  if ( FEOF ( $logfile ) )
   {
    $loader_finished = 1;
   }

  fclose ( $logfile ); // close logfile
  unset  ( $logfile );
  //----------------------------------------------------------------------------
 }
################################################################################
### save the last logfile entry of the timestamp ###
if ( $write_cache == 1 )
 {
  if ( $_GET [ "archive" ] )
   {
    $cache_time_stamp_file = fopen ( "log/cache_time_stamp_archive.php" , "w+" );
   }
  else
   {
    //------------------------------------------------------------------
    // save the last read physical address of the last entry of the read entry
    if ( $db_active != 1 )
     {
      //------------------------------------------------------------------
      $cache_time_stamp_file = fopen ( "log/cache_memory_address.php" , "w+" );
       flock  ( $cache_time_stamp_file , 2 );
        fwrite ( $cache_time_stamp_file , "<?php \$cache_memory_address = \"".$last_memory_address."\";?>" ); // save the last read physical address of the logfile
       flock  ( $cache_time_stamp_file , 3 );
      fclose ( $cache_time_stamp_file );
      unset  ( $cache_time_stamp_file );
      //------------------------------------------------------------------
     }
    //------------------------------------------------------------------
    $cache_time_stamp_file = fopen ( "log/cache_time_stamp.php" , "w+" );
    //------------------------------------------------------------------
   }

   flock  ( $cache_time_stamp_file , 2 );
    fwrite ( $cache_time_stamp_file , "<?php \$cache_time_stamp = \"".$last_logfile_entry."\";?>" ); //save the last read timestamp of the logfile
   flock  ( $cache_time_stamp_file , 3 );
  fclose ( $cache_time_stamp_file );
  unset  ( $cache_time_stamp_file );
 }
################################################################################
### get the latest timestamp ###
if ( $db_active == 1 )
 {
  //------------------------------
  $query                = "SELECT MAX(timestamp) FROM ".$db_prefix."_main";
  $result_temp          = db_query ( $query , 1 , 0 );
  $loader_finished_temp = $result_temp[0][0];
  unset ( $result_temp );
  //------------------------------
 }
else
 {
  //------------------------------
  $loader_finished_temp = file_get_contents ( "log/last_timestamp.dta" );
  //------------------------------
 }
################################################################################
// if the last read logfile entry is the last timestamp in the whole logfile, set the output to "finished"
if ( $db_active == 1 )
 {
  //------------------------------
  if ( ( $last_logfile_entry == $loader_finished_temp ) || ( $cache_time_stamp == $loader_finished_temp ) || ( trim ( $result[$x][0] ) == $loader_finished_temp ) )
   {
    $loader_finished = 1;
   }
  //------------------------------
 }
else
 {
  //------------------------------
  if ( ( $last_logfile_entry == $loader_finished_temp ) || ( $cache_time_stamp == $loader_finished_temp ) || ( trim ( $logfile_entry [ 0 ] ) == $loader_finished_temp ) )
   {
    $loader_finished = 1;
   }
  //------------------------------
 }
################################################################################
### save all array entries to the cache file ###
if ( $write_cache == 1 )
 {
  if ( $_GET [ "archive" ] )
   {
    $cache_visitors_file = fopen ( "log/cache_visitors_archive.php" , "w+" );
   }
  else
   {
    $cache_visitors_file = fopen ( "log/cache_visitors.php" , "w+" );
   }
 flock  ( $cache_visitors_file , 2 );
 fwrite ( $cache_visitors_file , "<?php\n" ); // php header
//----------------
if ( $visitor )
{
 $temp_file_counter = 1;
 fwrite ( $cache_visitors_file , "\$visitor = array ( \n" ); // array header
 $count_array = count ( $visitor );
 foreach ( $visitor as $key => $value )
  {
   if ( $value >= strtotime ( "-2 days" , $cache_time_stamp ) )
    {
     if ( $temp_file_counter == $count_array )
      {
       fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" );  // array values without ","
      }
     else
      {
       fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " );  // array values with "," at the end
      }
    }
   $temp_file_counter++;
  }
 fwrite ( $cache_visitors_file , "\n);\n\n" );  // array footer
}
//----------------
if ( $visitor_hour )
{
 $temp_file_counter = 1;
 fwrite ( $cache_visitors_file , "\$visitor_hour = array ( \n" ); // array header
 $count_array = count ( $visitor_hour );
 foreach ( $visitor_hour as $key => $value )
  {
   if ( $temp_file_counter == $count_array )
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" ); // array values without ","
    }
   else
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " ); // array values with "," at the end
    }
   $temp_file_counter++;
  }
 fwrite ( $cache_visitors_file , "\n);\n\n" ); // array footer
}
//----------------
 visitor_day();
//----------------
if ( $visitor_weekday )
{
 $temp_file_counter = 1;
 fwrite ( $cache_visitors_file , "\$visitor_weekday = array ( \n" ); // array header
 $count_array = count ( $visitor_weekday );
 foreach ( $visitor_weekday as $key => $value )
  {
   if ( $temp_file_counter == $count_array )
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" ); // array values without ","
    }
   else
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " ); // array values with "," at the end
    }
   $temp_file_counter++;
  }
 fwrite ( $cache_visitors_file , "\n);\n\n" ); // array footer
}
//----------------
 visitor_month();
 visitor_year();
//----------------
if ( $browser )
{
 $temp_file_counter = 1;
 fwrite ( $cache_visitors_file , "\$browser = array ( \n" ); // array header
 $count_array = count ( $browser );
 foreach ( $browser as $key => $value )
  {
   $key = kill_special_chars ( $key );
   if ( $temp_file_counter == $count_array )
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" ); // array values without ","
    }
   else
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " ); // array values with "," at the end
    }
   $temp_file_counter++;
  }
 fwrite ( $cache_visitors_file , "\n);\n\n" ); // array footer
}
//----------------
if ( $operating_system )
{
 $temp_file_counter = 1;
 fwrite ( $cache_visitors_file , "\$operating_system = array ( \n" ); // array header
 $count_array = count ( $operating_system );
 foreach ( $operating_system as $key => $value )
  {
   $key = kill_special_chars ( $key );
   if ( $temp_file_counter == $count_array )
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" ); // array values without ","
    }
   else
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " ); // array values with "," at the end
    }
   $temp_file_counter++;
  }
 fwrite ( $cache_visitors_file , "\n);\n\n" ); // array footer
}
//----------------
if ( $resolution )
{
 $temp_file_counter = 1;
 fwrite ( $cache_visitors_file , "\$resolution = array ( \n" ); // array header
 $count_array = count ( $resolution );
 foreach ( $resolution as $key => $value )
  {
   $key = kill_special_chars ( $key );
   if ( $temp_file_counter == $count_array )
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" ); // array values without ","
    }
   else
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " ); // array values with "," at the end
    }
   $temp_file_counter++;
  }
 fwrite ( $cache_visitors_file , "\n);\n\n" ); // array footer
}
//----------------
if ( $color_depth )
{
 $temp_file_counter = 1;
 fwrite ( $cache_visitors_file , "\$color_depth = array ( \n" ); // array header
 $count_array = count ( $color_depth );
 foreach ( $color_depth as $key => $value )
  {
   $key = kill_special_chars ( $key );
   if ( $temp_file_counter == $count_array )
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" ); // array values without ","
    }
   else
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " ); // array values with "," at the end
    }
   $temp_file_counter++;
  }
 fwrite ( $cache_visitors_file , "\n);\n\n" ); // array footer
}
//----------------
if ( $javascript_status )
{
 $temp_file_counter = 1;
 fwrite ( $cache_visitors_file , "\$javascript_status = array ( \n" ); // array header
 $count_array = count ( $javascript_status );
 foreach ( $javascript_status as $key => $value )
  {
   if ( $temp_file_counter == $count_array )
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" ); // array values without ","
    }
   else
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " ); // array values with "," at the end
    }
   $temp_file_counter++;
  }
 fwrite ( $cache_visitors_file , "\n);\n\n" ); // array footer
}
//----------------
if ( $site_name )
{
 $temp_file_counter = 1;
 fwrite ( $cache_visitors_file , "\$site_name = array ( \n" ); // array header
 $count_array = count ( $site_name );
 foreach ( $site_name as $key => $value )
  {
   $key = kill_special_chars ( strip_tags ( $key ) );
   if ( trim ( $key ) == "---" ) {}
   else
    {
     if ( $temp_file_counter == $count_array )
      {
       fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" ); // array values without ","
      }
     else
      {
       fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " ); // array values with "," at the end
      }
    }
   $temp_file_counter++;
  }
 fwrite ( $cache_visitors_file , "\n);\n\n" ); // array footer
}
//----------------
if ( $referer )
{
 //----------------
 // Delete all referer data with just < settings from admin center
 if ( ( $creator_referer_cut != 0 ) && ( count ( $referer ) > 5000 ) )
  {
   asort ( $referer );
   foreach ( $referer as $key => $value )
    {
     if ( $value < ( $creator_referer_cut + 1 ) ) { unset ( $referer [ $key ] ); }
     else { break; }
    }
  }
 //----------------
 $temp_file_counter = 1;
 fwrite ( $cache_visitors_file , "\$referer = array ( \n" ); // array header
 $count_array = count ( $referer );
 foreach ( $referer as $key => $value )
  {
  $key = kill_special_chars ( strip_tags ( $key ) );
  if ( trim ( $key ) == "---" ) {}
  else
   {
    if ( $temp_file_counter == $count_array )
     {
      fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" ); // array values without ","
     }
    else
     {
      fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " ); // array values with "," at the end
     }
   }
   $temp_file_counter++;
  }
 fwrite ( $cache_visitors_file , "\n);\n\n" ); // array footer
}
//----------------
if ( $country )
{
 $temp_file_counter = 1;
 fwrite ( $cache_visitors_file , "\$country = array ( \n" ); // array header
 $count_array = count ( $country );
 foreach ( $country as $key => $value )
  {
   $key = kill_special_chars ( $key );
   if ( $temp_file_counter == $count_array )
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" ); // array values without ","
    }
   else
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " ); // array values with "," at the end
    }
   $temp_file_counter++;
  }
 fwrite ( $cache_visitors_file , "\n);\n\n" ); // array footer
}
//----------------
if ( $searchengines_archive )
{
 $temp_file_counter = 1;
 fwrite ( $cache_visitors_file , "\$searchengines_archive = array ( \n" ); // array header
 $count_array = count ( $searchengines_archive );
 foreach ( $searchengines_archive as $key => $value )
  {
   $key = kill_special_chars ( $key );
   if ( $temp_file_counter == $count_array )
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" ); // array values without ","
    }
   else
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " ); // array values with "," at the end
    }
   $temp_file_counter++;
  }
 fwrite ( $cache_visitors_file , "\n);\n\n" ); // array footer
}
//----------------
if ( $searchwords_archive )
{
 $temp_file_counter = 1;
 fwrite ( $cache_visitors_file , "\$searchwords_archive = array ( \n" ); // array header
 $count_array = count ( $searchwords_archive );
 foreach ( $searchwords_archive as $key => $value )
  {
  $key = kill_special_chars ( $key );
   if ( $temp_file_counter == $count_array )
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" ); // array values without ","
    }
   else
    {
     fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " ); // array values with "," at the end
    }
   $temp_file_counter++;
  }
 fwrite ( $cache_visitors_file , "\n);\n\n" ); // array footer
}
//----------------
if ( $entrysite )
{
 $temp_file_counter = 1;
 fwrite ( $cache_visitors_file , "\$entrysite = array ( \n" ); // array header
 $count_array = count ( $entrysite );
 foreach ( $entrysite as $key => $value )
  {
   $key = kill_special_chars ( strip_tags ( $key ) );
   if ( trim ( $key ) == "---" ) {}
   else
    {
     if ( $temp_file_counter == $count_array )
      {
       fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" ); // array values without ","
      }
     else
      {
       fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " ); // array values with "," at the end
      }
    }
   $temp_file_counter++;
  }
 fwrite ( $cache_visitors_file , "\n);\n\n" ); // array footer
}
//----------------
 fwrite ( $cache_visitors_file , "\n?>" ); // php footer
 flock  ( $cache_visitors_file , 3 );
fclose ( $cache_visitors_file );
unset  ( $cache_visitors_file );
unset  ( $temp_file_counter   );
 }
################################################################################
### cut logfile ###
if ( $loader_finished == 1 )
 {
  //------------------------------------------------------------------
  // set the physical address to zero
  $cache_timestamp_file = fopen ( "log/cache_memory_address.php" , "w+" );
   fwrite ( $cache_timestamp_file , "<?php \$cache_memory_address = \"\";?>" ); // php header + footer
  fclose ( $cache_timestamp_file );
  unset  ( $cache_timestamp_file );
  //------------------------------------------------------------------
  if ( ( $_GET [ "loadfile" ] == 1 ) || ( $loggedin == 1 ) )
   {
    if ( $db_active != 1 )
     {
      //------------------------------------------------------------------
      // take all entries of the original logfile that are newer than 2 days to the temp logfile
      $log_file      = fopen ( "log/logdb.dta"      , "r"  ); // open logfile
      $log_file_temp = fopen ( "log/logdb_temp.dta" , "w+" ); // open temp-logfile
      flock  ( $log_file_temp , 2 );
      while ( !FEOF ( $log_file ) )
        {
         $logfile_entry = fgetcsv ( $log_file , 60000 , "|" );   // read entry from logfile
         if ( ( $logfile_entry [ 0 ] != "" ) &&  ( $logfile_entry [ 0 ] >= strtotime ("-2 days" ) ) )
          {
           fwrite ( $log_file_temp , $logfile_entry [ 0 ]."|".$logfile_entry [ 1 ]."|".$logfile_entry [ 2 ]."|".$logfile_entry [ 3 ]."|".$logfile_entry [ 4 ]."|".$logfile_entry [ 5 ]."|".$logfile_entry [ 6 ]."|".$logfile_entry [ 7 ]."|".$logfile_entry [ 8 ]."\n" );
          }
        }
      flock  ( $log_file_temp , 3 );
      fclose ( $log_file          ); // close logfile
      fclose ( $log_file_temp     ); // close logfile
      unset  ( $log_file          ); // kill var
      unset  ( $log_file_temp     ); // kill var

      // kill the original logfile and take all entries from the temp logfile back to the original logfile
      copy ( "log/logdb_temp.dta" , "log/logdb.dta" );
      //------------------------------------------------------------------
     }
    //------------------------------------------------------------------
    if ( $loggedin == 0 )
     {
      //------------------------------------------------------------------
      // set the timestamp for cache update
      $cache_timestamp_file = fopen ( "log/timestamp_cache_update.dta" , "w+" );
       fwrite ( $cache_timestamp_file , time() );
      fclose ( $cache_timestamp_file );
      unset  ( $cache_timestamp_file );
      //------------------------------------------------------------------
      echo "<script language=\"JavaScript\"> top.location.replace('index.php?parameter=finished'); </script>";
      //------------------------------------------------------------------
     }
    //------------------------------------------------------------------
   }
  if ( $_GET [ "loadfile" ] == 2 )
   {
     //------------------------------------------------------------------
    if ( $_GET [ "archive" ] )
     {
      echo "<script language=\"JavaScript\"> top.location.replace('index.php?parameter=finished&archive=1&from_timestamp=".$from_timestamp."&until_timestamp=".$until_timestamp."'); </script>";
     }
    else
     {
      //------------------------------------------------------------------
      // set the timestamp for cache update
      $cache_timestamp_file = fopen ( "log/timestamp_cache_update.dta" , "w+" );
       fwrite ( $cache_timestamp_file , time() );
      fclose ( $cache_timestamp_file );
      unset  ( $cache_timestamp_file );
      //------------------------------------------------------------------
      echo "<script language=\"JavaScript\"> top.location.replace('cache_panel.php?parameter=cache_finished'); </script>";
      //------------------------------------------------------------------
     }
    //------------------------------------------------------------------
   }
  //------------------------------------------------------------------
 }
else
 {
  if ( $loggedin == 0 )
   {
    if ( $_GET [ "loadfile" ] == 1 )
     {
      //------------------------------------------------------------------
      // set the timestamp for cache update
      $cache_timestamp_file = fopen ( "log/timestamp_cache_update.dta" , "w+" );
       fwrite ( $cache_timestamp_file , time() );
      fclose ( $cache_timestamp_file );
      unset  ( $cache_timestamp_file );
      //------------------------------------------------------------------
      echo "<script language=\"JavaScript\">location.replace('cache_creator.php?loadfile=1'); </script>";
      exit;
      //------------------------------------------------------------------
     }
    if ( $_GET [ "loadfile" ] == 2 )
     {
      if ( $_GET [ "archive" ] )
       {
        echo "<script language=\"JavaScript\">location.replace('cache_creator.php?loadfile=2&archive=".$_GET [ "archive" ]."'); </script>";
        exit;
       }
      else
       {
        //------------------------------------------------------------------
        // set the timestamp for cache update
        $cache_timestamp_file = fopen ( "log/timestamp_cache_update.dta" , "w+" );
         fwrite ( $cache_timestamp_file , time() );
        fclose ( $cache_timestamp_file );
        unset  ( $cache_timestamp_file );
        //------------------------------------------------------------------
        echo "<script language=\"JavaScript\">location.replace('cache_creator.php?loadfile=2'); </script>";
        exit;
        //------------------------------------------------------------------
       }
     }
   }
 }
################################################################################
// copy the updated stat cache into the counter cache file (old solution)
// @copy ( "log/cache_visitors.php" , "log/cache_visitors_counter.php" );

// now new and better way by HR3 (http://www.php-web-statistik.de/cgi-bin/yabb/YaBB.pl?num=1304324086)

if ( ( !$_GET [ "archive" ] ) && ( $write_cache == 1 ) )
 {
  $cache_visitors_file = fopen ( "log/cache_visitors_counter.php" , "w+" );
   flock  ( $cache_visitors_file , 2 );
    fwrite ( $cache_visitors_file , "<?php\n" ); // php header
     visitor_day();
     visitor_month();
     visitor_year();
    fwrite ( $cache_visitors_file , "\n?>" ); // php footer
   flock  ( $cache_visitors_file , 3 );
  fclose ( $cache_visitors_file );
  unset  ( $cache_visitors_file );
 }

function visitor_day()
 {
  global $visitor_day, $cache_visitors_file;
  if ( $visitor_day )
   {
    $temp_file_counter = 1;
    fwrite ( $cache_visitors_file , "\$visitor_day = array ( \n" ); // array header
    $count_array = count ( $visitor_day );
    foreach ( $visitor_day as $key => $value )
     {
      if ( $temp_file_counter == $count_array )
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" ); // array values without ","
       }
      else
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " ); // array values with "," at the end
       }
      $temp_file_counter++;
     }
    fwrite ( $cache_visitors_file , "\n);\n\n" ); // array footer
   }
  }

function visitor_month()
 {
  global $visitor_month, $cache_visitors_file;
  if ( $visitor_month )
   {
    $temp_file_counter = 1;
    fwrite ( $cache_visitors_file , "\$visitor_month = array ( \n" ); // array header
    $count_array = count ( $visitor_month );
    foreach ( $visitor_month as $key => $value )
     {
      if ( $temp_file_counter == $count_array )
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" ); // array values without ","
       }
      else
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " ); // array values with "," at the end
       }
      $temp_file_counter++;
     }
    fwrite ( $cache_visitors_file , "\n);\n\n" );  // array footer
   }
  }

function visitor_year()
 {
  global $visitor_year, $cache_visitors_file;
  if ( $visitor_year )
   {
    $temp_file_counter = 1;
    fwrite ( $cache_visitors_file , "\$visitor_year = array ( \n" ); // array header
    $count_array = count ( $visitor_year );
    foreach ( $visitor_year as $key => $value )
     {
      if ( $temp_file_counter == $count_array )
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\"\n" ); // array values without ","
       }
      else
       {
        fwrite ( $cache_visitors_file , "\"".$key."\" => \"".$value."\" ,\n " ); // array values with "," at the end
       }
      $temp_file_counter++;
     }
    fwrite ( $cache_visitors_file , "\n);\n\n" ); // array footer
   }
 }
################################################################################
### kill all vars ###
unset ( $visitor               );
unset ( $visitor_hour          );
unset ( $visitor_day           );
unset ( $visitor_weekday       );
unset ( $visitor_month         );
unset ( $visitor_year          );
unset ( $browser               );
unset ( $operating_system      );
unset ( $resolution            );
unset ( $color_depth           );
unset ( $javascript_status     );
unset ( $site_name             );
unset ( $referer               );
unset ( $country               );
unset ( $searchengines_archive );
unset ( $searchwords_archive   );
unset ( $entrysite             );
unset ( $last_logfile_entry    );
unset ( $logfile_entry         );
//------------------------------------------------------------------------------
?>