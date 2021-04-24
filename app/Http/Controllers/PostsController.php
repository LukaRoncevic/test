<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use  App\Http\Requests\StorePost;
use  App\Models\BlogPost;
use  App\Models\User;
use  App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     *
     */

    
    public function __construct(){

    $this->middleware('auth')->only(['create','store','edit','update','destroy']);       
    }




    public function index()
    {

    $mostCommented=Cache::remember('mostCommented', 60, function (){
     
    return BlogPost::MostCommented()->take(5)->get();
    });

    

    $mostActive=Cache::remember('mostActive', 60, function (){
     
        return User::WithMostBlogPosts()->take(5)->get();
        });
    
    

       return view('posts.index', ['posts' => BlogPost::latest()->withCount('comments')->with('user')->get(),
       
       'mostCommented'=>$mostCommented,
       'mostActive'=> $mostActive,
       ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request){
    

        $validated = $request->validated();
        $validated['user_id'] =$request->user()->id;
        $post = BlogPost::create($validated);
        
        if($request->hasFile('thumbnail')){
            $path = $request->file('thumbnail')->store('thumbnails');
            $post->image()->save(
                Image::create(['path'=>$path])
            );
        }
       
      // $hasFile = $request->hasFile('thumbnail');
      // dump($hasFile);

       // if($hasFile){
       // $file = $request->file('thumbnail');
       // dump($file);
       // dump($file->getClientMimeType());
       // dump($file->getClientOriginalExtension());

        //dump($file->store('thumbnails'));
        //dump(Storage::disk('public')->putFile('thumbnails',$file));
        
       // $name1 = $file->storeAs('thumbnails',$post->id . '.' .$file->guessExtension());
       // dump(Storage::putFileAs('thumbnails',$file,$post->id. '.'. $file->guessExtension()));

       // dump(Storage::url($name1));
        
        

        
        $request->session()->flash('status','The blog post was created');

        return redirect()->route('posts.show',['post'=>$post->id]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //abort_if(!isset($this->posts[$id]), 404);

    $blogPost = Cache::remember("blog-post-{$id}", 60, function() use ($id){
    
    return BlogPost::with('comments')->findOrFail($id);
    });



    return view('posts.show', ['post'=>$blogPost]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id); 
     
        $this->authorize('update',$post);
     //if(Gate::denies('update-post',$post)){
     
     // abort(403,"You can't edit this blog post");

     //}

     
     return view('posts.edit',['post'=>BlogPost::findOrFail($id)]);
     
     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {

     $post = BlogPost::findOrFail($id); 
     
     $this->authorize('update',$post);

     //if(Gate::denies('update-post',$post)){
     
      //abort(403,"You can't edit this blog post");

    // }
     

     $validated = $request->validated();

     $post->fill($validated);
     $post->save();
    
     $request->session()->flash('status','Post was updated!');
     
    return redirect()->route('posts.show', ['post'=>$post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     
    $post = BlogPost::findOrFail($id);

    $this->authorize('delete',$post);     
   // if(Gate::denies('delete-post',$post)){
     
      //  abort(403,"You can't  this blog post");
  
     //  } 

    $post->delete();
    
    session()->flash('status', 'Blog post was deleted');

    return redirect()->route('posts.index');

    }
}
