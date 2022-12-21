<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meni;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class MeniController extends Controller
{
    public function meni()
    {
        return view('admin.meni');
    }

    public function noviMeni()
    {
        return view('admin.dodajMeni');
    }

    public function dodajMeni(Request $request)
    {
        /* $this->validate($request, [
            'slika' => 'required|image|mimes:jpeg,png,jpg,svg'
        ]);*/
        if ($request->slika) {
            $slika = time() . '.' . explode('/', explode(':', substr($request->slika, 0, strpos($request->slika, ';')))[1])[1];

            Image::make($request->slika)->save(public_path('images/' . $slika));
        } else {
            $slika = null;
        }

        Meni::create([
            'naziv' => $request->naziv,
            'opis' => $request->opis,
            'cijena' => $request->cijena,
            'slika' => $slika,
        ]);
        /*$meni = new Meni();
        $meni->naziv = $request->naziv;
        $meni->opis = $request->opis;
        $meni->cijena = $request->cijena;
        $slika->slika = $slika;
        $meni->save();*/
    }

    public function urediMeni(Request $request, $id)
    {
        $meni = Meni::findOrFail($id);

        if ($request->slika) {
            if ($meni->slika) {
                unlink(public_path('images/' . $meni->slika));
            }
            $slika = time() . '.' . explode('/', explode(':', substr($request->slika, 0, strpos($request->slika, ';')))[1])[1];

            Image::make($request->slika)->save(public_path('images/' . $slika));
        } else {
            $slika = $meni->slika;
        }

        $meni = Meni::find($id);
        $meni->naziv = $request->naziv;
        $meni->opis = $request->opis;
        $meni->cijena = $request->cijena;
        $meni->slika = $slika;
        $meni->save();

        return $meni;
    }

    public function izbrisiMeni($id)
    {
        $meni = Meni::findOrFail($id);
        unlink(public_path('images/' . $meni->slika));
        Meni::where('id', $id)->delete();
    }
}
