<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed 5 Categories
        $categories = collect([
            ['name' => 'Programming', 'slug' => 'programming'],
            ['name' => 'Web Design', 'slug' => 'web-design'],
            ['name' => 'Technology', 'slug' => 'technology'],
            ['name' => 'Career', 'slug' => 'career'],
            ['name' => 'Life', 'slug' => 'life'],
        ])->map(fn ($cat) => Category::create($cat));

        // Seed 5 Tags
        $tags = collect([
            ['name' => 'Laravel'],
            ['name' => 'PHP'],
            ['name' => 'CSS'],
            ['name' => 'Tutorial'],
            ['name' => 'Database'],
        ])->map(fn ($tag) => Tag::create($tag));

        // Seed 5 Posts and attach tags
        $postsData = [
            [
                'title' => 'Belajar Laravel 12 untuk Pemula',
                'slug' => 'belajar-laravel-12-untuk-pemula',
                'category_id' => $categories[0]->id,
                'color' => '#3b82f6',
                'image' => 'posts/laravel.png',
                'body' => 'Laravel 12 memperkenalkan banyak fitur baru yang mempermudah pengembangan web modern.',
                'published' => true,
                'published_at' => now(),
                'tags' => [0, 1, 3], // Laravel, PHP, Tutorial
            ],
            [
                'title' => 'Mengenal CSS Grid dan Flexbox',
                'slug' => 'mengenal-css-grid-dan-flexbox',
                'category_id' => $categories[1]->id,
                'color' => '#10b981',
                'image' => 'posts/css.png',
                'body' => 'CSS Grid dan Flexbox adalah fondasi utama dari layout web responsive.',
                'published' => true,
                'published_at' => now(),
                'tags' => [2, 3], // CSS, Tutorial
            ],
            [
                'title' => 'Tren Teknologi Masa Depan',
                'slug' => 'tren-teknologi-masa-depan',
                'category_id' => $categories[2]->id,
                'color' => '#f59e0b',
                'image' => 'posts/tech.png',
                'body' => 'Kecerdasan Buatan dan Komputasi Awan mendominasi inovasi teknologi tahun ini.',
                'published' => true,
                'published_at' => now(),
                'tags' => [4], // Database
            ],
            [
                'title' => 'Tips Mempersiapkan Karir Programmer',
                'slug' => 'tips-mempersiapkan-karir-programmer',
                'category_id' => $categories[3]->id,
                'color' => '#8b5cf6',
                'image' => 'posts/career.png',
                'body' => 'Membangun portofolio yang kuat dan menguasai dasar-dasar algoritma sangat penting.',
                'published' => true,
                'published_at' => now(),
                'tags' => [3], // Tutorial
            ],
            [
                'title' => 'Keseimbangan Hidup dan Pekerjaan',
                'slug' => 'keseimbangan-hidup-dan-pekerjaan',
                'category_id' => $categories[4]->id,
                'color' => '#ec4899',
                'image' => 'posts/life.png',
                'body' => 'Menjaga produktivitas tanpa mengorbankan kesehatan mental dan fisik.',
                'published' => true,
                'published_at' => now(),
                'tags' => [],
            ],
        ];

        foreach ($postsData as $pData) {
            $tagIndices = $pData['tags'];
            unset($pData['tags']);

            $post = Post::create($pData);

            $attachIds = collect($tagIndices)->map(fn ($idx) => $tags[$idx]->id)->toArray();
            $post->tags()->attach($attachIds);
        }

        // Seed products
        $this->call(ProductSeeder::class);
    }
}
