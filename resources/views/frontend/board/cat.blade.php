@extends('frontend.layout')
@section('content')

<div class="container-resp pt-20">
<h2>{{ $category->name }}</h2>
<div class="res-container">
@foreach ($advertisements as $advertisement)
<section class="res-element bg-white">
<a href="{{ url('/adv/'.$advertisement->url) }}">
@if ($advertisement->image)
<img src="{{ asset('storage/images/preview/'.$advertisement->image) }}" class="res-container__img_center">
@else
<img src="{{ asset('storage/images/preview/placeholder.jpg') }}" class="res-container__img_center">
@endif
</a>
<a href="{{ url('/adv/'.$advertisement->url) }}"><h2>{{ $advertisement->header }}</h2></a>
Автор: <a href="{{ url('/user/'.$advertisement->author_id) }}">{{ $advertisement->author_name }}</a><br />
</section>
@endforeach
</div>

{{ $advertisements->links('frontend.pagination') }}
</div>

@endsection