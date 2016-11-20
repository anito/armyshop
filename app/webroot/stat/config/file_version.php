<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.6.x                                                    #
# File-Release-Date:  12/07/14                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2012 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
include ( "config.php" ); // include path to style
include ( "../".substr ( $language , 0 , strpos ( $language , "." ) )."_admin.php" ); // include language vars
//------------------------------------------------------------------------------
function check_file_version ( $file_name )
 {
  $check_file = file ( $file_name );
  $version    = trim ( substr ( $check_file [ 6 ] , 22 , 9 ) );
  $release    = trim ( substr ( $check_file [ 7 ] , 22 , 8 ) );
  return $version;
 }
function check_file_release ( $file_name )
 {
  $check_file = file ( $file_name );
  $release    = trim ( substr ( $check_file [ 7 ] , 22 , 8 ) );
  return $release;
 }
//------------------------------------------------------------------------------
include ( "../func/html_header.php" ); // include html header
//------------------------------------------------------------------------------
echo "<table class=\"standard\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">
<tr>
  <td colspan=\"3\" class=\"th2 bold center\">".$lang_admin_fv[3]."</td>
</tr>
<tr>
  <td class=\"bg1 bold center\" style=\"padding:4px;\">".$lang_admin_fv[4]."</td>
  <td class=\"bg1 bold center\" style=\"padding:4px;\">".$lang_admin_fv[5]."</td>
  <td class=\"bg1 bold center\" style=\"padding:4px;\">".$lang_admin_fv[6]."</td>
</tr>
<tr>
  <td class=\"bg1\">archive.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../archive.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../archive.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">cache_creator.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../cache_creator.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../cache_creator.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">cache_panel.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../cache_panel.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../cache_panel.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">cookie.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../cookie.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../cookie.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">counter.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../counter.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../counter.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">db_connect.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../db_connect.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../db_connect.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">detail_view.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../detail_view.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../detail_view.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">index.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../index.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../index.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">last_hits.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../last_hits.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../last_hits.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">plugin_choose.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../plugin_choose.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../plugin_choose.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">plugin_loader.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../plugin_loader.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../plugin_loader.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">syscheck.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../syscheck.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../syscheck.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">sysinfo.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../sysinfo.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../sysinfo.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">track.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../track.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../track.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">track_file.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../track_file.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../track_file.php" )."</td>
</tr>
<tr>
  <td colspan=\"3\" class=\"th2 bold center\">".$lang_admin_fv[7]."</td>
</tr>
<tr>
  <td class=\"bg1\">admin.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "admin.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "admin.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">backup.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "backup.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "backup.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">db_transfer.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "db_transfer.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "db_transfer.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">delete_archive.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "delete_archive.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "delete_archive.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">delete_backup.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "delete_backup.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "delete_backup.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">delete_index.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "delete_index.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "delete_index.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">edit_css.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "edit_css.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "edit_css.php" )."</td>
</tr>";
if ( file_exists ( "edit_db.php" ) )
 {
  echo "
  <tr>
    <td class=\"bg1\">edit_db.php</td>
    <td bgcolor=\"#D7E2EA\">".check_file_version ( "edit_db.php" )."</td>
    <td bgcolor=\"#D7E2EA\">".check_file_release ( "edit_db.php" )."</td>
  </tr>
  ";
 }
echo"
<tr>
  <td class=\"bg1\">edit_site_name.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "edit_site_name.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "edit_site_name.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">edit_string_replace.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "edit_string_replace.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "edit_string_replace.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">file_version.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "file_version.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "file_version.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">repair.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "repair.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "repair.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">reset.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "reset.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "reset.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">setup.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "setup.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "setup.php" )."</td>
</tr>
<tr>
  <td colspan=\"3\" class=\"th2 bold center\">".$lang_admin_fv[8]."</td>
</tr>
<tr>
  <td class=\"bg1\">german.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../language/german.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../language/german.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">german_admin.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../language/german_admin.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../language/german_admin.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">german_country.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../language/german_country.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../language/german_country.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">german_setup.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../language/german_setup.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../language/german_setup.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">english.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../language/english.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../language/english.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">english_admin.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../language/english_admin.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../language/english_admin.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">english_country.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../language/english_country.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../language/english_country.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">english_setup.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../language/english_setup.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../language/english_setup.php" )."</td>
</tr>
<tr>
  <td colspan=\"3\" class=\"th2 bold center\">".$lang_admin_fv[9]."</td>
</tr>
<tr>
  <td class=\"bg1\">func_archive_save.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_archive_save.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_archive_save.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_browser.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_browser.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_browser.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_cache_control.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_cache_control.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_cache_control.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_cache_write.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_cache_write.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_cache_write.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_create_index.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_create_index.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_create_index.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_display.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_display.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_display.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_display_trends.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_display_trends.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_display_trends.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_error.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_error.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_error.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_kill_special_chars.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_kill_special_chars.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_kill_special_chars.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_load_creator.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_load_creator.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_load_creator.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_last_logins.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_last_logins.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_last_logins.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_last_logins_show.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_last_logins_show.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_last_logins_show.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_operating_system.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_operating_system.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_operating_system.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_pattern_icons.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_pattern_icons.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_pattern_icons.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_pattern_matching.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_pattern_matching.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_pattern_matching.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_pattern_reverse.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_pattern_reverse.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_pattern_reverse.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_read_dir.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_read_dir.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_read_dir.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_refresh.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_refresh.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_refresh.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_timer.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_timer.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_timer.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">func_timestamp_control.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/func_timestamp_control.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/func_timestamp_control.php" )."</td>
</tr>
<tr>
  <td class=\"bg1\">html_header.php</td>
  <td bgcolor=\"#D7E2EA\">".check_file_version ( "../func/html_header.php" )."</td>
  <td bgcolor=\"#D7E2EA\">".check_file_release ( "../func/html_header.php" )."</td>
</tr>
</table>";
//------------------------------------------------------------------------------
include ( "../func/html_footer.php" ); // include html footer
//------------------------------------------------------------------------------
?>