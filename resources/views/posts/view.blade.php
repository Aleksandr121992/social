@extends('layouts.monster')


<style type="text/css">
        

        .img{
           max-width:400px;  
        }

        .col-md-8{
           margin:20px auto; 
        }

        .panel, .flip {
          padding: 5px;
          text-align: center;
        }

        .panel {
          padding: 10px;
          padding-left: 50px;
          display: none;
          background-color: #F2F7F8;
          border-radius: 10px;
        }
        
        .flip {
          cursor:pointer;
          height: 40px;
        }

        .panel1, .flip1 {
          padding: 5px;
          text-align: center;
        }

        .panel1 {
          padding: 10px;
          padding-left: 50px;
          display: none;
          background-color: #F2F7F8;
          border-radius: 10px;
        }
        
        .flip1 {
          cursor:pointer;
          height: 40px;
        }
        

</style>
@section('content')
<input type="hidden" id="post_id" value="{{$posts->id}}" name="">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
               @if(session('response'))
                    <div class="alert alert-success"> {{session('response')}}</div>
                @endif    
            <div class="card">
                <div class="card-header">Post View</div>
                    <div class="card-body" >
                    <div class="col-md-12">
                        @if($posts)                           
                          <h4>{{$posts->post_title}}</h4>                      
                              @foreach($posts->images as $image)
                                    <img src='{{$image->path}}'  width="400px" class="img" alt="" >      
                              @endforeach
                          <p>{{$posts->post_description}}</p>                          
                        @else 
                            <p>No Post Availible</p>
                        @endif
                        <br>
                            <div class="col-md-12 post_comments">
                                @if($posts->comments)
                                    <div class="card-body">
                                    <h4 class="card-title">Comments</h4>
                                        <div class="chat-box">
                                        <!--chat Row -->
                                        <ul class="chat-list" >
                                            @foreach($posts->comments as $comment)
                                                <li>
                                                    <div class="chat-img">
                                                        <img height="40px" src="{{url('uploads')}}/{{$comment->user->profile_image}}" alt="user" />
                                                    </div>
                                                    <div class="chat-content">
                                                        <h5>{{$comment->user->name}}</h5>
                                                        <div class="box bg-light-info" style="min-width: 80%" id="comment_{{$comment->id}}">{{$comment->comment}}</div>
                                                    </div>
                                                    <div class="chat-time">
                                                        <img id="likeImg{{$comment->id}}" style="cursor: pointer;" class="like addCommentLike"  data-type="like" data-liked="{{$comment->userLiked}}"  data-count="{{$comment->likesCount}}" data-id="{{$comment->id}}"  height="25px" @if($comment->userLiked==0) src='/images/like_2.png' @else src='/images/like_1.png' @endif >
                                                        <span id="likeCount{{$comment->id}}">{{$comment->likesCount}}</span>
                                                        <img id="disLikeImg{{$comment->id}}" style="cursor: pointer;" class="dislike addCommentLike"  data-disliked="{{$comment->userDisLiked}}" data-type="dislike" data-count="{{$comment->dislikesCount}}" data-id="{{$comment->id}}" height="25px" @if($comment->userDisLiked==0) src='/images/dislike_2.png' @else src='/images/dislike_1.png' @endif >
                                                        <span id="disLikeCount{{$comment->id}}">{{$comment->dislikesCount}}</span>
                                                        10:56 am
                                                    </div>
                                                </li>
                                             
                                                @if($comment->user->id == Auth::user()->id)
                                                    <li style="margin-top: 0">
                                                        <a class="comment_edit" data-id="{{$comment->id}}" href="#">
                                                            <img height="30px" src="/images/edit.ico">
                                                        </a>
                                                        <a style="color:red" href='{{url("/deleteComment/{$comment->id}")}}'>
                                                             <img height="30px" src="/images/delete_1.png">
                                                        </a>                                                   
                                                        <img height="30px" data-id="{{$comment->id}}" @if(count
                                                            ($comment->childComments)) class="flip" src="/images/comment.png" @else class="flip1" src='/images/plus.png' style="margin-left:6px" @endif > </li> 
                                                @elseif($posts->user_id  == Auth::user()->id)
                                                    <li style="margin-top: 0">
                                                        <a style="color:red" href='{{url("/deleteComment/{$posts->id}")}}'>
                                                            <img height="30px" src="/images/delete_1.png">
                                                        </a>
                                                            <img height="30px" data-id="{{$comment->id}}" @if(count
                                                                ($comment->childComments)) class="flip" src="/images/comment.png" @else class="flip1" src='/images/plus.png' style="margin-left:6px" @endif >
                                                    </li>
                                                    @else
                                                        <img height="30px" data-id="{{$comment->id}}"  @if(count
                                                        ($comment->childComments)) class="flip" src="/images/comment.png" @else class="flip1"  src='/images/plus.png' style="margin-left:6px" @endif >     
                                                    @endif
                                                   @if(count($comment->childComments))         
                                                      <div class="panel{{$comment->id}}  panel" style="display: none">
                                                        @foreach($comment->childComments as $childComment)
                                                            <div class="row">
                                                                <img style="margin-left:0;border-radius:100%;height: 30px;width: 30px" height="40px" src="{{url('uploads')}}/{{$childComment->user->profile_image}}" alt="user" />
                                                                <h6 style="margin-left: 10px">{{$childComment->user->name}}</h6>
                                                                <p style="margin-left: 20px" id="childComment_{{$childComment->id}}">{{$childComment->comment}}</p>  
                                                        @if($childComment->user_id  == Auth::user()->id)   
                                                            <a class="commentCom_edit" data-id="{{$childComment->id}}" href="#">
                                                                <img height="30px" src="/images/edit.ico">
                                                            </a>
                                                            <a style="color:red" href='{{url("/deleteCommentCom/{$childComment->id}")}}'>
                                                                 <img height="30px" src="/images/delete_1.png">
                                                            </a>                                                      
                                                        @elseif($posts->user_id == Auth::user()->id || 
                                                         ($comment->id == $childComment->comment_id) &&
                                                          ($comment->user_id  == Auth::user()->id))
                                                        
                                                            <a style="color:red" href='{{url("/deleteCommentCom/{$childComment->id}")}}'>
                                                                <img height="30px" src="/images/delete_1.png">
                                                            </a>  
                                                        @endif
                                                         </div>   
                                                        @endforeach 

                                                         
                                                            <form method="POST" action='{{url("/addCommentCom/{$comment->id}")}}'>
                                                                  @csrf
                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <textarea id="commentCom"   class="form-control b-0" name="comment" placeholder="Type your Comment " required ></textarea>     
                                                                </div>
                                                                <div class="col-4 text-right">        
                                                                    <button type="submit" class="btn btn-info btn-circle btn-lg">
                                                                        <i class="fa fa-paper-plane-o"></i> 
                                                                    </button>                    
                                                                </div>
                                                            </div>
                                                            </form>
                                                               


                                                       </div>
                                                    
                                                    @else
                                                        <div class="panel1{{$comment->id}} row panel1" style="display: none">
                                                            <form method="POST" action='{{url("/addCommentCom/{$comment->id}")}}'>
                                                                  @csrf
                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <textarea id="commentCom"   class="form-control b-0" name="comment" placeholder="Type your Comment " required ></textarea>     
                                                                </div>
                                                                <div class="col-4 text-right">        
                                                                    <button type="submit" class="btn btn-info btn-circle btn-lg">
                                                                        <i class="fa fa-paper-plane-o"></i> 
                                                                    </button>                    
                                                                </div>
                                                            </div>
                                                            </form>
                                                        </div>         
                                                    @endif
                                             
                                            @endforeach 
                                        
                                        </ul>
                                    </div>
                                </div>        
                                @else
                                    <p style="color:blue;">No Comment Availible</p>
                                @endif
                            </div>
                        <form method="POST" action= '{{url("/comment/{$posts->id}")}}'>
                            @csrf
                            <div class="row">
                                  <div class="col-8" >
                                        <textarea id="comment"   class="form-control b-0" name="comment" placeholder="Type your Comment here" required ></textarea>     
                                     </div>
                                    <div class="col-4 text-right">        
                                        <button type="submit" class="btn btn-info btn-circle btn-lg"><i class="fa fa-paper-plane-o"></i> 
                                        </button>                    
                                    </div>
                                </div>                 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

      

<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>


<div class="modal" id="Comment_Edit_Modal" style="z-index: 1500">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Comment</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="col-md-6">
        <textarea id="edit_comment"  style="width:330px"  class="form-control" rows="5">
          
        </textarea>
          <span class="invalid-feedback " id="errorTxt"role="alert">
             
          </span>
      </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-id="id"   id="edit_comment_Changes">Edit</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>


<div class="modal" id="CommentCom_Edit_Modal" style="z-index: 1500">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Comment</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="col-md-6">
        <textarea id="edit_commentCom" style="width:330px" class="form-control" rows="5">
          
        </textarea>
          <span class="invalid-feedback " id="errorTxt"role="alert">
             
          </span>
      </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-id="id"   id="edit_commentCom_Changes">Edit</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- <script type="text/javascript">
$( document ).ready(function() {
    var id = $('#post_id').val()
    setInterval(function(){ 
        $.ajax({
            method:'get',
            url: "/view/"+id,
            // data:{id:id,comment:comment},
            success: function(result){
           $('.post_comments').html(result.html)
        },
        error: function(xhr, status, error) {
        }
    });
    }, 10000);
    });

</script> -->

    <script src="/js/posts.js"></script>

@endsection
