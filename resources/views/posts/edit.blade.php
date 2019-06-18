@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Post</div>
                <div class="card-body"> 
                        <form method="POST" action="{{  url('/editPost', array($post->id)) }}" enctype= 
                   'multipart/form-data'>
                        @csrf
                        <div class="form-group row">
                            <label for="post_title" class="col-md-4 col-form-label text-md-right">
                                Add Title
                            </label>    

                            <div class="col-md-6">
                                <input id="post_title" type="input" class="form-control{{ $errors->has('post_title') ? ' is-invalid' : '' }}" name="post_title" value="{{$post->post_title}}"  autofocus>

                                @if ($errors->has('post_title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('post_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="post_description" class="col-md-4 col-form-label text-md-right">Add Description</label>

                            <div class="col-md-6">
                                <textarea id="post_description" rows="7" class="form-control{{ $errors->has('post_description') ? ' is-invalid' : '' }}" name="post_description" > {{$post->post_description}}
                                </textarea>

                                @if ($errors->has('post_description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('post_description') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                             @if($post->post_image)
                                 <span>Photo_1</span> <img src="{{$post->post_image}}" width="150">
                               
                             @endif

                              @if($post->post_image_2)
                                  <span>Photo_2</span><img src="{{$post->post_image_2}}" width="150">
                               
                             @endif

                              @if($post->post_image_3)
                                 <span>Photo_3</span> <img src="{{$post->post_image_3}}" width="150">
                               
                             @endif
                        <div class="form-group row">
                            
                            <label for="post_image" class="col-md-4 col-form-label text-md-right">{{ __('Choose Photo_1') }}</label>

                            <div class="col-md-6">
                                <input type="hidden" name="post_image" value="{{$post->post_image}}">
                                <input type="hidden" name="post_image_2" value="{{$post->post_image_2}}">
                                <input type="hidden" name="post_image_3" value="{{$post->post_image_3 }}">
                                <input id="post_image" type="file" class="form-control{{ $errors->has('post_image') ? ' is-invalid' : '' }}" name="post_image">
                                @if ($errors->has('post_image'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('post_image') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <label for="post_image_2" class="col-md-4 col-form-label text-md-right">{{ __('Choose Photo_2') }}</label>

                            <div class="col-md-6">
                                <input id="post_image_2" type="file" class="form-control{{ $errors->has('post_image_2') ? ' is-invalid' : '' }}" name="post_image_2"  >
                            </div>

                            <label for="post_image_3" class="col-md-4 col-form-label text-md-right">{{ __('Choose Photo_3') }}</label>

                            <div class="col-md-6">
                                <input id="post_image_3" type="file" class="form-control{{ $errors->has('post_image_3') ? ' is-invalid' : '' }}" name="post_image_3"  >
                            </div>
                        </div>

                       

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-large btn-block">
                                    Edit Post
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
