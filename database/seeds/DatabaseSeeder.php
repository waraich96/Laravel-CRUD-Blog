<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     */
    public function run()
    {
        $this->call([
            RoleTableSeeder::class, 
            UserTableSeeder::class,
            PostTableSeeder::class,
            CommentTableSeeder::class,
        ]);

    }
}
