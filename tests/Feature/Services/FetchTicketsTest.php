<?php

namespace Tests\Feature\Services;

use App\Services\AccessTokenService;
use App\Services\FetchTickets;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class FetchTicketsTest extends TestCase
{
    protected FetchTickets $fetchTickets;

    protected function setUp(): void
    {
        parent::setUp();

        // Initialize the real AccessTokenService to use a valid access token
        $accessTokenService = new AccessTokenService();
        $this->fetchTickets = new FetchTickets($accessTokenService);
    }

    public function testFetchTicketsForLastMonth(): void
    {
        // Define 'since' date for the last month
        $since = Carbon::now()->subMonth()->startOfDay()->format('Y-m-d H:i:s');

        // Measure request duration
        $startTime = microtime(true);

        // Attempt to fetch tickets for the last month
        $tickets = $this->fetchTickets->fetchTicketsFromDoit($since);

        $endTime = microtime(true);
        $duration = $endTime - $startTime;

        // Log or output the duration (optional)
        Log::info("Ticket fetch duration: {$duration} seconds");

        // Assert that we receive a JSON array response
        $this->assertIsArray($tickets, 'Expected the response to be a JSON array');
        $this->assertNotEmpty($tickets, 'Expected non-empty ticket data');

        // Display the duration for informational purposes in test output
        $this->assertTrue($duration > 0, "The request took {$duration} seconds to complete.");
    }
}
