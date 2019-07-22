@extends('layouts.monster')

@section('content')
<div class="container">
	<div class="row justify-content-center">
	  @if($user_perm == 1)
		  @if(count($posts)>0)
			<table class="table table-dark">
				<thead>
				  <tr>
				  	<th scope="col" style="width: 150px">User Name</th>
					<th scope="col">Title</th>
					<th scope="col">Description</th>
					<th scope="col">Operations</th>
				  </tr>
				</thead>
			   @foreach($posts->all() as $post)
					<tbody>
					  <tr>      
					  	<td style="color:red">{{$post->user->name}}</td>
						<td>{{$post->post_title}}</td>
						<td>{{substr($post->post_description , 0 ,190)}}</td>
						
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
		 <div class="col-md-12 ">
			@if(count($errors)>0)
				@foreach($errors->all() as $errors)
					<div class="alert alert-danger">{{$error}} </div>     
				@endforeach
			@endif 
			@if(session('response'))
				<div class="alert alert-success"></div>
				{{session('response')}}
			@endif   
			  <div class="row">
				@if(count($posts)>0)
					@foreach($posts as $post)
							 <div class="col-md-4">
							 	<span style="color:red">{{$post->user->name}}</span>
							  <div class="card">
								  <img class="myImg"  height="180px" src='{{$post->images[0]->path}}' >
								  <div class="card-body">
									  <ul class="list-inline font-14">
									   		
										  <img id="likeImg{{$post->id}}" style="cursor: pointer;" class="like addLike"  data-type="like" data-liked="{{$post->userLiked}}"  data-count="{{$post->likesCount}}" data-id="{{$post->id}}"  height="25px" @if($post->userLiked==0) src='/images/like_2.png' @else src='/images/like_1.png' @endif >
												<span id="likeCount{{$post->id}}">{{$post->likesCount}}</span>
										  <img id="disLikeImg{{$post->id}}" style="cursor: pointer;" class="dislike addLike"  data-disliked="{{$post->userDisLiked}}" data-type="dislike" data-count="{{$post->dislikesCount}}" data-id="{{$post->id}}" height="25px" @if($post->userDisLiked==0) src='/images/dislike_2.png' @else src='/images/dislike_1.png' @endif >
												 <span id="disLikeCount{{$post->id}}">{{$post->dislikesCount}}</span>
										  <li class="p-l-0">{{ date('F d,Y', strtotime($post->updated_at))}}</li>
										  <li><a href="javascript:void(0)" class="link">3 Comment</a></li>
									  </ul>
									  <h3 class="font-normal">{{$post->post_title}}</h3>
									  <div style="height:30px">
										  <p>{{substr($post->post_description , 0 ,66)}}</p>
									  </div>
									  <br>
									  <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20">
										<a href='{{url("/view/{$post->id}")}}' style="color:white">View</a>
									  </button>
								  </div>
							  </div>
						</div>
					@endforeach
				@else
				  <p>No Post Availible</p>
				@endif
			</div>             
			@endif
	   </div>
	</div> 

  <br />
  <div class="container box">
   <h3 align="center">Live search in laravel using AJAX</h3><br />
   <div class="panel panel-default">
    <div class="panel-heading">Search Customer Data</div>
    <div class="panel-body">
     <div class="form-group">
      <input type="text" name="search" id="search" class="form-control" placeholder="Search Customer Data" />
     </div>
     <div class="table-responsive">
      <h3 align="center">Total Data : <span id="total_records"></span></h3>
      <table class="table table-striped table-bordered">
       <thead>
        <tr>
         <th>Title</th>
         <th>Description</th>
        </tr>
       </thead>
       <tbody>

       </tbody>
      </table>
     </div>
    </div>    
   </div>
  </div>
 </body>
</html>


</body>

					
<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>
			  
	 
@endsection
