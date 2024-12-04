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
$lang['STATS'] = 'Statistika';
$lang['VIDEOS'] = 'videot teie galeriis';
$lang['VIDEOS_THUMB'] = 'videot koos pisipiltidega teie galeriis';
$lang['VIDEOS_GEOTAGGED'] = 'geotagidega videot teie galeriis';

$lang['HTML5'] = 'HTML5 video siltide seadistused';
$lang['PRELOAD'] = 'Eellaadimine';
$lang['PRELOAD_DESC'] = 'Eellaadimise atribuut ütleb lehitsejale, kas video infot peaks hakkama alla laadima kui video tag on laetud.';
$lang['CONTROLS'] = 'Juhtmikud';
$lang['CONTROLS_DESC'] = 'Juhtmikute valik tekitab video mängimise ajal kontrollnupud';
$lang['AUTOPLAY'] = 'Automaatesitus';
$lang['AUTOPLAY_DESC'] = 'Sisselülitatud automaatesitusega alustab video mängimist lehe laadimisel. Ei ole toetatud Apple\'i iOS seadmetes.';
$lang['LOOP'] = 'Silmusmängimine';
$lang['LOOP_DESC'] = 'Silmusmängimine alustab uuesti video mängimist, kui see on lõpuni käinud';
$lang['VOLUME'] = 'Heli tugevus';
$lang['VOLUME_DESC'] = 'Määrab heli tugevuse taseme. 0 on hääletu, 1.0 on maksimum, 0.5 on pool tugevusest';
$lang['LANGUAGE'] = 'Keel';
$lang['LANGUAGE_DESC'] = 'Valige mängija keel.';

$lang['METADATA_DESC'] = 'Metaandmete kirjeldus';

$lang['PLAYER_DESC'] = 'Valige vjs-mängija versioon.';

$lang['SKIN'] = 'Nahk';
$lang['SKIN_DESC'] = 'Vali stiil, mida mängijal rakendada';
$lang['CUSTOMCSS'] = 'Isikupärastatud CSS';
$lang['CUSTOMCSS_DESC'] = 'Isikupärastatud CSS, et saaks kopeerida ja kleepid VideoJS veebilehelt.';
$lang['HEIGHT'] = 'Maksimaalne kõrgus';
$lang['HEIGHT_DESC'] = 'Maksimaalse kõrguse atribuut määrab video maksimaalse kuvakõrguse. Kui video kõrgus on suurem kui maksimaalne kõrgus, vähendatakse video suurust maksimaalsele kõrgusele.';
$lang['UPSCALE'] = 'Suurenda';
$lang['UPSCALE_DESC'] = 'Kui video suurus on väiksem, kui max laius siis suurenda videot max laiuseni.';
$lang['ZOOMROTATE'] = 'SuurendaKeera';
$lang['ZOOMROTATE_DESC'] = 'Keera ja suurenda videot, kui võimalik, kasuta keeramiseks metainfot.';
$lang['THUMBNAILS'] = 'Pisipildid';
$lang['THUMBNAILS_DESC'] = 'Kuva pisipilte üleval olekuribal.';
$lang['WATERMARK'] = 'Vesimärk';
$lang['WATERMARK_DESC'] = 'Kuva vesimärki videol';
$lang['RESOLUTION'] = 'Eraldusvõime';
$lang['RESOLUTION_DESC'] = 'Eraldusvõime lüliti.';

$lang['SYNC_ERRORS'] = 'Vead';
$lang['SYNC_WARNINGS'] = 'Hoiatused';
$lang['SYNC_INFOS'] = 'Üksikasjalik informatsioon';

$lang['SYNC_METADATA_DESC'] = 'Asendab andmebaasi informatsiooni video metaandmetega';

$lang['SYNC_POSTER'] = 'Looge plakat teises kohas';
$lang['SYNC_POSTER_DESC'] = 'Loo poster videost ja määra asukoht';
$lang['SYNC_POSTEROVERWRITE'] = 'Kirjuta üle olemasolevad postrid';
$lang['SYNC_POSTEROVERWRITE_DESC'] = 'Kirjuta üle olemasolevad pisipildid uutega. Märkimata jätmisel mängib ainult uuesti lisatud videot';
$lang['SYNC_OUTPUT'] = 'Väljundi formaat';
$lang['SYNC_OUTPUT_DESC'] = 'Vali väljundi formaat postri ja pisipildi jaoks';
$lang['SYNC_POSTEROVERLAY'] = 'Lisa filmi efekt';
$lang['SYNC_POSTEROVERLAY_DESC'] = 'Lisa aplikatsioon postrile';

$lang['SYNC_THUMBSEC'] = 'Loo pisipilt igal sekundil';
$lang['SYNC_THUMBSEC_DESC'] = 'Loo pisipilt igal x sekundil';
$lang['SYNC_THUMBSIZE'] = 'Pisipildi suurus';
$lang['SYNC_THUMBSIZE_DESC'] = 'Suurus piksiltes, hoia see väiksena, vaikimisi valik on sobilik, Youtube kasutab 190x68';
$lang['SYNC_METADATA'] = 'Metaandmed';
$lang['POSTER_ERROR'] = 'FFmpeg ei saanud plakatit luua, logisid kontrollida ja käsitsi proovida';
$lang['METADATA_COUNT'] = 'Metaandmeüksuste arv:';
$lang['METADATA'] = 'Metaandmed';
$lang['DIR_NOT_WRITABLE'] = 'kataloog ilma kirjutamisõiguseta';
$lang['FILE_NOT_READABLE'] = 'fail pole loetav';
$lang['INTRO_CONFIG'] = 'See pistikprogramm:';
$lang['POSTER'] = 'Plakat';
$lang['PLAYER_TYPE'] = 'Tüüp:';
$lang['PLAYER'] = 'Mängija';
$lang['METADATA_FILE'] = 'Näita faili:';
$lang['INTRO_METADATA'] = 'ekstraktib metaandmed rakendusega <a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo</a> või <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a> (kui see on saadaval)';