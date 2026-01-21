<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HttpCache
{
    public function handle($request, Closure $next, $cache = 'yes')
    {
        $response = $next($request);

        // Development ortamında HTML minify yapılmaz
        if (config('settings.activation_http_cache') == 0) {
            return $response;
        }

        // Güvenlik başlıklarını ekle
        $response->header("X-Content-Type-Options", "nosniff");

        if (isset($_SERVER['SCRIPT_FILENAME'])) {
            $lastModified = filemtime($_SERVER['SCRIPT_FILENAME']);
            $eTagFile = md5_file($_SERVER['SCRIPT_FILENAME']);
            $ifModifiedSince = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false;
            $eTagHeader = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false;

            // Yanıt başlıklarını ayarla
            $response->header("Last-Modified", gmdate("D, d M Y H:i:s", $lastModified) . " GMT");
            $response->header("Etag", "$eTagFile");
            $response->header('Cache-Control', 'public');
            $response->header("Pragma", "cache");

            // Sayfa değişmemişse 304 yanıtını gönder
            if ($ifModifiedSince == $lastModified || $eTagHeader == $eTagFile) {
                $response->header('HTTP/1.1', '304 Not Modified');
            }

        } else {
            // Varsayılan önbellek başlıkları
            $response->header("Cache-Control", "max-age=86400, public, s-maxage=86400");
            $response->header("Pragma", "cache");
            $response->header("Expires", Carbon::now()->addDay()->format('D, d M Y H:i:s') . ' GMT');
        }

        return $response;
    }
}
