<?php

use App\Api\Models\Role;
use App\Api\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    private $roles = [
        'admin' => [
            'read-user',
            'create-user',
            'update-user',
            'delete-user',
            'read-page',
            'create-page',
            'update-page',
            'delete-page',
            'read-media',
            'create-media',
            'update-media',
            'delete-media',
        ],
        'content-master' => [
            'read-page',
            'create-page',
            'update-page',
            'delete-page',
            'read-media',
            'create-media',
            'update-media',
            'delete-media',
        ],
        'content-author' => [
            'read-page',
            'read-media',
            'create-media',
            'update-media',
            'delete-media',
        ],
        'member' => [
            'read-page',
            'read-media',
        ],
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
                Permission::findOrCreate($permission)->assignRole($role);
            }
        }
    }
}
