<?php

namespace App\Http\Controllers\User;

use App\Models\Stol;
use App\Models\Rezervacija;
use App\Http\Controllers\Controller;
use App\Http\Requests\RezervacijaRequest;

class RezervacijaController extends Controller
{
    public function index()
    {
        return view('user.rezervacija');
    }

    public function dodajRezervaciju(RezervacijaRequest $request)
    {
        $validetedData = $request->validated();

        $rezervacija = new Rezervacija();
        $rezervacija->ime = $request->ime;
        $rezervacija->prezime = $request->prezime;
        $rezervacija->email = $request->email;
        $rezervacija->broj_telefona = $request->broj_telefona;
        $rezervacija->datum_rezervacije = $request->datum_rezervacije;
        $rezervacija->broj_gostiju = $request->broj_gostiju;
        $rezervacija->stol_id = $request->stol_id;

        $rezervacija->save($validetedData);

        $stol = Stol::findOrFail($request->stol_id);
        $stol->status = 'Nedostupan';
        $stol->save();
    }
}
