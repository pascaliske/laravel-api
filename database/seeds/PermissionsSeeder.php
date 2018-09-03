<?php

use App\Api\Models\Role;
use App\Api\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    private $roles = [
        'admin' => [
            'read-users',
            'create-users',
            'update-users',
            'delete-users',
        ],
        'content-master' => [],
        'content-author' => [],
        'member' => [],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        foreach ($this->roles as $role => $permissions) {
            $role = Role::create(['name' => $role]);

            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission])->assignRole($role);
            }
        }
    }
}
