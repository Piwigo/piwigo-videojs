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
$lang['LOOP_DESC'] = '视频结束后立即再次从头播放';
$lang['PRELOAD_DESC'] = '预加载选项将告诉浏览器视频数据是否在视频标签加载后立即开始下载。';
$lang['WATERMARK_DESC'] = '在视频上显示水印。';
$lang['ZOOMROTATE'] = '缩放-旋转';
$lang['ZOOMROTATE_DESC'] = '如可能，使用旋转元数据对视频进行旋转和缩放。';
$lang['AUTOPLAY'] = '自动播放';
$lang['AUTOPLAY_DESC'] = '如启用自动播放，视频将在页面加载完成后立即开始播放，而无需用户点击。不支持苹果 iOS 设备。';
$lang['CONTROLS'] = '控件';
$lang['CONTROLS_DESC'] = '播放器上是否显示可供用户操作的控件';
$lang['CUSTOMCSS'] = '自定义设定';
$lang['CUSTOMCSS_DESC'] = '从 <a href="http://www.videojs.com/" target="_blank">VideoJS 网站</a>拷贝粘贴代码，以设定 CSS。';
$lang['HTML5'] = 'HTML5 视频标签设定';
$lang['LOOP'] = '循环';
$lang['PRELOAD'] = '预加载';
$lang['SKIN'] = '皮肤';
$lang['SKIN_DESC'] = '选择你想应用的播放器风格，或<a href="http://designer.videojs.com/" target="_blank">创建个性化的皮肤</a>。';
$lang['THUMBNAILS'] = '缩略图';
$lang['THUMBNAILS_DESC'] = '在进度条上显示缩略图。';
$lang['UPSCALE'] = '放大';
$lang['UPSCALE_DESC'] = '如果视频尺寸小于播放器高度，则将视频尺寸放大至此高度。';
$lang['WATERMARK'] = '水印';
$lang['SYNC_POSTEROVERLAY_DESC'] = '创建缩略图时应用覆盖层';
$lang['SYNC_POSTEROVERWRITE'] = '覆盖原有海报';
$lang['SYNC_POSTEROVERWRITE_DESC'] = '用新缩略图覆盖原缩略图。如不勾选，则只为新增视频文件生成缩略图。';
$lang['SYNC_POSTER_DESC'] = '以视频特定位置创建海报。';
$lang['SYNC_THUMBSEC'] = '每 x 秒创建一个缩略图';
$lang['SYNC_THUMBSEC_DESC'] = '指定缩略图间的时间间隔';
$lang['SYNC_THUMBSIZE'] = '缩略图尺寸';
$lang['SYNC_THUMBSIZE_DESC'] = '像素尺寸，不要太大，默认即可。Youtube 使用的是 190x68。';
$lang['SYNC_WARNINGS'] = '警告';
$lang['VOLUME'] = '音量';
$lang['VOLUME_DESC'] = '设置音量级别。0 为关（无声），1.0 为最高，0.5 为一半。';
$lang['SYNC_POSTEROVERLAY'] = '添加影片效果';
$lang['SYNC_POSTER'] = '以视频中第 x 秒处的图像创建海报';
$lang['SYNC_ERRORS'] = '错误';
$lang['SYNC_INFOS'] = '详细信息';
$lang['SYNC_METADATA_DESC'] = '将以来自视频的元数据覆盖数据库中的信息。';
$lang['SYNC_OUTPUT'] = '输出格式';
$lang['SYNC_OUTPUT_DESC'] = '选择海报和缩略图的输出格式';
$lang['HEIGHT'] = '最大高度';
$lang['HEIGHT_DESC'] = '设置视频的最大高度。如果视频高度超出此值，将按此处设置高度显示。';
$lang['LANGUAGE'] = '语言';
$lang['LANGUAGE_DESC'] = '选择播放器的语言。';
$lang['PLAYER_DESC'] = '选择 VideoJS 的版本。';
$lang['METADATA_DESC'] = '元数据描述';
$lang['RESOLUTION'] = '分辨率';
$lang['RESOLUTION_DESC'] = '切换分辨率。';
$lang['METADATA'] = '元数据';
$lang['METADATA_FILE'] = '显示文件：';
$lang['PLAYER'] = 'Player';
$lang['PLAYER_TYPE'] = '类型：';
$lang['STATS'] = '统计';
$lang['SYNC_INTRO'] = '视频的元数据同步和缩略图创建';
$lang['VIDEOS'] = '个视频在你的图库中';
$lang['VIDEOS_GEOTAGGED'] = '个带地理标记的视频在你的图库中';
$lang['VIDEOS_THUMB'] = '个带缩略图的视频在你的图库中';
$lang['INTRO_THUMB'] = '使用 <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a> 生成缩略图（如果可用）';
$lang['INTRO_VIDEOJS'] = '添加开源 HTML5 视频播放器 <a href="http://www.videojs.com/" target="_blank">VideoJS</a>';
$lang['INTRO_SUPPORT'] = '有关更多信息，请参阅<a href="https://github.com/xbgmsharp/piwigo-videojs/wiki" target="_blank">插件文档</a>；如果遇到问题，请查看<a href="https://piwigo.org/forum/" target="_blank">论坛</a>。<br/>如需报告错误和建议新功能，请创建一个新的<a href="https://github.com/xbgmsharp/piwigo-videojs/issues" target="_blank">问题</a>。';
$lang['INTRO_CONFIG'] = '此插件：';
$lang['INTRO_METADATA'] = '使用<a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo</a> 或 <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a> (如果可用)提取元数据';
$lang['SYNC_DETECTED'] = '检测到的视频';
$lang['SYNC_ERROR_COUNT'] = '同步过程中的错误';
$lang['SYNC_METADATA'] = '元数据';
$lang['SYNC_METADATA_ADDED'] = '添加了元数据的视频';
$lang['SYNC_POSTERS_NEW'] = '创建海报';
$lang['SYNC_POSTER_TITLE'] = '图库的海报';
$lang['SYNC_RESULTS'] = '同步结果';
$lang['SYNC_THUMB'] = 'VideoJS缩略图';
$lang['SYNC_THUMBS_NEW'] = '已创建VideoJS缩略图';
$lang['SYNC_WARNINGS_COUNT'] = '同步期间的警告';
$lang['SYNC_POSTER_REQUIRE'] = '需要 <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a>';
$lang['SYNC_REQUIRE'] = '需要<a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo</a>或<a href="http://www.ffmpeg.org" target="_blank">FFprobe</a>';
$lang['SYNC_DELETE'] = '删除VideoJS缩略图和额外的视频源';
$lang['SYNC_DELETE_ASK'] = '你确定吗？额外的视频源和VideoJS缩略图将被删除。';
$lang['SYNC_DELETE_DESC'] = '适用于不包含方向元数据的视频，并且这些视频与 VideoJS 播放器和 videojs-zoomrotate 插件一起显示。视频及其海报保持不变。仅更新存储在数据库中的方向参数。';
$lang['VIDEOS_ALL'] = '所有视频';
$lang['VIDEOS_METADATA_POSTERS'] = '视频元数据和海报';
$lang['VIDEOS_WO_POSTER'] = '所有视频(没有海报)';
$lang['VIDEOS_W_POSTER'] = '所有视频(有海报)';
$lang['DIR_NOT_WRITABLE'] = '没有目录的写入权限';
$lang['FILE_NOT_READABLE'] = '文件不可读';
$lang['METADATA_COUNT'] = '元数据项的数量：';
$lang['POSTER'] = '海报';
$lang['POSTER_ERROR'] = 'FFmpeg 无法生成海报，请检查日志并手动尝试';
$lang['SYNC_DATABASE'] = '从数据库中提取的元数据';
$lang['SYNC_DURATION_ERROR'] = '时长未知，无法创建海报';
$lang['SYNC_DURATION_SHORT'] = '持续时间太短，海报将在另一个位置生成';
$lang['SYNC_THUMBSIZE_ERROR'] = '缩略图大小无效，恢复默认值 120 像素';
$lang['SYNC_THUMB_ERROR'] = 'FFmpeg 无法生成缩略图，请检查日志并手动尝试';
$lang['SYNC_MEDIAINFO_ERROR'] = '由于缺少 XML 库，无法使用 MediaInfo 检索元数据。';
$lang['SYNC_METADATA_ERROR'] = '由于未安装 ExifTool、FFprobe 或 MediaInfo，或者它们的路径不正确，元数据无法检索。';
$lang['SYNC_NONE'] = '你让我什么都不做！';
$lang['SYNC_POSTEROVERLAY_ERROR'] = '由于缺少 GD 库，电影效果已禁用。';
$lang['SYNC_POSTER_ERROR'] = '由于未安装 FFmpeg 或其路径不正确，海报和缩略图创建已禁用。';
$lang['SYNC_REPRESENTATIVES'] = '手动上传海报';
$lang['SYNC_REPRESENTATIVES_DESC'] = '对于每个视频，更新与其海报相关的信息。';
$lang['VIDEO'] = '视频';
$lang['VIDEOJS_SETTINGS'] = 'VideoJS 设置';
$lang['VIDEO_SRC'] = '视频来源';