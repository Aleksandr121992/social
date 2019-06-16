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

        .col-md-8{
           margin:20px auto; 
        }

        .li{
          margin:0 5px;  
        }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
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
                <div class="card-header">Home Page</div>

                <div class="card-body">
                    

                    <div class="col-md-8">
                        @if($user->posts)
                            @foreach($user->posts as $post)
                                  
                                    <h4>{{$post->post_title}}</h4>
                                    <img src='{{$post->post_image}}' class="img" alt="">
                                    <p>{{substr($post->post_description , 0 ,190)}}</p>

                                    <ul class="nav nav-pills">
                                         <li class="li">
                                           
                                            <a href='{{url("/view/{$post->id}")}}'>
                                                <span>VIEW</span>
                                            </a>
                                        </li>
                                        <li class="li">
                                            <a href='{{url("/edit/{$post->id}")}}'>
                                                <span>EDIT</span>
                                            </a>
                                        </li>
                                        <li class="li">
                                            <a href='{{url("/delete/{$post->id}")}}'>
                                                <span>DELETE</span>
                                            </a>
                                        </li>
                                    </ul>
                                
                            @endforeach
                              @else
                                <p>No Post Availible</p>
                         @endif
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
