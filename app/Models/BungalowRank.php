<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BungalowRank extends Pivot
{
    use HasFactory;

    protected $table = 'bungalow_ranks';
    protected $fillable = [
        'bungalow_id',
        'rank_id',
    ];
}
