<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Cviebrock\EloquentSluggable\Services\SlugService;
class PostsController extends Controller
{
    public function __construct()
    {
        // Allowing users to only access index , show pages
        $this->middleware('auth',['except' => ['index' ,'show','blog']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all the post from the DB order by desc
        return view('blog.index')->with('posts' ,Post::orderBy('updated_at' ,'DESC')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Input validation
        $request->validate([
            'title' => 'required',
            'description' => 'required',
             'image' => 'required|mimes:jpg,png,jpeg|max:5040'
        ]);

        // Uplode image
        $newImage = uniqid()."-".$request->slug.'.'.$request->image->extension();

        $request->image->move(public_path('images') , $newImage);
       
       // Create a post afetr validation
        Post::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'slug' => SlugService::createSlug(Post::class,'slug',$request->title),
            'user_id' => auth()->user()->id,
            "image" => $newImage
        ]);

        // if the post created redirect to blog page with a message
        return redirect('/blog')->with('message' , 'Your post created successfully');

    }

    /**

     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //Show a specifc post based on his slug
        return view('blog.show')->with('post' , Post::where('slug',$slug)->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        return view('blog.edit')->with('post' , Post::where('slug',$slug)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        //Input validation
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        //Update after vlidation
        Post::where('slug',$slug)->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return redirect('/blog')->with('message',"your post has been updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        Post::where('slug',$slug)->delete();

        return redirect('/blog')->with('message',"your post has been Deleted!");

    }
}
