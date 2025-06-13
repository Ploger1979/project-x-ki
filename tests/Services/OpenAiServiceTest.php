<?php

namespace Tests\Services;

use App\Services\OpenAiService;
use Tests\TestCase;

class OpenAiServiceTest extends TestCase
{
    /**
     * Test the `getResponse` method with properly structured minimal data.
     */
    public function testGetResponseWithMinimalData(): void
    {
        // Minimal array structure matching expected ticket data format
        $tickets = [
            [
                'betreff' => 'Test Ticket',
                'beschreibung' => 'A simple description for testing.'
            ]
        ];

        $instruction = 'Please respond with "Pong."';

        // Expected response to mock OpenAI output
        $expectedResponse = 'Pong.';

        // Instantiate the OpenAiService and call getResponse
        $openAiService = new OpenAiService();
        $response = $openAiService->getResponse($tickets, $instruction);

        // Assert the response
        $this->assertSame($expectedResponse, $response, 'The response should be "pong".');
    }
}

