<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Radiologi extends Model
{
  protected $guarded = ['id'];
  protected $table = "radiologi";

  public function pasien(){
    return $this->belongsTo('App\Pasien','id_pasien');
  }
}
