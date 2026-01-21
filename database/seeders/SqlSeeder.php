<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SqlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          $path = database_path('seeds/cities.sql');
          $sql = File::get($path);
          DB::unprepared($sql);

          $path2 = database_path('seeds/countries.sql');
          $sql2 = File::get($path2);
          DB::unprepared($sql2);

          $path3 = database_path('seeds/positions.sql');
          $sql3 = File::get($path3);
          DB::unprepared($sql3);
    }
}
