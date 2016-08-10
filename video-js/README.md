Video JS Resolutions Plugin
==========================

Provides resolution switching capabilities for the [VideoJS](https://github.com/videojs/video.js) player.

**Example:**
http://vidcaster.github.io/video-js-resolutions

**To Use:**

* Include the plugin in the standard way.  See https://github.com/videojs/video.js/blob/master/docs/plugins.md
* Also include video-js-resolutions.css in the folder where your video-js.css file lives.

**Here's how to specify multiple streams:**

```html
<video id="vid1" class="video-js vjs-default-skin" controls preload="auto" width="640" height="264" poster="http://video-js.zencoder.com/oceans-clip.png" data-setup='{}'>
  <source src="http://video-js.zencoder.com/oceans-clip_hd.mp4" type='video/mp4' data-res="HD">
  <source src="http://video-js.zencoder.com/oceans-clip_sd.mp4" type='video/mp4' data-res="SD" data-default="true">
  <source src="http://video-js.zencoder.com/oceans-clip.webm" type='video/webm'>
  <source src="http://video-js.zencoder.com/oceans-clip.ogv" type='video/ogg'>
  <p>Video Playback Not Supported</p>
</video>
```

**Or if you're passing in the sources programatically:**

```javascript
myPlayer.src([
  { type: "video/mp4", src: "http://www.example.com/path/to/hd_video.mp4", data-res: "HD" },
  { type: "video/mp4", src: "http://www.example.com/path/to/sd_video.mp4", data-res: "SD", data-default: true },
  { type: "video/webm", src: "http://www.example.com/path/to/video.webm" },
  { type: "video/ogg", src: "http://www.example.com/path/to/video.ogv" }
]);
```

Browser Support
---------------

Target browsers for this implementation are Chrome, Safari, IE10, Firefox, Android, and iOS.

Caveats
-------

Currently only the *dev build* is supported (video.dev.js).  The minified, CDN-hosted version won't work due to the obfuscation of methods by the Closure compiler.  If you need minification you should probably minify your own build.  We'd like to get the distributed, minified, version working with this plugin.

Another limitation of the implementation is that only homogeneous video types are resolution switchable. So you can't specify a webm SD and an mp4 HD and expect the player to pick it up.

I also recommend you include this plugin either on player instantiation or immediately thereafter.  I'm not sure about the reliability of adding the plugin to an instance long after the instance has been active.
