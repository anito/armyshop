<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.1.x                                                    #
# File-Release-Date:  09/10/16                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Reimar Hoven, Holger Naves                                          #
# Copyright © 2009 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

// stat setup
//------------------------------------------------------------------------------
// login
$lang_login[1] = "Access to this site is password protected and requires authentication.";
$lang_login[2] = "Please enter the admin password!";
$lang_login[3] = "Password:";
$lang_login[4] = "Login";
$lang_login[5] = "Cancel";
//------------------------------------------------------------------------------

// general
//------------------------------------------------------------------------------
$lang_setup[1] = "Statistic Installation";
$lang_setup[2] = "Welcome to the Installation of the PHP Web Stat";
$lang_setup[3] = "This interface allows you to install and configure the stat in an easy, fast and smart way.";
//------------------------------------------------------------------------------

// step chmod
//------------------------------------------------------------------------------
$lang_chmod[1] = "Controlling file rights";
$lang_chmod[2] = "Control successful!";
$lang_chmod[3] = "The control sample of the file rights was successful.";
$lang_chmod[4] = "Click on Next to get to the next step of the installation.";
$lang_chmod[5] = "File Rights wrong!";
$lang_chmod[6] = "Some of the file rights have not been set correctly.";
$lang_chmod[7] = "If you run the stat on a Windows based server, you do not need to set the file rights. Please click Next in this case.";
$lang_chmod[8] = "In all other cases, control the file rights using the manual. Click on Reload to recontrol the file rights.";
//------------------------------------------------------------------------------

// step choose
//------------------------------------------------------------------------------
$lang_choose[1] = "Place of storage for the log entries";
$lang_choose[2] = "Please make your selection";
$lang_choose[3] = "The stat can store all log entries in textfiles or in a database.";
$lang_choose[4] = "Select Textfiles if you want to store all log entries in textfiles.";
$lang_choose[5] = "We encourage you to use the database setting if your hoster limits the filesize on your server.";
$lang_choose[6] = "Textfiles";
$lang_choose[7] = "Database";
//------------------------------------------------------------------------------

// setup goadmin
//------------------------------------------------------------------------------
$lang_goadmin[1] = "Installation successful!";
$lang_goadmin[2] = "Click on Next to enter the Admin-Center. There you have to set the general configuration steps.";
$lang_goadmin[3] = "Do not forget to include the Javascript into your website (see Manual).";
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
$lang_db_connect[12] = "Saved";
$lang_db_connect[13] = "Connection failed!";
$lang_db_connect[14] = "The connection to the database has failed.<br>Please edit the settings and retry again by clicking on Save.";
//------------------- settings
$lang_db_prefix[1] = "Please enter a name (prefix) for your database tables.";
$lang_db_prefix[2] = "If you are using several stats, every name (prefix) for your database tables has to be entered differently.";
$lang_db_prefix[3] = "CAUTION";
$lang_db_prefix[4] = "No database tables found.<br>Click on \"Create Tables\" to proceed.";
$lang_db_prefix[5] = "Create Tables";
//------------------------------------------------------------------------------

// create db_tables
//------------------------------------------------------------------------------
$lang_db_tables[1] = "Logfile Transfer";
$lang_db_tables[2] = "Cancel";
$lang_db_tables[3] = "Next";
$lang_db_tables[4] = "Skip";
$lang_db_tables[5] = "Finish";
$lang_db_tables[6] = "Close window";
$lang_db_tables_1[1] = "Ready to create the required database tables. Available log data will be imported in the next step.";
$lang_db_tables_1[2] = "Please be sure that the database connection is correct and click on \"Next\".";
$lang_db_tables_2[1] = "Database tables creating, please wait...";
$lang_db_tables_2[2] = "Database tables created!";
$lang_db_tables_2[3] = "Table";
$lang_db_tables_3[1] = "No log data have been found to import.";
$lang_db_tables_3[2] = "Log data found and ready to import.";
$lang_db_tables_3[3] = "The next step will import the pattern file entries into the database.";
$lang_db_tables_3[4] = "Click Skips if you do not want to import the data.";
$lang_db_tables_4[1] = "Importing pattern file entries, please wait...";
$lang_db_tables_4[2] = "Pattern file entries imported!";
$lang_db_tables_4[3] = "The next step will import the logfile entries into the database.";
$lang_db_tables_4[4] = "Please choose the desired number of lines to be read.<br>(Recommendation 4000)";
$lang_db_tables_5[1] = "Data transfering to the database, please wait...";
$lang_db_tables_5[2] = "Number of entries finished";
$lang_db_tables_5[3] = "Total Number";
$lang_db_tables_6[1] = "The database tables will be optimized now, please wait...";
$lang_db_tables_6[2] = "This process can take a few seconds, depending on the size of the logfile. Please wait!";
$lang_db_tables_7[1] = "The data transfer has been processed successfully!";
$lang_db_tables_7[2] = "The database configuration has been setup successfully!";
//------------------------------------------------------------------------------

// setup footer
//------------------------------------------------------------------------------
$lang_footer[1] = "Next";
$lang_footer[2] = "Reload";
$lang_footer[3] = "Back";
$lang_footer[4] = "Cancel";
$lang_footer[5] = "Finish";
//------------------------------------------------------------------------------
?>