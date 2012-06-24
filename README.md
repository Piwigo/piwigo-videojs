piwigo-videojs
==============

[Videojs](http://videojs.com/) port for piwigo. Play your videos in the HTML5 video tag on your web gallery!

Piwigo-videojs is a plugin for the [Piwigo](http://piwigo.org/) web gallery that allows you to render various video files within your piwigo install.

Installation
------------

Upload this in ``your-gallery/plugins/`` dir.

* download the archive from github (https://github.com/xbgmsharp/piwigo-videojs/downloads) 

        wget -O piwigo-videojs.tar.gz https://github.com/xbgmsharp/piwigo-videojs/tarball/master

* or clone the project 

        git clone git://github.com/xbgmsharp/piwigo-videojs.git

Then, go to the admin site, in the plugin section and activate it.

Supported formats
-----------------

### Videos ###

* webm
* ogg
* mp4

<u>Note</u> : [videojs compatibility](http://videojs.com/#section4)
<u>Note</u> : You should also make sure that the webserver is sending the correct type for the given file.

``
AddType video/mp4 mp4
AddType video/mp4 m4v
AddType video/ogg ogv
AddType video/webm webm
AddType video/webm webmv
``


Usage
-----
Basically, medias will be inserted in a same way as standard pictures : 

* Uploads the videos in the `galleries` dir
* The thumbnail is formed as usual `thumbnail/TN-base_name.jpg`
* The HD can be inserted as usual as well in the `pwg_high`
* Finally use the sync button


Credit
------

* [piwigo-jplayer](https://github.com/d-matt/piwigo-jplayer)
* [videojs](http://videojs.com/)
* [getid3](http://getid3.sourceforge.net/)

Licence
-------
The piwigo-videojs plugin for Piwigo is free software:  you can redistribute it
and/or  modify  it under  the  terms  of the  GNU  General  Public License  as
published by the Free Software Foundation.

This program  is distributed in the hope  that it will be  useful, but WITHOUT
ANY WARRANTY; without even the  implied warranty of MERCHANTABILITY or FITNESS
FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

See <http://www.gnu.org/licenses/gpl.html>.
