<?php
/**
 * This library is copied from diversen/http-send-file v3.2.0
 * 
 * MIT License
 * 
 * Copyright (c) Dennis Iversen <dennis.iversen@gmail.com> (github.com/diversen)
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * 
 */

namespace Diversen;

// Check whether we are indeed included by Piwigo.
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

use Exception;

/**
 * Sends a file to a client, with support for (multiple) range requests. 
 * It is also able to throttle the download.", 
 */
class Sendfile
{
    /**
     * if false we set content disposition from file that will be sent 
     */
    private string $disposition = '';

    /**
     * throttle speed in secounds
     */
    private float $sec = 0.1;

    /**
     * bytes per $sec
     */
    private int $bytes = 40960;

    /**
     * if contentType is false we try to guess it
     */
    private string $contentType = '';

    /**
     * The number of seconds until the content expires. 
     * If not set, defaults to a date in the past.
     */
    private ?int $expiresSeconds = null;

    /**
     * Sets the number of seconds until the content should be considered expired.
     */
    public function setExpires(int $secs)
    {
        $this->expiresSeconds = $secs;
    }

    /**
     * set content disposition. Name of file that will be sent to client
     * if empty we try to guess it from file path
     */
    public function setContentDisposition(string $file_name = '')
    {
        $this->disposition = $file_name;
    }

    /**
     * set throttle speed
     */
    public function throttle(float $sec = 0.1, int $bytes = 40960)
    {
        $this->sec = $sec;
        $this->bytes = $bytes;
    }

    /**
     * set content content type if empty we try to guess it
     */
    public function setContentType(string $content_type = '')
    {
        $this->contentType = $content_type;
    }

    /**
     * get name from path info
     */
    private function getBaseName(string $file)
    {
        $info = pathinfo($file);
        return $info['basename'];
    }


    /**
     * Send the file
     */
    public function send(string $file_path, bool $with_disposition = true)
    {
        if (!is_readable($file_path)) {
            throw new Exception("File {$file_path} not found or inaccessible.");
        }

        $size = $this->prepareHeaders($file_path, $with_disposition);
        if ($size === null) {
            return null;
        }

        $range = $this->processRangeHeader($size);

        $this->outputFileContents($file_path, $range);
    }

    /**
     * Prepares and sends HTTP headers.
     */
    private function prepareHeaders(string $file_path, bool $with_disposition): ?int
    {
        $size = filesize($file_path);
        $lastModified = filemtime($file_path);
        $etag = md5($file_path . $size . $lastModified);

        header('Etag: "' . $etag . '"');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastModified) . ' GMT');

        if ($this->clientCacheIsValid($etag)) {
            header("HTTP/1.1 304 Not Modified");
            return null;
        }

        if ($with_disposition) {
            $filename = $this->disposition ?: $this->getBaseName($file_path);
        } else {
            $filename = '';
        }

        $this->setDownloadHeaders($filename);

        header('Content-Type: ' . ($this->contentType ?: $this->getContentType($file_path)));
        header('Accept-Ranges: bytes');
        header("Cache-control: must-revalidate, private");
        header('Pragma: private');
        $this->setExpiresHeader();

        return $size;
    }


    /**
     * Sets the Expires header based on the expiresSeconds property.
     */
    private function setExpiresHeader()
    {
        if (is_null($this->expiresSeconds)) {
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        } else {
            $expiresTime = gmdate('D, d M Y H:i:s', time() + $this->expiresSeconds) . ' GMT';
            header("Expires: " . $expiresTime);
        }
    }

    /**
     * Checks if client cache is still valid.
     */
    private function clientCacheIsValid(string $etag): bool
    {

        if (!isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
            return false;
        }

        // Normalize ETag values for comparison
        $clientEtag = trim($_SERVER['HTTP_IF_NONE_MATCH'], "\"");
        $serverEtag = trim($etag);

        // Optionally strip known suffixes like "-gzip" and "-gunzip"
        // This is related to apache mod_deflate configuration
        // I don't know if it's needed for other web servers
        $clientEtag = preg_replace('/-gzip$/', '', $clientEtag);
        $clientEtag = preg_replace('/-gunzip$/', '', $clientEtag);

        return $clientEtag === $serverEtag;
    }


    /**
     * Sets headers related to file download.
     */
    private function setDownloadHeaders(string $filename)
    {
        if (ini_get('zlib.output_compression')) {
            ini_set('zlib.output_compression', 'Off');
        }

        if ($filename) {
            header('Content-Disposition: attachment; filename="' . rawurlencode($filename) . '"');
        }
    }

    /**
     * Handles range requests.
     */
    private function processRangeHeader(int $size): array
    {
        if (isset($_SERVER['HTTP_RANGE'])) {
            list($a, $range) = explode("=", $_SERVER['HTTP_RANGE'], 2);
            list($range) = explode(",", $range, 2);
            list($range, $range_end) = explode("-", $range);
            $range = intval($range);
            $range_end = ($range_end !== '') ? intval($range_end) : $size - 1;

            header("HTTP/1.1 206 Partial Content");
            header("Content-Length: " . ($range_end - $range + 1));
            header("Content-Range: bytes $range-$range_end/$size");

            return [$range, $range_end];
        } else {
            header("Content-Length: $size");
            return [0, $size - 1];
        }
    }

    /**
     * Outputs the file content.
     */
    private function outputFileContents(string $file_path, array $range): void
    {
        [$start, $end] = $range;
        $this->cleanAll();
        $length = $end - $start + 1; // exactly what you promised
        $chunkSize = $this->bytes;
        $pauseUs = (int)($this->sec * 1e6);

        $file = @fopen($file_path, 'rb');
        if (!$file) {
            throw new Exception("Cannot open {$file_path}");
        }
        fseek($file, $start);

        $sent = 0;
        while ($sent < $length && !feof($file) && ! connection_aborted()) {
            // never read past the end of the requested range
            $toRead = min($chunkSize, $length - $sent);
            $buffer = fread($file, $toRead);
            if ($buffer === false || $buffer === '') {
                break;  // I/O error or nothing left
            }

            echo $buffer;
            flush();
            usleep($pauseUs);

            $sent += strlen($buffer);
        }

        fclose($file);
    }

    /**
     *  Get content type
     */
    private function getContentType(string $path): string
    {
        $mimeType = 'application/octet-stream'; // Default MIME type if detection fails

        if (!is_file($path)) {
            return $mimeType;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo !== false) {
            $detectedType = finfo_file($finfo, $path);
            finfo_close($finfo);

            if ($detectedType !== false) {
                $mimeType = $detectedType;
            }
        }

        return $mimeType;
    }


    /**
     * clean all buffers
     */
    private function cleanAll()
    {
        while (ob_get_level()) {
            ob_end_clean();
        }
    }
}
