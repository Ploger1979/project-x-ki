<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\ConnectionException;

/**
 * Service für die Kommunikation mit der DoIt API
 *
 * Handhabt HTTP GET-Anfragen, verwaltet Fehler und gibt die Daten der Antwort zurück
 *
 * @category Services
 * @package  App\Services
 */
class DoItApiService
{
    /**
     * Timeout für API-Anfragen in Sekunden
     */
    private const TIMEOUT_DURATION = 10;

    /**
     * Führt eine GET-Anfrage an die DoIt API aus
     *
     * Sendet die Anfrage mit den angegebenen Parametern und einem Access Token
     * Bei Erfolg wird die API-Antwort zurückgegeben, andernfalls werden Fehler behandelt
     *
     * @param string $endpoint Die URL des API-Endpunkts
     * @param array $params Parameter für die Anfrage
     * @param string $accessToken Access Token für die Authentifizierung
     * @return array Antwortdaten von der API
     *
     * @throws RequestException Wenn die Anfrage fehlschlägt
     * @throws ConnectionException Bei Netzwerkfehlern wie einem Timeout
     */
    public function fetchData(string $endpoint, array $params, string $accessToken): array
    {
        try {
            $response = Http::withToken($accessToken)
                ->timeout(self::TIMEOUT_DURATION)
                ->get($endpoint, $params);

            if ($response->successful()) {
                Log::info('API-Anfrage erfolgreich', ['endpoint' => $endpoint, 'params' => $params]);
                return $response->json();
            }

            $this->handleError($response);
        } catch (ConnectionException $e) {
            Log::error('Netzwerkfehler bei der API-Anfrage', ['exception' => $e->getMessage()]);
            throw new ConnectionException('Timeout beim Abrufen der Daten', $e->getCode(), $e);
        } catch (RequestException $e) {
            Log::error('API-Fehler bei der Anfrage', ['status' => optional($e->response)->status(), 'exception' => $e->getMessage()]);
            throw new RequestException($e->response);
        }
    }

    /**
     * Behandelt Fehler bei API-Anfragen.
     *
     * Protokolliert die fehlerhafte Antwort und wirft entsprechende Ausnahmen
     *
     * @param \Illuminate\Http\Client\Response $response Die fehlerhafte API-Antwort
     * @throws RequestException Bei fehlerhaften Antworten
     */
    private function handleError($response)
    {
        Log::warning('Fehlerhafte API-Antwort', ['status' => $response->status(), 'body' => $response->body()]);

        if ($response->status() === 408) {
            throw new ConnectionException('Timeout bei der Anfrage', 408);
        }

        throw new RequestException($response);
    }
}
