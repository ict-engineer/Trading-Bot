<?php

namespace App;
use App\Models\Country;
use App\Models\States;
use App\Models\Membership;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = "users";


    // protected $fillable = [
    //     'name', 'email', 'password','phone_number', 'favorite_member', 'country', 'city'
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getCountryName(){
        return Country::find($this->country)->name;
    }

    public function getStatesName(){
        return States::find($this->city)->name;
    }

    public function getMembership(){
        return Membership::find($this->subscribtion_preference)->name;
    }
}
