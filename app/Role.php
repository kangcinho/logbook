<?php

namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $guarded = ['id'];

    public function permission(){
      return $this->belongsToMany('App\Permission');
    }
}
