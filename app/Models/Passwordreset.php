<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Passwordreset extends Model
{
    protected $fillable = [ 
        'user_id',
        'otp',
        'expiry_time',
    ];

    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
