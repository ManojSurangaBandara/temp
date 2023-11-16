<?php

namespace App\Models;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingGuest extends Model
{
    use HasFactory;

    protected $table = 'booking_guests';
    protected $fillable = [
        'booking_id',
        'name',
        'nic',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    // public function booking()
    // {
    //     return $this->belongsTo(Booking::class);
    // }
}
