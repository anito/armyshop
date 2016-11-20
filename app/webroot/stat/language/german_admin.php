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
$lang_login[1] = "Der Zugriff auf diese Seite erfordert die Eingabe eines Passwortes.";
$lang_login[2] = "Bitte geben Sie das Admin-Passwort ein!";
$lang_login[3] = "Passwort:";
$lang_login[4] = "Login";
$lang_login[5] = "Abbrechen";
//--------------------
// top menue
$lang_admin_tm[1] = "Zurück zur Statistik";
$lang_admin_tm[2] = "Admin Center Index";
$lang_admin_tm[3] = "Sysinfo";
$lang_admin_tm[4] = "Syscheck";
$lang_admin_tm[5] = "Online Anleitung";
$lang_admin_tm[6] = "Support Forum";
$lang_admin_tm[7] = "Abmelden";
//--------------------
// left menue
$lang_admin_lm[1] = "Allgemeine Konfiguration";
$lang_admin_lm[2] = "Zusätzliche Konfiguration";
$lang_admin_lm[3] = "Wartungsfunktionen";
$lang_admin_lm[4] = "Zusätzliche Funktionen";
//------------------------------------------------------------------------------

// index
//------------------------------------------------------------------------------
$lang_admin_i[1] = "Willkommen im Admin-Center Ihrer PHP Web Stat";
$lang_admin_i[2] = "Das Admin-Center der PHP Web Stat bietet Ihnen die Möglichkeit, Ihre Statistik zu konfigurieren, Einstellungen zu ändern oder Wartungsfunktionen auszuführen.";
$lang_admin_i[3] = "Bevor Sie im Supportforum um Hilfe bitten, stellen Sie sicher, dass Sie alle hier kleingeschriebenen Hinweistexte beachtet haben!";
$lang_admin_i[4] = "Vielen Dank, dass Sie sich für die PHP Web Stat entschieden haben!";
//-------------------- welcome
$lang_admin_i_vi[1]  = "Versions-Information";
$lang_admin_i_vi[2]  = "Ihre Version:";
$lang_admin_i_vi[3]  = "Remote Server nicht verfügbar";
$lang_admin_i_vi[4]  = "Neueste stabile Version:";
$lang_admin_i_vi[5]  = "Neueste BETA Version:";
$lang_admin_i_vi[6]  = "Eine neue, stabile Version ist verfügbar!";
$lang_admin_i_vi[7]  = "Wenn Sie die Version";
$lang_admin_i_vi[8]  = "herunterladen wollen, besuchen Sie bitte unsere Webseite.";
$lang_admin_i_vi[9]  = "Sie verwenden die neueste stabile Version!";
$lang_admin_i_vi[10] = "Für den Versionscheck muss Javascript eingeschaltet sein!";
//-------------------- stat logins
$lang_admin_i_l[1] = "Letzte Stat Logins";
$lang_admin_i_l[2] = "Admin";
$lang_admin_i_l[3] = "Benutzer";
$lang_admin_i_l[4] = "Heute";
$lang_admin_i_l[5] = "um";
$lang_admin_i_l[6] = "Logfile leeren";
$lang_admin_i_l[7] = "Logfile wurde geleert";
//-------------------- information
$lang_admin_i_i[1]   = "Informationen & Neuigkeiten";
//-------------------- thanks
$lang_admin_i_thx[1] = "Danksagung";
$lang_admin_i_thx[2] = "Wir bedanken uns recht herzlich für die tatkräftige Unterstützung bei:";
$lang_admin_i_thx[3] = "";
//------------------------------------------------------------------------------

// general settings
//------------------------------------------------------------------------------
$lang_admin_gs[1]  = "Grundeinstellungen";
$lang_admin_gs[2]  = "Aufzeichnung erfolgt in";
$lang_admin_gs[3]  = "Die Statistik zeichnet in den von Ihnen ausgewählten Modus auf.";
$lang_admin_gs[4]  = "Text-Dateien";
$lang_admin_gs[5]  = "Datenbank";
$lang_admin_gs[6]  = "Wie lautet Ihre Domain?";
$lang_admin_gs[7]  = "Hier muss der Domain-Name inklusive \"http://www.\" eingetragen werden, unter der die Statistik betrieben wird, also z.B. <b>http://www.mydomain.com</b><br>Es darf <b>kein \"/\" oder Verzeichnis</b> hinter der Domain notiert werden.";
$lang_admin_gs[8]  = "Startseite Ihrer Domain";
$lang_admin_gs[9]  = "Tragen Sie hier die Startseite der Domain ein, für die eine Aufzeichnung erfolgen soll, also z.B. <b>index.html</b> oder <b>index.php</b>";
$lang_admin_gs[10] = "Statistik Verzeichnis";
$lang_admin_gs[11] = "Hier muss der Ordner angegeben werden, in der die Statistik innerhalb Ihrer Domain betrieben wird, also z.B. <b>stat/</b>. Bitte achten Sie darauf, dass das letzte Zeichen ein \"/\" ist.";
$lang_admin_gs[12] = "Welche Domain(s) sollen aufgezeichnet werden?";
$lang_admin_gs[13] = "Hier müssen alle Domainnamen eingetragen werden, die von der Statistik erfasst werden sollen. Bitte achten Sie darauf, dass jeder Eintrag ohne \"www.\" einzutragen ist. Sollte Ihre Domain also z.B. http://www.mydomain.com sein, so tragen sie hier nur <b>mydomain.com</b> ein. <br><u>Geben Sie pro Zeile nur eine Domain an.</u> <br>Verwenden Sie eine Subdomain z.B. http://name.yourdomain.com so ist hier darauf zu achten, dass nur die Domain angegeben wird, also z.B. <b>yourdomain.com</b>.";
$lang_admin_gs[14] = "Aufzeichnung erfolgt für";
$lang_admin_gs[15] = "Kann eine Domain als auch einen Namen enthalten.";
$lang_admin_gs[16] = "Sprach-Datei";
$lang_admin_gs[17] = "Wählen Sie hier die für Sie passende Sprachdatei aus.";
$lang_admin_gs[18] = "Länder-Datei";
$lang_admin_gs[19] = "Wählen Sie hier die für Sie passende Länder-Erkennungsdatei aus.";
$lang_admin_gs[20] = "Dynamische URLs";
$lang_admin_gs[21] = "Wenn Seiten innerhalb Ihrer Domain dynamische Parameter beinhalten, also z.B. index.php?category=1, dann tragen Sie hier die <u>aufzuzeichnenden</u> Parameter ein. <br><u>Geben Sie pro Zeile nur einen Wert an.</u> In diesem Beispiel hier müsste also category eingetragen werden. Diese Einstellung verhindert, dass dynamische URLs zu oft in Ihren Logfiles auftauchen, weil benutzerspezifische Parameter wie PHPSESSID für jeden Seitenbesuch dazugefügt werden.";
//------------------------------------------------------------------------------

// advanced settings
//------------------------------------------------------------------------------
$lang_admin_as[1] = "Erweiterte Einstellungen";
$lang_admin_as[2] = "Allgemein";
$lang_admin_as[3] = "Sicherheit";
$lang_admin_as[4] = "Anzeige";
//-------------------- general
$lang_admin_as_g[1]  = "IP-Adressen ausschliessen";
$lang_admin_as_g[2]  = "Hier können Sie alle IP-Adressen eintragen, die von der Aufzeichnung der Statistik ausgeschlossen werden sollen. <br>Wenn Sie ganze IP Blöcke ausschließen möchten, so tragen Sie dieses wie folgt ein: <br>123.456.789.* <br>123.456.*.* <br><u>Geben Sie pro Zeile nur einen Wert an.</u>";
$lang_admin_as_g[3]  = "Serverzeit";
$lang_admin_as_g[4]  = "Wenn die hier angezeigte Zeit von der Zeit Ihres Heimatortes abweicht, so benutzen Sie bitte den Auswahldialog um die Differenz korrekt einzustellen.";
$lang_admin_as_g[5]  = "Stunde";
$lang_admin_as_g[6]  = "Stunden";
$lang_admin_as_g[7]  = "Betreiben Sie Ihre Seite in Frames?";
$lang_admin_as_g[8]  = "Nach wieviel Minuten soll ein Besucher neu gezählt werden?";
$lang_admin_as_g[9]  = "Soll automatisch auf Updates geprüft werden?";
$lang_admin_as_g[10] = "Aktivieren Sie diese Funktion wenn Sie innerhalb Ihrer Statistik auf wichtige oder größere Updates aufmerksam gemacht werden möchten.";
$lang_admin_as_g[11] = "Startdatum der Statistik festlegen";
$lang_admin_as_g[12] = "Hier können Sie das Startdatum der Statistik und des Counters manuell festlegen z.B. <b>15.08.2006</b>.<br>Wenn Sie dieses Feld frei lassen, wird automatisch der erste Logfile-Eintrag benutzt.";
$lang_admin_as_g[13] = "Gesamtbesucherzahl der Statistik erhöhen";
$lang_admin_as_g[14] = "Tragen Sie hier eine Zahl ein, die der Gesamtzahl der Statistik hinzugezählt werden soll.<br><b>Eine Auswertung für diese Zahl ist nicht möglich.</b>";
$lang_admin_as_g[15] = "Creator Lesezeilen";
$lang_admin_as_g[16] = "Benutzen Sie folgende Empfehlungen:<br><br>Standard = 5000<br>Strato = 2500<br>Hosteurope = 5000 - 10000";
$lang_admin_as_g[17] = "Ausgabe von Fehlermeldungen";
$lang_admin_as_g[18] = "Diese Funktion ermöglicht es, Fehlermeldungen bei Problemen ausgeben lassen zu können.";
$lang_admin_as_g[19] = "Aufzeichnung von Google Images Herkünften";
$lang_admin_as_g[20] = "Besucher, die über die Google Bilder-Suche auf Ihre Seite gelangen, werden bei Aktivierung aufgezeichnet.";
$lang_admin_as_g[21] = "Aufzeichnung von Google AdWords Herkünften";
$lang_admin_as_g[22] = "Besucher, die über geschaltete Google AdWords Werbung auf Ihre Seite gelangen, werden bei Aktivierung aufgezeichnet.";
$lang_admin_as_g[23] = "PHP-Variable der IP-Adresse des Benutzers";
$lang_admin_as_g[24] = "Hier muss die PHP-Variable ausgewählt werden, die der Server zur Ermittlung der IP-Adresse verwendet.";
$lang_admin_as_g[25] = "IP-Adresse anonymisieren?";
$lang_admin_as_g[26] = "Wenn die IP-Adresse eines Besuchers anonymisiert werden soll, so kann dies hier ausgewählt werden. Neben einer kompletten Anonymisierung kann auch eine Teilanonymisierung erfolgen.";
$lang_admin_as_g[27] = "IP-Adresse nicht anonymisieren";
$lang_admin_as_g[28] = "IP-Adresse teilweise anonymisieren";
$lang_admin_as_g[29] = "IP-Adresse vollständig anonymisieren";
$lang_admin_as_g[30] = "Index Creator Lesezeilen";
$lang_admin_as_g[31] = "Benutzen Sie folgende Empfehlungen gemessen am Besucheraufkommen:<br><br>normal = 30.000<br>mittel = 50.000<br>hoch = 100.000";
$lang_admin_as_g[32] = "Automatische Cache Aktualisierung";
$lang_admin_as_g[33] = "Legen Sie fest, nach wieviel Minuten der Statistik-Cache automatisch aktualisiert werden soll.";
$lang_admin_as_g[34] = "Keine Aktualisierung";
$lang_admin_as_g[35] = "Cache Optimierung (Herkunftsseiten reduzieren)";
$lang_admin_as_g[36] = "Diese Optimierung hat Einfluss auf die Cache- Dateigröße und greift erst bei einem Aufkommen von min. 5.000 Einträgen.<br><br>\"0\" = Keine Anpassung<br>\"1\" = Entfernen von Herkunftsseiten die nur einmalig vorkamen<br>\"2\" = Entfernen von Herkunftsseiten die nur 2 mal vorgekommen sind.";
$lang_admin_as_g[37] = "Herkunftsseite blockieren";
$lang_admin_as_g[38] = "Hier können Sie alle Herkunftsseiten (Teilstrings) eintragen, die von der Aufzeichnung der Statistik ausgeschlossen werden sollen.<br>Benutzen Sie folgende Vorlage:<br>some-spammer<br>other-spammer<br><u>Geben Sie pro Zeile nur einen Wert an.</u>";
$lang_admin_as_g[39] = "Bots (Suchmaschinen) blockieren";
$lang_admin_as_g[40] = "Hier können Sie alle Bots (Teilstrings des Useragents) eintragen, die von der Aufzeichnung der Statistik ausgeschlossen werden sollen.<br>Benutzen Sie folgende Vorlage:<br>bingbot<br>googlebot<br><u>Geben Sie pro Zeile nur einen Wert an.</u>";
//-------------------- security
$lang_admin_as_s[1]  = "Admin Passwort";
$lang_admin_as_s[2]  = "Tragen Sie hier ein von Ihnen gewünschtes Passwort ein.";
$lang_admin_as_s[3]  = "Benutzer Passwort";
$lang_admin_as_s[4]  = "Tragen Sie hier ein Benutzer Passwort ein.<br>Die Vergabe eines Benutzer Passwortes ermöglicht lediglich den Aufruf einer geschützten Statistik, ohne weitere Rechte.";
$lang_admin_as_s[5]  = "Passwortabfrage beim Statistik Aufruf?";
$lang_admin_as_s[6]  = "Passwortabfrage beim Cookie setzen?";
$lang_admin_as_s[7]  = "Schutzsystem des Logordners aktivieren?";
$lang_admin_as_s[8]  = "Automatisches Logout aktivieren?";
$lang_admin_as_s[9]  = "Wählen Sie, nach wieviel Minuten das Automatische Logout erfolgen soll.";
$lang_admin_as_s[10] = "Sie haben längere Zeit keine Aktionen durchgeführt. <br>Zu Ihrer eigenen Sicherheit wurde die Sitzung beendet.<br><br>Bitte melden Sie sich erneut an.";
//-------------------- display
$lang_admin_as_d[1]  = "Farbschema";
$lang_admin_as_d[2]  = "Wählen Sie hier das für Sie passende Theme aus.";
$lang_admin_as_d[3]  = "Detaillierte Browser-Versionen anzeigen?";
$lang_admin_as_d[30] = "Wählen Sie <b>A</b> wenn die Versionsnummer auf <b>eine Nachkommastelle</b> beschränkt werden soll, z.B. Browser <b>3.2</b>.<br>Wählen Sie <b>B</b> wenn die <b>komplette Versionsnummer</b> angezeigt werden soll, z.B. Browser <b>3.2.145</b>.";
$lang_admin_as_d[31] = "Nein";
$lang_admin_as_d[32] = "Ja (Option A)";
$lang_admin_as_d[33] = "Ja (Option B)";
$lang_admin_as_d[4]  = "Detaillierte Referer-Informationen anzeigen?";
$lang_admin_as_d[5]  = "Länderflaggen anzeigen?";
$lang_admin_as_d[6]  = "Browser Icons anzeigen?";
$lang_admin_as_d[7]  = "OS Icons anzeigen?";
$lang_admin_as_d[8]  = "Einstellung der Prozentangaben und Grafikbalken";
$lang_admin_as_d[9]  = "Wählen Sie <b>1</b> wenn sich die prozentualen Angaben auf die <b>Gesamtsumme der Einträge des jeweiligen Moduls</b> beziehen sollen.<br>Wählen Sie <b>2</b> wenn sich die prozentualen Angaben auf die <b>Summe der angezeigten Einträge des jeweiligen Moduls</b> beziehen sollen.";
$lang_admin_as_d[10] = "Erweiterte Prozentbalken Einstellung";
$lang_admin_as_d[11] = "Wählen Sie <b>1</b> wenn die Prozentgrafiken den Prozentangaben <b>gleichgestellt</b> werden sollen.<br>Wählen Sie <b>2</b> wenn sich die Prozentgrafiken auf den <b>größten Wert</b> der Einträge beziehen sollen.";
$lang_admin_as_d[12] = "Standardanzeige (Einträge) unter Letzte Zugriffe";
$lang_admin_as_d[13] = "Wählen Sie einen Standardwert aus, wieviele Einträge unter Letzte Zugriffe angezeigt werden sollen.";
$lang_admin_as_d[14] = "Whois Abfrage der IP-Adresse unter Letzte Zugriffe mit?";
$lang_admin_as_d[15] = "Wählen Sie einen Anbieter aus, mit dem bei Klick auf eine IP-Adresse unter Letzte Zugriffe diese lokalisiert werden soll.";
$lang_admin_as_d[16] = "Detaillierte OS-Versionen anzeigen?";
$lang_admin_as_d[17] = "Letzte Zugriffe";
$lang_admin_as_d[18] = "Floatbox- Fenstergröße";
$lang_admin_as_d[19] = "Spaltenbreite \"Besuchte Seite\"";
$lang_admin_as_d[20] = "Durch die Angabe dieser Breite wird automatisch der noch verbleibende Platz der Spalte \"Herkunfts-Seite\" zu Verfügung gestellt.";
$lang_admin_as_d[21] = "Abschneiden des Seitennamens";
$lang_admin_as_d[22] = "Legen Sie fest, nach wie vielen Zeichen der Seitenname abgeschnitten werden soll. Das Abschneiden verhindert unerwünschte Zeilenumbrüche. Ist ein Name länger als Ihre Angabe, so wird dieser mit \"...\" versehen.";
$lang_admin_as_d[23] = "Abschneiden der Herkünfte";
$lang_admin_as_d[24] = "Legen Sie fest, nach wie vielen Zeichen die Herkunfts-Seite abgeschnitten werden soll. Ist auch hier ein Name oder Link länger als Ihre Angabe, so wird dieser ebenfalls mit \"...\" versehen. Die Funktionalität eines Links wird durch das Abschneiden nicht beeinträchtigt.";
$lang_admin_as_d[25] = "Einsicht der letzten Zugriffe für Besucher?";
$lang_admin_as_d[26] = "Sollten Sie eine Passwortabfrage beim Statistikaufruf eingestellt haben, steht ihnen diese Funktion nicht zur Verfügung.";
$lang_admin_as_d[27] = "Anzeigen der IP für einen Client";
$lang_admin_as_d[28] = "Setzen Sie den Haken wenn ein Client die IP unter Letzte Zugriffe sehen darf.";
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
//------------------- settings
$lang_db_prefix[1] = "Bitte geben Sie einen Namen (Prefix) für die Datenbank-Tabellen an, z.B. <b>stat</b>.";
$lang_db_prefix[2] = "Bei der Verwendung mehrerer Statistiken, muss für jede eingesetzte Statistik diese Benennung zwingend unterschiedlich vergeben werden.";
$lang_db_prefix[3] = "ACHTUNG";
$lang_db_prefix[4] = "Es wurde festgestellt, dass die benötigten Datenbank-Tabellen noch nicht existieren.<br>Klicken Sie auf \"Tabellen erstellen\" um diese jetzt anzulegen.";
$lang_db_prefix[5] = "Tabellen erstellen";
//------------------------------------------------------------------------------

// module settings
//------------------------------------------------------------------------------
$lang_admin_ms[1]  = "Modul Einstellungen";
$lang_admin_ms[2]  = "Eigenschaften";
$lang_admin_ms[3]  = "Modul";
$lang_admin_ms[4]  = "An / Aus";
$lang_admin_ms[5]  = "Breite in Pixel";
$lang_admin_ms[6]  = "Zeilen";
$lang_admin_ms[7]  = "Besucher";
$lang_admin_ms[8]  = "Besucher nach Stunden";
$lang_admin_ms[9]  = "Besucher diesen Monat";
$lang_admin_ms[10] = "Besucher nach Wochentagen";
$lang_admin_ms[11] = "Besucher nach Monaten";
$lang_admin_ms[12] = "Besucher nach Jahren";
$lang_admin_ms[13] = "Verwendete Browser";
$lang_admin_ms[14] = "Verwendete Betriebssysteme";
$lang_admin_ms[15] = "Verwendete Auflösungen";
$lang_admin_ms[16] = "Verwendete Farbtiefen";
$lang_admin_ms[17] = "Seitenbesuche";
$lang_admin_ms[18] = "Seitenherkünfte";
$lang_admin_ms[19] = "Eintrittsseiten";
$lang_admin_ms[20] = "Verwendete Suchmaschinen";
$lang_admin_ms[21] = "Verwendete Suchbegriffe";
$lang_admin_ms[22] = "Herkunftsländer";
$lang_admin_ms[23] = "JavaScript Status";
//------------------------------------------------------------------------------

// pattern editor
//------------------------------------------------------------------------------
$lang_admin_pe[1] = "Seiten Benennung";
$lang_admin_pe[2] = "Namen";
$lang_admin_pe[3] = "Hier können Sie Ihren Dateien neue Bezeichnungen geben, um in der Statistik eine für Sie noch bessere Übersicht zu erreichen.";
$lang_admin_pe[4] = "Beispiel: &nbsp; index.php|Startseite";
//------------------------------------------------------------------------------

// pattern string replace
//------------------------------------------------------------------------------
$lang_admin_re[1] = "Teilstrings ersetzen";
$lang_admin_re[2] = "Bestandteil";
$lang_admin_re[3] = "Hier können Sie aufgerufene Teile Ihrer URL durch beliebige Werte automatisch ersetzen lassen";
$lang_admin_re[4] = "Beispiel: &nbsp; shop-einkaufs-wagen|warenkorb";
//------------------------------------------------------------------------------

// counter settings
//------------------------------------------------------------------------------
$lang_admin_cs[1] = "Counter Einstellungen";
$lang_admin_cs[2] = "Anzeige";
$lang_admin_cs[3] = "Counterzeile";
$lang_admin_cs[4] = "An / Aus";
//-------------------- display
$lang_admin_cs_d[1]  = "Online";
$lang_admin_cs_d[2]  = "Heute";
$lang_admin_cs_d[3]  = "Gestern";
$lang_admin_cs_d[4]  = "diesen Monat";
$lang_admin_cs_d[5]  = "letzten Monat";
$lang_admin_cs_d[6]  = "Maximum";
$lang_admin_cs_d[7]  = "&#216;/Tag";
$lang_admin_cs_d[8]  = "Gesamt";
$lang_admin_cs_d[9]  = "Fusszeile mit Startdatum der Statistik";
$lang_admin_cs_d[10] = "Ticker";
$lang_admin_cs_d[11] = "Durch Aktivierung dieser Option steht Ihnen ein Ticker im Footerbereich des Counters zur Verfügung. Dieser kann mehrere verschiedene Anzeigen visualisieren. Bitte wählen Sie dazu die nachfolgenden Optionen aus.";
$lang_admin_cs_d[12] = "Aufzeichnung seit";
$lang_admin_cs_d[13] = "Letzte Daten-Aktualisierung";
$lang_admin_cs_d[14] = "Seitenimpressionen Gesamt";
$lang_admin_cs_d[15] = "Trend des aktuellen Monats";
//-------------------- settings
$lang_admin_cs_s[1] = "Eigenschaften";
$lang_admin_cs_s[2] = "Besucher Online-Zeit";
$lang_admin_cs_s[3] = "Wie lange in Minuten soll ein Besucher als online im Counter gezählt werden?";
$lang_admin_cs_s[4] = "Gesamtbesucherzahl des Counters erhöhen";
$lang_admin_cs_s[5] = "Tragen Sie hier die Zahl eines alten Counters ein, die dem neuen hinzugezählt werden soll.";
//------------------------------------------------------------------------------

// maintenance mode
//------------------------------------------------------------------------------
$lang_admin_mm[1] = "Wartungs-Modus";
$lang_admin_mm[2] = "Der Wartungs-Modus bietet Ihnen die Möglichkeit Ihre Statistik anzuhalten. In dieser Einstellung werden keine neuen Logs geschrieben.<br>Diese Funktion kann von Vorteil sein wenn Sie z.B. händisch in den Logdateien eingreifen müssen aber in dieser Zeit von neuen Einträgen verschont bleiben möchten.";
$lang_admin_mm[3] = "Status";
$lang_admin_mm[4] = "Aktueller Status";
$lang_admin_mm[5] = "Sollten Sie den Wartungs-Modus aktiviert haben, so werden Sie in der Statistk zusätzlich durch einen Hinweis darauf aufmerksam gemacht.";
$lang_admin_mm[6] = "Statistik aktiv";
$lang_admin_mm[7] = "Status speichern";
//------------------------------------------------------------------------------

// create cache
//------------------------------------------------------------------------------
$lang_admin_dc[1] = "Cache neu erstellen";
$lang_admin_dc[2] = "Ein separates Fenster wurde geöffnet. Sollte sich das Fenster nicht geöffnet haben, klicken Sie";
$lang_admin_dc[3] = "hier";
//-------------------- panel
$lang_admin_cc[1]  = "Sie sind im Begriff den Cache der Statistik und des Counters neu zu erstellen";
$lang_admin_cc[2]  = "Dieser Vorgang kann mehrere Minuten dauern und während der Aktualisierung darf das Fenster nicht geschlossen werden.";
$lang_admin_cc[3]  = "Klicken Sie nun auf Weiter um den Cache neu zu erstellen";
$lang_admin_cc[4]  = "Weiter";
$lang_admin_cc[5]  = "Abbrechen";
$lang_admin_cc[6]  = "Cache wird erstellt, bitte warten...";
$lang_admin_cc[7]  = "Das Schreiben des Cache kann je nach Logfilegröße <u>einige Minuten</u> dauern.";
$lang_admin_cc[8]  = "Diesen Vorgang bitte nicht unterbrechen!";
$lang_admin_cc[9]  = "Der Cache wurde erfolgreich neu erstellt.";
$lang_admin_cc[10] = "";
$lang_admin_cc[11] = "Fertig stellen";
//------------------------------------------------------------------------------

// create index
//------------------------------------------------------------------------------
$lang_admin_ci[1] = "Index neu erstellen";
$lang_admin_ci[2] = "Der Index der Statistik dient der Erfassung der Speicheradressen der aufgezeichneten Besuchertage. Eine vollständige Erstellung beschleunigt die Arbeit der Statistik erheblich. Sollten also einmal Probleme bei der Geschwindigkeit oder dem Arbeiten der Statistik auftreten, so ist der Index neu zu erstellen.";
$lang_admin_ci[3] = "Hinweis";
$lang_admin_ci[4] = "Mit Klick auf den Button \"Index neu erstellen\" wird der Index neu erstellt. Dies kann je nach Statistik und/oder Logfile-Größe unter Umständen einige Minuten dauern.";
$lang_admin_ci[5] = "Index neu erstellen";
$lang_admin_ci[6] = "Der Index wird in wenigen Sekunden neu erstellt.<br><br>Bitte halten Sie das Fenster solange geöffnet, bis die Anzeige links oben unter dem Logo auf 100% steht.";
//------------------------------------------------------------------------------

// logfile repair
//------------------------------------------------------------------------------
$lang_admin_lr[1]  = "Logdatei Reparatur";
$lang_admin_lr[2]  = "Diese Routine bietet Ihnen die Möglichkeit Ihre Logdateien auf Fehler zu prüfen und diese ggf. zu beheben.";
$lang_admin_lr[3]  = "Prüfen und reparieren von Logdateien";
$lang_admin_lr[4]  = "ACHTUNG";
$lang_admin_lr[5]  = "Um diese Funktion nutzen zu können ist es erforderlich, dass sich Ihre Statistik im Wartungsmodus befindet!";
$lang_admin_lr[6]  = "Klicken Sie links im Menü auf Wartungs-Modus um diesen zunächst zu aktivieren.";
$lang_admin_lr[7]  = "Datei-Auswahl";
$lang_admin_lr[8]  = "Wählen Sie die Datei aus die Sie prüfen möchten.";
$lang_admin_lr[9]  = "Prüfen";
$lang_admin_lr[10] = "Prüfbericht";
$lang_admin_lr[11] = "Geprüfte Datei";
$lang_admin_lr[12] = "Fehler gesamt";
$lang_admin_lr[13] = "Überflüssige Leerzeilen";
$lang_admin_lr[14] = "Zeilen mit falscher Anzahl an Trennmarken";
$lang_admin_lr[15] = "Zeilen mit doppelten ID's";
$lang_admin_lr[16] = "Zeilen mit fehlerhaftem Timestamp";
$lang_admin_lr[17] = "Zeilen mit zu grossen Timestamps";
$lang_admin_lr[18] = "Es kann vorkommen, dass eine Reparatur nur teilweise durchgeführt werden kann. Sollten wiedererwartend Fehler auftauchen, so müssen diese händisch bereinigt werden.";
$lang_admin_lr[19] = "Reparieren";
$lang_admin_lr[20] = "Zurück zur Auswahl";
$lang_admin_lr[21] = "Erfolgreich ausgeführt!";
$lang_admin_lr[22] = "Die von Ihnen gewünschte Reparatur wurde erfolgreich durchgeführt.";
$lang_admin_lr[23] = "Datei nicht gefunden";
//------------------------------------------------------------------------------

// delete archive cache
//------------------------------------------------------------------------------
$lang_admin_dac[1] = "Archiv Cache löschen";
$lang_admin_dac[2] = "In der Statistik erstellte Archive können hier wieder gelöscht werden.";
$lang_admin_dac[3] = "Archive";
$lang_admin_dac[4] = "Treffen Sie die Auswahl, welches Archiv entfernt werden soll.";
$lang_admin_dac[5] = "Hier entfernte Archive können nur durch Neuerstellung in der Statistik-Ebene wieder hergestellt werden.";
$lang_admin_dac[6] = "Archiv löschen";
//------------------------------------------------------------------------------

// database editor
//------------------------------------------------------------------------------
$lang_admin_db_e[1] = "Datenbank Editor";
$lang_admin_db_e[2] = "Hier können SQL-Befehle an die Datenbank gesendet werden.";
$lang_admin_db_e[3] = "Diese Funktion ist ausschließlich für Supportzwecke eingerichtet worden. Wir weisen darauf hin, dass wir keinerlei Garantie für etwaige Schäden durch den User übernehmen.";
//------------------------------------------------------------------------------

// create backup
//------------------------------------------------------------------------------
$lang_admin_cb[1]  = "Statistik Backup";
$lang_admin_cb[2]  = "Bitte beachten Sie, das das Verzeichnis \"backup\" mit den Rechten (CHMOD) 777 versehen sein muss.";
$lang_admin_lfb[1] = "Log- & Cachedatei Backup erstellen";
$lang_admin_cfb[1] = "Cachefile Backup erstellen";
$lang_admin_lfb[2] = "Hier können Sie eine Sicherung Ihrer Logdateien vornehmen.";
$lang_admin_cfb[2] = "Hier können Sie eine Sicherung Ihrer Cachedateien vornehmen.";
$lang_admin_cb[3]  = "Wählen Sie zwischen einer komprimierten Version (ZIP-Datei) oder einer reinen Kopie in einen Ordner. Bitte beachten Sie, dass das Erstellen einer ZIP-Datei nicht zwingend auf allen Servern funktioniert.";
$lang_admin_cb[4]  = "Nach Klick auf den Button \"Backup erstellen\" wird, je nach Ihrer getroffenen Auswahl, eine ZIP-Datei in Form von \"backup_YYYY-MM-TT.zip\" oder ein Ordner in Form von \"backup_YYYY-MM-TT\" im Ordner \"backup\" Ihrer Statistik erstellt.";
$lang_admin_cb[5]  = "Backup erstellen";
$lang_admin_cb[6]  = "Backup wurde erstellt!";
//------------------------------------------------------------------------------

// delete backup
//------------------------------------------------------------------------------
$lang_admin_db[1] = "Backup löschen";
$lang_admin_db[2] = "Treffen Sie die Auswahl, welches Backup entfernt werden soll.";
$lang_admin_db[3] = "";
$lang_admin_db[4] = "Backup löschen";
$lang_admin_db[5] = "Backup wurde gelöscht!";
//------------------------------------------------------------------------------

// stat restart
//------------------------------------------------------------------------------
$lang_admin_sr[1]  = "Statistik Neustart";
$lang_admin_sr[2]  = "Sie möchten Ihre Statistik zurücksetzen? <br><br>Alle Log- und Cacheeinträge werden unwiderruflich gelöscht.";
$lang_admin_sr[3]  = "Führen Sie diesen Schritt nur dann aus, wenn Sie sich wicklich sicher sind.";
$lang_admin_sr[4]  = "Aus Sicherheitsgründen müssen Sie zunächst auf \"Weiter\" klicken um dann Ihre Statistik endgültig zurücksetzen zu können.";
$lang_admin_sr[5]  = "Weiter";
$lang_admin_sr[6]  = "ACHTUNG";
$lang_admin_sr[7]  = "Bei Klick auf den Button \"Ausführen\" wird Ihre Statistik neugestartet.";
$lang_admin_sr[8]  = "Ausführen";
$lang_admin_sr[9]  = "Ausgeführt";
$lang_admin_sr[10] = "Die Statistik wurde zurückgesetzt!";
//------------------------------------------------------------------------------

// CSS editor
//------------------------------------------------------------------------------
$lang_admin_ce[1] = "CSS Editor";
$lang_admin_ce[2] = "Statistik";
$lang_admin_ce[3] = "Counter";
$lang_admin_ce[4] = "Admin Center";
$lang_admin_ce[5] = "Druckansicht";
$lang_admin_ce[6] = "Bitte beachten Sie, das die zu ändernde CSS-Datei mit den Rechten (CHMOD) 666 versehen sein muss.";
$lang_admin_ce[7] = "Welche Statistik oder Counter CSS hier editiert werden kann, ist abhängig von der Einstellung des Farbschemas welches Sie unter den Grundeinstellungen ausgewählt haben.";
//------------------------------------------------------------------------------

// file version
//------------------------------------------------------------------------------
$lang_admin_fv[1] = "Datei Versionen";
$lang_admin_fv[2] = "Statistik Version";
$lang_admin_fv[3] = "Dateien im Hauptverzeichnis";
$lang_admin_fv[4] = "Datei Name";
$lang_admin_fv[5] = "Version";
$lang_admin_fv[6] = "Datum";
$lang_admin_fv[7] = "Dateien im Verzeichnis Config";
$lang_admin_fv[8] = "Dateien im Verzeichnis Language";
$lang_admin_fv[9] = "Dateien im Verzeichnis Func";
//------------------------------------------------------------------------------

// syscheck
//------------------------------------------------------------------------------
$lang_admin_sc[1]  = "Systemcheck";
$lang_admin_sc[2]  = "Hier können Sie die Konfiguration als auch die Funktionstüchtigkeit der Statistik überprüfen.";
$lang_admin_sc[3]  = "Durch die Prüfung (Aufzeichnung) werden Datensätze in Ihre Statistik geschrieben.";
$lang_admin_sc[4]  = "Ausgabe";
$lang_admin_sc[5]  = "phpinfo";
$lang_admin_sc[6]  = "Server Variablen";
$lang_admin_sc[7]  = "Session Variablen";
$lang_admin_sc[8]  = "";
$lang_admin_sc[9]  = "";
$lang_admin_sc[10] = "Prüfung";
$lang_admin_sc[11] = "IP Adresse";
$lang_admin_sc[12] = "Datenbank";
$lang_admin_sc[13] = "Dateirechte";
$lang_admin_sc[14] = "Konfiguration";
$lang_admin_sc[15] = "Aufzeichnung";
$lang_admin_sc[16] = "";
$lang_admin_sc[17] = "";
$lang_admin_sc[18] = "Wählen Sie einen der oben aufgeführten Menüpunkte aus, um weitere Informationen zu erhalten oder Prüfungen durchzuführen.";
$lang_admin_sc[19] = "Ergebnis";
$lang_admin_sc[20] = "Hostname";
$lang_admin_sc[21] = "Name der Datenbank";
$lang_admin_sc[22] = "Benutzername";
$lang_admin_sc[23] = "Passwort";
$lang_admin_sc[24] = "Prefix";
$lang_admin_sc[25] = "Es konnte keine Verbindung zur Datenbank hergestellt werden";
$lang_admin_sc[26] = "";
$lang_admin_sc[27] = "";
$lang_admin_sc[28] = "Betriebssystem des Servers";
$lang_admin_sc[29] = "Schreibprüfung der Datei";
$lang_admin_sc[30] = "erfolgreich";
$lang_admin_sc[31] = "nicht bestanden";
$lang_admin_sc[32] = "";
$lang_admin_sc[33] = "Ihre Angabe beginnt nicht mit \"http://\" oder \"https://\"";
$lang_admin_sc[34] = "Die Domainangabe ist abweichend von der Serverrückmeldung";
$lang_admin_sc[35] = "Anzahl \"/\" ist fehlerhaft";
$lang_admin_sc[36] = "fehlerhaft";
$lang_admin_sc[37] = "Fehlercode";
$lang_admin_sc[38] = "ist nicht erreichbar";
$lang_admin_sc[39] = "Fehler festgestellt!";
$lang_admin_sc[40] = "Auf einigen Servern wird nach der Ausführung eine vom Browser abhängig unterschiedliche Fehlersituation angezeigt. Diese hat keine Auswirkung auf die Testdatenerzeugung und kann ignoriert werden.";
$lang_admin_sc[41] = "Testuebergabe";
$lang_admin_sc[42] = "JavaScript ist aktiviert";
$lang_admin_sc[43] = "JavaScript ist deaktiviert";
$lang_admin_sc[44] = "Es sollten 3 Datensätze geschrieben worden sein.";
$lang_admin_sc[45] = "Es sollten 2 Datensätze geschrieben worden sein.";
$lang_admin_sc[46] = "Statistik auf Einträge überprüfen";
$lang_admin_sc[47] = "Ein Test konnte nicht durchgeführt werden, da Sie diese IP über die Einstellung \"IP-Adressen ausschliessen\" in der Statistik ausgeschlossen haben.";
$lang_admin_sc[48] = "Ein Test konnte nicht durchgeführt werden, da Sie die Einstellung \"Eigene Seiten-Besuche nicht zählen\" in der Statistik ausgewählt haben.";
$lang_admin_sc[49] = "Ein Test konnte nicht durchgeführt werden, da die aktuelle Domain nicht unter Aufzuzeichnende Domain(s) eingetragen ist.";
//------------------------------------------------------------------------------

// footer
//------------------------------------------------------------------------------
$lang_admin_f[1] = "Speichern";
//------------------------------------------------------------------------------
?>