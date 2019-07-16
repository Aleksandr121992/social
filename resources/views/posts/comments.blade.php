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
                                                        <div class="box bg-light-info">{{$comment->comment}}</div>
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
                                                        @foreach($comment->childComments as $childComment)
                                                            <div class="panel{{$comment->id}} row panel" style="display: none">
                                                                <img style="margin-left:0;border-radius:100%;height: 30px;width: 30px" height="40px" src="{{url('uploads')}}/{{$childComment->user->profile_image}}" alt="user" />
                                                                <h6 style="margin-left: 10px">{{$childComment->user->name}}</h6>
                                                                <p style="margin-left: 20px">{{$childComment->comment}}</p> <br>
                                                                 
                                             <img height="30px" src="/images/edit.ico">  

                                                            </div>                       
                                                        @endforeach       
                                                    @else
                                                        <div class="panel1{{$comment->id}} row panel1" style="display: none">
                                                            <form method="POST" action='{{url("/addCommentCom/{$comment->id}")}}'>
                                                                  @csrf
                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <textarea id="comment"   class="form-control b-0" name="comment" placeholder="Type your Comment" required ></textarea>     
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