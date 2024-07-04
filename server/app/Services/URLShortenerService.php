<?php

namespace App\Services;

use App\Models\Shorten;

class URLShortenerService {
    protected $length = 6;
    protected $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    public function generateUniqueHash(): string {
        $hash = $this->generateHash();

        if ($this->hashExists($hash)) {
            return $this->generateUniqueHash(); // Recursive call if hash exists
        }

        return $hash;
    }

    private function generateHash(): string {
        $hash = '';
        $charsetLength = strlen($this->charset);
        for ($i = 0; $i < $this->length; $i++) {
            $randomIndex = rand(0, $charsetLength - 1);
            $hash .= $this->charset[$randomIndex];
        }
        return $hash;
    }

    private function hashExists(string $hash): bool {
        return Shorten::where('short_url', $hash)->exists();
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
}
