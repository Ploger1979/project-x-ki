<?php
// app/Services/FetchCompanyService.php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchCompanyService
{
    protected $accessTokenService;

    public function __construct(AccessTokenService $accessTokenService)
    {
        $this->accessTokenService = $accessTokenService;
    }

    public function getCompanyByCustomerId($customerId)
    {
        try {
            $accessToken = $this->accessTokenService->getAccessToken();

            // Using the API to fetch customer data instead of the database
            $response = Http::withToken($accessToken)->get(config('enodia.customer-source-url'), [
                'id' => $customerId,
            ]);

            if ($response->successful()) {
                $companyData = $response->json();
                return $companyData[0] ?? []; // Return the first result or an empty array if none found
            }

            Log::error('Failed to fetch company data from API', ['response' => $response->body()]);
            return [];
        } catch (\Exception $e) {
            Log::error('Error in FetchCompanyService', ['message' => $e->getMessage()]);
            return [];
        }
    }
}
