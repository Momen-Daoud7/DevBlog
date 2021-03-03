<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Cviebrock\EloquentSluggable\Services\SlugService;
class PostsController extends Controller
{
    public function __construct()
    {
        // This middlerware allow users to only see the index and show methods
        $this->middleware('auth',['except' => ['index' ,'show','blog']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $request->validate([
            'title' => 'required',
            'description' => 'required',
             'image' => 'required|mimes:jpg,png,jpeg|max:5040'
        ]);
        // Uplode image
        $newImage = uniqid()."-".$request->slug.'.'.$request->image->extension();

        $request->image->move(public_path('images') , $newImage);
        // dd(auth()->user()->id);
        // creaet a new blog
        Post::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'slug' => SlugService::createSlug(Post::class,'slug',$request->title),
            'user_id' => auth()->user()->id,
            "image" => $newImage
        ]);

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
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        // Uplode image
        // dd($request->image->extension());
        // $newImage = uniqid()."-".$request->title.'.'.$request->image->extension();

        // $request->image->move(public_path('images') , $newImage);

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
