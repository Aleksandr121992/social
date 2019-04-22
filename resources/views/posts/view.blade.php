@extends('layouts.app')
<style type="text/css">
        

        .img{
           max-width:400px;  
        }

        .col-md-8{
           margin:20px auto; 
        }

</style>
@section('content')
<div class="container">

    <div class="row justify-content-center">
      


        <div class="col-md-8">
               @if(session('response'))
                    <div class="alert alert-success"> {{session('response')}}</div>
                @endif    
            <div class="card">
                <div class="card-header">Post View</div>

                <div class="card-body">

                    <div class="col-md-8">
                        @if(count($posts)>0)
                            @foreach($posts->all() as $post)
                                <h4>{{$post->post_title}}</h4>
                                <img src='{{$post->post_image}}' class="img" alt="">
                                <img src='{{$post->post_image_2}}' class="img" alt="">
                                <img src='{{$post->post_image_3}}' class="img" alt="">
                                <p>{{$post->post_description}}</p>

                            @endforeach  
                        @else 
                            <p>No Post Availible</p>
                         @endif
                            <div class="col-md-12">
                                 @if(count($comments)>0)
                                 <h3>Comments</h3>
                                        <table class="table">
                                            <tr>
                                                <th>Name</th>
                                                <th>Comment</th>
                                                <th></th>
                                            </tr>
                                        @if($user_perm == 1)
                                             @foreach($comments->all() as $comment)
                                             <tr>
                                                  <td><span style="color:blue">{{$comment->name}}</span></td>
                                                  <td id="comment_{{$comment->id}}">{{$comment->comment}}</td>
                                                      <td>
                                                          <a class="comment_edit" data-id="{{$comment->id}}" href="#">Edit</a>/
                                                          <a style="color:red" href='{{url("/deleteComment/{$comment->id}")}}'>Delete</a>
                                                      </td>                         
                                                
                                                  <td></td>
                                              </tr>
                                          @endforeach 

                                        @else
                                          @foreach($comments->all() as $comment)
                                             <tr>
                                                  <td><span style="color:blue">{{$comment->name}}</span></td>
                                                  <td id="comment_{{$comment->id}}">{{$comment->comment}}</td>
                                                  @if($comment -> user_id == Auth::user()->id)
                                                      <td>
                                                          <a class="comment_edit" data-id="{{$comment->id}}" href="#">Edit</a>/
                                                          <a style="color:red" href='{{url("/deleteComment/{$comment->id}")}}'>Delete</a>
                                                      </td>                         
                                                  @elseif($post -> user_id  == Auth::user()->id)
                                                      <td><a style="color:red" href='{{url("/deleteComment/{$post->id}")}}'>Delete</a></td>
                                                  @else
                                                  <td></td>
                                                      
                                                  @endif
                                              </tr>
                                          @endforeach 
                                        @endif
                                        </table>
                                  @else 
                                    <p style="color:blue;">No Comment Availible</p>
                                 @endif
                            </div>
                        <form method="POST" action= '{{url("/comment/{$post->id}")}}'>
                            @csrf
                            <div class="form-group">
                                    <textarea id="comment" rows="5" class="form-control" name="comment"  required> 
                                    </textarea>    
                            </div>
                            <div class="form-group">          
                                    <button type="submit" class="btn btn-success btn-large btn-block">
                                        Add comment
                                    </button>                    
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="Comment_Edit_Modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <textarea id="edit_comment" style="width:400px" rows="5">
           @if(count($comments)>0)
              {{$comment->comment}}
            @endif  
        </textarea>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-id="id"  data-dismiss="modal" id="edit_comment_Changes">Edit</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
@endsection
