<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\State;

class State extends Model
{
    public function states(){
        return $this->hasMany(City::class,'state_id','id');
    }
}
