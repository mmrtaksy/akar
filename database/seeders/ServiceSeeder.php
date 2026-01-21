<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Services;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Services::factory()->count(15)->create(); // 15 adet sahte hizmet kaydı oluşturur
    }
}
