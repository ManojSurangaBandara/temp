<?php

namespace App\Models;

use App\Models\Regiment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'units';
    protected $fillable = [
        'name',
        'status',
        'regiment_id'
    ];

    public function regiment()
    {
        return $this->belongsTo(Regiment::class, 'regiment_id', 'id');
    }
}
