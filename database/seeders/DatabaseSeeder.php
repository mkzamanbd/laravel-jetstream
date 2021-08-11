<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(20)->create();
        $user = User::whereEmail('zaman7u@gmail.com')->first();
        if(!$user){
            $user = new User();
            $user->name = 'Zaman';
            $user->email = 'zaman7u@gmail.com';
            $user->username = 'zaman';
            $user->password = bcrypt('12345678');
            $user->save();
        }
        $this->call(CategorySeeder::class);
        $this->call(TagSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(PostTagSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(ChatSeeder::class);
    }
}
