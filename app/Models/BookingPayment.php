<?php

namespace App\Models;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingPayment extends Model
{
    use HasFactory;

    protected $table = 'booking_payment';
    protected $fillable = [
        'id',
        'reason_code',
        'reference_number',
        'auth_trans_ref_no',
        'amount',
        'decision',
        'message',
	'transaction_id',
        'booking_id',
        'created_at',
        'updated_at',
    ];

    public function bookingpaymens()
    {
        return $this->hasMany(Booking::class, 'booking_id', 'id');
    }

}
