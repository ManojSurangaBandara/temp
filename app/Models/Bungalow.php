<?php

namespace App\Models;

use App\Models\Rank;
use App\Models\BungalowRank;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bungalow extends Model
{
    use HasFactory;

    protected $table = 'bungalows';
    protected $fillable = [
        'name',
        'status',
        'no_ac_room',
        'no_none_ac_room',
        'no_guest',
        'serving_price',
        'retired_price',
        'official_price',
        'directorate_id',
        'location',
    ];

    public function ranks()
    {
        return $this->belongsToMany(Rank::class, 'bungalow_ranks')
            ->using(BungalowRank::class); // Using the custom pivot model
    }


}
