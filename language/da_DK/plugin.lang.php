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
$lang['VIDEOS'] = 'videoer i dit galleri';
$lang['VIDEOS_THUMB'] = 'videoer med miniaturebilleder i dit galleri';
$lang['VIDEOS_GEOTAGGED'] = 'geotaggede videoer i dit galleri';

$lang['HTML5'] = 'HTML5-videotagindstillinger';
$lang['PRELOAD'] = 'Forindlæs';
$lang['PRELOAD_DESC'] = 'Indstillingen "Forindlæs" giver browseren besked om hvorvidt hentning af videodata skal begynde så snart videotag\'et er indlæst.';
$lang['CONTROLS'] = 'Kontroller';
$lang['CONTROLS_DESC'] = 'Kontrolvalgmulighederne bestemmer hvorvidt afspilleren har kontroller, som brugeren kan benytte';
$lang['AUTOPLAY'] = 'Autoafspil';
$lang['AUTOPLAY_DESC'] = 'Hvis autoafspil er sand, vil videoafspilningen begynde så snart siden indlæses (uden brugeren involveres). UNDERSTØTTES IKKE AF APPLE iOS-ENHEDER.';
$lang['LOOP'] = 'Løkke';
$lang['LOOP_DESC'] = 'Indstillingen "Løkke" får videoen til at begynde forfra, så snart den slutter.';
$lang['VOLUME'] = 'Lydstyrke';
$lang['VOLUME_DESC'] = 'Lydstyrkevalgmuligheden opsætter lydstyrkeniveauet. 0 betyder slået fra (tavs/mute). 1.0 er maksimal lydstyrke, mens 0.5 er halvvejen.';
$lang['LANGUAGE'] = 'Sprog';
$lang['LANGUAGE_DESC'] = 'Vælg afspillerens sprog';

$lang['METADATA_DESC'] = 'Metadatabeskrivelse';

$lang['PLAYER_DESC'] = 'Vælg vjs-afspillerversion';

$lang['PLUGIN'] = 'Pluginindstillinger';
$lang['SKIN'] = 'Skind';
$lang['SKIN_DESC'] = 'Vælg det udseende, du ønsker at give afspilleren, eller <a href="http://designer.videojs.com/" target="_blank">opret dit eget udseende</a>.';
$lang['CUSTOMCSS'] = 'Skræddersyet CSS';
$lang['CUSTOMCSS_DESC'] = 'Skræddersyet CSS til kopiering fra <a href="http://www.videojs.com/" target="_blank">VideoJS-hjemmesiden</a>.';
$lang['HEIGHT'] = 'Maksimal højde';
$lang['HEIGHT_DESC'] = 'Maksimal højde-attributten sætter den maksimale visningshøjde på videoen. Hvis videohøjden er større end den maksimale højde, vil videohøjden blive nedskaleret til den maksimale højde.';
$lang['UPSCALE'] = 'Opskalér';
$lang['UPSCALE_DESC'] = 'Hvis videostørrelsen er mindre end den maksimale bredde, vil videostørrelsen blive opskaleret til den maksimale bredde.';

$lang['VIDEOJSPLUGIN'] = 'VideoJS-plugins';
$lang['ZOOMROTATE'] = 'ZoomRotering';
$lang['ZOOMROTATE_DESC'] = 'Rotér og zoom en video, anvend om muligt roteringsmetadata.';
$lang['THUMBNAILS'] = 'Miniturebilleder';
$lang['THUMBNAILS_DESC'] = 'Vis miniaturebilleder over progressbjælken';
$lang['WATERMARK'] = 'Vandmærke';
$lang['WATERMARK_DESC'] = 'Vis vandmærker over vidoen';
$lang['RESOLUTION'] = 'Opløsning';
$lang['RESOLUTION_DESC'] = 'Opløsningsskifter.';

$lang['SYNC_ERRORS'] = 'Fejl';
$lang['SYNC_INFOS'] = 'Flere oplysninger';
$lang['SYNC_WARNINGS'] = 'Advarsler';

$lang['SYNC_METADATA_DESC'] = 'Overskriver oplysningerne i databasen med metadata fra videoen.';

$lang['SYNC_POSTER'] = 'Opret en plakat ved position i sekunder';
$lang['SYNC_POSTER_DESC'] = 'Opret en plakat fra videoen på den angivne position.';
$lang['SYNC_POSTEROVERWRITE'] = 'Overskriv eksisterende plakater';
$lang['SYNC_POSTEROVERWRITE_DESC'] = 'Overskriv eksisterende miniaturebilleder med nye. Hvis uafkrydset, kører det kun på nyligt tilføjet video.';
$lang['SYNC_OUTPUT'] = 'Outputformat';
$lang['SYNC_OUTPUT_DESC'] = 'Vælg outputformat til plakat og miniaturebillede.';
$lang['SYNC_POSTEROVERLAY'] = 'Tilføj filmeffekt';
$lang['SYNC_POSTEROVERLAY_DESC'] = 'Indfør en billedtilretning (overlay) på plakatoprettelsen. ';

$lang['SYNC_THUMBSEC'] = 'Opret et miniaturebillede hvert sekund';
$lang['SYNC_THUMBSEC_DESC'] = 'Opret et miniaturebillede hvert x sekunder.';
$lang['SYNC_THUMBSIZE'] = 'Størrelse på miniaturebillede';
$lang['SYNC_THUMBSIZE_DESC'] = 'Størrelse i pixels, hold det småt, standarden er fin. Youtube anvender 190*68.';
$lang['INTRO_METADATA'] = 'udtrækker metadata med <a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo</a> eller <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a> (hvis tilgængelig)';
$lang['INTRO_SUPPORT'] = 'Se <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki" target="_blank">plugin-dokumentationen</a> for yderligere oplysninger samt besøg <a href="https://piwigo.org/forum/" target="_blank">forummet</a>, hvis du løber ind i problemer.<br/>For at rapportere fejl og foreslå nye funktioner, bedes du oprette en ny <a href="https://github.com/xbgmsharp/piwigo-videojs/issues" target="_blank">sag</a> (issue).';
$lang['INTRO_THUMB'] = 'fremstiller miniaturebilleder med <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a> (hvis tilgængelig)';
$lang['INTRO_VIDEOJS'] = 'tilføjer open source HTML5-videoafspilleren <a href="http://www.videojs.com/" target="_blank">VideoJS</a>';
$lang['SYNC_DELETE_DESC'] = 'Nyttig til videoer, som ikke indeholder retningsmetadata og som vises med en VideoJS-afspiller med brug af plugin\'en videojs-zoomrotate. Videoen og dens plakat forbliver uberørte. Kun retningsparameteret gemt i databasen blive opdateret.';
$lang['SYNC_METADATA_ADDED'] = 'video(er) med metadata tilføjet';
$lang['SYNC_POSTERS_NEW'] = 'plakat(er) oprettet';
$lang['SYNC_POSTER_REQUIRE'] = 'Kræv <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a>';
$lang['SYNC_POSTER_TITLE'] = 'Plakater til fotogalleri';
$lang['SYNC_REQUIRE'] = 'Kræver <a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo</a> eller <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a>';
$lang['SYNC_RESULTS'] = 'Resultat af synkronisering';
$lang['SYNC_THUMB'] = 'VideoJS-miniaturebilleder';
$lang['SYNC_THUMBSIZE_ERROR'] = 'Ugyldig større på miniaturebillede, benytter i stedet standardværdien på 120 px';
$lang['SYNC_THUMBS_NEW'] = 'VideoJS-miniaturebillede(r) oprettet';
$lang['SYNC_THUMB_ERROR'] = 'FFmpeg kunne ikke generere miniaturebillederne, tjek logninger og prøv manuelt';
$lang['SYNC_WARNINGS_COUNT'] = 'advarsel/advarsler under synkronisering';
$lang['VIDEOS_ALL'] = 'Alle videoer';
$lang['VIDEOS_METADATA_POSTERS'] = 'Videometadata og plakater';
$lang['VIDEOS_WO_POSTER'] = 'Alle videoer uden plakater';
$lang['VIDEOS_W_POSTER'] = 'Alle videoer med plakater';
$lang['POSTER'] = 'Plakat';
$lang['SYNC_DETECTED'] = 'video(er) fundet';
$lang['SYNC_DURATION_ERROR'] = 'ukendt længde, plakaten kan ikke oprettet';
$lang['SYNC_DURATION_SHORT'] = 'for kort længde, plakaten vil blive oprettet på en anden position';
$lang['SYNC_ERROR_COUNT'] = 'fejl under synkronisering';
$lang['SYNC_INTRO'] = 'Synkronisering af metadata oprettelse af miniturebilleder til videoer:';
$lang['SYNC_METADATA'] = 'Metadata';
$lang['DIR_NOT_WRITABLE'] = 'mappe uden skriveadgang';
$lang['FILE_NOT_READABLE'] = 'fil ikke læsbar';
$lang['INTRO_CONFIG'] = 'Denne plugin:';
$lang['METADATA'] = 'Metadata';
$lang['METADATA_COUNT'] = 'Antal metadataelementer';
$lang['METADATA_FILE'] = 'Vis fil:';
$lang['MOVIE'] = 'Film';
$lang['PLAYER'] = 'Afspiller';
$lang['PLAYER_TYPE'] = 'Type:';
$lang['POSTER_ERROR'] = 'FFmpeg kunne ikke generere plakaten, tjek logninger og prøv manuelt';
$lang['SYNC_DATABASE'] = 'Metadata udtrukket fra databasen';
$lang['SYNC_DELETE'] = 'Slet VideoJS-miniaturebilleder og ekstra videokilder';
$lang['SYNC_DELETE_ASK'] = 'Er du sikker? Ekstra videokilder og VideoJS-miniaturebilleder vil blive slettet.';