<?php

namespace App\Http\Controllers;

use App\Models\Meni;

class MeniController extends Controller
{
    public function dohvatiMeni()
    {
        $meni = Meni::all();

        return response()->json([
            'meni' => $meni
        ]);
    }
}
