<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    protected $data = [
        [
            'name' => 'Admin',
            'permissions' => ['root']
        ],
        [
            'name' => 'Member',
            'permissions' => ['member']
        ]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      foreach ($this->data as $_data) {
          \App\Role::create([
              'name' => $_data['name'],
              'permissions' => $_data['permissions']
          ]);
      }
    }
}
