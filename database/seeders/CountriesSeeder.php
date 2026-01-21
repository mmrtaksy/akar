<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        try {
            DB::table('countries')->delete();

            $filePath = public_path('countries.json');

            if (!file_exists($filePath)) {
                $this->command->info('File not found at path: ' . $filePath);
            }


            $jsonContent = file_get_contents($filePath);

            $countries = json_decode($jsonContent);

            $cities = [];
            foreach ($countries->data as $country) {
                $cities[] = ['name' => $country->name, 'is_active' => 1];
            }

            DB::transaction(function () use ($cities) {
                DB::table('countries')->insert($cities);
            });


            $this->command->info("Cities data has been successfully inserted.");

        } catch (\Exception $e) {
            $this->command->error("An error occurred: " . $e->getMessage());
        }

    }
}
