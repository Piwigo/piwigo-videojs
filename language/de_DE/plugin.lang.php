<?php
// +-----------------------------------------------------------------------+
// | Piwigo - a PHP based photo gallery                                    |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2008-2013 Piwigo Team                  http://piwigo.org |
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
$lang['STATS'] = 'Statistik';
$lang['VIDEOS'] = 'Videos in Ihrer Galerie';
$lang['VIDEOS_THUMB'] = 'Videos mit Miniaturbild in Ihrer Galerie';
$lang['VIDEOS_GEOTAGGED'] = 'mit Geotags versehene Videos in Ihrer Galerie';

$lang['HTML5'] = 'HTML5 Video Tag Einstellungen';
$lang['PRELOAD'] = 'vorab laden';
$lang['PRELOAD_DESC'] = 'Das preload Attribut informiert den Browser, ob oder ob nicht das Video geladen wird, sobald der video Tag geladen wurde.';
$lang['CONTROLS'] = 'Steuerung';
$lang['CONTROLS_DESC'] = 'Mit der Steuerungsoption wird festgelegt, ob der Player Steuerelemente, die der Benutzer nutzen kann, hat oder nicht';
$lang['AUTOPLAY'] = 'autom. abspielen';
$lang['AUTOPLAY_DESC'] = 'Wenn "autom. abspielen" gesetzt ist, wird das Video, nachdem die Seite geladen ist, abgespielt (ohne jegliche Interaktion durch den Benutzer). WIRD NICHT VON APPLE IOS GERÄTEN UNTERSTÜTZT';
$lang['LOOP'] = 'Schleife';
$lang['LOOP_DESC'] = 'Das Attribut "Schleife" startet das Video wieder, nachdem es beendet wurde.';
$lang['VOLUME'] = 'Lautstärke';
$lang['VOLUME_DESC'] = 'Die Lautstärkeregelung bestimmt die Lautstärke (0 ist lautlos, 0.5 ist halbe Lautstärke, 1 ist Maximallautstärke).';
$lang['LANGUAGE'] = 'Sprache';
$lang['LANGUAGE_DESC'] = 'Player-Sprache festlegen';

$lang['METADATA_DESC'] = 'Metadatenbeschreibung';

$lang['PLAYER_DESC'] = 'Wählen Sie die vjs Player Version aus.';

$lang['PLUGIN'] = 'Plugin-Einstellungen';
$lang['SKIN'] = 'Design';
$lang['SKIN_DESC'] = 'Wähle das Aussehen des Players';
$lang['CUSTOMCSS'] = 'Benutzer CSS';
$lang['CUSTOMCSS_DESC'] = 'Benutzer CSS, um von der VideoJS Webseite zu kopieren u. einzufügen';
$lang['HEIGHT'] = 'Maximale Höhe';
$lang['HEIGHT_DESC'] = 'Das Attribut maximale Höhe legt die maximale Anzeigegrösse des Videos fest. Falls die Video-Breite höher ist, als die maximale Höhe, wird das Video entsprechend auf die maximale Höhe verkleinert.';
$lang['UPSCALE'] = 'Hochrechnen';
$lang['UPSCALE_DESC'] = 'Die Videogröße wird auf die Maximalbreite hochgerechnet, wenn sie kleiner als diese ist.';

$lang['VIDEOJSPLUGIN'] = 'VideoJS Plugins';
$lang['ZOOMROTATE'] = 'Zoomrate';
$lang['ZOOMROTATE_DESC'] = 'Benutze die Videometadaten, um das Video zu drehen und zu zoomen.';
$lang['THUMBNAILS'] = 'Vorschaubilder';
$lang['THUMBNAILS_DESC'] = 'Vorschaubilder über der Fortschrittsanzeige darstellen.';
$lang['WATERMARK'] = 'Wasserzeichen';
$lang['WATERMARK_DESC'] = 'Wasserzeichen über dem Video anzeigen.';
$lang['RESOLUTION'] = 'Auflösung';
$lang['RESOLUTION_DESC'] = 'Auflösungswähler.';

$lang['SYNC_ERRORS'] = 'Fehler';
$lang['SYNC_WARNINGS'] = 'Warnungen';
$lang['SYNC_INFOS'] = 'Detailinformation';

$lang['SYNC_METADATA_DESC'] = 'Wird die Informationen in der Datenbank mit den Metadaten des Videos überschreiben.';

$lang['SYNC_POSTER'] = 'Poster erstellen bei Sekunde';
$lang['SYNC_POSTER_DESC'] = 'Erstelle ein Poster des Videos an der angegebenen Position.';
$lang['SYNC_POSTEROVERWRITE'] = 'Existierende Poster überschreiben';
$lang['SYNC_POSTEROVERWRITE_DESC'] = 'Überschreibt vorhandene Miniaturbilder. Falls nicht aktiviert sollte die Funktion nur auf neu hinzugefügte Videos angewendet werden.';
$lang['SYNC_OUTPUT'] = 'Ausgabeformat';
$lang['SYNC_OUTPUT_DESC'] = 'Wähle das Ausgabeformat für das Poster und das Vorschaubild.';
$lang['SYNC_POSTEROVERLAY'] = 'Fügt Filmeffekt hinzu';
$lang['SYNC_POSTEROVERLAY_DESC'] = 'Wende ein Overlay während der Postererstellung an.';

$lang['SYNC_THUMBSEC'] = 'Erstellt jede Sekunde ein Miniaturbild';
$lang['SYNC_THUMBSEC_DESC'] = 'Erstellt alle x Sekunden ein Miniaturbild.';
$lang['SYNC_THUMBSIZE'] = 'Größe des Miniaturbilds';
$lang['METADATA_DESC'] = 'Metadatenbeschreibung';
$lang['SYNC_THUMBSIZE_DESC'] = 'Größe in Pixeln (Standard-Einstellung wird empfohlen, YouTube verwendet 190x68) ';
$lang['SYNC_WARNINGS_COUNT'] = 'Warnung(en) während der Synchronisierung';
$lang['VIDEOS_ALL'] = 'Alle Videos';
$lang['VIDEOS_METADATA_POSTERS'] = 'Video-Metadaten und Poster';
$lang['VIDEOS_WO_POSTER'] = 'Alle Videos ohne Poster';
$lang['VIDEOS_W_POSTER'] = 'Alle Videos mit Poster';
$lang['SYNC_RESULTS'] = 'Ergebnisse der Synchronisierung';
$lang['SYNC_THUMB'] = 'VideoJS-Miniaturansichten';
$lang['SYNC_THUMBS_NEW'] = 'VideoJS-Miniaturansicht(en) erstellt';
$lang['SYNC_POSTERS_NEW'] = 'Plakat(e) erstellen';
$lang['SYNC_POSTER_REQUIRE'] = 'Erfordert <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a>';
$lang['SYNC_POSTER_TITLE'] = 'Plakate für die Fotogalerie';
$lang['SYNC_ERROR_COUNT'] = 'Fehler bei der Synchronisierung';
$lang['SYNC_INTRO'] = 'Synchronisierung von Metadaten und Erstellung von Miniaturansichten für Videos:';
$lang['SYNC_METADATA'] = 'Metadaten';
$lang['SYNC_METADATA_ADDED'] = 'Video(s) mit hinzugefügten Metadaten';
$lang['SYNC_DELETE'] = 'Löschen von VideoJS-Miniaturansichten und zusätzlichen Videoquellen';
$lang['SYNC_DELETE_ASK'] = 'Sind Sie sicher? Zusätzliche Videoquellen und VideoJS-Miniaturansichten werden gelöscht.';
$lang['SYNC_DETECTED'] = 'Video(s) entdeckt';
$lang['METADATA'] = 'Metadaten';
$lang['METADATA_FILE'] = 'Datei anzeigen:';
$lang['PLAYER'] = 'Player';
$lang['PLAYER_TYPE'] = 'Art:';
$lang['SYNC_REQUIRE'] = 'Erfordert <a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo</a> or <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a>';
$lang['INTRO_CONFIG'] = 'Dieses Plugin:';
$lang['INTRO_METADATA'] = 'extrahiert Metadaten mit <a href=„https://exiftool.org“ target=„_blank“>ExifTool</a>, <a href=„http://mediaarea.net/en/MediaInfo“ target=„_blank“>MediaInfo</a> or <a href=„http://www.ffmpeg.org“ target=„_blank“>FFprobe</a> (if available)';
$lang['INTRO_SUPPORT'] = 'Siehe dazu die <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki" target="_blank">plugin documentation</a> für zusätzliche Informationen und sehen Sie sich die <a href="https://piwigo.org/forum/" target="_blank">forums</a> <br/> Um Fehler zu melden und neue Funktionen vorzuschlagen, erstellen Sie bitte einen neuen <a href="https://github.com/xbgmsharp/piwigo-videojs/issues" target="_blank">issue</a>.';
$lang['INTRO_THUMB'] = 'erzeugt Miniaturbilder mit <a href=„http://www.ffmpeg.org“ target=„_blank“>FFmpeg</a> (falls verfügbar)';
$lang['INTRO_VIDEOJS'] = 'fügt den quelloffenen HTML5-Video-Player <a href=„http://www.videojs.com/“ target=„_blank“>VideoJS</a> hinzu';
$lang['SYNC_DELETE_DESC'] = 'Nützlich für Videos, die keine Orientierungsmetadaten enthalten und die mit einem VideoJS-Player in Verbindung mit dem videojs-zoomrotate-Plugin angezeigt werden. Das Video und sein Poster bleiben unangetastet. Nur der in der Datenbank gespeicherte Orientierungsparameter wird aktualisiert.';
$lang['SYNC_DURATION_ERROR'] = 'unbekannte Dauer, das Plakat kann nicht erstellt werden';
$lang['SYNC_DURATION_SHORT'] = 'zu kurze Dauer, wird das Plakat an einer anderen Stelle erstellt';
$lang['SYNC_THUMBSIZE_ERROR'] = 'Ungültige Thumbnail-Größe, Rückfall auf Standardwert von 120 px';
$lang['SYNC_THUMB_ERROR'] = 'FFmpeg konnte die Thumbnails nicht erzeugen, prüfen Sie die Logs und versuchen Sie es manuell';
$lang['MOVIE'] = 'Film';
$lang['POSTER'] = 'Poster';
$lang['POSTER_ERROR'] = 'FFmpeg konnte das Poster nicht erstellen, prüfen Sie die Protokolle und versuchen Sie es manuell';
$lang['SYNC_DATABASE'] = 'us der Datenbank extrahierte Metadaten';
$lang['DIR_NOT_WRITABLE'] = 'Verzeichnis ohne Schreibzugriff';
$lang['FILE_NOT_READABLE'] = 'Datei nicht lesbar';
$lang['METADATA_COUNT'] = 'Anzahl der Metadatenelemente:';