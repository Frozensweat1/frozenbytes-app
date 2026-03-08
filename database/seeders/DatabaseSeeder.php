<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );

        SiteSetting::query()->firstOrCreate([], [
            'business_name' => 'FrozenBytes',
            'tagline' => 'Reliable Web Engineering for Growing Businesses',
            'footer_text' => 'All rights reserved.',
        ]);

        $defaultPages = [
            ['title' => 'Home', 'slug' => 'home', 'sort_order' => 1, 'hero_title' => 'Build, Scale, and Grow', 'hero_subtitle' => 'Digital products engineered for measurable business impact.'],
            ['title' => 'About', 'slug' => 'about', 'sort_order' => 2, 'hero_title' => 'About FrozenBytes', 'hero_subtitle' => 'Our process, standards, and delivery approach.'],
            ['title' => 'Services', 'slug' => 'services', 'sort_order' => 3, 'hero_title' => 'Our Services', 'hero_subtitle' => 'Flexible services built around your business goals.'],
            ['title' => 'Projects', 'slug' => 'projects', 'sort_order' => 4, 'hero_title' => 'Featured Projects', 'hero_subtitle' => 'Real implementation outcomes from real client work.'],
            ['title' => 'Blog', 'slug' => 'blog', 'sort_order' => 5, 'hero_title' => 'Insights and Updates', 'hero_subtitle' => 'Engineering, product, and growth-focused articles.'],
            ['title' => 'Contact Us', 'slug' => 'contact-us', 'sort_order' => 6, 'hero_title' => 'Start a Conversation', 'hero_subtitle' => 'Share your goals and we will propose a practical plan.'],
            ['title' => 'Reviews & Ratings', 'slug' => 'reviews-ratings', 'sort_order' => 7, 'hero_title' => 'Client Reviews', 'hero_subtitle' => 'Feedback from businesses we have served.'],
        ];

        foreach ($defaultPages as $page) {
            Page::query()->firstOrCreate(
                ['slug' => $page['slug']],
                [
                    'title' => $page['title'],
                    'excerpt' => null,
                    'content' => null,
                    'hero_title' => $page['hero_title'] ?? null,
                    'hero_subtitle' => $page['hero_subtitle'] ?? null,
                    'hero_cta_text' => null,
                    'hero_cta_url' => null,
                    'is_published' => true,
                    'sort_order' => $page['sort_order'],
                ]
            );
        }

        $this->call(RoleAndPermissionSeeder::class);
    }
}
