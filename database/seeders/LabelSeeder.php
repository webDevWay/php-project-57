<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('labels')->insert(['name' => 'ошибка', 
                                    'description' => 'Какая-то ошибка в коде или проблема с функциональностью', 
                                    'color' => 'red',
                                    'created_at'=> Carbon::now()]);

        DB::table('labels')->insert(['name' => 'документация', 
                                    'description' => 'Задача которая касается документации', 
                                    'color' => 'gray',
                                    'created_at'=> Carbon::now()]);

        DB::table('labels')->insert(['name' => 'дубликат', 
                                    'description' => 'Повтор другой задачи', 
                                    'color' => 'yellow',
                                    'created_at'=> Carbon::now()]);

        DB::table('labels')->insert(['name' => 'доработка', 
                                    'description' => 'Новая фича, которую нужно запилить', 
                                    'color' => 'purple',
                                    'created_at'=> Carbon::now()]);
    }
}