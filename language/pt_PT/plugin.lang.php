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
$lang['AUTOPLAY'] = 'Auto reproduzir';
$lang['AUTOPLAY_DESC'] = 'Se auto reproduzir Está definido, o vídeo começará a exibição assim que a página é carregada (sem qualquer interação do utilizador). NÃO SUPORTADO POR APARELHOS APPLE iOS';
$lang['CONTROLS'] = 'Controles';
$lang['CONTROLS_DESC'] = 'A opção Controles define se o jogador tem ou não controles que o utilizador pode usar para interagir com';
$lang['CUSTOMCSS'] = 'CSS personalizado';
$lang['CUSTOMCSS_DESC'] = 'Personalizar CSS para copiar e colar a partir do site VideoJS.';
$lang['HTML5'] = 'Definições de etiquetas Video HTML5';
$lang['LOOP'] = 'Repetir';
$lang['LOOP_DESC'] = 'O atributo Repetir faz com que o vídeo recomece de novo assim que  termina.';
$lang['PRELOAD'] = 'Pré-carregar';
$lang['PRELOAD_DESC'] = 'O atributo de pré-carga informa o navegador se os dados de vídeo devem começar ou não a descarregar assim que a etiqueta do vídeo é carregada.';
$lang['SKIN'] = 'Pele';
$lang['SKIN_DESC'] = 'Selecione o modelo que deseja aplicar ao jogador';
$lang['THUMBNAILS'] = 'Miniaturas';
$lang['THUMBNAILS_DESC'] = 'Mostrar as miniaturas sobre a barra de progresso';
$lang['UPSCALE'] = 'Aumentar tamanho';
$lang['UPSCALE_DESC'] = 'Se o tamanho de vídeo é menor que a largura máxima, isto aumentará o tamanho do video para a largura máxima.';
$lang['WATERMARK'] = 'Marca de água';
$lang['WATERMARK_DESC'] = 'Mostrar a marca de água sobre o video';
$lang['ZOOMROTATE'] = 'Rotação com ampliação';
$lang['ZOOMROTATE_DESC'] = 'Girar e ampliar um vídeo se aplicável, utilize os metadados de rotação.';
$lang['SYNC_POSTEROVERLAY_DESC'] = 'Aplicar uma camada na criação de posters.';
$lang['SYNC_OUTPUT_DESC'] = 'Selecionar o formato para o poster e miniatura';
$lang['SYNC_METADATA_DESC'] = 'Irá substituir a informação no banco de dados com os metadados do vídeo.';
$lang['SYNC_POSTEROVERWRITE'] = 'Substiruir posters existentes';
$lang['SYNC_POSTEROVERWRITE_DESC'] = 'Substituir miniaturas existentes com as novas. Se desmarcar só funcionará para vídeo recém-adicionado';
$lang['SYNC_POSTER_DESC'] = 'Criar um poster a partir de determinada posição do video';
$lang['SYNC_THUMBSEC'] = 'Criar uma miniatura cada segundo';
$lang['SYNC_THUMBSIZE_DESC'] = 'Tamanho em pixels, mantê-lo pequeno, o padrão é bom, Youtube usa 190x68 .';
$lang['VOLUME_DESC'] = 'A opção volume ajusta o nível de volume. 0 é desligado (silenciado), 1,0 é para máximo, de 0,5 é metade do máximo.';
$lang['SYNC_ERRORS'] = 'Erros';
$lang['SYNC_INFOS'] = 'Informação detalhada';
$lang['SYNC_OUTPUT'] = 'Formato de saída';
$lang['SYNC_POSTER'] = 'Criar um poster na posição de segundo';
$lang['SYNC_POSTEROVERLAY'] = 'Adicionar efeito filme';
$lang['SYNC_THUMBSEC_DESC'] = 'Criar uma miniatura cada X segundos';
$lang['SYNC_THUMBSIZE'] = 'Tamanho da miniatura';
$lang['SYNC_WARNINGS'] = 'Avisos';
$lang['VOLUME'] = 'Volume';
$lang['LANGUAGE_DESC'] = 'Seleccione a língua do utilizador.';
$lang['LANGUAGE'] = 'Língua';
$lang['HEIGHT_DESC'] = 'O atributo da altura máxima marca a altura máxima do vídeo apresentado. Se a altura do vídeo for superior à altura máxima definida, ela será reduzido para a altura máxima definida.';
$lang['HEIGHT'] = 'Altura Máxima';
$lang['METADATA_DESC'] = 'Desc de metadados';
$lang['PLAYER_DESC'] = 'Selecione a versão do vjs player.';
$lang['RESOLUTION'] = 'Resolução';
$lang['RESOLUTION_DESC'] = 'Comutador de resolução.';
$lang['VIDEOS_WO_POSTER'] = 'Alterar idioma de referência para
Inglês [Reino Unido]';
$lang['VIDEOS_W_POSTER'] = 'Todos os vídeos sem poster';
$lang['VIDEO_SRC'] = 'Fontes de vídeo';
$lang['VIDEOS'] = 'Vídeo(s) na sua galeria';
$lang['VIDEOS_ALL'] = 'Todos os vídeos';
$lang['VIDEOS_GEOTAGGED'] = 'Vídeo(s) com geolocalização na sua galeria';
$lang['VIDEOS_METADATA_POSTERS'] = 'Vídeo Metadados e pósteres';
$lang['VIDEOS_THUMB'] = 'vídeo(s) com poster na sua galeria';
$lang['DIR_NOT_WRITABLE'] = 'Diretório sem permissão de escrita';
$lang['FILE_NOT_READABLE'] = 'Arquivo ilegível';
$lang['INTRO_CONFIG'] = 'Este plugin:';
$lang['INTRO_METADATA'] = 'extrai metadados com <a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo</a> ou <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a> (se disponível)';
$lang['INTRO_SUPPORT'] = 'Consulte a <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki" target="_blank">documentação do plugin</a> para obter mais informações e consulte os <a href="https://piwigo.org/forum/" target="_blank">fóruns</a> se encontrar algum problema. <br/>Para reportar bugs e sugerir novas funcionalidades, crie uma nova <a href="https://github.com/xbgmsharp/piwigo-videojs/issues" target="_blank">problema</a>.';
$lang['INTRO_THUMB'] = 'Gera miniaturas com <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a> (se disponível)';
$lang['INTRO_VIDEOJS'] = 'Adiciona o leitor de vídeo HTML5 de código aberto <a href="http://www.videojs.com/" target="_blank">VideoJS</a>';
$lang['METADATA'] = 'Metadados';
$lang['METADATA_COUNT'] = 'Número de itens de metadados:';
$lang['METADATA_FILE'] = 'Exibir ficheiro:';
$lang['PLAYER'] = 'Reprodutor';
$lang['PLAYER_TYPE'] = 'Tipo:';
$lang['POSTER'] = 'Poster';
$lang['POSTER_ERROR'] = 'O FFmpeg não conseguiu gerar o cartaz. Verifique os registos e tente manualmente.';
$lang['STATS'] = 'Estatísticas';
$lang['SYNC_DATABASE'] = 'Metadados extraídos da base de dados';
$lang['SYNC_DELETE'] = 'Apagar miniaturas do VideoJS e fontes de vídeo extra';
$lang['SYNC_DELETE_ASK'] = 'Tem a certeza? As fontes de vídeo extra e as miniaturas do VideoJS serão eliminadas.';
$lang['SYNC_DELETE_DESC'] = 'Útil para vídeos que não incluem metadados de orientação e que são apresentados com um leitor VideoJS em conjunto com o plugin videojs-zoomrotate. O vídeo e o seu cartaz permanecem inalterados. Apenas o parâmetro de orientação armazenado na base de dados é atualizado.';
$lang['SYNC_DETECTED'] = 'vídeo(s) detectado(s)';
$lang['SYNC_DURATION_ERROR'] = 'duração desconhecida, o cartaz não pode ser criado';
$lang['SYNC_DURATION_SHORT'] = 'duração muito curta, cartaz gerado noutra posição';
$lang['SYNC_ERROR_COUNT'] = 'erro(s) durante a sincronização';
$lang['SYNC_INTRO'] = 'Sincronização de metadados e criação de miniaturas para vídeos:';
$lang['SYNC_MEDIAINFO_ERROR'] = 'Os metadados não podem ser recuperados com o MediaInfo porque a biblioteca XML está em falta';
$lang['SYNC_METADATA'] = 'Metadados';
$lang['SYNC_METADATA_ADDED'] = 'vídeo(s) com metadados adicionados';
$lang['SYNC_METADATA_ERROR'] = 'Os metadados não podem ser recuperados porque o ExifTool, o FFprobe ou o MediaInfo não estão instalados ou os seus caminhos estão incorretos.';
$lang['SYNC_NONE'] = 'Pediu-me para não fazer nada!';
$lang['SYNC_POSTEROVERLAY_ERROR'] = 'Efeito de filme desativado porque a biblioteca GD está em falta.';
$lang['SYNC_POSTERS_NEW'] = 'Poster(es) adotado(s) ou criado(s)';
$lang['SYNC_POSTER_ERROR'] = 'A criação de cartazes e miniaturas está desativada porque o FFmpeg não está instalado ou o caminho está incorreto.';
$lang['SYNC_POSTER_REQUIRE'] = 'Requer <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a>:';
$lang['SYNC_POSTER_TITLE'] = 'Posters para a galeria de fotos';
$lang['SYNC_REPRESENTATIVES'] = 'Adotar pósteres enviados manualmente';
$lang['SYNC_REPRESENTATIVES_DESC'] = 'Para cada vídeo, atualiza as informações relacionadas com o seu cartaz.';
$lang['SYNC_REQUIRE'] = 'Requer <a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo</a> ou <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a>:';
$lang['SYNC_RESULTS'] = 'Resultados da sincronização';
$lang['SYNC_THUMB'] = 'Miniaturas do VideoJS';
$lang['SYNC_THUMBSIZE_ERROR'] = 'Tamanho de miniatura inválido, utilizando o valor padrão de 120 px';
$lang['SYNC_THUMBS_NEW'] = 'Miniatura(s) do VideoJS criada(s)';
$lang['SYNC_THUMB_ERROR'] = 'O FFmpeg não conseguiu gerar as miniaturas. Verifique os registos e tente manualmente.';
$lang['SYNC_WARNINGS_COUNT'] = 'Avisos durante a sincronização';
$lang['VIDEO'] = 'Video';
$lang['VIDEOJS_SETTINGS'] = 'Configurações do VideoJS';