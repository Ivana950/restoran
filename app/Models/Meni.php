<?php


namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meni extends Model
{
  use SoftDeletes;
  protected $table = 'meni';

  protected $fillable = [
    'naziv', 'opis', 'slika', 'cijena'
  ];
}
