<?php

namespace App\Support;

class HtmlSanitizer
{
    private const ALLOWED_TAGS = '<p><br><strong><b><em><i><u><s><ul><ol><li><blockquote><h2><h3><h4><a><img><figure><figcaption><table><thead><tbody><tr><th><td>';

    public static function clean(?string $html): ?string
    {
        if ($html === null) {
            return null;
        }

        $html = strip_tags($html, self::ALLOWED_TAGS);
        $html = preg_replace('/\s+on[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html) ?? '';
        $html = preg_replace('/\s+(href|src)\s*=\s*(["\'])\s*javascript:[^"\']*\2/i', ' $1="#"', $html) ?? '';
        $html = preg_replace('/\s+(href|src)\s*=\s*javascript:[^\s>]*/i', ' $1="#"', $html) ?? '';
        $html = preg_replace('/<\s*(script|iframe|object|embed|form|input|button|textarea|select|option|meta|link|style)\b[^>]*>.*?<\s*\/\s*\1\s*>/is', '', $html) ?? '';
        $html = preg_replace('/<\s*(script|iframe|object|embed|form|input|button|textarea|select|option|meta|link|style)\b[^>]*\/?>/i', '', $html) ?? '';

        return trim($html);
    }
}
