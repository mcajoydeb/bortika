<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Role::truncate();

        foreach (config('roles') as $data) {
            Role::create(['name' => $data['name']]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
