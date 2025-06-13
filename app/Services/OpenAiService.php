<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;

class OpenAiService
{
    public function getResponse(array $tickets): string
    {
        try {
            // برومبت شامل واحترافي
            $prompt = <<<PROMPT
Du bist ein KI-basierter IT-Support-Analyst. 
Analysiere die folgenden Support-Tickets aus dem Do-IT-System, fasse ähnliche Anfragen zusammen, 
bewerte ihre Wichtigkeit (hoch, mittel, niedrig), und schlage für jede Ticketgruppe eine mögliche Lösung vor.

Format:
- Zusammenfassung der Tickets
- Priorität: Hoch/Mittel/Niedrig
- Lösungsvorschlag

Tickets:
[TICKET_DATEN]

Antwort:
PROMPT;

            $ticketsInfo = '';
            foreach ($tickets as $t) {
                $ticketsInfo .= "- Betreff: {$t['title']}, Beschreibung: {$t['description']}\n";
            }
            $prompt = str_replace('[TICKET_DATEN]', $ticketsInfo, $prompt);

            $response = OpenAI::chat()->create([
                'model' => config('openai.model', 'gpt-4o-2024-05-13', 'gpt-3.5-turbo'),
                'messages' => [
                    ['role' => 'system', 'content' => 'Du bist ein hilfsbereiter Assistent.'],
                    ['role' => 'user', 'content' => $prompt]
                ]
            ]);

            return $response->choices[0]->message->content ?? 'Keine Antwort erhalten.';
        } catch (\Exception $e) {
            Log::error('Fehler bei OpenAI:', ['message' => $e->getMessage()]);
            return 'Fehler bei der KI-Antwort.';
        }
    }



    public function generateAnswer(string $description): string
    {
        try {
            $prompt = <<<PROMPT
Du bist ein KI-basierter IT-Support-Analyst.
Analysiere das folgende Support-Ticket, bewerte die Wichtigkeit (hoch/mittel/niedrig), und gib einen Lösungsvorschlag:

Beschreibung:
{$description}

Antwort:
PROMPT;

            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-2024-05-13',
                'messages' => [
                    ['role' => 'system', 'content' => 'Du bist ein hilfsbereiter Assistent.'],
                    ['role' => 'user', 'content' => $prompt]
                ]
            ]);

            return $response->choices[0]->message->content ?? 'Keine Antwort erhalten.';
        } catch (\Exception $e) {
            Log::error('Fehler bei OpenAI:', ['message' => $e->getMessage()]);
            return 'Fehler bei der KI-Antwort.';
        }
    }
}