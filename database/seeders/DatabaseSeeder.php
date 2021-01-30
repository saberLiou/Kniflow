<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

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
        // User::truncate();

        /* Merely use `php artisan migrate:refresh/fresh --seed`. */
        $this->call([
            UserSeeder::class,
            PostSeeder::class
        ]);

        // Schema::enableForeignKeyConstraints();
    }
}
