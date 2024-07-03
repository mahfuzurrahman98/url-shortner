<?php

namespace App\Http\Controllers;

use App\Models\Shorten;
use Illuminate\Http\Request;
use App\Services\UrlSafetyService;
use App\Services\UrlComparisonService;
use Illuminate\Support\Facades\Validator;

class ShortenController extends Controller {
    protected $urlSafetyService;
    protected $urlCompressionService;

    public function __construct(
        UrlSafetyService $urlSafetyService,
        UrlComparisonService $urlCompressionService
    ) {
        $this->urlSafetyService = $urlSafetyService;
        $this->urlCompressionService = $urlCompressionService;
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'original_url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $original_url = $request->original_url;
        $normalized_url = $this->urlCompressionService->normalizeUrl($original_url);


        // Check if the URL already exists in the database
        $existingUrl = Shorten::where('normalized_url', $normalized_url)->first();
        if ($existingUrl) {
            return response()->json(['short_url' => url($existingUrl->short_url)]);
        }


        // Check URL safety
        if (!$this->urlSafetyService->isUrlSafe($original_url)) {
            return response()->json(['error' => 'URL is not safe'], 400);
        }




        // Generate short URL logic
        $shortUrl = $this->generateShortUrl();

        // Store URL in database
        $newUrl = Shorten::create([
            'original_url' => $original_url,
            'normalized_url' => $normalized_url,
            'short_url' => $shortUrl,
        ]);

        return response()->json(['short_url' => url($newUrl->short_url)]);
    }

    public function show(Request $request) {
    }
}
