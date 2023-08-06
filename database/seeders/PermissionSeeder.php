<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Permission::truncate();

        foreach (config('permissions-list') as $permission) {
            Permission::create(['name' => $permission]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
