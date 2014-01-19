<?php

/***************************************************************************
 *
 *   RobotStats
 *
 * Author: 	Olivier Duffez, WebRankInfo ( http://www.webrankinfo.com )
 * Version:  1.0
 * Date:     2003-10-11
 * Homepage: 	http://www.robotstats.com    
 * Translated into Spanish: 	http://google.dirson.com (2003-03-05)
 *
 ***************************************************************************/

$RS_LANG = array();

$RS_LANG["YES"]         = "S�";
$RS_LANG["NO"]          = "No";
$RS_LANG["Delete"]      = "Eliminar";
$RS_LANG["Modify"]      = "Modificar";
$RS_LANG["On"]          = "sobre";
$RS_LANG["Of"]          = "de";
$RS_LANG["CloseWindow"] = "Cerrar ventana";
$RS_LANG["BackHome"]    = "Volver a p�gina principal";
$RS_LANG["OK"]          = "OK";

// ---------------------------------------------------------------------------
// error handling
// ---------------------------------------------------------------------------
$RS_LANG["MySQLErrorSubject"] = "Error con RobotStats";
$RS_LANG["MySQLErrorBody1"]   = "Las siguientes peticiones SQL han fallado:\n";
$RS_LANG["MySQLErrorBody2"]   = "";

// ---------------------------------------------------------------------------
// alertes par mail
// ---------------------------------------------------------------------------
$RS_LANG["FullCrawlBeginSubject"] = "RobotStats: �el 'Full Crawl' ha comenzado!";
$t  = "Hola,\n";
$t .= "Esta es una alerta enviada por RobotStats, la herramienta instalada en tu sitio web.\n";
$t .= "El 'Full Crawl' puede que haya comenzado. Un 'bot' cuya direcci�n IP comienza \n";
$t .= "por 216. acaba de visitar tu sitio web.\n\n";
$t .= "Para m�s informaci�n, visita el foro de Dirson en la siguiente direcci�n:\n";
$t .= "http://google.dirson.com/foro/foro-google.php\n";
$RS_LANG["FullCrawlBeginBody"]    = $t;

// ---------------------------------------------------------------------------
// calendar
// ---------------------------------------------------------------------------
$RS_LANG["Error"]        = "Error";
$RS_LANG["Visites"]      = "Visitas";
$RS_LANG["Pages"]        = "P�ginas";
$RS_LANG["VisitsPerDay"] = "Visitas / D�a";
$RS_LANG["URL"]          = "URL";
$RS_LANG["Hour"]         = "Hora";
$RS_LANG["NbOfVisits"]   = "#Visitas";
$RS_LANG["NoData"]       = "Sin datos";
$RS_LANG["Summary"]      = "Resumen";
$RS_LANG["Pages"]        = "P�ginas";
$RS_LANG["Graph"]        = "Gr�fica";
$RS_LANG["Monday1"]      = "L";
$RS_LANG["Tuesday1"]     = "M";
$RS_LANG["Wednesday1"]   = "X";
$RS_LANG["Thursday1"]    = "J";
$RS_LANG["Friday1"]      = "V";
$RS_LANG["Saturday1"]    = "S";
$RS_LANG["Sunday1"]      = "D";
$RS_LANG["PreviousDay"]  = "D�a Anterior";
$RS_LANG["PreviousMonth"]= "Mes Anterior";
$RS_LANG["NextDay"]      = "D�a Sigiente";
$RS_LANG["NextMonth"]    = "Mes Siguiente";
$RS_LANG["Week"]         = "Semana";

// ---------------------------------------------------------------------------
// table
// ---------------------------------------------------------------------------
$RS_LANG["Code"]         = "C�digo  HTTP";

// ---------------------------------------------------------------------------
// graph
// ---------------------------------------------------------------------------
$RS_LANG["GraphAlt"]     = "Gr�fica de las visitas de ";
$RS_LANG["Graph1"]       = "Escoge la gr�fica a mostrar:";
$RS_LANG["Month_1"]      = "1 mes";
$RS_LANG["Month_2"]      = "2 meses";
$RS_LANG["Month_3"]      = "3 meses";
$RS_LANG["Month_6"]      = "6 meses";
$RS_LANG["Month_12"]     = "1 a�o";
$RS_LANG["InactiveCalendar"] = "Desactivar Calendario";

// ---------------------------------------------------------------------------
// robots
// ---------------------------------------------------------------------------
$RS_LANG["RobotsAvailable"]  = " robot(s) conocido(s):";
$RS_LANG["NoRobotDefined"]   = "�No hay ning�n robot definido!";
$RS_LANG["SelectedRobot"]    = "Robot Seleccionado";
$RS_LANG["RobotDescription"] = "Descripci�n del Robot";
$RS_LANG["UndefinedRobot"]   = "�Robot sin definir!";
$RS_LANG["RobotName"]        = "Nombre";
$RS_LANG["RobotActive"]      = "�Activo?";
$RS_LANG["ActiveRobots"]     = "Robots Activados";
$RS_LANG["NonActiveRobots"]  = "Robots Desactivados";
$RS_LANG["RobotUserAgent"]   = "User Agent";
$RS_LANG["RobotIP1"]         = "Direcci�n IP #1";
$RS_LANG["RobotIP2"]         = "Direcci�n IP #2";
$RS_LANG["RobotMode"]        = "Modo de detecci�n";
$RS_LANG["RobotDesc"]        = "Descripci�n";
$RS_LANG[$RS_DETECTION_USER_AGENT] = "Por el User Agent";
$RS_LANG[$RS_DETECTION_IP]         = "Por la direcci�n IP";
$RS_LANG["RobotURL"]         = "URL";
$RS_LANG["RobotURLInfo"]     = "P�gina web oficial de este robot";
$RS_LANG["ListeRobotsVenus"] = "Lista de robots que vinieron en este periodo:";

// ---------------------------------------------------------------------------
// Index page
// ---------------------------------------------------------------------------
$RS_LANG["TitleIndex"]         = "RobotStats: An�lisis de las visitas de Google i otros robots";
$RS_LANG["IPAddresses"]        = "Direcciones IP";
$RS_LANG["RobotsPie"]          = "Reparticion de los robots";

// ---------------------------------------------------------------------------
// footer
// ---------------------------------------------------------------------------
$RS_LANG["RS_Line1"]      = ": an�lisis en tiempo real de las visitas de Google i otros robots en tu sitio web";
$RS_LANG["RS_Line2"]      = "Aplicaci�n Libre y de C�digo Abierto, desarrollada por";
$RS_LANG["RS_desc"]       = "Especialista en Optimizaci�n Google";
$RS_LANG["Info"]          = "Para mayor informaci�n, dir�gete a";

// ---------------------------------------------------------------------------
// installation
// ---------------------------------------------------------------------------
$RS_LANG["Install OK"] = "El proceso de instalaci�n se ha completado. No olvides borrar el fichero 'install.php' del servidor. Pulsa <A HREF='index.php'>aqu�</A> para volver a la p�gina principal.";
$RS_LANG["UpdateOK"]   = "El proceso de actualizaci�n ha concluido.";

// ---------------------------------------------------------------------------
// admin
// ---------------------------------------------------------------------------
$RS_LANG["Admin"]            = "Administraci�n";
$RS_LANG["TitleAdmin"]       = "�rea de Administraci�n";
$RS_LANG["AdminTestVersion"] = "Comprobar si hay Nuevas Versiones";
$RS_LANG["AdminNothing"]     = "Est�s en el �rea de Administraci�n. Pulsa sobre un elemento.";
$RS_LANG["AdminReset"]       = "Reset (borrado de registros)";
$RS_LANG["AdminResetExplanations"] = "Esta herramienta te permite borrar algunos de los registros almacenados en la Base de Datos MySQL (visitas de los robots). Puedes borrar un mes o todos los datos.";
$RS_LANG["ResetMonths"]      = "Borrar un mes";
$RS_LANG["ResetAll"]         = "Borrar todo";
$RS_LANG["ResetAllLink"]     = "Pulsa aqu� (ten cuidado, porque esta operaci�n NO puede ser cancelada)";
$RS_LANG["ResetNoData"]      = "�No hay datos!";
$RS_LANG["ResetMonthsOK"]    = "Los datos de este mes han sido eliminados.";
$RS_LANG["ResetMonthsNOK"]   = "Par�metros no v�lidos: no se puede eliminar este mes";
$RS_LANG["ResetAllOK"]       = "Todos los datos han sido borrados.";
$RS_LANG["AdminVersionTitle"] = "Comprueba si dispones de la �ltima versi�n de RobotStats";
$RS_LANG["AdminVersionLink"]  = "Pulsa aqu� para comprobarlo.";
$RS_LANG["AdminRobots"]      = "Gesti�n de Robots";
$RS_LANG["ModifyRobot"]      = "Modificar un robot";
$RS_LANG["AddRobot"]         = "A�adir un nuevo robot";
$RS_LANG["RobotDeleted"]     = "El robot ha sido eliminado.";
$RS_LANG["BackToRobotsAdmin"]= "Volver a Gesti�n de Robots.";
$RS_LANG["RobotAdded"]       = "�Robot a�adido!";
$RS_LANG["RobotUpdated"]     = "�Robot modificado!";
$RS_LANG["RobotDeleted"]     = "�Robot eliminado!";
$RS_LANG["BadRobotName"]     = "�Nombre de robot no v�lido!";
$RS_LANG["BadUserAgent"]     = "�Nombre de User Agent no v�lido!";
$RS_LANG["IPNotSpecified"]   = "�No has definido ninguna direcci�n IP para el robot!";
$RS_LANG["BadDetectionMode"] = "�Modo de detecci�n no v�lido!";


// ---------------------------------------------------------------------------
// other
// ---------------------------------------------------------------------------
$TAB_MONTHS = array( '','Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' );
$TAB_JOURS = array('Domingo', 'Lunes', 'Martes', 'Mi�rcoles', 'Jueves', 'Viernes', 'S�bado');
?>
