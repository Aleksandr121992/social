@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Post</div>
                <div class="card-body"> 
                        <form method="POST" action="{{  url('/addPost') }}" enctype= 
                   'multipart/form-data'>
                        @csrf
                        <div class="form-group row">
                            <label for="post_title" class="col-md-4 col-form-label text-md-right">
                                Add Title
                            </label>    

                            <div class="col-md-6">
                                <input id="post_title" type="input" class="form-control{{ $errors->has('post_title') ? ' is-invalid' : '' }}" name="post_title" value="{{ old('post_title') }}"  autofocus>

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
                                <textarea id="post_description" rows="7" class="form-control {{ $errors->has('post_description') ? ' is-invalid' : '' }}" name="post_description" value="{{ old('post_description') }}" > 
                                </textarea>

                                @if ($errors->has('post_description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('post_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="file" class="col-md-4 col-form-label text-md-right">Choose Image(s)</label>

                            <div class="col-md-6">
                                   <input type="file" name="filename[]" class="form-control">
                             
                        </div>
                        </div>
                        <br>
                  

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-large btn-block">
                                    Add Post
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
