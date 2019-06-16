<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\user;
use App\Post;
use App\Comment;

class StaticController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
  public function index()
    {   
        $user_perm = Auth::user()->permition;
        $user_id = Auth::user()->id;
        $users =  Auth::user()->id;  
        $posts = Post::all();    
        $users = User::all();             
        return view('blog',[ 'posts' => $posts,'user_perm' => $user_perm,'users' => $users]);
    }
}
