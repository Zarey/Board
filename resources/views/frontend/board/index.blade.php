@extends('frontend.layout')
@section('content')


<div class="container-resp pt-20">
<section class="res-element pb-0 bg-white">
<div class="simple-grid">
@foreach ($categories as $category)
<a class="pb-10" href="{{ url('/cat/'.$category->id) }}">
	<h3>{{ $category->name }}</h3>
	{{ $category->description }}</a>
@endforeach
</div>
</section>
</div>

<div class="container-resp pt-10 clearfix">
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

@if (Auth::id() == 1)
<div class="container-resp pt-20">
<section class="res-element bg-white">
      <a target="_blank" href="https://webmaster.yandex.ru/tools/robotstxt/?hostName={{ urlencode('https://'.$_SERVER['HTTP_HOST']) }}">Проверить robots.txt в Яндексе</a>
      <br />
      <a target="_blank" href="https://www.google.com/webmasters/tools/robots-testing-tool?hl=ru&siteUrl={{ urlencode('https://'.$_SERVER['HTTP_HOST']) }}">Проверить robots.txt в Google</a>
      <hr />
	<a target="_blank" href="https://metrika.yandex.ru/dashboard?id=75130711">Посмотреть метрику</a> | 
	<a target="_blank" href="https://analytics.google.com/analytics/web/#/p268981273/reports/dashboard?r=lifecycle-acquisition-overview">Посмотреть аналитику</a><br />
</section>
</div>
@endif

@endsection