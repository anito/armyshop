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
$lang_login[1] = "Der Zugriff auf diese Seite erfordert die Eingabe eines Passwortes.";
$lang_login[2] = "Bitte geben Sie das Admin-Passwort ein!";
$lang_login[3] = "Passwort:";
$lang_login[4] = "Login";
$lang_login[5] = "Abbrechen";
//------------------------------------------------------------------------------

// general
//------------------------------------------------------------------------------
$lang_setup[1] = "Statistik Installation";
$lang_setup[2] = "Willkommen bei der Installation der PHP Web Stat";
$lang_setup[3] = "Die Setup-Routine bietet Ihnen die Möglichkeit Ihre Statistik einfach, schnell und problemlos zu installieren.";
//------------------------------------------------------------------------------

// step chmod
//------------------------------------------------------------------------------
$lang_chmod[1] = "Prüfung der Dateirechte";
$lang_chmod[2] = "Prüfung erfolgreich!";
$lang_chmod[3] = "Eine Stichprobe der gesetzten Dateirechte wurde erfolgreich durchgeführt.";
$lang_chmod[4] = "Klicken Sie auf Weiter um zum nächsten Schritt der Installation zu gelangen.";
$lang_chmod[5] = "Dateirechte fehlerhaft!";
$lang_chmod[6] = "Es wurde festgestellt, dass einige Dateirechte nicht korrekt gesetzt wurden.";
$lang_chmod[7] = "Sollten Sie einen Windows-Server nutzen, so ist das Setzen der Dateirechte nicht notwendig. Bitte klicken Sie in diesem Falle auf Weiter.";
$lang_chmod[8] = "Prüfen Sie in allen anderen Fällen die notwendigen Dateirechte anhand der Anleitung. Durch Klicken auf Aktualisieren können Sie eine erneute Prüfung durchführen.";
//------------------------------------------------------------------------------

// step choose
//------------------------------------------------------------------------------
$lang_choose[1] = "Speicherort von Logeinträgen";
$lang_choose[2] = "Treffen Sie Ihre Auswahl";
$lang_choose[3] = "Die Statistik kann Logeinträge in Textdateien oder in einer Datenbank speichern.";
$lang_choose[4] = "Wählen Sie Textdateien wenn die Statistik alle aufkommenden Logeinträge in Textdateien im Ordner Log speichern soll.";
$lang_choose[5] = "Wir empfehlen die Aufzeichnung in eine Datenbank, wenn Ihr Hoster beispielsweise die Dateigröße einschränkt.";
$lang_choose[6] = "Textdateien";
$lang_choose[7] = "Datenbank";
//------------------------------------------------------------------------------

// setup goadmin
//------------------------------------------------------------------------------
$lang_goadmin[1] = "Die Installation wurde erfolgreich abgeschlossen!";
$lang_goadmin[2] = "Mit Klick auf Weiter werden Sie zum Admin Center geleitet, wo Sie die Grundeinstellungen Ihrer Statistik vornehmen müssen.";
$lang_goadmin[3] = "Vergessen Sie nicht nach dem Einrichten das Javascript in Ihre Webseite einzufügen (siehe Anleitung).";
//------------------------------------------------------------------------------

// database settings
//------------------------------------------------------------------------------
//-------------------- connect
$lang_db_connect[1]  = "Datenbank Einstellungen";
$lang_db_connect[2]  = "Datenbank Zugang";
$lang_db_connect[3]  = "Hostname";
$lang_db_connect[4]  = "Tragen Sie hier den Hostnamen Ihrer Datenbank ein, z.B. <b>localhost</b> oder die komplette URL.";
$lang_db_connect[5]  = "Name der Datenbank";
$lang_db_connect[6]  = "Notieren Sie die Datenbank die verwendet werden soll.";
$lang_db_connect[7]  = "Benutzername";
$lang_db_connect[8]  = "Hier muss der Benutzername eingetragen werden, um einen Zugriff auf die Datenbank zu ermöglichen.";
$lang_db_connect[9]  = "Passwort";
$lang_db_connect[10] = "Hier muss das Passwort Ihres Zugangs eingetragen werden.";
$lang_db_connect[11] = "Gespeichert!";
$lang_db_connect[12] = "Speichern";
$lang_db_connect[13] = "Fehlerhafte Verbindung!";
$lang_db_connect[14] = "Die von Ihnen eingegebene Verbindung zur Datenbank wurde zurückgewiesen.<br>Bitte korrigieren Sie Ihre Eingabe und klicken erneut auf Speichern.";
//------------------- settings
$lang_db_prefix[1] = "Bitte geben Sie einen Namen (Prefix) für die Datenbank-Tabellen an, z.B. <b>stat</b>.";
$lang_db_prefix[2] = "Bei der Verwendung mehrerer Statistiken, muss für jede eingesetzte Statistik diese Benennung zwingend unterschiedlich vergeben werden.";
$lang_db_prefix[3] = "ACHTUNG";
$lang_db_prefix[4] = "Es wurde festgestellt, dass die benötigten Datenbank-Tabellen noch nicht existieren.<br>Klicken Sie auf \"Tabellen erstellen\" um diese jetzt anzulegen.";
$lang_db_prefix[5] = "Tabellen erstellen";
//------------------------------------------------------------------------------

// create db_tables
//------------------------------------------------------------------------------
$lang_db_tables[1] = "Logfile Transfer";
$lang_db_tables[2] = "Abbrechen";
$lang_db_tables[3] = "Weiter";
$lang_db_tables[4] = "Überspringen";
$lang_db_tables[5] = "Fertigstellen";
$lang_db_tables[6] = "Fenster schließen";
$lang_db_tables_1[1] = "Sie sind im Begriff die benötigten Datenbank-Tabellen zu erzeugen. Falls bereits Logdaten vorhanden sind, können diese im Anschluss automatisch in die Datenbank importiert werden.";
$lang_db_tables_1[2] = "Stellen Sie sicher, dass Sie den Datenbank Zugang korrekt eingerichtet haben und klicken Sie dann auf \"Weiter\".";
$lang_db_tables_2[1] = "Datenbank-Tabellen werden angelegt, bitte warten...";
$lang_db_tables_2[2] = "Datenbank-Tabellen wurden angelegt!";
$lang_db_tables_2[3] = "Tabelle";
$lang_db_tables_3[1] = "Eine Überprüfung hat ergeben, dass keine Logdaten für einen Import vorhanden sind.";
$lang_db_tables_3[2] = "Eine Überprüfung hat ergeben, dass Logdaten vorhanden sind die Sie jetzt importieren können.";
$lang_db_tables_3[3] = "Im folgenden Schritt werden zunächst die Pattern-Dateien zur Datenbank übertragen.";
$lang_db_tables_3[4] = "Klicken Sie auf überspringen wenn Sie keine Daten importieren möchten.";
$lang_db_tables_4[1] = "Die Pattern-Dateien werden übertragen, bitte warten...";
$lang_db_tables_4[2] = "Die Pattern-Dateien wurden erfolgreich übertragen!";
$lang_db_tables_4[3] = "Im nächsten Schritt werden die Logeinträge in die Datenbank geschrieben.";
$lang_db_tables_4[4] = "Wählen Sie dazu die zu schreibenden Zeilen pro Durchlauf aus.<br>(Empfehlung 4000)";
$lang_db_tables_5[1] = "Übertrage Daten in die Datenbank-Tabellen, bitte warten...";
$lang_db_tables_5[2] = "Einträge geschrieben";
$lang_db_tables_5[3] = "Gesamt Anzahl";
$lang_db_tables_6[1] = "Die Datenbank-Tabellen werden optimiert, bitte warten...";
$lang_db_tables_6[2] = "Dieser Vorgang kann je nach Logdaten einige Sekunden dauern. Bitte haben Sie Geduld!";
$lang_db_tables_7[1] = "Der Datentransfer ist abgeschlossen.";
$lang_db_tables_7[2] = "Die Datenbank wurde erfolgreich vorbereitet!";
//------------------------------------------------------------------------------

// setup footer
//------------------------------------------------------------------------------
$lang_footer[1] = "Weiter";
$lang_footer[2] = "Aktualisieren";
$lang_footer[3] = "Zurück";
$lang_footer[4] = "Abbrechen";
$lang_footer[5] = "Fertigstellen";
//------------------------------------------------------------------------------
?>