<?php

namespace App\Http\Controllers;

use App\Models\Meni;

class MeniController extends Controller
{
    public function dohvatiMeni()
    {
        $meni = Meni::orderBy('created_at', 'DESC')->get();
        return response()->json([
            'meni' => $meni
        ]);
    }
}
