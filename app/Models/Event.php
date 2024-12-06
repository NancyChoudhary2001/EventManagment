<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Currency;

class Event extends Model
{
    protected $fillable =[
        'name',
        'description',
        'role',
        'currency_id',
        'price',
        'image',

    ];
    public $timestamps = false;
    public function currency()
{
    return $this->belongsTo(Currency::class, 'currency_id', 'id');
}
public function buyers()
{
    return $this->belongsToMany(User::class, 'items');
}

}
