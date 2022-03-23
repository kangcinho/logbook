<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
  protected $table = 'paket';
  protected $guarded = ['id'];

  public function logbook()
  {
    return $this->hasMany('App\Logbook');
  }
}
