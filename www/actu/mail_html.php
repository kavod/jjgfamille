<?php

define("WEBMASTER_EMAIL","webmaster@domain.com");

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'actu';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_ACTU);
init_userprefs($userdata);
//
// End session management
//
include($phpbb_root_path . 'includes/reserved_access.'.$phpEx);

$rdn_id = $_GET['rdn_id'];

//Selection de la revue du net
$val_rdn = select_element("SELECT * FROM famille_rdn WHERE rdn_id = ".$rdn_id." ",'',false);

//Ici on verifie que la personne soit inscrite (les non inscrits ne passent pas sauf les admins et responsables)
if ($userdata['user_level'] != ADMIN && !is_responsable($userdata['user_id'],'rdn') && $userdata['news_mail']=='N')
{
	redirect(append_sid($phpbb_root_path . "actu/rdn.html"));
}

//selection de la date de l'avant derniere rdn
$val_date = select_element("SELECT date FROM famille_rdn ORDER BY date DESC LIMIT 1,2",'',false);

//Selection des news 
$tab_news = select_liste("SELECT * FROM famille_news WHERE date_unix >= '".$val_date['date']."' AND date_unix >= UNIX_TIMESTAMP('2005-08-01 00:00:00') ORDER BY date_unix DESC");
             
//Selection des majs
$tab_maj = select_liste("SELECT * FROM famille_maj WHERE date_unix >= '".$val_date['date']."' ORDER BY date_unix DESC");

//Image 
$image = $phpbb_root_path . 'images/rdn/rdn_'.$val_rdn['rdn_id'].'.';
$ext = find_image($image);
$image .= $ext;
if(is_file($image))
{
		$img = 'http://'.$board_config['server_name'].'/images/rdn/rdn_'.$val_rdn['rdn_id'].'.'.$ext; 
}else
{
		$img = 'http://'.$board_config['server_name'].'/templates/jjgfamille/images/site/px.png'; 
}

//Séléction de tous les abonnés ou d'un seul 
if (isset($_GET['user_id']) && $_GET['user_id'] != '')
{
	$tab_mail = select_liste("SELECT * FROM phpbb_users WHERE user_id=".$_GET['user_id']."");
} else
{
	$tab_mail = select_liste("SELECT * FROM phpbb_users WHERE news_mail = 'Y' order by user_id");
}

//Construction du message html
$trouble = 'Si vous n\'arrivez pas à lire ce mail,<a href="http://'.$board_config['server_name'].'/actu/mail_html.php?rdn_id='.$val_rdn['rdn_id'].'&nid=1">cliquez-ici</a>';
$message = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
$message .= "<html dir=\"ltr\">\n";
$message .= '<head>'."\n";
$message .= '<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />'."\n";
$message .= '<meta http-equiv="Content-Style-Type" content="text/css" />'."\n";
$message .= '<title>JJG famille :: Jean-Jacques Goldman :: Croisons nos vies de temps en temps</title>'."\n";
$message .= '<style type="text/css">'."\n";
$message .= '<!--'."\n";
$message .= 'font,th,td,p { font-family: Verdana, Arial, Helvetica, sans-serif }'."\n";
$message .= 'a:link,a:active,a:visited { color : #000000; }'."\n";
$message .= 'a:hover		{ text-decoration: underline; color : #DD6900; }'."\n";
$message .= 'hr	{ height: 0px; border: solid #D7BB72 0px; border-top-width: 1px;}'."\n";
$message .= '.bodyline	{ background-color: #FFEFC3; border: 1px #B79B52 solid; }'."\n";
$message .= 'td.row1	{ background-color: #F7DB92;'."\n";
$message .= '		border:#FFEBA2;'."\n";
$message .= '		border-style: solid;'."\n";
$message .= '		border-width: 1px 1px 0px 1px; }'."\n";
$message .= 'td.row2	{ background-color: #F7DB92; }'."\n";
$message .= 'td.row3	{ 	background-color: #E7CB82;'."\n";
$message .= '		border:#FFEBA2;'."\n";
$message .= '		border-style: solid;'."\n";
$message .= '		border-width: 1px 1px 0px 1px;}'."\n";
$message .= 'td.rowpic {'."\n";
$message .= '		background-color: #F7DB92;'."\n";
$message .= '		background-image: url(http://'.$board_config['server_name'].'/templates/jjgfamille/images/cellpic_famille2.png);'."\n";
$message .= '		background-repeat: repeat-y;'."\n";
$message .= '		border:#E7CB82;'."\n";
$message .= '		border-style: solid;'."\n";
$message .= '		border-width: 1px 0px 0px 1px;'."\n";
$message .= '}'."\n";
$message .= 'th	{'."\n";
$message .= '	color: #FFFFFF; font-size: 14px; font-weight : bold;'."\n";
$message .= '	background-color: #B79B52; height: 28px;'."\n";
$message .= '}'."\n";
$message .= 'td.cat,td.catHead,td.catSides,td.catLeft,td.catRight,td.catBottom {'."\n";
$message .= '			background-color:#E7CB82; border: #000000; border-style: solid; height: 28px;'."\n";
$message .= '}'."\n";
$message .= 'td.cat,td.catHead,td.catBottom {'."\n";
$message .= '	height: 29px;'."\n";
$message .= '	border-width: 0px 0px 0px 0px;'."\n";
$message .= '}'."\n";
$message .= 'th.thHead,th.thSides,th.thTop,th.thLeft,th.thRight,th.thBottom,th.thCornerL,th.thCornerR {'."\n";
$message .= '	font-weight: bold; border: #FFEFC3; border-style: solid; height: 28px; }'."\n";
$message .= 'td.row3Right,td.spaceRow {'."\n";
$message .= '}'."\n";
$message .= 'td.catHead { font-size: 12px; border-width: 0px 1px 1px 0px; }'."\n";
$message .= 'th.thHead { font-size: 12px; border-width: 0px 0px 0px 0px; }'."\n";
$message .= 'th.thSides,td.catSides,td.spaceRow	 { border-width: 0px 1px 0px 1px; }'."\n";
$message .= 'th.thRight,td.catRight,td.row3Right	 { border-width: 0px 0px 0px 0px; }'."\n";
$message .= 'td.catLeft	  { border-width: 0px 1px 1px 0px; }'."\n";
$message .= 'th.thBottom,td.catBottom  { border-width: 1px 1px 1px 1px; }'."\n";
$message .= 'th.thTop	 { border-width: 0px 0px 0px 0px; }'."\n";
$message .= 'th.thCornerL { border-width: 0px 0px 0px 0px; }'."\n";
$message .= 'th.thCornerR { border-width: 0px 0px 0px 0px; }'."\n";
$message .= 'th.thLeft    { border-width: 0px 0px 0px 0px; }'."\n";
$message .= '.gen { font-size : 13px; }'."\n";
$message .= '.genmed { font-size : 11px; }'."\n";
$message .= '.gensmall { font-size : 10px; }'."\n";
$message .= '.gen,.genmed,.gensmall { color : #000000; }'."\n";
$message .= 'a.gen,a.genmed,a.gensmall { color: #000000; text-decoration: none; }'."\n";
$message .= 'a.gen:hover,a.genmed:hover,a.gensmall:hover	{ text-decoration: underline; color : #DD6900; }'."\n";
$message .= '.cattitle		{ font-weight: bold; font-size: 14px ; letter-spacing: 1px; color : #000000}'."\n";
$message .= 'a.cattitle		{ text-decoration: none; color : #000000; }'."\n";
$message .= 'a.cattitle:hover{ text-decoration: underline; }'."\n";
$message .= '.Copyright		{ font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #444444; letter-spacing: -1px;}'."\n";
$message .= 'a.copyright		{ color: #444444; text-decoration: none;}'."\n";
$message .= 'a.copyright:hover { color: #000000; text-decoration: underline;}'."\n";
$message .= '-->'."\n";
$message .= '</style>'."\n";
$message .= '</head>'."\n";
$message .= '<body bgcolor="#FFEFC3">'."\n";
$message .= '<center>'."\n";
$message .= '<table width="90%" border="0" cellpadding="0"><tr><td><center><a href="http://'.$board_config['server_name'].'"><img src="http://'.$board_config['server_name'].'/templates/jjgfamille/images/site/ban.png" border="0" align="middle" title="Le site famille" alt="Le site famille" /></a></center></td></tr></table>'."\n";
$message .= '<br>'."\n";
$message .= '<table style="text-align: left; width: 90%;" border="1" cellspacing="0" cellpadding="0" bordercolor="#A98743">'."\n";
$message .= '<tbody>'."\n";
$message .= '<tr>'."\n";
$message .= '<th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">LA REVUE DU NET</th>'."\n";
$message .= '</tr>'."\n";
$message .= '<tr>'."\n";
$message .= '<td class="catLeft" height="28"><span class="cattitle"><b>'.$val_rdn['title'].'</b></span>&nbsp;&nbsp;<span class="genmed">Posté par <a href="http://'.$board_config['server_name'].'/forum/profile.php?mode=viewprofile&u='.$val_rdn['user_id'].'&nid=1">'.$val_rdn['username'].'</a> '.date_unix($val_rdn['date'],'date').'</span></td>'."\n";
$message .= '</tr>'."\n";
$message .= '<tr>'."\n";
$message .= '<td class="row2"><br/><center><img src="'.$img.'" border="0" alt="'.$val_rdn['title'].'" title="'.$val_rdn['title'].'" /></center><br /><span class="genmed">'.nl2br(bbencode_second_pass($val_rdn['contenu'],$val_rdn['bbcode_uid'])).'</span><br/><br/></td>'."\n";
$message .= '</tr>'."\n";
$message .= '</tbody>'."\n";
$message .= '</table>'."\n";
$message .= '<br/>'."\n";
$message .= '<table style="text-align: left; width: 90%;" border="1" cellspacing="0" cellpadding="0" bordercolor="#A98743">'."\n";
$message .= '<tbody>'."\n";
$message .= '<tr>'."\n";
$message .= '<th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">NEWS !</th>'."\n";
$message .= '</tr>'."\n";
	if(!$tab_news)
	 {
		$message .= '<tr>'."\n";
		$message .= '<td class="catLeft" height="28"><span class="genmed"><b>Il n\' y a pas de nouvelle news sur le site famille depuis la derniere revue du net du '.date_unix($val_date['date'],'date1').'</b></span></td>'."\n";
		$message .= '</tr>'."\n";
	
	}else
	{
		for($i=0;$i<count($tab_news);$i++)
		 {
			$val_user = select_element('SELECT user_id,username FROM phpbb_users WHERE user_id = ' . $tab_news[$i]['user_id'],false,'');	

			$message .= '<tr>'."\n";
			$message .= '<td class="catLeft" height="28"><span class="cattitle">'.$tab_news[$i]['title'].'</span>&nbsp;&nbsp;<span class="genmed">Posté par <a href="http://'.$board_config['server_name'].'/forum/profile.php?mode=viewprofile&u='.$val_user['user_id'].'&nid=1">'.$val_user['username'].'</a> '.date_unix($tab_news[$i]['date_unix'],'date').'</span></td>'."\n";
			$message .= '</tr>'."\n";
			$message .= '<tr>'."\n";
			$message .= '<td class="row2"><center><span class="genmed"><a href="http://'.$board_config['server_name'].'/actu/n'.$tab_news[$i]['news_id'].'-' . str_replace('&amp;url_title=','',add_title_in_url($tab_news[$i]['title'])).'.html"><b>Voir la news</b></a></span></center><br /></td>'."\n";
			$message .= '</tr>'."\n";
		}
	}
$message .= '</tbody>'."\n";
$message .= '</table>'."\n";
$message .= '<br/>'."\n";
$message .= '<table style="text-align: left; width: 90%;" border="1" cellspacing="0" cellpadding="0" bordercolor="#A98743">'."\n";
$message .= '<tbody>'."\n";
$message .= '<tr>'."\n";
$message .= '<th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">MISE A JOUR DE FAMILLE</th>'."\n";
$message .= '</tr>'."\n";
	if(!$tab_maj)
	 {
		$message .= '<tr>'."\n";
		$message .= '<td class="catLeft" height="28"><span class="genmed"><b>Il n\' y a pas de nouvelle mise a jour sur le site famille depuis la derniere revue du net du '.date_unix($val_date['date'],'date1').'</b></span></td>'."\n";
		$message .= '</tr>'."\n";
	
	}else
	{
		for($i=0;$i<count($tab_maj);$i++)
		{
			$val_user = select_element('SELECT user_id,username FROM phpbb_users WHERE user_id = ' . $tab_maj[$i]['user_id'],false,''); 	

			$message .= '<tr>'."\n";
			$message .= '<td class="catLeft" height="28"><span class="cattitle"><a href="http://'.$board_config['server_name'].'/actu/m'.$tab_maj[$i]['maj_id'].'-' . str_replace('&amp;url_title=','',add_title_in_url($tab_maj[$i]['title'])) . '.html">'.$tab_maj[$i]['title'].'</a></span>&nbsp;&nbsp;<span class="genmed">Posté par <a href="http://'.$board_config['server_name'].'/forum/profile.php?mode=viewprofile&u='.$val_user['user_id'].'">'.$val_user['username'].'</a> '.date_unix($tab_maj[$i]['date_unix'],'date').'</span></td>'."\n";
			$message .= '</tr>'."\n";
			$message .= '<tr>'."\n";
			$message .= '<td class="row2"><center><span class="genmed"><a href="http://'.$board_config['server_name'].'/'.$tab_maj[$i]['url'].'"><b>Voir la mise à jour</b></a></span></center><br /></td>'."\n";
			$message .= '</tr>'."\n";
		}
	}
$message .= '</tbody>'."\n";
$message .= '</table>'."\n";
$message .= '<br/>'."\n";
$message .= '<table width="90%" border="0" cellpadding="0"><tr><td><span class="genmed"><center>Vous recevez ce mail à la suite de votre inscription sur jjgfamille.com<br />Pour vous désinscire, <a href="http://'.$board_config['server_name'].'/actu/rdn.php?mail=no">cliquez-ici</a><br /></center></span></td></tr></table><br/>'."\n";                  
$message .= '<span class="Copyright">'."\n";
$message .= '<strong>jjgfamille</strong> (c) tous droits réservés<br />'."\n";
$message .= 'Les illustrations, textes, marques, enregistrements audios/vidéos présents sur ce site appartiennent à leur propriétaire respectifs<br />'."\n";
$message .= 'Déclaration CNIL N°1 005 356<br />';
$message .= 'Vous disposez d\'un droit d\'accès, de modification, de rectification et de suppression des données qui vou s concernent (art. 34 de la loi "Informatique et Libertés" du 6 janvier 1978). Vous pouvez, à tout moment, demander que vos contributions à cet espace de discussion soient supprimées.<br />'."\n";
$message .= 'Contact : <a href="mailto:' . WEBMASTER_EMAIL . '">' . WEBMASTER_EMAIL . '</a>.</center>'."\n";
$message .= '<br>'."\n";
$message .= '</span>'."\n";
$message .= '</body>'."\n";
$message .= '</html>'."\n";

//Construction du message texte
$message_txt = "<b>LA REVUE DU NET :</b> ".$val_rdn['title']." Posté par <a href=http://".$board_config['server_name']."/forum/profile.php?mode=viewprofile&u=".$val_rdn['user_id'].">".$val_rdn['username']."</a> ".date_unix($val_rdn['date'],'date')."<br/><br/>";
$message_txt .= nl2br(bbencode_second_pass($val_rdn['contenu'],$val_rdn['bbcode_uid']))."<br/><br/>";
$message_txt .= "<b>NEWS ! :</b><br/>";

	if(!$tab_news)
	 {
		$message_txt .= "<br/><b>Il n' y a pas de nouvelle news sur le site famille depuis la derniere revue du net du ".date_unix($val_date['date'],'date1')."</b><br/><br/>";	
	 }else
	 {
		for($i=0;$i<count($tab_news);$i++)
		 {
			$val_user = select_element('SELECT user_id,username FROM phpbb_users WHERE user_id = ' . $tab_news[$i]['user_id'],false,'');	
			$message_txt .= bbencode_second_pass($tab_news[$i]['news'],$tab_news[$i]['bbcode_uid']).' Posté par <a href="http://'.$board_config['server_name'].'/forum/profile.php?mode=viewprofile&u='.$val_user['user_id'].'">'.$val_user['username'].'</a> '.date_unix($tab_news[$i]['date_unix'],'date').'   <a href="http://'.$board_config['server_name'].'/actu/n'.$tab_news[$i]['news_id'].'-' . str_replace('&amp;url_title=','',add_title_in_url($tab_news[$i]['title'])).'.html">Voir la news</a><br/><br/>';
		}
	 }
	$message_txt .= "<b>MISE A JOUR FAMILLE :</b>\n";
	if(!$tab_maj)
	 {
		$message_txt .= "<br/><b>Il n' y a pas de nouvelle mise à jour sur le site famille depuis la derniere revue du net du ".date_unix($val_date['date'],'date1')."</b><br/><br/>";	
	 }else
	 {
		for($i=0;$i<count($tab_maj);$i++)
		 {
			$val_user = select_element('SELECT user_id,username FROM phpbb_users WHERE user_id = ' . $tab_maj[$i]['user_id'],false,'');	
			$message_txt .= bbencode_second_pass($tab_maj[$i]['maj'],$tab_maj[$i]['bbcode_uid']).' Posté par <a href="http://'.$board_config['server_name'].'/forum/profile.php?mode=viewprofile&u='.$val_user['user_id'].'">'.$val_user['username'].'</a> '.date_unix($tab_maj[$i]['date'],'date').'   <a href="'.$board_config['server_name'].'/'.$tab_maj[$i]['url'].'">Voir la mise à jour</a><br/><br/>';
		}
	 }

$message_txt .= "Pour ne plus recevoir cet email <a href=\"http://" . $board_config['server_name'] . "/actu/rdn.php?mail=no\">cliquez-ici</a>";	 
$message_txt .= "<br/><br/>-- L'équipe d'administration de JJG Famille";

//Envoie du/des mails
if($_GET['mode']=='sendmail')
{

		for($i=0;$i<count($tab_mail);$i++)
		{
			if($tab_mail[$i]['format_mail']=='html')
			{
				$mail = sendmail('html',WEBMASTER_EMAIL,WEBMASTER_EMAIL,$tab_mail[$i]['user_email'],'La Revue du Net famille du '.date_unix($val_rdn['date'],'jour'),$trouble.'<br/>'.$message);
			
			}elseif($tab_mail[$i]['format_mail']=='txt')
			{
				$mail = sendmail('html',WEBMASTER_EMAIL,WEBMASTER_EMAIL,$tab_mail[$i]['user_email'],'La Revue du Net famille du '.date_unix($val_rdn['date'],'jour'),$message_txt);
			}
		}
		
		if (!isset($_GET['user_id']) || $_GET['user_id'] == '')
			$turn_off = mysql_query("UPDATE famille_rdn SET mail = 'Y' WHERE rdn_id = ".$rdn_id); 

		echo '<meta http-equiv="refresh" content="0;url=' . append_sid($phpbb_root_path . "actu/rdn.html") . '">';
				
}else
{
	echo $message;
}
	
?>





