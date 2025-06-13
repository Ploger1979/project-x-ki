<?php

namespace App\Http\Controllers;

use App\Services\FetchTickets;
use App\Services\OpenAiService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class OpenAIFrontendController extends Controller
{
    protected $fetchTickets;
    protected $openAiService;

    public function __construct(FetchTickets $fetchTickets, OpenAiService $openAiService)
    {
        $this->fetchTickets = $fetchTickets;
        $this->openAiService = $openAiService;
    }

    public function showSearchView()
    {
        // Nur die leere Vue-Seite anzeigen
        return Inertia::render('Tickets/OpenAISearch');
    }

    public function processSearch(Request $request)
    {
        $sinceDate = $request->input('since_date');
        $sinceTime = $request->input('since_time') ?? '00:00';

        if ($sinceDate) {
            try {
                // Kombiniere Datum und Uhrzeit zu einem vollständigen Zeitstempel
                $since = Carbon::parse("$sinceDate $sinceTime")->format('Y-m-d H:i:s');
                Log::info('Since-Parameter für OpenAI:', ['since' => $since]);

                // Tickets von DoIt abrufen
                $tickets = $this->fetchTickets->fetchTicketsFromDoit($since);

                // Tickets an OpenAI senden und Antwort abrufen
                $openAiResponse = $this->openAiService->getResponse($tickets);

                // Tickets und OpenAI-Antwort an das View übergeben
                return Inertia::render('Tickets/OpenAISearch', [
                    'tickets' => $tickets,
                    'openAiResponse' => $openAiResponse,
                    'sinceDate' => $sinceDate,
                    'sinceTime' => $sinceTime,
                ]);
            } catch (\Exception $e) {
                Log::error('Fehler beim Abrufen der Tickets oder OpenAI-Anfrage:', ['message' => $e->getMessage()]);
                // Bei Fehler einfach Vue-Seite anzeigen (mit Fehler-Message)
                return Inertia::render('Tickets/OpenAISearch', [
                    'error' => 'Abrufen der Tickets oder OpenAI-Anfrage fehlgeschlagen',
                    'sinceDate' => $sinceDate,
                    'sinceTime' => $sinceTime,
                ]);
            }
        }

        return Inertia::render('Tickets/OpenAISearch', [
            'sinceDate' => $sinceDate,
            'sinceTime' => $sinceTime,
        ]);
    }
}