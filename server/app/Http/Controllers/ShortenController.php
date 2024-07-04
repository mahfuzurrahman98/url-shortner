<?php

namespace App\Http\Controllers;

use App\Models\Shorten;
use Illuminate\Http\Request;
use App\Services\URLService;
use App\Services\URLShortenerService;
use Illuminate\Support\Facades\Validator;

class ShortenController extends Controller {
    protected $urlService;
    protected $urlShortenerService;

    public function __construct(
        URLService $urlSerive,
        URLShortenerService $urlShortenerService
    ) {
        $this->urlService = $urlSerive;
        $this->urlShortenerService = $urlShortenerService;
    }

    public function store(Request $request) {
        try {
            // Validation
            $validator = Validator::make($request->all(), [
                'originalUrl' => 'required|url',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $originalUrl = $request->originalUrl;
            $normalizedUrl = $this->urlService->normalizeUrl($originalUrl);

            // Check if the URL already exists in the database
            $existingUrl = Shorten::where('normalized_url', $normalizedUrl)->first();
            if ($existingUrl) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'shortUrl' => $existingUrl->short_url
                    ]
                ], 200);
            }

            // Check URL safety
            if (!$this->urlService->isUrlSafe($originalUrl)) {
                return response()->json([
                    'success' => false,
                    'message' => 'The URL is not safe.'
                ], 400);
            }

            // Generate short URL logic
            $shortUrl = $this->urlShortenerService->generateUniqueHash($originalUrl);

            // Store URL in database
            $newUrl = Shorten::create([
                'original_url' => $originalUrl,
                'normalized_url' => $normalizedUrl,
                'short_url' => $shortUrl,
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'shortUrl' => $newUrl->short_url
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function show(Request $request, string $hash) {
        try {
            $url = Shorten::where('short_url', $hash)->first();
            if ($url) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'originalUrl' => $url->original_url
                    ]
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'The URL does not exist.'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
