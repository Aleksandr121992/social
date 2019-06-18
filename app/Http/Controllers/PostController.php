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
    public function createPost()
    {
    	return view('posts/post');	
    }

    public function addProfileImage(Request $request)
    {
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
        
        $posts->save();
      return redirect('/home')->
        with('response','Post Added Succesfully');
    }

    public function view($post_id){
         $user_perm = Auth::user()->permition;
    	 $posts = Post::where('id','=',$post_id)->with('comments.user')->first();   
    	 return view('/posts/view',['posts' => $posts,'user_perm' => $user_perm]);
    }

    public function edit($post_id){
        $user_id = Auth::id();
    	$post = Post::where('id',$post_id)->where('user_id',$user_id)->first();
         if ($post){
        	return view('/posts/edit',['post' => $post]);
        }else{
            return abort(404);
        }
    }

    public function editPost(EditRequest $request,$post_id){
    	
    
        $user_id = Auth::id();
        $dataRequest =$request->all();
        $post = Post::where('id',$post_id)->where('user_id',$user_id)->first();
        
         if ($post){
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
         
        $data = array(
        
            'post_title' => $dataRequest['post_title'],
            'post_description' =>$dataRequest['post_description'] ,
            // 'post_image' => $post->post_image,
            // 'post_image_2' => $post->post_image_2,
            // 'post_image_3' => $post->post_image_3
        );
        // dd($data);
        Post::where('id',$post_id)
        ->update($data);  
      return redirect('/home')->
        with('response','Post Edited Succesfully');
           
        }else{
            return abort(404);
        }
    	
       
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
        	$data = $request->all();
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
