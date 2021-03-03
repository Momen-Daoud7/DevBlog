@extends('layouts.app')

@section('content')
<div class="m-auto">
	<div class="container">
		
	<h2 class="py-3">{{$post->title}}</h2>
	<p class="py-3 ">{{$post->description}}</p>
	</div>

</div>

@endsection