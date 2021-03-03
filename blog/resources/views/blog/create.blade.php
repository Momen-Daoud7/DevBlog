@extends('layouts.app')

@section('content')
<div class="create-blog">
	<div class="container">
		<h2 class="text-center font-weight-bold py-3">Create a blog post</h2>
		<form action="/blog" enctype="multipart/form-data" method="POST">
			@csrf
			<input type="text" name="title" placeholder="Title..." class="form-control mb-2 font-weight-bold">
			<textarea placeholder="Description......" name="description" class="form-control input-lg mb-2 font-weight-bold"></textarea>
			<label id="image" class="btn btn-primary my-2">
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