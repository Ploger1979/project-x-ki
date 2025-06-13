<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Services\FetchTickets;
use App\Services\OpenAiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    protected $fetchTickets;
    protected $openAiService;

    public function __construct(FetchTickets $fetchTickets, OpenAiService $openAiService)
    {
        $this->fetchTickets = $fetchTickets;
        $this->openAiService = $openAiService;
    }

    /**
     *  Get all tickets
     * يرجع كل التذاكر من قاعدة البيانات كـ JSON
     */
    public function index()
    {
        try {
            $tickets = Ticket::all();
            return response()->json([
                'success' => true,
                'tickets' => $tickets,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch tickets'
            ], 500);
        }
    }

    /**
     *  Search tickets
     * ▪︎ يبحث عن تذاكر بناءً على الكلمات المفتاحية أو customer_id
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'query' => 'required|string',
            'customer_id' => 'nullable|integer'
        ]);

        $tickets = Ticket::query()
            ->when($validated['customer_id'] ?? false, function ($query, $customerId) {
                $query->where('kunden_id', $customerId);
            })
            ->where(function ($q) use ($validated) {
                $q->where('betreff', 'like', '%' . $validated['query'] . '%')
                    ->orWhere('beschreibung', 'like', '%' . $validated['query'] . '%');
            })
            ->get();

        return response()->json([
            'success' => true,
            'tickets' => $tickets
        ]);
    }

    /**
     * // Fetch tickets from external system (if needed)
     * ▪︎ يجلب تذاكر من النظام الخارجي (DoIt API مثلاً) بناءً على تاريخ/وقت/customerId
     */
    public function fetchTickets(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'customerId' => 'required|string',
            'instruction' => 'nullable|string',
        ]);

        try {
            // استدعى خدمة FetchTickets (اللي بترجع مصفوفة من التذاكر)
            $sinceDateTime = $validated['date'] . ' ' . $validated['time'];
            $tickets = $this->fetchTickets->fetchTicketsFromDoit($sinceDateTime, $validated['customerId']);

            $response = $this->openAiService->getResponse($tickets);

            return response()->json([
                'success' => true,
                'tickets' => $tickets,
                'result' => $response
            ]);
        } catch (\Exception $e) {
            Log::error('Fetch tickets error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process tickets'
            ], 500);
        }
    }

    /**
     * // Generate answer for a ticket description
     * ▪︎ يستقبل “description” كـ String ويرسلها لـ OpenAIService
     */
    public function generateAnswer(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string'
        ]);

        try {
            $answer = $this->openAiService->generateAnswer($validated['description']);
            return response()->json([
                'success' => true,
                'answer' => $answer
            ]);
        } catch (\Exception $e) {
            Log::error('AI answer error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate answer'
            ], 500);
        }
    }
}