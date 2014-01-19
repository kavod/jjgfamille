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

$RS_LANG["YES"]         = "Sí";
$RS_LANG["NO"]          = "No";
$RS_LANG["Delete"]      = "Eliminar";
$RS_LANG["Modify"]      = "Modificar";
$RS_LANG["On"]          = "sobre";
$RS_LANG["Of"]          = "de";
$RS_LANG["CloseWindow"] = "Cerrar ventana";
$RS_LANG["BackHome"]    = "Volver a página principal";
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
$RS_LANG["FullCrawlBeginSubject"] = "RobotStats: ¡el 'Full Crawl' ha comenzado!";
$t  = "Hola,\n";
$t .= "Esta es una alerta enviada por RobotStats, la herramienta instalada en tu sitio web.\n";
$t .= "El 'Full Crawl' puede que haya comenzado. Un 'bot' cuya dirección IP comienza \n";
$t .= "por 216. acaba de visitar tu sitio web.\n\n";
$t .= "Para más información, visita el foro de Dirson en la siguiente dirección:\n";
$t .= "http://google.dirson.com/foro/foro-google.php\n";
$RS_LANG["FullCrawlBeginBody"]    = $t;

// ---------------------------------------------------------------------------
// calendar
// ---------------------------------------------------------------------------
$RS_LANG["Error"]        = "Error";
$RS_LANG["Visites"]      = "Visitas";
$RS_LANG["Pages"]        = "Páginas";
$RS_LANG["VisitsPerDay"] = "Visitas / Día";
$RS_LANG["URL"]          = "URL";
$RS_LANG["Hour"]         = "Hora";
$RS_LANG["NbOfVisits"]   = "#Visitas";
$RS_LANG["NoData"]       = "Sin datos";
$RS_LANG["Summary"]      = "Resumen";
$RS_LANG["Pages"]        = "Páginas";
$RS_LANG["Graph"]        = "Gráfica";
$RS_LANG["Monday1"]      = "L";
$RS_LANG["Tuesday1"]     = "M";
$RS_LANG["Wednesday1"]   = "X";
$RS_LANG["Thursday1"]    = "J";
$RS_LANG["Friday1"]      = "V";
$RS_LANG["Saturday1"]    = "S";
$RS_LANG["Sunday1"]      = "D";
$RS_LANG["PreviousDay"]  = "Día Anterior";
$RS_LANG["PreviousMonth"]= "Mes Anterior";
$RS_LANG["NextDay"]      = "Día Sigiente";
$RS_LANG["NextMonth"]    = "Mes Siguiente";
$RS_LANG["Week"]         = "Semana";

// ---------------------------------------------------------------------------
// table
// ---------------------------------------------------------------------------
$RS_LANG["Code"]         = "Código  HTTP";

// ---------------------------------------------------------------------------
// graph
// ---------------------------------------------------------------------------
$RS_LANG["GraphAlt"]     = "Gráfica de las visitas de ";
$RS_LANG["Graph1"]       = "Escoge la gráfica a mostrar:";
$RS_LANG["Month_1"]      = "1 mes";
$RS_LANG["Month_2"]      = "2 meses";
$RS_LANG["Month_3"]      = "3 meses";
$RS_LANG["Month_6"]      = "6 meses";
$RS_LANG["Month_12"]     = "1 año";
$RS_LANG["InactiveCalendar"] = "Desactivar Calendario";

// ---------------------------------------------------------------------------
// robots
// ---------------------------------------------------------------------------
$RS_LANG["RobotsAvailable"]  = " robot(s) conocido(s):";
$RS_LANG["NoRobotDefined"]   = "¡No hay ningún robot definido!";
$RS_LANG["SelectedRobot"]    = "Robot Seleccionado";
$RS_LANG["RobotDescription"] = "Descripción del Robot";
$RS_LANG["UndefinedRobot"]   = "¡Robot sin definir!";
$RS_LANG["RobotName"]        = "Nombre";
$RS_LANG["RobotActive"]      = "¿Activo?";
$RS_LANG["ActiveRobots"]     = "Robots Activados";
$RS_LANG["NonActiveRobots"]  = "Robots Desactivados";
$RS_LANG["RobotUserAgent"]   = "User Agent";
$RS_LANG["RobotIP1"]         = "Dirección IP #1";
$RS_LANG["RobotIP2"]         = "Dirección IP #2";
$RS_LANG["RobotMode"]        = "Modo de detección";
$RS_LANG["RobotDesc"]        = "Descripción";
$RS_LANG[$RS_DETECTION_USER_AGENT] = "Por el User Agent";
$RS_LANG[$RS_DETECTION_IP]         = "Por la dirección IP";
$RS_LANG["RobotURL"]         = "URL";
$RS_LANG["RobotURLInfo"]     = "Página web oficial de este robot";
$RS_LANG["ListeRobotsVenus"] = "Lista de robots que vinieron en este periodo:";

// ---------------------------------------------------------------------------
// Index page
// ---------------------------------------------------------------------------
$RS_LANG["TitleIndex"]         = "RobotStats: Análisis de las visitas de Google i otros robots";
$RS_LANG["IPAddresses"]        = "Direcciones IP";
$RS_LANG["RobotsPie"]          = "Reparticion de los robots";

// ---------------------------------------------------------------------------
// footer
// ---------------------------------------------------------------------------
$RS_LANG["RS_Line1"]      = ": análisis en tiempo real de las visitas de Google i otros robots en tu sitio web";
$RS_LANG["RS_Line2"]      = "Aplicación Libre y de Código Abierto, desarrollada por";
$RS_LANG["RS_desc"]       = "Especialista en Optimización Google";
$RS_LANG["Info"]          = "Para mayor información, dirígete a";

// ---------------------------------------------------------------------------
// installation
// ---------------------------------------------------------------------------
$RS_LANG["Install OK"] = "El proceso de instalación se ha completado. No olvides borrar el fichero 'install.php' del servidor. Pulsa <A HREF='index.php'>aquí</A> para volver a la página principal.";
$RS_LANG["UpdateOK"]   = "El proceso de actualización ha concluido.";

// ---------------------------------------------------------------------------
// admin
// ---------------------------------------------------------------------------
$RS_LANG["Admin"]            = "Administración";
$RS_LANG["TitleAdmin"]       = "Área de Administración";
$RS_LANG["AdminTestVersion"] = "Comprobar si hay Nuevas Versiones";
$RS_LANG["AdminNothing"]     = "Estás en el Área de Administración. Pulsa sobre un elemento.";
$RS_LANG["AdminReset"]       = "Reset (borrado de registros)";
$RS_LANG["AdminResetExplanations"] = "Esta herramienta te permite borrar algunos de los registros almacenados en la Base de Datos MySQL (visitas de los robots). Puedes borrar un mes o todos los datos.";
$RS_LANG["ResetMonths"]      = "Borrar un mes";
$RS_LANG["ResetAll"]         = "Borrar todo";
$RS_LANG["ResetAllLink"]     = "Pulsa aquí (ten cuidado, porque esta operación NO puede ser cancelada)";
$RS_LANG["ResetNoData"]      = "¡No hay datos!";
$RS_LANG["ResetMonthsOK"]    = "Los datos de este mes han sido eliminados.";
$RS_LANG["ResetMonthsNOK"]   = "Parámetros no válidos: no se puede eliminar este mes";
$RS_LANG["ResetAllOK"]       = "Todos los datos han sido borrados.";
$RS_LANG["AdminVersionTitle"] = "Comprueba si dispones de la última versión de RobotStats";
$RS_LANG["AdminVersionLink"]  = "Pulsa aquí para comprobarlo.";
$RS_LANG["AdminRobots"]      = "Gestión de Robots";
$RS_LANG["ModifyRobot"]      = "Modificar un robot";
$RS_LANG["AddRobot"]         = "Añadir un nuevo robot";
$RS_LANG["RobotDeleted"]     = "El robot ha sido eliminado.";
$RS_LANG["BackToRobotsAdmin"]= "Volver a Gestión de Robots.";
$RS_LANG["RobotAdded"]       = "¡Robot añadido!";
$RS_LANG["RobotUpdated"]     = "¡Robot modificado!";
$RS_LANG["RobotDeleted"]     = "¡Robot eliminado!";
$RS_LANG["BadRobotName"]     = "¡Nombre de robot no válido!";
$RS_LANG["BadUserAgent"]     = "¡Nombre de User Agent no válido!";
$RS_LANG["IPNotSpecified"]   = "¡No has definido ninguna dirección IP para el robot!";
$RS_LANG["BadDetectionMode"] = "¡Modo de detección no válido!";


// ---------------------------------------------------------------------------
// other
// ---------------------------------------------------------------------------
$TAB_MONTHS = array( '','Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' );
$TAB_JOURS = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
?>
