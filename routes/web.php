<?php
use  App\Http\Controllers\PostsController;
use  App\Http\Controllers\AboutController;
use  App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
 //   return view('home.index');
//})->name('home.index');

//Route::get('/contact', function (){

//return view('home.contact');
//})->name('home.contact');

Route::get('/',[HomeController::class,'home'])->name('home.index');

Route::get('/contact',[HomeController::class,'contact'])->name('home.contact');

Route::get('/secret',[HomeController::class,'secret'])->name('home.secret')->middleware('can:home.secret');

Route::get('/single',AboutController::class);

Auth::routes();

$posts = [
    1 => [
        'title' => 'Intro to Laravel',
        'content' => 'This is a short intro to Laravel',
         'is_new'=>true,
         'has_comments'=>true
    ],
    2 => [
        'title' => 'Intro to PHP',
        'content' => 'This is a short intro to PHP',
         'is_new'=>false
    ],
    3 => [
        'title' => 'Intro to Java ',
        'content' => 'This is a short intro to Java',
         'is_new'=>false
    ]

    ];
Route::resource('posts', PostsController::class);
//->only(['index', 'show', 'create', 'store', 'edit','update']);

//Route::resource('posts', PostsController::class)->except(['index', 'show']);

//Route::resource('posts', PostsController::class);

//Route::get('/posts', function() use($posts){
//dd(request()->all());
//dd((int)request()->input('page',1));
//return view('posts.index', ['posts' => $posts]);
//});

//Route::get('/posts/{id}', function($id) use($posts) {



    // abort_if(!isset($posts[$id]), 404);

   // return view('posts.show', ['post'=>$posts[$id]]);


//})//->where(['id'=>'[0-9]+'])

//->name('posts.show');

//Route::get('fun/responses', function() use($posts){

//return response($posts,201)->header('Content-Type','application/json')->cookie('MY_COOKIE','Luka',3600);

//});

Route::get('/fun/redirect', function(){

return redirect('/contact');

});

Route::get('/fun/back', function(){

    return back();

    });

    Route::get('/fun/named-route', function(){

        return redirect()->route('posts.show', ['id'=>1]);

        });


        Route::get('/fun/away', function(){

            return redirect()->away();

            });

            Route::get('/fun/download', function() use($posts) {

                return response()->download(public_path('/daniel.jpg'),'face.jpg');

                });


