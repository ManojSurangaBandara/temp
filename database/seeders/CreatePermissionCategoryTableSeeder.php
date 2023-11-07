<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PermissionCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreatePermissionCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionCategories = [
            'Master Data',
            'System Management',
            'Person Management',
            'Card Issue'
        ];
      
        foreach ($permissionCategories as $permissionCategory) {
             PermissionCategory::create(['name' => $permissionCategory]);
        }
    }
}
