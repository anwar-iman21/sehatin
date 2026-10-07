<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Kesehatan Umum',
                'slug'        => 'kesehatan-umum',
                'description' => 'Informasi kesehatan umum untuk masyarakat luas.',
                'icon'        => 'fas fa-heartbeat',
                'is_featured' => true,
                'order'       => 1,
            ],
            [
                'name'        => 'Kesehatan Mental',
                'slug'        => 'kesehatan-mental',
                'description' => 'Panduan menjaga kesehatan mental dan kesejahteraan jiwa.',
                'icon'        => 'fas fa-brain',
                'is_featured' => true,
                'order'       => 2,
            ],
            [
                'name'        => 'Diet dan Nutrisi',
                'slug'        => 'diet-dan-nutrisi',
                'description' => 'Informasi pola makan sehat, gizi, dan nutrisi seimbang.',
                'icon'        => 'fas fa-apple-alt',
                'is_featured' => true,
                'order'       => 3,
            ],
            [
                'name'        => 'Kesehatan Anak',
                'slug'        => 'kesehatan-anak',
                'description' => 'Tips merawat dan menjaga kesehatan anak sejak dini.',
                'icon'        => 'fas fa-child',
                'is_featured' => true,
                'order'       => 4,
            ],
            [
                'name'        => 'Gaya Hidup Sehat',
                'slug'        => 'gaya-hidup-sehat',
                'description' => 'Inspirasi dan panduan menjalani gaya hidup aktif dan sehat.',
                'icon'        => 'fas fa-running',
                'is_featured' => true,
                'order'       => 5,
            ],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
