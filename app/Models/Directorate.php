<?php

namespace App\Models;

use App\Models\Bungalow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Directorate extends Model
{
    use HasFactory;

    protected $table = 'directorates';
    protected $fillable = [
        'name',
        'status',
    ];

    public function bungalows()
    {
        return $this->hasMany(Bungalow::class,'directorate_id');
    }
    
}
