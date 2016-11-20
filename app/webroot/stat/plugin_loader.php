<?php @session_start(); if ( $_SESSION [ "hidden_stat" ] != md5_file ( "config/config.php" ) ) { include ( "func/func_error.php" ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.8.x                                                    #
# File-Release-Date:  14/07/24                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2014 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
error_reporting(0);
//------------------------------------------------------------------------------
if ( $_POST [ "plugin" ] )
 {
  include ( "config/config.php" ); // include main configuration
  include ( $language           ); // include language vars
	//------------------------------------------------------------------------------
	// Plugin Language Specific
  if ( $language == "language/german.php"     ) { $language_plugin_select = "de";    }
  if ( $language == "language/english.php"    ) { $language_plugin_select = "en";    }
  if ( $language == "language/dutch.php"      ) { $language_plugin_select = "nl";    }
  if ( $language == "language/italian.php"    ) { $language_plugin_select = "it";    }
  if ( $language == "language/spanish.php"    ) { $language_plugin_select = "es";    }
  if ( $language == "language/catalan.php"    ) { $language_plugin_select = "es-ct"; }
  if ( $language == "language/farsi.php"      ) { $language_plugin_select = "fa";    }
  if ( $language == "language/danish.php"     ) { $language_plugin_select = "dk";    }
  if ( $language == "language/french.php"     ) { $language_plugin_select = "fr";    }
  if ( $language == "language/turkish.php"    ) { $language_plugin_select = "tr";    }
  if ( $language == "language/hungarian.php"  ) { $language_plugin_select = "hu";    }
  if ( $language == "language/portuguese.php" ) { $language_plugin_select = "pt";    }
  if ( $language == "language/hebrew.php"     ) { $language_plugin_select = "he";    }
  if ( $language == "language/russian.php"    ) { $language_plugin_select = "ru";    }
  if ( $language == "language/serbian.php"    ) { $language_plugin_select = "rs";    }
  if ( $language == "language/finnish.php"    ) { $language_plugin_select = "fi";    }
  //------------------------------------------------------------------------------
  if ( strpos ( $_POST [ "plugin" ] , ".." ) === TRUE ) { exit; }
  //------------------------------------------------------------------------------
  include ( "plugins/".$_POST [ "plugin" ]."/info.php"  ); // include plugin configuration
  //------------------------------------------------------------------------------
  include ( "func/func_timer.php"  ); // include stopwatch function
  $timer_start = timer_start();       // start the stopwatch timer
  //------------------------------------------------------------------------------
  include ( "func/html_header.php" ); // include html header
  //------------------------------------------------------------------------------
	// header tables
	echo '
	<table id="groundtable" style="width:960px; margin:auto; border-collapse:separate; border-spacing:0"><tr><td style="padding:0px">
	<table id="header1_plugin" style="width:100%; border-spacing:0">
	<tr>
	  <td style="width:140px; text-align:center; vertical-align:middle">
	  <a href="http://www.php-web-statistik.de" target="_blank"><img src="images/system.png" style="vertical-align:middle;" width="104" height="50" alt="PHP Web Stat" title="PHP Web Stat"></a>
	  </td>
	  <td style="width:150px; text-align:left; vertical-align:middle">
	  <span style="font-size:18px; font-family:Helvetica, Verdana, Arial, sans-serif"><b>PHP Web Stat</b></span><br>
	  <b>Plugin-Loader</b>
	  </td>
	  <td style="text-align:center; font-size:20px; font-family:Georgia">
	  '.$plugin_name.'&nbsp;&nbsp;V'.$plugin_version.'
	  </td>
	  <td style="width:140px; text-align:center; vertical-align:top; padding-top:15px;">
	  <a href="javascript:window.close()">'.$lang_footer[3].'</a>
	  </td>
	</tr>
	</table>
	<table id="header2_plugin" style="width:100%; border-spacing:0">
	<tr>
	  <td style="text-align:right; padding:0px 10px 0px 10px; vertical-align:middle;">
	  Plugin by <a href="'.$plugin_website.'" target="_blank" title="'.$plugin_website.'">'.$plugin_author.'</a>
	  </td>
	  <td style="width:20px; padding:0px 10px 0px 10px; vertical-align:middle;">
	  <img style="vertical-align:middle; cursor:pointer;" src="images/print.png" onclick="window.print();return false;" width="18" height="18" alt="'.$lang_menue[6].'" title="'.$lang_menue[6].'">
	  </td>
	</tr>
	</table>
	';
  //------------------------------------------------------------------------------
  include ( "plugins/".$_POST [ "plugin" ]."/index.php" ); // include plugin
  //------------------------------------------------------------------------------
  // footer
  echo '
  <table style="width:100%; border-spacing:0">
  <tr>
    <td style="padding-top:7px; height:20px; text-align:center; vertical-align:middle">Copyright &copy; 2014 <a href="http://www.php-web-statistik.de" target="_blank">PHP Web Stat</a> &nbsp; <b>&middot;</b> &nbsp; '.$lang_footer[1].' '.timer_stop($timer_start).' '.$lang_footer[2].'.</td>
    <td style="padding-top:7px; width:240px; text-align:center; vertical-align:middle"><a href="http://validator.w3.org/check?uri=referer" target="_blank"><img style="vertical-align:middle;" src="images/w3c-html5.gif" width="80" height="15" alt="Valid HTML 5" title="Valid HTML 5"></a> &nbsp; <a href="http://jigsaw.w3.org/css-validator/validator?uri='.$script_domain.'/'.$script_path.''.$theme.'style.css"  target="_blank"><img style="vertical-align:middle;" src="images/w3c-css.gif" width="80" height="15" alt="Valid CSS!" title="Valid CSS!"></a></td>
  </tr>
  </table>
  </td></tr></table>
  ';
  //------------------------------------------------------------------------------
  include ( "func/html_footer.php" ); // include html footer
  //------------------------------------------------------------------------------
 }
//------------------------------------------------------------------------------
?>