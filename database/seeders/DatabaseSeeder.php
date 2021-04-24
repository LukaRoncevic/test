<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $users = \App\Models\User::factory(20)->create();

       // \App\Models\Comment::factory(10)->create(['blog_post_id'=>2]);

      $posts =\App\Models\BlogPost::factory(40)->make()->each(function ($post) use ($users){
     $post->user_id = $users->random()->id;
    $post->save();
     }
    );
    
    $comments = \App\Models\Comment::factory(200)->make()->each(function ($comment) use ($posts){

    $comment->blog_post_id = $posts->random()->id;
    
    $comment->save();
    }
);

    

    
    
}
}