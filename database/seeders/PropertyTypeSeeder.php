<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PropertyType;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'ar' => 'فلل',
                'en' => 'Villas',
            ],
            [
                'ar' => 'مزارع',
                'en' => 'Farms',
            ],
            [
                'ar' => 'شاليهات',
                'en' => 'Chalets',
            ],
        ];

        foreach ($types as $type) {
            PropertyType::updateOrCreate(
                [
                    'name->en' => $type['en'],
                ],
                [
                    'name' => [
                        'ar' => $type['ar'],
                        'en' => $type['en'],
                    ],
                ]
            );
        }
    }
}
