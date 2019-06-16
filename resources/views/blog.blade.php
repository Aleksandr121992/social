@extends('layouts.app')
<style type="text/css">
        .avatar{
            border-radius:100%;
            width:150px; 
            height:150px; 
        }

        .img{
           max-width:400px;  
        }

        .img_adm{
            max-width:120px;
        }

        .col-md-8{
           margin:20px auto; 
        }

        .li{
          margin:0 5px;  
        }

       .admin{
        width:70px;
       }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
@if($user_perm == 2)
     <div class="col-md-3">
        @if(Auth::user()->profile_image != null)
            <img src="{{url('uploads')}}/{{Auth::user()->profile_image}}" class="avatar" alt=""> 
             <br> 
           <h2 style="margin-left: 25px">{{ Auth::user()->name }} </h2> 
        @else   
            <img src="{{ url('images/avatar.png')}}" class="avatar" alt="">
             <br> 
           <h2 style="margin-left: 25px">{{ Auth::user()->name }} </h2> 

                <form action="/profile" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="file" class="form-control-file" name="profile_image" id="profile_image" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>


        @endif    

         

                    </div> 
@else
     
@endif  
       

                    @if($user_perm == 1)
                                @if(count($posts)>0)
                                  <table class="table table-dark">
                                      <thead>
                                        <tr>
                                          
                                         
                                          <th scope="col">Title</th>
                                          <th scope="col">Description</th>
                                          <th scope="col">Image_1</th>
                                          <th scope="col">Image_2</th>
                                          <th scope="col">Image_3</th>
                                          <th scope="col">Operations</th>
                                        </tr>
                                      </thead>
                                     @foreach($posts->all() as $post)
                                          <tbody>
                                            <tr>   
                                                  
                                                  <td>{{$post->post_title}}</td>
                                                  <td>{{substr($post->post_description , 0 ,190)}}</td>
                                                  <td><img src='{{$post->post_image}}' class="img_adm" alt=""></td>
                                                  <td><img src='{{$post->post_image_2}}' class="img_adm" alt=""></td>
                                                  <td><img src='{{$post->post_image_3}}' class="img_adm" alt=""></td>
                                                  <td>
                                                    <ul class="list-group">
                                                     <li class="list-group-item list-group-item-success">
                                                        <a href='{{url("/view/{$post->id}")}}'>
                                                            <span>View</span>
                                                        </a>
                                                    </li>
                                                    <li class="list-group-item list-group-item-primary">
                                                        <a href='{{url("/edit/{$post->id}")}}'>
                                                            <span>Edit</span>
                                                        </a>
                                                    </li>

                                                     <li class="list-group-item list-group-item-danger">
                                                        <a href='{{url("/delete/{$post->id}")}}'>
                                                            <span>Delete</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                                </td>
                                            </tr>
                                          </tbody>      
                                      @endforeach
                                      </table>
                                  </div>
                                      @else
                                        <p>No Post Availible</p>
                                      @endif
                    @else
                     <div class="col-md-8">
            @if(count($errors)>0)
                @foreach($errors->all() as $errors)
                    <div class="alert alert-danger">{{$error}}
                    </div>
                @endforeach
            @endif
            
            @if(session('response'))
                <div class="alert alert-success">
                {{session('response')}}</div>
            @endif   
                    <div class="card">
                        <div class="card-header">Blog</div>

                        <div class="card-body">
                            

                            <div class="col-md-8">
                                @if(count($posts)>0)

                                    @foreach($posts->all() as $post)
                                            
                                              @foreach($users->all() as $user) 
                                                  @if($user->id == $post->user_id)  
                                                    <span style="color:red;margin-right:15px;">{{$user->name}}</span>
                                                    @endif
                                             @endforeach <h4>
                                                {{$post->post_title}} 
                                            </h4>
                                           
                                            <img src='{{$post->post_image}}' class="img" alt="">
                                            <p>{{substr($post->post_description , 0 ,190)}}</p>

                                            <ul class="nav nav-pills">
                                                 <li class="li">
                                                    <a href='{{url("/view/{$post->id}")}}'>
                                                        <span>View</span>
                                                    </a>
                                                </li>
                                            </ul >
                                            <br>
                                    
                                    @endforeach
                                      @else
                                        <p>No Post Availible</p>
                                 @endif
                            </div>
                        </div>
                    </div>
            @endif
        </div>
    </div>
</div>
@endsection
