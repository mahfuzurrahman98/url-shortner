<?php

namespace App\Services;

class URLService {
    public function areUrlsEquivalent(string $url1, string $url2): bool {
        // Normalize URLs
        $normalizedUrl1 = $this->normalizeUrl($url1);
        $normalizedUrl2 = $this->normalizeUrl($url2);

        // Compare normalized URLs
        return $normalizedUrl1 === $normalizedUrl2;
    }

    public function normalizeUrl(string $url): string {
        // Remove scheme (http, https)
        $url = preg_replace('#^https?://#', '', $url);

        // Remove www subdomain
        $url = preg_replace('#^www\.#', '', $url);

        // Remove trailing slashes
        $url = rtrim($url, '/');

        return $url;
    }

    public function isUrlSafe(string $url): bool {
        return true;
    }
}
