<?php

use App\Api\Models\Role;
use App\Api\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    private $roles = [
        'admin' => [
            // user
            'user' => [
                'read',
                'create',
                'update',
                'delete',
            ],

            // page
            'page' => [
                'read',
                'create',
                'update',
                'delete',
            ],

            // media
            'media' => [
                'read',
                'create',
                'update',
                'delete',
            ],
        ],
        'content-master' => [
            // user
            'user' => [
                'read',
            ],

            // page
            'page' => [
                'read',
                'create',
                'update',
                'delete',
            ],

            // media
            'media' => [
                'read',
                'create',
                'update',
                'delete',
            ],
        ],
        'content-author' => [
            // page
            'page' => [
                'read',
            ],

            // media
            'media' => [
                'read',
                'create',
                'update',
                'delete',
            ],
        ],
        'member' => [
            // page
            'page' => [
                'read',
            ],

            // media
            'media' => [
                'read',
            ],
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

        foreach ($this->roles as $role => $scopes) {
            $role = Role::create(['name' => $role]);

            foreach ($scopes as $scope => $permissions) {
                foreach ($permissions as $permission) {
                    Permission::findOrCreate(sprintf('%s-%s', $permission, $scope))->assignRole($role);
                }
            }
        }
    }
}
