<?php

namespace Database\Seeders;

use App\Models\Languages;
use App\Models\User;
use App\Models\UserTypes;
use App\Models\Seo;
use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // User::truncate();
        User::create([
            "name" => "Admin",
            "surname" => "Admin",
            "email" => 'admin@admin.com',
            "password" => '123321',
            "phone" => "5448807289",
            "statu" => 1,
            "user_type_id" => 1
        ]);
        UserTypes::create([
            "title" => "Admin",
        ]);
        Seo::create([
            "meta_title" => "Test Title",
        ]);
        BlogCategory::create([
            "title" => "Genel",
        ]);
        Languages::insert([
            [
                "name" => "Türkçe",
                "native" => "tr",
                "code" => "tr_TR",
                "is_default" => true,
                "statu" => 1,
            ],
            [
                "name" => "English",
                "native" => "en",
                "code" => "en_EN",
                "is_default" => false,
                "statu" => 1,
            ]
        ]);
    }
}
