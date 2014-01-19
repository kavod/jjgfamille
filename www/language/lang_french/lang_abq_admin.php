<?php
/***************************************************************************
 *                          lang_abq_admin.php [French]
 *                          ----------------------------
 *   Version              : Version 2.0.0 - 04.12.2006
 *   copyright            : (C) 2005-2006 M.W.
 *   URL Auteur du Mod                 : http://phpbb.mwegner.de/
 *   Traduit sur phpBB-fr
 *
 ***************************************************************************/

// redirect pages
$lang['ABQ_Config_updated'] = 'La configuration du MOD Anti Bot Question a été modifiée';
$lang['ABQ_Config2_updated'] = 'La configuration des couleurs du MOD Anti Bot Question a été modifiée';
$lang['ABQ_Click_return_config'] = 'Cliquez %sIci%s pour retourner à la configuration du MOD Anti Bot Question';
$lang['ABQ_Click_return_config2'] = 'Cliquez %Ici%s pour retourner à la configuration des couleurs du MOD Anti Bot Question ';
$lang['ABQ_New_Question_created'] = 'Une nouvelle question personnelle a été crée';
$lang['ABQ_Question_updated'] = 'La question personnelle a été mise à jour';
$lang['ABQ_Question_deleted'] = 'La question personnelle a été supprimée';
$lang['ABQ_Click_return_ABQ'] = 'Cliquez %sIci%s pour retourner à l\'administration des questions personnelles du MOD Anti Bot Question';
$lang['ABQ_Click_return_Fonts'] = 'Cliquez %sIci%s pour retourner à l\'administration des polices du MOD Anti Bot Question';
$lang['ABQ_Click_return_IImages'] = 'Cliquez %sIci%s pour retourner à l\'administration des images des questions personnelles du MOD Anti Bot Question';
$lang['ABQ_delete_Font_ok'] = 'La police a été supprimée';
$lang['ABQ_upload_File_OK'] = 'Le fichier image a été uploadé.';
$lang['ABQ_delete_Image_ok'] = 'Le fichier image a été supprimé.';

// not only for redirect pages
$lang['ABQ_unknown_font'] = 'La police en cours d\'utilisation n\'a pas été trouvée.';
$lang['ABQ_dont_delete_font'] = 'Impossible de supprimer la police "do-not-delete".<br />Cette police est requise pour le bon fonctionnement du MOD.';
$lang['ABQ_unknown_image'] = 'L\'image en cours d\'utilisation n\'a pas été trouvée.';
$lang['ABQ_iimage_in_use'] = 'Vous ne pouvez pas effacer cette image car elle est au moins utilisée, dans une question personnelle.';

// general
$lang['ABQ_Version'] = '2.0.0';
$lang['ABQ_Wiki_GD'] = 'http://en.wikipedia.org/wiki/GD_Graphics_Library';
$lang['ABQ_Wiki_FT'] = 'http://fr.wikipedia.org/wiki/FreeType';
$lang['ABQ_installiert'] = 'installée';
$lang['ABQ_nicht_installiert'] = 'non installée';
$lang['ABQ_Rand'] = 'Au hasard';
$lang['ABQ_Beispiel'] = 'Exemple';
$lang['ABQ_JPG'] = 'JPG';
$lang['ABQ_PNG'] = 'PNG';
$lang['ABQ_ReadOnly1_Explain'] = 'Cette option nécessite la <a href="' . $lang['ABQ_Wiki_GD'] . '" title="GD Graphics Library" target="_blank">librairie GD</a>. Cette libraire n\'étant pas présente sur votre serveur, cette option ne fonctionnera donc pas sur votre forum.';
$lang['ABQ_ReadOnly2_Explain'] = 'Cette option nécessite la <a href="' . $lang['ABQ_Wiki_FT'] . '" title="FreeType Library" target="_blank">librairie FreeType</a>. Cette libraire n\'étant pas présente sur votre serveur, cette option ne fonctionnera donc pas sur votre forum.';
$lang['ABQ_Allgemeines'] = 'Configuration générale';
$lang['ABQ_QuestAuto'] = 'Questions automatiques';
$lang['ABQ_QuestIndi'] = 'Questions personnelles';
$lang['ABQ_File'] = 'Fichier';
$lang['ABQ_Image'] = 'image';

// ACP Menu
$lang['ABQ_Admin_Index'] = 'Administration du Anti Bot Question';
$lang['ABQ_Admin_Index_Explain'] = 'Le MOD Anti Bot Question ajoute une question à l\'enregistrement et au formulaire de posting pour les invités, afin d\'empêcher l\'inscription des robots ou le posting de SPAMS sur votre forum. Il faudra répondre correctement à cette question afin de valider une inscription ou un message sur le forum. Si vous utilisez ce MOD, vous pouvez désactiver la confirmation visuelle standard de phpBB.<br /><br />Ce MOD est compatible avec <a href="http://www.phpbbhacks.com/download/235" title="Select Default Language MOD 1.3.4" target="_blank">Select Default Language MOD 1.3.4</a>. Si vous l\'utilisez, aucun changement de code n\'est à prévoir.<br />Si vous utilisez par contre un des mods suivants, vous devrez installer un Add-on:<br />
&#8226; <a href="http://www.phpbbhacks.com/download/586" title="Advanced Quick Reply MOD 1.1.1" target="_blank">Advanced Quick Reply MOD 1.1.1</a><br />
&#8226; <a href="http://www.phpbbhacks.com/download/3096" title="Easy Contact Form MOD 1.1.0" target="_blank">Easy Contact Form MOD 1.1.0</a><br />
&#8226; <a href="http://www.phpbbhacks.com/download/522" title="Quick Reply MOD 1.0.5" target="_blank">Quick Reply MOD 1.0.5</a><br />
&#8226; <a href="http://www.phpbbhacks.com/download/540" title="Quick Reply MOD with Quote 1.1.3" target="_blank">Quick Reply MOD with Quote 1.1.3</a><br />
&#8226; <a href="http://www.phpbbhacks.com/download/4733" title="Quick Reply MOD with Quote and BBCode 1.1.3" target="_blank">Quick Reply MOD with Quote and BBCode 1.1.3</a><br />
&#8226; every other Quick Reply MOD (no further special Add-Ons available)<br />
Vous pouvez télécharger les Add-Ons de compatibilité avec ces mods <a href="http://phpbb.mwegner.de/" title="Anti Bot Question MOD Add-Ons" target="_blank">ici</a>.';
$lang['ABQ_AdminI_Config'] = 'Configuration';
$lang['ABQ_AdminI_AutoFragen'] = 'Gestion des "' . $lang['ABQ_QuestAuto'] . '"';
$lang['ABQ_AdminI_Fonts'] = 'Gestion des polices';
$lang['ABQ_AdminI_Config2'] = 'Gestion des couleurs';
$lang['ABQ_AdminI_IndiFragen'] = 'Gestion des "' . $lang['ABQ_QuestIndi'] . '"';
$lang['ABQ_AdminI_IndiImages'] = 'Gestion des images';

// configuration
$lang['ABQ_Aktivate'] = 'Activer/Désactiver le MOD Anti Bot Question';
$lang['ABQ_Aktivate_explain'] = 'Ici, vous pouvez activer/désactiver l\'utilisation de ce MOD, au moment des inscriptions ou du posting d\'un message en tant qu\'invité.';
$lang['ABQ_Register'] = 'Activer le MOD Anti Bot Question lors des inscriptions';
$lang['ABQ_Register_explain'] = 'Les utilisateurs devront répondre à une question au moment de l\'inscription.';
$lang['ABQ_confirm_aktiv'] = 'La confirmation visuelle standard de phpBB est (aussi) activée! (Vous pouvez la désactiver dans: ' . $lang['General'] . ' &gt; ' . $lang['Configuration'] . ')';
$lang['ABQ_Guest'] = 'Activer le MOD Anti Bot Question pour les invités';
$lang['ABQ_Guest_explain'] = 'Les invités devront répondre correctement à une question afin de valider leur message sur le forum.';
 // general configuration
$lang['ABQ_GeneralConfig'] = 'Configuration générale';
$lang['ABQ_VarName'] = 'Sélectionnez le nom de la variable POST du MOD Anti Bot Question';
$lang['ABQ_VarName_Explain'] = 'Choisissez une combinaison. Cela n\'a aucune influence visible sur le formulaire d\'enregistrement pour les visiteurs humains.';
$lang['ABQ_VerhEFAF'] = 'Quel est le pourcentage d\'utilisation des questions personnelles ? (Les questions automatiques seront utilisées sur le pourcentage restant)';
$lang['ABQ_VerhEFAF_Explain'] = 'Avec 100%, seules les questions personnelles seront choisies, avec 0 % seules les questions automatiques le seront. Si les questions personnelles sont désactivées, qu\'aucune question personnelle n\'existe, ou qu\'aucune sorte de question automatique n\'est activée, cette option sera ignorée.';
$lang['ABQ_AF_Malzeichen'] = 'Symbole de la multiplication';
$lang['ABQ_AF_Malzeichen_Explain'] = 'Choisissez le symbole de la multiplication à utiliser avec les problèmes arithmetiques<br />3*3=?; 3x3=?; 3X3=?';
$lang['ABQ_AF_Use_Select'] = 'Choix multiple pour les questions automatiques';
$lang['ABQ_AF_Use_Select_Explain'] = 'Si vous choisissez le choix multiple, l\'utilisateur n\'aura pas à écrire la réponse. Il devra sélectionner la réponse correcte parmi plusieurs réponses données. Ceci est une éventuelle simplification de la procédure pour l\'utilisateur. Mais la protection contre les robots en est légèrement réduite.';
 // Individual Question Individuelle Fragen configuration
$lang['ABQ_EFConfig'] = 'Configuration des questions personnelles';
$lang['ABQ_EFConfig_explain'] = 'Seuls les questions personnelles sont concernées par ces options.';
$lang['ABQ_IndividulleFragenVerwenden'] = 'Activer les questions personnelles';
$lang['ABQ_IndividulleFragenVerwenden_Explain'] = 'Si les questions personnelles sont désactivées, le MOD utilisera seulement les questions automatiques. Si aucune question personnelle n\'est disponible, cette option sera ignorée et le MOD utilisera toujours les questions automatiques. Si aucune question automatique n\'est activée, le MOD utilisera toujours les question-texte automatique type 1.';
$lang['ABQ_CaseSensitive'] = 'Est ce que la réponse est sensible à le cas ? (MAJUSCULE/minuscule)';
$lang['ABQ_CaseSensitive_Explain'] = 'Les questions automatiques passent outre cette option. La réponse à une question automatique devra toujours être sensible à la case!';
$lang['ABQ_BildPHP'] = 'Utiliser le ficher abq_bild.php pour montrer des images';
$lang['ABQ_BildPHP_Explain'] = 'Ce fichier rend l\'identification des images plus difficiles pour les robots. Cependant, cela ne marche pas pour tous les serveurs (dépend de la configuration du serveur).<br />Si vous pouvez lire le texte de l\'image ci-dessous (Test) alors vous devriez activer cette option.<br />%s<br clear="all" />Si aucune image n\'est affichée, une erreur est alors rencontrée et votre serveur ne supporte donc pas cette fonction.';
 // Automatical Question configuration
$lang['ABQ_AFConfig'] = 'Configuration des questions automatiques';
$lang['ABQ_AFConfig_explain'] = 'Seules les questions personnelles seront concernées par ces options. Cela suppose que la <a href="' . $lang['ABQ_Wiki_GD'] . '" title="GD Graphics Library" target="_blank">librairie GD</a> est installée sur votre serveur.  Une version installée de la <a href="' . $lang['ABQ_Wiki_FT'] . '" title="FreeType Library" target="_blank">librairie FreeType</a> n\'est pas obligatoire mais recommandée.<br /><a href="' . $lang['ABQ_Wiki_GD'] . '" title="GD Graphics Library" target="_blank">Librairie GD</a>: %s<br /><a href="' . $lang['ABQ_Wiki_FT'] . '" title="FreeType Library" target="_blank">Librairie FreeType</a>: %s<br /><br />Les images liées sont fixes (par ex. pas de Gif animés), afin d\'éviter de surcharger le serveur.';
$lang['ABQ_AFConfig_explain2'] = 'sans la librairie FreeType';
$lang['ABQ_AFConfig_explain3'] = 'avec la librairie FreeType';
$lang['ABQ_ImageType'] = 'Sélectionner le format des images';
$lang['ABQ_JPGQuality'] = 'Qualité JPG';
$lang['ABQ_JPGQuality_Explain'] = 'Les valeurs de 50 à 90 sont autorisées. Plus cette valeur est haute, plus la qualité de l\'image est élevée mais plus le temps de chargement sera long.';
$lang['ABQ_Fontsize'] = 'Taille de la police';
$lang['ABQ_Fontsize_Explain'] = 'Cette option est ignorée si la <a href="' . $lang['ABQ_Wiki_FT'] . '" title="FreeType Library" target="_blank"> librairie FreeType</a> n\'est pas installée.<br />Les valeurs de 15 à 40 sont autorisées. Plus la taille de la police est elevée, plus la lecture du texte sera facilitée. Cependant, la taille de la police influe aussi la taille de l\'image générée. Plus la taille de la police est élevée, plus l\'image générée sera lourde.<br />Note: S\'il y a plus d\'une ligne de texte, la taille de la police est automatiquement réduite de moitié par ligne.';
$lang['ABQ_GrosseZahlen'] = 'Utiliser de grandes valeurs numériques dans les problèmes arithmétiques.';
$lang['ABQ_GrosseZahlen_Explain'] = 'Si de grandes valeurs numériques sont utilisées, alors les nombres utilisés pour les problèmes arithmétiques seront supérieurs à 1000. Si de grandes valeurs numériques ne sont pas utilisées, alors les nombres utilisés pour les problèmes arithmétiques auront, de même que les résultats, une valeur de 350.';
$lang['ABQ_AFEFF_Max'] = 'Limite maximum des effets utilisés';
$lang['ABQ_AFEFF_Max_explain'] = 'Ici, vous pouvez spécifiez le nombre d\'effets qui pourront être sélectionnés au hasard. Cette option s\'applique uniquement sur les effets, réglés sur "' . $lang['ABQ_Rand'] . '".<br />S\'il y a plus d\'effets avec l\'option "oui", alors aucun effet "' . $lang['ABQ_Rand'] . '" ne sera utilisé.<br />S\'il y a moins d\'effets avec l\'option "oui" que cette valeur, les effets "' . $lang['ABQ_Rand'] . '" seront utilisés. Les effets avec l\'option "Non" ne sont jamais utilisés.<br />Une valeur à 0 signifie qu\'il n\'y a aucune limitation. La valeur maximale autorisée est de 6.';
$lang['ABQ_AFEFF_Trennlinie'] = 'Utilisez l\'effet: Séparateur';
$lang['ABQ_AFEFF_Trennlinie_explain'] = 'Si plus d\'une ligne est présente, une ligne de séparation peut être incluse entre les lignes de texte.';
$lang['ABQ_AFEFF_BGText'] = 'Utilisez l\'effet: Texte de fond';
$lang['ABQ_AFEFF_Grid'] = 'Utilisez l\'effet: Grille';
$lang['ABQ_AFEFF_GridW'] = 'Distance horizontale des lignes de la grille';
$lang['ABQ_AFEFF_GridW_explain'] = 'Valeurs autorisées: 10 - 100; 0 = une valeur au hasard est sélectionnée';
$lang['ABQ_AFEFF_GridH'] = 'Distance verticale des lignes de la grille';
$lang['ABQ_AFEFF_GridH_explain'] = 'Valeurs autorisées: 10 - 50; 0 = une valeur au hasard est sélectionnée';
$lang['ABQ_AFEFF_GridF'] = 'Utilisez l\'effet: Grille remplie';
$lang['ABQ_AFEFF_GridF_explain'] = 'Cet effet peut être seulement utilisé en combinaison avec l\'effet "Grille". Si l\'effet "Grille" est désactivé, cet effet sera aussi automatiquement désactivé.';
$lang['ABQ_AFEFF_Ellipsen'] = 'Utilisez l\'effet: Cercle et cercle partiel';
$lang['ABQ_AFEFF_Boegen'] = 'Utilisez l\'effet: Arcs de cercle';
$lang['ABQ_AFEFF_Linien'] = 'Utilisez l\'effet: Lignes';

// Automatic Questions administration
$lang['ABQ_AutoQuestVerwalt'] = 'Gestion des questions automatiques';
$lang['ABQ_AutoQuestVerwalt_Explain'] = 'Ici, vous pouvez sélectionner les questions automatiques qui sont à activer ou désactiver.<br /><br />Si vous voulez utiliser les questions-image, la <a href="' . $lang['ABQ_Wiki_GD'] . '" title="GD Graphics Library" target="_blank">librairie GD</a> doit être installée. La <a href="' . $lang['ABQ_Wiki_GD'] . '" title="GD Graphics Library" target="_blank">librairie</a> est %s sur votre serveur.<br /><br />Si toutes les questions automatiques sont désactivées, le MOD utilise seulement les questions personnelles. Si les questions personnelles sont désactivées, le MOD utilisera toujours la question texte automatique type 1.<br /><br />La ligne N°x et les positions x1 à x8 sont remplacés au hasard par les nombres adéquats.';
$lang['ABQ_AutoQuestVerwalt_TQ'] = 'Questions-texte';
$lang['ABQ_AutoQuestVerwalt_IQ'] = 'Questions-image';
$lang['ABQ_Typ'] = 'Type';
 // Automatic Text Questions
$lang['ABQ_AF05'] = '%s<br />4 lignes sont affichées.';
$lang['ABQ_AF06'] = '%s<br />3 lignes sont affichées.';
$lang['ABQ_AF07'] = '%s<br />2 lignes sont affichées.';
$lang['ABQ_AF08'] = '%s';
$lang['ABQ_AF13'] = '%s<br />4 lignes sont affichées.';
$lang['ABQ_AF14'] = '%s<br />3 lignes sont affichées.';
$lang['ABQ_AF15'] = '%s<br />2 lignes sont affichées.';
$lang['ABQ_AF16'] = '%s';
$lang['ABQ_AF21'] = '%s<br />4 lignes sont affichées.';
$lang['ABQ_AF22'] = '%s<br />3 lignes sont affichées.';
$lang['ABQ_AF23'] = '%s<br />2 lignes sont affichées.';
$lang['ABQ_AF24'] = '%s';
$lang['ABQ_AF28'] = '%s';
$lang['ABQ_AF29'] = '%s';
$lang['ABQ_AF30'] = '%s';
 // Automatic Image Questions
$lang['ABQ_AF01'] = '%s<br />4 lignes sont affichées.';
$lang['ABQ_AF02'] = '%s<br />3 lignes sont affichées.';
$lang['ABQ_AF03'] = '%s<br />2 lignes sont affichées.';
$lang['ABQ_AF04'] = '%s';
$lang['ABQ_AF09'] = '%s<br />4 lignes sont affichées.';
$lang['ABQ_AF10'] = '%s<br />3 lignes sont affichées.';
$lang['ABQ_AF11'] = '%s<br />2 lignes sont affichées.';
$lang['ABQ_AF12'] = '%s';
$lang['ABQ_AF17'] = '%s<br />4 lignes sont affichées.';
$lang['ABQ_AF18'] = '%s<br />3 lignes sont affichées.';
$lang['ABQ_AF19'] = '%s<br />2 lignes sont affichées.';
$lang['ABQ_AF20'] = '%s';
$lang['ABQ_AF25'] = '%s';
$lang['ABQ_AF26'] = '%s';
$lang['ABQ_AF27'] = '%s';
$lang['ABQ_AF31'] = '%s';
$lang['ABQ_AF32'] = '%s';
$lang['ABQ_AF33'] = '%s';
$lang['ABQ_AF34'] = '%s';

// Individual Questions administration
$lang['ABQ_Admin_Title'] = 'Gestion des questions personnelles';
$lang['ABQ_Admin_Explain'] = 'Ici, vous pouvez créer, éditer ou supprimer une question personnelle.<br />Si les questions personnelles sont activées, le MOD utilise une des questions suivantes. La question est choisie au hasard.<br /><br />Exemple:<br />Question: Lequel de ces 4 mots représente un animal ? Voiture, Europe, Cheval, Montagne<br />Réponse: Cheval<br />';
$lang['ABQ_Answer'] = 'Réponse';
$lang['ABQ_Answer_F'] = 'Mauvaise réponse';
$lang['ABQ_Question'] = 'Question';
$lang['ABQ_ImageURL'] = 'URL de l\'image';
$lang['ABQ_ImageURL_DelExplain'] = 'L\'image n\'a pas été supprimée du serveur!';
$lang['ABQ_Create_Question'] = 'Ajouter une nouvelle question';
$lang['ABQ_Image_DNE'] = 'N\'existe plus';
$lang['ABQ_No_questions'] = '<br />Aucune question personnelle n\'a été crée.<br /><br />';
$lang['ABQ_Edit_Question'] = 'Editer la question';
$lang['ABQ_Answer_Explain'] = 'Sensible à la case!';
$lang['ABQ_Delete_Title'] = 'Supprimer une question personnelle';
$lang['ABQ_Delete_Question'] = 'Supprimer la question';
$lang['ABQ_MCQ'] = 'Question à choix multiple';
$lang['ABQ_IQ_MC_Info1'] = 'Question non à choix multiple ** - L\'utilisateur doit entrer la réponse dans un champ texte.';
$lang['ABQ_IQ_MC_Info1a'] = 'Entrez une ou plusieurs bonnes réponses et <b>pas</b> de mauvaises réponses.';
$lang['ABQ_IQ_MC_Info2'] = 'Question à choix multiple ** - L\'utilisateur doit choisir la bonne réponse parmi toutes les réponses proposées.';
$lang['ABQ_IQ_MC_Info2a'] = 'Complétez uniquement le champ &quot;' . $lang['ABQ_Answer'] . ' 1&quot; et <b>tous</b> les champs mauvaise réponse.';
$lang['ABQ_IQ_MC_Info3'] = '** - Si vous choisissez le choix multiple, l\'utilisateur n\'aura pas à écrire la réponse. Il devra sélectionner la réponse correcte parmi plusieurs réponses données. Ceci est une éventuelle simplification de la procédure pour l\'utilisateur. Mais la protection contre les robots en est légèrement réduite.';

// advanced configuration
$lang['ABQ_ColorConf_Titel'] = 'Configuration des couleurs';
$lang['ABQ_ColorConf_Explain'] = 'Ici, vous pouvez spécifier les couleurs utilisées dans les <b>questions-images automatiques</b>. Ces valeurs ne concernent pas les questions personnelles ou les questions-texte automatiques.<br /><br /><img width="16" height="16" border="0" vspace="0" hspace="0" src="' . $phpbb_root_path . 'images/abq_mod/admin/achtung.gif" alt="Avertissement" /> <bChangez ces options uniquement si vous savez ce que vous faîtes. Un mauvais paramétrage peut rendre le texte illisible dans les images</b><br clear="all"><br />Utilisez le shéma RGB pour définir les couleurs. Les points suivants sont à prendre en compte :<br />&#187; Les valeurs valides de couleur sont : 0 - 255<br />&#187; Deux valeurs doivent être définies pour chaque attribut de couleur R (= rouge), V (= vert) and B (= bleu). La seconde valeur doit être supérieure à la première.<br /><br />Normallement, seule une valeur est nécessaire. Pourquoi alors utiliser ici deux valeurs par attribut de couleur ?<br />Parce que vous ne définissez pas seulement une couleur. Vous définissez un ensemble de couleurs. Par exemple: si la première valeur-rouge est 10 et la seconde 50, une valeur-rouge supérieure à 9 et inférieure à 51 est sélectionnée au hasard pour l\'image.';
$lang['ABQ_RGB_red'] = 'R';
$lang['ABQ_RGB_green'] = 'G';
$lang['ABQ_RGB_blue'] = 'B';
$lang['ABQ_Mainconfig'] = 'Valeurs par défaut';
$lang['ABQ_Color_BG'] = 'Couleur de fond';
$lang['ABQ_Color_Text'] = 'Couleur de texte';
$lang['ABQ_Color_Text_Explain'] = 'la couleur de texte doit être clairement différente de la couleur de texte 1, couleur de texte 2 et couleur de texte de fond d\'écran.';
$lang['ABQ_Color_F1'] = 'Couleur de texte 1';
$lang['ABQ_Color_F1_Explain'] = 'La couleur de texte 1 dans la question-image automatique type 16 (%s). Si vous choisissez une autre couleur que le vert, vous devez changer la variable de langue $lang[\'ABQ_Farbe1\'] (dans le fichier : language/lang_xxx/lang_abq.php) du "vert" vers la nouvelle couleur. Faites ce changement pour toutes les langues installées sur votre forum !<br />la couleur de texte 1 doit être clairement différente de la couleur de texte, couleur de texte 2 et couleur de texte de fond d\'écran.';
$lang['ABQ_Color_F2'] = 'Couleur de texte 2';
$lang['ABQ_Color_F2_Explain'] = 'La couleur de texte 2 dans la question-image automatique type 17 (%s). Si vous choisissez une autre couleur que le rouge, vous devez changer la variable de langue $lang[\'ABQ_Farbe2\'] (dans le fichier : language/lang_xxx/lang_abq.php) de "rouge" vers la nouvelle couleur. Faites ce changement pour toutes les langues installées sur votre forum !<br />la couleur de texte 2 doit être clairement différente de la couleur de texte, couleur de texte 1 et couleur de texte de fond d\'écran.';
$lang['ABQ_Effconfig'] = 'Couleur de l\'effet';
$lang['ABQ_Color_SLines'] = 'Couleur de la ligne de séparation entre les lignes de texte';
$lang['ABQ_Color_BGText'] = 'Couleur du texte de fond';
$lang['ABQ_Color_BGText_Explain'] = 'La couleur du texte de fond doit être visuellement différente de la couleur de texte, de la couleur de texte 1 et de la couleur de texte 2. La couleur de fond doit être moins visible que la couleur de texte. Ceci est nécessaire pour différencier le texte important à taper du texte de fond de remplissage.';
$lang['ABQ_Color_Grid'] = 'Couleur de la grille';
$lang['ABQ_Color_GridF'] = 'Couleur de la grille remplie';
$lang['ABQ_Color_Ellipsen'] = 'Couleur du cercle';
$lang['ABQ_Color_TEllipsen'] = 'Couleur du cercle partiel';
$lang['ABQ_Color_Arcs'] = 'Couleur de l\'arc de cercle';
$lang['ABQ_Color_Lines'] = 'Couleur de la ligne';
$lang['ABQ_ValueReset'] = 'Réinitialiser aux valeurs par défaut';
$lang['ABQ_ValueReset_Explain'] = 'Ici vous pouvez réinitialiser toutes les valeurs de couleur à leur valeurs originale. Cochez la case ci-contre.<br /><b>Important:</b><br />&#187; Si vous avez changé la variable de langue $lang[\'ABQ_Farbe1\'], vous devez annuler le changement effectué dans le fichier langue language/lang_xxx/lang_abq.php pour toutes les langues installées sur votre forum. La valeur de variable originale est "verts", la valeur actuelle est "%s".<br />&#187; Si vous avez changer la variable de langue $lang[\'ABQ_Farbe2\'], vous devez annuler le changement effectué dans le fichier langue language/lang_xxx/lang_abq.php pour toutes les langues installées sur votre forum. La valeur de variable originale est "rouge", la valeur actuelle est "%s".';

// font administration
$lang['ABQ_FontAdmin_Title'] = 'Gestion des polices';
$lang['ABQ_FontAdmin_Explain'] = 'Ici vous pouvez envoyer de nouvelles polices, qui seront utilisées dans les questions-images automatiques. Les polices que vous ne voulez plus utiliser peuvent également être supprimées.<br /><br />Il est obligatoire que la <a href="' . $lang['ABQ_Wiki_GD'] . '" title="GD Graphics Library" target="_blank">librairie GD</a> et la <a href="' . $lang['ABQ_Wiki_FT'] . '" title="FreeType Library" target="_blank">librairie FreeType</a> soient installées sur le serveur, si vous voulez utiliser une de ces polices.<br />Librairie GD : %s<br />librairie FreeType : %s<br /><br />Avant d\'envoyer une nouvelle police, vérifiez le copyright de celle-ci. Merci de respecter les droits d\'auteur.';
$lang['ABQ_Font'] = 'Police';
$lang['ABQ_Upload_New_Font'] = 'Envoyer une nouvelle police';
$lang['ABQ_gd_ft_fehlt'] = 'Les librairies GD et FreeType doivent être installées. Sans une de ces librairies, les polices ne peuvent pas être utilisées.<br />Au moins une de ces librairies n\'est pas installée.';
$lang['ABQ_FontAdmin_Example'] = 'Afficher la police';
$lang['ABQ_FontAdmin_Example_Explain'] = 'Ici la police peut être testée. La police est-elle appropriée pour le MOD ? Les caractères utilisés sont-ils identifiables et la police possède-t-elle tous les caractères utilisés ?';
$lang['ABQ_Font_Anforderungen'] = 'Les caractères suivants doivent être présents et identifiables dans l\'image :';
$lang['ABQ_FontAdmin_Delete'] = 'Supprimer la police';
$lang['ABQ_FontAdmin_Delete_Explain'] = 'Ici vous pouvez une police, si vous ne voulez plus l\'utiliser pour le MOD. %s Si vous voulez utiliser à l\'avenir cette police, vous devrez l\'envoyer à nouveau.';
$lang['ABQ_FontAdmin_Delete_Explain2'] = 'La police sera complètement supprimée de la liste des polices !';
$lang['ABQ_FontAdmin_Upload'] = 'Envoi de police';
$lang['ABQ_FontAdmin_Upload_Explain'] = 'Ici vous pouvez envoyer de nouvelles polices. Prenez note de ce qui suit :<br />La taille maximale autorisée de la police est de %d Ko.<br />Avant d\'envoyer une nouvelle police, vérifiez le copyright de celle-ci. Merci de respecter les droits d\'auteur.';
$lang['ABQ_FontAdmin_Upload_FontFile'] = 'Envoyer une police depuis votre ordinateur';
$lang['ABQ_FontAdmin_Upload_FontFile_Explain'] = '<br />Seuls des formats de police de type TTF peuvent être uploadés. Les autres formats de police ne sont pas valides.<br />Seuls les caractères alphabétiques, nombres, tirets (-) et soulignements (_) sont autorisés dans le nom de fichier.<br />Vous ne pouvez pas écraser un fichier de police existant. Vous devez d\'abord supprimer la police et ensuite seulement, vous pourrez envoyer la nouvelle police (avec le même nom de fichier).';

// Image Administration for the Individual Questions
$lang['ABQ_IImageAdmin_Title'] = 'Gestion des images pour les questions personnelles';
$lang['ABQ_IImageAdmin_Explain'] = 'Ici vous pouvez envoyer de nouvelles images à utiliser dans les questions personnelles. Si vous n\'utilisez plus une image, vous pouvez aussi la supprimer.<br /><br />Avant d\'envoyer une nouvelle image, vérifiez le copyright de celle-ci. Merci de respecter les droits d\'auteur.';
$lang['ABQ_Upload_New_Image'] = 'Envoyer une nouvelle image';
$lang['ABQ_ShowImage'] = 'Afficher l\'image';
$lang['ABQ_No_IIMages'] = 'Il n\'y a aucune image disponible pouvant être utilisée dans les questions personnelles.';
$lang['ABQ_IImageAdmin_Delete'] = 'Supprimer l\'image';
$lang['ABQ_IImageAdmin_Delete_Explain'] = 'Si vous n\'utilisez plus une image, vous pouvez la supprimer. %s Si vous voulez utiliser à l\'avenir cette image, vous devrez l\'envoyer à nouveau.';;
$lang['ABQ_IImageAdmin_Delete_Explain2'] = 'L\'image sera complètement supprimée de la liste des images !';
$lang['ABQ_IImageAdmin_Upload'] = 'Envoi d\'image';
$lang['ABQ_IImageAdmin_Upload_Explain'] = 'Ici vous pouvez envoyer de nouvelles images. Prenez note de ce qui suit :<br />La taille maximale autorisée de l\'image est de %d Ko.<br />Avant d\'envoyer une nouvelle image, vérifiez le copyright de celle-ci. Merci de respecter les droits d\'auteur.';
$lang['ABQ_IImageAdmin_Upload_ImageFile'] = 'Envoyer une image depuis votre ordinateur';
$lang['ABQ_IImageAdmin_Upload_ImageFile_Explain'] = '<br />Seuls les types d\'images/extensions de fichiers suivants sont valides : jpg, gif, png. Les autres types d\'images ne sont pas valides.<br />Seuls les caractères alphabétiques, nombres, tirets (-) et soulignements (_) sont autorisés dans le nom de fichier.<br />Vous ne pouvez pas écraser un fichier-image existant. Vous devez d\'abord supprimer l\'image et ensuite seulement vous pourrez envoyer la nouvelle police (avec le même nom de fichier).';

// error messages
$lang['ABQ_not_updated'] = 'La base de données n\'a pas été mise à jour.';
$lang['ABQ_ConfProzente'] = 'La valeur du pourcentage doit être comprise entre 0 et 100. Les décimales après la virgule ne sont pas autorisées.';
$lang['ABQ_ConfMaxEffekte'] = 'La limite maximale des effets utilisés doit être comprise entre 0 et 6. Les décimales après la virgule ne sont pas autorisées.';
$lang['ABQ_ConfGridW'] = 'La distance horizontale des lignes de la grille doit être à 0 ou comprise entre 10 et 100. Les décimales après la virgule ne sont pas autorisées.';
$lang['ABQ_ConfGridH'] = 'La distance verticale des lignes de la grille doit être à 0 ou comprise entre 10 et 50. Les décimales après la virgule ne sont pas autorisées.';
$lang['ABQ_ConfFontsize'] = 'La taille de police doit être supérieure à 14 et inférieure à 40. Les décimales après la virgule ne sont pas autorisées.';
$lang['ABQ_ConfJPGQuality'] = 'La valeur pour la qualité JPG doit être comprise entre 50 et 90. Les décimales après la virgule ne sont pas autorisées.';
$lang['ABQ_Question_too_long'] = 'La question est trop longue (longueur maximale autorisée : %s caractères)';
$lang['ABQ_Answer_too_long'] = 'Au moins une des réponses est trop longue (longueur maximale autorisée : %s caractères)';
$lang['ABQ_Missed_Question'] = 'Vous devez au moins entrer une question !';
$lang['ABQ_Missed_Answer'] = 'Vous devez au moins entrer une réponse !';
$lang['ABQ_No_Image'] = 'L\'image que vous avez sélectionnée n\'est pas disponible.';
$lang['ABQ_ColorRand_WrongValue'] = 'La valeur pour les couleurs doit être comprise entre 0 to 255. Les décimales après la virgule ne sont pas autorisées.';
$lang['ABQ_ColorRand_2NichtGroesser1'] = 'Si deux valeurs sont nécessaires pour une couleur, la seconde valeur doit être supérieure à la première. Vous l\'avez surement oublié, revenez en arrière et réessayez.';
$lang['ABQ_Valuereset_Not_Checked'] = 'Merci de cocher la case de confirmation de réinitialisation. Si vous ne la cochez pas, la réinitialisation ne sera pas effectuée.';
$lang['ABQ_Error_no_fonts'] = 'Aucune police n\'est disponible. <b>La police nommée "do-not-delete" est obligatoire pour le bon fonctionnement du MOD.</b> Réenvoyer cette police.';
$lang['ABQ_Error_font_missing'] = '<b>La police nommée "do-not-delete" est obligatoire pour le bon fonctionnement du MOD.</b>, or elle est manquante. Réenvoyer cette police.';
$lang['ABQ_upload_File_Error'] = 'Le fichier n\'a pas été envoyé.';
$lang['ABQ_upload_Font_FileSize'] = 'La taille du fichier de police doit être inférieure à %d Ko.';
$lang['ABQ_upload_File_exists'] = 'Un fichier avec le même nom existe déjà.<br />Supprimez le fichier existant ou renommez le fichier que vous désirez envoyer.';
$lang['ABQ_upload_File_WrongTyp'] = 'Ce fichier est d\'un format invalide ou a un nom de fichier invalide (Utilisez seulement les caractères alphabétiques, nombres tirets (-) et soulignements (_) dans les noms de fichiers).';
$lang['ABQ_delete_Font_false'] = 'Le fichier de police ne peut pas être supprimé.<br />Vous devez avoir les autorisations nécessaires pour supprimer des fichiers dans le répertoire /abq_mod/fonts/. Assurez-vous d\'avoir les droits requis. Le CHMOD sur ce répertoire doit être 777.';
$lang['ABQ_upload_no_File'] = 'Vous n\'avez choisi aucun fichier à envoyer !';
$lang['ABQ_upload_wrong_Filename'] = 'Nom de fichier invalide. Seuls les caractères alphabétiques, nombres, tirets (-) et soulignements (_) sont autorisés dans le nom de fichier. Renommez le fichier.';
$lang['ABQ_upload_can_not_create_File'] = 'Le fichier n\'a pas été envoyé. Vous devez avoir les autorisations nécessaires pour envoyer des fichiers. Assurez-vous d\'avoir les droits requis (chmod %s 777).';
$lang['ABQ_delete_Image_false'] = 'Le fichier-image ne peut pas être supprimé.<br />Vous devez avoir les autorisations nécessaires pour supprimer des fichiers dans le répertoire /images/abq_mod/. Assurez-vous d\'avoir les droits requis. Le CHMOD sur ce répertoire doit être 777.';
$lang['ABQ_upload_Image_FileSize'] = 'La taille du fichier-image doit être inférieure à %d Ko.';
$lang['ABQ_upload_Image_WrongTyp'] = 'Seuls les formats d\'images de type jpg, gif et png peuvent être envoyés. Les autres types d\'images ne sont pas supportés. Le type d\'image de votre nouvelle image est d\'un format invalide.';
$lang['ABQ_MC_or_nMC'] = 'Pas de choix multiple: Une ou plusieurs bonnes réponses et pas de mauvaise réponse; choix multiple: Seulement une bonne réponse et 10 mauvaises réponses. Les autres options n\'existent pas.';
$lang['ABQ_MC_AnswerMissing'] = 'Si vous voulez utiliser la fonction de choix multiple, vous devez entrer 10 mauvaises réponses.';
$lang['ABQ_MC_WAngRA'] = 'Une mauvaise réponse est identique à une bonne réponse.';
$lang['ABQ_MC_WA_doppelt'] = 'N\'utilisez pas deux fois la même mauvaise réponse.';

?>