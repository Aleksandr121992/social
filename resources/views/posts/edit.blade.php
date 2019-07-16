@extends('layouts.monster')
<style type="text/css">
        .delete{
            width:25px; 
            height:20px; 
            margin:0;
        }

         .path{
            width:80%; 
            margin:0;
     

        }

        
</style>
@section('content')
<input type="hidden" value="{{$post->id}}" id="post_id">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" >
            <div class="card">
                <div class="card-header">Edit Post</div>
                <div class="card-body"> 
                        <form method="POST" action="{{  url('/editPost', array($post->id)) }}" enctype= 
                   'multipart/form-data'>
                        @csrf
                        <div class="form-group row">
                            <label for="post_title" class="col-md-4 col-form-label text-md-right">
                                Edit Title
                            </label>    

                            <div class="col-md-12">
                                <input id="post_title" type="input" class="form-control{{ $errors->has('post_title') ? ' is-invalid' : '' }}" name="post_title" value="{{$post->post_title}}"  autofocus>

                                @if ($errors->has('post_title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('post_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="post_description" class="col-md-6 col-form-label text-md-right">Edit Description</label>

                            <div class="col-md-12">
                                <textarea id="post_description" rows="7" class="form-control{{ $errors->has('post_description') ? ' is-invalid' : '' }}" name="post_description" > {{$post->post_description}}
                                </textarea>

                                @if ($errors->has('post_description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('post_description') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                       
                        <div class="form-group row">     
                             @foreach($post->images as $image)
                             <div class="col-md-6">
                               <div id="img{{$image->id}}">
                                    <img src='{{$image->path}}' class="path" alt="">
                                     <a href='javascript:void(0)' data-id="{{$image->id}}" class="delete_path"><img src="{{ url('images/delete.png')}}" class="delete" alt=""></a> 
                               </div>
                             </div>
                             @endforeach
                         </div> 
                       
                        <div class="form-group row">
                            
                            <label for="filename[]" class="col-md-4 col-form-label text-md-right">{{ __('Add Photo') }}</label>

                            <div class="col-md-12">
                                <input type="hidden" name="filename[]" value="">
                               
                                <input id="filename[]" type="file" class="form-control{{ $errors->has('filename[]') ? ' is-invalid' : '' }}" name="filename[]" multiple>
                                @if ($errors->has('filename[]'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('filename[]') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-0">
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
<div class="modal" id="error_Delete">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h1 class="modal-title" style="color:red;">Error</h1>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
       <h1>You can’t delete the last image</h1>
      </div>

      <!-- Modal footer -->

    </div>
  </div>
</div>
@endsection
