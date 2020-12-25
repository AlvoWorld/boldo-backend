<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Ryan",
            'email' => "boldo@boldo.com",
            'role' => 2,
            'active' => true,
            'password' => bcrypt('goodman'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('types')->insert([
           ['name' => "Chef", 'sort' => 0, 'created_at' => now(), 'updated_at' => now()],
           ['name' => "Pastry Chef", 'sort' => 1, 'created_at' => now(), 'updated_at' => now()],
           ['name' => "Baker", 'sort' => 2, 'created_at' => now(), 'updated_at' => now()],
           ['name' => "Caterer", 'sort' => 3, 'created_at' => now(), 'updated_at' => now()],
           ['name' => "Bartender", 'sort' => 4, 'created_at' => now(), 'updated_at' => now()],
           ['name' => "Mixologist", 'sort' => 5, 'created_at' => now(), 'updated_at' => now()],
           ['name' => "Sommelier", 'sort' => 6, 'created_at' => now(), 'updated_at' => now()],
           ['name' => "Wait Staff", 'sort' => 7, 'created_at' => now(),'updated_at' => now()],
        ]);
    }
}
