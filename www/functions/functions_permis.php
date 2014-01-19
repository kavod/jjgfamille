<?

/*
Les param�tres de la fonction sont :
- imgSource : OBLIGATOIRE chemin de l'image � tagger
- imgTag : OBLIGATOIRE
- S'il s'agit d'un chemin, ce sera celui de l'image servant de tag
- S'il s'agit d'une cha�ne de caract�re de la forme "votre texte:rouge|vert|bleu", "votre texte" sera tag� sur l'image avec une couleur d�finie par les proportions de rouge, vert et bleu. On peu la tagger sur plusieurs lignes en utilisant la balise <br>
- destination : OBLIGATOIRE chemin de l'image qui sera cr��
- X : OBLIGATOIRE
- Si c'est un nombre : abscisse du coin sup�rieur gauche du tag dans l'image
- Peut prendre comme valeur "left" ou "right" et le tag sera dans un coin gauche ou droit de l'image
- Peut prendre comme valeur middle et le tag sera centr�
- Si c'est un nombre d�finie comme une cha�ne de caract�re ( entre guillemet ) : l'image est positionn� � un pourcentage de l'image �gal au nombre entre guillemet ( EX : $X = "50" positionnera le tag au milieu de l'image )
- Y : OBLIGATOIRE
- Idem que X sauf qu'il s'agit de l'ordonn�e du coin sup�rieur gauche du tag
- Les valeurs pour d�finir une image dans un coin sont "up" et "down"
- largeur et hauteur : OPTIONNEL
- S'il ne sont pas pr�cis�s : le tag n'est pas redimmensionn� avant d'�tre ins�r� dans l'image
- Si ce sont des nombres : largeur et hauteur du tag dans l'image
- Si ce sont des nombres d�finies comme des cha�ne de caract�re ( entre guillemet ) : l'image est redimmensionn�e en prenant la valeur dans lacha�ne comme pourcentage ( EX : $largeur = "50" donnera au tag une largeur �quivalente � 50% de la largeur de l'image d'origine )
- Si un seul des deux est pr�cis�, le script donne � l'autre la valeur n�c�ssaire pour que le tag ne soit pasd�form�
- distance : OPTIONNEL
- Dans le cas d'un X ou Y d�finie par une chaine de caract�re ( up down left ou right ), distance du tag par rapport au bord de l'image

Si vous ne souhaitez pas d�finir les param�tres optionnels , remplacez les par NULL dans l'appel de la fonction

La fonction retourne le chemin vers l'image cr��e.

*/

function tag($imgSource,$imgTag,$destination,$X,$Y,$largeur,$hauteur,$distance) {
    
    //R�cup�re les info sur les images utilis�es
        $sourceSize = getimagesize($imgSource);
        $sourceWidth = $sourceSize[0];
        $sourceHeight = $sourceSize[1];
        @$tagSize = getimagesize($imgTag); //Les @ servent � �viter un message d'erreur si le tag est une chaine de caract�re
        @$tagWidth = $tagSize[0];
        @$tagHeight = $tagSize[1];

    //Cr�e l'image et s�lectionne l'image source et le tag
       $img = imagecreatetruecolor($sourceWidth,$sourceHeight);
        $source = imagecreatefrompng($imgSource);

        //Si le tag est une chaine de caract�re
        if( strpos($imgTag,"@") ) {
             $fontHeight = imagefontheight(5);  $fontWidth = imagefontwidth(5);
             list( $texte , $color ) = explode("@",$imgTag) ;
             //Si elle doit �tre affich� sur plusieurs lignes
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
        //Cr�ation de l'image tag avec dedans le texte
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

    //Donne ou calcule des donn�es par d�fault si elles n'ont pas �t� pr�cis�es
        if( isset($largeur) && empty($hauteur) ) {
                @$hauteur = ( $tagHeight / $tagWidth ) * $largeur ;
                }
        elseif( isset($hauteur) && empty($largeur) ) {
                $largeur = ( $tagWidth / $tagHeight ) * $hauteur ;
                }
        if( empty($distance) ) $distance = 10 ;
        $largeur = empty($largeur) ? $tagWidth : $largeur ;
        $hauteur = empty($hauteur) ? $tagHeight : $hauteur ;

    //Si la taille du tag est d�finie comme un pourcentage, calcul de la taille du tag
        if( is_string($largeur) ) { $largeur = ( $tagWidth / 100 ) * $largeur ; $largeur = ( int ) $largeur ; }
        if( is_string($hauteur) ) { $hauteur = ( $tagHeight / 100 ) * $hauteur ; $hauteur = ( int ) $hauteur ; }

    //Donne la position du tag s'il a �t� d�finie par sa position sur l'image
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

    //Donne la position du tag s'il a �t� d�finie par un pourcentage de l'image
        if( is_string( $X ) ) { $X = ( $sourceWidth / 100 ) * $X ; $X = ( int ) $X ; }
        if( is_string( $Y ) ) { $Y = ( $sourceHeight / 100 ) * $Y ; $Y = ( int ) $Y ; }

    //Dessine l'image
        imagecopy($img,$source,0,0,0,0,$sourceWidth,$sourceHeight) or die("Probl�me avec la copie de l'image source");
        if( isset($stringType) ) imagecopymerge($img,$tag,$X,$Y,0,0,$tagWidth,$tagHeight,100);
        else imagecopyresampled($img,$tag,$X,$Y,0,0,$largeur,$hauteur,$tagWidth,$tagHeight) or die("Probl�me avec l'insertion du tag");

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

//On tag le pseudo et on cr�ee en meme temps le permis du user
$tag = tag($phpbb_root_path.'images/permis/permis.png','Pseudo : '.$userdata['username'].'@50|50|50',$phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',20,50,NULL,NULL,NULL);
//On tag le domicile
$tag = tag($phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png','Domicile : 17 rue Leidenstadt<br>   En passant@50|50|50',$phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',20,85,NULL,NULL,NULL);
//On tag le "delivr� par"
$tag = tag($phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png','D�livr� par@50|50|50',$phpbb_root_path.'images/permis/permis_'.$userdata['user_id'].'.png',20,150,NULL,NULL,NULL);
//On tag le logo famille a cot� de "d�livr� par"
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