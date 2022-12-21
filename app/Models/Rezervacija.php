<?php


namespace App\Models;

use App\Models\Stol;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rezervacija extends Model
{
  use SoftDeletes;
  protected $table = 'rezervacije';

  protected $fillable = [
    'ime', 'prezime', 'email', 'broj_telefona', 'datum_rezervacije', 'broj_gostiju', 'stol_id'
  ];

  public function stol()
  {
    return $this->belongsTo(Stol::class, 'stol_id');
  }
}
