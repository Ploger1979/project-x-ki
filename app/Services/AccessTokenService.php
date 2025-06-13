<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AccessTokenService
{
    /**
     * Holt ein AccessToken von externer API (DoIt z.B.)
     * 👉 Aktuell nutzen wir ein Dummy-Token zum Testen
     */
    public function getAccessToken(): string
    {
        try {
            // 🚀 Dummy AccessToken, damit wir das System weiter entwickeln können
            Log::info('⚠️ Using Dummy AccessToken for testing');
            return 'dummy-token-123456';

            // Das ist der originale Code (kommentiert, nicht löschen!)
            /*
            $response = Http::post(config('enodia.customer-token-url'), [
                'grant_type' => 'client_credentials',
                'client_id' => config('enodia.customer-source-user'),
                'client_secret' => config('enodia.customer-source-password'),
            ]);

            if ($response->successful()) {
                return $response->json()['access_token'];
            }
            */
        } catch (\Exception $e) {
            Log::error('Fehler beim Abrufen des Access-Tokens:', ['message' => $e->getMessage()]);
        }

        return '';
    }
}