<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.9.x                                                    #
# File-Release-Date:  15/10/27                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2015 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
function os_matching ( $os_search )
 {
  //--------------------------------
  $os_icons = array (
   "Windows 10"           => "os_windows8"     ,
   "Windows 8.1"          => "os_windows8"     ,
   "Windows 8"            => "os_windows8"     ,
   "Windows Phone"        => "os_windows8"     ,
   "Windows 7"            => "os_windows7"     ,
   "Windows Vista"        => "os_windowsvista" ,
   "Windows Server 2003"  => "os_windowsxp"    ,
   "Windows Media Center" => "os_windowsxp"    ,
   "Windows XP"           => "os_windowsxp"    ,
   "Windows 2000"         => "os_windows"      ,
   "Windows CE"           => "os_windows"      ,
   "Windows NT"           => "os_windows"      ,
   "Windows ME"           => "os_windows"      ,
   "Windows 98"           => "os_windows"      ,
   "Windows 95"           => "os_windows"      ,
   "Windows"              => "os_windows"      ,
   //-------------------------------------------
   "Android"              => "os_android"      ,
   "Java"                 => "os_java"         ,
   "Solaris"              => "os_question"     ,
   "DOS"                  => "os_question"     ,
   "Unix"                 => "os_sco"          ,
   "Mac OS X"             => "os_macosx"       ,
   "Mac OS"               => "os_mac"          ,
   "Macintosh PowerPC"    => "os_macppc"       ,
   "SunOS"                => "os_sun"          ,
   "BeOS"                 => "os_be"           ,
   "RISC OS"              => "os_risc"         ,
   "OS/2"                 => "os_os2"          ,
   "FreeBSD"              => "os_freebsd"      ,
   "OpenBSD"              => "os_openbsd"      ,
   "NetBSD"               => "os_netbsd"       ,
   "IRIX"                 => "os_irix"         ,
   "Plan9"                => "os_question"     ,
   "OSF"                  => "os_question"     ,
   "AIX"                  => "os_aix"          ,
   "GNU Hurd"             => "os_question"     ,
   "Linux"                => "os_linux"        ,
   "AmigaOS"              => "os_amiga"        ,
   "Amiga"                => "os_amiga"        ,
   "PalmOS"               => "os_palm"         ,
   "WebTV"                => "os_question"     ,
   "Dreamcast OS"         => "os_dreamcast"    ,
   //-------------------------------------------
   "Unknown"              => "os_question"
  );
  //--------------------------------
  if ( @array_key_exists ( $os_search , $os_icons ) ) { return $os_icons [ $os_search ]; }
  elseif ( @array_key_exists ( substr ( $os_search , 0 , strpos ( $os_search , " " ) ) , $os_icons ) ) { return $os_icons [ substr ( $os_search , 0 , strpos ( $os_search , " " ) ) ]; }
  else { return "os_question"; }
  //--------------------------------
 }
//------------------------------------------------------------------------------

//------------------------------------------------------------------------------
function browser_matching ( $browser_search )
 {
  //--------------------------------
  $browser_icons = array (
   "Firefox"               => "browser_firefox"      ,
   "Opera"                 => "browser_opera"        ,
   "Opera23"               => "browser_opera"        ,
   "Netscape"              => "browser_netscape"     ,
   "OmniWeb"               => "browser_omniweb"      ,
   "Google Chrome"         => "browser_chrome"       ,
   "Safari"                => "browser_safari"       ,
   //-------------------------------------------------
   "Mozilla SeaMonkey"     => "browser_seamonkey"    ,
   "Mozilla Galeon"        => "browser_galeon"       ,
   "Mozilla Camino"        => "browser_camino"       ,
   "Mozilla Epiphany"      => "browser_epiphany"     ,
   "Mozilla Shiira"        => "browser_shiira"       ,
   "Mozilla K-Meleon"      => "browser_k-meleon"     ,
   "Mozilla Mnenhy"        => "browser_mnenhy"       ,
   "Mozilla MultiZilla"    => "browser_multibrowser" ,
   "Mozilla"               => "browser_mozilla"      ,
   //-------------------------------------------------
   "IE CrazyBrowser"       => "browser_crazybrowser" ,
   "IE SlimBrowser"        => "browser_slimbrowser"  ,
   "IE DeepnetExplorer"    => "browser_deepnet"      ,
   "IE NetCaptor"          => "browser_netcaptor"    ,
   "IE Maxthon"            => "browser_maxthon"      ,
   "Internet Explorer"     => "browser_explorer"     ,
   "Internet Explorer 8.0" => "browser_explorer8"    ,
   "Edge"                  => "browser_edge"         ,
   //-------------------------------------------------
   "Java"                  => "browser_hotjava"      ,
   "NetPositive"           => "browser_netpositive"  ,
   "MS FrontPage"          => "browser_question"     ,
   "PHP"                   => "browser_question"     ,
   "WebWasher"             => "browser_question"     ,
   "Konqueror"             => "browser_konqueror"    ,
   "Lynx"                  => "browser_lynx"         ,
   "Mosaic"                => "browser_mosaic"       ,
   "Links"                 => "browser_links"        ,
   "OffByOne"              => "browser_offbyone"     ,
   "ELinks"                => "browser_links"        ,
   "Teleport Pro"          => "browser_question"     ,
   "Amiga-AWeb"            => "browser_question"     ,
   "AmigaVoyager"          => "browser_question"     ,
   "AvantGo"               => "browser_avantgo"      ,
   "BrowserEmulator"       => "browser_question"     ,
   "Cosmos"                => "browser_question"     ,
   "Download Accelerator"  => "browser_question"     ,
   "FlashGet"              => "browser_question"     ,
   "GetRight"              => "browser_question"     ,
   "GigaBaz"               => "browser_question"     ,
   "Go!zilla"              => "browser_question"     ,
   "IBrowser"              => "browser_multibrowser" ,
   "ICS"                   => "browser_question"     ,
   "lpw-trivial"           => "browser_question"     ,
   "Lotus-Notes"           => "browser_lotus"        ,
   "MSProxy"               => "browser_question"     ,
   "NetAnts"               => "browser_question"     ,
   "Offline Explorer"      => "browser_question"     ,
   "Penetrator"            => "browser_question"     ,
   "Planetweb"             => "browser_question"     ,
   "PowerNet"              => "browser_question"     ,
   "Rotondo"               => "browser_question"     ,
   "UP.Browser"            => "browser_upbrowser"    ,
   "W3M"                   => "browser_w3m"          ,
   "WebCapture"            => "browser_question"     ,
   "WebCopier"             => "browser_question"     ,
   "Webcollage"            => "browser_question"     ,
   "WebScrape"             => "browser_question"     ,
   "Web Downloader"        => "browser_question"     ,
   "WebStripper"           => "browser_question"     ,
   "WebZIP"                => "browser_question"     ,
   "WebTv"                 => "browser_webtv"        ,
   "WGet"                  => "browser_question"     ,
   "Dillo"                 => "browser_dillo"        ,
   //-------------------------------------------------
   "Robot"                 => "browser_question"     ,
   "Robots/Spider"         => "browser_question"     ,
   //-------------------------------------------------
   "Unknown"               => "browser_question"
  );
  //--------------------------------
  if ( @array_key_exists ( $browser_search , $browser_icons ) ) { return $browser_icons [ $browser_search ]; }
  elseif ( @array_key_exists ( substr ( $browser_search , 0 , strrpos ( $browser_search , " " ) ) , $browser_icons ) ) { return $browser_icons [ substr ( $browser_search , 0 , strrpos ( $browser_search , " " ) ) ]; }
  elseif ( @array_key_exists ( substr ( $browser_search , 0 , strpos  ( $browser_search , " " ) ) , $browser_icons ) ) { return $browser_icons [ substr ( $browser_search , 0 , strpos  ( $browser_search , " " ) ) ]; }
  else { return "browser_question"; }
  //--------------------------------
 }
//------------------------------------------------------------------------------
?>