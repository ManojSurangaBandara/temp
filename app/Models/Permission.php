<?php

namespace App\Models;

use App\Models\PermissionCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';
    protected $fillable = [
        'name',
        'visible_name',
        'permission_category_id',
        'status',        
    ];

    public function permission_category()
    {
        return $this->belongsTo(PermissionCategory::class, 'permission_category_id', 'id');
    }
}
