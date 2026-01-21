<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PanelMenu;

class PanelMenuSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'title' => 'Hizmetler',
                'statu' => true,
                'meta' => false,
                'editor' => false,
                'multiple_image' => false,
                'image' => true,
                'categories' => false,
                'extra' => null
            ],
            [
                'id' => 2,
                'title' => 'Odalar',
                'statu' => true,
                'meta' => true,
                'editor' => true,
                'multiple_image' => true,
                'categories' => false,
                'image' => true,
                'extra' => json_encode([
                    [
                        'field_title' => 'Oda Özellikleri',
                        'fields' => [
                            ['label' => 'Yatak', 'name' => 'bed'],
                            ['label' => 'Duş', 'name' => 'shower'],
                            ['label' => 'TV', 'name' => 'tv'],
                            ['label' => 'Fiyat', 'name' => 'price']
                        ]
                    ]
                ])
            ],
            [
                'id' => 3,
                'title' => 'Blog',
                'statu' => true,
                'meta' => true,
                'editor' => true,
                'multiple_image' => true,
                'image' => true,
                'categories' => true,
                'extra' => null
            ],
            [
                'id' => 4,
                'title' => 'Slayt',
                'statu' => true,
                'meta' => false,
                'editor' => false,
                'multiple_image' => false,
                'image' => true,
                'categories' => false,
                'extra' => null
            ],
            [
                'id' => 5,
                'title' => 'Yorumlar',
                'statu' => true,
                'meta' => false,
                'editor' => false,
                'multiple_image' => false,
                'categories' => false,
                'image' => true,
                'extra' => json_encode([
                    [
                        'field_title' => 'Müşteri Özellikleri',
                        'fields' => [
                            ['label' => 'Meslek', 'name' => 'job']
                        ]
                    ]
                ])
            ],
            [
                'id' => 6,
                'title' => 'SSS',
                'statu' => true,
                'meta' => false,
                'editor' => false,
                'multiple_image' => false,
                'categories' => false,
                'image' => false,
                'extra' => null
            ],
            [
                'id' => 7,
                'title' => 'Yasal',
                'statu' => true,
                'meta' => false,
                'editor' => true,
                'multiple_image' => false,
                'categories' => false,
                'image' => false,
                'extra' => null
            ],
        ];

        foreach ($data as $menu) {
            PanelMenu::updateOrCreate(['id' => $menu['id']], $menu);
        }
    }
}