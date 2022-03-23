<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upadana extends Model
{
  protected $guarded = ['id'];
  protected $table = "upadana";

  public function pasien(){
    return $this->belongsTo('App\Pasien','id_pasien');
  }
}
