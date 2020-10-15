<?php

namespace Modules\Todo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Todo\Entities\Priority;

class PriorityTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $priorities = [
            [
                'id' => 1,
                'name' => 'Today',
                'color' => '#FF2B71',
                'days' => 1,
                'rank_order' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Tomorrow',
                'color' => '#FF874B',
                'days' => 2,
                'rank_order' => 2,
            ],
            [
                'id' => 3,
                'name' => 'Upcoming',
                'color' => '#9561e2',
                'days' => 3,
                'rank_order' => 3,
            ],
            [
                'id' => 4,
                'name' => 'This Week',
                'color' => '#2d48c5',
                'days' => 7,
                'rank_order' => 4,
            ],
            [
                'id' => 100,
                'name' => 'Scheduled',
                'color' => '#031229',
                'rank_order' => 5,
            ],
        ];

        foreach ($priorities as $priority) {
            Priority::create($priority);
        }

        // $this->call("OthersTableSeeder");
    }
}
