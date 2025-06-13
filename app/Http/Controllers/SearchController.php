<?php

namespace App\Http\Controllers;

use App\Services\FetchTickets;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
class SearchController extends Controller
{
    protected $fetchTicketsService;

    public function __construct(FetchTickets $fetchTicketsService)
    {
        $this->fetchTicketsService = $fetchTicketsService;
    }

    public function index(Request $request)
    {
        Log::info('SearchController index-Methode aufgerufen');
        $tickets = [];
        $sinceDate = $request->input('since_date');
        $sinceTime = $request->input('since_time') ?? '00:00';

        if ($sinceDate) {
            try {
                // Kombiniere Datum und Uhrzeit zu einem vollständigen Datum
                $since = Carbon::parse("$sinceDate $sinceTime")->format('Y-m-d H:i:s');
                Log::info('Since-Parameter:', ['since' => $since]);

                // Tickets abrufen
                $tickets = $this->fetchTicketsService->fetchTicketsFromDoit($since);

            } catch (\Exception $e) {
                Log::error('Ticket-Fehler:', ['message' => $e->getMessage()]);
                // Fehler an Vue/Inertia geben
                return Inertia::render('Tickets/Search', [
                    'error' => 'Abrufen der Tickets fehlgeschlagen',
                    'sinceDate' => $sinceDate,
                    'sinceTime' => $sinceTime,
                ]);
            }
        }

        return Inertia::render('Tickets/Search', [
            'tickets' => $tickets,
            'sinceDate' => $sinceDate,
            'sinceTime' => $sinceTime,
        ]);
    }
}