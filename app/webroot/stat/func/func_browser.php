<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.9.x                                                    #
# File-Release-Date:  15/08/17                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2015 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
function browser_detection ( $browser_search )
{
 //--------------------------------
 $browser_patterns = array
  (
   //--------------------------------------------------------------------------------------------------
   "(firefox).(([0-9]{1,2}\.[0-9]{1,3})?(\.[0-9]{1,3})?)"                   => "Firefox",
   "(Opera\/9.80.+Version).([0-9]{1,2}\.[0-9]{1,3})"                        => "Opera",
   "(opera).([0-9]{1,2}\.[0-9]{1,3})"                                       => "Opera",
   "(opera).([0-9]{1,2}\.[0-9x]{1,3})"                                      => "Opera23",
   "(netscape).{1,2}([0-9]{1,2}\.[0-9]{1,4}(\.[0-9]{1,3})?)"                => "Netscape",
   "(Edge).([0-9]{1,3}\.[0-9]{1,4})"                                        => "Edge",
   "(OmniWeb).v([0-9]{1,3}(\.[0-9]{1,3})?)"                                 => "OmniWeb",
   "(ChromePlus).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?(\.[0-9]{1,3})?)" => "ChromePlus",
   "(Chrome).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?(\.[0-9]{1,4})?)"     => "Google Chrome",
   "(Version).([0-9]{1,2}\.[0-9]{1,3}?(\.[0-9]{1,3})?).+(safari)"           => "Safari",
   "(safari).([0-9]{1,3}(\.[0-9]{1,3})?)"                                   => "Safari",
   //--------------------------------------------------------------------------------------------------
   "(msie).([0-9]{1,2}\.[0-9]{1,2}).+(crazy browser)"                       => "IE CrazyBrowser",
   "(msie).([0-9]{1,2}\.[0-9]{1,2}).+slimBrowser"                           => "IE SlimBrowser",
   "(msie).([0-9]{1,2}\.[0-9]{1,2}).+(deepnet explorer)"                    => "IE DeepnetExplorer",
   "(msie).([0-9]{1,2}\.[0-9]{1,2}).+netcaptor"                             => "IE NetCaptor",
   "(msie).([0-9]{1,2}\.[0-9]{1,2}).+(maxthon|myie2)"                       => "IE Maxthon",
   "(Trident).+rv:([0-9]{1,2}\.[0-9]{1,2})"                                 => "Internet Explorer",
   "(msie) ([0-9]{1,2}\.[0-9]{1,2})"                                        => "Internet Explorer",
   //--------------------------------------------------------------------------------------------------
   "(seamonkey).([0-9]{1,3}(\.[0-9]{1,3})?)"                                => "Mozilla SeaMonkey",
   "(galeon).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)"                    => "Mozilla Galeon",
   "(camino).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)"                    => "Mozilla Camino",
   "(epiphany).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)"                  => "Mozilla Epiphany",
   "(Shiira).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)"                    => "Mozilla Shiira",
   "(k-meleon).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)"                  => "Mozilla K-Meleon",
   "(Mnenhy).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)"                    => "Mozilla Mnenhy",
   "(MultiZilla).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)"                => "Mozilla MultiZilla",
   "(mozilla).+rv:([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)"               => "Mozilla",
   //--------------------------------------------------------------------------------------------------
   "(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})"                             => "Java",
   "(NetPositive)\/([0-9]{1,2}\.[0-9]{0,3})"                                => "NetPositive",
   "(FrontPage)([0-9]{1,2}\.[0-9]{1,2})"                                    => "MS FrontPage",
   "(PHP)\/([0-9]{1,2}\.[0-9]{1,2})"                                        => "PHP",
   "(WebWasher)([0-9]{1,2}\.[0-9]{1,2})"                                    => "WebWasher",
   "(konqueror).([0-9]{1,2}(\.[0-9])?)"                                     => "Konqueror",
   "(lynx)"                                                                 => "Lynx",
   "(mosaic)"                                                               => "Mosaic",
   "(links).*([0-9]{1,2}\.[0-9]{1,2})"                                      => "Links",
   "(OffByOne)"                                                             => "OffByOne",
   "(ELinks)"                                                               => "ELinks",
   "(teleport pro)\/([0-9\.]{1,9})"                                         => "Teleport Pro",
   "(Amiga-AWeb)\/([0-9 ]{1}\.[0-9]{1,2}\.[0-9]{1,4})"                      => "Amiga-AWeb",
   "(amigavoyager)\/([0-9]{1}\.[0-9]{1,2}\.[0-9]{1,4})"                     => "AmigaVoyager",
   "(AvantGo)([0-9]{1}\.[0-9]{1,2})"                                        => "AvantGo",
   "(AvantGo)([0-9]{1}\.[0-9]{1,2})"                                        => "BrowserEmulator",
   "(cosmos)\/([0-9]{1,2}\.[0-9]{1,3})"                                     => "Cosmos",
   "(da)([0-9]{1,2}\.[0-9]{1,3})"                                           => "Download Accelerator",
   "(flashget)"                                                             => "FlashGet",
   "(GetRight)\/([0-9]{1,2}\.[0-9b]{1,3})"                                  => "GetRight",
   "(gigabaz)\/([0-9]{1,2}\.[0-9]{1,3})"                                    => "GigaBaz",
   "(go!zilla)([0-9]{1,2}\.[0-9b]{1,3})"                                    => "Go!zilla",
   "(gozilla)([0-9]{1,2}\.[0-9b]{1,3})"                                     => "Go!zilla",
   "(ibrowse)\/([0-9]{1,2}\.[0-9]{1,3})"                                    => "IBrowser",
   "(ICS) ([0-9]{1,2}\.[0-9]{1,3}\.[0-9]{1,3})"                             => "ICS",
   "(lwp-trivial)\/([0-9]{1,2}\.[0-9]{1,3})"                                => "lpw-trivial",
   "(Lotus-Notes)\/([0-9]{1,2}\.[0-9]{1,3})"                                => "Lotus-Notes",
   "(msproxy)\/([0-9]{1,2}\.[0-9]{0,3})"                                    => "MSProxy",
   "(NetAnts)\/([0-9]{1,2}\.[0-9]{0,3})"                                    => "NetAnts",
   "(offline explorer)\/([0-9]{1,2}\.[0-9]{0,3})"                           => "Offline Explorer",
   "(Penetrator)([0-9]{1,2}\.[0-9]{0,3})"                                   => "Penetrator",
   "(planetweb)\/([0-9]{1,2}\.[0-9ab]{0,4})"                                => "Planetweb",
   "(PowerNet)\/([0-9]{1,2}\.[0-9]{0,4})"                                   => "PowerNet",
   "(Rotondo)\/([0-9]{1,2}\.[0-9]{0,3})"                                    => "Rotondo",
   "(UP\.Browser)\/([0-9]{1,2}\.[0-9]{0,3})"                                => "UP.Browser",
   "(w3m)"                                                                  => "W3M",
   "(WebCapture)([0-9]{1,2}\.[0-9]{0,3})"                                   => "WebCapture",
   "(WebCopier v)([0-9]{1,2}\.[0-9]{0,3})"                                  => "WebCopier",
   "(webcollage)\/([0-9]{1,2}\.[0-9]{0,3})"                                 => "Webcollage",
   "(WebScrape)\/([0-9]{1,2}\.[0-9]{0,3})"                                  => "WebScrape",
   "(web downloader)(\/[0-9]{1,2}\.[0-9]{0,1})"                             => "Web Downloader",
   "(mas downloader)(\/[0-9]{1,2}\.[0-9]{0,1})"                             => "Web Downloader",
   "(webstripper)\/([0-9]{1,2}\.[0-9]{0,3})"                                => "WebStripper",
   "(WebZIP)\/([0-9]{1,2}\.[0-9]{0,3})"                                     => "WebZIP",
   "(webtv)"                                                                => "WebTv",
   "(Wget)\/([0-9]{1,2}\.[0-9]{0,3})"                                       => "WGet",
   "(Dillo).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)"                     => "Dillo",
   //--------------------------------------------------------------------------------------------------
   "Arora[ /]([0-9.]{1,10})"                                                => "Arora",
   "BeZillaBrowser/([0-9.+]{1,10})"                                         => "Bezilla",
   "^BlackBerry.*?/([0-9.]{1,10})"                                          => "Blackberry",
   "BrowseX.*\(([0-9.]{1,10})"                                              => "BrowseX",
   "CometBird[ /]([0-9.]{1,10})"                                            => "CometBird",
   "Cruz[ /]([0-9.]{1,10})"                                                 => "Cruz",
   "Demeter[ /]([0-9.]{1,10})"                                              => "Demeter",
   "Dolfin[ /]([0-9.]{1,10})"                                               => "Dolfin",
   "Dooble/([0-9.]{1,10})"                                                  => "Dooble",
   "Fennec[ /]([0-9.a-z]{1,10})"                                            => "Fennec",
   "Fluid[ /]([0-9.]{1,10})"                                                => "Fluid",
   "FrontPage[ /]([0-9.+]{1,10})"                                           => "FrontPage",
   "Iceape/([0-9a-z.]{1,10})"                                               => "Iceape",
   "IceCat/([0-9a-z.]{1,10})"                                               => "IceCat",
   "^iPeng.*(iPhone|iPad)[ /]([0-9.]{1,10})"                                => "iPeng",
   "Iron/([0-9.]{1,10})"                                                    => "Iron",
   "Kylo/([0-9.]{1,10})"                                                    => "Kylo",
   "Lobo/([0-9.]{1,10})"                                                    => "Lobo",
   "midori[ /]([0-9.]{1,10})"                                               => "midori",
   "Miro[ /]([0-9.]{1,10})"                                                 => "Miro",
   "Plainview[ /]([0-9.]{1,10})"                                            => "Plainview",
   "Reeder/([0-9.+]{1,10})"                                                 => "Reeder",
   "Smart Bro[ /]?([0-9.]{1,10})?"                                          => "Smart Bro",
   "Stainless[ /]([0-9.]{1,10})"                                            => "Stainless",
   "Strata[/ ]([0-9.]{1,10})"                                               => "Strata",
   "Swiftfox[ /]?([0-9.]{1,10})?"                                           => "Swiftfox",
   "Thunderbird[ /]([0-9a-z.]{1,10})"                                       => "Thunderbird",
   "Uzbl"                                                                   => "Uzbl",
   "AppleWebKit/([0-9.]{1,10}).*Gecko"                                      => "AppleWebKit",
   "Wyzo[ /]([0-9.]{1,10})"                                                 => "Wyzo",
   //--------------------------------------------------------------------------------------------------
   "msnbot"                                                                 => "MSN Bot",
   "googlebot"                                                              => "Google Bot",
   "mediapartners-google"                                                   => "Google Adsense",
   "inktomi"                                                                => "Yahoo Inktomi Bot",
   "slurp"                                                                  => "Yahoo Slurp Bot",
   "baiduspider"                                                            => "Robot",
   "job crawler"                                                            => "Robot",
   "analyzer"                                                               => "Robot",
   "arachnofilia"                                                           => "Robot",
   "aspseek"                                                                => "Robot",
   "bot"                                                                    => "Robot",
   "check"                                                                  => "Robot",
   "crawl"                                                                  => "Robot",
   "infoseek"                                                               => "Robot",
   "netoskop"                                                               => "Robot",
   "NetSprint"                                                              => "Robot",
   "openfind"                                                               => "Robot",
   "roamer"                                                                 => "Robot",
   "robot"                                                                  => "Robot",
   "rover"                                                                  => "Robot",
   "scooter"                                                                => "Robot",
   "search"                                                                 => "Robot",
   "siphon"                                                                 => "Robot",
   "spider"                                                                 => "Robot",
   "sweep"                                                                  => "Robot",
   "walker"                                                                 => "Robot",
   "WebStripper"                                                            => "Robot",
   "wisenutbot"                                                             => "Robot",
   "gulliver"                                                               => "Robot",
   "validator"                                                              => "Robot",
   "yandex"                                                                 => "Robot",
   "ask jeeves"                                                             => "Robot",
   "moget@"                                                                 => "Robot",
   "teomaagent"                                                             => "Robot",
   "infoNavirobot"                                                          => "Robot",
   "PPhpDig"                                                                => "Robot",
   "gigabaz"                                                                => "Robot",
   "Webclipping\.com"                                                       => "Robot",
   "RRC"                                                                    => "Robot",
   "netmechanic"                                                            => "Robot"
   //--------------------------------------------------------------------------------------------------
  );
  //--------------------------------
  $browser = "";
  //--------------------------------
  foreach ( $browser_patterns as $browser_pattern => $browser_name )
   {
    //--------------------------------
    if ( preg_match ( "/".$browser_pattern."/i" , $browser_search , $name ) )
     {
      //--------------------------------
      $browser = @$browser_name." ".@$name [ 2 ];
      break;
      //--------------------------------
     }
    //--------------------------------
   }
  return trim ( $browser );
  //--------------------------------
 }
//------------------------------------------------------------------------------
?>