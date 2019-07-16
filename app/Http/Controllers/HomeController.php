<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Post;
use App\Image;

class HomeController extends Controller
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
        $authUser = User::where('id',$authId)->with('posts.images')->first();
        $users = User::where('id','!=',$authId)
            ->with(['friends'=> function ($query) use($authId){
                    $query->where('follower_id', $authId);
                }])
             ->with(['sendedRequest'=> function ($query) use($authId){
                    $query->where('user_id', $authId);
                }])
            ->get(); 
        foreach ($users as $key => $user) {
            // dd($users,$user);
          // dd($user->friends[0])
            if ($user->id ==4) {
                // dd($user);
            }
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
    
        return view('myPosts',[ 'authUser' => $authUser,'users' => $users]);
    }
}
