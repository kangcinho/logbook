<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
          'username' => 'it',
          'password' => bcrypt('it'),
          'name' => 'Super Admin'
        ]);
    }
}
