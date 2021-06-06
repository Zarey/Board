@extends('frontend.layout')
@section('content')

<div class="container-resp pt-20">
<section class="res-element bg-white">
<h2>{{ $advertisement->header }}</h2>
{{ nl2br($advertisement->advcontent) }}
@if ($advertisement->image)
	<img src="{{ asset('storage/images/'.$advertisement->image) }}">
@endif


<hr />
Автор: <a href="{{ url('/user/'.$advertisement->author_id) }}">{{ $advertisement->author_name }}</a><br />
Телефон: <a href="tel:{{ $advertisement->phone }}">{{ $advertisement->phone }}</a><br />
Город: {{ $advertisement->city }}<br />
@if ($advertisement->price)
Цена: {{ $advertisement->price }} Руб.
@endif

@if ($advertisement->price && $advertisement->image)
    <script type="application/ld+json">
      {
        "@context": "https://schema.org/",
        "@type": "Product",
        "name": "{{ $advertisement->header }}",
        "image": [
          "{{ asset('storage/images/'.$advertisement->image) }}"
         ],
        "description": "{{ str_replace(array("\r\n", "\r", "\n"), ' ', $advertisement->advcontent) }}",
        "offers": {
          "@type": "AggregateOffer",
          "offerCount": "1",
          "lowPrice": "{{ $advertisement->price }}",
          "highPrice": "{{ $advertisement->price }}",
          "priceCurrency": "RUB"
        }
      }
    </script>
@endif
</section>
</div>


@if (Auth::id() == 1)
<div class="container-resp pt-20">
<section class="res-element bg-white">
			<a target="_blank" href="https://webmaster.yandex.ru/site/https:{{ $_SERVER['HTTP_HOST'] }}:443/indexing/reindex/">Проиндексировать в Яндексе</a><br />
			<a target="_blank" href="https://search.google.com/search-console?hl=ru&resource_id=https://{{ $_SERVER['HTTP_HOST'] }}/">Проиндексировать в Google</a>
			<hr />
			<a target="_blank" href="https://yandex.ru/search/?text=url%3A{{ URL::current() }}">Проверить индекс в Яндексе</a><br />
			<a target="_blank" href="https://www.google.com/search?q={{ URL::current() }}">Проверить индекс в Google</a>
			<br />
			<hr />
			<a target="_blank" href="https://webmaster.yandex.ru/site/https:{{ $_SERVER['HTTP_HOST'] }}:443/indexing/indexing/?page=1&samplesType=event&filters=%7B%22URL%22%3A%5B%7B%22name%22%3A%22TEXT_CONTAINS%22%2C%22value%22%3A%22{{ urlencode($_SERVER['REQUEST_URI']) }}%22%7D%5D%7D">Статистика обхода (Яндекс)</a><br />
			<hr />
			<a target="_blank" href="https://webmaster.yandex.ru/tools/microtest/?url={{ URL::current() }}">Проверить структурированные данные в Яндексе</a>
			<br />
			<a target="_blank" href="https://search.google.com/test/rich-results?url={{ URL::current() }}">Проверить структурированные данные в Google</a>

</section>
</div>
@endif









@endsection