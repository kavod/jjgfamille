<?
// Ancienne page d'accueil de famille 2
// beaucoup de sites pointent dessus. Nécessité donc de faire une redirection propre.

header("Status: 301 Moved Permanently", false, 301);
header("Location: http://www.jjgfamille.com");
exit();

?>