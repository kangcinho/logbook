<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BabySPA extends Model
{
    protected $guarded = ['id'];
    protected $table = "babyspa";

    public function pasien(){
      return $this->belongsTo('App\Pasien','id_pasien');
    }
}
