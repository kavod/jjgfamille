<?

/*
Les paramètres de la fonction sont :
- imgSource : OBLIGATOIRE chemin de l'image à tagger
- imgTag : OBLIGATOIRE
- S'il s'agit d'un chemin, ce sera celui de l'image servant de tag
- S'il s'agit d'une chaîne de caractère de la forme "votre texte:rouge|vert|bleu", "votre texte" sera tagé sur l'image avec une couleur définie par les proportions de rouge, vert et bleu. On peu la tagger sur plusieurs lignes en utilisant la balise <br>
- destination : OBLIGATOIRE chemin de l'image qui sera créé
- X : OBLIGATOIRE
- Si c'est un nombre : abscisse du coin supérieur gauche du tag dans l'image
- Peut prendre comme valeur "left" ou "right" et le tag sera dans un coin gauche ou droit de l'image
- Peut prendre comme valeur middle et le tag sera centré
- Si c'est un nombre définie comme une chaîne de caractère ( entre guillemet ) : l'image est positionné à un pourcentage de l'image égal au nombre entre guillemet ( EX : $X = "50" positionnera le tag au milieu de l'image )
- Y : OBLIGATOIRE
- Idem que X sauf qu'il s'agit de l'ordonnée du coin supérieur gauche du tag
- Les valeurs pour définir une image dans un coin sont "up" et "down"
- largeur et hauteur : OPTIONNEL
- S'il ne sont pas précisés : le tag n'est pas redimmensionné avant d'être inséré dans l'image
- Si ce sont des nombres : largeur et hauteur du tag dans l'image
- Si ce sont des nombres définies comme des chaîne de caractère ( entre guillemet ) : l'image est redimmensionnée en prenant la valeur dans lachaîne comme pourcentage ( EX : $largeur = "50" donnera au tag une largeur équivalente à 50% de la largeur de l'image d'origine )
- Si un seul des deux est précisé, le script donne à l'autre la valeur nécéssaire pour que le tag ne soit pasdéformé
- distance : OPTIONNEL
- Dans le cas d'un X ou Y définie par une chaine de caractère ( up down left ou right ), distance du tag par rapport au bord de l'image

Si vous ne souhaitez pas définir les paramètres optionnels , remplacez les par NULL dans l'appel de la fonction

La fonction retourne le chemin vers l'image créée.

*/

function tag($imgSource,$imgTag,$destination,$X,$Y,$largeur,$hauteur,$distance) {
    
    //Récupère les info sur les images utilisées
        $sourceSize = getimagesize($imgSource);
        $sourceWidth = $sourceSize[0];
        $sourceHeight = $sourceSize[1];
        @$tagSize = getimagesize($imgTag); //Les @ servent à éviter un message d'erreur si le tag est une chaine de caractère
        @$tagWidth = $tagSize[0];
        @$tagHeight = $tagSize[1];

    //Crée l'image et sélectionne l'image source et le tag
       $img = imagecreatetruecolor($sourceWidth,$sourceHeight);
        $source = imagecreatefrompng($imgSource);

        //Si le tag est une chaine de caractère
        if( strpos($imgTag,"@") ) {
             $fontHeight = imagefontheight(5);  $fontWidth = imagefontwidth(5);
             list( $texte , $color ) = explode("@",$imgTag) ;
             //Si elle doit être affiché sur plusieurs lignes
             if( strpos($texte,"<br>")) {
                 $temptexte = $texte;
                 $nbrlign = 0; $maxpos = 0;
                 while( $pos = strpos($temptexte,"<br>") ) {
                     if( $pos > $maxpos ) $maxpos = $pos ;
                     $ligntexte[] = substr($temptexte,0,$pos);
                     $temptexte = substr($temptexte,$pos+4);
                     $nbrlign ++;
                     }
                 $ligntexte[] = $temptexte;
                 $largeur = $tagWidth = $fontWidth * $maxpos;
                 $hauteur = $tagHeight = $fontHeight * ($nbrlign+1) ;
            //Si une seule ligne suffit
                } else {
                 $largeur = $tagWidth = $fontWidth * strlen($texte) ;
                 $hauteur = $tagHeight = $fontHeight * count($texte);
                }
        //Création de l'image tag avec dedans le texte
             list( $red , $green , $blue ) = explode("|",$color) ;
             $tag = imagecreatetruecolor($tagWidth,$tagHeight);
             $col = imagecolorallocate($tag,$red,$green,$blue);
             $coltransp = imagecolorallocate($tag,0,0,0);
             $transp = imagecolortransparent($tag,$coltransp);
            imagefill($tag,0,0,$coltransp);
             if(isset($ligntexte)) {
                for($x=0;$x<count($ligntexte);$x++) {
                     $abscisse = $fontWidth * ( ( $maxpos / 2 ) - ( strlen($ligntexte[$x] ) / 2 ) );
                     imagestring($tag,5,$abscisse,$fontHeight*($x),$ligntexte[$x],$col);
                     }
             } else imagestring($tag,5,0,0,$texte,$col);
             $stringType = TRUE;
             }
        //Si c'est une image png ou jpg
        elseif( strpos($imgTag,".jpg") ) $tag = imagecreatefromjpeg($imgTag);
        elseif( strpos($imgTag,".png")) $tag = imagecreatefrompng($imgTag);
        elseif( strpos($imgTag,".gif")) $tag = imagecreatefromgif($imgTag);

    //Donne ou calcule des données par défault si elles n'ont pas été précisées
        if( isset($largeur) && empty($hauteur) ) {
                @$hauteur = ( $tagHeight / $tagWidth ) * $largeur ;
                }
        elseif( isset($hauteur) && empty($largeur) ) {
                $largeur = ( $tagWidth / $tagHeight ) * $hauteur ;
                }
        if( empty($distance) ) $distance = 10 ;
        $largeur = empty($largeur) ? $tagWidth : $largeur ;
        $hauteur = empty($hauteur) ? $tagHeight : $hauteur ;

    //Si la taille du tag est définie comme un pourcentage, calcul de la taille du tag
        if( is_string($largeur) ) { $largeur = ( $tagWidth / 100 ) * $largeur ; $largeur = ( int ) $largeur ; }
        if( is_string($hauteur) ) { $hauteur = ( $tagHeight / 100 ) * $hauteur ; $hauteur = ( int ) $hauteur ; }

    //Donne la position du tag s'il a été définie par sa position sur l'image
        switch($Y) {
                case "up" :
                         $Y = $distance ; break ;
                case "down" :
                         $Y = $sourceHeight - $hauteur - $distance ; break ;
                case "middle" :
                         $Y = ( $sourceHeight / 2 ) - ( $hauteur / 2 ) ; break ;
                }

        switch($X) {
                case "left" :
                        $X = $distance ; break;
                case "right" :
                        $X = $sourceWidth - $largeur - $distance ; break ;
                case "middle" :
                        $X = ( $sourceWidth / 2 ) - ( $largeur / 2 ) ; break ;
                }

    //Donne la position du tag s'il a été définie par un pourcentage de l'image
        if( is_string( $X ) ) { $X = ( $sourceWidth / 100 ) * $X ; $X = ( int ) $X ; }
        if( is_string( $Y ) ) { $Y = ( $sourceHeight / 100 ) * $Y ; $Y = ( int ) $Y ; }

    //Dessine l'image
        imagecopy($img,$source,0,0,0,0,$sourceWidth,$sourceHeight) or die("Problème avec la copie de l'image source");
        if( isset($stringType) ) imagecopymerge($img,$tag,$X,$Y,0,0,$tagWidth,$tagHeight,100);
        else imagecopyresampled($img,$tag,$X,$Y,0,0,$largeur,$hauteur,$tagWidth,$tagHeight) or die("Problème avec l'insertion du tag");

     //Enregistrement de l'image
        if( strpos($destination,"png") ) imagepng($img,$destination) ;
        elseif( strpos($destination,"jpg") ) imagejpeg($img,$destination) ;
        else imagepng($img) ;

        return $destination;
        }
        
function permis()
{

global $phpbb_root_path,$userdata;

$permis = $phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png';
if(is_file($permis))
	unlink($permis);

//Ok au depart on a notre image vierge "permis.png"  

//On tag le pseudo et on créee en meme temps le permis du user
$tag = tag($phpbb_root_path.'images/permis/permis.png','Pseudo : '.$userdata['username'].'@50|50|50',$phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',20,50,NULL,NULL,NULL);
//On tag le domicile
$tag = tag($phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png','Domicile : 17 rue Leidenstadt<br>   En passant@50|50|50',$phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',20,85,NULL,NULL,NULL);
//On tag le "delivré par"
$tag = tag($phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png','Délivré par@50|50|50',$phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',20,150,NULL,NULL,NULL);
//On tag le logo famille a coté de "délivré par"
$tag = tag($phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',$phpbb_root_path.'images/permis/copyright.png',$phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',140,135,NULL,NULL,NULL);
//On tag "A Paris"
$tag = tag($phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png','A Paris@50|50|50',$phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',20,168,NULL,NULL,NULL);
//On tag la date du jour
$tag = tag($phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png','Le '.date_unix(time(),'jour').'@50|50|50',$phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',20,185,NULL,NULL,NULL);
//On tag "Signature"
$tag = tag($phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png','Signature:@50|50|50',$phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',20,240,NULL,NULL,NULL);
//On tag une photo de jjg
$tag = tag($phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',$phpbb_root_path.'images/permis/jjg.jpg',$phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',"left","down",NULL,NULL,NULL);
//On tag la signature de jjg
$tag = tag($phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',$phpbb_root_path.'images/permis/signature.png',$phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',40,270,NULL,NULL,NULL);
//On l'avatar sinon rien !! 			
if (is_file('../images/forum/avatars/' . $userdata['user_avatar']))
	$tag = tag($phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',$phpbb_root_path.'images/forum/avatars/'.$userdata['user_avatar'],$phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',190,190,NULL,NULL,NULL);
else
	$tag = tag($phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',$phpbb_root_path.'images/permis/non_dispo.gif',$phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',160,180,NULL,NULL,NULL);
//On retourne la destination de l'image finale	
return $tag;

}
        
?>