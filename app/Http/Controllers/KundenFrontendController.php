<?php

namespace App\Http\Controllers;

use App\Models\Kunde;
use Inertia\Inertia;

class KundenFrontendController extends Controller
{
    public function list()
    {
        $kunden = Kunde::all();
        return Inertia::render('Kunden/List', [
            'kunden' => $kunden
        ]);
    }
}