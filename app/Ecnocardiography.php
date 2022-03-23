<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ecnocardiography extends Model
{
    protected $guarded = ['id'];
    protected $table = "ecnocardiography";

    public function pasien(){
      return $this->belongsTo('App\Pasien','id_pasien');
    }
}
