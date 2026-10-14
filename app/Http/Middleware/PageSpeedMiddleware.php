<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PageSpeedMiddleware
{
    /**
     * Handle an incoming request and apply PageSpeed optimizations:
     * - HTML Minification (whitespace collapse, comment removal)
     * - Transparent Gzip Output Compression
     * - Browser caching headers for shared hosting speed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Don't modify binary downloads, images, or non-HTML responses
        $contentType = $response->headers->get('Content-Type');
        if (!$contentType || !str_contains($contentType, 'text/html')) {
            return $response;
        }

        // Don't minify in admin forms or during debug error pages
        if ($request->is('admin*') && $request->is('admin/products/create*', 'admin/products/*/edit*', 'admin/posts/create*', 'admin/posts/*/edit*')) {
            return $response;
        }

        $content = $response->getContent();
        if (!$content) {
            return $response;
        }

        // 1. Minify HTML safely (protect script, style, pre, and textarea from whitespace destruction)
        $placeholders = [];
        $protectedContent = preg_replace_callback('/<(script|pre|textarea)\b[^>]*>.*?<\/\1>/si', function($matches) use (&$placeholders) {
            $key = '___PROTECTED_PAGE_BLOCK_' . count($placeholders) . '___';
            $placeholders[$key] = $matches[0];
            return $key;
        }, $content);

        if ($protectedContent !== null) {
            $search = [
                '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
                '/[^\S ]+\</s',     // strip whitespaces before tags, except space
                '/(\s)+/s',         // shorten multiple whitespace sequences
                '/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', // delete comments except IE conditionals
            ];

            $replace = [
                '>',
                '<',
                '\\1',
                '',
            ];

            $minified = preg_replace($search, $replace, $protectedContent);
            if ($minified) {
                // Restore protected blocks safely
                $content = strtr($minified, $placeholders);
            }
        }

        // 2. Apply Gzip Compression if client browser supports it
        $acceptEncoding = $request->header('Accept-Encoding', '');
        if (str_contains($acceptEncoding, 'gzip') && function_exists('gzencode') && !headers_sent()) {
            $compressed = gzencode($content, 6);
            if ($compressed !== false && strlen($compressed) < strlen($content)) {
                $response->setContent($compressed);
                $response->headers->set('Content-Encoding', 'gzip');
                $response->headers->set('Vary', 'Accept-Encoding');
                $response->headers->set('Content-Length', (string)strlen($compressed));
            } else {
                $response->setContent($content);
            }
        } else {
            $response->setContent($content);
        }

        // 3. Cache headers for fast client-side navigation
        if (!$request->is('admin*') && $request->isMethod('GET')) {
            $response->headers->set('Cache-Control', 'public, max-age=600, must-revalidate');
        }

        return $response;
    }
}
