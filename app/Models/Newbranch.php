<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newbranch extends Model
{
    protected $fillable = [
        'name',
        'address',
        'country_id',
        'state_id',
        'city_id',
        'pincode',
    ];

    public $timestamps = false;
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    
    public function state()
    {
        return $this->belongsTo(State::class);
    }

   
    public function city()
    {
        return $this->belongsTo(City::class);
    }

}
