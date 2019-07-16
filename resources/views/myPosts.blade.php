@extends('layouts.monster')

@section('content')
  
            <div class="row"> 
                @if($authUser->posts)
                    @foreach($authUser->posts as $post)
                        <div class="col-md-4">
                            <div class="card">
                                     <img class="myImg"  src='{{$post->images[0]->path}}' height="200px">
                                <div class="card-body">
                                    <ul class="list-inline font-14">
                                        <li class="p-l-0">20 May 2016</li>
                                        <li><a href="javascript:void(0)" class="link">3 Comment</a></li>
                                    </ul>
                                    <h3 class="font-normal">{{$post->post_title}}</h3>
                                    <div style="height:30px">
                                        <p class="m-b-0 m-t-10">{{substr($post->post_description , 0 ,66)}}</p>
                                    </div>
                                    <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20">
                                      <a href='{{url("/view/{$post->id}")}}' style="color:white">View</a>
                                    </button>
                                    <button class="btn btn-info btn-rounded waves-effect waves-light m-t-20">
                                      <a href='{{url("/edit/{$post->id}")}}' style="color:white">Edit</a>
                                    </button>
                                    <button class="btn btn-danger btn-rounded waves-effect waves-light m-t-20">
                                      <a href='{{url("/delete/{$post->id}")}}' style="color:white">Delete</a>
                                    </button>
                                </div>
                            </div>
                        </div>    
                        <br><br>
                    @endforeach
                @else
                    <p>No Post Availible</p>
                @endif   
            </div>
           
@endsection
