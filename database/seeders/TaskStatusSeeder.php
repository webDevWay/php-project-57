<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('task_statuses')->insert(['name' => 'новая',
            'color' => 'gray',
            'created_at' => Carbon::now(),
        ]);
        DB::table('task_statuses')->insert(['name' => 'завершена',
            'color' => 'green',
            'created_at' => Carbon::now(),
        ]);
        DB::table('task_statuses')->insert(['name' => 'выполняется',
            'color' => 'yellow',
            'created_at' => Carbon::now(),
        ]);
        DB::table('task_statuses')->insert(['name' => 'в архиве',
            'color' => 'purple',
            'created_at' => Carbon::now(),
        ]);
    }
}
