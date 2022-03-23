<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KlinikLaktasi extends Model
{
  protected $guarded = ['id'];
  protected $table = "kliniklaktasi";

  public function pasien(){
    return $this->belongsTo('App\Pasien','id_pasien');
  }
}
