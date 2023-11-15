<?php

namespace App\Models;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingVehicle extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $fillable = [
        'booking_id',
        'reg_no'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }
}
