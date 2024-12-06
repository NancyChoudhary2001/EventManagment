<?php

namespace App\Models;

use App\Models\Passwordreset;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'password',
        'address',
        'country',
        'state',
        'city',
        'pincode',
        'branch_id',
        'profile_picture',
        'role',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function passwordreset(){
        return $this->hasOne(Passwordreset::class, 'user_id','id');
    }
    public function setting()
    {
        return $this->hasOne(Setting::class, 'user_id','id'); 
    }
    public function branch()
{
    return $this->belongsTo(Branch::class, 'branch_id' );
}
public function country()
    {
        return $this->belongsTo(Country::class, 'country', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city', 'id');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'items', 'user_id', 'event_id')
                    ->withTimestamps();
    }

}


