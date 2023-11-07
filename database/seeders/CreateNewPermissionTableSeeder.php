<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CreateNewPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'so-action-pending-list',
            'permission-category-list',
            'permission-category-create',
            'permission-category-edit',
            'permission-category-delete',
        ];
      
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
