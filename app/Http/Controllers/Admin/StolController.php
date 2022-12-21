<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stol;
use Illuminate\Http\Request;

class StolController extends Controller
{
    public function stolovi()
    {
        return view('admin.stolovi');
    }

    public function noviStol()
    {
        return view('admin.dodajStol');
    }

    public function dodajStol(Request $request)
    {
        $stol = new Stol();
        $stol->naziv = $request->naziv;
        $stol->broj_gostiju = $request->broj_gostiju;
        $stol->status = $request->status;
        $stol->save();
    }

    public function urediStol(Request $request, $id)
    {
        $stol = Stol::find($id);
        $stol->naziv = $request->naziv;
        $stol->broj_gostiju = $request->broj_gostiju;
        $stol->status = $request->status;
        $stol->save();

        return $stol;
    }

    public function izbrisiStol($id)
    {
        $stol = Stol::find($id);
        $stol->delete();
    }
}
