<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;


class City extends Model
{
    public function branch(){
        return $this->hasMany(Branch::class,'city_id','id');
    }
}
