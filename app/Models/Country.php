<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\State;

class Country extends Model
{
    public function states(){
        return $this->hasMany(State::class,'country_id','id');
    }
}
