<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OpenAiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OpenAiApiController extends Controller
{
    protected $openAiService;

    public function __construct(OpenAiService $openAiService)
    {
        $this->openAiService = $openAiService;
    }

    /**
     * POST /api/openai/process-tickets
     * يُعالج التذاكر ويرجع JSON يحتوي على النتيجة
     */
    public function getOpenAIResponse(Request $request)
    {
        try {
            $tickets = $request->input('tickets');
            if (!$tickets || empty($tickets)) {
                return response()->json(['error' => 'Keine Tickets zum Verarbeiten bereitgestellt'], 400);
            }

            $response = $this->openAiService->getResponse($tickets);
            return response()->json([
                'success' => true,
                'response' => $response
            ]);
        } catch (\Exception $e) {
            Log::error('Fehler bei der OpenAI-Anfrage: ' . $e->getMessage());
            return response()->json([
                'error' => 'Fehler bei der OpenAI-Anfrage: ' . $e->getMessage()
            ], 500);
        }
    }
}