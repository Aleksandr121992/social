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
                        @if($posts)
                           
                                <h4>{{$posts->post_title}}</h4>
                                <img src='{{$posts->post_image}}' class="img" alt="">
                                <img src='{{$posts->post_image_2}}' class="img" alt="">
                                <img src='{{$posts->post_image_3}}' class="img" alt="">
                                <p>{{$posts->post_description}}</p>

                           
                        @else 
                            <p>No Post Availible</p>
                         @endif
                            <div class="col-md-12">
                                 @if($posts->comments)
                                 <h3>Comments</h3>
                                        <table class="table">
                                            <tr>
                                                <th>Name</th>
                                                <th>Comment</th>
                                                <th></th>
                                            </tr>
                                        @if($user_perm == 1)
                                             @foreach($posts->comments as $comment)
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
                                          @foreach($posts->comments as $comment)
                                             <tr>
                                              
                                                  <td><span style="color:blue">{{$comment->user->name}}</span></td>
                                                  <td id="comment_{{$comment->id}}">{{$comment->comment}}</td>
                                             
                                                  @if($comment->user->id == Auth::user()->id)
                                                      <td>
                                                          <a class="comment_edit" data-id="{{$comment->id}}" href="#">Edit</a>/
                                                          <a style="color:red" href='{{url("/deleteComment/{$comment->id}")}}'>Delete</a>
                                                      </td>                         
                                                  @elseif($posts->user_id  == Auth::user()->id)
                                                      <td><a style="color:red" href='{{url("/deleteComment/{$posts->id}")}}'>Delete</a></td>
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
                        <form method="POST" action= '{{url("/comment/{$posts->id}")}}'>
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
        <div class="col-md-6">
        <textarea id="edit_comment" style="width:400px" class="form-control" rows="5">
          
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
@endsection
