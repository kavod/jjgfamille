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

// ---------------------------------------------------------------------------
// procedure d'installation de RobotStats
// ---------------------------------------------------------------------------

// ---------------------------------------------------------------------------
// inclusions
// ---------------------------------------------------------------------------
include "admin/config.php";
include "lib.php";
include "lang.".$RS_LANGUE.".php";

// ---------------------------------------------------------------------------
// table log
// ---------------------------------------------------------------------------

// suppression eventuelle de la table log
$sql  = "DROP TABLE IF EXISTS ".$RS_TABLE_LOG.";";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

// creation de la table log
$sql  = "CREATE TABLE ".$RS_TABLE_LOG." (";
$sql .= "id int(10) unsigned NOT NULL auto_increment,";
$sql .= "url varchar(255) NOT NULL,";
$sql .= "date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,";
$sql .= "ip varchar(16) NOT NULL,";
$sql .= "dns varchar(120) NOT NULL,";
$sql .= "robot smallint(7) unsigned NOT NULL,";
$sql .= "code smallint(6) NOT NULL default '0',";
$sql .= "PRIMARY KEY (id),";
$sql .= "KEY id (id),";
$sql .= "KEY robot (robot)";
$sql .= ");";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

// ---------------------------------------------------------------------------
// table robots
// ---------------------------------------------------------------------------

// suppression eventuelle de la table robots
$sql  = "DROP TABLE IF EXISTS ".$RS_TABLE_ROBOTS.";";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

// creation de la table robots
$sql  = "CREATE TABLE ".$RS_TABLE_ROBOTS." (";
$sql .= "id smallint(7) unsigned NOT NULL auto_increment,";
$sql .= "actif smallint(1) unsigned NOT NULL DEFAULT 1,";
$sql .= "user_agent varchar(255) NOT NULL,";
$sql .= "ip1 varchar(16) NOT NULL,";
$sql .= "ip2 varchar(16) NOT NULL,";
$sql .= "nom varchar(255) NOT NULL,";
$sql .= "detection enum('".$RS_DETECTION_USER_AGENT."', '".$RS_DETECTION_IP."') NOT NULL DEFAULT '".$RS_DETECTION_USER_AGENT."',";
$sql .= "descr_fr text,";
$sql .= "descr_en text,";
$sql .= "url varchar(120) NOT NULL default '',";
$sql .= "PRIMARY KEY (id),";
$sql .= "KEY id (id)";
$sql .= ");";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (1, 1, 'Googlebot/2.1 (+http://www.googlebot.com/bot.html)', '216.239.46.', '64.68.8', 'GoogleBot', 'detection_ip', 'GoogleBot est le nom du robot d\'indexation de Google. Ce robot est programm� pour fonctionner sur des centaines de machines � la fois, avec des adresses IP diff�rentes.<br />\r\nN�anmoins il en existe deux sortes : le <b>Fresh Crawler</b>, dont l\'adresse IP commence par 64.68.82., correspond au robot qui indexe les nouvelles pages trouv�es par Google ; une fois visit�es par ce robot, les pages apparaissent dans Google seulement quelques jours. Le <b>Deep Crawler</b> (ou <b>Full Crawler</b>), dont l\'adresse IP commence par 216.239.46., correspond au robot qui effectue une indexation massive de tous les documents connus de Google, en g�n�ral pendant environ une semaine, juste apr�s la Google Dance.', 'GoogleBot is the name of the crawler of Google. This robot is programmed to run on hundreds of machines simultaneously with different IP addresses.<br />Nevertheless there are two types of GoogleBot robots: the <b>Fresh Crawler</b>, whose IP address begins with 64.68.82., is the robot indexing the fresh pages recently found by Google; once visited by this robot, the pages are in the Google\'s index only for a few days. The <b>Deep Crawler</b> (or <b>Full Crawler</b>), whose IP address begins with 216.239.46., is the robot massively indexing all the documents within the Google\'s index, during around one week, just after the Google Dance.', 'http://www.googlebot.com/bot.html');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (2, 0, 'test', '.', '.', 'test', 'detection_ip', 'Ceci n\'est pas un robot � proprement parler, il est utilis� pour tester si RobotStats est bien install� sur votre site.<br />Une fois que l\'installation est valid�e, pensez � d�sactiver ce robot.', 'This is not really a robot... it is used to test if RobotStats is correctly installed on your site.<br />Once you have tested it, disable it.', '');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (3, 1, 'Pompos', '212.27.33.', '', 'Pompos', 'detection_user_agent', 'Pompos est un outil puissant d\'analyse de documents � des fins d\'indexation et de classement du Web. Le but du robot Pompos est de collecter le plus de documents possible sur le web, et ce pour le moteur dir.com.<br />', 'Pompos est un outil puissant d\'analyse de documents � des fins d\'indexation et de classement du Web. Le but du robot Pompos est de collecter le plus de documents possible sur le web, et ce pour le moteur dir.com.<br />', 'http://dir.com/pompos.html');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (4, 1, 'FAST-WebCrawler', '66.77.73.', '', 'Fast', 'detection_ip', 'Le robot de Fast / AlTheWeb', 'Used for http://www.alltheweb.com and other search engines', '');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (5, 1, 'ia_archiver', '66.28.250.', '209.237.238.', 'Alexa', 'detection_user_agent', 'Le robot d\'Alexa.', 'Used for http://www.alexa.com and http://www.archive.org internet archive', 'http://pages.alexa.com/help/webmasters/index.html');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (6, 1, 'Mercator', '204.123.28.', '', 'Mercator (Altavista)', 'detection_user_agent', 'Robot d\'Altavista', 'Altavista search indexing spider', '');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (7, 1, 'Slurp', '216.35.116.', '', 'Slurp (Inktomi)', 'detection_ip', 'Robot utilis� par Inktomi', 'Spider for http://www.inktomi.com partner sites', '');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (8, 1, 'Openfind', '66.237.60.', '', 'Openfind', 'detection_ip', 'Openfind data gatherer, Openbot/3.0+(robot-response@openfind.com.tw)<br />Used for http://www.openfind.com.tw/ search engine (Taiwan)', 'Openfind data gatherer, Openbot/3.0+(robot-response@openfind.com.tw;)<br />Used for http://www.openfind.com.tw/ search engine (Taiwan)', 'http://www.openfind.com.tw/robot.html');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (9, 1, 'Scooter', '64.152.75.114', '209.73.162.54', 'Scooter (Altavista)', 'detection_user_agent', 'Robot d\'Altavista', 'http://www.altavista.com web crawler', '');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (10, 1, 'SlySearch/1.2', '64.140.48.30', '', 'SlySearch', 'detection_user_agent', 'Robot de recherche de plagiat (www.plagiarism.com)', 'Robot searching for plagiarism (www.plagiarism.org)', 'http://www.plagiarism.org/crawler/robotinfo.html');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (11, 1, 'ASPseek/1.2.10', '198.169.127.', '', 'ASP seek', 'detection_user_agent', '', '', '');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (12, 1, 'http://www.almaden.ibm.com/cs/crawler', '66.147.154.3', '', 'Almaden', 'detection_user_agent', 'Almaden est le laboratoire de recherche d\'IBM...', '', 'http://www.almaden.ibm.com/cs/crawler');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (13, 1, 'Mozilla/2.0 (compatible; Ask Jeeves)', '65.214.36.150', '', 'Ask Jeeves', 'detection_user_agent', '', '', '');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (14, 1, 'Googlebot-Image/1.0 (+http://www.googlebot.com/bot.html)', '64.68.84.', '', 'Googlebot-Image', 'detection_user_agent', 'Robot d\'indexation des images de Google', 'Image Google crawler', 'http://www.googlebot.com/bot.html');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (15, 1, 'TurnitinBot', '64.140.48.', '', 'Turnitin', 'detection_user_agent', '', '', 'http://www.turnitin.com/robot/crawlerinfo.html');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (16, 1, 'Mozilla/4.0 (compatible; MSIE 5.0; Windows 95) VoilaBot; 1.6', '195.101.94.', '', 'VoilaBot', 'detection_user_agent', 'Le robot de Voila', 'Voila search engine robot', '');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (17, 1, 'Mozilla/4.0 compatible ZyBorg/1.0 (ZyBorg@WISEnutbot.com; http://www.WISEnutbot.com)', '209.249.66', '209.249.67', 'ZyBorg (WiseNut)', 'detection_user_agent', 'Robot de WiseNut', 'WiseNut\'s robot', 'http://www.wisenutbot.com/');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (18, 1, 'DeepIndex', '', '', 'DeepIndex', 'detection_user_agent', 'DeepIndex est le principal robot d\'indexation de DeepIndex le moteur de recherche. Ce robot fonctionne sur plusieurs machines et alimente la base de recherche principale du moteur en permanence. Il respecte les normes W3C en mati�re de robot d\'indexation et suit les indications du fichier robots.txt et/ou du meta-tag robots. Il est programm� pour ne pas saturer les serveurs.', 'DeepIndex is the name of the searchengine bot of DeepIndex european searchengine. The bot works on several computers to feed the DeepIndex main base. The bot does follow robots.txt and/or meta-tag robots and respects the W3C recommandations for indexing robots. The bot is programmed to be polite with your server.', 'http://www.webrankinfo.com/partenaires/deepindex/');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (19, 1, 'exabot', '', '', 'Exabot', 'detection_user_agent', 'Robot de Exalead.', 'Exalead\'s robot.', 'http://www.exalead.com/');";
$res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (20, 0, 'ZBot/1.00 (icaulfield@zeus.com)', '', '', 'Zeus', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (21, 0, 'xyro_(xcrawler@cosmos.inria.fr)', '', '', 'Inria', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (22, 1, 'Xenu Link Sleuth 1.1f', '', '', 'Xenu', 'detection_user_agent', 'Link Checker', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (23, 0, 'WWWOFFLE/2.x', '', '', 'WWWOffle', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (24, 0, 'WiseWire-Spider2', '', '', 'WiseWire-Spider', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (25, 1, 'WISEbot/1.0 (WISEbot@koreawisenut.com; http://wisebot.koreawisenut.com)', '', '', 'Wisenut - Korea', 'detection_user_agent', '', '', 'http://wisebot.koreawisenut.com');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (26, 0, 'Willow Internet Crawler by Twotrees V2.1', '', '', 'TwoTrees', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (27, 1, 'whatUseek_winona/3.0', '', '', 'What U Seek', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (28, 1, 'WebZIP/4.1 (http://www.spidersoft.com)', '', '', 'WebZip', 'detection_user_agent', '', '', 'http://www.spidersoft.com');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (29, 1, 'WebTrends/3.0 (WinNT)', '', '', 'WebTrends', 'detection_user_agent', 'Link Analyser', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (30, 0, 'WebStripper/2.0x', '', '', 'Web Stripper', 'detection_user_agent', 'Download Manager', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (31, 0, 'Webspinne/1.0 webmaster@webspinne.de', '', '', 'WebSpinne', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (32, 0, 'WebReaper vx.x - www.webreaper.net', '', '', 'WebReaper', 'detection_user_agent', 'Download Manager', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (33, 0, 'Web Image Collector', '', '', 'Web Image Collector', 'detection_user_agent', 'Datafire Web Image Collector', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (34, 0, 'WebCopier v2.7a', '', '', 'WebCopier', 'detection_user_agent', 'offline browser', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (35, 0, 'WebCompass 2.0', '', '', 'WebCompass', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (36, 0, 'webbandit/4.45.0', '', '', 'webbandit', 'detection_user_agent', 'Web Bandit personal search software\r\n', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (37, 0, 'WDG_Validator/1.1', '', '', 'WDG', 'detection_user_agent', 'WDG HTML-code validator\r\n', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (38, 1, 'W3C_Validator/1.122 libwww-perl/5.50', '', '', 'W3C', 'detection_user_agent', 'W3C HTML-Code Validator\r\n', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (39, 1, 'vspider/3.x', '', '', 'VSpider', 'detection_user_agent', 'Verity vspider indexing software\r\n', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (40, 0, 'UtilMind HTTPGet', '', '', 'WebThief', 'detection_user_agent', 'Web Thief Site Grabber', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (41, 0, 'URLGetFile', '', '', 'URLGetFile', 'detection_user_agent', 'URLGetFile downloading tool\r\n', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (42, 1, 'Ultraseek', '', '', 'Infoseek', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (43, 0, 'tricosMetaCheck 1.2216-08-1999 (http://www.tricos.com/metacheck)', '', '', 'Tricos', 'detection_user_agent', '', '', 'http://www.tricos.com/metacheck');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (44, 0, 'Trampelpfad-Spider-v0.1', '', '', 'Trampelpfad', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (45, 0, 'Toutatis 2.5-2', '', '', 'Hoppa', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (46, 0, 'TJG/Spider', '', '', 'TJGroup', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (47, 0, 'tivraSpider/1.0 (crawler@tivra.com)', '', '', 'Tivra', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (48, 1, 'teomaagent1 [crawler-admin@teoma.com]', '', '', 'Teoma', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (49, 0, 'Szukacz/1.4 (robot; www.szukacz.pl/jakdzialarobot.html; szukacz@proszynski.pl)', '', '', 'Szukacz', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (50, 0, 'SyncIT/2.x', '', '', 'SyncIT', 'detection_user_agent', 'Link Validation', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (51, 1, 'suzuran', '', '', 'Yokogao', 'detection_user_agent', 'Yokogao Search Engine robot (Kanazawa University)', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (52, 1, 'SurferF3 1/0', '', '', 'Wanadoo', 'detection_user_agent', 'Wanadoo Rechereche robot\r\n', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (53, 1, 'Spinne/2.0 med', '', '', 'Spider.de', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (54, 0, 'speedfind ramBot xtreme 8.1', '', '', 'Speedfind', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (55, 1, 'SlySearch (slysearch@slysearch.com)', '', '', 'SlySearch (slysearch@slysearch.com)', 'detection_user_agent', 'Slysearch', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (56, 1, 'Slider_Search_v1-de', '', '', 'Slider', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (57, 0, 'sitecheck.internetseer.com', '', '', 'Internetseer', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (58, 0, 'SearchExpress Spider0.99', '', '', 'Searchexpress', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (59, 0, 'search.ch V1.4', '', '', 'Search.ch', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (60, 0, 'Search+', '', '', 'URLSearch+', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (62, 0, 'PlantyNet_WebRobot_V1.9 dhkang@plantynet.com', '', '', 'PlantyNet', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (63, 0, 'PJspider/3.0 (pjspider@portaljuice.com; http://www.portaljuice.com)', '', '', 'PortalJuice', 'detection_user_agent', '', '', 'http://www.portaljuice.com');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (64, 0, 'PingALink Monitoring Services 1.0', '', '', 'PingALink', 'detection_user_agent', 'PingALink  website monitoring\r\n', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (65, 1, 'PicoSearch/1.0', '', '', 'Pico', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (66, 0, 'ParaSite/1.0b (http://www.ianett.com/parasite/)', '', '', 'IANett', 'detection_user_agent', '', '', 'http://www.ianett.com/parasite/');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (67, 1, 'Oracle Ultra Search', '', '', 'Oracle Search', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (68, 0, 'OpenTextSiteCrawler/2.9.2', '', '', 'OpenText', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (70, 1, 'nttdirectory_robot/0.9 (super-robot@super.navi.ocn.ne.jp)', '', '', 'NTT Dir', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (71, 1, 'Nokia-WAPToolkit/1.2 googlebot(at)googlebot.com', '', '', 'Google WAP', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (72, 0, 'Nocilla/1.0', '', '', 'Telefonica(es)', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (73, 0, 'Noago Spider', '', '', 'Noago', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (74, 0, 'NICO/1.0', '', '', 'NICO Zone', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (75, 0, 'NetZippy', '', '', 'NetZippy', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (76, 0, 'Netprospector JavaCrawler', '', '', 'Netprospector', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (77, 1, 'NetMechanic V3.0', '', '', 'NetMechanic', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (78, 0, 'NetAnts/1.2x', '', '', 'NetAnts', 'detection_user_agent', 'NetAnts/1.2x Downloadmanager', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (79, 1, 'NEC Research Agent -- compuman at research.nj.nec.com', '', '', 'NEC', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (80, 0, 'NationalDirectory-WebSpider/1.3', '', '', 'NationalDirectory', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (81, 0, 'NABOT/5.0', '', '', 'Korea Telekom', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (82, 0, 'MyGetRight/1.0.0', '', '', 'GetRight', 'detection_user_agent', 'Downloadmanager', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (83, 0, 'Mozilla/4.7 (compatible; http://eidetica.com/spider)', '', '', 'Eidetica', 'detection_user_agent', '', '', 'http://eidetica.com/spider');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (84, 0, 'Mozilla/4.0 (Sleek Spider/1.2)', '', '', 'ASI', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (85, 0, 'Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 4.0; QXW03018)', '', '', 'Wespe.de', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (86, 0, 'Mozilla/4.0 (compatible; MSIE 5.0; www.galaxy.com; www.psychedelix.com)', '', '', 'Galaxy', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (87, 0, 'Mozilla/4.0_(compatible;_MSIE_5.0;_Windows_95)_TrueRobot/1.4 libwww/5.2.8', '', '', 'Echo.com', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (88, 0, 'Mozilla/4.0 (compatible; FDSE robot)', '', '', 'Abador', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (89, 0, 'Mozilla/4.0 (compatible; Advanced Email Extractor v2.xx)', '', '', 'Advanced Email Extractor', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (90, 1, 'Mozilla/3.01 (Compatible; Links2Go Similarity Engine)', '', '', 'Links2GO', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (91, 0, 'Mozilla/3.0 (Vagabondo/1.0 MT; webagent@wise-guys.nl; http://webagent.wise-guys.nl/)', '', '', 'WiseGuys', 'detection_user_agent', '', '', 'http://webagent.wise-guys.nl/');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (92, 1, 'Mozilla/3.0 (Slurp.so/Goo; slurp@inktomi.com; http://www.inktomi.com/slurp.html)', '', '', 'GOO.jp', 'detection_user_agent', '', '', 'http://www.inktomi.com/slurp.html');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (93, 1, 'Mozilla/3.0 (compatible; Web Link Validator 2.1)', '', '', 'Web Link Validator', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (94, 0, 'Mozilla/3.0 (compatible; MuscatFerret/1.6.x; claude@euroferret.com)', '', '', 'Euroferret', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (95, 1, 'Mozilla/3.0 (compatible; Fluffy the spider; http://www.searchhippo.com/; info@searchhippo.com)', '', '', 'SearchHippo', 'detection_user_agent', '', '', 'http://www.searchhippo.com');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (96, 0, 'Mozilla/2.0 compatible; Check&Get 1.1x (Windows 98)', '', '', 'Check&Get', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (97, 0, 'Mozilla/2.0 (compatible; T-H-U-N-D-E-R-S-T-O-N-E)', '', '', 'Thunderstone', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (98, 0, 'Mozilla/2.0 (compatible; NEWT ActiveX; Win32)', '', '', 'WebCollector', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (99, 0, 'Mozilla/2.0 (compatible; EZResult -- Internet Search Engine)', '', '', 'DirectHit', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (100, 1, 'Mozilla (Mozilla@somewhere.com)', '', '', 'SomeWhere.com', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (102, 0, 'MediaSearch/0.1', '', '', 'WWW.fi', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (103, 1, 'Mata Hari/2.00', '', '', 'Lexibot', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (104, 0, 'Marvin v0.3', '', '', 'Marvin', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (105, 0, 'Mariner/5.1b [de] (Win95; I ;Kolibri gncwebbot)', '', '', 'Kolibri', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (106, 1, 'MantraAgent', '', '', 'LookSmart', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (107, 1, 'Lycos_Spider_(modspider)', '', '', 'LycosSpider (mod_spider)', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (108, 1, 'Lycos_Spider_(T-Rex)', '', '', 'Lycos Spider (T-Rex)', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (109, 0, 'lwp-trivial/1.34', '', '', 'Search4Free', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (110, 0, 'LinkWalker', '', '', 'SevenTwentyFour', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (111, 0, 'Link Valet Online 1.1', '', '', 'Link valet', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (112, 0, 'libwww-perl/5.41', '', '', 'CMP', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (113, 0, 'LEIA/3.01pr (LEIAcrawler; [SNIP])', '', '', 'GSeek', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (114, 0, 'larbin (samualt9@bigfoot.com)', '', '', 'BigFoot', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (115, 0, 'larbin_2.2.2 sugayama@lab7.kuis.kyoto-u.ac.jp', '', '', 'Kyoto Uni', 
'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (116, 0, 'KIT-Fireball/2.0', '', '', 'Fireball', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (117, 0, 'Kenjin Spider', '', '', 'Kenjin', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (119, 0, 'Internet Ninja 6.0', '', '', 'Dream Train', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (120, 0, 'IncyWincy(http://www.look.com)', '', '', 'Look.com', 'detection_user_agent', '', '', 'http://www.look.com');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (121, 0, 'IncyWincy page crawler(webmaster@loopimprovements.com,http://www.loopimprovements.com/robot.html)', '', '', 'IncyWincy', 'detection_user_agent', '', '', 'http://www.loopimprovements.com/robot.htm');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (122, 0, 'Hippias/0.9 Beta', '', '', 'Hippias', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (123, 0, 'Harvest-NG/1.0.2', '', '', 'Harvest-NG', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (124, 0, 'Gulper Web Bot 0.2.4 (www.ecsl.cs.sunysb.edu/~maxim/cgi-bin/Link/GulperBot)', '', '', 'Yuntis', 'detection_user_agent', '', '', 'www.ecsl.cs.sunysb.edu/~maxim/cgi-bin/Link/GulperBot');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (125, 1, 'Gulliver/1.3', '', '', 'Northernlight', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (126, 1, 'googlebot (larbin2.6.0@unspecified.mail)', '', '', 'PackerdBell', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (127, 0, 'Go!Zilla/4.0.0.26', '', '', 'GoZilla', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (128, 0, 'GNODSPIDER (www.gnod.net)', '', '', 'Gnod.net', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (129, 0, 'gigabaz/3.14 (baz@gigabaz.com; http://gigabaz.com/gigabaz/)', '', '', 'GigaBaz', 'detection_user_agent', '', '', 'http://gigabaz.com/gigabaz/');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (130, 0, 'geckobot', '', '', 'geckobot', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (131, 0, 'gazz/2.1 (gazz@nttrd.com)', '', '', 'NTTRD.com', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (132, 1, 'GaisLab data gatherer, Gaisbot/3.0+(indexer@gais.cs.ccu.edu.tw;+http://gais.cs.ccu.edu.tw/robot.php)', '', '', 'GaisLab', 'detection_user_agent', '', '', 'http://gais.cs.ccu.edu.tw/robot.php');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (133, 1, 'GAIS Robot/1.0B2', '', '', 'Seed', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (134, 0, 'Firefly/1.0', '', '', 'Fireball', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (135, 1, 'Excalibur Internet Spider V6.5.4', '', '', 'Excalibur', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (136, 0, 'ESISmartSpider', '', '', 'SmartSpider', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (137, 0, 'EroCrawler', '', '', 'EroCrawler', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (138, 0, 'Enterprise_Search/1.0', '', '', 'Enterprise Search', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (139, 0, 'EmailWolf 1.00', '', '', 'EmailWolf', 'detection_user_agent', 'Mail Collector', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (140, 0, 'EmailSiphon', '', '', 'EmailSiphon', 'detection_user_agent', 'Mail Collector', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (141, 1, 'EchO!/2.0', '', '', 'Echo.fr', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (142, 0, 'dtSearchSpider', '', '', 'dtSearchSpider', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (143, 0, 'DoCoMo/1.0/N210i/c10', '', '', 'NTT', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (144, 0, 'DIIbot/1.2', '', '', 'Findsame', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (145, 0, 'DittoSpyder', '', '', 'Ditto', 'detection_user_agent', 'Picture Search', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (146, 0, 'DigOut4U', '', '', 'openPortal4U', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (147, 0, 'Digger/1.0 JDK/1.3.0rc3', '', '', 'DiggIt', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (148, 0, 'dbDig(http://www.prairielandconsulting.com)', '', '', 'dbDig', 'detection_user_agent', '', '', 'http://www.prairielandconsulting.com');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (149, 0, 'DaviesBot/1.7 (www.wholeweb.net)', '', '', 'WholeWeb', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (150, 0, 'Custom Spider www.bisnisseek.com /1.0', '', '', 'Bisnisseek', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (151, 0, 'CurryGuide SiteScan 1.1', '', '', 'CurryGuide', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (152, 0, 'Cuam Ver0.050bx', '', '', 'TTNet', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (153, 1, 'CrawlerBoy Pinpoint.com', '', '', 'pinPoint', 'detection_user_agent', 'WapResearch', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (154, 1, 'Crawler V 0.2.x admin@crawler.de', '', '', 'Abacho.de (1)', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (155, 1, 'Crawler admin@crawler.de', '', '', 'Abacho (2)', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (156, 1, 'cosmos/0.9_(robot@xyleme.com)', '', '', 'SA France', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (157, 0, 'combine/0.0', '', '', 'Combine', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (158, 0, 'CheckWeb', '', '', 'CheckWeb', 'detection_user_agent', 'Link Validation', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (159, 0, 'Checkbot/1.6x LWP/5.46', '', '', 'CheckBot', 'detection_user_agent', 'Linkvalidation', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (160, 0, 'cg-eye interactive', '', '', 'CG-Exe', 'detection_user_agent', 'CGI Checker', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (161, 0, 'BullsEye', '', '', 'BullsEye', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (162, 0, 'Bot mailto:craftbot@yahoo.com', '', '', 'Cybercity', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (163, 0, 'BigBrother/1.6e', '', '', 'BB4', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (164, 1, 'Atomz/1.0', '', '', 'Atomz', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (165, 0, 'ASSORT/0.10', '', '', 'Associative Sort', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (166, 1, 'ASPSeek/1.2.8pre', '', '', 'Aspseek robot', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (167, 1, 'ASPSeek/1.2.6', '', '', 'ASPSeek search engine software', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (168, 0, 'ArchitextSpider', '', '', 'Excite', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (169, 1, 'Arachnoidea (arachnoidea@euroseek.com)', '', '', 'EuroSeek', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (170, 0, 'Aport', '', '', 'Aport', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (171, 0, 'appie 1.1 (www.walhello.com)', '', '', 'WalHello', 'detection_user_agent', '', '', 'www.walhello.com');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (172, 0, 'Allesklar/0.1 libwww-perl/5.46', '', '', 'AllesKlar', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (173, 0, 'AlkalineBOT/1.4 (1.4.0326.0 RTM)', '', '', 'Vestris', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (174, 0, 'Aladin/3.324', '', '', 'Aladin.de', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (175, 0, 'AESOP_com_SpiderMan', '', '', 'AESOP', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (176, 0, 'Acoon Robot v1.50.001', '', '', 'Acoon.de', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (177, 0, 'AcoiRobot', '', '', 'Acoi', 'detection_user_agent', 'Picturefinder', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (178, 0, 'About/0.1libwww-perl/5.47', '', '', 'About', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (179, 1, 'AbachoBOT', '', '', 'AbachoBot', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (180, 0, 'A-Online Search', '', '', 'A-Online Search', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (181, 0, '4anything.com LinkChecker v2.0', '', '', '4anything.com', 'detection_user_agent', '', '', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (182, 1, 'MicrosoftPrototypeCrawler', '131.107.', '', 'MS Prototype', 'detection_user_agent', 'Robot de Microsoft', 'Microsoft\'s Robot', '');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (183, 1, 'Surfnomore Spider', '165.90.194.', '66.28.249.', 'Surfnomore', 'detection_user_agent', 'Moteur de recherche en construction', 'A future search engine...', 'http://www.surfnomore.com');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

$sql = "INSERT INTO ".$RS_TABLE_ROBOTS." VALUES (184, 1, 'MSNBOT/0.1 (http://search.msn.com/msnbot.htm)', '131.107.', '', 'MSN Bot', 'detection_ip', 'Robot qui alimentera peut-�tre un moteur de recherche de Microsoft... MSN ?', 'Maybe the next MSN spider robot...', 'http://search.msn.com/msnbot.htm');";
$res  = mysql_query($sql) or erreurServeurMySQL($sql);

// termin� !
echo $RS_LANG["Install OK"]
?>