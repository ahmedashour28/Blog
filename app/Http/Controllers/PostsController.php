<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     * this one is to make only the loggedin users has the access to these functions in the controller except the function that
     * we add to the except array
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => ['index' , 'show' ]]);
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //$posts = Post::all();
        $posts = Post::orderBy('created_at','asc')->get();
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('posts.createPost');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'title'=> 'required',
            'body'=> 'required',
            'image'=> 'image|nullable|max:1999'
        ]);

        // handle the file upload
        if($request->hasFile('image')){
            // get file with extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            // get the file name alone
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // get the extension
            $extension = $request->file('image')->getClientOriginalExtension();
            // make the file name to store
            $fileNameToStore = $fileName .'_'.time().'.'.$extension;
            // upload image
            //$path = $request->file('image')->storeAs('public/images', $fileNameToStore);
            Storage::disk('public')->putFileAs('images', $request->file('image'), $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'post created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $post = Post::find($id);
        return view('posts.showPost')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);
        if(Auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized page');
        }
        return view('posts.editPost')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'title'=> 'required',
            'body'=> 'required',
            'image'=> 'image|nullable|max:1999'
        ]);

        // handle the file upload
        if($request->hasFile('image')){
            // get file with extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            // get the file name alone
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // get the extension
            $extension = $request->file('image')->getClientOriginalExtension();
            // make the file name to store
            $fileNameToStore = $fileName .'_'.time().'.'.$extension;
            // upload image
            //$path = $request->file('image')->storeAs('public/images', $fileNameToStore);
            Storage::disk('public')->putFileAs('images', $request->file('image'), $fileNameToStore);
        }

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('image')){
            $post->image = $fileNameToStore;
        }
        $post->save();
        echo $post->title;

        return redirect('/posts')->with('success', 'post updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if(Auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized page');
        }

        if($post->image != 'noimage.jpg'){
            Storage::disk('public')->delete('images/'.$post->image);
        }
        $post->delete();
        return redirect('/posts')->with('success', 'post removed');
    }
}
