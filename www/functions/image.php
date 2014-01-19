<?php
define('IN_PHPBB', true); 
require_once('functions.php');
$phpbb_root_path = '../';
// on spécifie le type de fichier créer (ici une image de type jpeg) 
header ("Content-type: image/png");   

switch($_GET['mode'])
{
	case "photos":
		if (!isset($_GET['cate_id']))
			die("Erreur de transmission de variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id=="")
			die("Le champs 'cate_id' est obligatoire");
			
		if (!isset($_GET['photo_id']))
			die("Erreur de transmission de variables");
		$photo_id = $_GET['photo_id'];
		if ($photo_id=="")
			die("Le champs 'photo_id' est obligatoire");
		
		$ext = find_image($phpbb_root_path . "images/photos/photo_".$cate_id."_".$photo_id.".");
		$fichier_source = $phpbb_root_path . "images/photos/photo_".$cate_id."_".$photo_id.".".$ext;
		break;
	case "disco":
		if (!isset($_GET['jack_id']))
			die("Erreur de transmission de variables");
		$jack_id = $_GET['jack_id'];
		if ($jack_id=="")
			die("Le champs 'jack_id' est obligatoire");
			
		if (!isset($_GET['album_id']))
			die("Erreur de transmission de variables");
		$album_id = $_GET['album_id'];
		if ($album_id=="")
			die("Le champs 'album_id' est obligatoire");
		$ext = find_image($phpbb_root_path . "images/disco/jack_".$album_id."_".$jack_id.".");
		$fichier_source = $phpbb_root_path . "images/disco/jack_".$album_id."_".$jack_id.".".$ext;
		break;
	case "biblio":
		if (!isset($_GET['illu_id']))
			die("Erreur de transmission de variables");
		$illu_id = $_GET['illu_id'];
		if ($illu_id=="")
			die("Le champs 'illu_id' est obligatoire");
			
		if (!isset($_GET['livre_id']))
			die("Erreur de transmission de variables");
		$livre_id = $_GET['livre_id'];
		if ($livre_id=="")
			die("Le champs 'livre_id' est obligatoire");
		
		$ext = find_image($phpbb_root_path . "images/biblio/livre_".$illu_id."_".$livre_id.".");
		$fichier_source = $phpbb_root_path . "images/biblio/livre_".$illu_id."_".$livre_id.".".$ext;
		break;
	case "bio":			
		if (!isset($_GET['bio_id']))
			die("Erreur de transmission de variables");
		$bio_id = $_GET['bio_id'];
		if ($bio_id=="")
			die("Le champs 'bio_id' est obligatoire");
		
		$ext = find_image($phpbb_root_path . "images/bio/bio_".$bio_id.".");
		$fichier_source = $phpbb_root_path . "images/bio/bio_".$bio_id.".".$ext;
		break;
	case "tournee":			
		if (!isset($_GET['tournee_id']))
			die("Erreur de transmission de variables");
		$tournee_id = $_GET['tournee_id'];
		if ($tournee_id=="")
			die("Le champs 'tournee_id' est obligatoire");
		if (!isset($_GET['billet_id']))
			die("Erreur de transmission de variables");
		$billet_id = $_GET['billet_id'];
		if ($billet_id=="")
			die("Le champs 'billet_id' est obligatoire");	
		
		$ext = find_image($phpbb_root_path . "images/tournees/billet_".$tournee_id."_".$billet_id.".");
		$fichier_source = $phpbb_root_path . "images/tournees/billet_".$tournee_id."_".$billet_id.".".$ext;
		break;
	case "concert":			
		if (!isset($_GET['concert_id']))
			die("Erreur de transmission de variables");
		$concert_id = $_GET['concert_id'];
		if ($concert_id=="")
			die("Le champs 'concert_id' est obligatoire");
		if (!isset($_GET['photo_id']))
			die("Erreur de transmission de variables");
		$photo_id = $_GET['photo_id'];
		if ($photo_id=="")
			die("Le champs 'photo_id' est obligatoire");	
		
		$ext = find_image($phpbb_root_path . "images/tournees/concert_".$concert_id."_".$photo_id.".");
		$fichier_source = $phpbb_root_path . "images/tournees/concert_".$concert_id."_".$photo_id.".".$ext;
		break;
	case "report":			
		if (!isset($_GET['report_id']))
			die("Erreur de transmission de variables");
		$report_id = $_GET['report_id'];
		if ($report_id=="")
			die("Le champs 'report_id' est obligatoire");
		if (!isset($_GET['photo_id']))
			die("Erreur de transmission de variables");
		$photo_id = $_GET['photo_id'];
		if ($photo_id=="")
			die("Le champs 'photo_id' est obligatoire");	
		
		$ext = find_image($phpbb_root_path . "images/report/photo_".$report_id."_".$photo_id.".");
		$fichier_source = $phpbb_root_path . "images/report/photo_".$report_id."_".$photo_id.".".$ext;
		break;
	case 'medias':
		if (!isset($_GET['emission_id']))
			die("Erreur de transmission de variables");
		$emission_id = $_GET['emission_id'];
		if ($emission_id=="")
			die("Le champs 'emission_id' est obligatoire");
		if (!isset($_GET['illu_id']))
			die("Erreur de transmission de variables");
		$illu_id = $_GET['illu_id'];
		if ($illu_id=="")
			die("Le champs 'illu_id' est obligatoire");
		
		$ext = find_image($phpbb_root_path . "images/medias/illustration_".$emission_id."_".$illu_id.".");
		$fichier_source = $phpbb_root_path . "images/medias/illustration_".$emission_id."_".$illu_id.".".$ext;
		break;
	case "rdf":
		if (!isset($_GET['rdf_id']))
			die("Erreur de transmission de variables");
		$rdf_id = $_GET['rdf_id'];
		if ($rdf_id=="")
			die("Le champs 'rdf_id' est obligatoire");
			
		if (!isset($_GET['photo_id']))
			die("Erreur de transmission de variables");
		$photo_id = $_GET['photo_id'];
		if ($photo_id=="")
			die("Le champs 'photo_id' est obligatoire");
		
		$ext = find_image($phpbb_root_path . "images/rdf/photo_".$rdf_id."_".$photo_id.".");
		$fichier_source = $phpbb_root_path . "images/rdf/photo_".$rdf_id."_".$photo_id.".".$ext;
		break;
	case 'concours':
		if (!isset($_GET['concours_id']))
			die("Erreur de transmission de variables");
		$concours_id = $_GET['concours_id'];
		if ($concours_id=="")
			die("Le champs 'concours_id' est obligatoire");
			
		$img = $phpbb_root_path . 'images/more/concours_' . $_GET['concours_id'];
		$ext = find_image($img);

		$fichier_source = $img . "." . $ext;
		break;
	default:
		die('mode inconnu');
}

$fichier_copyright = $phpbb_root_path . "images/copyright_flou.png"; 

// on crée nos deux ressources de type image (par le biais de la fonction ImageCreateFromJpeg) 
//$im_source = ImageCreateFromJpeg ($fichier_source);

switch($ext)
{
	case 'jpg':
	case 'jpeg':
		$im_source = @imagecreatefromjpeg($fichier_source); 
		$dest = @imagecreatefromjpeg($fichier_source);
		break;
	
	case 'gif':
		$im_source = @imagecreatefromgif($fichier_source);
		$dest = @imagecreatefromgif($fichier_source);
		break;
	case 'png':
		$im_source = @imagecreatefrompng($fichier_source);
		$dest = @imagecreatefrompng($fichier_source);
		break;
	default:
		$im_source = false;
		$dest = false;
}

if(!$im_source || !$dest)
{
	$im = imagecreatefrompng('../templates/jjgfamille/images/site/px.png'); 
	header("Content-type: image/png");
	imagepng($im);
	exit();	
}
	
$im_copyright = ImageCreateFromPNG ($fichier_copyright); 


// on calcule la largeur de l'image qui va être copyrightée 
$larg_destination = imagesx ($im_source); 
$haut_destination = imagesy ($im_source);

// on calcule la largeur de l'image correspondant à la vignette de copyright 
$larg_copyright = imagesx ($im_copyright); 
// on calcule la hauteur de l'image correspondant à la vignette de copyright 
$haut_copyright = imagesy ($im_copyright); 

/* Début modif */

$ratio=1/5;

if ($larg_destination/$larg_copyright>$haut_destination/$haut_copyright)
{
	// Calcul de la taille destination du copyright
	$haut_final=$haut_destination*2*$ratio;
	$larg_final=$larg_copyright*$haut_final/$haut_copyright;
} else
{
	$larg_final=$larg_destination*2*$ratio;
	$haut_final=$haut_copyright*$larg_final/$haut_copyright;
}
// Initialisation des variables temporaires
// ImageC : partie découpée de l'image source correspondant à l'emplacement de destination du copyright
$imageC=imagecreatetruecolor($larg_final,$haut_final);
// ImageD : le copyright mis aux dimentions finales
$imageD=imagecreate($larg_final,$haut_final);
// ImageE : fusion de C et D


// Découpage de la partie destination du copyright
imagecopy($imageC,$im_source,0,0,($larg_destination-$larg_final)/2,($haut_destination-$haut_final)/2,$larg_final,$haut_final);

// Création du copyright redimentionné
//$dest = ImageCreateFromjpeg ($fichier_source); 
$alpha = imagecolorallocatealpha($dest, 255,255,255, 127);
imagefilledrectangle($dest, ($larg_destination-$larg_final)/2,($haut_destination-$haut_final)/2, $larg_final, $haut_final, $alpha);
imagecopyresampled ( $dest, $im_copyright, ($larg_destination-$larg_final)/2,($haut_destination-$haut_final)/2, 0,0, $larg_final, $haut_final, $larg_copyright, $haut_copyright); 

imagecopymerge($im_source,$im_copyright,$larg_destination*(1/2-$ratio),$haut_destination*(1/2-$ratio),0,0,$larg_final,$haut_final,100);

Imagepng($dest);

?>