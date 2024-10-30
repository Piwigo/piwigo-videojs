piwigo-videojs
==============

[![Version](https://img.shields.io/github/release/Piwigo/piwigo-videojs.svg)](https://piwigo.org/ext/index.php?eid=610)
[![ReleaseDate](https://img.shields.io/github/release-date/Piwigo/piwigo-videojs.svg?color=screen)](https://piwigo.org/ext/index.php?eid=610)
[![ClosedIssues](https://img.shields.io/github/issues-closed-raw/Piwigo/piwigo-videojs.svg?color=success)](https://github.com/Piwigo/piwigo-videojs/issues?utf8=✓&q=is%3Aissue+is%3Aclosed)
[![OpenedIssues](https://img.shields.io/github/issues-raw/Piwigo/piwigo-videojs.svg?style=flat)](https://github.com/Piwigo/piwigo-videojs/issues)

[![Git](https://img.shields.io/badge/GitHub-Piwigo-blue.svg?style=flat)](https://github.com/Piwigo)
[![Twitter](https://img.shields.io/badge/twitter-@piwigo-blue.svg?style=flat)](http://twitter.com/piwigo)
[![Website](https://img.shields.io/badge/website-piwigo.org-orange.svg?style=flat)](http://piwigo.org)

Extend Piwigo with video support. [Videojs](http://videojs.com/) port for piwigo. Play your videos in the HTML5 video tag on your web gallery!

Piwigo-videojs is a [plugin](http://piwigo.org/ext/extension_view.php?eid=610) for the [Piwigo](http://piwigo.org/) web gallery that allows you to render various video files within your piwigo install.

Installation
-----

Upload this in ``your-gallery/plugins/`` directory.

* download the archive from github

        wget -O piwigo-videojs.zip https://github.com/xbgmsharp/piwigo-videojs/archive/master.zip

        unzip piwigo-videojs.zip
        
        mv piwigo-videojs-master piwigo-videojs

* or clone the project 

        git clone git://github.com/xbgmsharp/piwigo-videojs.git

Then, go to the admin site, in the plugin section and activate it.

Requirement
-----

Piwigo-videojs requires software to be installed on your server:

* [MediaInfo](http://mediaarea.net/en/MediaInfo)
* [ExifTool](https://exiftool.org)
* [FFmpeg](http://www.ffmpeg.org)

Please refer to the [wiki](https://github.com/xbgmsharp/piwigo-videojs/wiki/How-to-add-videos#step-2-install) for additional information.

Supported formats
-----

### Videos ###

* webm,webmv
* ogg,ogv
* mp4,m4v

Usage
-----

Basically, medias will be inserted in a same way as standard pictures.

Please refer to the [wiki](https://github.com/xbgmsharp/piwigo-videojs/wiki) for additional information.

Support
-----
Please have a look at the forums if you encounter some issues during installation.

To report bugs and suggest new features, please create a new [issue](https://github.com/xbgmsharp/piwigo-videojs/issues)

Help me improve the plugin, rate my [plugin](http://piwigo.org/ext/extension_view.php?eid=610), and if possible please send a greeting message to me ;)

Thanks
-----

* [videojs](http://videojs.com/)
* [getID3](http://getid3.sourceforge.net/)
* [FFmpeg](http://www.ffmpeg.org/)
* [MediaInfo](http://mediaarea.net/en/MediaInfo)
* [ExifTool](https://exiftool.org)
* [piwigo-jplayer](https://github.com/d-matt/piwigo-jplayer)

Licence
-------
The piwigo-videojs plugin for Piwigo is free software:  you can redistribute it
and/or  modify  it under  the  terms  of the  GNU  General  Public License  as
published by the Free Software Foundation.

This program  is distributed in the hope  that it will be  useful, but WITHOUT
ANY WARRANTY; without even the  implied warranty of MERCHANTABILITY or FITNESS
FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

See <http://www.gnu.org/licenses/gpl.html>.

