<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Rank;
use App\Models\Location;
use App\Models\Regiment;
use App\Models\Directorate;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',       
        'rank_id',
        'status',
        'svc_no',
        'regiment_id',
        'mobile_no',
        'last_login_date',
        'last_login_ip',
        'directorate_id',
        'rank_id',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // public function regiment()
    // {
    //     return $this->hasOne(Location::class, 'id', 'regiment_id');
    // }

    // public function location()
    // {
    //     return $this->hasOne(Location::class, 'id', 'location_id');
    // }

    public function regiment()
    {
        return $this->hasOne(Regiment::class, 'id', 'regiment_id');
    }

    public function directorate()
    {
        return $this->hasOne(Directorate::class, 'id', 'directorate_id');
    }

    public function rank()
    {
        return $this->hasOne(Rank::class, 'id', 'rank_id');
    }
    
}
