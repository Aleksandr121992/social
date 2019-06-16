<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\EditRequest;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use App\Post;
use Auth;
use App\Comment;
use app\User;

class PostController extends Controller
{
    public function post(){
    	return view('posts/post');	
    }

    public function addProfileImage(Request $request){

        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        $profile_imageName = $user->id.'_profile_image'.time().'.'.request()->profile_image->getClientOriginalExtension();

        $request->profile_image->move(public_path().'/uploads',$profile_imageName);

        $user->profile_image = $profile_imageName;
        $user->save();

        return back()
            ->with('success','You have successfully upload image.');

    }


    public function addPost(PostRequest $request){
    	// $this->validate($request,[
    	// 	'post_title' => 'required',
    	// 	'post_description' => 'required',
    	// 	'post_image' => 'required',
     //        'post_image_2' => 'required',
     //        'post_image_3' => 'required',
    	// ]);		
    	$posts = new Post;
        $posts->post_title = $request->input('post_title');
        $posts->post_description = $request->input('post_description');
    	$posts->user_id = Auth::user()->id;
    	if(Input::hasFile('post_image')){
           $file = Input::file('post_image');
           $file -> move(public_path().'/posts/', $file->
           getClientOriginalName());
		   $url = URL::to("/") . '/posts/' . $file-> getClientOriginalName();

        }

        if(Input::hasFile('post_image_2')){
           $file_2 = Input::file('post_image_2');
           $file_2 -> move(public_path().'/posts/', $file_2->
           getClientOriginalName());
           $url_2 = URL::to("/") . '/posts/' . $file_2-> getClientOriginalName();
        }

         if(Input::hasFile('post_image_3')){
           $file_3 = Input::file('post_image_3');
           $file_3 -> move(public_path().'/posts/', $file_3->
           getClientOriginalName());
           $url_3 = URL::to("/") . '/posts/' . $file_3-> getClientOriginalName();
        }
    	$posts->post_image = $url;
        $posts->post_image_2 = $url_2;	
        $posts->post_image_3 = $url_3;  
    	$posts->save();
      return redirect('/home')->
    	with('response','Post Added Succesfully');
    }

    public function view($post_id){
         $user_perm = Auth::user()->permition;
         // $users = User::all(); 
    	 $posts = Post::where('id','=',$post_id)->with('comments.user')->first();
         // dd($posts);
    	 // $comments =  Comment::all();      
    	 return view('/posts/view',['posts' => $posts,'user_perm' => $user_perm]);
    }

    public function edit($post_id){
    	$posts = Post::find($post_id);
    	return view('/posts/edit',['posts' => $posts]);
    }

    public function editPost(EditRequest $request,$post_id){
    	
    	// $this->validate($request,[
    	// 	'post_title' => 'required',
    	// 	'post_description' => 'required',
    		
            
    	// ]);		
       
    	$posts = new Post;
        $posts->post_title = $request->input('post_title');
        $posts->post_description = $request->input('post_description');
    	$posts->user_id = Auth::user()->id;
    	if(Input::hasFile('post_image')){
           $file = Input::file('post_image');
           $file -> move(public_path().'/posts/', $file->
           getClientOriginalName());
		   $url = URL::to("/") . '/posts/' . $file-> getClientOriginalName();
        } else{
           $url =""; 
         }

        if(Input::hasFile('post_image_2')){
           $file_2 = Input::file('post_image_2');
           $file_2 -> move(public_path().'/posts/', $file_2->
           getClientOriginalName());
           $url_2 = URL::to("/") . '/posts/' . $file_2-> getClientOriginalName();
        }
         else{
           $url_2 =""; 
         }

        if(Input::hasFile('post_image_3')){
           $file_3 = Input::file('post_image_3');
           $file_3 -> move(public_path().'/posts/', $file_3->
           getClientOriginalName());
           $url_3 = URL::to("/") . '/posts/' . $file_3-> getClientOriginalName();

        }
         else{
           $url_3 =""; 
         }
    	$posts->post_image = $url;	
        $posts->post_image_2 = $url_2;  
        $posts->post_image_3 = $url_3;  
    	$data = array(
    		'user_id' => $posts->user_id,
    		'post_title' => $posts->post_title,
    		'post_description' => $posts->post_description,
    		'post_image' => $posts->post_image,
            'post_image_2' => $posts->post_image_2,
            'post_image_3' => $posts->post_image_3
    	);
    	Post::where('id',$post_id)
    	->update($data);
    	$posts->update();
      return redirect('/home')->
    	with('response','Post Edited Succesfully');
    }

    public function deletePost($post_id){
    Post::where('id',$post_id)
    	->delete();
    	 return redirect('/home')->
    	with('response','Post Deleted Succesfully');
    }

    public function comment(CommentRequest $request,$post_id){
		// $this->validate($request,[
  //   		'comment' => 'required',
  //   	]);	
    	$comment = new Comment;	
    	$comment ->user_id = Auth::user()->id;
    	$comment ->post_id = $post_id;
    	$comment ->comment = $request -> input('comment');
    	$comment->save();
    	return redirect('/view/'.$post_id)->
    	with('response','Comment Added Succesfully');
    }	

    public function editComment(CommentRequest $request)
        {
        	// dd($id);
        	$data = $request->all();
        	// dd($data);
        	unset($data['_token']);
        	Comment::where('id',$data['id'])->update($data);
        }	

    public function deleteComment($post_id){
    Comment::where('id',$post_id)
        ->delete();
         return redirect('/home')->
        with('response','Comment Deleted Succesfully');
    }
}
