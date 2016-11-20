<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.9.x                                                    #
# File-Release-Date:  15/09/06                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2015 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

// admin center
//------------------------------------------------------------------------------
// login
$lang_login[1] = "Access to this site is password protected and requires authentication.";
$lang_login[2] = "Please enter the admin password!";
$lang_login[3] = "Password:";
$lang_login[4] = "Login";
$lang_login[5] = "Cancel";
//--------------------
// top menue
$lang_admin_tm[1] = "Back to Stat";
$lang_admin_tm[2] = "Admin Center Index";
$lang_admin_tm[3] = "Sysinfo";
$lang_admin_tm[4] = "Syscheck";
$lang_admin_tm[5] = "Online Manual";
$lang_admin_tm[6] = "Support Forum";
$lang_admin_tm[7] = "Logout";
//--------------------
// left menue
$lang_admin_lm[1] = "General Configuration";
$lang_admin_lm[2] = "Advanced Configuration";
$lang_admin_lm[3] = "Maintenance Features";
$lang_admin_lm[4] = "Advanced Features";
//------------------------------------------------------------------------------

// index
//------------------------------------------------------------------------------
$lang_admin_i[1] = "Welcome to the Admin-Center of your PHP-Web-Stat";
$lang_admin_i[2] = "The admincenter enables you to configure or edit your stat settings and use several maintenance tools.";
$lang_admin_i[3] = "Please note that you read the smallsized  notices before searching for help in the forum!";
$lang_admin_i[4] = "We thank you for choosing the PHP-Web-Stat!";
//-------------------- welcome
$lang_admin_i_vi[1]  = "Version Information";
$lang_admin_i_vi[2]  = "Running Version:";
$lang_admin_i_vi[3]  = "Remote Server not available";
$lang_admin_i_vi[4]  = "Latest Stable Version:";
$lang_admin_i_vi[5]  = "Latest Beta Version:";
$lang_admin_i_vi[6]  = "A new stable version is available!";
$lang_admin_i_vi[7]  = "If you want to download";
$lang_admin_i_vi[8]  = "the latest version, please visit our website.";
$lang_admin_i_vi[9]  = "You are using the latest stable version!";
$lang_admin_i_vi[10] = "The versioncheck only works with Javascript enabled!";
//-------------------- stat logins
$lang_admin_i_l[1] = "Last Stat Logins";
$lang_admin_i_l[2] = "Admin";
$lang_admin_i_l[3] = "User";
$lang_admin_i_l[4] = "Today";
$lang_admin_i_l[5] = "at";
$lang_admin_i_l[6] = "Empty Logfile";
$lang_admin_i_l[7] = "Logfile has been emptied";
//-------------------- information
$lang_admin_i_i[1]   = "Latest Information & News";
//-------------------- thanks
$lang_admin_i_thx[1] = "Acknowledgement";
$lang_admin_i_thx[2] = "We would like to thank the following persons for their proactively support:";
$lang_admin_i_thx[3] = "";
//------------------------------------------------------------------------------

// general settings
//------------------------------------------------------------------------------
$lang_admin_gs[1]  = "General Settings";
$lang_admin_gs[2]  = "Tracking of ";
$lang_admin_gs[3]  = "The stat is tracking by using the selected mode.";
$lang_admin_gs[4]  = "Text Files";
$lang_admin_gs[5]  = "Database";
$lang_admin_gs[6]  = "What is your domain?";
$lang_admin_gs[7]  = "Please enter the complete path of your domain, for example <b>http://www.mydomain.com</b>. No Slashes or further folders are allowed after the domain.";
$lang_admin_gs[8]  = "Starting page of your domain";
$lang_admin_gs[9]  = "Here you should enter the starting page of your domain, e.g. <b>index.php</b>";
$lang_admin_gs[10] = "Stat folder";
$lang_admin_gs[11] = "Please enter the relative path to your stat, e.g. <b>stat/</b>. The last char has be set to /";
$lang_admin_gs[12] = "Which domains should be tracked by the stat?";
$lang_admin_gs[13] = "Please enter all domain names that should be tracked by the stat. Please be aware that every entry starts without 'www.'. So if your domain name is http://www.mydomain.com, just enter <b>mydomain.com</b>. <u>Please use a seperate line for each value.</u> <br>In the case of a subdomain, enter only the main domain. So if your subdomain would be http://name.yourdomain.com, enter only <b>yourdomain.com</b>";
$lang_admin_gs[14] = "The stat tracks for whom?";
$lang_admin_gs[15] = "Enter a domain name or a phrase of your individual choice.";
$lang_admin_gs[16] = "Language file";
$lang_admin_gs[17] = "Please choose a appropriate language file.";
$lang_admin_gs[18] = "Country file";
$lang_admin_gs[19] = "Please choose a appropriate country detection file.";
$lang_admin_gs[20] = "Dynamic URLs";
$lang_admin_gs[21] = "If you use dynamic urls, please enter parameters like \"category\" that should be tracked by the stat. So you can be sure that only useful parameters will be tracked. <u>Please use a seperate line for each value.</u>";
//------------------------------------------------------------------------------

// advanced settings
//------------------------------------------------------------------------------
$lang_admin_as[1] = "Advanced Settings";
$lang_admin_as[2] = "General";
$lang_admin_as[3] = "Security";
$lang_admin_as[4] = "Display";
//-------------------- general
$lang_admin_as_g[1]  = "Exclude IP Addresses";
$lang_admin_as_g[2]  = "Here you can enter all IP Addresses you want to exclude from logging. <br>If you want to exclude ip address ranges from being tracked, please use the following syntax: <br>123.456.789.* <br>123.456.*.* <br><u>Please use a seperate line for each value.</u>";
$lang_admin_as_g[3]  = "Server Time";
$lang_admin_as_g[4]  = "If the shown time here is not your hometime, please choose the difference in the list.";
$lang_admin_as_g[5]  = "Hour";
$lang_admin_as_g[6]  = "Hours";
$lang_admin_as_g[7]  = "Do you use frames on your site?";
$lang_admin_as_g[8]  = "Time in minutes after a user will be tracked as a new one";
$lang_admin_as_g[9]  = "Automatic update check?";
$lang_admin_as_g[10] = "Please activate this option if you want to be notified about major updates of the stat.";
$lang_admin_as_g[11] = "Starting date of the stat";
$lang_admin_as_g[12] = "Here you can manually set the starting date of the stat, e.g. <b>15.08.2006</b>.<br>If you enter nothing, the first logfile entry will be used as the starting date.";
$lang_admin_as_g[13] = "Increase the total number of visitors";
$lang_admin_as_g[14] = "Please enter a number that will be added to the total number of visitors.<br><b>There will be no analysis for this number.</b>";
$lang_admin_as_g[15] = "Creator Lines to read";
$lang_admin_as_g[16] = "Use the following suggestions:<br><br>Standard = 5000<br>Strato = 2500<br>Hosteurope = 5000 - 10000";
$lang_admin_as_g[17] = "Show error messages";
$lang_admin_as_g[18] = "If you encounter problems, this enables you to view error messages in some stat files.";
$lang_admin_as_g[19] = "Tracking of Google Image Referers";
$lang_admin_as_g[20] = "Visitors coming from Google Images will be tracked.";
$lang_admin_as_g[21] = "Tracking of Google AdWords Referers";
$lang_admin_as_g[22] = "Visitors coming from Google Adwords will be tracked.";
$lang_admin_as_g[23] = "PHP-Variable of the User IP Address ";
$lang_admin_as_g[24] = "The PHP variable has to be choosed that should be used to get the user ip address.";
$lang_admin_as_g[25] = "Anonymize IP Address?";
$lang_admin_as_g[26] = "If the ip address should be anonymized, please make your selection. You can choose between no anonymization, partial and full anonymization.";
$lang_admin_as_g[27] = "No Anonymization";
$lang_admin_as_g[28] = "Partial Anonymization";
$lang_admin_as_g[29] = "Full Anonymization";
$lang_admin_as_g[30] = "Index Creator Lines to read";
$lang_admin_as_g[31] = "Please use the following suggestions depending on the amount of visitor traffic:<br><br>normal = 30.000<br>enhanced = 50.000<br>high = 100.000";
$lang_admin_as_g[32] = "Automatic Cache Update";
$lang_admin_as_g[33] = "Please choose a minute interval for an automatic cache update.";
$lang_admin_as_g[34] = "Update disabled";
$lang_admin_as_g[35] = "Cache Optimization (Reduced Referer)";
$lang_admin_as_g[36] = "This optimization reduces the filesize of the cachefile, but is only available within more than 5.000 referers.<br><br>\"0\" = No change<br>\"1\" = Delete all referer data only occured once<br>\"2\" = Delete all referer data only occured twice.";
$lang_admin_as_g[37] = "Exclude Referer";
$lang_admin_as_g[38] = "Here you can enter all referer (URL Strings) you want to exclude from logging.<br>Please use the following syntax:<br>some-spammer<br>other-spammer<br><u>Please use a seperate line for each value.</u>";
$lang_admin_as_g[39] = "Exclude Bots (Searchengines)";
$lang_admin_as_g[40] = "Here you can enter all bots (partial strings of the Useragent) you want to exclude from logging.<br>Please use the following syntax:<br>bingbot<br>googlebot<br><u>Please use a seperate line for each value.</u>";
//-------------------- security
$lang_admin_as_s[1]  = "Admin Password";
$lang_admin_as_s[2]  = "Enter a password of your choice.";
$lang_admin_as_s[3]  = "User Password";
$lang_admin_as_s[4]  = "Enter a user password here.<br>This enables you to enter the stat in a write-protected mode without further permissions.";
$lang_admin_as_s[5]  = "Protect the stat with a password?";
$lang_admin_as_s[6]  = "Protect the cookie settings with a password?";
$lang_admin_as_s[7]  = "Enable security mode for your log folder?";
$lang_admin_as_s[8]  = "Activate automatic logout?";
$lang_admin_as_s[9]  = "Please choose the time in minutes for the automatic session timeout.";
$lang_admin_as_s[10] = "Your session has been inactive since a few minutes.<br>For security reasons you have been logged out automatically.<br><br>Please login again.";
//-------------------- display
$lang_admin_as_d[1]  = "Colorscheme";
$lang_admin_as_d[2]  = "Choose the colorscheme of your choice.";
$lang_admin_as_d[3]  = "Show detailed browser versions?";
$lang_admin_as_d[30] = "Please choose <b>A</b> if the version number should be formatted with <b>one decimal number</b>, e.g. Browser <b>3.2</b>.<br>Please choose <b>B</b> if the <b>complete version number</b> should be shown, e.g. Browser <b>3.2.145</b>.";
$lang_admin_as_d[31] = "No";
$lang_admin_as_d[32] = "Yes (Option A)";
$lang_admin_as_d[33] = "Yes (Option B)";
$lang_admin_as_d[4]  = "Show detailed referers?";
$lang_admin_as_d[5]  = "Show country flags?";
$lang_admin_as_d[6]  = "Show browser icons?";
$lang_admin_as_d[7]  = "Show os icons?";
$lang_admin_as_d[8]  = "Configuration of the percent values and progress bars";
$lang_admin_as_d[9]  = "Please choose <b>1</b> if the percentage values rely on the <b>total sum of entries of the desired module</b>.<br><br>Please choose <b>2</b> if the percentage values rely on the <b>sum of the visible entries of the desired module</b>";
$lang_admin_as_d[10] = "Advanced configuration of the progress bars";
$lang_admin_as_d[11] = "Please choose <b>1</b> if the progress bars are <b>equal to the percentage values</b>.<br><br>Please choose <b>2</b> if the progress bars rely on the <b>maximum value</b> of the entries.";
$lang_admin_as_d[12] = "Number of default entries within the Last Hits section";
$lang_admin_as_d[13] = "Choose a default value how many entries should be shown within the Last Hits section.";
$lang_admin_as_d[14] = "Whois Query of IP Addresses within the Last Hits section?";
$lang_admin_as_d[15] = "Here you can choose a service that provides the localization of clicking on the ip address in the Last Hits section.";
$lang_admin_as_d[16] = "Show detailed OS versions?";
$lang_admin_as_d[17] = "Last Hits";
$lang_admin_as_d[18] = "Floatbox Windows Size";
$lang_admin_as_d[19] = "Column Width \"Sitenames\"";
$lang_admin_as_d[20] = "Setting the column width will set the remaining space for the width of the column \"Referers\".";
$lang_admin_as_d[21] = "Cut Sitenames String Length";
$lang_admin_as_d[22] = "Define how many chars will  be shown of the sitename string. This will avoid unwanted carriage returns. Outstanding strings will be replaced by \"...\".";
$lang_admin_as_d[23] = "Cut Referer String Length";
$lang_admin_as_d[24] = "Define how many chars will be shown of the referer string. Outstanding strings will be replaced by \"...\". Cutting the referer string will not disable its functionality.";
$lang_admin_as_d[25] = "Enable Last Hits section also for website visitors?";
$lang_admin_as_d[26] = "If you set a password for entering the stat, this function will not be available.";
$lang_admin_as_d[27] = "Show IP addresses for visitors (client) logged in";
$lang_admin_as_d[28] = "Please activate this option if a client should be able to see the IP addresses within the Last Hits section.";
//------------------------------------------------------------------------------

// database settings
//------------------------------------------------------------------------------
//-------------------- connect
$lang_db_connect[1]  = "Database Settings";
$lang_db_connect[2]  = "Database Access";
$lang_db_connect[3]  = "Hostname";
$lang_db_connect[4]  = "Enter the hostname of your database, e.g. <b>localhost</b> or the complete url of your database.";
$lang_db_connect[5]  = "Database name";
$lang_db_connect[6]  = "Edit the database name that should be used by the stat.";
$lang_db_connect[7]  = "Username";
$lang_db_connect[8]  = "Enter the required username of your database.";
$lang_db_connect[9]  = "Password";
$lang_db_connect[10] = "Enter the required database password.";
$lang_db_connect[11] = "Saved";
//------------------- settings
$lang_db_prefix[1] = "Please enter a name (prefix) for your database tables.";
$lang_db_prefix[2] = "If you are using several stats, every name (prefix) for your database tables has to be entered differently.";
$lang_db_prefix[3] = "CAUTION";
$lang_db_prefix[4] = "No database tables found.<br>Click on \"Create Tables\" to proceed.";
$lang_db_prefix[5] = "Create Tables";
//------------------------------------------------------------------------------

// module settings
//------------------------------------------------------------------------------
$lang_admin_ms[1]  = "Module Settings";
$lang_admin_ms[2]  = "Properties";
$lang_admin_ms[3]  = "Module";
$lang_admin_ms[4]  = "On / Off";
$lang_admin_ms[5]  = "Width in pixel";
$lang_admin_ms[6]  = "Lines";
$lang_admin_ms[7]  = "Visitors";
$lang_admin_ms[8]  = "Visitors per hour";
$lang_admin_ms[9]  = "Visitors this month";
$lang_admin_ms[10] = "Visitors per weekday";
$lang_admin_ms[11] = "Visitors per month";
$lang_admin_ms[12] = "Visitors per year";
$lang_admin_ms[13] = "Browsers";
$lang_admin_ms[14] = "Operating Systems";
$lang_admin_ms[15] = "Screen Resolutions";
$lang_admin_ms[16] = "Screen Colordepths";
$lang_admin_ms[17] = "Page Impressions";
$lang_admin_ms[18] = "Referers";
$lang_admin_ms[19] = "Entry Sites";
$lang_admin_ms[20] = "Search Engines";
$lang_admin_ms[21] = "Search Terms";
$lang_admin_ms[22] = "Countries of Origin";
$lang_admin_ms[23] = "JavaScript Status";
//------------------------------------------------------------------------------

// pattern editor
//------------------------------------------------------------------------------
$lang_admin_pe[1] = "Edit Sitenames";
$lang_admin_pe[2] = "Names";
$lang_admin_pe[3] = "Here you can name your files to get a better detail view of your tracked files in the stat.";
$lang_admin_pe[4] = "Example: &nbsp; index.php|Startseite";
//------------------------------------------------------------------------------

// pattern string replace
//------------------------------------------------------------------------------
$lang_admin_re[1] = "Replace URL Strings";
$lang_admin_re[2] = "Part";
$lang_admin_re[3] = "Parts of the URL can be replaced by own strings.";
$lang_admin_re[4] = "Example: &nbsp; shop-buy-cart|shopping cart";
//------------------------------------------------------------------------------

// counter settings
//------------------------------------------------------------------------------
$lang_admin_cs[1] = "Counter Settings";
$lang_admin_cs[2] = "Display";
$lang_admin_cs[3] = "Line of Counter";
$lang_admin_cs[4] = "On / Off";
//-------------------- display
$lang_admin_cs_d[1]  = "Online";
$lang_admin_cs_d[2]  = "Today";
$lang_admin_cs_d[3]  = "Yesterday";
$lang_admin_cs_d[4]  = "This month";
$lang_admin_cs_d[5]  = "Last month";
$lang_admin_cs_d[6]  = "Maximum";
$lang_admin_cs_d[7]  = "&#216;/Day";
$lang_admin_cs_d[8]  = "Total";
$lang_admin_cs_d[9]  = "Footer including starting date of the stat";
$lang_admin_cs_d[10] = "Ticker";
$lang_admin_cs_d[11] = "By activating this option, a dynamic ticker will be available within the footer of the counter. Different visualization options are given, please make your choice.";
$lang_admin_cs_d[12] = "Tracking Start Date";
$lang_admin_cs_d[13] = "Last Cache Update";
$lang_admin_cs_d[14] = "Total Page Impressions";
$lang_admin_cs_d[15] = "Monthly Trend";
//-------------------- settings
$lang_admin_cs_s[1] = "Properties";
$lang_admin_cs_s[2] = "Visitors Online Time";
$lang_admin_cs_s[3] = "Time in minutes a user will be shown as online";
$lang_admin_cs_s[4] = "Increase the total number of visitors";
$lang_admin_cs_s[5] = "Enter the number of visitors of an old counter that should be added to the recent total counter value.";
//------------------------------------------------------------------------------

// maintenance mode
//------------------------------------------------------------------------------
$lang_admin_mm[1] = "Maintenance Mode";
$lang_admin_mm[2] = "The maintenance mode enables you to stop the tracking of your stat. By activating the maintenance mode, no log entries will be written.<br>You can use this function if you need to manually edit your logfile entries without getting disturbed.";
$lang_admin_mm[3] = "Status";
$lang_admin_mm[4] = "Current State";
$lang_admin_mm[5] = "If the maintenance mode is enabled, you will also get a notice in the main stat display.";
$lang_admin_mm[6] = "Stat Active";
$lang_admin_mm[7] = "Save";
//------------------------------------------------------------------------------

// create cache
//------------------------------------------------------------------------------
$lang_admin_dc[1] = "Recreate Cache";
$lang_admin_dc[2] = "A new window has been opened. If not, please click";
$lang_admin_dc[3] = "here";
//-------------------- panel
$lang_admin_cc[1]  = "You are going to recreate the cache now";
$lang_admin_cc[2]  = "This operation can take several minutes. Please do not close this window while operating.";
$lang_admin_cc[3]  = "Please click Next to recreate the cache";
$lang_admin_cc[4]  = "Next";
$lang_admin_cc[5]  = "Cancel";
$lang_admin_cc[6]  = "Cache creating, please wait...";
$lang_admin_cc[7]  = "The creation of the cache can take <u>a few minutes</u>, depending on your logfile size.";
$lang_admin_cc[8]  = "Please do not cancel the process!";
$lang_admin_cc[9]  = "The cache has been recreated successfully.";
$lang_admin_cc[10] = "";
$lang_admin_cc[11] = "Finish";
//------------------------------------------------------------------------------

// create index
//------------------------------------------------------------------------------
$lang_admin_ci[1] = "Recreate Index";
$lang_admin_ci[2] = "The stat index will be used to store the memory addresses of all website visitor days. The full indexing of the data can leads to a better performance of the stat. If you encounter any problems with the performance or errors, please recreate the index.";
$lang_admin_ci[3] = "Notice";
$lang_admin_ci[4] = "Clicking the button \"Index recreate\" will delete and recreate the existing index. This can take a few minutes depending on the size of the stat data.";
$lang_admin_ci[5] = "Index recreate";
$lang_admin_ci[6] = "The index will be recreated in a few seconds.<br><br>Please do not close this window until the percentage progress bar in the upper left corner has reached 100%.";
//------------------------------------------------------------------------------

// logfile repair
//------------------------------------------------------------------------------
$lang_admin_lr[1]  = "Logfile repair";
$lang_admin_lr[2]  = "This script can check and repair the stat logfiles.";
$lang_admin_lr[3]  = "Check and repair the stat logfiles";
$lang_admin_lr[4]  = "CAUTION";
$lang_admin_lr[5]  = "Set the PHP Web Stat to maintenance mode before starting to repair files!";
$lang_admin_lr[6]  = "Please choose the desired menu item in the left menu and set the stat to the maintenance mode.";
$lang_admin_lr[7]  = "Select file";
$lang_admin_lr[8]  = "Please select the file to be checked";
$lang_admin_lr[9]  = "Check";
$lang_admin_lr[10] = "Report";
$lang_admin_lr[11] = "Checked file";
$lang_admin_lr[12] = "Number of errors found";
$lang_admin_lr[13] = "Number of empty lines";
$lang_admin_lr[14] = "Number of lines with wrong number of delimiters";
$lang_admin_lr[15] = "Number of double lines";
$lang_admin_lr[16] = "Number of lines with wrong timestamps";
$lang_admin_lr[17] = "Number of lines with too high timestamps";
$lang_admin_lr[18] = "If errors still appear after repairing, the desired lines have to be edit manually.";
$lang_admin_lr[19] = "Repair";
$lang_admin_lr[20] = "Back to file selection";
$lang_admin_lr[21] = "Successful!";
$lang_admin_lr[22] = "The selected file has been repaired successfully.";
$lang_admin_lr[23] = "File not found";
//------------------------------------------------------------------------------

// delete archive cache
//------------------------------------------------------------------------------
$lang_admin_dac[1] = "Delete Archive Caches";
$lang_admin_dac[2] = "Saved archives of the stat can be deleted here.";
$lang_admin_dac[3] = "Archives";
$lang_admin_dac[4] = "Please select the archive to be deleted.";
$lang_admin_dac[5] = "Deleted archives can be recreated by using the Archive function in the main stat.";
$lang_admin_dac[6] = "Delete Archive";
//------------------------------------------------------------------------------

// database editor
//------------------------------------------------------------------------------
$lang_admin_db_e[1] = "Database Editor";
$lang_admin_db_e[2] = "Here you can query your database with SQL statements.";
$lang_admin_db_e[3] = "This function is only provided for support purposes. We point out that we are not liable for any risks of damage by improper use.";
//------------------------------------------------------------------------------

// create backup
//------------------------------------------------------------------------------
$lang_admin_cb[1]  = "Statistic Backup";
$lang_admin_cb[2]  = "Please be aware to set the permissions of the folder \"backup\" to (CHMOD) 777.";
$lang_admin_lfb[1] = "Create Log- & Cachefile Backup";
$lang_admin_cfb[1] = "Create Cachefile Backup";
$lang_admin_lfb[2] = "Here you can create a backup of your logfiles.";
$lang_admin_cfb[2] = "Here you can create a backup of your cache files.";
$lang_admin_cb[3]  = "Choose between a compressed backup-file (ZIP) or a folder copy. Please be aware that the zip function is not supported on all servers.";
$lang_admin_cb[4]  = "After clicking on \"Create Backup\", a zip file with the syntax of \"backup_YYYY-MM-DD.zip\" or a folder with the syntax of \"backup_YYYY-MM-DD\" will be created in the stat folder \"backup\".";
$lang_admin_cb[5]  = "Create Backup";
$lang_admin_cb[6]  = "Backup created!";
//------------------------------------------------------------------------------

// delete backup
//------------------------------------------------------------------------------
$lang_admin_db[1] = "Delete Backup";
$lang_admin_db[2] = "Choose the backup to delete.";
$lang_admin_db[3] = "";
$lang_admin_db[4] = "Delete Backup";
$lang_admin_db[5] = "Backup deleted!";
//------------------------------------------------------------------------------

// stat restart
//------------------------------------------------------------------------------
$lang_admin_sr[1]  = "Stat Reset";
$lang_admin_sr[2]  = "Do you want to reset your stat? <br><br>All Log- and Cache-Entries will be irrevocable deleted.";
$lang_admin_sr[3]  = "Continue the process if you are really sure of.";
$lang_admin_sr[4]  = "Due to security reasons, you have to click on \"Next\" to reset the stat.";
$lang_admin_sr[5]  = "Next";
$lang_admin_sr[6]  = "CAUTION";
$lang_admin_sr[7]  = "The stat will be reset and restarted after clicking on \"Next\".";
$lang_admin_sr[8]  = "Next";
$lang_admin_sr[9]  = "Finished";
$lang_admin_sr[10] = "The stat has been reset!";
//------------------------------------------------------------------------------

// CSS editor
//------------------------------------------------------------------------------
$lang_admin_ce[1] = "CSS Editor";
$lang_admin_ce[2] = "Stat";
$lang_admin_ce[3] = "Counter";
$lang_admin_ce[4] = "Admin Center";
$lang_admin_ce[5] = "Print View";
$lang_admin_ce[6] = "Please note stat the CSS file is writeable (CHMOD 666).";
$lang_admin_ce[7] = "The CSS file you want to edit depends on the colorscheme choosen in the general settings.";
//------------------------------------------------------------------------------

// file version
//------------------------------------------------------------------------------
$lang_admin_fv[1] = "File Versions";
$lang_admin_fv[2] = "Stat Version";
$lang_admin_fv[3] = "Files in the Root folder";
$lang_admin_fv[4] = "Filename";
$lang_admin_fv[5] = "Version";
$lang_admin_fv[6] = "Date";
$lang_admin_fv[7] = "Files in the Config folder";
$lang_admin_fv[8] = "Files in the Language folder";
$lang_admin_fv[9] = "Files in the Func folder";
//------------------------------------------------------------------------------

// syscheck
//------------------------------------------------------------------------------
$lang_admin_sc[1]  = "Systemcheck";
$lang_admin_sc[2]  = "Within this panel you can check your stat and server configuration and functionality.";
$lang_admin_sc[3]  = "This function checks for correct tracking. Data records will be written in your logfiles.";
$lang_admin_sc[4]  = "Output";
$lang_admin_sc[5]  = "phpinfo";
$lang_admin_sc[6]  = "Server Environment Variables";
$lang_admin_sc[7]  = "Session Variables";
$lang_admin_sc[8]  = "";
$lang_admin_sc[9]  = "";
$lang_admin_sc[10] = "Check";
$lang_admin_sc[11] = "IP Address";
$lang_admin_sc[12] = "Database";
$lang_admin_sc[13] = "File permissions (chmod)";
$lang_admin_sc[14] = "Configuration";
$lang_admin_sc[15] = "Tracking";
$lang_admin_sc[16] = "";
$lang_admin_sc[17] = "";
$lang_admin_sc[18] = "Please choose one of the options above to get more information about your server or to check the functionality.";
$lang_admin_sc[19] = "Results";
$lang_admin_sc[20] = "Hostname";
$lang_admin_sc[21] = "Name of Database";
$lang_admin_sc[22] = "Username";
$lang_admin_sc[23] = "Password";
$lang_admin_sc[24] = "Prefix";
$lang_admin_sc[25] = "Could not connect to MySQL";
$lang_admin_sc[26] = "";
$lang_admin_sc[27] = "";
$lang_admin_sc[28] = "Server operating system";
$lang_admin_sc[29] = "Write authority the";
$lang_admin_sc[30] = "passed";
$lang_admin_sc[31] = "failed";
$lang_admin_sc[32] = "";
$lang_admin_sc[33] = "Your manual input does not start with \"http://\" or \"https://\"";
$lang_admin_sc[34] = "The domain entry differs from the server response.";
$lang_admin_sc[35] = "Number \"/\" is not correct";
$lang_admin_sc[36] = "incorrect";
$lang_admin_sc[37] = "Errorcode";
$lang_admin_sc[38] = "is not available";
$lang_admin_sc[39] = "Error occured";
$lang_admin_sc[40] = "On some systems (browser/server) unusual character output can occur. This data has no impact and can be ignored.";
$lang_admin_sc[41] = "Testlog";
$lang_admin_sc[42] = "JavaScript enabled";
$lang_admin_sc[43] = "JavaScript disabled";
$lang_admin_sc[44] = "3 records have been saved.";
$lang_admin_sc[45] = "2 records should have been saved.";
$lang_admin_sc[46] = "Check your stat for these records";
$lang_admin_sc[47] = "The test did not work. The configuration is set to \"Exclude IP Addresses\" within the stat.";
$lang_admin_sc[48] = "The test did not work. The configuration is set to \"Exclude own visits\" within the stat.";
$lang_admin_sc[49] = "The test did not work. The testing domain cannot be found within the admin panel under \"General Settings - Domains to track\".";
//------------------------------------------------------------------------------

// footer
//------------------------------------------------------------------------------
$lang_admin_f[1] = "Save";
//------------------------------------------------------------------------------
?>