<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userlog extends Model
{
    protected $guarded = ['id'];
    protected $table = 'userlogs';
}
