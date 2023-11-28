<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelRemark extends Model
{
    use HasFactory;

    protected $table = 'cancel_remarks';
    protected $fillable = [
        'name',
        'status',
    ];
}
