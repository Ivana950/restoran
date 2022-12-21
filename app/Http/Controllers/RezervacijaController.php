<?php

namespace App\Http\Controllers;

use App\Models\Rezervacija;


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
