<?php

namespace App\Models;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingApprove extends Model
{
    use HasFactory;

    protected $table = 'booking_approves';
    protected $fillable = [
        'user_id',
        'booking_id',
        'approve_date',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
