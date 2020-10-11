<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


use Illuminate\Database\Seeder;

class SuperAdminRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::updateOrCreate(['guard_name' => 'api', 'name' => 'super-admin']);
        $role = Role::where('name', 'super-admin')
        ->first();
        $permissions = Permission::where('guard_name', 'api')->get();
        $role->givePermissionTo($permissions);

    }
}
