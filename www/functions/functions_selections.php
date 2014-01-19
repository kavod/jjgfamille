<?
function Execute($sql)
{		
	$result = mysql_query($sql) or
	die("<br>ERREUR CRITIQUE Requete SQL<br>FICHIER : ".__FILE__."<br>LIGNE ".__LINE__."<br>SQL = ".$sql);
	return $result;
}

function select_element($sql,$error='',$obli=true,$file='X',$line=-1)
{
	$result = mysql_query($sql) or 
	message_die(CRITICAL_ERROR, 'Bad SQL request on ' . $file . ':' . $line, "", __LINE__, __FILE__, $sql);
	if($val = mysql_fetch_array($result))
	{
		mysql_free_result($result);
		return $val;
	} else
	{
		if ($obli)
			message_die(CRITICAL_ERROR,$error,'',__LINE__,__FILE__,$sql);
		else
			return false;
	}
}

function select_liste($sql)
{
	$result = mysql_query($sql) or 
	message_die(CRITICAL_ERROR, 'Bad SQL request', "", __LINE__, __FILE__, $sql);
	for ($i=0; $val = mysql_fetch_array($result) ; $i++)
	{
		$tab[$i] = $val;
	}
	mysql_free_result($result);
	return $tab;
}

function is_responsable($user_id,$code_rub='')
{
	// Boris 13/05/2006
	// Mesures anti-spam
	// Vérifie si le user est responsable d'une rubrique quelconque
	if ($code_rub=='')
		$code_rub = '%';
	// fin modif
	
	if (select_element('SELECT * FROM famille_access WHERE user_id = '.$user_id.' AND rub LIKE \''.$code_rub.'\'','',false))
	{
		return true;
	} else
		return false;
}
?>