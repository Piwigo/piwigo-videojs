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
$lang['STATS'] = 'Estadísticas';
$lang['VIDEOS'] = 'vídeos en tu galería';
$lang['VIDEOS_THUMB'] = 'vídeos con miniaturas en tu galería';
$lang['VIDEOS_GEOTAGGED'] = 'vídeos geoetiquetados en tu galería';

$lang['HTML5'] = 'Ajustes de etiquetas del vídeo HTML5';
$lang['PRELOAD'] = 'Precargar';
$lang['PRELOAD_DESC'] = 'El atributo de precarga informa al navegador si la información del vídeo ha de empezar a cargar tan pronto como se cargue la etiqueta del vídeo.';
$lang['CONTROLS'] = 'Controles';
$lang['CONTROLS_DESC'] = 'La opción de control establece si el reproductor tiene controles con los que el usuario puede interactuar';
$lang['AUTOPLAY'] = 'Reproducción automática';
$lang['AUTOPLAY_DESC'] = 'Si la reproducción automática está activada, el vídeo empezará a reproducirse tan pronto como la página cargue (sin ninguna interacción por parte del usuario). NO SOPORTADO POR DISPOSITIVOS IOS DE APPLE';
$lang['LOOP'] = 'Bucle';
$lang['LOOP_DESC'] = 'El atributo bucle hace que el vídeo empiece a reproducirse de nuevo tan pronto como acaba.';
$lang['VOLUME'] = 'Volumen';
$lang['VOLUME_DESC'] = 'La opción de volumen ajusta el nivel de volumen. 0 es silenciado, 1,0 es el máximo, 0,5 es la mitad.';
$lang['LANGUAGE'] = 'Idioma';
$lang['LANGUAGE_DESC'] = 'Seleccione el idioma del reproductor.';

$lang['METADATA_DESC'] = 'Descripción metadata';

$lang['PLAYER_DESC'] = 'Selecciona la versión del reproductor vjs';

$lang['SKIN'] = 'Tema';
$lang['SKIN_DESC'] = 'Selecciona el tema que quieras aplicar al reproductor';
$lang['CUSTOMCSS'] = 'CSS personalizado';
$lang['CUSTOMCSS_DESC'] = 'CSS personalizado para copiar desde la web de VideoJS';
$lang['HEIGHT'] = 'Altura máxima ';
$lang['HEIGHT_DESC'] = 'El atributo de altura máxima define la altura máxima de la pantalla de vídeo. Si la altura de vídeo es más grande que la altura máxima, será reducir tamaño del vídeo al atributo de altura máxima.';
$lang['UPSCALE'] = 'Mejora la resolución';
$lang['UPSCALE_DESC'] = 'Si el tamaño del vídeo es más pequeño que el ancho máximo, se aumentara el tamaño del vídeo al ancho máximo.';
$lang['ZOOMROTATE'] = ' Rotación zoom';
$lang['ZOOMROTATE_DESC'] = 'Rotar y hacer zoom un video si es aplicable, utilizar los metadatos de rotación.';
$lang['THUMBNAILS'] = 'Miniaturas';
$lang['THUMBNAILS_DESC'] = 'Muestra imágenes en miniatura sobre la barra de progreso.';
$lang['WATERMARK'] = 'Marca de agua';
$lang['WATERMARK_DESC'] = 'Muestra la marca de agua sobre el video.';
$lang['RESOLUTION'] = 'Resolución';
$lang['RESOLUTION_DESC'] = 'Selector de resolución';

$lang['SYNC_ERRORS'] = 'Errores';
$lang['SYNC_WARNINGS'] = 'Advertencia';
$lang['SYNC_INFOS'] = 'Información detallada';

$lang['SYNC_METADATA_DESC'] = 'Se sobrescribirá los datos en la base de datos con los metadatos del vídeo.';

$lang['SYNC_POSTER'] = 'Crear un póster en  su posición en segundos.';
$lang['SYNC_POSTER_DESC'] = 'Crear un póster a partir de una posición del vídeo';
$lang['SYNC_POSTEROVERWRITE'] = 'Sobrescribir pósteres existentes';
$lang['SYNC_POSTEROVERWRITE_DESC'] = 'Sobrescribir miniaturas existentes por otras nuevas. Si se desmarca se ejecutara sólo para vídeo nuevo.';
$lang['SYNC_OUTPUT'] = 'Formato de salida';
$lang['SYNC_OUTPUT_DESC'] = 'Seleccione el formato de salida para el póster y la miniatura.';
$lang['SYNC_POSTEROVERLAY'] = 'Añadir un efecto de película';
$lang['SYNC_POSTEROVERLAY_DESC'] = 'Aplicar una capa de superposición en la creación de carteles.';

$lang['SYNC_THUMBSEC'] = 'Crear una miniatura por cada segundos.';
$lang['SYNC_THUMBSEC_DESC'] = 'Crear una miniatura cada x segundo.';
$lang['SYNC_THUMBSIZE'] = 'Dimensión de la miniatura';
$lang['SYNC_THUMBSIZE_DESC'] = 'Tamaño en píxeles, que sea pequeña, por defecto está muy bien, el uso en Youtube 190x68 .';
$lang['SYNC_POSTER_ERROR'] = 'Creación de póster y miniatura desactivados porque FFmpeg no está instalado o su ruta de acceso es incorrecta.';
$lang['SYNC_POSTER_REQUIRE'] = 'Requiere <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a>:';
$lang['SYNC_POSTER_TITLE'] = 'Pósters para la galería de fotos';
$lang['SYNC_REPRESENTATIVES'] = 'Adoptar pósters cargados manualmente';
$lang['SYNC_REPRESENTATIVES_DESC'] = 'Para cada video, actualiza la información relacionada con su póster.';
$lang['SYNC_REQUIRE'] = 'Requiere <a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo</a> o <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a>:';
$lang['SYNC_RESULTS'] = 'Resultados de sincronización';
$lang['SYNC_THUMB'] = 'Miniaturas de VideoJS';
$lang['SYNC_THUMBSIZE_ERROR'] = 'Tamaño de miniatura no válido; se vuelve al valor predeterminado de 120 px';
$lang['SYNC_THUMBS_NEW'] = 'miniatura(s) de VideoJS creada(s)';
$lang['SYNC_THUMB_ERROR'] = 'FFmpeg no ha podido generar las miniaturas; verifique los registros e inténtelo manualmente';
$lang['SYNC_WARNINGS_COUNT'] = 'aviso(s) durante la sincronización';
$lang['VIDEO'] = 'Vídeo';
$lang['VIDEOJS_SETTINGS'] = 'parámetros de VideoJS';
$lang['VIDEOS_ALL'] = 'Todos los vídeos';
$lang['VIDEOS_METADATA_POSTERS'] = 'Metadatos y pósters de vídeo';
$lang['VIDEOS_WO_POSTER'] = 'Todos los vídeos sin póster';
$lang['VIDEOS_W_POSTER'] = 'Todos los vídeos con póster';
$lang['VIDEO_SRC'] = 'Fuentes de vídeo';
$lang['DIR_NOT_WRITABLE'] = 'directorio sin acceso de escritura';
$lang['FILE_NOT_READABLE'] = 'Archivo no legible';
$lang['INTRO_CONFIG'] = 'Este plugin:';
$lang['INTRO_METADATA'] = 'extrae metadatos con <a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo</a> o <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a> (si está disponible)';
$lang['INTRO_SUPPORT'] = 'Consulte la <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki" target="_blank">documentación del plugin</a> para obtener información adicional y consulte los <a href="https://piwigo.org/forum/" target="_blank">foros</a> si encuentra algún problema.<br/>Para informar sobre errores y sugerir nuevas funciones, cree un nuevo <a href="https://github.com/xbgmsharp/piwigo-videojs/issues" target="_blank">problema</a>.';
$lang['INTRO_THUMB'] = 'produce miniaturas con <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a> (si está disponible)';
$lang['INTRO_VIDEOJS'] = 'agrega el reproductor de video HTML5 de código abierto <a href="http://www.videojs.com/" target="_blank">VideoJS</a>';
$lang['METADATA'] = 'Metadatos';
$lang['METADATA_COUNT'] = 'Número de elementos de metadatos:';
$lang['METADATA_FILE'] = 'Mostrar archivo:';
$lang['PLAYER'] = 'Reproductor';
$lang['PLAYER_TYPE'] = 'Tipo:';
$lang['POSTER'] = 'Póster';
$lang['POSTER_ERROR'] = 'FFmpeg no ha podido generar el póster; verifique los registros e inténtelo manualmente';
$lang['SYNC_DATABASE'] = 'Metadatos extraídos de la base de datos';
$lang['SYNC_DELETE'] = 'Eliminar miniaturas de VideoJS y fuentes de video adicionales';
$lang['SYNC_DELETE_ASK'] = '¿Está seguro? Se eliminarán las fuentes de video adicionales y las miniaturas de VideoJS.';
$lang['SYNC_DELETE_DESC'] = 'Útil para videos que no incluyen metadatos de orientación y que se muestran con un reproductor VideoJS junto con el complemento videojs-zoomrotate. El vídeo y su póster permanecen intactos. Solo se actualiza el parámetro de orientación almacenado en la base de datos.';
$lang['SYNC_DETECTED'] = 'Se han detectado vídeos';
$lang['SYNC_DURATION_ERROR'] = 'Duración desconocida; no se puede crear el póster';
$lang['SYNC_DURATION_SHORT'] = 'Duración demasiado corta; el póster se ha creado en otra posición';
$lang['SYNC_ERROR_COUNT'] = 'Errores durante la sincronización';
$lang['SYNC_INTRO'] = 'Sincronización de metadatos y creación de miniaturas para vídeos:';
$lang['SYNC_MEDIAINFO_ERROR'] = 'No se pueden recuperar los metadatos con MediaInfo porque falta la biblioteca XML';
$lang['SYNC_METADATA'] = 'Metadatos';
$lang['SYNC_METADATA_ADDED'] = 'vídeo(s) con metadatos añadido(s)';
$lang['SYNC_METADATA_ERROR'] = 'No se pueden recuperar los metadatos porque ExifTool, FFprobe o MediaInfo no están instalados o sus rutas de acceso son incorrectas.';
$lang['SYNC_NONE'] = '¡Me ha pedido que no haga nada!';
$lang['SYNC_POSTEROVERLAY_ERROR'] = 'Efecto de película desactivado porque falta la biblioteca GD.';
$lang['SYNC_POSTERS_NEW'] = 'póster(s) adoptado(s) o creado(s)';
