<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nokamar extends Model
{
  protected $table = 'no_kamar';
  protected $guarded = ['id'];

  public function kamar()
  {
    return $this->belongsTo('App\Kamar', 'id_kamar');
  }

  public function logbook()
  {
    return $this->hasMany('App\Logbook');
  }

}
