<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FetchTickets
{
    protected $accessTokenService;
    private const API_TIMEOUT = 60;

    public function __construct(AccessTokenService $accessTokenService)
    {
        $this->accessTokenService = $accessTokenService;
    }

    public function fetchTicketsFromDoit(string $since, string $customer): array
    {
        $since = $since ?? Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
        $accessToken = $this->accessTokenService->getAccessToken();

        $params = [
            'since' => $since,
            'customer' => $customer
        ];

        $url = config('enodia.ticket-source-url');
        $response = Http::withToken($accessToken)
            ->timeout(self::API_TIMEOUT)
            ->get($url, $params);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Fehler beim Abrufen der Tickets', ['body' => $response->body()]);
        return [];
    }
}