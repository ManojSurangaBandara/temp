<?php

namespace App\Models;

use App\Models\Bungalow;
use App\Models\BookingGuest;
use App\Models\BookingRefund;
use App\Models\BookingApprove;
use App\Models\BookingVehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $fillable = [
        'regiment',
        'unit',
        'svc_no',
        'name',
        'nic',
        'contact_no',
        'army_id',
        'bungalow_id',
        'cancelremark_id',
        'type',
        'save',
        'level',
        'check_in',
        'check_out',
        'bank_id',
        'acc_no',
        'paid_amount',
        'no_of_days',
        'sms_delivery_status',
        'sms_delivery_date_time',
        'cancel_sms_delivery_status',
        'cancel_msg_date_time',
        'confirm_msg_contain',
        'cancel_msg_contain',
        'eno',
        'rank',
        'filpath',
        'cancel_time',
        'cancel',
        'cancel_user_id',
        'refund',
        'refund_time',
        'refund_user_id',
        'refund_recieve',
        'refund_recieve_time',
        'approve',
    ];

    public function bookingguests()
    {
        return $this->hasMany(BookingGuest::class);
    }

    public function bookingvehicles()
    {
        return $this->hasMany(BookingVehicle::class);
    }

    public function bungalow()
    {
        return $this->belongsTo(Bungalow::class, 'bungalow_id', 'id');
    }

    public function refund()
    {
        return $this->hasOne(BookingRefund::class);
    }

    public function approve()
    {
        return $this->hasOne(BookingApprove::class);
    }
}
