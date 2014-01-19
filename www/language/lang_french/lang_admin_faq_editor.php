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
$lang['faq_editor_explain'] = 'Ce module vous permet d\éditer et de réorganiser vos FAQ. Vous <u>NE DEVEZ PAS</u> supprimer ou modifier la rubrique appelée <b>phpbb 2</b>.';

$lang['faq_select_language'] = 'Choisiez la lanque du fichier que vous souhaitez éditer';
$lang['faq_retrieve'] = 'Charger le fichier';

$lang['faq_block_delete'] = 'Etes-vous sûr de vouloir supprimer cette catégorie ?';
$lang['faq_quest_delete'] = 'Etes-vous sûr de vouloir supprimer cette question (et sa réponse) ?';

$lang['faq_quest_edit'] = 'Editer la question et sa réponse';
$lang['faq_quest_create'] = 'Créer une nouvelle question/réponse';

$lang['faq_quest_edit_explain'] = 'Editer la question et la réponse. Changer la catégorie si vous le désirez.';
$lang['faq_quest_create_explain'] = 'Entrez la nouvelle question et sa réponse puis faites "Envoyer".';

$lang['faq_block'] = 'Catégorie';
$lang['faq_quest'] = 'Question';
$lang['faq_answer'] = 'Réponse';

$lang['faq_block_name'] = 'Nom de la catégorie';
$lang['faq_block_rename'] = 'Renommez la catégorie';
$lang['faq_block_rename_explain'] = 'Changer le nom de la catégorie dans le fichier';

$lang['faq_block_add'] = 'Ajouter une catégorie';
$lang['faq_quest_add'] = 'Ajouter une question';

$lang['faq_no_quests'] = 'Aucune question dans cette catégorie. Ceci empêche les autres blocks de la catégorie d\'être affichés. Supprimez la catégorie ou ajouter une ou plusieurs questions;';
$lang['faq_no_blocks'] = 'Aucune catégorie définies. Ceci n\'est pas normal. Contactez Boris.';

$lang['faq_write_file'] = 'Ne peut écrire dans le fichier de lang';
$lang['faq_write_file_explain'] = 'Vous devez faire le fichier de lang dans le dossier language/lang_french/ ou équivalent <u>avec les droits écritures</u>pour utiliser le panneau de contrôle. Sur UNIX, ceci correspond à exécuter <code>cdmod 666 nom_du_fichier</code>. La plupart des clients FTP peuvent le faire à travers la commande "propriétés". Sinon, utilisez telnet (breuk) ou SSH (powaaaaaaa).';

?>