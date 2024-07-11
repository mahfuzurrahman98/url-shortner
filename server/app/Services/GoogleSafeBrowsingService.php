<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleSafeBrowsingService {
    private $apiKey;
    private $apiUrl;

    public function __construct() {
        $this->apiKey = env('GOOGLE_SAFE_BROWSING_API_KEY');
        $this->apiUrl = 'https://safebrowsing.googleapis.com/v4/threatMatches:find?key=' . $this->apiKey;
    }

    public function isUrlSafe($url) {
        try {
            $response = Http::post($this->apiUrl, [
                'client' => [
                    'clientId' => 'URL-Shortner',
                    'clientVersion' => '1.0',
                ],
                'threatInfo' => [
                    'threatTypes' => ['MALWARE', 'SOCIAL_ENGINEERING'],
                    'platformTypes' => ['ANY_PLATFORM'],
                    'threatEntryTypes' => ['URL'],
                    'threatEntries' => [
                        ['url' => $url],
                    ],
                ],
            ]);


            $responseData = $response->json();

            if (empty($responseData)) {
                return [
                    'safe' => true
                ];
            }

            if (!empty($responseData['error'])) {
                throw new \Exception($responseData['error']['message']);
            }


            if (!empty($responseData['matches'])) {
                $threatType = $responseData['matches'][0]['threatType'];
                return [
                    'safe' => false,
                    'threatType' => $threatType
                ];
            } else {
                return [
                    'safe' => true
                ];
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}


/*
{
    "data": {
        "response": {
            "matches": [
                {
                    "threatType": "MALWARE",
                    "platformType": "ANY_PLATFORM",
                    "threat": {
                        "url": "http://testsafebrowsing.appspot.com/s/malware.html"
                    },
                    "cacheDuration": "300s",
                    "threatEntryType": "URL"
                }
            ]
        }
    }
}

{
    "data": {
        "response": {
            "matches": [
                {
                    "threatType": "SOCIAL_ENGINEERING",
                    "platformType": "ANY_PLATFORM",
                    "threat": {
                        "url": "http://testsafebrowsing.appspot.com/s/phishing.html"
                    },
                    "cacheDuration": "300s",
                    "threatEntryType": "URL"
                }
            ]
        }
    }
}
 */
