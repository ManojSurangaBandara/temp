<?php

namespace App\Models;

use App\Models\Bank;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingRefund extends Model
{
    use HasFactory;

    protected $table = 'booking_refunds';
    protected $fillable = [
        'bank_id',
        'branch',
        'acc_no',
        'acc_owner',
        'deposit_date',
        'cheque_no',
        'filepath',
        'booking_id',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

}
