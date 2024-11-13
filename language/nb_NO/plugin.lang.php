<?php
// +-----------------------------------------------------------------------+
// | Piwigo - a PHP based photo gallery                                    |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2008-2014 Piwigo Team                  http://piwigo.org |
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
$lang['SYNC_METADATA_DESC'] = 'Vil overskrive informasjonen i data basen med metadata fra videoen.';
$lang['SYNC_OUTPUT'] = 'Utskrifts format';
$lang['SYNC_OUTPUT_DESC'] = 'Velg utskrifts format for plakaten og miniatyrbilde. ';
$lang['SYNC_POSTER'] = 'Lager en plakat i posisjon på sekunder';
$lang['SYNC_INFOS'] = 'Detaljert informasjon';
$lang['SYNC_ERRORS'] = 'Feil';
$lang['SKIN'] = 'Stil';
$lang['SKIN_DESC'] = 'Velg stilen du vil bruke på spilleren eller <a href="http://designer.videojs.com/" target="_blank">lage din egen Stil</a>.';
$lang['CUSTOMCSS'] = 'Tilpasset CSS';
$lang['LOOP_DESC'] = 'Sløyfens egenskaper får videoen til å starte på nytt så snart den slutter.';
$lang['PRELOAD'] = 'Last på nytt';
$lang['PRELOAD_DESC'] = 'Last på nytt egenskapen informerer nettleseren om ikke nedlastningen av videodata bør begynne så snart video taggen er lastet';
$lang['LOOP'] = 'Sløyfe';
$lang['HTML5'] = 'HTML5 video tagg innstillinger';
$lang['CUSTOMCSS_DESC'] = 'Tilpasset CSS for å kopiere/lime inn fra <a href="http://www.videojs.com/" target="_blank">VideoJS website</a>.';
$lang['CONTROLS'] = 'Kontrollelementer';
$lang['CONTROLS_DESC'] = 'Kontrollelementenes alternativ angir hvorvidt eller ikke spilleren har kontroller som brukeren kan samhandle med';
$lang['AUTOPLAY_DESC'] = 'Hvis autokjør er valgt, vil videoen begynn å spille så snart siden er lastet (uten interaksjon fra brukeren). STØTTES IKKE AV APPLE iOS ENHETER.';
$lang['AUTOPLAY'] = 'Autokjør';
$lang['SYNC_POSTEROVERLAY'] = 'Legg til film effekt';
$lang['SYNC_POSTEROVERLAY_DESC'] = 'Påfør et overlegg på plakat skapelsen.';
$lang['SYNC_POSTEROVERWRITE'] = 'Overskrive eksisterende plakater';
$lang['SYNC_POSTEROVERWRITE_DESC'] = 'Overskrive eksisterende miniatyrbilder med nye. Hvis ikke avkrysset skal det bare kjøre for nylig tillagte video.';
$lang['ZOOMROTATE'] = 'Zoom Roter';
$lang['ZOOMROTATE_DESC'] = 'Rotere og zoome en video hvis det er aktuelt, bruker rotasjons metadata.';
$lang['WATERMARK_DESC'] = 'Vis vannmerke over videoen';
$lang['WATERMARK'] = 'Vannmerke';
$lang['VOLUME'] = 'Volum';
$lang['VOLUME_DESC'] = 'Alternativet Angir volumnivået. 0 er av (dempet), 1.0 er hele veien opp, 0.5 er halvveis.';
$lang['UPSCALE_DESC'] = 'Hvis videostørrelsen er mindre enn maks bredde, vil det oppskalere video størrelse til maks bredde.';
$lang['UPSCALE'] = 'Oppskalere';
$lang['SYNC_WARNINGS'] = 'Advarsler';
$lang['THUMBNAILS'] = 'Miniatyrbilder';
$lang['THUMBNAILS_DESC'] = 'Viser miniatyrbilder over fremdriftslinjen.';
$lang['SYNC_THUMBSIZE_DESC'] = 'Størrelse i piksler, beholde det lit, standard er bra, Youtube bruke 190x68.';
$lang['SYNC_THUMBSIZE'] = 'Størrelsen på miniatyrbilde';
$lang['SYNC_THUMBSEC_DESC'] = 'Lag et miniatyrbilde hvert x antall sekunder';
$lang['SYNC_THUMBSEC'] = 'Lag et miniatyrbilde hvert sekund';
$lang['SYNC_POSTER_DESC'] = 'Lag en plakat fra videoen og angi posisjon.';
$lang['HEIGHT_DESC'] = 'Maks høyde valget angir maksimal visningshøyden på videoen. Hvis videohøyden er større enn maks høyde, vil den nedskalere videostørrelsen til maks høyde.';
$lang['HEIGHT'] = 'Maks høyde';
$lang['LANGUAGE'] = 'Språk';
$lang['LANGUAGE_DESC'] = 'Avspillerspråk';
$lang['METADATA_DESC'] = 'Metadate beskrivelse';
$lang['PLAYER_DESC'] = 'Velg vjs spillerversjon.';
$lang['RESOLUTION'] = 'Oppløsning';
$lang['RESOLUTION_DESC'] = 'Oppløsningsbryter';
$lang['VIDEOS_METADATA_POSTERS'] = 'Videometadata og plakater';
$lang['VIDEOS_THUMB'] = 'videoer med plakat i galleriet ditt';
$lang['VIDEOS_WO_POSTER'] = 'Alle videoer uten plakat';
$lang['VIDEOS_W_POSTER'] = 'Alle videoer med plakat';
$lang['SYNC_DETECTED'] = 'video(er) oppdaget';
$lang['SYNC_DURATION_ERROR'] = 'ukjent varighet, plakaten kan ikke opprettes';
$lang['SYNC_DURATION_SHORT'] = 'for kort varighet, plakaten vil bli produsert ved en annen plass';
$lang['SYNC_ERROR_COUNT'] = 'feil(er) under synkronisering';
$lang['SYNC_INTRO'] = 'Synkronisering av metadata og opprettelse av miniatyrbilder for videoer:';
$lang['SYNC_METADATA'] = 'Metadata';
$lang['SYNC_METADATA_ADDED'] = 'video(er) med metadata lagt til';
$lang['SYNC_POSTERS_NEW'] = 'plakat(er) opprettet';
$lang['SYNC_POSTER_REQUIRE'] = 'Krever <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a>';
$lang['SYNC_POSTER_TITLE'] = 'Plakater for fotogalleri';
$lang['SYNC_REQUIRE'] = 'Krever <a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo </a> eller <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a>';
$lang['SYNC_RESULTS'] = 'Synkroniseringsresultater';
$lang['SYNC_THUMB'] = 'VideoJS-miniatyrbilder';
$lang['SYNC_THUMBSIZE_ERROR'] = 'Ugyldig størrelse på miniatyrbilde, tilbakestilling til standardverdien på 120 piksler';
$lang['SYNC_THUMBS_NEW'] = 'VideoJS-miniatyrbilde(er) opprettet';
$lang['SYNC_THUMB_ERROR'] = 'FFmpeg kunne ikke generere miniatyrbildene, sjekke logger og prøve manuelt';
$lang['SYNC_WARNINGS_COUNT'] = 'advarsel(er) under synkronisering';
$lang['VIDEOS'] = 'videoer i galleriet ditt';
$lang['VIDEOS_ALL'] = 'Alle videoer';
$lang['VIDEOS_GEOTAGGED'] = 'geotaggede videoer i galleriet ditt';
$lang['DIR_NOT_WRITABLE'] = 'katalog uten skrivetilgang';
$lang['FILE_NOT_READABLE'] = 'fil ikke lesbar';
$lang['INTRO_CONFIG'] = 'Dette pogramtillegget:';
$lang['INTRO_METADATA'] = 'trekker ut metadata med <a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank" >MediaInfo</a> eller <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a> (hvis tilgjengelig)
';
$lang['INTRO_SUPPORT'] = 'Se <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki" target="_blank">plugindokumentasjonen</a> for mer informasjon se på <a href="https: //piwigo.org/forum/" target="_blank">fora</a> hvis du støter på problemer.<br/>For å rapportere feil og foreslå nye funksjoner, må du opprette en ny <a href="https://github.com/xbgmsharp/piwigo-videojs/issues" target="_blank">utgave</a>.';
$lang['INTRO_THUMB'] = 'produserer miniatyrbilder med <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a> (hvis tilgjengelig)';
$lang['INTRO_VIDEOJS'] = 'legger til åpen kildekode HTML5-videospilleren <a href="http://www.videojs.com/" target="_blank">VideoJS</a>';
$lang['METADATA'] = 'Metadata';
$lang['METADATA_COUNT'] = 'Antall metadataelementer:';
$lang['METADATA_FILE'] = 'Vis fil:';
$lang['PLAYER'] = 'Spiller';
$lang['PLAYER_TYPE'] = 'Type:';
$lang['POSTER'] = 'Plakat';
$lang['POSTER_ERROR'] = 'FFmpeg kunne ikke generere plakaten, sjekke logger og prøve manuelt';
$lang['STATS'] = 'Statistikk';
$lang['SYNC_DATABASE'] = 'Metadata hentet fra databasen';
$lang['SYNC_DELETE'] = 'Slett VideoJS-miniatyrbilder og ekstra videokilder';
$lang['SYNC_DELETE_ASK'] = 'Er du sikker? Ekstra videokilder og VideoJS-miniatyrbilder vil bli slettet.';
$lang['SYNC_DELETE_DESC'] = 'Nyttig for videoer som ikke inkluderer orienteringsmetadata og som vises med en VideoJS-spiller i forbindelse med videojs-zoomrotate-pluginen. Videoen og plakaten forblir urørt. Bare orienteringsparameteren som er lagret i databasen, oppdateres.';
$lang['SYNC_MEDIAINFO_ERROR'] = 'Metadata kan ikke hentes med MediaInfo fordi XML-biblioteket mangler';
$lang['SYNC_METADATA_ERROR'] = 'Metadata kan ikke hentes fordi ExifTool, FFprobe eller MediaInfo ikke er installert eller banen deres er feil.';
$lang['SYNC_NONE'] = 'Du ba meg ikke gjøre noe!';
$lang['SYNC_POSTEROVERLAY_ERROR'] = 'Filmeffekten er deaktivert fordi GD-biblioteket mangler.';
$lang['SYNC_POSTER_ERROR'] = 'Oppretting av plakater og miniatyrbilder er deaktivert fordi FFmpeg ikke er installert eller banen er feil.';
$lang['SYNC_REPRESENTATIVES'] = 'Godta plakater som lastes opp manuelt';
$lang['SYNC_REPRESENTATIVES_DESC'] = 'For hver video oppdateres informasjonen knyttet til plakaten';
$lang['VIDEO'] = 'Video';
$lang['VIDEOJS_SETTINGS'] = 'VideoJS-innstillinger';
$lang['VIDEO_SRC'] = 'Videokilder';