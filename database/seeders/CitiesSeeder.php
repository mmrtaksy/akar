<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('cities')->delete();

        DB::table('cities')->insert([
            0 => [
                'is_active' => 1,
                'id' => 1,
                'name' => 'Adana',
            ],
            1 => [
                'is_active' => 1,
                'id' => 2,
                'name' => 'Adıyaman',
            ],
            2 => [
                'is_active' => 1,
                'id' => 3,
                'name' => 'Afyonkarahisar',
            ],
            3 => [
                'is_active' => 1,
                'id' => 4,
                'name' => 'Ağrı',
            ],
            4 => [
                'is_active' => 1,
                'id' => 5,
                'name' => 'Amasya',
            ],
            5 => [
                'is_active' => 1,
                'id' => 6,
                'name' => 'Ankara',
            ],
            6 => [
                'is_active' => 1,
                'id' => 7,
                'name' => 'Antalya',
            ],
            7 => [
                'is_active' => 1,
                'id' => 8,
                'name' => 'Artvin',
            ],
            8 => [
                'is_active' => 1,
                'id' => 9,
                'name' => 'Aydın',
            ],
            9 => [
                'is_active' => 1,
                'id' => 10,
                'name' => 'Balıkesir',
            ],
            10 => [
                'is_active' => 1,
                'id' => 11,
                'name' => 'Bilecik',
            ],
            11 => [
                'is_active' => 1,
                'id' => 12,
                'name' => 'Bingöl',
            ],
            12 => [
                'is_active' => 1,
                'id' => 13,
                'name' => 'Bitlis',
            ],
            13 => [
                'is_active' => 1,
                'id' => 14,
                'name' => 'Bolu',
            ],
            14 => [
                'is_active' => 1,
                'id' => 15,
                'name' => 'Burdur',
            ],
            15 => [
                'is_active' => 1,
                'id' => 16,
                'name' => 'Bursa',
            ],
            16 => [
                'is_active' => 1,
                'id' => 17,
                'name' => 'Çanakkale',
            ],
            17 => [
                'is_active' => 1,
                'id' => 18,
                'name' => 'Çankırı',
            ],
            18 => [
                'is_active' => 1,
                'id' => 19,
                'name' => 'Çorum',
            ],
            19 => [
                'is_active' => 1,
                'id' => 20,
                'name' => 'Denizli',
            ],
            20 => [
                'is_active' => 1,
                'id' => 21,
                'name' => 'Diyarbakır',
            ],
            21 => [
                'is_active' => 1,
                'id' => 22,
                'name' => 'Edirne',
            ],
            22 => [
                'is_active' => 1,
                'id' => 23,
                'name' => 'Elazığ',
            ],
            23 => [
                'is_active' => 1,
                'id' => 24,
                'name' => 'Erzincan',
            ],
            24 => [
                'is_active' => 1,
                'id' => 25,
                'name' => 'Erzurum',
            ],
            25 => [
                'is_active' => 1,
                'id' => 26,
                'name' => 'Eskişehir',
            ],
            26 => [
                'is_active' => 1,
                'id' => 27,
                'name' => 'Gaziantep',
            ],
            27 => [
                'is_active' => 1,
                'id' => 28,
                'name' => 'Giresun',
            ],
            28 => [
                'is_active' => 1,
                'id' => 29,
                'name' => 'Gümüşhane',
            ],
            29 => [
                'is_active' => 1,
                'id' => 30,
                'name' => 'Hakkari',
            ],
            30 => [
                'is_active' => 1,
                'id' => 31,
                'name' => 'Hatay',
            ],
            31 => [
                'is_active' => 1,
                'id' => 32,
                'name' => 'Isparta',
            ],
            32 => [
                'is_active' => 1,
                'id' => 33,
                'name' => 'Mersin',
            ],
            33 => [
                'is_active' => 1,
                'id' => 34,
                'name' => 'İstanbul',
            ],
            34 => [
                'is_active' => 1,
                'id' => 35,
                'name' => 'İzmir',
            ],
            35 => [
                'is_active' => 1,
                'id' => 36,
                'name' => 'Kars',
            ],
            36 => [
                'is_active' => 1,
                'id' => 37,
                'name' => 'Kastamonu',
            ],
            37 => [
                'is_active' => 1,
                'id' => 38,
                'name' => 'Kayseri',
            ],
            38 => [
                'is_active' => 1,
                'id' => 39,
                'name' => 'Kırklareli',
            ],
            39 => [
                'is_active' => 1,
                'id' => 40,
                'name' => 'Kırşehir',
            ],
            40 => [
                'is_active' => 1,
                'id' => 41,
                'name' => 'Kocaeli',
            ],
            41 => [
                'is_active' => 1,
                'id' => 42,
                'name' => 'Konya',
            ],
            42 => [
                'is_active' => 1,
                'id' => 43,
                'name' => 'Kütahya',
            ],
            43 => [
                'is_active' => 1,
                'id' => 44,
                'name' => 'Malatya',
            ],
            44 => [
                'is_active' => 1,
                'id' => 45,
                'name' => 'Manisa',
            ],
            45 => [
                'is_active' => 1,
                'id' => 46,
                'name' => 'Kahramanmaraş',
            ],
            46 => [
                'is_active' => 1,
                'id' => 47,
                'name' => 'Mardin',
            ],
            47 => [
                'is_active' => 1,
                'id' => 48,
                'name' => 'Muğla',
            ],
            48 => [
                'is_active' => 1,
                'id' => 49,
                'name' => 'Muş',
            ],
            49 => [
                'is_active' => 1,
                'id' => 50,
                'name' => 'Nevşehir',
            ],
            50 => [
                'is_active' => 1,
                'id' => 51,
                'name' => 'Niğde',
            ],
            51 => [
                'is_active' => 1,
                'id' => 52,
                'name' => 'Ordu',
            ],
            52 => [
                'is_active' => 1,
                'id' => 53,
                'name' => 'Rize',
            ],
            53 => [
                'is_active' => 1,
                'id' => 54,
                'name' => 'Sakarya',
            ],
            54 => [
                'is_active' => 1,
                'id' => 55,
                'name' => 'Samsun',
            ],
            55 => [
                'is_active' => 1,
                'id' => 56,
                'name' => 'Siirt',
            ],
            56 => [
                'is_active' => 1,
                'id' => 57,
                'name' => 'Sinop',
            ],
            57 => [
                'is_active' => 1,
                'id' => 58,
                'name' => 'Sivas',
            ],
            58 => [
                'is_active' => 1,
                'id' => 59,
                'name' => 'Tekirdağ',
            ],
            59 => [
                'is_active' => 1,
                'id' => 60,
                'name' => 'Tokat',
            ],
            60 => [
                'is_active' => 1,
                'id' => 61,
                'name' => 'Trabzon',
            ],
            61 => [
                'is_active' => 1,
                'id' => 62,
                'name' => 'Tunceli',
            ],
            62 => [
                'is_active' => 1,
                'id' => 63,
                'name' => 'Şanlıurfa',
            ],
            63 => [
                'is_active' => 1,
                'id' => 64,
                'name' => 'Uşak',
            ],
            64 => [
                'is_active' => 1,
                'id' => 65,
                'name' => 'Van',
            ],
            65 => [
                'is_active' => 1,
                'id' => 66,
                'name' => 'Yozgat',
            ],
            66 => [
                'is_active' => 1,
                'id' => 67,
                'name' => 'Zonguldak',
            ],
            67 => [
                'is_active' => 1,
                'id' => 68,
                'name' => 'Aksaray',
            ],
            68 => [
                'is_active' => 1,
                'id' => 69,
                'name' => 'Bayburt',
            ],
            69 => [
                'is_active' => 1,
                'id' => 70,
                'name' => 'Karaman',
            ],
            70 => [
                'is_active' => 1,
                'id' => 71,
                'name' => 'Kırıkkale',
            ],
            71 => [
                'is_active' => 1,
                'id' => 72,
                'name' => 'Batman',
            ],
            72 => [
                'is_active' => 1,
                'id' => 73,
                'name' => 'Şırnak',
            ],
            73 => [
                'is_active' => 1,
                'id' => 74,
                'name' => 'Bartın',
            ],
            74 => [
                'is_active' => 1,
                'id' => 75,
                'name' => 'Ardahan',
            ],
            75 => [
                'is_active' => 1,
                'id' => 76,
                'name' => 'Iğdır',
            ],
            76 => [
                'is_active' => 1,
                'id' => 77,
                'name' => 'Yalova',
            ],
            77 => [
                'is_active' => 1,
                'id' => 78,
                'name' => 'Karabük',
            ],
            78 => [
                'is_active' => 1,
                'id' => 79,
                'name' => 'Kilis',
            ],
            79 => [
                'is_active' => 1,
                'id' => 80,
                'name' => 'Osmaniye',
            ],
            80 => [
                'is_active' => 1,
                'id' => 81,
                'name' => 'Düzce',
            ],
        ]);

    }
}
