<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SuperadminUser::class);
        $this->call(ModuleListsTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(SuperAdminRolePermissionSeeder::class);
        $this->call(AssignRoleSeeder::class);
    }
}
