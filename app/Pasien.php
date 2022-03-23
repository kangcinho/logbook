<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
  protected $table = 'pasien';
  protected $guarded = ['id'];

  public function logbook()
  {
    return $this->hasMany('App\Logbook');
  }

  public function upadana(){
    return $this->hasMany('App\Upadana');
  }

  public function babySPA(){
    return $this->hasMany('App\BabySPA');
  }

  public function klinikLaktasi(){
    return $this->hasMany('App\KlinikLaktasi');
  }

  public function radiologi(){
    return $this->hasMany('App\Radiologi');
  }

  public function echnocardiography(){
    return $this->hasMany('App\Ecnocardiography');
  }

}
