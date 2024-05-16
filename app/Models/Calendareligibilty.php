<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendareligibilty extends Model
{
    use HasFactory;

    protected $table = 'calendareligibilty';
    protected $fillable = [
        'id',
        'no_of_days',
        'active',
        'created_at',
        'updated_at',
    ];
}
