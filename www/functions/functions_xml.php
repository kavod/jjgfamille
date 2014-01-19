<?php

function genere_rss() 
{

         $xml = '<?xml version="1.0" encoding="ISO-8859-1"?>';
         $xml .= '<rss version="2.0">';
         $xml .= '<channel>';

         $xml .= '<title>jjgfamille.com News</title>';
         $xml .= '<link>'.$_SERVER['HTTP_HOST'].'/</link>';
         $xml .= '<description>Toutes les actualités de Jean-Jacques Goldman sur jjgfamille.com</description>';
         $xml .= '<language>fr-fr</language>';
         $xml .= '<copyright>Copyright © 2006 famille Musik</copyright>';
         $xml .= '<lastBuildDate>'.date("D, d M Y H:i:s").' GMT</lastBuildDate>';
         $xml .= '<managingEditor>webmaster@jjgfamille.com</managingEditor>';
         $xml .= '<webMaster>webmaster@jjgfamille.com</webMaster>';
         $xml .= '<ttl>60</ttl>';
              
         $xml .= '<image>';
         $xml .= '<url>'.$_SERVER['HTTP_HOST'].'/templates/jjgfamille/images/site/ban.png</url>';
         $xml .= '<title>jjgfamille.com, croisons nos vies de temps en temps !</title>';
         $xml .= '<link>'.$_SERVER['HTTP_HOST'].'/</link>';
         $xml .= '<description>Le site consacré à l\'oeuvre de Jean-Jacques Goldman</description>';
         $xml .= '<width>486</width>';
         $xml .= '<height>60</height>';
         $xml .= '</image>';

$tab_news = select_liste("SELECT * FROM famille_news ORDER BY date_unix DESC,news_id DESC LIMIT 0,10");

for($i=0;$i<count($tab_news);$i++)
{

$author =  select_element("SELECT * FROM phpbb_users WHERE user_id = ". $tab_news[$i]["user_id"] ." ",false,'');

         $xml .= '<item>';
	 $xml .= '<title>'.$tab_news[$i]["title"].'</title>';
	 $xml .= '<link>'.$_SERVER['HTTP_HOST'].'/actu/news.php?news_id='.$tab_news[$i]["news_id"].'</link>';
	 $xml .= '<description>'.htmlspecialchars(nl2br(strip_tags(bbencode_second_pass($tab_news[$i]["news"],$tab_news[$i]["bbcode_uid"])))).'</description>';
	 $xml .= '<author>'.$author['user_email'].' ('.$author['username'].')</author>';
	 $xml .= '<guid>'.$_SERVER['HTTP_HOST'].'/actu/news.php?news_id='.$tab_news[$i]["news_id"].'</guid>';
	 $xml .= '<pubDate>'.date("D, d M Y",$tab_news[$i]["date_unix"]).' GMT</pubDate>';
	 $xml .= '<source url="'.$_SERVER['HTTP_HOST'].'/rss/news.xml">jjgfamille.com</source>';
	 $xml .= '</item>';
}

         $xml .= '</channel>';
         $xml .= '</rss>';

$fp = fopen("../rss/news.xml", 'w+');
fputs($fp, $xml);
fclose($fp);

}

?>
