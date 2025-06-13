<?php

namespace App\Http\Controllers;

use App\Services\FetchTickets;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia; 
class JsonDisplayController extends Controller
{
    protected $fetchTicketsService;

    public function __construct(FetchTickets $fetchTicketsService)
    {
        $this->fetchTicketsService = $fetchTicketsService;
    }

    public function show()
    {
        try {
            // Tickets der letzten 10 Tage abrufen
            $since = now()->subDays(10)->format('Y-m-d H:i:s');
            Log::info('Using since parameter:', ['since' => $since]); // Zum Debuggen

            $tickets = $this->fetchTicketsService->fetchTicketsFromDoit($since);

            // Tickets als JSON an Vue (Inertia) schicken
            return Inertia::render('Tickets/JsonDisplay', [
                'tickets' => $tickets,
            ]);
        } catch (\Exception $e) {
            Log::error('Fehler beim Abrufen der Tickets: ' . $e->getMessage());
            return response()->json(['error' => 'Abrufen der Tickets fehlgeschlagen'], 500);
        }
    }
}