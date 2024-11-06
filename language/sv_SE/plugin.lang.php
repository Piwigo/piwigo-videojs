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
$lang['CUSTOMCSS_DESC'] = 'Custom CSS att klippa och klistra från <a href="http://www.videojs.com/" target="_blank">VideoJS webbsidan</a>.';
$lang['VIDEOJSPLUGIN'] = 'VideoJS plugins';
$lang['WATERMARK'] = 'Vattenmärkning';
$lang['WATERMARK_DESC'] = 'Vattenmärk videon';
$lang['ZOOMROTATE'] = 'Zoom och rotation';
$lang['ZOOMROTATE_DESC'] = 'Rotera och zoom videon om det står det i metadatan.';
$lang['AUTOPLAY'] = 'Autostart';
$lang['AUTOPLAY_DESC'] = 'Om autostart är aktiverat kommer videon att börja spela så fort sidan laddas (utan att användaren behöver göra något). INTE SUPPORTERAT PÅ APPLE iOS ENHETER.';
$lang['CONTROLS'] = 'Kontroller';
$lang['CONTROLS_DESC'] = 'Kontroller-alternativet bestämmer om spelaren har kontroller som användaren kan interagera med';
$lang['CUSTOMCSS'] = 'Custom CSS';
$lang['HTML5'] = 'HTML5 video-tagg-inställningar';
$lang['LOOP'] = 'Loopa';
$lang['LOOP_DESC'] = 'Gör så att videon börjar om från början när den kommer till slutet.';
$lang['PLUGIN'] = 'Plugin-inställningar';
$lang['PRELOAD'] = 'Förladda';
$lang['PRELOAD_DESC'] = 'Informerar webbläsaren att den ska börja ladda ner videon direkt när sidan laddas.';
$lang['SKIN'] = 'Skal';
$lang['SKIN_DESC'] = 'Välj vilken stil du vill att spelaren ska ha eller <a href="http://designer.videojs.com/" target="_blank">designa ditt eget skal</a>.';
$lang['THUMBNAILS'] = 'Tumnaglar';
$lang['THUMBNAILS_DESC'] = 'Visar tumnaglar över förloppsindikatorn.';
$lang['UPSCALE'] = 'Skala upp';
$lang['UPSCALE_DESC'] = 'Om videon är mindre än max bredd, skala upp videon till max bredd.';
$lang['SYNC_ERRORS'] = 'Fel';
$lang['SYNC_INFOS'] = 'Detaljerad information';
$lang['SYNC_POSTEROVERLAY'] = 'Lägg till film effekt';
$lang['SYNC_THUMBSEC'] = 'Skapa en miniatyrbild varje sekund';
$lang['SYNC_THUMBSEC_DESC'] = 'Skapa en miniatyrbild varje x sekunder';
$lang['SYNC_THUMBSIZE'] = 'Miniatyrbildens storlek';
$lang['SYNC_WARNINGS'] = 'Varningar';
$lang['VOLUME'] = 'Volym';
$lang['SYNC_POSTEROVERLAY_DESC'] = 'Lägg till ett lager över affischen';
$lang['SYNC_POSTER'] = 'Skapar en affisch från filmen vid andra positionen';
$lang['SYNC_POSTEROVERWRITE'] = 'Skriv över befintliga affischer';
$lang['SYNC_POSTEROVERWRITE_DESC'] = 'Skriv över befintliga miniatyrer med nya. Om inte markerad så skapas bara miniatyrer för nyligen tillagda filmer.';
$lang['SYNC_POSTER_DESC'] = 'Skapar en affisch från filmen vid angiven position';
$lang['VOLUME_DESC'] = 'Volymalternativet anger ljudnivån. 0 är avstängd, 1.0 är max.';
$lang['SYNC_METADATA_DESC'] = 'Skriver över informationen i databasen med metadata från filmen';
$lang['SYNC_OUTPUT_DESC'] = 'Välj utdataformat för affischen och miniatyrbilden';
$lang['SYNC_OUTPUT'] = 'Utdataformat';
$lang['SYNC_THUMBSIZE_DESC'] = 'Storlek i bildpunkter. Håll den liten, default är ok. Youtube använder 190x68';
$lang['HEIGHT'] = 'Maxhöjd';
$lang['HEIGHT_DESC'] = 'Maxhöjden sätter filmens maximala höjd. Om filmen är större än maxhöjden kommer den skalas ned till maxhöjden.';
$lang['LANGUAGE'] = 'Språk';
$lang['LANGUAGE_DESC'] = 'Välj spelarens språk.';
$lang['METADATA_DESC'] = 'Metadatabeskrivning';
$lang['PLAYER_DESC'] = 'Välj version av vjsspelaren.';
$lang['RESOLUTION'] = 'Upplösning';
$lang['RESOLUTION_DESC'] = 'Upplösningsväxlare.';
$lang['VIDEOS_METADATA_POSTERS'] = 'Filmermetadata och affischer';
$lang['VIDEOS_THUMB'] = 'filmer med affischer i ditt galleri';
$lang['VIDEOS_WO_POSTER'] = 'Alla filmer utan affischer';
$lang['VIDEOS_W_POSTER'] = 'Alla filmer med affischer';
$lang['SYNC_DETECTED'] = 'film(er) detekterade';
$lang['SYNC_DURATION_ERROR'] = 'okänd varaktighet, affischen kan inte skapas';
$lang['SYNC_DURATION_SHORT'] = 'för kort varaktighet, affischen kommer att produceras på annan plats';
$lang['SYNC_ERROR_COUNT'] = 'fel vid synkronisering';
$lang['SYNC_INTRO'] = 'Synkronisering av metadata och skapande av miniatyrbilder för videor:';
$lang['SYNC_METADATA'] = 'Metadata';
$lang['SYNC_METADATA_ADDED'] = 'film(er) med metadata tillagd';
$lang['SYNC_POSTERS_NEW'] = 'affisch(er) skapad(e)';
$lang['SYNC_POSTER_REQUIRE'] = 'Kräver <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a>';
$lang['SYNC_POSTER_TITLE'] = 'Affischer för fotogalleri';
$lang['SYNC_REQUIRE'] = 'Kräver <a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo </a> eller <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a>';
$lang['SYNC_RESULTS'] = 'Synkroniseringsresultat';
$lang['SYNC_THUMB'] = 'VideoJS miniatyrbilder';
$lang['SYNC_THUMBSIZE_ERROR'] = 'Ogiltig miniatyrstorlek, återgå till standardvärdet på 120 px';
$lang['SYNC_THUMBS_NEW'] = 'VideoJS-miniatyr(er) skapade';
$lang['SYNC_THUMB_ERROR'] = 'FFmpeg kunde inte generera miniatyrerna, kontrollera loggar och försök manuellt';
$lang['SYNC_WARNINGS_COUNT'] = 'fel vid synkronisering';
$lang['VIDEOS'] = 'filmer i ditt galleri';
$lang['VIDEOS_ALL'] = 'Alla filmer';
$lang['VIDEOS_GEOTAGGED'] = 'geotaggade filmer i ditt galleri';
$lang['DIR_NOT_WRITABLE'] = 'katalog utan skrivåtkomst';
$lang['FILE_NOT_READABLE'] = 'filen ej läsbar';
$lang['INTRO_CONFIG'] = 'Detta plugin:';
$lang['INTRO_METADATA'] = 'extraherar metadata med <a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank" >MediaInfo</a> eller <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a> (om tillgängligt)';
$lang['INTRO_SUPPORT'] = 'Se <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki" target="_blank">plugindokumentationen</a> för ytterligare information och titta på <a href="https: //piwigo.org/forum/" target="_blank">forum</a> om du stöter på några problem.<br/>För att rapportera buggar och föreslå nya funktioner, skapa ett nytt <a href="https:/ /github.com/xbgmsharp/piwigo-videojs/issues" target="_blank">problem</a>.';
$lang['INTRO_THUMB'] = 'producerar miniatyrer med <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a> (om tillgängligt)';
$lang['INTRO_VIDEOJS'] = 'lägger till HTML5-videospelaren med öppen källkod <a href="http://www.videojs.com/" target="_blank">VideoJS</a>';
$lang['METADATA'] = 'Metadata';
$lang['METADATA_COUNT'] = 'Antal metadata objekt:';
$lang['METADATA_FILE'] = 'Visa fil:';
$lang['MOVIE'] = 'Film';
$lang['PLAYER'] = 'Spelare';
$lang['PLAYER_TYPE'] = 'Typ:';
$lang['POSTER'] = 'Affisch';
$lang['POSTER_ERROR'] = 'FFmpeg kunde inte generera affischen, kontrollera loggar och försök manuellt';
$lang['STATS'] = 'Statistik';
$lang['SYNC_DATABASE'] = 'Metadata extraherad från databasen';
$lang['SYNC_DELETE'] = 'Ta bort VideoJS-miniatyrer och extra videokällor';
$lang['SYNC_DELETE_ASK'] = 'Är du säker? Extra videokällor och VideoJS-miniatyrer kommer att raderas.';
$lang['SYNC_DELETE_DESC'] = 'Användbar för videor som inte inkluderar orienteringsmetadata och som visas med en VideoJS-spelare i samband med plugin-programmet videojs-zoomrotate. Videon och dess affisch förblir orörda. Endast orienteringsparametern som är lagrad i databasen uppdateras.';