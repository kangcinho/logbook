<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
  protected $table = 'logbook';
  protected $guarded = ['id'];

  public function nokamar()
  {
    return $this->belongsTo('App\Nokamar','id_no_kamar');
  }

  public function paket()
  {
    return $this->belongsTo('App\Paket','id_paket_kamar');
  }

  public function pasien()
  {
    return $this->belongsTo('App\Pasien','id_pasien');
  }
}
