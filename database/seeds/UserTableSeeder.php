<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $rolename = array(
        'name' => 'superadmin'
      );
      $role = Role::create($rolename);

      $user = User::create([
        'name' => 'Wawan',
        'username' => 'noctis',
        'email' => 'superadmin@email.com',
        'password' => bcrypt('password'),
      ]);

      $user->assignRole($rolename['name']);

    }
}
