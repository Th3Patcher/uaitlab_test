<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create()->each(function ($user) {
            $posts = Post::factory()->count(rand(1, 5))->create([
                'user_id' => $user->id,
            ]);

            $posts->each(function ($post) use ($user) {
                Comment::factory()->count(rand(0, 2))->create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                ]);
            });
        });
    }
}
