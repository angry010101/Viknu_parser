<?php

namespace App\Http\Controllers;
use App\Models\Posts;

class PostsController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function getPostById($id)
    {
        $post = Posts::whereid($id)->firstOrFail();

        $data = [
            'post'         => $post,
        ];
        return view('pages.user.post')->with($data);
    }

    public function index()
    {
        $posts = Posts::paginate(5);
        $data = [
            'posts'         => $posts,
        ];
        return view('pages.user.posts')->with($data);
    }

}
