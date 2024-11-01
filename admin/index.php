<?php
// +-----------------------------------------------------------------------+
// | This file is part of piwigo-videojs.                                  |
// |                                                                       |
// | For copyright and license information, please view the LICENSE        |
// | file that was distributed with this source code.                      |
// +-----------------------------------------------------------------------+

// Recursive call
$url = '../';
header( 'Request-URI: '.$url );
header( 'Content-Location: '.$url );
header( 'Location: '.$url );
exit();
?>
