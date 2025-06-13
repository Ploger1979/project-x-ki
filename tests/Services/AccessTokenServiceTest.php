<?php

namespace Tests\Services;

use App\Services\AccessTokenService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * Testklasse für AccessTokenService.
 *
 * Diese Klasse testet die Funktionen zur Verwaltung und Abrufung von Zugriffstoken.
 */
class AccessTokenServiceTest extends TestCase
{
    /**
     * Testet, ob das Token aus dem Cache abgerufen wird, wenn es vorhanden ist.
     *
     * @return void
     */
    public function testGetAccessTokenWhenTokenInCache(): void
    {
        // Cache simulieren
        Cache::shouldReceive('get')
            ->once()
            ->andReturn('cached_token');

        // Service initialisieren und Token abrufen
        $accessTokenService = new AccessTokenService();
        $this->assertEquals('cached_token', $accessTokenService->getAccessToken());
    }

    /**
     * Testet, ob das Token erfolgreich von der API abgerufen und in den Cache gespeichert wird.
     *
     * @return void
     */
    public function testGetAccessTokenWhenFetchNewTokenSuccessful(): void
    {
        // Cache simulieren, als wäre kein Token vorhanden
        Cache::shouldReceive('get')->once()->andReturn(null);
        Cache::shouldReceive('put')->once();

        // Erfolgreiche HTTP-Antwort simulieren
        Http::fake([
            '*' => Http::response(['access_token' => 'new_token', 'expires_in' => 3600], 200)
        ]);

        $accessTokenService = new AccessTokenService();
        $this->assertEquals('new_token', $accessTokenService->getAccessToken());
    }

    /**
     * Testet, ob eine Ausnahme ausgelöst wird, wenn das Abrufen des Tokens fehlschlägt.
     *
     * @return void
     */
    public function testGetAccessTokenWhenFetchNewTokenFails(): void
    {
        // Cache simulieren, als wäre kein Token vorhanden
        Cache::shouldReceive('get')->once()->andReturn(null);

        // HTTP-Fehler simulieren
        Http::fake([
            '*' => Http::response([], 400)
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Failed to fetch access token');

        $accessTokenService = new AccessTokenService();
        $accessTokenService->getAccessToken();
    }
}
