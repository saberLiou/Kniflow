<?php

namespace Database\Seeders;

// use App\Models\Category;
// use App\Models\PersonalAccessToken;
// use App\Models\Post;
// use App\Models\User;
use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /* If use `php artisan db:seed`. */
        // Schema::disableForeignKeyConstraints();

        // Post::truncate();
        // Category::truncate();
        // PersonalAccessToken::truncate();
        // User::truncate();

        /* Merely use `php artisan migrate:refresh/fresh --seed`. */
        $this->call([
            UserSeeder::class,
            PersonalAccessTokenSeeder::class,
            CategorySeeder::class,
            PostSeeder::class,
        ]);

        // Schema::enableForeignKeyConstraints();
    }
}
