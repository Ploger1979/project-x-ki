<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AccessTokenService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    protected $accessTokenService;

    public function __construct(AccessTokenService $accessTokenService)
    {
        $this->accessTokenService = $accessTokenService;
    }

    /**
     * GET /api/contacts
     * Holt die Kontakt-Daten von externer API → aktuell Fallback auf Dummy-Daten
     */
    public function index()
    {
        try {
            // Log für Debugging
            Log::info('🔍 Starte API-Call zu /api/contacts');

            // Token abrufen
            $accessToken = $this->accessTokenService->getAccessToken();
            Log::info('✅ Access Token erhalten:', ['token' => $accessToken]);

            // Wenn kein Token → Fehler
            if (!$accessToken) {
                return response()->json(['error' => 'AccessToken ist leer'], 401);
            }

            // Request an externe API senden
            $contactsResponse = Http::withToken($accessToken)
                ->get(config('enodia.contact-source-url'));

            // Wenn API-Fehler → Dummy-Daten zurückgeben
            if ($contactsResponse->serverError() || $contactsResponse->status() == 502) {
                Log::warning('⚠️ API nicht erreichbar → Dummy-Daten werden genutzt.');

                return response()->json([
                    [
                        'id'    => 1,
                        'name'  => 'Muster GmbH',
                        'email' => 'info@muster.de',
                    ],
                    [
                        'id'    => 2,
                        'name'  => 'Beispiel AG',
                        'email' => 'kontakt@beispiel.ag',
                    ],
                    [
                        'id'    => 3,
                        'name'  => 'Kanzlei Müller & Partner',
                        'email' => 'mueller@kanzlei-mueller.de',
                    ],
                    [
                        'id'    => 4,
                        'name'  => 'Zahnarztpraxis Dr. Schulze',
                        'email' => 'info@zahnarzt-schulze.de',
                    ],
                    [
                        'id'    => 5,
                        'name'  => 'Autohaus Berlin GmbH',
                        'email' => 'verkauf@autohaus-berlin.de',
                    ],
                    [
                        'id'    => 6,
                        'name'  => 'ImmobilienService24',
                        'email' => 'kontakt@immobilienservice24.de',
                    ],
                    [
                        'id'    => 7,
                        'name'  => 'IT Solutions Hamburg',
                        'email' => 'support@itsolutions-hamburg.de',
                    ],
                    [
                        'id'    => 8,
                        'name'  => 'Hotel am See',
                        'email' => 'reservierung@hotelamsee.de',
                    ],
                    [
                        'id'    => 9,
                        'name'  => 'Versicherung Stark AG',
                        'email' => 'service@versicherung-stark.de',
                    ],
                    [
                        'id'    => 10,
                        'name'  => 'Bäckerei Schmidt',
                        'email' => 'info@baeckerei-schmidt.de',
                    ],
                ], 200);
            }

            // Wenn API erfolgreich → echte Daten zurückgeben
            if ($contactsResponse->successful()) {
                Log::info('✅ Kontakte erfolgreich geladen');
                return response()->json($contactsResponse->json(), 200);
            }

            // Sonst generischer Fehler
            Log::error('❌ Fehler beim Laden der Kontakte', [
                'status' => $contactsResponse->status(),
                'body'   => $contactsResponse->body()
            ]);
            return response()->json(['error' => 'Fehler beim Abrufen der Kontakte'], 500);
        } catch (\Exception $e) {
            Log::error('❌ Ausnahmefehler im ContactController', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Fehler im Controller'], 500);
        }
    }
}