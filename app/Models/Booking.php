<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];
}
