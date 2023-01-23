<?php

namespace App\Http\Controllers\Admin;

use App\Models\Stol;
use Illuminate\Http\Request;
use App\Http\Requests\StolRequest;
use App\Http\Controllers\Controller;

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

    public function dodajStol(StolRequest $request)
    {
        $validetedData = $request->validated();

        $stol = new Stol();
        $stol->naziv = $request->naziv;
        $stol->broj_gostiju = $request->broj_gostiju;
        $stol->status = $request->status;
        $stol->save($validetedData);
    }

    public function urediStol(StolRequest $request, $id)
    {
        $validetedData = $request->validated();

        $stol = Stol::find($id);
        $stol->naziv = $request->naziv;
        $stol->broj_gostiju = $request->broj_gostiju;
        $stol->status = $request->status;
        $stol->save($validetedData);

        return $stol;
    }

    public function izbrisiStol($id)
    {
        $stol = Stol::find($id);
        $stol->delete();
        $stol->rezervacije()->delete();
    }
}
