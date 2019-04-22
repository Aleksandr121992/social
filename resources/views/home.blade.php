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
                        @if(!empty($profile))
                            <img src="{{ $profile->profile_image}}" class="avatar" alt="">
                        @else   
                            <img src="{{ url('images/avatar.png')}}" class="avatar" alt="">
                        @endif     
                        
                        @if(!empty($profile))
                            <h2>{{$profile->name}}</h2>
                        @else   
                            <p></p>
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
                        @if(count($posts)>0)
                            @foreach($posts->all() as $post)
                                @if($post -> user_id == Auth::user()->id)  
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
                                @endif  
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
