<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kunde;
use Illuminate\Http\Request;

class KundenController extends Controller
{
    public function index()
    {
        $kunden = Kunde::all();
        return response()->json(['kunden' => $kunden]);
    }
}