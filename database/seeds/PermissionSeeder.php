<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Faker\Generator as Faker;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $arr = array(
        'member_new',
        'member_list',
        'wallet_add',
        'wallet_list',
        'wd_pending',
        'wd_approve',
        'categoryproduct',
        'admin_panel'
      );

      // for ($i=0; $i < count($arr); $i++) {
      //   Permission::create(['name' => $arr[$i]]);
      // }

      $txt = 'superadmin';
      $role = Role::whereRaw('lower(name) = "'.$txt.'"')->first();
      $role->syncPermissions($arr);
    }
}
