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
function operating_system_detection ( $os_search )
 {
  //--------------------------------
  $os_patterns = array
   (
    //------------------------------------------------------------------------------
    "(Windows XP)"                                          => "Windows XP",
    "(Windows NT 5.1|Windows NT5.1)"                        => "Windows XP",
    "(Windows 2000)"                                        => "Windows 2000",
    "(Windows NT 5.0)"                                      => "Windows 2000",
    "(Windows NT 4.0|WinNT4.0)"                             => "Windows NT",
    "(Windows NT 5.2)"                                      => "Windows Server 2003",
    "(Windows NT 6.0)"                                      => "Windows Vista",
    "(Windows NT 6.1)"                                      => "Windows 7",
    "(Windows NT 6.2)"                                      => "Windows 8",
    "(Windows NT 6.3)"                                      => "Windows 8.1",
    "(Windows NT 6.4)"                                      => "Windows 10",
    "(Windows NT 10.0)"                                     => "Windows 10",
    "(Windows Phone)"                                       => "Windows Phone",
    "(media center pc).([0-9]{1,2}\.[0-9]{1,2})"            => "Windows Media Center",
    "(Windows ME)"                                          => "Windows ME",
    "(Win 9x 4.90)"                                         => "Windows ME",
    "win 9x 4\.90"                                          => "Windows ME",
    "wi(n|ndows)[ \-]?me"                                   => "Windows ME",
    "(Windows 98|Win98)"                                    => "Windows 98",
    "(Windows 95)"                                          => "Windows 95",
    "(Windows CE)"                                          => "Windows CE",
    "wi(n|ndows)[ \-]?ce"                                   => "Windows CE",
    "wi(n|ndows)[ /.;]*mobile"                              => "Windows CE",
    "(Microsoft|Windows) Pocket"                            => "Windows CE",
    "(win)([0-9]{1,2}\.[0-9x]{1,2})"                        => "Windows",
    "(win)([0-9]{2})"                                       => "Windows",
    "(windows)([0-9x]{2})"                                  => "Windows",
    "(windows)([0-9]{1,2}\.[0-9]{1,2})"                     => "Windows",
    "(win32)"                                               => "Windows",
    "(GetRight)"                                            => "Windows",
    "(go!zilla)"                                            => "Windows",
    "(gozilla)"                                             => "Windows",
    "(gulliver)"                                            => "Windows",
    "(ia archiver)"                                         => "Windows",
    "(NetPositive)"                                         => "Windows",
    "(mass downloader)"                                     => "Windows",
    "(microsoft)"                                           => "Windows",
    "(offline explorer)"                                    => "Windows",
    "(teleport)"                                            => "Windows",
    "(web downloader)"                                      => "Windows",
    "(webcapture)"                                          => "Windows",
    "(webcollage)"                                          => "Windows",
    "(webcopier)"                                           => "Windows",
    "(webstripper)"                                         => "Windows",
    "(webzip)"                                              => "Windows",
    "(wget)"                                                => "Windows",
    "(flashget)"                                            => "Windows",
    "(MS FrontPage)"                                        => "Windows",
    "(msproxy)\/([0-9]{1,2}.[0-9]{1,2})"                    => "Windows",
    "(msie)([0-9]{1,2}.[0-9]{1,2})"                         => "Windows",
    "(UP.Browser)"                                          => "Windows",
    "(NetAnts)"                                             => "Windows",
    //------------------------------------------------------------------------------
    "(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})"            => "Java",
    "(Solaris)([0-9]{1,2}\.[0-9x]{1,2}){0,1}"               => "Solaris",
    "(dos x86)"                                             => "DOS",
    "(unix)"                                                => "Unix",
    //------------------------------------------------------------------------------
    "(Mac OS X)"                                            => "Mac OS X",
    "(Mac_PowerPC)"                                         => "Macintosh PowerPC",
    "(mac|Macintosh)"                                       => "Mac OS",
    "i(Phone|Pod|Pad).*OS[ /]([0-9]{1,10})_([0-9]{1,10})"   => "iOS",
    "i(Phone|Pod|Pad)"                                      => "iOS",
    "(sunos)([0-9]{1,2}\.[0-9]{1,2}){0,1}"                  => "SunOS",
    "(beos)([0-9]{1,2}\.[0-9]{1,2}){0,1}"                   => "BeOS",
    "(risc os)([0-9]{1,2}\.[0-9]{1,2})"                     => "RISC OS",
    "(os\/2)"                                               => "OS/2",
    "(freebsd)"                                             => "FreeBSD",
    "(openbsd)"                                             => "OpenBSD",
    "(netbsd)"                                              => "NetBSD",
    "(irix)"                                                => "IRIX",
    "(plan9)"                                               => "Plan9",
    "(osf)"                                                 => "OSF",
    "(aix)"                                                 => "AIX",
    "(GNU Hurd)"                                            => "GNU Hurd",
    //------------------------------------------------------------------------------
    "Android ([0-9.]{1,10})"                                => "Android",
    "(fedora)"                                              => "Linux - Fedora",
    "(kubuntu)"                                             => "Linux - Kubuntu",
    "(ubuntu)"                                              => "Linux - Ubuntu",
    "(debian)"                                              => "Linux - Debian",
    "(CentOS)"                                              => "Linux - CentOS",
    "(Mandriva).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)" => "Linux - Mandriva",
    "(SUSE).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)"     => "Linux - SUSE",
    "(Dropline)"                                            => "Linux - Slackware",
    "(ASPLinux)"                                            => "Linux - ASPLinux",
    "(Red Hat)"                                             => "Linux - Red Hat",
    "RedHat"                                                => "Linux - Red Hat",
    "Red Hat[ /]?([0-9.]{1,10})"                            => "Linux - Red Hat",
    "centos([0-9]{1})"                                      => "CentOS",
    "el([0-9.]{1}).*centos"                                 => "CentOS",
    "CentOS"                                                => "CentOS",
    "Mandriva[ /]([0-9.]{1,10})"                            => "Mandriva",
    "Linux[ /\-]([0-9.-]{1,10}).mdk"                        => "Linux Mint",
    "Linux[ /\-]([0-9.-]{1,10}).mdv"                        => "Linux Mint",
    "Linux Mint[/ ]?([0-9.]{1,10})?"                        => "Linux Mint",
    "(linux)"                                               => "Linux",
    "(libwww-perl)"                                         => "Unix",
    //------------------------------------------------------------------------------
    "(amigaos)([0-9]{1,2}\.[0-9]{1,2})"                     => "AmigaOS",
    "(amiga-aweb)"                                          => "AmigaOS",
    "(amiga)"                                               => "Amiga",
    "(AvantGo)"                                             => "PalmOS",
    "(webtv)\/([0-9]{1,2}\.[0-9]{1,2})"                     => "WebTV",
    "(Dreamcast)"                                           => "Dreamcast OS",
    //------------------------------------------------------------------------------
    "Arch Linux"                                            => "Arch Linux",
    "Bada[ /]([0-9]{1,10})"                                 => "Bada",
    "BlackBerry"                                            => "BlackBerry",
    "BREW[ /]([0-9.]{1,10})"                                => "BREW",
    "Haiku BePC"                                            => "Haiku",
    "PLD[ /]?([0-9.]{1,10})"                                => "PLD",
    "PLD"                                                   => "PLD",
    "SliTaz"                                                => "SliTaz",
    "Trisquel[ /]([0-9.]{1,10})"                            => "Trisquel"
    //------------------------------------------------------------------------------
   );
  //--------------------------------
  $operating_system = "";
  //--------------------------------
  foreach ( $os_patterns as $os_pattern => $os_name )
   {
    //--------------------------------
    if ( preg_match ( "/".$os_pattern."/i" , $os_search , $name ) )
     {
      $operating_system = @$os_name." ".@$name [ 2 ];
      break;
     }
    //--------------------------------
   }
  //--------------------------------
  return trim ( $operating_system );
  //--------------------------------
}
//------------------------------------------------------------------------------
?>