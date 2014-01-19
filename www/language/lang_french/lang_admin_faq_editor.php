<?php
/***************************************************************************
 *                       lang_admin_faq_editor.php [English]
 *                              -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *
 *     $Id: lang_admin_faq_editor.php,v 1.0.0.0 2003/07/13 23:24:12 Selven Exp $
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/


$lang['faq_editor'] = 'Editer la langue';
$lang['faq_editor_explain'] = 'Ce module vous permet d\�diter et de r�organiser vos FAQ. Vous <u>NE DEVEZ PAS</u> supprimer ou modifier la rubrique appel�e <b>phpbb 2</b>.';

$lang['faq_select_language'] = 'Choisiez la lanque du fichier que vous souhaitez �diter';
$lang['faq_retrieve'] = 'Charger le fichier';

$lang['faq_block_delete'] = 'Etes-vous s�r de vouloir supprimer cette cat�gorie ?';
$lang['faq_quest_delete'] = 'Etes-vous s�r de vouloir supprimer cette question (et sa r�ponse) ?';

$lang['faq_quest_edit'] = 'Editer la question et sa r�ponse';
$lang['faq_quest_create'] = 'Cr�er une nouvelle question/r�ponse';

$lang['faq_quest_edit_explain'] = 'Editer la question et la r�ponse. Changer la cat�gorie si vous le d�sirez.';
$lang['faq_quest_create_explain'] = 'Entrez la nouvelle question et sa r�ponse puis faites "Envoyer".';

$lang['faq_block'] = 'Cat�gorie';
$lang['faq_quest'] = 'Question';
$lang['faq_answer'] = 'R�ponse';

$lang['faq_block_name'] = 'Nom de la cat�gorie';
$lang['faq_block_rename'] = 'Renommez la cat�gorie';
$lang['faq_block_rename_explain'] = 'Changer le nom de la cat�gorie dans le fichier';

$lang['faq_block_add'] = 'Ajouter une cat�gorie';
$lang['faq_quest_add'] = 'Ajouter une question';

$lang['faq_no_quests'] = 'Aucune question dans cette cat�gorie. Ceci emp�che les autres blocks de la cat�gorie d\'�tre affich�s. Supprimez la cat�gorie ou ajouter une ou plusieurs questions;';
$lang['faq_no_blocks'] = 'Aucune cat�gorie d�finies. Ceci n\'est pas normal. Contactez Boris.';

$lang['faq_write_file'] = 'Ne peut �crire dans le fichier de lang';
$lang['faq_write_file_explain'] = 'Vous devez faire le fichier de lang dans le dossier language/lang_french/ ou �quivalent <u>avec les droits �critures</u>pour utiliser le panneau de contr�le. Sur UNIX, ceci correspond � ex�cuter <code>cdmod 666 nom_du_fichier</code>. La plupart des clients FTP peuvent le faire � travers la commande "propri�t�s". Sinon, utilisez telnet (breuk) ou SSH (powaaaaaaa).';

?>