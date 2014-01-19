<?
define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.php');
include($phpbb_root_path . 'functions/functions_disco.php');
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'fmc/style.php');

// Start session management
$userdata = session_pagestart($user_ip, PAGE_FMC);
init_userprefs($userdata);
// End session management

//On recupere le mode (midi,disco,media,report)
$mode = $_GET['mode'];

//On recupere le id de l'audio
if(isset($_GET['id']) &&  $_GET['id']!='')
{
	$id = $_GET['id'];
}
else //S'il n'existe pas selon le mode on selectionne un audio opif
{
	switch($mode)
	{
		case "midi" :
			$midiopif = select_element("SELECT song_id FROM disco_songs WHERE midi = 'Y' ORDER BY RAND()");
			$assopif = select_element("SELECT id FROM disco_songs_albums WHERE song_id=".$midiopif['song_id']." ORDER BY id");
			$id = $assopif['id'];
		break;
		case "disco" :
			$discopif = select_element("SELECT song_id FROM disco_songs WHERE rm = 'Y' ORDER BY RAND()");
			$assopif = select_element("SELECT id FROM disco_songs_albums WHERE song_id=".$discopif['song_id']." ORDER BY id");
			$id = $assopif['id'];
		break;
		case "media" :
			$mediaopif = select_element("SELECT emission_id FROM media_audio ORDER BY RAND()");
			$audiopif = select_element("SELECT audio_id FROM media_audio WHERE emission_id= ".$mediaopif['emission_id']." ORDER BY audio_id");
			$id = $audiopif['audio_id'];
		break;
		case "report" :
			$reportopif = select_element("SELECT * FROM report_audio ORDER BY audio_id");
			$id = $reportopif['audio_id'];
		break;
	}
}
?>

<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<title>JJG famille :: famille media center</title>
<style type="text/css">
<!--
<? echo $style; ?>
-->
</style>
<script type="text/javascript">
<!--
	document.oncontextmenu = function() {return false;};
	document.ondragstart = function() {return false;};
	document.onselectstart = function() {return false;};
-->
</script>
</head>

<body>
<!-- entete de la page avec titre,image + formulaire pour changer de mode  -->
<form name="form" action="jukebox.php" method="get">
<table width="99%" border="0" cellpadding="0">
<tr>
   <td><img src="<? echo $phpbb_root_path; ?>templates/jjgfamille/images/site/ban.png" border="0" align="middle" title="Le site famille" alt="Le site famille" /></td>
   <td><center><font size="+1" color="#FF9933" face="Verdana, Arial, Helvetica, sans-serif"><img src="<? echo $phpbb_root_path; ?>images/jukebox.gif" border="0" align="middle" title="Famille media center" alt="Famille media center" /></font></center></td>
</tr>
<tr>
   <td align="right"><font size="2" color="#FF9933" face="Verdana, Arial, Helvetica, sans-serif">Jukebox famille v1.3</font></td>
   <td>
    <center>
    <select name="mode" onchange="form.submit();">
	<option value="disco" <? if($mode == 'disco'){echo "selected";} ?>>Jukebox Discographie</option>
	<option value="midi" <? if($mode == 'midi'){echo "selected";} ?>>Jukebox  Midi</option> 
	<option value="media" <? if($mode == 'media'){echo "selected";} ?>>Jukebox Médiathèque</option>
	<option value="report" <? if($mode == 'report'){echo "selected";} ?>>Jukebox Reportages</option>  
    </select>
    </center>
   </td>
</tr>
</table>
</form>
<!-- FIN ENTETE  -->
<!-- DEBUT ENTETE TABLEAU  -->
<center>
<table style="text-align: left; width: 80%;" border="1" cellspacing="0" cellpadding="0" bordercolor="#A98743">
<tbody>
<tr>
<th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">
<? 
switch($mode) 
{
	case "midi" : echo "JUKEBOX MIDI";break;
	case "disco" : echo "JUKEBOX DISCOGRAPHIE";break;
	case "media" : echo "JUKEBOX MEDIATHEQUE";break;
	case "report" : echo "JUKEBOX REPORTAGES";break;
	default : echo "JUKEBOK FAMILLE"; 
} 
?>
</th>
</tr>
<!-- FIN ENTETE TABLEAU  -->
<!-- DEBUT DES SWITCH  -->
<? 
switch($mode)
{
////////////////////////////////////////////   MIDI   //////////////////////////////////////////////////////////
Case "midi":
$val_asso = sql_select('disco_songs_albums','id = '.$id,'','','asso');
$val_song = sql_select('disco_songs','song_id = '.$val_asso['song_id'],'','','song');
$val_jack = select_element("SELECT C.* FROM disco_songs_albums A, disco_albums B, disco_jacks C WHERE C.album_id = B.album_id AND A.album_id = B.album_id AND B.title = '".str_replace("'","\'",$val_song['title'])."' AND B.type = 'le single' AND A.song_id = ".$val_song['song_id']." ORDER BY B.date,C.ordre",'',false);
if(!$val_jack)
	$val_jack = sql_select('disco_jacks','album_id = '.$val_asso['album_id'],'ordre','','');
$ext = find_image('../images/disco/jack_'.$val_jack['album_id'].'_'.$val_jack['jack_id'].'.');
if($val_jack && is_file('../images/disco/jack_'.$val_jack['album_id'].'_'.$val_jack['jack_id'].'.'.$ext))
	$jack = $phpbb_root_path . 'functions/miniature.php?mode=disco&album_id=' . $val_jack['album_id'] . '&jack_id='. $val_jack['jack_id'] . '&tnH=90';
else
	$jack = '../templates/jjgfamille/images/site/px.png';

?> 
<tr>
   <td class="catLeft" height="28"><span class="cattitle"><b><? echo $val_song['title']; ?></b></span></td>
</tr>
<tr>
   <td class="row2"><br/>
   <form name="formmidi" action="jukebox.php" method="get">
                   <table width="99%" align="center" border="0">
                     <tr>
                       <td width="150" align="center" valign="middle"><img src="<? echo $jack; ?>" border="0" alt="<? echo $val_song['title']; ?>" title="<? echo $val_song['title']; ?>" /><br/></td>
                       <td class="row2" align="center" valign="middle"><embed autostart='true' bgcolor="#FFFFFF" src="<? echo $phpbb_root_path; ?>audio/disco/midi_<? echo $id; ?>.mid"></td>
		     </tr>
                     <tr>
                       <td colspan="2"  class="row2"><br/>
                       <input type="hidden" name="mode" value="<? echo $mode; ?>">
                        <span class="genmed">Ecouter une autre chanson</span>&nbsp;&nbsp;
                        <select name="id" onchange="formmidi.submit();"><? 
                       $tab_midi = select_liste("SELECT * FROM disco_songs WHERE midi = 'Y' ORDER BY `title`");
                       while(list($key,$val) = each($tab_midi)){ 
                       	$asso = select_element("SELECT * FROM disco_songs_albums WHERE song_id = ".$val['song_id']."",'',false);
                       	?>
                       <option value="<? echo $asso['id']; ?>" <? if($asso['id']==$id){echo "selected";}?>><? echo $val['title']; ?></option><?}?>
                      </select>
                      </td>
                      </tr>
                      </table>
                      </form>
   </td>
</tr>
<? break; ////////////////////////////////////////////  FIN MIDI   //////////////////////////////////////////////////////////

////////////////////////////////////////////   DISCO   //////////////////////////////////////////////////////////
case "disco":
$val_asso = sql_select('disco_songs_albums','id = '.$id,'','','asso');
$val_song = sql_select('disco_songs','song_id = '.$val_asso['song_id'],'','','song');
$val_jack = select_element("SELECT C.* FROM disco_songs_albums A, disco_albums B, disco_jacks C WHERE C.album_id = B.album_id AND A.album_id = B.album_id AND B.title = '".str_replace("'","\'",$val_song['title'])."' AND B.type = 'le single' AND A.song_id = ".$val_song['song_id']." ORDER BY B.date,C.ordre",'',false);
if(!$val_jack)
$val_jack = sql_select('disco_jacks','album_id = '.$val_asso['album_id'],'ordre','','');
$ext = find_image('../images/disco/jack_'.$val_jack['album_id'].'_'.$val_jack['jack_id'].'.');
if($val_jack && is_file('../images/disco/jack_'.$val_jack['album_id'].'_'.$val_jack['jack_id'].'.'.$ext))
	$jack = $phpbb_root_path . 'functions/miniature.php?mode=disco&album_id=' . $val_jack['album_id'] . '&jack_id='. $val_jack['jack_id'] . '&tnH=90';
else
	$jack = '../templates/jjgfamille/images/site/px.png';

?> 
<tr>
   <td class="catLeft" height="28"><span class="cattitle"><b><? echo $val_song['title']; ?></b></span></td>
</tr>
<tr>
   <td class="row2"><br/>
   <form name="formdisco" action="jukebox.php" method="get">
                   <table width="99%" align="center" border="0">
                     <tr>
                       <td width="150" align="center" valign="middle"><img src="<? echo $jack; ?>" border="0" alt="<? echo $val_song['title']; ?>" title="<? echo $val_song['title']; ?>" /><br/></td>
                       <td class="row2" align="center" valign="middle">
                       <object id="video1" classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" height="30" width="200">
			      <param name="_ExtentX" value="1191">
			      <param name="_ExtentY" value="661">
			      <param name="AUTOSTART" value="0">
			      <param name="SHUFFLE" value="0">
			      <param name="PREFETCH" value="0">
			      <param name="NOLABELS" value="0">
			      <param name="SRC" value="<? echo $phpbb_root_path; ?>audio/disco/extrait_<? echo $id; ?>.ram">
			      <param name="CONTROLS" value="ControlPanel">
			      <param name="CONSOLE" value="Clip1">
			      <param name="LOOP" value="0">
			      <param name="NUMLOOP" value="0">
			      <param name="CENTER" value="0">
			      <param name="MAINTAINASPECT" value="0">
			      <param name="BACKGROUNDCOLOR" value="#000000"><embed src="<? echo $phpbb_root_path; ?>audio/disco/extrait_<? echo $id; ?>.ram" type="audio/x-pn-realaudio-plugin" console="clip1" controls="ControlPanel" height="25" width="45" autostart="true">
			      </object>
                       </td>
		     </tr>
                     <tr>
                       <td colspan="2"  class="row2"><br/>
                       <input type="hidden" name="mode" value="<? echo $mode; ?>">
                        <span class="genmed">Ecouter un autre extrait de chanson</span>&nbsp;&nbsp;
                        <select name="id" onchange="formdisco.submit();"><? 
                       $tab_disco = select_liste("SELECT * FROM disco_songs WHERE rm = 'Y' ORDER BY title");
                       while(list($key,$val) = each($tab_disco)){ 
                       	$asso = select_element("SELECT * FROM disco_songs_albums WHERE song_id = ".$val['song_id'],'',false);
                       	?>
                       <option value="<? echo $asso['id']; ?>" <? if($asso['id']==$id){echo "selected";}?>><? echo $val['title']; ?></option><?}?>
                      </select>
                      </td>
                      </tr>
                      </table>
                      </form>
   </td>
</tr>
<? break;////////////////////////////////////////////   FIN DISCO   //////////////////////////////////////////////////////////

////////////////////////////////////////////   MEDIA   //////////////////////////////////////////////////////////
case "media":
$val_audio = sql_select('media_audio','audio_id = '.$id,'','','audio');
$val_emission = sql_select('media_emission','emission_id = '.$val_audio['emission_id'],'','','emission');
	
	
$sql_illustration = "SELECT * FROM media_illustrations WHERE emission_id = ".$val_audio['emission_id']." ORDER BY RAND()";
$result_illustration = mysql_query($sql_illustration);
if ($val_illustration = mysql_fetch_array($result_illustration))
{
	$illu_id = $val_illustration['illustration_id'];
	mysql_free_result($result_illustration);
} else
{
	$illu_id = 0;
}
?>
<tr>
   <td class="catLeft" height="28"><span class="cattitle"><b><? echo $val_emission['title']; ?></b></span></td>
</tr>
<tr>
   <td class="row2">
   <form name="formmedia" action="jukebox.php" method="get">
                   <table width="99%" align="center" border="0">
                   <tr>
                       <td colspan="2"><span class="genmed"><b>Extrait :</b><? echo $val_audio['description']; ?><br/><i>Auteur :</i><? echo $val_audio['auteur']; ?></span></td>
		     </tr>
                     <tr>
                       <td height="112" width="40%" align="center" valign="middle">
                       <? if ($illu_id != 0){?>
                       <img src="../functions/miniature.php?mode=medias&emission_id=<? echo $val_emission['emission_id']; ?>&illu_id=<? echo $illu_id; ?>" border="0" alt="<? echo $val_emission['title']; ?>" title="<? echo $val_emission['title']; ?>"/>
                       <? }?>
                        <br/></td>
                       <td rowspan="2" class="row2" align="center" valign="top">
                       <span class="genmed"><u><b>Liste des autres audios de l' émission</b></u></span><br/><br/>
                       <? 
                       $tab_audio = select_liste("SELECT * FROM media_audio WHERE emission_id=".$val_emission['emission_id']." ORDER BY audio_id");
                       while(list($key,$val) = each($tab_audio)){ 
                       ?> <span class="genmed"><a href="jukebox.php?mode=media&id=<? echo $val['audio_id']; ?>"><? echo $val['description']; ?></a></span><br/>	
		       <? }?>
                       </td>
		     </tr>
		    <tr><td align="center" valign="middle">
		    <object id="video1" classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" height="200" width="200">
			      <param name="_ExtentX" value="1191">
			      <param name="_ExtentY" value="661">
			      <param name="AUTOSTART" value="0">
			      <param name="SHUFFLE" value="0">
			      <param name="PREFETCH" value="0">
			      <param name="NOLABELS" value="0">
			      <param name="SRC" value="<? echo $phpbb_root_path; ?>audio/media/audio_<? echo $val_emission['emission_id']; ?>_<? echo $id; ?>.ram">
			      <param name="CONTROLS" value="ImageWindow,ControlPanel">
			      <param name="CONSOLE" value="Clip1">
			      <param name="LOOP" value="0">
			      <param name="NUMLOOP" value="0">
			      <param name="CENTER" value="0">
			      <param name="MAINTAINASPECT" value="0">
			      <param name="BACKGROUNDCOLOR" value="#000000"><embed src="<? echo $phpbb_root_path; ?>audio/media/audio_<? echo $val_emission['emission_id']; ?>_<? echo $id; ?>.ram" type="audio/x-pn-realaudio-plugin" console="clip1" controls="ImageWindow,ControlPanel" height="200" width="200" autostart="true">
			    </object>
                       </td>
		     </tr>
                     <tr>
                       <td colspan="2"  class="row2"><br/>
                       <input type="hidden" name="mode" value="<? echo $mode; ?>">
                        <span class="genmed">Ecouter les extraits d'une autre emission</span>&nbsp;&nbsp;
                        <select name="id" onchange="formmedia.submit();"><? 
                       $tab_media = select_liste("SELECT DISTINCT(emission_id) FROM media_audio");
                       while(list($key,$val) = each($tab_media)){ 
                       	$val_media = sql_select('media_emission','emission_id = '.$val['emission_id'],'','','emission');
                       	$val_media_audio = sql_select('media_audio','emission_id = '.$val_media['emission_id'],'audio_id','','audio');
                       	?>
                       <option value="<? echo $val_media_audio['audio_id']; ?>" <? if($val_media['emission_id']==$val_emission['emission_id']){echo "selected";}?>><? echo $val_media['title']; ?></option><?}?>
                      </select>
                      </td>
                      </tr>
                      </table>
                      </form>
   </td>
</tr>
<? break; ////////////////////////////////////////////   FIN MEDIA   //////////////////////////////////////////////////////////

////////////////////////////////////////////   REPORTAGE   //////////////////////////////////////////////////////////
case "report":
$val_audio = sql_select('report_audio','audio_id = '.$id,'','','audio');
$val_page = sql_select('report_pages','page_id='.$val_audio['page_id'],'','','page');
$val_report = sql_select('report','report_id = '.$val_page['report_id'],'','','report');

$sql_photo = "SELECT * FROM report_photos WHERE report_id = ".$val_report['report_id']." ORDER BY RAND() LIMIT 0,1";
$result_photo = mysql_query($sql_photo);
if ($val_photo = mysql_fetch_array($result_photo))
{
	$illu_id = $val_photo['photo_id'];
	mysql_free_result($result_photo);
} else
{
	$illu_id = 0;
}
?>
<tr>
   <td class="catLeft" height="28"><span class="cattitle"><b><? echo $val_report['title']; ?></b></span></td>
</tr>
<tr>
   <td class="row2">
   <form name="formreport" action="jukebox.php" method="get">
                   <table width="99%" align="center">
                   <tr>
                       <td colspan="2"><span class="genmed"><b>Extrait :</b><? echo $val_audio['description']; ?></span></td>
		     </tr>
                     <tr>
                       <td height="112" width="40%" align="center" valign="middle">
                       <? if ($illu_id != 0){?>
                       <img src="../functions/miniature.php?mode=report&report_id=<? echo $val_report['report_id']; ?>&photo_id=<? echo $illu_id; ?>" border="0" alt="<? echo $val_report['title']; ?>" title="<? echo $val_report['title']; ?>"/>
                       <? }?>
                        <br/></td>
                       <td rowspan="2" class="row2" align="center" valign="top">
                       <span class="genmed"><u><b>Liste des autres audios du reportage</b></u></span><br/><br/>
                       <? 
                        $tab_audio = select_liste("SELECT * FROM report_audio WHERE page_id=".$val_page['page_id']." ORDER BY audio_id");
                       	while(list($key,$val) = each($tab_audio)){
                       ?> <span class="genmed"><a href="jukebox.php?mode=report&id=<? echo $val['audio_id']; ?>"><? echo $val['description']; ?></a></span><br/>	
		       <? }?>
                       </td>
		     </tr>
		    <tr><td align="center" valign="middle">
		    <object id="video1" classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" height="200" width="200">
			      <param name="_ExtentX" value="1191">
			      <param name="_ExtentY" value="661">
			      <param name="AUTOSTART" value="0">
			      <param name="SHUFFLE" value="0">
			      <param name="PREFETCH" value="0">
			      <param name="NOLABELS" value="0">
			      <param name="SRC" value="<? echo $phpbb_root_path; ?>audio/report/audio_<? echo $val_page['page_id']; ?>_<? echo $id; ?>.ram">
			      <param name="CONTROLS" value="ImageWindow,ControlPanel">
			      <param name="CONSOLE" value="Clip1">
			      <param name="LOOP" value="0">
			      <param name="NUMLOOP" value="0">
			      <param name="CENTER" value="0">
			      <param name="MAINTAINASPECT" value="0">
			      <param name="BACKGROUNDCOLOR" value="#000000"><embed src="<? echo $phpbb_root_path; ?>audio/report/audio_<? echo $val_page['page_id']; ?>_<? echo $id; ?>.ram" type="video/vnd.rn-realvideo" console="clip1" controls="ImageWindow,ControlPanel" height="200" width="200" autostart="true">
			    </object>
                       </td>
		     </tr>
                     <tr>
                       <td colspan="2"  class="row2"><br/>
                       <input type="hidden" name="mode" value="<? echo $mode; ?>">
                        <span class="genmed">Ecouter les extraits des autres pages du reportage</span>&nbsp;&nbsp;
                        <select name="id" onchange="formreport.submit();"><? 
                       $tab_page = select_liste("SELECT * FROM report_pages WHERE report_id=".$val_report['report_id']." ORDER BY ordre");
			while(list($key,$val) = each($tab_page)){  
			$val_reportage = select_element("SELECT * FROM report_audio WHERE page_id=".$val['page_id']." ORDER BY audio_id",'',false);	
			?><option value="<? echo $val_reportage['audio_id']; ?>" <? if($val['page_id']==$val_page['page_id']){echo "selected";}?>>Page N°<? echo $key+1; ?></option>
			<?}?>
                      </select>
                      </td>
                      </tr>
                      </table>
                      </form>
   </td>
</tr>
<? break; ////////////////////////////////////////////   FIN REPORTAGE   //////////////////////////////////////////////////////////
}
?>
<!-- FIN DES SWITCH  -->
</tbody>
</table>
</body>
</html>
<!-- FIN PAGE  -->
