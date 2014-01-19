<?php

/***************************************************************************
 *
 *   RobotStats
 *
 * Author:  Olivier Duffez, WebRankInfo ( http://www.webrankinfo.com/ )
 * Version:  1.0
 * Date:     2003-10-11
 * Übersetzt von Prof. Guido Kühn ( http://fh-zine.fhsh.de/ )
 * Datum:   2003-01-01
 ***************************************************************************/

$RS_LANG = array();

$RS_LANG["YES"]         = "Ja";
$RS_LANG["NO"]          = "Nein";
$RS_LANG["Delete"]      = "Löschen";
$RS_LANG["Modify"]      = "Ändern";
$RS_LANG["On"]          = "An";
$RS_LANG["Of"]          = "Aus";
$RS_LANG["CloseWindow"] = "Fenster schließen";
$RS_LANG["BackHome"]    = "zur  Homepage";
$RS_LANG["OK"]          = "OK";

// ---------------------------------------------------------------------------
// error handling
// ---------------------------------------------------------------------------
$RS_LANG["MySQLErrorSubject"] = "Error im RobotStats";
$RS_LANG["MySQLErrorBody1"]   = "Die folgende MySQL Abfrage war fehlerhaft:\n";
$RS_LANG["MySQLErrorBody2"]   = "";

// ---------------------------------------------------------------------------
// alertes par mail
// ---------------------------------------------------------------------------
$RS_LANG["FullCrawlBeginSubject"] = "RobotStats: der Crawler hat begonnen!";
$t  = "Hi,\n";
$t .= "This is an alert sent by RobotStats, the tool installed on your site.\n";
$t .= "The Full Crawl may have begun: a bot GoogleBot whose IP address begins \n";
$t .= "with 216. has just visited your site.\n\n";
$t .= "Für mehr Informationen, schaue ins Forum bei WebRankInfo:\n";
$t .= "http://www.webrankinfo.com/forums/\n";
$RS_LANG["FullCrawlBeginBody"]    = $t;

// ---------------------------------------------------------------------------
// calendar
// ---------------------------------------------------------------------------
$RS_LANG["Error"]        = "Fehler";
$RS_LANG["Visites"]      = "Besuche";
$RS_LANG["Pages"]        = "Seiten";
$RS_LANG["VisitsPerDay"] = "Zugriffe / Tag";
$RS_LANG["URL"]          = "URL";
$RS_LANG["Hour"]         = "Stunde";
$RS_LANG["NbOfVisits"]   = "Zugriffe";
$RS_LANG["NoData"]       = "Keine Daten";
$RS_LANG["Summary"]      = "Zusammenfassung";
$RS_LANG["Pages"]        = "Seiten";
$RS_LANG["Graph"]        = "Grafik";
$RS_LANG["Monday1"]      = "Mo";
$RS_LANG["Tuesday1"]     = "Di";
$RS_LANG["Wednesday1"]   = "Mi";
$RS_LANG["Thursday1"]    = "Do";
$RS_LANG["Friday1"]      = "Fr";
$RS_LANG["Saturday1"]    = "Sa";
$RS_LANG["Sunday1"]      = "So";
$RS_LANG["PreviousDay"]  = "Tag zuvor";
$RS_LANG["PreviousMonth"]= "Monat zuvor";
$RS_LANG["NextDay"]      = "Nächster Tag";
$RS_LANG["NextMonth"]    = "Nächster Monat";
$RS_LANG["Week"]         = "Woche";

// ---------------------------------------------------------------------------
// table
// ---------------------------------------------------------------------------
$RS_LANG["Code"]         = "HTTP code";

// ---------------------------------------------------------------------------
// graph
// ---------------------------------------------------------------------------
$RS_LANG["GraphAlt"]     = "Grafik der Besuche von ";
$RS_LANG["Graph1"]       = "Wählen Sie eine Grafik:";
$RS_LANG["Month_1"]      = "1 Monat";
$RS_LANG["Month_2"]      = "2 Monate";
$RS_LANG["Month_3"]      = "3 Monate";
$RS_LANG["Month_6"]      = "6 Monate";
$RS_LANG["Month_12"]     = "1 Jahr";
$RS_LANG["InactiveCalendar"] = "Inactive Calendar";

// ---------------------------------------------------------------------------
// robots
// ---------------------------------------------------------------------------
$RS_LANG["RobotsAvailable"]  = " bekannter Robot:";
$RS_LANG["NoRobotDefined"]   = "Kein Robot definiert!!!";
$RS_LANG["SelectedRobot"]    = "Robot auswählen";
$RS_LANG["RobotDescription"] = "Robot's Beschreibung";
$RS_LANG["UndefinedRobot"]   = "Undefinierter Robot!";
$RS_LANG["RobotName"]        = "Name";
$RS_LANG["RobotActive"]      = "Aktivieren?";
$RS_LANG["ActiveRobots"]     = "Aktiviere Robots";
$RS_LANG["NonActiveRobots"]  = "Deaktivieren Robots";
$RS_LANG["RobotUserAgent"]   = "User Agent";
$RS_LANG["RobotIP1"]         = "IP Address #1";
$RS_LANG["RobotIP2"]         = "IP Address #2";
$RS_LANG["RobotMode"]        = "Detektion Mode";
$RS_LANG["RobotDesc"]        = "Beschreibung";
$RS_LANG[$RS_DETECTION_USER_AGENT] = "Nach User Agent";
$RS_LANG[$RS_DETECTION_IP]         = "Nach IP Addressen";
$RS_LANG["RobotURL"]         = "URL";
$RS_LANG["RobotURLInfo"]     = "Offizielle Homepage des Robot";
$RS_LANG["ListeRobotsVenus"] = "Liste der Robots die in dieser Periode kamen";

// ---------------------------------------------------------------------------
// Index page
// ---------------------------------------------------------------------------
$RS_LANG["TitleIndex"]         = "RobotStats: Analyse der Googlezugriffe";
$RS_LANG["IPAddresses"]        = "IP Adressen";
$RS_LANG["RobotsPie"]          = "RobotercKreisdiagramm";

// ---------------------------------------------------------------------------
// footer
// ---------------------------------------------------------------------------
$RS_LANG["RS_Line1"]      = ": Echtzeitanalyse von Google Zugriffen auf Ihre Seite";
$RS_LANG["RS_Line2"]      = "Frei verfügbare Open Source Anwendung, entwickelt von";
$RS_LANG["RS_desc"]       = "Google Search Engine Optimization Specialist";
$RS_LANG["Info"]          = "Für weitere Informationen gehen Sie zu:";

// ---------------------------------------------------------------------------
// installation
// ---------------------------------------------------------------------------
$RS_LANG["Install OK"] = "Der Installationsvorgang ist abgeschlossen. Vergessen Sie nicht die Datei 'install.php' zu löschen. Bitte <A HREF='index.php'>hier</A>klicken Um zur Homepage zurück zu kommen.";
$RS_LANG["UpdateOK"]   = "Der Updateprozess ist beendet.";

// ---------------------------------------------------------------------------
// admin
// ---------------------------------------------------------------------------
$RS_LANG["Admin"]            = "Administration";
$RS_LANG["TitleAdmin"]       = "Administration Bereich";
$RS_LANG["AdminTestVersion"] = "Check letztet Version";
$RS_LANG["AdminNothing"]     = "Sie sind in der Administration. Klicken Sie eine Auswahl an.";
$RS_LANG["AdminReset"]       = "Reset (löschen der Einträge)";
$RS_LANG["AdminResetExplanations"] = "Dieses Tool erlaubt Ihnen, einige der Aufzeichnungen zu löschen, die in der MySQL Datenbank gespeichert sind, (Besuche von GoogleBot). Sie können einen Monat oder die ganzen Daten löschen.";
$RS_LANG["ResetMonths"]      = "Reset einen Monat";
$RS_LANG["ResetAll"]         = "Reset alle";
$RS_LANG["ResetAllLink"]     = "Klick hier ";
$RS_LANG["ResetNoData"]      = "Keine Daten!";
$RS_LANG["ResetMonthsOK"]    = "Die Daten dieses Monats sind Resettet.";
$RS_LANG["ResetMonthsNOK"]   = "Falscher Parameter: Reset des Monats nicht möglich";
$RS_LANG["ResetAllOK"]       = "Alle Daten sind Resettet";
$RS_LANG["AdminVersionTitle"] = "Check die letzte Version von RobotStats";
$RS_LANG["AdminVersionLink"]  = "Klick hier zu Check.";
$RS_LANG["AdminRobots"]      = "Robots Management";
$RS_LANG["ModifyRobot"]      = "Ändern Robot";
$RS_LANG["AddRobot"]         = "Neuen Robot hinzufügen";
$RS_LANG["RobotDeleted"]     = "Der Robots wurde gelöscht.";
$RS_LANG["BackToRobotsAdmin"]= "Zurück zum Robots Management.";
$RS_LANG["RobotAdded"]       = "Robot hinzugefügt!";
$RS_LANG["RobotUpdated"]     = "Robot geändert!";
$RS_LANG["RobotDeleted"]     = "Robot gelöscht!";
$RS_LANG["BadRobotName"]     = "Falscher Robot Name!";
$RS_LANG["BadUserAgent"]     = "Falscher User Agent!";
$RS_LANG["IPNotSpecified"]   = "Keine IP Addresse definiert für diesen Robot!";
$RS_LANG["BadDetectionMode"] = "Falscher Detektionmode!";


// ---------------------------------------------------------------------------
// other
// ---------------------------------------------------------------------------
$TAB_MONTHS = array( '','Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli',
            'August', 'September', 'Oktober', 'November', 'Dezember' );
$TAB_JOURS = array('Sonntag', 'Montag', 'Dienstag', 'Mitwoch', 'Donnerstag', 'Freitag', 'Samstag');
?>
