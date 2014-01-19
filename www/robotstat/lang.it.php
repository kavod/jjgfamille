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
 * Traduzione Italiana di Marco Di Silvio - ( http://www.submission.it )
 *
 ***************************************************************************/

$RS_LANG = array();

$RS_LANG["YES"]         = "Si";
$RS_LANG["NO"]          = "No";
$RS_LANG["Delete"]      = "Cancella";
$RS_LANG["Modify"]      = "Modifica";
$RS_LANG["On"]          = "di";
$RS_LANG["Of"]          = "di";
$RS_LANG["CloseWindow"] = "Chiudi Finestra";
$RS_LANG["BackHome"]    = "Torna in homepage";
$RS_LANG["OK"]          = "OK";

// ---------------------------------------------------------------------------
// error handling
// ---------------------------------------------------------------------------
$RS_LANG["MySQLErrorSubject"] = "Errore di RobotStats";
$RS_LANG["MySQLErrorBody1"]   = "Problemi con MySql; la richiesta seguente ha avuto esito negativo:\n";
$RS_LANG["MySQLErrorBody2"]   = "";

// ---------------------------------------------------------------------------
// alertes par mail
// ---------------------------------------------------------------------------
$RS_LANG["FullCrawlBeginSubject"] = "RobotStats: è iniziato il Deep Crawl di Google!";
$t  = "Ciao,\n";
$t .= "Questo è un messaggio automatico spedito da RobotStats,\n";
$t .= "il programma di monitoraggio degli accessi installato sul tuo sito.\n";
$t .= "il Deep Crawl di Google potrebbe essere iniziato: uno spider di Google,\n";
$t .= "il cui IP inizia per 216, ha appena visitato il tuo sito.\n\n";
$t .= "Per ulteriori informazioni, puoi far riferimento al forum di WebRankInfo\n"; 
$t .= "http://www.webrankinfo.com/forums/\n";
$RS_LANG["FullCrawlBeginBody"]    = $t;

// ---------------------------------------------------------------------------
// calendar
// ---------------------------------------------------------------------------
$RS_LANG["Error"]        = "Errore";
$RS_LANG["Visites"]      = "Visite";
$RS_LANG["Pages"]        = "Pagine";
$RS_LANG["VisitsPerDay"] = "Visite / Giorno";
$RS_LANG["URL"]          = "URL";
$RS_LANG["Hour"]         = "Ora";
$RS_LANG["NbOfVisits"]   = "Num. Visite";
$RS_LANG["NoData"]       = "Nessun dato";
$RS_LANG["Summary"]      = "Riassunto";
$RS_LANG["Pages"]        = "Pagine";
$RS_LANG["Graph"]        = "Grafico";
$RS_LANG["Monday1"]      = "L";
$RS_LANG["Tuesday1"]     = "M";
$RS_LANG["Wednesday1"]   = "M";
$RS_LANG["Thursday1"]    = "G";
$RS_LANG["Friday1"]      = "V";
$RS_LANG["Saturday1"]    = "S";
$RS_LANG["Sunday1"]      = "D";
$RS_LANG["PreviousDay"]  = "Giorno Precedente";
$RS_LANG["PreviousMonth"]= "Mese Precedente";
$RS_LANG["NextDay"]      = "Giorno Successivo";
$RS_LANG["NextMonth"]    = "Mese Successivo";
$RS_LANG["Week"]         = "Settimana";

// ---------------------------------------------------------------------------
// table
// ---------------------------------------------------------------------------
$RS_LANG["Code"]         = "Codice HTTP";

// ---------------------------------------------------------------------------
// graph
// ---------------------------------------------------------------------------
$RS_LANG["GraphAlt"]     = "Grafico delle visite di ";
$RS_LANG["Graph1"]       = "Scegli il grafico da mostrare:";
$RS_LANG["Month_1"]      = "1 mese";
$RS_LANG["Month_2"]      = "2 mesi";
$RS_LANG["Month_3"]      = "3 mesi";
$RS_LANG["Month_6"]      = "6 mesi";
$RS_LANG["Month_12"]     = "1 anno";
$RS_LANG["InactiveCalendar"] = "Il calendario è disabilitato";

// ---------------------------------------------------------------------------
// robots
// ---------------------------------------------------------------------------
$RS_LANG["RobotsAvailable"]  = " robot(s) supportati:";
$RS_LANG["NoRobotDefined"]   = "Nessuno spider impostato!!!";
$RS_LANG["SelectedRobot"]    = "Spider Selezionato";
$RS_LANG["RobotDescription"] = "Descrizione dello Spider";
$RS_LANG["UndefinedRobot"]   = "Spider non definito!";
$RS_LANG["RobotName"]        = "Nome";
$RS_LANG["RobotActive"]      = "Attivo?";
$RS_LANG["ActiveRobots"]     = "Spider attivi";
$RS_LANG["NonActiveRobots"]  = "Spider non attivi";
$RS_LANG["RobotUserAgent"]   = "User Agent";
$RS_LANG["RobotIP1"]         = "Indirizzo IP #1";
$RS_LANG["RobotIP2"]         = "Indirizzo IP #2";
$RS_LANG["RobotMode"]        = "Modalità di riconoscimento";
$RS_LANG["RobotDesc"]        = "Descrizione";
$RS_LANG[$RS_DETECTION_USER_AGENT] = "Attraverso lo User Agent";
$RS_LANG[$RS_DETECTION_IP]         = "Attraverso l'indirizzo IP";
$RS_LANG["RobotURL"]         = "URL";
$RS_LANG["RobotURLInfo"]     = "Homepage ufficiale dello Spider";
$RS_LANG["ListeRobotsVenus"] = "Lista degli Spider in questo periodo:";

// ---------------------------------------------------------------------------
// Index page
// ---------------------------------------------------------------------------
$RS_LANG["TitleIndex"]       = "Visite degli Spider e statistiche";
$RS_LANG["IPAddresses"]      = "Indirizzi IP";
$RS_LANG["RobotsPie"]        = "Grafico a torta degli Spider";

// ---------------------------------------------------------------------------
// footer
// ---------------------------------------------------------------------------
$RS_LANG["RS_Line1"]      = ": analisi in tempo reale degli spider che visitano il tuo sito web";
$RS_LANG["RS_Line2"]      = "Applicazione freeware ed Open Source, realizzata da";
$RS_LANG["RS_desc"]       = "Specialista nell'ottimizzazione per Google";
$RS_LANG["Info"]          = "Per maggiori informazioni, vai su";

// ---------------------------------------------------------------------------
// installation
// ---------------------------------------------------------------------------
$RS_LANG["Install OK"] = "Il processo di installazione è completato. Non dimenticare di cancellare il file 'install.php' dal tuo server. Clicca <A HREF='index.php'>qui</A> per tornare in homepage.";
$RS_LANG["UpdateOK"]   = "Il processo di aggiornamento è temrinato.";

// ---------------------------------------------------------------------------
// admin
// ---------------------------------------------------------------------------
$RS_LANG["Admin"]            = "Amministrazione";
$RS_LANG["TitleAdmin"]       = "Area Amministrativa";
$RS_LANG["AdminTestVersion"] = "Ricerca Aggiornamenti";
$RS_LANG["AdminNothing"]     = "Benvenuto nell'Area Amministrativa. Clicca su una delle voci per proseguire.";
$RS_LANG["AdminReset"]       = "Cancella (eliminazione dei dati)";
$RS_LANG["AdminResetExplanations"] = "Questo strumento ti consente di cancellare alcuni dati (le visite degli spider) immagazzinati nel database MySql. Puoi cancellare un solo mese o tutti i dati archiviati.";
$RS_LANG["ResetMonths"]      = "Cancella un mese";
$RS_LANG["ResetAll"]         = "Elimina tutti i dati";
$RS_LANG["ResetAllLink"]     = "Clicca qui (Attenzione, questa operazione non è reversibile)";
$RS_LANG["ResetNoData"]      = "Nessun dato!";
$RS_LANG["ResetMonthsOK"]    = "I dati di questo mese sono stati cancellati.";
$RS_LANG["ResetMonthsNOK"]   = "Parametri errati: non posso cancellare questo mese";
$RS_LANG["ResetAllOK"]       = "Tutti i dati sono stati eliminati.";
$RS_LANG["AdminVersionTitle"] = "Controlla aggiornamenti di RobotStats";
$RS_LANG["AdminVersionLink"]  = "Clicca qui per controllare.";
$RS_LANG["AdminRobots"]      = "Gestione degli Spider";
$RS_LANG["ModifyRobot"]      = "Modifica uno spider";
$RS_LANG["AddRobot"]         = "Aggiungi uno spider";
$RS_LANG["RobotDeleted"]     = "Lo Spider è stato cancellato.";
$RS_LANG["BackToRobotsAdmin"]= "Torna alla Gestione degli Spider.";
$RS_LANG["RobotAdded"]       = "Spider aggiunto!";
$RS_LANG["RobotUpdated"]     = "Spider aggiornato!";
$RS_LANG["RobotDeleted"]     = "Spider cancellato!";
$RS_LANG["BadRobotName"]     = "Nome non valido!";
$RS_LANG["BadUserAgent"]     = "User Agent non valido!";
$RS_LANG["IPNotSpecified"]   = "Nessun indirizzo IP è stato assegnato per questo Spider!";
$RS_LANG["BadDetectionMode"] = "Modalità di riconoscimento errata!";


// ---------------------------------------------------------------------------
// other
// ---------------------------------------------------------------------------
$TAB_MONTHS = array( '','Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre' );
$TAB_JOURS = array('Domenica', 'Lunedì', 'Martedì', 'Mercoledì', 'Giovedì', 'Venerdì', 'Sabato');
?>
