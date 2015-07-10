piwigo-videojs
==============

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

Piwigo-videojs require those 2 programs to be install on your system:

* [MediaInfo](http://mediaarea.net/en/MediaInfo)
* [Libav](https://libav.org/)
* [FFmpeg](http://www.ffmpeg.org/)

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

To get support, please create new [issue](https://github.com/xbgmsharp/piwigo-videojs/issues)

Help me improve the plugin, rate my [plugin](http://piwigo.org/ext/extension_view.php?eid=610), and if possible please send a greeting message to me ;)

Thanks
-----

* [videojs](http://videojs.com/)
* [getid3](http://getid3.sourceforge.net/)
* [FFmpeg](http://www.ffmpeg.org/)
* [MediaInfo](http://mediaarea.net/en/MediaInfo)
* [Libav](https://libav.org/)
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

