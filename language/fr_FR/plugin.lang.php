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
$lang['INTRO_SUPPORT'] = 'Reportez-vous à la <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki" target="_blank">documentation du plugin</a> pour de plus amples informations et consultez les <a href="https://piwigo.org/forum/" target="_blank">forums</a> si vous rencontrez des problèmes.<br/>Pour signaler des bogues et suggérer de nouvelles fonctionnalités, veuillez créer un nouveau <a href="https://github.com/xbgmsharp/piwigo-videojs/issues" target="_blank">problème</a>.';

$lang['STATS'] = 'Statistiques';
$lang['VIDEOS'] = 'vidéos dans votre galerie';
$lang['VIDEOS_THUMB'] = 'vidéos avec vignette dans votre galerie';
$lang['VIDEOS_GEOTAGGED'] = 'vidéos géolocalisées dans votre galerie';

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

$lang['METADATA'] = 'Métadonnées';
$lang['METADATA_FILE'] = 'Montrer le fichier :';
$lang['METADATA_DESC'] = 'Présente ou pas les métadonnées';

$lang['PLAYER'] = 'Lecteur';
$lang['PLAYER_TYPE'] = 'Type :';
$lang['PLAYER_DESC'] = 'Sélectionner le type et la version du lecteur.';

$lang['PLUGIN'] = 'Plugin préférences';
$lang['SKIN'] = 'Style';
$lang['SKIN_DESC'] = 'Selectionne un style a appliquer au lecteur ou <a href="http://designer.videojs.com/" target="_blank">creer votre propre style</a>.';
$lang['CUSTOMCSS'] = 'Custom CSS';
$lang['CUSTOMCSS_DESC'] = 'Custom CSS a copier coller depuis le site web de <a href="http://www.videojs.com/" target="_blank">VideoJS</a>.';
$lang['HEIGHT'] = 'Hauteur max';
$lang['HEIGHT_DESC'] = 'L\'attribut hauteur max désigne la hauteur maximum affichée pour la vidéo. Si la hauteur de la vidéo dépasse cette taille, elle sera réduit à cette limite.';
$lang['UPSCALE'] = 'Upscale';
$lang['UPSCALE_DESC'] = 'Si la taille de la video est plus petite que le parametre max width, la video sera agrandi aux dimension de max width.';

$lang['VIDEOJSPLUGIN'] = 'VideoJS plugins';
$lang['ZOOMROTATE'] = 'Tourne, adapte :';
$lang['ZOOMROTATE_DESC'] = 'Tourne et adapte la vidéo quand cela est possible, utilise la métadonnée rotation.';
$lang['THUMBNAILS'] = 'Miniatures :';
$lang['THUMBNAILS_DESC'] = 'Affiche les miniatures sur la barre de progression.';
$lang['WATERMARK'] = 'Filigrane :';
$lang['WATERMARK_DESC'] = 'Affiche un filigrane sur la vidéo.';
$lang['RESOLUTION'] = 'Résolution :';
$lang['RESOLUTION_DESC'] = 'Curseur de résolution';

$lang['SYNC_INTRO'] = 'Synchronisation des méta-données et création de vignettes pour les vidéos :';
$lang['SYNC_ERRORS'] = 'Erreurs';
$lang['SYNC_WARNINGS'] = 'Alertes';
$lang['SYNC_INFOS'] = 'Informations détaillées';

$lang['SYNC_METADATA_DESC'] = 'Remplacera les informations en base de données par les métadonnées de la vidéo. ';

$lang['SYNC_POSTER'] = 'Crée une affiche à la position en seconde';
$lang['SYNC_POSTER_DESC'] = 'Crée une affiche pour la vidéo à la position spécifiée. ';
$lang['SYNC_POSTEROVERWRITE'] = 'Remplace les affiches existantes';
$lang['SYNC_POSTEROVERWRITE_DESC'] = 'Remplace les affiches existantes par les nouvelles. Si décoché cela sera actif uniquement pour les prochaines vidéos ajoutées. ';
$lang['SYNC_OUTPUT'] = 'Format de sortie';
$lang['SYNC_OUTPUT_DESC'] = 'Sélectionne le format de sortie pour l\'affiche et la miniature. ';
$lang['SYNC_POSTEROVERLAY'] = 'Ajouter un effet au film';
$lang['SYNC_POSTEROVERLAY_DESC'] = 'Applique un calque à la création de l\'affiche. ';

$lang['SYNC_THUMBSEC'] = 'Crée une miniature à chaque seconde';
$lang['SYNC_THUMBSEC_DESC'] = 'Crée une miniature toutes les x secondes';
$lang['SYNC_THUMBSIZE'] = 'Taille de la miniature';
$lang['SYNC_THUMBSIZE_DESC'] = 'Taille en pixels, gardez une petite taille, celle par défaut est correcte, Youtube utilise 190x68';
?>
