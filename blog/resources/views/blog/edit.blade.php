@extends('layouts.app')

@section('content')
<div class="create-blog">
	<div class="container">
	<h2 class="text-center font-weight-bold py-3">Create a blog</h2>
	<img src="{{asset('images/'.$post->image)}}" width="300px" height="300px">
	<form action="/blog/{{$post->slug}}" enctype="mulutipart/form-data" method="POST">
		@csrf
		@method('PUT')
		<input type="text" name="title" value ="{{$post->title}}"class="form-control mb-2 font-weight-bold">
		<textarea name="description" class="form-control input-lg font-weight-bold mb-2">{{$post->description}}</textarea>
		<label id="image" class="btn btn-primary my-3 mr-2 ">
			<span>Select image</span>
			<input type="file" name="image" class="d-none">
		</label>
		<button class="btn btn-success" type="submit">Submit</button>
	</form>
	@if($errors->any())
		@foreach($errors->all() as $error)
			<ul class="list-unstyled">
				<li class="font-weight-bold text-danger">
					{{$error}}
				</li>
			</ul>
		@endforeach
	@endif
</div>
</div>
@endsection