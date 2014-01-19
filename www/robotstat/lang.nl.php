<?php

/***************************************************************************
 *
 *   RobotStats
 *
 * Author:   Olivier Duffez, WebRankInfo ( http://www.webrankinfo.com )
 * Version:  1.0
 * Date:     2003-10-11
 * Homepage: http://www.robotstats.com
 *
 * Dutch language file translated by SMokeY - ( http://www.smokingmedia.com )
 *
 ***************************************************************************/

$RS_LANG = array();

$RS_LANG["YES"]         = "Ja";
$RS_LANG["NO"]          = "Nee";
$RS_LANG["Delete"]      = "Wissen";
$RS_LANG["Modify"]      = "Wijzig";
$RS_LANG["On"]          = "aan";
$RS_LANG["Of"]          = "uit";
$RS_LANG["CloseWindow"] = "Sluit Venster";
$RS_LANG["BackHome"]    = "Terug naar homepage";
$RS_LANG["OK"]          = "OK";

// ---------------------------------------------------------------------------
// error handling
// ---------------------------------------------------------------------------
$RS_LANG["MySQLErrorSubject"] = "Fout met RobotStats";
$RS_LANG["MySQLErrorBody1"]   = "De volgende MySQL query is mislukt:\n";
$RS_LANG["MySQLErrorBody2"]   = "";

// ---------------------------------------------------------------------------
// alertes par mail
// ---------------------------------------------------------------------------
$RS_LANG["FullCrawlBeginSubject"] = "RobotStats: De 'Full crawl' is begonnen!";
$t  = "Hallo,\n";
$t .= "Dit is een bericht verzonden door RobotStats, de tool geïnstalleerd op je site.\n";
$t .= "De Full Crawl is begonnen: een bot GoogleBot met IP adres dat begint \n";
$t .= "met 216. heeft net je site bezocht.\n\n";
$t .= "Voor meer informatie, bezoek het forum van WebRankInfo:\n";
$t .= "http://www.webrankinfo.com/forums/\n";
$RS_LANG["FullCrawlBeginBody"]    = $t;

// ---------------------------------------------------------------------------
// calendar
// ---------------------------------------------------------------------------
$RS_LANG["Error"]        = "Fout";
$RS_LANG["Visites"]      = "Bezoeken";
$RS_LANG["Pages"]        = "Pagina's";
$RS_LANG["VisitsPerDay"] = "Bezoeken / Dag";
$RS_LANG["URL"]          = "URL";
$RS_LANG["Hour"]         = "Uur";
$RS_LANG["NbOfVisits"]   = "#Bezoeken";
$RS_LANG["NoData"]       = "Geen gegevens";
$RS_LANG["Summary"]      = "Samenvatting";
$RS_LANG["Pages"]        = "Pagina's";
$RS_LANG["Graph"]        = "Grafiek";
$RS_LANG["Monday1"]      = "M";
$RS_LANG["Tuesday1"]     = "D";
$RS_LANG["Wednesday1"]   = "W";
$RS_LANG["Thursday1"]    = "D";
$RS_LANG["Friday1"]      = "V";
$RS_LANG["Saturday1"]    = "Z";
$RS_LANG["Sunday1"]      = "Z";
$RS_LANG["PreviousDay"]  = "Vorige Dag";
$RS_LANG["PreviousMonth"]= "Vorige Maand";
$RS_LANG["NextDay"]      = "Volgende Dag";
$RS_LANG["NextMonth"]    = "Volgende Maand";
$RS_LANG["Week"]         = "Week";

// ---------------------------------------------------------------------------
// graph
// ---------------------------------------------------------------------------
$RS_LANG["GraphAlt"]     = "Grafiek van de bezoeken van ";
$RS_LANG["Graph1"]       = "Kies een grafiek om weer te geven:";
$RS_LANG["Month_1"]      = "1 maand";
$RS_LANG["Month_3"]      = "3 maanden";
$RS_LANG["Month_6"]      = "6 maanden";
$RS_LANG["Month_12"]     = "1 jaar";
$RS_LANG["InactiveCalendar"] = "Kalender niet actief";

// ---------------------------------------------------------------------------
// robots
// ---------------------------------------------------------------------------
$RS_LANG["RobotsAvailable"]  = " bekende robot(s):";
$RS_LANG["NoRobotDefined"]   = "Geen robot gedefiniëerd!!!";
$RS_LANG["SelectedRobot"]    = "Geselecteerde Robot";
$RS_LANG["RobotDescription"] = "Robot's Omschrijving";
$RS_LANG["UndefinedRobot"]   = "Ongedefiniëerde Robot!";
$RS_LANG["RobotName"]        = "Naam";
$RS_LANG["RobotActive"]      = "Actief?";
$RS_LANG["ActiveRobots"]     = "Geactiveerde Robots";
$RS_LANG["NonActiveRobots"]  = "Gedeactieveerde Robots";
$RS_LANG["RobotUserAgent"]   = "User Agent";
$RS_LANG["RobotIP1"]         = "IP Adres #1";
$RS_LANG["RobotIP2"]         = "IP Adres #2";
$RS_LANG["RobotMode"]        = "Detectie Wijze";
$RS_LANG["RobotDesc"]        = "Omschrijving";
$RS_LANG[$DETECTION_USER_AGENT] = "Door de User Agent";
$RS_LANG[$DETECTION_IP]         = "Door het IP adres";
$RS_LANG["RobotURL"]         = "URL";
$RS_LANG["RobotURLInfo"]     = "Officiële homepage van deze robot";
$RS_LANG["ListeRobotsVenus"] = "Lijst van robots die in deze periode kwamen:";

// ---------------------------------------------------------------------------
// Index page
// ---------------------------------------------------------------------------
$RS_LANG["TitleIndex"]         = "RobotStats: Google's bezoeken geanaliseerd";
$RS_LANG["IPAddresses"]        = "IP adressen";

// ---------------------------------------------------------------------------
// footer
// ---------------------------------------------------------------------------
$RS_LANG["GS_Line1"]      = ": real time analyse van Google's bezoeken aan jouw website";
$RS_LANG["GS_Line2"]      = "Gratis, Open Source Applicatie, ontwikkeld door";
$RS_LANG["GS_desc"]       = "Google Zoek Machine Optimalisatie Specialist";
$RS_LANG["Info"]          = "Voor meer informatie, surf naar";

// ---------------------------------------------------------------------------
// installation
// ---------------------------------------------------------------------------
$RS_LANG["Install OK"] = "Het installatie proces is voltooid. Vergeet niet om het bestand 'install.php' van uw server te verwijderen. Klik <A HREF='index.php'>hier</A> om terug te keren naar de homepage.";
$RS_LANG["UpdateOK"]   = "Het Bijwerken is voltooid.";

// ---------------------------------------------------------------------------
// admin
// ---------------------------------------------------------------------------
$RS_LANG["Admin"]            = "Beheer";
$RS_LANG["TitleAdmin"]       = "Beheer afdeling";
$RS_LANG["AdminTestVersion"] = "Bekijk Laatste Versie";
$RS_LANG["AdminNothing"]     = "Je bent in de beheer afdeling. Klik op een item.";
$RS_LANG["AdminReset"]       = "Reset (verwijderen van records)";
$RS_LANG["AdminResetExplanations"] = "Dit gereedschap geeft je de mogelijkheid om records, opgeslagen in de MySQL database te verwijderen (bezoeken van de GoogleBot). Je kan één maand, of alle data wissen.";
$RS_LANG["ResetMonths"]      = "Reset één maand";
$RS_LANG["ResetAll"]         = "Reset alles";
$RS_LANG["ResetAllLink"]     = "Klik hier (Pas op, deze handeling kan niet worden onderbroken)";
$RS_LANG["ResetNoData"]      = "Geen gegevens!";
$RS_LANG["ResetMonthsOK"]    = "De gegevens van deze maand zijn ge-reset.";
$RS_LANG["ResetMonthsNOK"]   = "Verkeerde parameters: kan deze maand niet resetten.";
$RS_LANG["ResetAllOK"]       = "Alle gegevens zijn ge-reset.";
$RS_LANG["AdminVersionTitle"] = "Bekijk of je de laatste versie van RobotStats hebt";
$RS_LANG["AdminVersionLink"]  = "Klik hier om te checken.";
$RS_LANG["AdminRobots"]      = "Robots Beheer";
$RS_LANG["ModifyRobot"]      = "Wijzig een robot";
$RS_LANG["AddRobot"]         = "Voeg een nieuwe robot toe";
$RS_LANG["RobotDeleted"]     = "De robot is verwijderd.";
$RS_LANG["BackToRobotsAdmin"]= "Terug naar Robots Beheer.";
$RS_LANG["RobotAdded"]       = "Robot toegevoegd!";
$RS_LANG["RobotUpdated"]     = "Robot bijgewerkt!";
$RS_LANG["RobotDeleted"]     = "Robot gewist!";
$RS_LANG["BadRobotName"]     = "Verkeerde robot name!";
$RS_LANG["BadUserAgent"]     = "Verkeerde user agent!";
$RS_LANG["IPNotSpecified"]   = "Er is geen IP adres voor deze robot gedefiniëerd!";
$RS_LANG["BadDetectionMode"] = "Verkeerde detectie methode!";


// ---------------------------------------------------------------------------
// other
// ---------------------------------------------------------------------------
$TAB_MONTHS = array( '','januari', 'februari', 'maart', 'april', 'mei', 'juni', 'juli',
            'augustus', 'september', 'oktober', 'november', 'december' );
$TAB_JOURS = array("zondag", "maandag", "dinsdag", "woensdag", "donderdag", "vrijdag", "zaterdag");
?>