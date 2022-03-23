<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
          [
            'name' => 'superadmin',
            'display_name' => 'Super Admin',
            'description' => 'Super Admin',
            'created_at' => now(),
            'updated_at' => now()
          ],
          [
            'name' => 'menu_babyspa',
            'display_name' => 'Menu Baby Spa',
            'description' => 'Akses Menuju Menu Baby SPA',
            'created_at' => now(),
            'updated_at' => now()
          ],
          [
            'name' => 'menu_logbook',
            'display_name' => 'Menu Logbook',
            'description' => 'Akses ke Menu Logbook',
            'created_at' => now(),
            'updated_at' => now()
          ],
          [
            'name' => 'menu_kliniklaktasi',
            'display_name' => 'Menu Klinik Laktasi',
            'description' => 'Akses Ke Menu Laktasi',
            'created_at' => now(),
            'updated_at' => now()
          ],
          [
            'name' => 'menu_radiologi',
            'display_name' => 'Menu Radiologi',
            'description' => 'Akses Ke Menu Radiologi',
            'created_at' => now(),
            'updated_at' => now()
          ],
          [
            'name' => 'menu_echocardiography',
            'display_name' => 'Menu Echocardiography',
            'description' => 'Akses Menu Echocardiography',
            'created_at' => now(),
            'updated_at' => now()
          ],
          [
            'name' => 'menu_upadana',
            'display_name' => 'Menu Upadana',
            'description' => 'Akses Menu Upadana',
            'created_at' => now(),
            'updated_at' => now()
          ],
          [
            'name' => 'menu_master',
            'display_name' => 'Menu Master',
            'description' => 'Akses Ke menu master',
            'created_at' => now(),
            'updated_at' => now()
          ],
          [
            'name' => 'menu_penomoran',
            'display_name' => 'Menu Penomoran',
            'description' => 'Akses Ke menu penomoran',
            'created_at' => now(),
            'updated_at' => now()
          ]
        ]);
    }
}
