<?php  
$lang['submit'] = 'Validar';
$lang['Title'] = 'VideoJS';
$lang['Howto'] = 'Este plugin agrega reproductor de vídeo HTML5.';
$lang['Howto2'] = 'Paso a paso de demostración:<br/>
* Crear un nuevo álbum (MyVideoClip) a través del panel de administración o directamente en el directorio de sus galerías.
* Descarga y ipload tanto el archivo en el disco nuevo (eg: galleries/MyVideoClip):
* El cartel, http://video-js.zencoder.com/oceans-clip.jpg
* El video, http://video-js.zencoder.com/oceans-clip.mp4
* Cambiar el nombre de la imagen del póster de 'oceans-clip.jpg.poster', de esta manera no se manejan como una imagen.
* Sincronizar
';

$lang['Howto3'] = 'Descripción completa:<br/>
* El video debe ser un formato de apoyo y no debe contener espacios ni caracteres especiales.
* El cartel debe tener el mismo tamaño del video y se debe terminar par \'.poster\'
* El tamaño de vídeo original se mantenga siempre que está por debajo de ancho 720px.
Si el vídeo es HDReady (1280*720) o FullHD (1920*1080), el vídeo será la escala a través de una fórmula matemática impresionante (se divide por 2).
La resolución de pantalla de HDReady será 640*360 y 960*540 par el FullHD.';

$lang['Howto3'] = 'Nota independiente del plugin o Piwigo:

* Asegúrese de que su servidor está utilizando los tipos MIME correctos. Firefox no se reproducirá el vídeo Ogg si el tipo MIME que está mal. Coloque estas líneas en el archivo. Htaccess en el directorio raíz (Piwigo) para enviar los tipos MIME correctos a los navegadores

AddType video/ogg  .ogv
AddType video/mp4  .mp4
AddType video/webm .webm

* Algunos servidores de Internet, para tratar de ahorrar ancho de banda, todo lo que gzip por defecto, incluyendo los archivos de vídeo! En Firefox y Opera, en busca de no ser posible o el vídeo no puede reproducirse en absoluto si es un archivo de vídeo comprimido con gzip. Si esto está ocurriendo a usted por favor compruebe que su servidor / hosts y deshabilitar el gzipping de Ogg y otros archivos multimedia. Puede optar por desactivar gzipping para archivos de vídeo en su htaccess mediante la adición de esta línea.:

SetEnvIfNoCase Request_URI \.(og[gv]|mp4|m4v|webm)$ no-gzip dont-vary';

$lang['vjs_pref'] = 'VideoJS preferencias';
$lang['vjs_pref2'] = 'Plugin preferencias';

$lang['skin'] = 'Skin';
$lang['preload'] = 'Preload';
$lang['controls'] = 'Controls';
$lang['autoplay'] = 'Autoplay';
$lang['loop'] = 'Loop';
$lang['width'] = 'Max Width';

?>
