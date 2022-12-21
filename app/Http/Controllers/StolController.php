<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Stol;


class StolController extends Controller
{
    public function dohvatiStolove()
    {
        $stolovi = Stol::all();

        return response()->json([
            'stolovi' => $stolovi
        ]);
    }

    public function index()
    {
        return view('stolovi');
    }

    public function dodajStol()
    {
        return view('stolovi.dodaj');
    }

    public function urediStol()
    {
        return view('stolovi.uredi');
    }

    public function dodaj(Request $request)
    {
        $stol = new Stol();
        $stol->naziv = $request->naziv;
        $stol->broj_gostiju = $request->broj_gostiju;
        $stol->status = $request->status;
        $stol->save();

        //return redirect(route('admin.okvir'));
    }

    public function uredi(Request $request, $id)
    {
        $stol = Stol::find($id);
        $stol->naziv = $request->naziv;
        $stol->broj_gostiju = $request->broj_gostiju;
        $stol->status = $request->status;
        $stol->save();

        //return redirect(route('admin.okvir'));
    }
}
