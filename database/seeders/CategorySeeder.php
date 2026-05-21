<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'ar' => 'احتفال',
                'en' => 'Celebration',
            ],
            [
                'ar' => 'عيلة',
                'en' => 'Family',
            ],
            [
                'ar' => 'رومانسي',
                'en' => 'Romantic',
            ],
            [
                'ar' => 'هدوء',
                'en' => 'Peaceful',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                [
                    'name->en' => $category['en'],
                ],
                [
                    'name' => [
                        'ar' => $category['ar'],
                        'en' => $category['en'],
                    ],
                ]
            );
        }
    }
}
