<?php @session_start(); if ( $_SESSION [ "hidden_func" ] != md5_file ( "config.php" ) ) { $error_path = "../"; include ( "../func/func_error.php" ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.1.x                                                    #
# File-Release-Date:  09/01/11                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2009 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
include ( "config.php" ); // include path to style
include ( "../".substr ( $language , 0 , strpos ( $language , "." ) )."_admin.php" ); // include language vars
//------------------------------------------------------------------------------
include ( "../func/html_header.php" ); // include html header
//------------------------------------------------------------------------------
function rmdir_recurse($path)
 {
    $path= rtrim($path, '/').'/';
    $handle = opendir($path);
    for (;false !== ($file = readdir($handle));)
        if($file != "." and $file != ".." )
        {
            $fullpath= $path.$file;
            if( is_dir($fullpath) )
            {
                rmdir_recurse($fullpath);
                rmdir($fullpath);
            }
            else
              unlink($fullpath);
        }
    closedir($handle);
}
//------------------------------------------------------------------------------
function read_files ( $path )
 {
  $result = array();
  $handle = opendir ( $path );
   if ($handle)
    {
     while ( false !== ( $file = readdir ( $handle ) ) )
      {
       if ( $file != "." && $file != ".." )
        {
         if ( !is_dir ( $path."/".$file ) && ( substr ( $file , 0 , 1) != "." ) )
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
if ( $_POST [ "backup" ] )
 {
  //------------------------------------------------------------------
  if ( is_dir ( "../backup/".$_POST [ "backup" ] ) )
   {
    rmdir_recurse ( "../backup/".$_POST [ "backup" ] );
    rmdir ( "../backup/".$_POST [ "backup" ] );
   }
  else
   {
    if ( file_exists ( "../backup/".$_POST [ "backup" ] ) )
     {
     	unlink ( "../backup/".$_POST [ "backup" ] );
     }
   }
  echo "<br><br><center><img src=\"../images/admin/done.png\" border=\"0\" width=\"32\" height=\"32\" style=\"vertical-align:middle;\" alt=\"\"> &nbsp; <b>".$lang_admin_db[5]."</b></center>";
  echo '<meta http-equiv="refresh" content="2; URL=delete_backup.php">';
  //------------------------------------------------------------------
 }
else
 {
  //------------------------------------------------------------------
  echo '
  <form style="margin:0px" action="'.$_SERVER [ "PHP_SELF" ].'" method="post">
  <table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" class="th2 bold center" style="height:18px; padding:2px; border-bottom:1px solid #0D638A;">'.$lang_admin_db[4].'</td>
  </tr>
  <tr>
    <td class="bg2">'.$lang_admin_db[2].'<br><div class="small">'.$lang_admin_db[3].'</div></td>
    <td class="bg3">
    <select name="backup" size="1" style="width:250px;">';
    $backup_dir_read = read_dir ( "../backup/" );
    asort ( $backup_dir_read );
    foreach ( $backup_dir_read as $value )
     {
      echo '<option value="'.$value.'">'.$value.'</option>\n';
     }
    $backup_files_read = read_files ( "../backup/" );
    asort ( $backup_files_read );
    foreach ( $backup_files_read as $value )
     {
      echo '<option value="'.$value.'">'.$value.'</option>\n';
     }
    echo '
    </select>
    </td>
  </tr>
  <tr>
    <td colspan="2" class="th2 center" style="height:24px; padding:2px; border-top:1px solid #0D638A;">
    <input type="submit" style="border:1px solid #7F9DB9; color:#000000; font-family:Verdana,Arial,Sans-Serif; font-size:12px; background-color:#FEFEFE; padding: 1px 10px 1px 10px; width:auto; overflow:visible; cursor:pointer;" value="'.$lang_admin_db[4].'">
    </td>
  </tr>
  </table>
  </form>
  ';
  //------------------------------------------------------------------
 }
//------------------------------------------------------------------------------
include ( "../func/html_footer.php" ); // include html footer
//------------------------------------------------------------------------------
?>