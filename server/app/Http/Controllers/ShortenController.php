<?php

namespace App\Http\Controllers;

use App\Models\Shorten;
use App\Services\URLService;
use Illuminate\Http\Request;
use App\Services\URLShortenerService;
use Illuminate\Support\Facades\Validator;
use App\Services\GoogleSafeBrowsingService;

class ShortenController extends Controller {
    private URLShortenerService $urlShortenerService;
    private GoogleSafeBrowsingService $googleSafeBrowsingService;

    public function __construct(
        URLShortenerService $urlShortenerService,
        GoogleSafeBrowsingService $googleSafeBrowsingService
    ) {
        $this->urlShortenerService = $urlShortenerService;
        $this->googleSafeBrowsingService = $googleSafeBrowsingService;
    }

    public function store(Request $request) {
        try {
            // Validation
            $validator = Validator::make($request->all(), [
                'originalUrl' => 'required|url',
                'folder' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9_-]+$/',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ], 422);
            }

            $originalUrl = $request->originalUrl;
            $normalizedUrl = $this->urlShortenerService->normalizeUrl($originalUrl);

            // Check if the URL already exists in the database
            $existingUrlQuery = Shorten::where('normalized_url', $normalizedUrl);
            if ($request->has('folder')) {
                $existingUrlQuery->where('folder', $request->folder);
            }
            $existingUrl = $existingUrlQuery->first();

            if ($existingUrl) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'folder' => $existingUrl->folder,
                        'hash' => $existingUrl->hash
                    ]
                ], 200);
            }

            // Check URL safety
            $safetyResult = $this->googleSafeBrowsingService->isUrlSafe($normalizedUrl);
            if ($safetyResult['safe'] === false) {
                $threatType = $safetyResult['threatType'];
                return response()->json([
                    'success' => false,
                    'message' => [
                        'originalUrl' => 'The URL is marked as unsafe by Google with Threat type: ' . $threatType
                    ]
                ], 400);
            }

            // Generate short URL logic
            $hash = $this->urlShortenerService->generateUniqueHash($originalUrl);

            // Store URL in database
            $newUrl = Shorten::create([
                'original_url' => $originalUrl,
                'normalized_url' => $normalizedUrl,
                'folder' => $request->folder,
                'hash' => $hash,
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'folder' => $newUrl->folder,
                    'hash' => $newUrl->hash
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, string $hash) {
        try {
            // just add a validation that the hash is 6 characters long and consists of only letters and numbers
            $validator = Validator::make(['hash' => $hash], [
                'hash' => 'required|size:6|regex:/^[a-zA-Z0-9]+$/',
            ]);
            // though it's a 422 error, but respond with 404
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 404);
            }

            $url = Shorten::where('hash', $hash)
                ->whereNull('folder')
                ->first();

            if (!$url) {
                return response()->json([
                    'success' => false,
                    'message' => 'The URL does not exist.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'originalUrl' => $url->original_url
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function showWithFolder(Request $request, string $folder, string $hash) {
        try {
            $input = [
                'folder' => $folder,
                'hash' => $hash
            ];

            // just add a validation that the hash is 6 characters long and consists of only letters and numbers
            $validator = Validator::make($input, [
                'folder' => 'required|string|max:50|regex:/^[a-zA-Z0-9_-]+$/',
                'hash' => 'required|size:6|regex:/^[a-zA-Z0-9]+$/',
            ]);
            // though it's a 422 error, but respond with 404
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 404);
            }

            $url = Shorten::where('folder', trim($folder))
                ->where('hash', $hash)
                ->first();

            if (!$url) {
                return response()->json([
                    'success' => false,
                    'message' => 'The URL does not exist.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'originalUrl' => $url->original_url
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
