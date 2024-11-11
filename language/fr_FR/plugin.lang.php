<?php
// +-----------------------------------------------------------------------+
// | Piwigo - a PHP based photo gallery                                    |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2008-2015 Piwigo Team                  http://piwigo.org |
// | Copyright(C) 2003-2008 PhpWebGallery Team    http://phpwebgallery.net |
// | Copyright(C) 2002-2003 Pierrick LE GALL   http://le-gall.net/pierrick |
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation                                          |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, |
// | USA.                                                                  |
// +-----------------------------------------------------------------------+
$lang['INTRO_CONFIG'] = 'Ce plugin:';
$lang['INTRO_VIDEOJS'] = 'ajoute un lecteur HTML5 open source <a href="http://www.videojs.com/" target="_blank">VideoJS</a>';
$lang['INTRO_METADATA'] = 'extrait les métadonnées avec <a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo</a> ou <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a> (si disponible)';
$lang['INTRO_THUMB'] = 'produit des vignettes avec <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a> (si disponible)';
$lang['INTRO_SUPPORT'] = 'Reportez-vous à la <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki" target="_blank">documentation du plugin</a> pour de plus amples informations et consultez les <a href="https://piwigo.org/forum/" target="_blank">forums</a> si vous rencontrez des problèmes.<br/>Pour signaler des bogues et suggérer de nouvelles fonctionnalités, veuillez créer une nouvelle <a href="https://github.com/xbgmsharp/piwigo-videojs/issues" target="_blank">issue</a>.';

$lang['STATS'] = 'Statistiques';
$lang['VIDEO'] = 'Vidéo';
$lang['VIDEO_SRC'] = 'Sources vidéo';
$lang['VIDEOS'] = 'vidéo(s) dans votre galerie';
$lang['VIDEOS_THUMB'] = 'vidéo(s) avec affiche dans votre galerie';
$lang['VIDEOS_GEOTAGGED'] = 'vidéo(s) géolocalisée(s) dans votre galerie';

$lang['HTML5'] = 'Réglages HTML5';
$lang['PRELOAD'] = 'Préchargement :';
$lang['PRELOAD_DESC'] = 'The preload attribute informs the browser whether or not the video data should begin downloading as soon as the video tag is loaded.';
$lang['CONTROLS'] = 'Contrôles :';
$lang['CONTROLS_DESC'] = 'L\'option de contrôles autorise ou non l\'utilisateur à interagir avec les éléments de contrôle.';
$lang['AUTOPLAY'] = 'Lecture automatique';
$lang['AUTOPLAY_DESC'] = 'Si la lecture automatique est activée, la vidéo démarrera aussitôt la page téléchargée (sans action de la part de l\'utilisateur). NON SUPPORTE PAR LES TERMINAUX APPLE.';
$lang['LOOP'] = 'Répétition :';
$lang['LOOP_DESC'] = 'The loop attribute causes the video to start over as soon as it ends.';
$lang['VOLUME'] = 'Volume :';
$lang['VOLUME_DESC'] = 'L\'option de volume positionne le niveau du volume. 0 son coupé, 1 son au maximum, 0.5 son à la moitié.';
$lang['LANGUAGE'] = 'Langue :';
$lang['LANGUAGE_DESC'] = 'Sélectionner la langue du lecteur';

$lang['METADATA'] = 'Méta-données';
$lang['METADATA_FILE'] = 'Montrer le fichier :';
$lang['METADATA_DESC'] = 'Présente ou pas les métadonnées';

$lang['PLAYER'] = 'Lecteur';
$lang['PLAYER_TYPE'] = 'Type :';
$lang['PLAYER_DESC'] = 'Sélectionner le type et la version du lecteur.';

$lang['VIDEOJS_SETTINGS'] = 'Réglages VideoJS';
$lang['SKIN'] = 'Style';
$lang['SKIN_DESC'] = 'Sélectionne un style à appliquer au lecteur ou <a href="http://designer.videojs.com/" target="_blank">créer votre propre style</a>.';
$lang['CUSTOMCSS'] = 'Custom CSS';
$lang['CUSTOMCSS_DESC'] = 'Custom CSS a copier coller depuis le site web de <a href="http://www.videojs.com/" target="_blank">VideoJS</a>.';
$lang['HEIGHT'] = 'Hauteur max';
$lang['HEIGHT_DESC'] = 'L\'attribut hauteur max désigne la hauteur maximum affichée pour la vidéo. Si la hauteur de la vidéo dépasse cette taille, elle sera réduit à cette limite.';
$lang['UPSCALE'] = 'Upscale';
$lang['UPSCALE_DESC'] = 'Si la taille de la video est plus petite que le parametre max width, la video sera agrandi aux dimension de max width.';
$lang['ZOOMROTATE'] = 'Tourne, adapte :';
$lang['ZOOMROTATE_DESC'] = 'Tourne et adapte la vidéo quand cela est possible, utilise la métadonnée rotation.';
$lang['THUMBNAILS'] = 'Miniatures :';
$lang['THUMBNAILS_DESC'] = 'Affiche les miniatures sur la barre de progression.';
$lang['WATERMARK'] = 'Filigrane :';
$lang['WATERMARK_DESC'] = 'Affiche un filigrane sur la vidéo.';
$lang['RESOLUTION'] = 'Résolution :';
$lang['RESOLUTION_DESC'] = 'Curseur de résolution';

$lang['SYNC_INTRO'] = 'Synchronisation des méta-données et création de vignettes pour les vidéos :';
$lang['SYNC_NONE'] = 'Vous m\'avez demandé de ne rien faire!';
$lang['SYNC_INFOS'] = 'Informations détaillées';
$lang['SYNC_RESULTS'] = 'Résultats de la synchronisation';
$lang['SYNC_DETECTED'] = 'vidéo(s) détectée(s)';
$lang['SYNC_METADATA_ADDED'] = 'vidéo(s) avec méta-données ajoutées';
$lang['SYNC_POSTERS_NEW'] = 'affiche(s) adoptée(s) ou créée(s)';
$lang['SYNC_THUMBS_NEW'] = 'miniature(s) VideoJS créée(s)';
$lang['SYNC_WARNINGS'] = 'Alertes';
$lang['SYNC_WARNINGS_COUNT'] = 'alerte(s) pendant la synchronisation';
$lang['SYNC_ERRORS'] = 'Erreurs';
$lang['SYNC_ERROR_COUNT'] = 'erreur(s) pendant la synchronisation';
$lang['FILE_NOT_READABLE'] = 'fichier illisible';
$lang['DIR_NOT_WRITABLE'] = 'répertoire sans accès en écriture';

$lang['SYNC_METADATA'] = 'Meta-données';
$lang['METADATA_COUNT'] = 'Nombre de méta-données :';
$lang['SYNC_DATABASE'] = 'Méta-données extraites de la base de données';
$lang['SYNC_REQUIRE'] = 'Requiert <a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo</a> ou <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a> :';
$lang['SYNC_METADATA_DESC'] = 'Remplacera les informations en base de données par les méta-données de la vidéo. ';
$lang['SYNC_METADATA_ERROR'] = 'Les métadonnées ne peuvent pas être récupérées car ExifTool, FFprobe ou MediaInfo ne sont pas installés ou leurs chemins d\'accès sont incorrects.';
$lang['SYNC_MEDIAINFO_ERROR'] = 'Les métadonnées ne peuvent pas être récupérées avec MediaInfo car la bibliothèque XML n\'est pas installée.';
$lang['SYNC_DELETE'] = 'Effacer les sources secondaires et les miniatures VideoJS';
$lang['SYNC_DELETE_ASK'] = 'Etes-vous certain(e)? Les vidéos source secondaires et les miniatures VideoJS seront effacées.';
$lang['SYNC_DELETE_DESC'] = 'Utile pour les vidéos qui n\'incluent pas de métadonnées d\'orientation et qui sont affichées avec un lecteur VideoJS en conjonction avec le plugin videojs-zoomrotate. La vidéo et son affiche restent inchangées. Seul le paramètre d\'orientation stocké dans la base de données est mis à jour.';

$lang['POSTER'] = 'Affiche';
$lang['POSTER_ERROR'] = 'FFmpeg n\'a pas pu générer l\'affiche, vérifiez les journaux et essayez manuellement';
$lang['SYNC_REPRESENTATIVES'] = 'Adopte les posters téléchargés manuellement';
$lang['SYNC_REPRESENTATIVES_DESC'] = 'Pour chaque vidéo, met à jour les informations liées à son affiche.';
$lang['SYNC_POSTER_TITLE'] = 'Affiches pour la galerie photo';
$lang['SYNC_POSTER'] = 'Créer des affiches à la position en secondes :';
$lang['SYNC_POSTER_DESC'] = 'Crée une affiche à partir de la vidéo à la position spécifiée en secondes. ';
$lang['SYNC_POSTER_REQUIRE'] = 'Requiert <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a> :';
$lang['SYNC_POSTER_ERROR'] = 'La création de posters et de vignettes est désactivée car FFmpeg n\'est pas installé ou son chemin d\'accès est incorrect.';
$lang['SYNC_POSTEROVERWRITE'] = 'Remplacer les affiches existantes';
$lang['SYNC_POSTEROVERWRITE_DESC'] = 'Remplace les affiches existantes par les nouvelles. Si décoché cela sera actif uniquement pour les prochaines vidéos ajoutées. ';
$lang['SYNC_OUTPUT'] = 'Format :';
$lang['SYNC_OUTPUT_DESC'] = 'Sélectionne le format de sortie pour l\'affiche et la miniature. ';
$lang['SYNC_POSTEROVERLAY'] = 'Ajouter un effet de film';
$lang['SYNC_POSTEROVERLAY_DESC'] = 'Applique un calque à la création de l\'affiche. ';
$lang['SYNC_POSTEROVERLAY_ERROR'] = 'Effet de film désactivé car la bibliothèque GD n\'est pas installée.';
$lang['SYNC_DURATION_ERROR'] = 'durée inconnue, l\'affiche ne peut être créée';
$lang['SYNC_DURATION_SHORT'] = 'durée trop courte, affiche produite à une autre position';

$lang['SYNC_THUMB'] = 'Miniatures VideoJS';
$lang['SYNC_THUMB_ERROR'] = 'FFmpeg n\'a pas pu générer les vignettes, vérifiez les logs et essayez manuellement';
$lang['SYNC_THUMBSEC'] = 'Créer une vignette toutes les N secondes où N = ';
$lang['SYNC_THUMBSEC_DESC'] = 'Ces miniatures sont seulement utilisées par VideoJS.';
$lang['SYNC_THUMBSIZE'] = 'Taille de la miniature :';
$lang['SYNC_THUMBSIZE_DESC'] = 'Taille en pixels, gardez une petite taille, celle par défaut est correcte, Youtube utilise 190x68';
$lang['SYNC_THUMBSIZE_ERROR'] = 'taille de vignette non valide, retour à la valeur par défaut de 120 px';

$lang['VIDEOS_ALL'] = 'Toutes les vidéos';
$lang['VIDEOS_W_POSTER'] = 'Toutes les vidéos avec affiche';
$lang['VIDEOS_WO_POSTER'] = 'Toutes les vidéos sans affiche';
$lang['VIDEOS_METADATA_POSTERS'] = 'Meta-données et posters des vidéos';
?>
