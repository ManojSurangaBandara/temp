<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class PermissionCategory extends Model
{
    use HasFactory;
    protected $table = 'permission_categories';
    protected $fillable = [
        'name',
        'status',
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'permission_category_id');
    }
}
