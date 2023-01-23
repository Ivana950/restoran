<?php

namespace App\Http\Controllers\Admin;

use App\Models\Meni;
use Illuminate\Http\Request;
use App\Http\Requests\MeniRequest;
use App\Http\Controllers\Controller;
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

    public function dodajMeni(MeniRequest $request)
    {
        $validatedData = $request->validated();


        if ($request->slika) {
            $slika = time() . '.' . explode('/', explode(':', substr($request->slika, 0, strpos($request->slika, ';')))[1])[1];

            Image::make($request->slika)->save(public_path('images/' . $slika));
        } else {
            $slika = null;
        }

        $meni = new Meni();
        $meni->naziv = $request->naziv;
        $meni->opis = $request->opis;
        $meni->cijena = $request->cijena;
        $meni->slika = $slika;
        $meni->save($validatedData);
    }

    public function urediMeni(MeniRequest $request, $id)
    {

        $validatedData = $request->validated();

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
        $meni->save($validatedData);

        return $meni;
    }

    public function izbrisiMeni($id)
    {
        $meni = Meni::findOrFail($id);
        unlink(public_path('images/' . $meni->slika));
        Meni::where('id', $id)->delete();
    }
}
