<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = ['About', 'Help', 'How it works', 'Tips & Tricks', 'Winners'];
        
        foreach ($pages as $page) {
            \App\Models\Page::factory()->create([
                'title' => $page,
                'slug' => Str::slug($page)
            ]);
        }
    }
}
