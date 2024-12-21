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
$lang['STATS'] = 'Statistiky';
$lang['VIDEOS'] = 'videí ve vaší galerii';
$lang['VIDEOS_THUMB'] = 'videí s náhledy ve vaší galerii';
$lang['VIDEOS_GEOTAGGED'] = 'videí s geografickými značkami v galerii';

$lang['HTML5'] = 'Nastavení HTML5 video tag';
$lang['PRELOAD'] = 'Přednačtení obsahu';
$lang['PRELOAD_DESC'] = 'Tento parametr informuje prohlížeč zda má nebo nemá ukládat data o videu ihned jakmile je přehrávač načten.';
$lang['CONTROLS'] = 'Ovládání';
$lang['CONTROLS_DESC'] = 'Nastavuje jestli má mít přehrávač ovladací prvky a uživatel tak může ovládat zobrazovaný obsah';
$lang['AUTOPLAY'] = 'Autoplay';
$lang['AUTOPLAY_DESC'] = 'Pokud je autoplay povolen video bude načteno a spuštěno ihned jakmile se načte zobrazí stránka v prohlížeči (uživatel toto neovlivní). Toto nepodporují zařízení od APPLE s operačním systémem iOS.';
$lang['LOOP'] = 'Smyčka';
$lang['LOOP_DESC'] = 'Zajišťuje opakování video obsahu ve smyčce stále dokola automaticky.';
$lang['VOLUME'] = 'Hlasitost';
$lang['VOLUME_DESC'] = 'Ovladač hlasitosti nastavuje hlasitost, 0 je vypnuto, 1 plně zapnuto, 0,5 je poloviční hlasitost.';
$lang['LANGUAGE'] = 'Jazyk';
$lang['LANGUAGE_DESC'] = 'Vyberte jazyk přehrávače.';

$lang['METADATA_DESC'] = 'Metadata';

$lang['PLAYER_DESC'] = 'Zvolte verzi přehrávače';

$lang['SKIN'] = 'Vzhled';
$lang['SKIN_DESC'] = 'Vyberte si šablonu jakou chcete použít na přehrávač nebo si <a href="http://designer.videojs.com/" target="_blank">vytvořte vzhled vlastní</a>.';
$lang['CUSTOMCSS'] = 'Vlastní nastylování CSS';
$lang['CUSTOMCSS_DESC'] = 'Vlastní styl CSS sem zkopíruj z této stránky <a href="http://www.videojs.com/" target="_blank">web VideoJS</a>.';
$lang['HEIGHT'] = 'Max výška';
$lang['HEIGHT_DESC'] = 'Atribut maximální výška nastavuje maximální výšku videa. Pokud je výška videa větší než hodnota maximální výška, bude video zmenšeno na velikost hodnoty max výška.';
$lang['UPSCALE'] = 'Zvětšení';
$lang['UPSCALE_DESC'] = 'POkud je video měnší než nastavená hodnota pro max. šířku tak bude obsah zvětšen právě na tuto hodnotu.';
$lang['ZOOMROTATE'] = 'ZoomRotate';
$lang['ZOOMROTATE_DESC'] = 'Rotace a zvětšování videa pokud jej takto ovládat lze, používá metadata o možnosti rotace.';
$lang['THUMBNAILS'] = 'Náhledy';
$lang['THUMBNAILS_DESC'] = 'Zobrazí obrázky náhledu na ovládací liště.';
$lang['WATERMARK'] = 'Vodoznak';
$lang['WATERMARK_DESC'] = 'Zobrazuje vodoznak přes obsah videa.';
$lang['RESOLUTION'] = 'Rozlišení';
$lang['RESOLUTION_DESC'] = 'Změna rozlišení.';

$lang['SYNC_ERRORS'] = 'Chyby';
$lang['SYNC_WARNINGS'] = 'Varování';
$lang['SYNC_INFOS'] = 'Detailní informace';

$lang['SYNC_METADATA_DESC'] = 'Přepíše informace v databázi metadaty z videa.';

$lang['SYNC_POSTER'] = 'Vytvořit náhled v určeném čase (sekundy)';
$lang['SYNC_POSTER_DESC'] = 'Vytvořit náhled videa v určeném čase.';
$lang['SYNC_POSTEROVERWRITE'] = 'Přepsat existující náhledy';
$lang['SYNC_POSTEROVERWRITE_DESC'] = 'Přepsat existující náhledy novými. Pokud je nezatrženo, náhledy by měly být vytvořeny pouze pro nově přidaná videa.';
$lang['SYNC_OUTPUT'] = 'Výstupní formát';
$lang['SYNC_OUTPUT_DESC'] = 'Vyberte výstupní formát pro náhledy ';
$lang['SYNC_POSTEROVERLAY'] = 'Přidat filmový efekt';
$lang['SYNC_POSTEROVERLAY_DESC'] = 'Přidá filmový efekt do vytvářených náhledů';

$lang['SYNC_THUMBSEC'] = 'Vytrvořit náhled každou sekundu';
$lang['SYNC_THUMBSEC_DESC'] = 'Vytvořit náhled každých x sekund.';
$lang['SYNC_THUMBSIZE'] = 'velikost náhledu';
$lang['SYNC_THUMBSIZE_DESC'] = 'Velikost v pixelech, doporučuje se vybrat malé rozměry, výchozí nastavení by mělo vyhovovat, Youtube používá 190x68';
$lang['METADATA_COUNT'] = 'Počet položek metadat:';
$lang['METADATA_FILE'] = 'Zobrazit soubor:';
$lang['PLAYER_TYPE'] = 'Typ:';
$lang['POSTER'] = 'Náhled';
$lang['POSTER_ERROR'] = 'FFmpeg nemohl generovat náhled, zkontrolujte logy a zkuste to ručně';
$lang['SYNC_DATABASE'] = 'Metadata načteny z databáze';
$lang['SYNC_DELETE'] = 'Smazat náhledy VideoJS a dodatečné zdroje videa';
$lang['SYNC_DELETE_ASK'] = 'Jste si jisti? Extra video zdroje a náhledy VideoJS budou smazány.';
$lang['SYNC_DELETE_DESC'] = 'Užitečné pro videa, která neobsahují orientační metadata a která jsou zobrazena s přehrávačem VideoJS ve spojení s pluginem videojs-zoomrotate. Video a jeho náhled zůstávají nedotčeny. Aktualizuje se pouze orientační parametr uložený v databázi.';
$lang['SYNC_DURATION_ERROR'] = 'neznámá doba trvání, náhled nebyl vytvořen';
$lang['SYNC_DURATION_SHORT'] = 'příliš krátká doba trvání, náhled vyroben na jiné pozici';
$lang['SYNC_ERROR_COUNT'] = 'chyba(y) v průběhu synchronizace';
$lang['SYNC_INTRO'] = 'Synchronizace metadat a tvorba náhledů pro videa:';
$lang['SYNC_MEDIAINFO_ERROR'] = 'Metadata nelze načíst pomocí MediaInfo, protože chybí knihovna XML';
$lang['SYNC_METADATA_ADDED'] = 'videa s metadaty přidána';
$lang['SYNC_METADATA_ERROR'] = 'Metadata nelze načíst, protože nejsou nainstalovány ExifTool, FFprobe nebo MediaInfo nebo jsou cesty k nim nesprávné.';
$lang['SYNC_NONE'] = 'Žádal jste mě, abych nic nedělal!';
$lang['SYNC_POSTEROVERLAY_ERROR'] = 'Filmový efekt vypnut, protože chybí knihovna GD.';
$lang['SYNC_POSTERS_NEW'] = 'náhledy přiřazeny nebo vytvořeny';
$lang['SYNC_POSTER_ERROR'] = 'Vytváření náhledů je zakázáno, protože FFmpeg není nainstalován nebo je cesta k němu nesprávná.';
$lang['SYNC_POSTER_REQUIRE'] = 'Vyžaduje <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a>:';
$lang['SYNC_POSTER_TITLE'] = 'Náhledy pro fotogalerii';
$lang['SYNC_REPRESENTATIVES'] = 'Přiřaďte náhledy uploadované ručně';
$lang['SYNC_REPRESENTATIVES_DESC'] = 'Pro každé video aktualizuje informace vztažené k těmto náhledům.';
$lang['SYNC_REQUIRE'] = 'Vyžaduje <a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo</a> nebo <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a>:';
$lang['SYNC_RESULTS'] = 'Výsledek synchronizace';
$lang['SYNC_THUMB'] = 'VideoJS náhledy';
$lang['SYNC_THUMBSIZE_ERROR'] = 'Nesprávná velikost náhledu, zpět nastaveno na výchozích 120 px';
$lang['SYNC_THUMBS_NEW'] = 'VideoJS náhledy vytvořeny';
$lang['SYNC_THUMB_ERROR'] = 'FFmpeg nemohl vygenerovat náhledy, zkontrlujte logy a zkuste to ručně';
$lang['SYNC_WARNINGS_COUNT'] = 'varování v průběhu synchronizace';
$lang['VIDEO'] = 'Video';
$lang['VIDEOJS_SETTINGS'] = 'VideoJS nastavení';
$lang['VIDEOS_ALL'] = 'Všechna videa';
$lang['VIDEOS_METADATA_POSTERS'] = 'Video metadata a náhledy';
$lang['VIDEOS_WO_POSTER'] = 'Všechna videa bez náhledů';
$lang['VIDEOS_W_POSTER'] = 'Všechna videa s náhledy';
$lang['VIDEO_SRC'] = 'Video zdroje';
$lang['SYNC_METADATA'] = 'Metadata';
$lang['DIR_NOT_WRITABLE'] = 'adresář nemá možnost zapisování dat';
$lang['FILE_NOT_READABLE'] = 'soubor nelze přečíst';
$lang['INTRO_CONFIG'] = 'Tento plugin:';
$lang['INTRO_METADATA'] = 'vytvoření metadat s <a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo</a> nebo <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a> (pokud existují)';
$lang['INTRO_SUPPORT'] = 'Více v <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki" target="_blank">dokumentaci pluginu</a> pro další informace a na <a href="https://piwigo.org/forum/" target="_blank">diskusním fórum</a> pokud budete mít nějaké potíže.<br/> Pro zasílání chyb a poptávce po nových funkcích, vytvořte nový chybový <a href="https://github.com/xbgmsharp/piwigo-videojs/issues" target="_blank">report</a>.';
$lang['INTRO_THUMB'] = 'vytvořte náhledy s <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a> (pokud existuje)';
$lang['INTRO_VIDEOJS'] = 'přidá open source HTML5 video přehrávač <a href="http://www.videojs.com/" target="_blank">VideoJS</a>';
$lang['METADATA'] = 'Metadata';
$lang['PLAYER'] = 'Přehrávač';
$lang['SYNC_DETECTED'] = 'nalezená videa';