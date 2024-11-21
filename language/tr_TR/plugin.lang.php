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
$lang['AUTOPLAY_DESC'] = 'Eğer otomatik çalma doğru ise, sayfa yüklenir yüklenmez video yürütülmeye başlanır (kullanıcı etkileşimi olmadan). APPLE iOS CİHAZLARI DESTEKLENMEMEKTEDİR.';
$lang['CONTROLS_DESC'] = 'Kontroller parametresi, yürütücünün oynatma sırasında kullanıcının etkileşime geçeceği kontrollere sahip olup olmayacağını belirler';
$lang['LOOP_DESC'] = 'Döngü parametresi, videonun biter bitmez başa sarmasını sağlar';
$lang['CUSTOMCSS_DESC'] = 'VideoJS web sitesinden kopyalaıp yapıştırılacak özelleştirilmiş CSS';
$lang['PRELOAD_DESC'] = 'Önyükleme parametresi, video etiketi yüklendikten hemen sonra video verisinin yüklenmeye başlanıp başlanmayacağını tarayıcıya bildirir';
$lang['AUTOPLAY'] = 'Otomatik yürütme';
$lang['SKIN_DESC'] = 'Yürütücüye uygulamak istediğiniz stili seçin';
$lang['CONTROLS'] = 'Kontroller';
$lang['CUSTOMCSS'] = 'Özelleştirilmiş CSS';
$lang['HTML5'] = 'HTML5 etiket ayarları';
$lang['LOOP'] = 'Döngü';
$lang['PRELOAD'] = 'Önyükleme';
$lang['SKIN'] = 'Kaplama';
$lang['UPSCALE_DESC'] = 'Eğer video boyutu azami genişlikten küçükse azami genişliğe ölçekleyerek büyüt.';
$lang['UPSCALE'] = 'Ölçekleyerek büyütme';
$lang['ZOOMROTATE_DESC'] = 'Eğer döndürme metadatası varsa, videoyu döndür ve çevir.';
$lang['ZOOMROTATE'] = 'BüyütDöndür';
$lang['WATERMARK'] = 'Filigran';
$lang['THUMBNAILS'] = 'Pul resimleri';
$lang['THUMBNAILS_DESC'] = 'İlerletme çubuğunda pul resmi görüntüler.';
$lang['WATERMARK_DESC'] = 'Video üzerinde filigran görüntüler.';
$lang['VOLUME_DESC'] = 'Ses seçeneği ses seviyesini ayarlar. 0: Kapalı (Sessiz) 1:tamamen açık 0.5:yarım açık.';
$lang['SYNC_POSTEROVERWRITE_DESC'] = 'Varolan küçükresimlerin üzerine yenilerini yaz. Bu seçenek seçilmemişse sadece yeni eklenen video için çalıştırılmalıdır.';
$lang['SYNC_THUMBSIZE_DESC'] = 'Piksel büyüklüğü, küçük tutun, varsayılan gayet iyi, Youtube 190x68 kullanmakta.';
$lang['SYNC_THUMBSEC'] = 'Her saniye için küçükresim oluştur.';
$lang['SYNC_THUMBSEC_DESC'] = 'Her x saniye için küçükresim oluştur.';
$lang['SYNC_POSTER_DESC'] = 'Belirli bir konumdaki video için bir poster oluştur.';
$lang['SYNC_POSTEROVERWRITE'] = 'Varolan posterlerin üzerine yaz';
$lang['SYNC_POSTEROVERLAY_DESC'] = 'Poster yaratmaya bir kaplama uygula.';
$lang['SYNC_POSTEROVERLAY'] = 'Film efekti ekle';
$lang['SYNC_METADATA_DESC'] = 'Videodan metadata ile veri tabanındaki bilgiler üzerine yazılır.';
$lang['SYNC_POSTER'] = 'Belirtilen saniyedeki konumdan bir poster yarat';
$lang['SYNC_OUTPUT_DESC'] = 'Poster ve küçükresim için çıktı formatını seçin.';
$lang['SYNC_THUMBSIZE'] = 'Küçükresim boyutu';
$lang['SYNC_WARNINGS'] = 'Uyarılar';
$lang['VOLUME'] = 'Ses';
$lang['SYNC_ERRORS'] = 'Hatalar';
$lang['SYNC_INFOS'] = 'Detaylı bilgi';
$lang['SYNC_OUTPUT'] = 'Çıktı formatı';
$lang['HEIGHT_DESC'] = 'Azami yükseklik seçeneği görüntülenecek videonun maksimum yüksekliğini belirler. Eğer video yüksekliği azami yükseklikten büyükse küçültülecektir.';
$lang['HEIGHT'] = 'Azami yükseklik';
$lang['LANGUAGE'] = 'Dil';
$lang['LANGUAGE_DESC'] = 'Oynatıcı dilini seç';
$lang['RESOLUTION_DESC'] = 'Çözünürlük değiştirici.';
$lang['RESOLUTION'] = 'Çözünürlük';
$lang['PLAYER_DESC'] = 'vjs oynatıcı sürümünü seçin.';
$lang['METADATA_DESC'] = 'Meta veri açıklaması';
$lang['INTRO_SUPPORT'] = 'Ek bilgi için <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki" target="_blank">eklenti belgelerine</a> bakın ve herhangi bir sorunla karşılaşırsanız <a href="https://piwigo.org/forum/" target="_blank">forumlara</a> bakın.<br/>Hataları bildirmek ve yeni özellikler önermek için lütfen yeni bir <a href="https://github.com/xbgmsharp/piwigo-videojs/issues" target="_blank">sorun</a> oluşturun.';
$lang['SYNC_METADATA_ERROR'] = 'ExifTool, FFprobe veya MediaInfo yüklü olmadığından veya yolları yanlış olduğundan meta veriler alınamıyor.';
$lang['SYNC_REQUIRE'] = '<a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo</a> veya <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a> gerektirir:';
$lang['SYNC_POSTER_REQUIRE'] = '<a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a> gerektirir:';
$lang['SYNC_POSTER_ERROR'] = 'FFmpeg kurulu olmadığı veya yolu yanlış olduğu için poster ve küçük resim oluşturma devre dışı bırakıldı.';
$lang['SYNC_POSTEROVERLAY_ERROR'] = 'GD kütüphanesi eksik olduğundan film efekti devre dışı bırakıldı.';
$lang['INTRO_VIDEOJS'] = 'açık kaynaklı HTML5 video oynatıcısını ekler <a href="http://www.videojs.com/" target="_blank">VideoJS</a>';
$lang['INTRO_THUMB'] = '<a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a> ile küçük resimler üretir (mümkünse)';
$lang['INTRO_METADATA'] = '<a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo</a> veya <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a> (mevcutsa) ile meta verileri ayıklar';
$lang['SYNC_RESULTS'] = 'Senkronizasyon sonuçları';
$lang['SYNC_THUMB'] = 'VideoJS küçük resimleri';
$lang['SYNC_THUMBSIZE_ERROR'] = 'Geçersiz küçük resim boyutu, varsayılan 120 piksel değerine geri dönün';
$lang['SYNC_THUMB_ERROR'] = 'FFmpeg küçük resimleri oluşturamadı, günlükleri kontrol edin ve manuel olarak deneyin';
$lang['SYNC_THUMBS_NEW'] = 'VideoJS küçük resim(ler)i oluşturuldu';
$lang['SYNC_WARNINGS_COUNT'] = 'senkronizasyon sırasında uyarı(lar)';
$lang['VIDEOJS_SETTINGS'] = 'VideoJS ayarları';
$lang['VIDEO'] = 'Video';
$lang['VIDEOS'] = 'Galerinizdeki video(lar)';
$lang['VIDEOS_ALL'] = 'Tüm videolar';
$lang['VIDEOS_GEOTAGGED'] = 'galerinizdeki coğrafi etiketli video(lar)';
$lang['VIDEOS_W_POSTER'] = 'Posterli tüm videolar';
$lang['VIDEO_SRC'] = 'Video kaynakları';
$lang['VIDEOS_WO_POSTER'] = 'Tüm videolar postersiz';
$lang['VIDEOS_THUMB'] = 'Galerinizdeki posterli video(lar)';
$lang['VIDEOS_METADATA_POSTERS'] = 'Video meta verileri ve posterler';
$lang['SYNC_REPRESENTATIVES_DESC'] = 'Her video için, o videonun posterine ait bilgiler güncellenmektedir.';
$lang['SYNC_REPRESENTATIVES'] = 'Manuel olarak yüklenen posterleri benimseyin';
$lang['SYNC_POSTER_TITLE'] = 'Fotoğraf galerisi için posterler';
$lang['SYNC_POSTERS_NEW'] = 'benimsenen veya oluşturulan poster(ler)';
$lang['SYNC_NONE'] = 'Benden hiçbir şey yapmamı istemedin!';
$lang['SYNC_METADATA_ADDED'] = 'metadata eklenmiş video(lar)';
$lang['SYNC_MEDIAINFO_ERROR'] = 'XML kitaplığı eksik olduğundan meta veriler MediaInfo ile alınamıyor';
$lang['SYNC_METADATA'] = 'Metadata';
$lang['SYNC_DURATION_ERROR'] = 'süresi bilinmiyor, poster oluşturulamıyor';
$lang['SYNC_DURATION_SHORT'] = 'çok kısa süre, poster başka bir konumda üretildi';
$lang['SYNC_ERROR_COUNT'] = 'senkronizasyon sırasında hata(lar)';
$lang['SYNC_INTRO'] = 'Videolar için meta verilerin senkronizasyonu ve küçük resim oluşturma:';
$lang['PLAYER'] = 'Oynatıcı';
$lang['METADATA_COUNT'] = 'Metadata öğelerinin sayısı:';
$lang['POSTER_ERROR'] = 'FFmpeg posteri oluşturamadı, günlükleri kontrol edin ve manuel olarak deneyin';
$lang['SYNC_DELETE_DESC'] = 'Yönlendirme meta verisi içermeyen ve videojs-zoomrotate eklentisiyle birlikte bir VideoJS oynatıcısıyla görüntülenen videolar için kullanışlıdır. Video ve posteri dokunulmadan kalır. Yalnızca veritabanında saklanan yönlendirme parametresi güncellenir.';
$lang['SYNC_DETECTED'] = 'video(lar) algılandı';
$lang['SYNC_DELETE_ASK'] = 'Emin misiniz? Ekstra video kaynakları ve VideoJS küçük resimleri silinecek.';
$lang['SYNC_DELETE'] = 'VideoJS küçük resimlerini ve ekstra video kaynaklarını silin';
$lang['PLAYER_TYPE'] = 'Tip:';
$lang['POSTER'] = 'Poster';
$lang['STATS'] = 'İstatistikler';
$lang['SYNC_DATABASE'] = 'Veritabanından çıkarılan meta veriler';
$lang['METADATA_FILE'] = 'Dosyayı göster:';
$lang['METADATA'] = 'Metadata';
$lang['INTRO_CONFIG'] = 'Bu eklenti:';
$lang['DIR_NOT_WRITABLE'] = 'yazma erişimi olmayan dizin';
$lang['FILE_NOT_READABLE'] = 'dosya okunabilir değil';