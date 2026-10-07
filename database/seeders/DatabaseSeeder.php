<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ServiceSeeder::class,
            FaqSeeder::class,
            StaticPageSeeder::class,
            ArticleSeeder::class,
            DrugSeeder::class,
            DiseaseSeeder::class,
            HealthGuideSeeder::class,
        ]);
    }
}
