<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
          [
            'name' => 'create',
            'display_name' => 'Create Data',
            'description' => 'Ijin Untuk Menambahkan Data'
          ],
          [
            'name' => 'update',
            'display_name' => 'Update Data',
            'description' => 'Ijin Untuk Mengubah Data'
          ],
          [
            'name' => 'delete',
            'display_name' => 'Delete Data',
            'description' => 'Ijin Untuk Menghapus Data'
          ],
          [
            'name' => 'report',
            'display_name' => 'Report Data',
            'description' => 'Ijin untuk Mengambil Report Data'
          ]
        ]);
    }
}
