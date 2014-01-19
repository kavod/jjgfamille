<?php
// On trouve le referer
require_once($phpbb_root_path . 'functions/functions.php');
/**
 * Trouve les site correspondant, à un certain niveau, à l'url indiqué
 *
 * @param $url URL à trouver
 * @param $niveau Niveau de comparaison
 *
 * @return id du site trouve ou 0 sinon
 */
function find_site($url,$niveau=0)
{
	if ($niveau>9)
	{
		return 0;
	} else
	{
		$result = sous_url($url,$niveau);
		$sql = "SELECT site_id FROM liens_sites WHERE url LIKE '" . $result . "'";
		$tab_sites = select_liste($sql);
		
		if (count($tab_sites)>0)
		{
			
			if (count($tab_sites)>1)
			{
				// Plusieurs sites correspondent
				return 0;//find_site($url,$niveau+1);
			} else
			{
				return $tab_sites[0]['site_id'];
			}
		} else
		{
			// Aucun site correspondant
			return 0;
		}
	}
}

/**
 * retourne le cache LIKE de l'url dans le niveau demandé
 *
 * @param $url url à analyser
 * @param $niveau niveau demandé
 *
 * @return le résultat
 */
function sous_url($url,$niveau)
{
	$nb_result = preg_match("|http://(.*)|",$url,$matches);
	if ($nb_result == 1 )
	{
		$path = explode("/",$matches[1]);
		if ($path[count($path)-1]=='')
			array_pop($path);
		$domaine = explode(".",$path[0]);
		
		if ($niveau+2<count($domaine))
		{
			$result = 'http://%';
			for ($j=count($domaine)-$niveau-2;$j<count($domaine);$j++)
			{
				$result .= "." . $domaine[$j];
			}
		} else
		{
			$result .= "http://" . $path[0];
			for ($j=1;$j<$niveau-count($domaine)+3;$j++)
			{
				if (!isset($path[$j]))
					return $url;
				else
					$result .= '/' . $path[$j];
			}
		}
		return $result . '%';
	} else
	{
		// URL invalide
		return false;
	}
}

$url_referer = $_SERVER['HTTP_REFERER'];

function get_domain($full_domain)
{
	$full_domain_explo = explode(".",$full_domain);
	$nb_level = count($full_domain_explo);
	return $full_domain_explo[$nb_level-2] . "." . $full_domain_explo[$nb_level-1];
}

preg_match("|(http://[^/]*).*|",$url_referer,$matches);
if (count($matches)>1 && get_domain($_SERVER['HTTP_HOST']) != get_domain($matches[1]))
{
	require_once($phpbb_root_path . 'functions/functions_selections.php');
	//logger("Le site suivant nous a envoyé qqun : " . $matches[1]);
	
	// On vide les clicks de la veille
	$sql_del = "DELETE FROM liens_visitors WHERE day <> ".date('d');
	mysql_query($sql_del) or die("Erreur Interne<br>Requète SQL : ".$sql_del);
	if (mysql_affected_rows()>0)
		logger("table des IP vidée");
		
	// On cherche si l'utilisateur a déjà fait un click
	$sql_select_ip = "SELECT * FROM liens_visitors WHERE ip = '".$_SERVER['REMOTE_ADDR']."' AND day = ".date('d');
	$result_select_ip = mysql_query($sql_select_ip) or die("Erreur Interne<br />Requète SQL invalide : ".$sql_select_ip);
	if (mysql_num_rows($result_select_ip)==0)
	{
		// Non, son click est pris en compte
		// On cherche le site en question dans la rubrique liens
		$site_id = find_site($url_referer);
		if ($site_id>0)
		{
			// On a détecté le site référent
			
			$sql_add = "INSERT INTO liens_visitors (day,ip,site_id) VALUES (".date('d').",'".$_SERVER['REMOTE_ADDR']."',".$site_id.")";
			mysql_query($sql_add) or die("Erreur Interne<br />Requète SQL : ".$sql_add);
			//logger("Ajout d'un lien visiteur pour le site ". $tab_sites['site_name']);
			
			$sql_update = "UPDATE liens_sites SET score = score+1 WHERE site_id = ".$site_id;
			mysql_query($sql_update) or die("Erreur Interne<br />Requète SQL : ".$sql_update);
			logger("+1 point pour le site ". $matches[1]);
		} else
		{
			// Le site référent n'est pas dans les liens
		}
	} else
	{
		// Oui, son click a déjà été pris en compte
	}
	
} else
{
	// Pas de référents
}
?>
