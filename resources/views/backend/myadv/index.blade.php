@extends('backend.layout')
@section('content')

@if (Session::has('message')) 
<div class="container-resp pt-20">
<div class="alert">{{ Session::get('message') }}</div>
</div>
@endif

<div class="container-resp pt-20">
<h2>{{ $title }}</h2>
@foreach ($advertisements as $advertisement)
<section class="res-element bg-white">
<a href="{{ url('/myadv/'.$advertisement->id.'/edit/') }}">
@if ($advertisement->draft_image)
<img src="{{ asset('storage/images/preview/'.$advertisement->draft_image) }}">
@else
<img src="{{ asset('storage/images/preview/placeholder.jpg') }}">
@endif
</a>
<a href="{{ url('/myadv/'.$advertisement->id.'/edit/') }}"><h2>{{ $advertisement->draft_header }}</h2></a>
</section>
@endforeach

{{ $advertisements->links('backend.pagination') }}
</div>

@endsection