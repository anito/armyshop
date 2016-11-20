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
include ( "config/config.php"      ); // include config
include ( $language                ); // include language
include ( "func/html_header.php"   ); // include html header
//------------------------------------------------------------------------------
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
function read_dir ( $path )
 {
  $result = array();
  $handle = opendir ( $path );
   if ($handle)
    {
     while ( false !== ( $file = readdir ( $handle ) ) )
      {
       if ( $file != "." && $file != ".." )
        {
         if ( is_dir ( $path."/".$file ) )
          {
           $result[] = $file;
          }
        }
      }
   }
   closedir ( $handle );
   return $result;
 }
//------------------------------------------------------------------------------
echo '
<div style="width:438px; height:60px; border:1px solid #000000; border-bottom:1px solid #737373; background: url(images/bg_system.gif); text-align:right; color:#436783; font-family:Arial Black; font-size:13px">
  <p style="margin:0px; padding:10px 20px 0px 0px">'.$lang_plugin[1].'</p>
</div>
<div style="width:438px; height:150px; border-left:1px solid #000000; border-right:1px solid #000000; background:#EBE8D8; color:#000000; font-family:Arial; font-size:11px">
  <p style="margin:0px; padding:10px 10px 0px 10px">'.$lang_plugin[2].'</p>';
  //-------------------------------------------------
  $plugin_files_read = read_dir ( "plugins/" );
  asort ( $plugin_files_read );
  //-------------------------------------------------
  echo '
  <form action="plugin_loader.php" method="post" target="plugin">
  <p style="margin:0px; padding:10px 10px 0px 10px">
  <select name="plugin" size="1" style="width:330px">';
  //------------------------------------------------------------------------------
  foreach ( $plugin_files_read as $value )
   {
    //-------------------------------------------------
    if ( file_exists ( "plugins/".$value."/info.php" ) )
     {
      //-------------------------------------------------
      include ( "plugins/".$value."/info.php" );

      if ( $db_active == 0 )
       {
        echo '<option value="'.$plugin_directory.'">'.$plugin_name.'</option>';
       }

      if ( ( $plugin_database == 1 ) && ( $db_active == 1 ) )
       {
        echo '<option value="'.$plugin_directory.'">'.$plugin_name.'</option>';
       }

       unset ( $plugin_name      );
       unset ( $plugin_version   );
       unset ( $plugin_release   );
       unset ( $plugin_author    );
       unset ( $plugin_website   );
       unset ( $plugin_security  );
       unset ( $plugin_directory );
      //-------------------------------------------------
     }
    //-------------------------------------------------
   }
  //------------------------------------------------------------------------------
  echo '
  </select>
  <input type="submit" onclick="show_plugin();" value="OK">
  </p>
  </form>
  <p style="margin:0px; padding:10px 10px 0px 10px">'.$lang_plugin[3].'</p>
</div>
<div style="width:438px; height:46px; border:1px solid #000000; border-top:1px solid #A7A7A7; background:#EBE8D8; text-align:left; font-size:9px; color:#303030; line-height:11px">
  <p style="text-align: justify; margin:0px; padding:5px 10px 0px 10px">'.$lang_plugin[4].'</p>
</div>
';
//------------------------------------------------------------------------------
include ( "func/html_footer.php" ); // include html footer
//------------------------------------------------------------------------------
?>