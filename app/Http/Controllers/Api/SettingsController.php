<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

use App\Services\OpenAiService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;

class SettingsController extends Controller
{
    // Aktuelles Modell ausgeben
    public function getModel()
    {
        $model = config('openai.model', 'gpt-4o-2024-05-13');
        return response()->json(['model' => $model]);
    }

    // Cache leeren
    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');

        return response()->json(['message' => 'Cache erfolgreich geleert!']);
    }

    // Test Verbindung zu OpenAI
    public function testConnection(OpenAiService $openAiService)
    {
        try {
            $testAnswer = $openAiService->generateAnswer('Dies ist ein Test für die OpenAI Verbindung.');
            return response()->json(['message' => 'OpenAI Antwort: ' . $testAnswer]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Fehler beim Test der Verbindung: ' . $e->getMessage()], 500);
        }
    }

    public function index()
    {
        $logs = [
            ['text' => 'System gestartet', 'time' => Carbon::now()->subMinutes(3)->format('d.m.Y H:i')],
            ['text' => 'Letzter Cache-Reset', 'time' => Carbon::now()->subMinutes(2)->format('d.m.Y H:i')],
            ['text' => 'Modell geändert', 'time' => Carbon::now()->subMinutes(1)->format('d.m.Y H:i')],
        ];

        return Inertia::render('Settings', [
            'user' => Auth::user(),
            'logs' => $logs,
            'model' => config('openai.model', 'gpt-4o-2024-05-13'),
        ]);
    }
}