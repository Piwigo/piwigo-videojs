As advised in getid3's doc, we only need to keep 

* getid3.lib.php
* getid3.php
* module.audio.flac.php
* module.audio.mp3.php
* module.audio.ogg.php
* module.audio-video.flv.php
* module.audio-video.matroska.php
* module.audio-video.quicktime.php
* module.tag.apetag.php
* module.tag.id3v1.php
* module.tag.id3v2.php
* module.tag.lyrics3.php

and thus :
rm extension.* module.archive.* write.* module.graphic.* module.tag.xmp.php module.audio.voc.php module.audio.vqf.php module.audio.wavpack.php module.audio.tta.php module.audio.shorten.php module.audio.rkau.php module.audio.optimfrog.php module.audio.mpc.php module.audio.monkey.php module.audio.mod.php module.audio.midi.php module.audio.lpac.php module.audio.la.php module.audio.dts.php module.audio.dss.php module.audio.bonk.php module.audio.avr.php module.audio.au.php module.audio.ac3.php module.audio.aa.php module.audio.aac.php module.audio-video.asf.php module.audio-video.bink.php module.audio-video.nsv.php module.audio-video.real.php module.audio-video.mpeg.php module.audio-video.riff.php module.audio-video.swf.php
