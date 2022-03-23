<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use App\Permission;
class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $admin = User::where('username', 'it')->firstOrFail();
      $role = Role::where('name', 'superadmin')->firstOrFail();
      $permission = Permission::all();
      $admin->roles()->sync($role->id);
      $role->permission()->sync($permission);
    }
}
