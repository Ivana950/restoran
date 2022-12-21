<?php


namespace App\Models;

use App\Enums\StatusStola;
use App\Models\Rezervacija;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stol extends Model
{
  use SoftDeletes;
  protected $table = 'stolovi';

  protected $fillable = [
    'naziv', 'broj_gostiju', 'status'
  ];


  public function rezervacije()
  {
    return $this->hasMany(Rezervacija::class, 'stol_id');
  }
}
