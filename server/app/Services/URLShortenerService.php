<?php

namespace App\Services;

use App\Models\Shorten;

class URLShortenerService {
    private $length = 6;
    private $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

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
        return Shorten::where('hash', $hash)->exists();
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
