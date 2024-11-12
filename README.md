piwigo-videojs
==============

[![Version](https://img.shields.io/github/release/Piwigo/piwigo-videojs.svg)](https://piwigo.org/ext/index.php?eid=610)
[![ReleaseDate](https://img.shields.io/github/release-date/Piwigo/piwigo-videojs.svg?color=screen)](https://piwigo.org/ext/index.php?eid=610)
[![ClosedIssues](https://img.shields.io/github/issues-closed-raw/Piwigo/piwigo-videojs.svg?color=success)](https://github.com/Piwigo/piwigo-videojs/issues?utf8=✓&q=is%3Aissue+is%3Aclosed)
[![OpenedIssues](https://img.shields.io/github/issues-raw/Piwigo/piwigo-videojs.svg?style=flat)](https://github.com/Piwigo/piwigo-videojs/issues)

A [plugin](http://piwigo.org/ext/extension_view.php?eid=610) which extends [Piwigo](http://piwigo.org) with video support:
* retrieves video metadata
* produces thumbnails from videos
* brings [Videojs](http://videojs.com/) port for piwigo


### Installation
1. Installation:
 * Use the Piwigo built-in plugin manager (preferred)
 * or git clone and move to ``your-gallery/plugins/`` directory
 * or download from [http://piwigo.org/ext/extension_view.php?eid=831](https://piwigo.org/ext/index.php?eid=610) and move to ``your-gallery/plugins/`` directory
2. Enable VideoJS from the Administration / Plugins section
3. Install the [LocalFiles Editor](https://piwigo.org/ext/index.php?eid=144) plugin if it is not already installed
4. Configure your server with the [LocalFiles Editor](https://piwigo.org/ext/extension_view.php?eid=144) extension so that it accepts video files with the text below. [It is highly recommended to not add the MOV format which is supported by only a very few web browsers](https://caniuse.com/?search=video%20format).
```
    /* File extensions — to allow video and other file types */
    $conf['file_ext'] = array_merge(
        $conf['picture_ext'],
        array('heic','tif','tiff','mp4','m4v','mpg','ogg','ogv','webm','webmv')
    );
    $conf['graphics_library'] = 'ext_imagick';
    $conf['upload_form_all_types'] = true;

    /* File names — to allow special characters */
    $conf['sync_chars_regex'] = '/^[a-zA-Z0-9-_. ]+$/';
```
5. Add also these lines to add metadata support:
```
    /* VideoJS — to add video metadata support */
    $conf['show_exif'] = true;
    $conf['show_exif_fields'] = array(
      'Make',
      'Model',
      'ExifVersion',
      'Software',
      'DateTimeOriginal',
      'FNumber',
      'ExposureBiasValue',
      'FILE;FileSize',
      'ExposureTime',
      'Flash',
      'ISOSpeedRatings',
      'FocalLength',
      'FocalLengthIn35mmFilm',
      'WhiteBalance',
      'ExposureMode',
      'MeteringMode',
      'ExposureProgram',
      'LightSource',
      'Contrast',
      'Saturation',
      'Sharpness',
      'bitrate',
      'channel',
      'date_creation',
      'display_aspect_ratio',
      'duration',
      'filesize',
      'format',
      'formatprofile',
      'codecid',
      'frame_rate',
      'latitude',
      'longitude',
      'make',
      'model',
      'playtime_seconds',
      'sampling_rate',
      'type',
      'resolution',
      'rotation',
      );    
```
### Requirements
VideoJS requires `MediaInfo` or `ffprobe` or `Exiftool` to retrieve metadata, and `ffmpeg` to produce posters i.e. thumbnails:
* If you can compile `MediaInfo` on your server, download the source code from the [MediaInfo website](https://mediaarea.net/en/MediaInfo/Download). Add the necessary libraries if needed and compile it. Then, enter the path to the `MediaInfo` directory as shown below so that the plugin knows how to call it.
* If you cannot compile software on your server for some reason, `ExifTool` is the solution because it is a platform-independent Perl library delivered with a command-line application. Download the [ExifTool version](https://exiftool.org) corresponding to your server and make it executable. Then, enter the path to the `ExifTool` directory as shown below so that the plugin knows how to call it.
* `ffmpeg` and `ffprobe` binaries (executables) can be downloaded from [FFbinaries](https://ffbinaries.com/downloads) for most platforms. So in most cases, it is not necessary to compile the [FFmpeg](https://ffmpeg.org/download.html) source code. Once it is installed and made executable, enter the path to the `FFmpeg` directory as shown below so that the plugin knows how to call it.

Copy/paste the below lines in LocalFiles Editor and replace the paths with those of your server. Put the lines in comment for the software that are not available (by adding `//` at the beginning):
```
    /* VideoJS — to gather metadata and produce thumbnails */
    // - requires 'MediaInfo' or 'ffprobe' or 'Exiftool' to sync metadata
    // - requires 'FFmpeg' to produce posters i.e. thumbnails
    // - define below the full path of the directories of the available executables
    //=> MediaInfo:
    //   1. download the source from https://mediaarea.net/en/MediaInfo/Download
    //   2. compile the source as explained here: https://github.com/MediaArea/MediaInfo
    //   3. check with './mediainfo --version' (on Linux)
    $conf['vjs_mediainfo_dir'] = '/home/clients/.../mediainfo/';
    //=> ExifTool:
    //   1. download the library and CLI from https://exiftool.org
    //   2. make it executable with e.g. chmod +x exiftool on Linux
    //   3. check it with e.g. './exiftool -ver' on Linux
    $conf['vjs_exiftool_dir'] = '/home/clients/.../exiftool/Image-ExifTool-12.92/';
    //=> FFmpeg:
    //   1. download binaries from https://ffbinaries.com/downloads
    //   2. on Linux: make ffmpeg and ffprobe executable with:
    //      > chmod +x ffmpeg
    //      > chmod +x ffprobe
    //   3. check it with e.g. './ffmpeg -version' on Linux
    $conf['vjs_ffprobe_dir'] = '/home/clients/.../ffmpeg/ffmpag-7.1/';
    $conf['vjs_ffmpeg_dir'] = '/home/clients/.../ffmpeg/ffmpag-7.1/';
```
If you encounter difficulties, for example to determine the full paths, add the following lines so that errors are displayed in the browser and logs are gathered in the `_data/logs folder` when you sync files:

    $conf['log_level'] = 'DEBUG';
    $conf['show_php_errors'] = E_ERROR;
    $conf['show_php_errors_on_frontend'] = true;


### Supported formats
The supported formats are those [supported by most browsers](https://caniuse.com/?search=video):
* mp4,m4v
* webm,webmv
* ogg,ogv

### Usage
Basically, medias are uploaded in a same way as standard pictures. You then synchronize the metadata and create posters and VideoJS thumbnails of a selection of medias from the Adminitrstaion / Plugins / VideoJS interface. You can also do this from the Edit Photo page or the Batch Manager page.

### Support
Please have a look at the forums if you encounter some issues during installation.

To report bugs and suggest new features, please create a new [issue](https://github.com/xbgmsharp/piwigo-videojs/issues).

### Thanks
* [videojs](http://videojs.com/)
* [getID3](http://getid3.sourceforge.net/)
* [FFmpeg](http://www.ffmpeg.org/)
* [MediaInfo](http://mediaarea.net/en/MediaInfo)
* [ExifTool](https://exiftool.org)
* [piwigo-jplayer](https://github.com/d-matt/piwigo-jplayer)
* The Piwigo Team for a great gallery software
* The Piwigo translation team

### Licence
The piwigo-videojs plugin for Piwigo is free software:  you can redistribute it
and/or  modify  it under  the  terms  of the  GNU  General  Public License  as
published by the Free Software Foundation.

This program  is distributed in the hope  that it will be  useful, but WITHOUT
ANY WARRANTY; without even the  implied warranty of MERCHANTABILITY or FITNESS
FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

See <http://www.gnu.org/licenses/gpl.html>.

