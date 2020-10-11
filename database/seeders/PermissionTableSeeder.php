<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'Role',
                'guard_name' => 'api',
                'module_list_id' => 1,
            ],
            [
                'name' => 'role-list',
                'guard_name' => 'api',
                'module_list_id' => 1,
            ],
            [
                'name' => 'role-create',
                'guard_name' => 'api',
                'module_list_id' => 1,
            ],
            [
                'name' => 'role-edit',
                'guard_name' => 'api',
                'module_list_id' => 1,
            ],
            [
                'name' => 'role-delete',
                'guard_name' => 'api',
                'module_list_id' => 1,
            ],
            [
                'name' => 'User',
                'guard_name' => 'api',
                'module_list_id' => 2,
            ],
            [
                'name' => 'user-list',
                'guard_name' => 'api',
                'module_list_id' => 2,
            ],
            [
                'name' => 'user-create',
                'guard_name' => 'api',
                'module_list_id' => 2,
            ],
            [
                'name' => 'user-edit',
                'guard_name' => 'api',
                'module_list_id' => 2,
            ],
            [
                'name' => 'user-delete',
                'guard_name' => 'api',
                'module_list_id' => 2,
            ],
            [
                'name' => 'user-view',
                'guard_name' => 'api',
                'module_list_id' => 2,
            ],

            [
                'name' => 'Cms',
                'guard_name' => 'api',
                'module_list_id' => 3,
            ],
            [
                'name' => 'blog-list',
                'guard_name' => 'api',
                'module_list_id' => 3,
            ],
            [
                'name' => 'blog-create',
                'guard_name' => 'api',
                'module_list_id' => 3,
            ],
            [
                'name' => 'blog-edit',
                'guard_name' => 'api',
                'module_list_id' => 3,
            ],
            [
                'name' => 'blog-delete',
                'guard_name' => 'api',
                'module_list_id' => 3,
            ],
            [
                'name' => 'blog-view',
                'guard_name' => 'api',
                'module_list_id' => 3,
            ],

        ];

        foreach ($permissions as $permission) {
            $permissionId = Permission::updateOrCreate($permission)->id;
        }
    }
}
