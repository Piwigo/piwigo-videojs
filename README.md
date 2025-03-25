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

## Installation & Configuration
After installation, you must [configure](https://github.com/Piwigo/piwigo-videojs/wiki/How-to-install-the-plugin#installation) your Piwigo with the LocalFiles Editor plugin and [install](https://github.com/Piwigo/piwigo-videojs/wiki/How-to-install-the-plugin#requirements) `ExifTool`, `FFmpeg` or `MediaInfo` on your server to extract metadata and generate posters of a video. If `ExifTool`, `FFmpeg` or `MediaInfo` cannot be installed, we explain [here](https://github.com/Piwigo/piwigo-videojs/wiki/How-to-install-the-plugin#upload-video-posters-manually) how to upload posters manually.

## Supported formats
The supported formats are those [supported by most browsers](https://caniuse.com/?search=video):
* mp4,m4v
* webm,webmv
* ogg,ogv

## Usage
Basically, medias are uploaded in a same way as standard pictures. You then synchronize the metadata and create posters and VideoJS thumbnails of a selection of medias from the Adminitrstaion / Plugins / VideoJS interface. You can also do this from the Edit Photo page or the Batch Manager page.

## Support
* Please look at the [forums](https://piwigo.org/forum/) if you encounter any issues.
* To report bugs and suggest new features, please create a new [issue](https://github.com/xbgmsharp/piwigo-videojs/issues).

## Thanks
* [videojs](http://videojs.com/)
* [getID3](http://getid3.sourceforge.net/)
* [FFmpeg](http://www.ffmpeg.org/)
* [MediaInfo](http://mediaarea.net/en/MediaInfo)
* [ExifTool](https://exiftool.org)
* [piwigo-jplayer](https://github.com/d-matt/piwigo-jplayer)
* The Piwigo Team for a great gallery software
* The Piwigo translation team

## Licence
The piwigo-videojs plugin for Piwigo is free software:  you can redistribute it and/or  modify  it under  the  terms  of the  GNU  General  Public License  as published by the Free Software Foundation.

This program  is distributed in the hope  that it will be  useful, but WITHOUT ANY WARRANTY; without even the  implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

See <http://www.gnu.org/licenses/gpl.html>.
