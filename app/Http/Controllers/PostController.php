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
use App\Follower;
use App\User;
use App\Image;
use App\Post_like_dislike;
use App\CommentLikeDislike;


class PostController extends Controller
{
    public function createPost()
    {
      $users = User::all();
    	return view('posts/post',['users'=>$users]);	
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
        $post = new Post;
        $post->post_title = $request->input('post_title');
        // dd ($post->post_title);
        $post->post_description = $request->input('post_description');
        $post->user_id = Auth::user()->id;
        $data = $request->all();
        $post->save();
        
       foreach ($data['filename'] as $key => $value) {
           $value -> move(public_path().'/posts/', $value->
           getClientOriginalName());
           $url = URL::to("/") . '/posts/' . $value-> getClientOriginalName();
           $imageData = [
            'post_id'=>$post->id,
            'path'=>$url
           ];
           Image::create($imageData);
       }

         
      return redirect('/myPosts')->
        with('response','Post Added Succesfully');
    }

    public function view($post_id,Request $request){
        $authId =Auth::id();
        $comments=new Comment;
        // $comments = $comments->orderBy("id","desc")->with(['likes','dislikes'])->get();
        $users = User::all();  
        $user_perm = Auth::user()->permition;
    	  $posts = Post::where('id','=',$post_id)->with(['comments.user','comments.likes','comments.dislikes','images','comments.childComments'])->first(); 
       // dd ($posts->comments[]);

        foreach ($posts->comments as $key => $comment) {
           $userLiked = 1;
           $userDisLiked = 1;
           $likesCount =$comment->likes->count();
           $dislikesCount =$comment->dislikes->count();
           foreach ($comment->likes as $like) {
               if ($like->user_id ==$authId) {
                   $userLiked = 0;
               }
           }
           foreach ($comment->dislikes as $dislike) {
               if ($dislike->user_id ==$authId) {
                   $userDisLiked = 0;
               }
           }
           // dd()
           $posts->comments[$key]->likesCount =$likesCount;
           $posts->comments[$key]->dislikesCount =$dislikesCount;
           $posts->comments[$key]->userLiked =$userLiked;
           $posts->comments[$key]->userDisLiked =$userDisLiked;
        }
       // dd ($posts->comments);
        if ($posts){
            if ($request->ajax()) {
                // dd(555);
                $dataRend =[
                    'posts'=>$posts,
                ];
                $html = view('posts.comments', $dataRend)->render();
                return response()->json(['success'=>true,'html'=>$html]);
            }else{
                return view('/posts/view',['posts' => $posts,'user_perm' => $user_perm,'users' => $users,'comments' => $comments]);

            }
        }else{
            return abort(404);
        }
    }

    public function edit($post_id){
        $user_id = Auth::id();
        $users = User::all();
    	$post = Post::where('id',$post_id)->where('user_id',$user_id)->first();
         if ($post){
        	return view('/posts/edit',['post' => $post,'users'=>$users]);
        }else{
            return abort(404);
        }
    }

    public function editPost(EditRequest $request,$post_id){
    	
        $data = $request->all();
        $user_id = Auth::id();
        $dataRequest =$request->all();
        $post = Post::where('id',$post_id)->where('user_id',$user_id)->first();
         
           if ($post){
           foreach ($data['filename'] as $key => $value) {
           if($value){
           $value -> move(public_path().'/posts/', $value->
           getClientOriginalName());
           
           $url = URL::to("/") . '/posts/' . $value-> getClientOriginalName();
           $imageData = [
            'post_id'=>$post->id,
            'path'=>$url
           ];
           Image::create($imageData);
           }
       }
                        
        $data = array(
        
            'post_title' => $dataRequest['post_title'],
            'post_description' =>$dataRequest['post_description'] ,
            // 'post_image_2' => $post->post_image_2,
            // 'post_image_3' => $post->post_image_3
        );

        // dd ($request->all());
        Post::where('id',$post_id)
        ->update($data);  
      return redirect('/myPosts')->
        with('response','Post Edited Succesfully');
  
        }else{
            return abort(404);
        }   
    }
    public function deletePost($post_id){
    Post::where('id',$post_id)
    	->delete();
    // Image::where('post_id',$post_id)
    //     ->delete(); 
    // Comment::where('post_id',$post_id)
    // ->delete(); 
          
    	 return redirect('/myPosts')->
    	with('response','Post Deleted Succesfully');
    }

    public function deletePath($id,$post_id){

        $imgCount =Image::where('post_id',$post_id)->count();
        if ($imgCount ==1 ) {
                    return response()->json(['success'=>false]);           
        }else{
          $del=  Image::where('id',$id)
                ->delete();    
                    if ($del) {
                    return response()->json(['success'=>true]);  
                    }       
     }
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
    Comment::where('comment_id',$post_id)
        ->delete();
        return back()->
        with('response','Comment Deleted Succesfully');
    }

    public function addCommentCom(CommentRequest $request,$comment_id){

        $comment = new Comment; 
        $comment ->user_id = Auth::user()->id;
        $comment ->comment_id = $comment_id;
        $comment ->comment = $request -> input('comment');
        $comment->save();
          return back()->
        with('response','Comment Added Succesfully');
    }   

    public function editCommentCom(CommentRequest $request)
        {
          $data = $request->all();
          unset($data['_token']);
          Comment::where('id',$data['id'])->update($data);
        } 

     public function deleteCommentCom($comment_id){
         Comment::where('id',$comment_id)
        ->delete();
         return back()->
        with('response','Comment Deleted Succesfully');
    }    



    public function addLike(Request $request){
        $data = $request->all();
        $user_id = Auth::id();
        $type =$data['type'];
        $like=Post_like_dislike::firstOrNew(["post_id"=>$data['id'],'user_id'=>$user_id]);
        if ($type =='like') {
            if($like->dislike)$like->dislike=0;
        }else{
            if($like->like)$like->like=0;          
        }
        
        $like->$type = $data['liked'];
        if($like->save()){
            return response()->json(['success'=>true]);
        }

    }

    public function addCommentLike(Request $request){

        $data = $request->all();
        $user_id = Auth::id();
        $type =$data['type'];
        $like=CommentLikeDislike::firstOrNew(["comment_id"=>$data['id'],'user_id'=>$user_id]);
        if ($type =='like') {
            if($like->dislike)$like->dislike=0;
        }else{
            if($like->like)$like->like=0;          
        }       
        $like->$type = $data['liked'];
        if($like->save()){
            return response()->json(['success'=>true]);
        }

    }


    public function sendFrienqRequest($id){
       
        Auth::user()->friends()->attach($id);
     
    }   


    public function acceptRequest($id){
        $authId =Auth::id();
        Auth::user()->friends()->attach($id,['accepted'=>1]);
     	User::find($id)->friends()->updateExistingPivot($authId,['accepted' => 1]);
    }   

    public function undoRequest($id){
        $authId =Auth::id();
        Auth::user()->friends()->detach($id);
     	User::find($id)->friends()->detach($authId);
    }    

    public function deleteFriend($id){
       $authId =Auth::id();
       Auth::user()->friends()->detach($id,['accepted'=>0]);
       User::find($id)->friends()->detach($authId);

    }    

    
}
