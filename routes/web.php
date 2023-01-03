<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.', 'middleware' => ['isAdmin']], function () {

    Route::get('/', 'AdminController@index')->name('index');

    // STOLOVI
    Route::get('/stolovi', 'StolController@stolovi')->name('stolovi.index');
    Route::get('/stolovi/dodaj', 'StolController@noviStol')->name('stolovi.dodaj');
    Route::post('/stolovi/dodaj', 'StolController@dodajStol')->name('stolovi.dodajStol');
    Route::post('/stolovi/uredi/{id}', 'StolController@urediStol')->name('stolovi.urediStol');
    Route::get('/stolovi/izbrisi/{id}', 'StolController@izbrisiStol')->name('stolovi.izbrisi');

    // MENI
    Route::get('/meni', 'MeniController@meni')->name('meni.index');
    Route::get('/meni/dodaj', 'MeniController@noviMeni')->name('meni.dodaj');
    Route::post('/meni/dodaj', 'MeniController@dodajMeni')->name('meni.dodajMeni');
    Route::post('/meni/uredi/{id}', 'MeniController@urediMeni')->name('meni.urediMeni');
    Route::get('/meni/izbrisi/{id}', 'MeniController@izbrisiMeni')->name('meni.izbrisi');

    // REZERVACIJE
    Route::get('/rezervacije', 'RezervacijaController@rezervacije')->name('rezervacije.index');
    Route::get('/rezervacije/dodaj', 'RezervacijaController@novaRezervacija')->name('rezervacije.dodaj');
    Route::post('/rezervacije/izbrisi/{id}', 'RezervacijaController@izbrisiRezervaciju')->name('rezervacije.izbrisi');
    Route::post('/rezervacije/uredi/{id}', 'RezervacijaController@urediRezervaciju')->name('rezervacije.urediRezervaciju');
    Route::post('/rezervacije/dodaj', 'RezervacijaController@dodajRezervaciju')->name('rezervacije.dodajRezervaciju');
});

Route::group(['prefix' => 'user', 'namespace' => 'User', 'as' => 'user.', 'middleware' => ['auth']], function () {
    Route::get('/', 'UserController@index')->name('index');
});

Route::get('/stolovi', 'StolController@dohvatiStolove');
Route::get('/slobodniStolovi', 'StolController@dohvatiSlobodneStolove');
Route::get('/meni', 'MeniController@dohvatiMeni');
Route::get('/rezervacije', 'RezervacijaController@dohvatiRezervacije');

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
