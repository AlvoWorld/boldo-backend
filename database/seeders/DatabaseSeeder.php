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
            'fname' => "Ryan",
            'lname' => "",
            'email' => "boldo@boldo.com",
            'role' => 2,
            'active' => true,
            'password' => bcrypt('goodman'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('types')->insert([
           ['name' => "Chef", 'sort' => 0, 'style' =>true, 'created_at' => now(), 'updated_at' => now()],
           ['name' => "Pastry Chef", 'sort' => 1, 'style' =>false, 'created_at' => now(), 'updated_at' => now()],
           ['name' => "Baker", 'sort' => 2,  'style' =>false, 'created_at' => now(), 'updated_at' => now()],
           ['name' => "Caterer", 'sort' => 3, 'style' =>true, 'created_at' => now(), 'updated_at' => now()],
           ['name' => "Bartender", 'sort' => 4, 'style' =>false, 'created_at' => now(), 'updated_at' => now()],
           ['name' => "Mixologist", 'sort' => 5, 'style' =>false, 'created_at' => now(), 'updated_at' => now()],
           ['name' => "Sommelier", 'sort' => 6, 'style' =>false, 'created_at' => now(), 'updated_at' => now()],
           ['name' => "Wait Staff", 'sort' => 7, 'style' =>false, 'created_at' => now(),'updated_at' => now()],
        ]);

        DB::table('styles')->insert([
            ['name' => "American", 'sort' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Asian Fusion", 'sort' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Cajun", 'sort' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Canadian", 'sort' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Carribean", 'sort' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Chinese", 'sort' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['name' => "European", 'sort' => 7, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Filipino", 'sort' => 8, 'created_at' => now(),'updated_at' => now()],
            ['name' => "French", 'sort' => 9, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Fusion", 'sort' => 10, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Greek", 'sort' => 11, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Hungarian", 'sort' => 12, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Indian", 'sort' => 13, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Italian", 'sort' => 14, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Jamaican", 'sort' => 15, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Japanese", 'sort' => 16, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Kosher", 'sort' => 17, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Korean", 'sort' => 18, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Mediterranean", 'sort' => 19, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Mexican", 'sort' => 20, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Middle Eastern", 'sort' => 21, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Modern", 'sort' => 22, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Russian", 'sort' => 23, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Spanish", 'sort' => 24, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Swedish", 'sort' => 25, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Thai", 'sort' => 26, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Turkish", 'sort' => 27, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Vegan", 'sort' => 28, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Vegetarian", 'sort' => 29, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Vietnamese", 'sort' => 30, 'created_at' => now(),'updated_at' => now()],
            ['name' => "Other", 'sort' => 31, 'created_at' => now(),'updated_at' => now()],
         ]);
    }
}
