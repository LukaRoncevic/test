<?php

namespace App\Providers;

use App\Models\BlogPost;
use App\Policies\BlogPostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
     'App\Models\Model' => 'App\Policies\ModelPolicy',
       BlogPost::class => BlogPostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

       Gate::define('home.secret',function($user){
        return $user->is_admin;

       });

        //
      //  Gate::define('update-post', function($user,$post){

       // return $user->id == $post->user_id;    
       // });

       // Gate::define('delete-post', function($user,$post){

         //   return $user->id == $post->user_id;    
         //   });

       // Gate::resource('posts','App\Policies\BlogPostPolicy');

        Gate::before(function($user,$abillity){
          if($user->is_admin){
              return true;
          } 

        });  

    }
}
