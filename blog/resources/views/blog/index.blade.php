@extends('layouts.app')

@section('content')

<!-- start blogs section -->
<section class="blogs py-5">
	<div class="container">
		<h2 class="py-3 text-center">Blogs</h2>
		@if(auth::check())
			<a href="blog/create" class="btn btn-primary rounded-2 py-2 m-auto">Create a blog</a>
		@endif
		@if(session()->has('message'))
			<p class="btn btn-success ml-5">{{session()->get('message')}}</p>
		@endif
		<div class="row">
			@foreach($posts as $post)
			<div class="col-md-8 d-flex align-items-center m-auto w-100">
			
				<img src="{{asset('images/'.$post->image)}}" width="300px" height="300px" class="mb-5 mr-auto">
				<div>
				<h2 class="blog-title">{{$post->title}}</h2>
				<p class="blog-deatils text-gray">By <strong>{{$post->user->name}}</strong>{{date('Js M Y')}}</p>
				<p class="blog-description pt-2">{{$post->decription}}</p>
				<a href="blog/{{$post->slug}}" class="btn btn-primary text-white font-weight-bold text-uppercase">read</a>
				@if(isset(Auth::user()->id) && $post->user_id === Auth::user()->id)
					<div class="pl-5 btn btn-group">
						<a href="blog/{{$post->slug}}/edit" class="btn btn-secondary text-white mr-2">Edit &rarr;</a>
						<form action="/blog/{{$post->slug}}" method="POST">
							@csrf
							@method('delete')
							<button type="submit" class="btn btn-danger">Delete</button>
						</form>
					</div>
				</div>
				@endif
			</div>
		</div>

				@endforeach
		</div>
	</div>
</section>
@endsection