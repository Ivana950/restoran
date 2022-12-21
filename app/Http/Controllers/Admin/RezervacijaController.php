<?php

namespace App\Http\Controllers\Admin;


use App\Models\Stol;
use App\Models\Rezervacija;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


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

    public function dodajRezervaciju(Request $request)
    {
        /* $stol = Stol::findOrFail($request->stol_id);
        if ($request->broj_gostiju > $stol->broj_gostiju) {
            return back()->with('warning', 'Ovaj stol nema toliko sjedećih mjesta');
        }*/

        $rezervacija = new Rezervacija();
        $rezervacija->ime = $request->ime;
        $rezervacija->prezime = $request->prezime;
        $rezervacija->email = $request->email;
        $rezervacija->broj_telefona = $request->broj_telefona;
        $rezervacija->datum_rezervacije = $request->datum_rezervacije;
        $rezervacija->broj_gostiju = $request->broj_gostiju;
        $rezervacija->stol_id = $request->stol;

        $rezervacija->save();
    }

    public function urediRezervaciju(Request $request, $id)
    {
        $rezervacija = Rezervacija::find($id);
        $rezervacija->ime = $request->ime;
        $rezervacija->prezime = $request->prezime;
        $rezervacija->email = $request->email;
        $rezervacija->broj_telefona = $request->broj_telefona;
        $rezervacija->datum_rezervacije = $request->datum_rezervacije;
        $rezervacija->broj_gostiju = $request->broj_gostiju;
        $rezervacija->stol_id = $request->stol;
        $rezervacija->save();

        return $rezervacija;
    }

    public function izbrisiRezervaciju($id)
    {
        $rezervacija = Rezervacija::find($id);
        $rezervacija->delete();
    }
}