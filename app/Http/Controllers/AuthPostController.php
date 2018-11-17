<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class AuthPostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(10);

        return view ('auth.posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('auth.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        // Check for correct user

        if(auth()->user()->id !== $post->user_id){
            return redirect('/auth/posts'.'/'.$id)->with('error', 'Permission Denied');
        }

        return view('auth.posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'featured_image' => 'image|nullable|max:1999'
        ]);

        // Handle File Upload
        if($request->hasFile('featured_image')){

            // Get filename with the extension
            $filenameWithExt = $request->file('featured_image')->getclientOriginalName();

            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $request->file('featured_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('featured_image')->storeAs('public/images',$fileNameToStore);

        }

        // Create Post
        $post = Post::find($id);
        $post->title =$request->input('title');
        $post->body =$request->input('body');
        if($request->hasFile('featured_image')){
            Storage::delete('public/featured_image/' . $post->featured_image);
            $post->featured_image = $fileNameToStore;
            $post->featured_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/auth/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();

        // Check for correct user

        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts'.'/'.$id)->with('error', 'Permission Denied');
        }

        if($post->featured_image != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/images/'.$post->featured_image);
        }

        return redirect('/auth/posts')->with('success', 'Post Deleted');
    }
}
