<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ModuleList;

class ModuleListsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $moduleLists = [
            'Role',
            'User',
            'Cms',
        ];

        foreach($moduleLists as $module) {
            ModuleList::updateOrCreate(['name'=>$module]);
        }
    }
}
