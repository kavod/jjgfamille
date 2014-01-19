<?php
$nickname = "jjgfamille";
$ip = "irc.worldnet.net";
$port = 6667;
$channel = '#ensemble';

function ircg_pconnect($nickname, $ip, $port)
{
	$fp = fsockopen($ip, $port, $errno, $errstr, 5);
	if (!$fp) {
		echo "$errstr ($errno)<br />\n";
	} 
	else 
	{
		$out = "NICK salmioc\r\n";
		$out .= "USER $nickname \"localhost\" \"irc_server\" :salemioche\r\n\r\n";
		
		fwrite($fp, $out);
		stream_set_timeout($fp, 2);
		$my_time = time();
		while(!feof($fp) && time()-$my_time < 5) 
		{
			echo fgets($fp, 128);
			echo "<br />";
		}
		fclose($fp);
	}
	return $fp;
}

// Connexion au serveur
$id = ircg_pconnect($nickname, $ip, $port);

function ircg_list($id,$channel)
{
	if (!$fp) {
		echo "$errstr ($errno)<br />\n";
	} 
	else 
	{
		$out = "QLIST $channel\r\n\r\n";
		
		fwrite($fp, $out);
		$my_time = time();
		while(!feof($fp) && time()-$my_time < 5) 
		{
			$result = fgets($fp, 128);
			if (preg_match('|:.* 322 .* #' . $channel . ' (\d+) :(.*)|i',$result,$matches))
				$my_result = "************ " . $matches[1] . " : " . $matches[2] . "<br />";
			echo $result; 
			echo "<br />";
		}
		fclose($fp);
	}
	return $my_result;
}
// envoie une commande list
echo ircg_list($id, $channel);

/*
// définition d'un fichier pour l'affichage
ircg_set_file($id, 'irc_output.html');

// essai de rejoindre un canal
if (!ircg_join($id, $channel)) {
    echo "Echec de /join $channel<br />";
}

// envoie une commande list
ircg_list($id, $channel);

// attente pour l'affichage
sleep(5);

// déconnexion
ircg_disconnect($id,'Au revoir le monde !');

// affichage de n'importe quoi
readfile('irc_output.html');
*/
?> 