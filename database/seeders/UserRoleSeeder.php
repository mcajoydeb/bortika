<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('model_has_roles')->truncate();

        foreach (User::all() as $sl => $user) {
            DB::table('model_has_roles')->insert([
                'role_id' => $sl == 0 ? 1 : 2,
                'model_type' => 'App\Models\User',
                'model_id' => $user->id,
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
