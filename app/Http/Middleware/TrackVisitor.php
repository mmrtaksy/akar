<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Illuminate\Support\Facades\Auth;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');
        $url = $request->fullUrl();
        $referer = $request->header('referer');

        // Statik dosya uzantılarını kontrol et
        if ($this->isStaticFile($url)) {
            return $next($request);
        }

        // Botları kontrol et
        if ($this->isBot($userAgent)) {
            return $next($request);
        }

        $visitor = Visitor::where('ip_address', $ipAddress)
            ->where('url', $url)
            ->first();

        if ($visitor) {
            $visitor->increment('visit_count');
            $visitor->last_visit_at = now();
            $visitor->referer = $referer;
            $visitor->save();
        } else {
            $visitor = new Visitor([
                'user_id' => Auth::check() ? Auth::id() : null,
                'ip_address' => $ipAddress,
                'browser' => $this->getBrowser($userAgent),
                'device' => $this->getDevice($userAgent),
                'country' => $this->getCountry($ipAddress),
                'referer' => $referer,
                'url' => $url,
                'last_visit_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $visitor->save();
        }

        return $next($request);
    }

    private function isStaticFile($url)
    {
        $staticExtensions = ['css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'woff', 'woff2', 'ttf', 'eot', 'ico'];
        $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
        return in_array($extension, $staticExtensions);
    }

    private function isBot($userAgent)
    {
        $botKeywords = ['bot', 'crawl', 'spider', 'slurp', 'mediapartners'];
        foreach ($botKeywords as $bot) {
            if (stripos($userAgent, $bot) !== false) {
                return true;
            }
        }
        return false;
    }

    private function getBrowser($userAgent)
    {
        if (strpos($userAgent, 'Firefox') !== false) {
            return 'Firefox';
        } elseif (strpos($userAgent, 'Chrome') !== false) {
            return 'Chrome';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            return 'Safari';
        }
        return 'Unknown';
    }

    private function getDevice($userAgent)
    {
        return preg_match('/mobile/i', $userAgent) ? 'Mobile' : 'Desktop';
    }

    private function getCountry($ipAddress)
    {
        $url = "https://api.country.is/{$ipAddress}";
        $response = @file_get_contents($url);
        $data = json_decode($response, true);

        return $data['country'] ?? 'Unknown';
    }
}
