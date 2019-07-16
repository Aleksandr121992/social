<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Request;
use Auth;
use App\User;
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
        $authId =Auth::id();
        $input=Request::all();
        $posts = new Post;     

        if(Request::input("search")){
            $posts = $posts->where("post_title", 'LIKE', "%".Request::input("search")."%");
        }
        $posts = $posts->orderBy("id","desc")->with(['likes','dislikes','user'])->get();
        // dd($posts);
        foreach ($posts as $key => $post) {
           $userLiked = 1;
           $userDisLiked = 1;
           $likesCount =$post->likes->count();
           // $likesCount =count($post->likes);
           $dislikesCount =$post->dislikes->count();
           foreach ($post->likes as $like) {
               if ($like->user_id ==$authId) {
                   $userLiked = 0;
               }
           }
           foreach ($post->dislikes as $dislike) {
               if ($dislike->user_id ==$authId) {
                   $userDisLiked = 0;
               }
           }
           $posts[$key]->likesCount=$likesCount;
           $posts[$key]->dislikesCount =$dislikesCount;
           $posts[$key]->userLiked =$userLiked;
           $posts[$key]->userDisLiked =$userDisLiked;
        }
      
        $user_perm = Auth::user()->permission;
       

        //         // dd($userPoint);
        $users = User::where('id','!=',$authId)
            ->with(['friends'=> function ($query) use($authId){
                    $query->where('follower_id', $authId);
                }])
             ->with(['sendedRequest'=> function ($query) use($authId){
                    $query->where('user_id', $authId);
                }])
            ->get(); 
// dd($users);
        foreach ($users as $key => $user) {
            // dd($users,$user);
          // dd($user->friends[0])
           
          if (count($user->friends)) {
                $is_accepted = $user->friends[0]->pivot->accepted;
                $is_friend =1;
              
          }else{
                $is_friend =0;
                $is_accepted = 0;

          }
          if (count($user->sendedRequest)) {
                $is_user_sended = 1;
                $is_friend =1;
          }else{
                $is_user_sended =0;
                
          }
          $users[$key]->is_friend =$is_friend;
          $users[$key]->is_accepted =$is_accepted;
          $users[$key]->is_user_sended =$is_user_sended;
        }


        // dd($users);
        return view('allPosts',[ 'posts' => $posts,'user_perm' => $user_perm,'users' => $users,'input'=> $input]);
    
      
    }
}
