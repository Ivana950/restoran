<?php

namespace App\Http\Controllers;

use App\Models\Rezervacija;
use App\Models\Stol;

class RezervacijaController extends Controller
{
    public function dohvatiRezervacije()
    {
        $rezervacija = Rezervacija::with('stol')->get();

        return response()->json([
            'rezervacija' => $rezervacija
        ]);
    }
}
