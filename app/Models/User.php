<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Rank;
use App\Models\Forces;
use App\Models\Usertype;
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
        'location_id'
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

    public function force()
    {
        return $this->belongsTo(Forces::class, 'force_id', 'id');
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class, 'rank_id', 'id');
    }

    public function usertype()
    {
        return $this->belongsTo(Usertype::class, 'user_type_id', 'id');
    }
    
}
