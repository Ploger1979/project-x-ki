<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Inertia\Inertia;

class TicketFrontendController extends Controller
{
    // Dashboard View (mit extra letzteAktivitaeten + kleine Anzahl Tickets)
    public function dashboard()
    {
        $tickets = Ticket::with('kunde')->latest()->take(20)->get();

        // خلي الأحداث تظهر حقيقية بالتواريخ والحالة
        $letzteAktivitaeten = Ticket::latest()->take(5)->get()->map(function ($ticket) {
            // هات اسم العميل لو موجود
            $kunde = $ticket->kunde?->name ?? 'Unbekannt';

            // التاريخ بصيغة ألمانية
            $datum = \Carbon\Carbon::parse($ticket->updated_at)->format('d.m.Y H:i');

            // نص النشاط حسب الحالة
            if ($ticket->status == "geschlossen") {
                return "Ticket #{$ticket->id} für <b>{$kunde}</b> wurde <span class='text-red-600'>geschlossen</span>. <span class='text-gray-500'>($datum)</span>";
            }
            if ($ticket->status == "offen") {
                return "Neues Ticket #{$ticket->id} für <b>{$kunde}</b> wurde erstellt. <span class='text-gray-500'>($datum)</span>";
            }
            if ($ticket->status == "in_progress") {
                return "Ticket #{$ticket->id} für <b>{$kunde}</b> ist in Bearbeitung. <span class='text-gray-500'>($datum)</span>";
            }
            return "Ticket #{$ticket->id} ({$ticket->title}) aktualisiert. <span class='text-gray-500'>($datum)</span>";
        });

        return Inertia::render('Dashboard', [
            'tickets' => $tickets,
            'letzteAktivitaeten' => $letzteAktivitaeten,
        ]);
    }

    // Ticket List View
    public function list()
    {
        $tickets = Ticket::with('kunde')->latest()->take(50)->get();

        return Inertia::render('Tickets/List', [
            'tickets' => $tickets,
        ]);
    }


    // Ticket Analyse
    public function analyse()
    {
        $tickets = \App\Models\Ticket::with('kunde')->latest()->take(50)->get();

        return Inertia::render('Tickets/Analyse', [
            'tickets' => $tickets,
        ]);
    }
}