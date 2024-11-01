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

$lang['PLUGIN'] = 'Nastavení pluginu';
$lang['SKIN'] = 'Vzhled';
$lang['SKIN_DESC'] = 'Vyberte si šablonu jakou chcete použít na přehrávač nebo si <a href="http://designer.videojs.com/" target="_blank">vytvořte vzhled vlastní</a>.';
$lang['CUSTOMCSS'] = 'Vlastní nastylování CSS';
$lang['CUSTOMCSS_DESC'] = 'Vlastní styl CSS sem zkopíruj z této stránky <a href="http://www.videojs.com/" target="_blank">web VideoJS</a>.';
$lang['HEIGHT'] = 'Max výška';
$lang['HEIGHT_DESC'] = 'Atribut maximální výška nastavuje maximální výšku videa. Pokud je výška videa větší než hodnota maximální výška, bude video zmenšeno na velikost hodnoty max výška.';
$lang['UPSCALE'] = 'Zvětšení';
$lang['UPSCALE_DESC'] = 'POkud je video měnší než nastavená hodnota pro max. šířku tak bude obsah zvětšen právě na tuto hodnotu.';

$lang['VIDEOJSPLUGIN'] = 'VideoJS moduly';
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
?>
