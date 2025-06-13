<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\KundenController;
use App\Http\Controllers\Api\OpenAiApiController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\SettingsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| هنا كلّ الـ API اللّي بيقدّم JSON (قاعدة بيانات التذاكر، OpenAI، أو بيانات العملاء)
|
*/

// ====== 1. تذاكر – CRUD / Search / Fetch عبر خدمات خارجية / OpenAI ======

// - GET /api/tickets           → قائمة همه (Ticket::all())
// - GET /api/tickets/search    → البحث عن تذاكر (مع باراميتر query و customer_id)
// - POST /api/tickets/fetch    → يجلب التذاكر من API خارجي (بتاريخ وزمن وcustomerId)
// - POST /api/tickets/generate-answer → يبعث للأوبن إيه آي ويرجع إجابة

Route::prefix('tickets')->group(function () {
    Route::get('/', [TicketController::class, 'index']);
    Route::get('/search', [TicketController::class, 'search']);
    Route::post('/fetch', [TicketController::class, 'fetchTickets']);
    Route::post('/generate-answer', [TicketController::class, 'generateAnswer']);
});



// ====== 2. OpenAI API (لو في حاجة مستقلة) ======
Route::post('/openai/process-tickets', [OpenAiApiController::class, 'getOpenAIResponse']);

// ====== 3. بيانات العملاء (Contacts) ======
Route::get('/contacts', [ContactController::class, 'index']);

Route::get('/kunden', [KundenController::class, 'index']);


// ====== API Endpunkte für Einstellungen ======
Route::get('/settings/model', [SettingsController::class, 'getModel']);
Route::post('/settings/clear-cache', [SettingsController::class, 'clearCache']);
Route::post('/settings/test-connection', [SettingsController::class, 'testConnection']);