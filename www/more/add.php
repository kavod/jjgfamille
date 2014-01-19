<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'more';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/emailer.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_MORE);
init_userprefs($userdata);
//
// End session management
//

include($phpbb_root_path . 'includes/log_necessary.php');

/**
 * Fonction permettant l'upload facile d'un fichier sur le FTP anonyme
 * @param $error référence au booléen indiquant une erreur
 * @param $error_msg référence sur le message d'erreur
 * @param $filename Chemin du fichier temporaire (obtenu avec $_FILE['user_file']['tmp_name'] voir fonction suivante)
 * @param $realname Nom réel du fichier sur le poste source (obtenu avec $FILE['user_file']['name'])
 * @param $filesize Taille du fichier en octet (obtenu avec $FILE['user_file']['size'])
 * @param $filetype Type de fichier (obtenu avec $_FILE['user_file']['type'])
 * @param $dest Destination du fichier ATTENTION : *AVEC* L'EXTENSION
 * @param $max_size Taille maximale du fichier autorisée(200ko par défault)
 *
 */
 
function upload_ftp_anon(&$error, &$error_msg, $filename, $realname, $filesize, $filetype,$dest,$max_size = 204800)
{
	global $board_config, $site_config,$db, $lang,$phpbb_root_path,$ftp_anon_server,$ftp_anon_login,$ftp_anon_password;
	$ini_val = ( @phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';
	
	if ( $filesize <= $max_size && $filesize > 0 )
	{
		//preg_match('#.*\.(r[a|m])$/',$filename,$filetype);
		//$filetype = $filetype[1];	
	}
	else
	{
		$l_size = sprintf($lang['too_weight_file'], round($max_size / 1024)).' et il fait ' .  round($filesize / 1024) . "ko";

		$error = true;
		$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_size : $l_size;
		return;
	}
		
	$conn_id = ftp_connect($ftp_anon_server); 
	$login_result = ftp_login($conn_id, $ftp_anon_login, $ftp_anon_password); 
	// Vérification de la connexion
	if ((!$conn_id) || (!$login_result)) 
	{
		$error = true;
		$error_msg = "La connexion FTP a échoué !";
	}
	
	// Chargement d'un fichier
	@$upload = ftp_put($conn_id, $dest.$realname, $filename, FTP_BINARY);
	
	// Vérification du status du chargement
	if (!$upload) 
	{
		$error = true;
		$error_msg = "Le chargement FTP a échoué!";
	}
	
	// Fermeture du flux FTP
	ftp_close($conn_id); 
		
	@chmod( $dest.$filename , 0777);


	return;
}
// fin de la fonction


if($_GET['mode']=='add')
{
	$error = false;
	$error_msg = '';

	if(!isset($_POST['title']))
		list($error,$error_msg) = array (true,'Erreur de transmission des variables');
	$title = $_POST['title'];
	if($title == '')
    		list($error,$error_msg) = array (true,"Le champ 'Nom' est obligatoire");

	$userfile = $_FILES['userfile']['tmp_name'];
	$file = $_FILES['userfile']['name'];
	$userfile_size = $_FILES['userfile']['size'];
        $extension = substr($file,strrpos($file,'.')+1);
	$MFS=1024*200;

        if(!isset($_POST['description']))
		list($error,$error_msg) = array (true,"Erreur de transmission des variables");
	$description = $_POST['description'];
	if($description == '')
    		list($error,$error_msg) = array (true,"Le champ 'Description' est obligatoire");        
                 
	if(!isset($_POST['cate_id']))
		list($error,$error_msg) = array (true,"Erreur de transmission des variables");
	$cate_id = $_POST['cate_id']; 
	if($cate_id == '')
    		list($error,$error_msg) = array (true,"Le champ 'Categorie' est obligatoire");                
         

	$user_id = $userdata['user_id']; 
	$username = $userdata['username'];      
	
	$bbcode_uid = make_bbcode_uid();
        $description = bbencode_first_pass($description,$bbcode_uid);
        	       
        if(!$error)
	{
		$sql_insert = "INSERT more (title,file,description,cate_id,user_id,username,bbcode_uid,enable,date_add) VALUES ('". $title ."','". $file ."','". $description ."','". $cate_id ."','". $user_id ."','". $username ."','". $bbcode_uid ."','N','". Date('Ymd') ."')";
		mysql_query($sql_insert) or list($error,$error_msg) = array (true,"Erreur durant l'enregistrement<br>Requete sql ".$sql_insert);
		logger("Ajout du goodies $file");
		
		$more_id = mysql_insert_id();

		if(!$error)
		{
			upload_ftp_anon($error, $error_msg, $userfile, $file, $userfile_size, $_FILES['userfile']['type'],'goodies/',$MFS);
 	               /*if($userfile_size>0 && $userfile_size < $MFS)
                        {
                           if(!move_uploaded_file($userfile,"../goodies/".$file))
		   	    {*/
		   	if ($error)
		   	{
		   	             //list($error,$error_msg) = array (true,"Echec de l'upload du fichier");
				     $sql_delete = "DELETE FROM more WHERE more_id = " .$more_id;
				     mysql_query($sql_delete) or list($error,$error_msg) = array (true,"Echec de la suppression apres echec de l'upload<br>Requete sql".$sql_delete);
				     logger("Suppression du goodies $file apres echec de l'upload");
		            }

                        /*} else if($userfile_size > 0)
			{
				$MFS = $MFS / 1024;
				$size = round($userfile_size / 1024);
				list($error,$error_msg) = array( true , "Fichier trop volumineux : ".$size." alors que seuls ".$MFS." ko sont autorisés");
				$sql_delete = "DELETE FROM more WHERE more_id = " .$more_id;
				mysql_query($sql_delete) or list($error,$error_msg) = array (true,"Echec de la suppression apres echec de l'upload<br>Requete sql".$sql_delete);
			        logger("Suppression du goodies $file apres echec de l'upload");
                        } else
			{
				
				list($error,$error_msg) = array( true , "Aucun fichier réceptionné");
				$sql_delete = "DELETE FROM more WHERE more_id = " .$more_id;
				mysql_query($sql_delete) or list($error,$error_msg) = array (true,"Echec de la suppression apres echec de l'upload<br>Requete sql".$sql_delete);
			        logger("Suppression du goodies $file apres echec de l'upload");
			}*/
			
			   if(!$error)
			   {
			    	     if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'gif' || $extension == 'png')
			    	     {
			    	      	   copy($userfile,'../images/goodies/goodies_'.$more_id.'.'.$extension);
			    	      	 	   
			    	     }
			   }								
		}
        }

	if(!$error)
	{
				
 			// Envoi du mail aux responsables
			$sql_responsable = "SELECT B.* FROM famille_access A, phpbb_users B WHERE A.user_id = B.user_id AND A.rub = 'more'";
			$result_responsable = mysql_query($sql_responsable) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />" . $sql_responsable);
			
			$message = "Le goodies ".$file." appellé ".$title." a été rajouté par ".$username." dans la rubrique En ++\r\n";
												
			while ($val_responsable = mysql_fetch_array($result_responsable))
			{

				$emailer = new emailer($board_config['smtp_delivery']);
				$emailer->from($board_config['board_email']);
				$emailer->replyto($board_config['board_email']);
				$emailer->use_template('email_notify',"french");
				$emailer->email_address($val_responsable['user_email']);
				$emailer->set_subject($lang['Notification_subject']);
					
				$emailer->assign_vars(array(
					'SUBJECT' => "Notification d'activité de la rubrique 'En ++'",
					'USERNAME' => $val_responsable['username'], 
					'EMAIL_SIG' => "-- \nL'équipe d'administration de JJG Famille",
					'MESSAGE' => $message,
				));

				$emailer->send();
				$emailer->reset();
	
			}


                                $template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="5;url=' . append_sid("index." . $phpEx) . '">')
				);
				$message =  sprintf($lang['Upload_goodies_ok'], '<a href="' . append_sid("index." . $phpEx) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);			
	}

}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='more' ORDER BY user_id");

//
//Liste des categories
//
$tab_cate = select_liste("SELECT * FROM more_cate ORDER BY ordre");
//
//Liste des categories
//
$tab_options = select_liste("SELECT * FROM more_cate WHERE cate_name <> 'Jeux' ORDER BY ordre");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_more'],'more');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['EnPlusPlus'].' :: '.$lang['add_more'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);



$template->set_filenames(array(
	'body' => 'site/more/add.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/more/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;	
					
$template->assign_vars(array(

				'NOM_RUB' => $lang['EnPlusPlus'],
				"RESPONSABLES" => $lang['Responsables'],
				"L_LISTE" => $lang['liste_cate'],
				"IMG_MASCOTTE" => $mascotte,
				'L_RETOUR'=> $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'more/index.php'),
				'AJOUT_MORE' => $lang['add_more'],
				'SELECT_CATE' => $lang['Select_a_category'],
				'L_TITLE' => $lang['Titre'],
				'L_DESC' => $lang['Description'],
				'L_FILE' =>  $lang['Chemin du fichier'],
				'L_CATE' =>  $lang['categories'],
				'L_SUBMIT' =>  $lang['Submit'],
				'U_FORM' => append_sid($phpbb_root_path . 'more/add.php?mode=add'),
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'more/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}
			
for ($i=0;$i<count($tab_access);$i++)
{
	$val_access = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_access[$i]['user_id']."  LIMIT 0,1",'',false);
	$template->assign_block_vars('switch_access',array(
						'U_RESP' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$val_access['user_id']),
						'RESP' => $val_access['username']
						)
					);
}

for ($i=0;$i<count($tab_cate);$i++)
{
	$url = $phpbb_root_path . 'more/';
	$url .= ($tab_cate[$i]['filename'] == '') ? 'view_cate.php?cate_id='.$tab_cate[$i]['cate_id'] : $tab_cate[$i]['filename'];
	$template->assign_block_vars('switch_cate',array(
						'U_CATE' => append_sid($url),
						'L_CATE' => $tab_cate[$i]['cate_name'],
						)
					);
}

for ($i=0;$i<count($tab_options);$i++)
{
	
	$template->assign_block_vars('switch_options',array(
						'VALUE' => $tab_options[$i]['cate_id'],
						'INTITULE' => $tab_options[$i]['cate_name'],
						)
					);
}

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('more','opif');
if ($sitopif)
	$template->assign_block_vars('switch_opif', $sitopif );


if ( $error )
{
	$template->set_filenames(array(
		'reg_header' => 'error_body.tpl')
	);
	$template->assign_vars(array(
		'ERROR_MESSAGE' => $error_msg)
	);
	$template->assign_var_from_handle('ERROR_BOX', 'reg_header');
}

$template->assign_var_from_handle('OPIF', 'opif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>

