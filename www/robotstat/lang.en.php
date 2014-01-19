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
 ***************************************************************************/

$RS_LANG = array();

$RS_LANG["YES"]         = "Yes";
$RS_LANG["NO"]          = "No";
$RS_LANG["Delete"]      = "Delete";
$RS_LANG["Modify"]      = "Modify";
$RS_LANG["On"]          = "on";
$RS_LANG["Of"]          = "of";
$RS_LANG["CloseWindow"] = "Close Window";
$RS_LANG["BackHome"]    = "Back to homepage";
$RS_LANG["OK"]          = "OK";

// ---------------------------------------------------------------------------
// error handling
// ---------------------------------------------------------------------------
$RS_LANG["MySQLErrorSubject"] = "Error with RobotStats";
$RS_LANG["MySQLErrorBody1"]   = "The following MySQL request has failed:\n";
$RS_LANG["MySQLErrorBody2"]   = "";

// ---------------------------------------------------------------------------
// alertes par mail
// ---------------------------------------------------------------------------
$RS_LANG["FullCrawlBeginSubject"] = "RobotStats: the Google Full Crawl has begun!";
$t  = "Hi,\n";
$t .= "This is an alert sent by RobotStats, the tool installed on your site.\n";
$t .= "The Google Full Crawl may have begun: a GoogleBot robot whose IP address begins \n";
$t .= "with 216. has just visited your site.\n\n";
$t .= "For more information, please go to the forum of WebRankInfo at:\n";
$t .= "http://www.webrankinfo.com/forums/\n";
$RS_LANG["FullCrawlBeginBody"]    = $t;

// ---------------------------------------------------------------------------
// calendar
// ---------------------------------------------------------------------------
$RS_LANG["Error"]        = "Error";
$RS_LANG["Visites"]      = "Visits";
$RS_LANG["Pages"]        = "Pages";
$RS_LANG["VisitsPerDay"] = "Visits / Day";
$RS_LANG["URL"]          = "URL";
$RS_LANG["Hour"]         = "Hour";
$RS_LANG["NbOfVisits"]   = "#Visits";
$RS_LANG["NoData"]       = "No data";
$RS_LANG["Summary"]      = "Summary";
$RS_LANG["Pages"]        = "Pages";
$RS_LANG["Graph"]        = "Graph";
$RS_LANG["Monday1"]      = "M";
$RS_LANG["Tuesday1"]     = "T";
$RS_LANG["Wednesday1"]   = "W";
$RS_LANG["Thursday1"]    = "T";
$RS_LANG["Friday1"]      = "F";
$RS_LANG["Saturday1"]    = "S";
$RS_LANG["Sunday1"]      = "S";
$RS_LANG["PreviousDay"]  = "Previous Day";
$RS_LANG["PreviousMonth"]= "Previous Month";
$RS_LANG["NextDay"]      = "Next Day";
$RS_LANG["NextMonth"]    = "Next Month";
$RS_LANG["Week"]         = "Week";

// ---------------------------------------------------------------------------
// table
// ---------------------------------------------------------------------------
$RS_LANG["Code"]         = "HTTP Code";

// ---------------------------------------------------------------------------
// graph
// ---------------------------------------------------------------------------
$RS_LANG["GraphAlt"]     = "Graph of the visits of ";
$RS_LANG["Graph1"]       = "Choose the graph to display:";
$RS_LANG["Month_1"]      = "1 month";
$RS_LANG["Month_2"]      = "2 months";
$RS_LANG["Month_3"]      = "3 months";
$RS_LANG["Month_6"]      = "6 months";
$RS_LANG["Month_12"]     = "1 year";
$RS_LANG["InactiveCalendar"] = "Calendar is disabled";

// ---------------------------------------------------------------------------
// robots
// ---------------------------------------------------------------------------
$RS_LANG["RobotsAvailable"]  = " known robot(s):";
$RS_LANG["NoRobotDefined"]   = "No robot defined!!!";
$RS_LANG["SelectedRobot"]    = "Selected Robot";
$RS_LANG["RobotDescription"] = "Robot Description";
$RS_LANG["UndefinedRobot"]   = "Undefined Robot!";
$RS_LANG["RobotName"]        = "Name";
$RS_LANG["RobotActive"]      = "Enabled?";
$RS_LANG["ActiveRobots"]     = "Enabled Robots";
$RS_LANG["NonActiveRobots"]  = "Disabled Robots";
$RS_LANG["RobotUserAgent"]   = "User Agent";
$RS_LANG["RobotIP1"]         = "IP Address #1";
$RS_LANG["RobotIP2"]         = "IP Address #2";
$RS_LANG["RobotMode"]        = "Detection Mode";
$RS_LANG["RobotDesc"]        = "Description";
$RS_LANG[$RS_DETECTION_USER_AGENT] = "By the User Agent";
$RS_LANG[$RS_DETECTION_IP]         = "By the IP address";
$RS_LANG["RobotURL"]         = "URL";
$RS_LANG["RobotURLInfo"]     = "Official robot homepage";
$RS_LANG["ListeRobotsVenus"] = "List of robots that came in this period:";

// ---------------------------------------------------------------------------
// Index page
// ---------------------------------------------------------------------------
$RS_LANG["TitleIndex"]       = "SE Robots visits tracking and statistics";
$RS_LANG["IPAddresses"]      = "IP addresses";
$RS_LANG["RobotsPie"]        = "Robots Pie Chart";

// ---------------------------------------------------------------------------
// footer
// ---------------------------------------------------------------------------
$RS_LANG["RS_Line1"]      = ": real time analysis of robots visits on your website";
$RS_LANG["RS_Line2"]      = "Free and Open Source Application, developped by";
$RS_LANG["RS_desc"]       = "Google Search Engine Optimization Specialist";
$RS_LANG["Info"]          = "For further information, go to";

// ---------------------------------------------------------------------------
// installation
// ---------------------------------------------------------------------------
$RS_LANG["Install OK"] = "The install process is completed. Do not forget to delete the 'install.php' file from your server. Click <A HREF='index.php'>here</A> to come back to the homepage.";
$RS_LANG["UpdateOK"]   = "The Update Process is finished.";

// ---------------------------------------------------------------------------
// admin
// ---------------------------------------------------------------------------
$RS_LANG["Admin"]            = "Administration";
$RS_LANG["TitleAdmin"]       = "Administration Area";
$RS_LANG["AdminTestVersion"] = "Check Latest Version";
$RS_LANG["AdminNothing"]     = "You are in the Administration Area. Click on one item.";
$RS_LANG["AdminReset"]       = "Reset (deletion of records)";
$RS_LANG["AdminResetExplanations"] = "This tool allows you to delete some of the records stored on the MySQL database (robots visits). You can delete one month or the whole data.";
$RS_LANG["ResetMonths"]      = "Reset one month";
$RS_LANG["ResetAll"]         = "Reset all";
$RS_LANG["ResetAllLink"]     = "Click here (be carefull, this operation cannot be cancelled)";
$RS_LANG["ResetNoData"]      = "No data!";
$RS_LANG["ResetMonthsOK"]    = "The data of this mon have been reseted.";
$RS_LANG["ResetMonthsNOK"]   = "Wrong parameters: cannot reset this month";
$RS_LANG["ResetAllOK"]       = "All the data have been reseted.";
$RS_LANG["AdminVersionTitle"] = "Check if you have the latest version of RobotStats";
$RS_LANG["AdminVersionLink"]  = "Click here to check.";
$RS_LANG["AdminRobots"]      = "Robots Management";
$RS_LANG["ModifyRobot"]      = "Modify a robot";
$RS_LANG["AddRobot"]         = "Add a new robot";
$RS_LANG["RobotDeleted"]     = "The robot has been deleted.";
$RS_LANG["BackToRobotsAdmin"]= "Back to the Robots Management.";
$RS_LANG["RobotAdded"]       = "Robot added!";
$RS_LANG["RobotUpdated"]     = "Robot updated!";
$RS_LANG["RobotDeleted"]     = "Robot deleted!";
$RS_LANG["BadRobotName"]     = "Bad robot name!";
$RS_LANG["BadUserAgent"]     = "Bad user agent!";
$RS_LANG["IPNotSpecified"]   = "No IP address has been defined for the robot!";
$RS_LANG["BadDetectionMode"] = "Bad detection mode!";


// ---------------------------------------------------------------------------
// other
// ---------------------------------------------------------------------------
$TAB_MONTHS = array( '','January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
$TAB_JOURS = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
?>
