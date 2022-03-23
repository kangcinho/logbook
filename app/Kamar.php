<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table = 'kamar';
    protected $guarded = ['id'];

    // public function no_kamar()
    // {
    //   return $this->hasManyThrough('App\Nokamar','App\Logbook','id_kamar','id_no_kamar','id','id');
    // }
    public function no_kamar()
    {
      return $this->hasMany('App\Nokamar','id_kamar');
    }

}
