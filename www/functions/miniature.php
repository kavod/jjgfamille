<?php
 
   /******************************/
  /*       Miniature.php        */
 /*    par Boris Kavod         */
/******************************/

/***************************************************************************************************************

Cette page doit etre appellée avec <img src="miniature.php?tnH=112&url=<? echo $url_de_l_image; ?>">
A noter aussi : il faut définir la variable TAILLE_MINI avec la taille minimum que doit prendre
l'image en hauteur/largeur.
cad : si c'est une image en portrait : la hauteur sera à TAILLE_MINI et la largeur sera réduite proportionnellement
idem : si c'est une image en paysage, la largeur sera à TAILLE_MINI et la hauteur réduite proportionnellement.

*****************************************************************test.php***********************************************/

define('IN_PHPBB', true);
define("TAILLE_MINI",100);  // C'est ici qu'il faut changer la TAILL_MINI
$phpbb_root_path = '../';

require_once('functions.php');

switch($_GET['mode'])
{
	case 'nojack':
		$url = '../images/disco/nojack.';
		$ext = find_image($url);
		$url .= $ext;
		break;
		
	case 'edito':
		$edito_id = $_GET['edito_id'];
		$url = '../images/edito/edito_' . $edito_id  . '.';
		$ext = find_image($url);
		$url .= $ext;
		break;
		
	case 'disco':
		$album_id = $_GET['album_id'];
		$jack_id = $_GET['jack_id'];
		$url = '../images/disco/jack_' . $album_id . '_' . $jack_id . '.';
		$ext = find_image($url);
		$url .= $ext;
		break;
	
	case 'photo':
		$cate_id = $_GET['cate_id'];
		$photo_id = $_GET['photo_id'];
		$url = '../images/photos/photo_' . $cate_id . '_' . $photo_id . '.';
		$ext = find_image($url);
		$url .= $ext;
		break;
		
	case 'liens':
		$site_id = $_GET['site_id'];
		$url = '../images/liens/logo_' . $site_id .'.';
		$ext = find_image($url);
		$url .= $ext;
		break;
		
	case 'bio':
		$bio_id = $_GET['bio_id'];
		$url = '../images/bio/bio_' . $bio_id . '.';
		$ext = find_image($url);
		$url .= $ext;
		break;	
	
	case 'biblio':
		$livre_id = $_GET['livre_id'];
		$illu_id = $_GET['illu_id'];
		$url = '../images/biblio/livre_' . $illu_id . '_' . $livre_id . '.';
		$ext = find_image($url);
		$url .= $ext;
		break;
	
	case 'medias':
		$emission_id = $_GET['emission_id'];
		$illu_id = $_GET['illu_id'];
		$url = '../images/medias/illustration_' . $emission_id . '_' . $illu_id . '.';
		$ext = find_image($url);
		$url .= $ext;
		break;		
	case 'report':
		$photo_id = $_GET['photo_id'];
		$report_id = $_GET['report_id'];
		$url = '../images/report/photo_' . $report_id . '_' . $photo_id . '.';
		$ext = find_image($url);
		$url .= $ext;
		break;
	case 'tournees_billets':
		$billet_id = $_GET['billet_id'];
		$tournee_id = $_GET['tournee_id'];
		$url = '../images/tournees/billet_' . $tournee_id . '_' . $billet_id . '.';
		$ext = find_image($url);
		$url .= $ext;
		break;
	case 'tournees':
		$photo_id = $_GET['photo_id'];
		$concert_id = $_GET['concert_id'];
		$url = '../images/tournees/concert_' . $concert_id . '_' . $photo_id . '.';
		$ext = find_image($url);
		$url .= $ext;
		break;
	case 'more':
		$more_id = $_GET['more_id'];
		$url = '../images/goodies/goodies_' . $more_id . '.';
		$ext = find_image($url);
		$url .= $ext;
		break;
	case 'rdn':
		$rdn_id = $_GET['rdn_id'];
		$url = '../images/rdn/rdn_' . $rdn_id . '.';
		$ext = find_image($url);
		$url .= $ext;
		break;
	case 'rdf':
		$photo_id = $_GET['photo_id'];
		$rdf_id = $_GET['rdf_id'];
		$url = '../images/rdf/photo_' . $rdf_id . '_' . $photo_id . '.';
		$ext = find_image($url);
		$url .= $ext;
		break;
	case 'famille':
		$rub_id = $_GET['rub_id'];
		$url = '../images/famille/rub_' . $rub_id . '.';
		$ext = find_image($url);
		$url .= $ext;
		break;
	case 'code':
		$question_id = $_GET['question_id'];
		$url = '../images/permis/question_' . $question_id . '.';
		$ext = find_image($url);
		$url .= $ext;
		break;
	case 'artist':
		$artist_id = $_GET['artist_id'];
		$url = '../images/disco/photo_artist_' . $artist_id.'.';
		$ext = find_image($url);
		$url .= $ext;
		break;
	case 'concours':
		$concours_id = $_GET['concours_id'];
		$url = '../images/more/concours_' . $concours_id;
		$ext = find_image($url);
		$url .= '.' . $ext;
		break;
	default:
                $im = imagecreate(150, 30); /* Création d'une image blanche */
		$bgc = imagecolorallocate($im, 255, 255, 255);
		$tc  = imagecolorallocate($im, 0, 0, 0);
		imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

	// Affichage d'un message d'erreur
		imagestring($im, 1, 5, 5, "Erreur de chargement de l'image $imgname", $tc);
		exit();
}
function loadjpeg($imgname,$ext) 
{
	switch($ext)
	{
		case 'jpg':
		case 'jpeg':
			$im = @imagecreatefromjpeg($imgname); /* Tentative d'ouverture */
			break;
		case 'gif':
			$im = @imagecreatefromgif($imgname);
			break;
		case 'png':
			$im = @imagecreatefrompng($imgname);
			break;
		default:
			$im = false;

	}
return $im;
}
if (!isset($_GET['tnH']))
{
       $tnH = TAILLE_MINI;
} else $tnH = $_GET['tnH'];

$src_im = loadjpeg($url,$ext);

if(!$src_im)
{
	$im = @imagecreatefrompng('../templates/jjgfamille/images/site/px.png'); 
	header("Content-type: image/png");
	imagepng($im);
	exit();	
}

$size[0] = imagesx($src_im); 
$size[1] = imagesy($src_im);
if ($size[0] <= $size[1]) 
{
	$destW = $size[0]*$tnH/$size[1]; 
	$destH = $tnH; 
} else
{
	$destH = $size[1]*$tnH/$size[0]; 
	$destW = $tnH; 
}	

$dest = imagecreatetruecolor($destW, $destH); 
imagecopyresampled ( $dest, $src_im, 0, 0, 0, 0, $destW, $destH, $size[0],$size[1]); 
header("Content-type: image/jpeg");
imagejpeg($dest,"",80);
imagedestroy($dest);
imagedestroy($src_im);

?>
