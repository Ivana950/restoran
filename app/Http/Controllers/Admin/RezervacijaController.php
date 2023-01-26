<?php

namespace App\Http\Controllers\Admin;

use App\Models\Stol;
use App\Models\Rezervacija;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RezervacijaRequest;

class RezervacijaController extends Controller
{
    public function rezervacije()
    {
        return view('admin.rezervacije');
    }

    public function novaRezervacija()
    {
        return view('admin.dodajRezervaciju');
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

    public function urediRezervaciju(RezervacijaRequest $request, $id)
    {
        $validetedData = $request->validated();

        $rezervacija = Rezervacija::find($id);
        $rezervacija->ime = $request->ime;
        $rezervacija->prezime = $request->prezime;
        $rezervacija->email = $request->email;
        $rezervacija->broj_telefona = $request->broj_telefona;
        $rezervacija->datum_rezervacije = $request->datum_rezervacije;
        $rezervacija->broj_gostiju = $request->broj_gostiju;
        $rezervacija->stol_id = $request->stol_id;
        $rezervacija->save();

        $rezervacija->save($validetedData);

        $stol = Stol::findOrFail($request->stol_id);
        $stol->status = 'Nedostupan';
        $stol->save();
    }

    public function izbrisiRezervaciju(Request $request, $id)
    {

        $rezervacija = Rezervacija::find($id);

        $stol = Stol::findOrFail($request->stol_id);
        $stol->status = 'Dostupan';

        $stol->save();

        $rezervacija->delete();
    }
}
