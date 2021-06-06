@extends('backend.layout')
@section('content')
<div class="container-resp pt-20">

<h2>{{ $title }}</h2>

<section class="res-element bg-white">

@if ($advertisement->status !== 2)
Черновик для утверждения:<br />
Заголовок: {{ $advertisement->draft_header }}<br />
Сообщение:<br /> {{ $advertisement->draft_advcontent }}<br />
Категория: {{ isset($draft_category->name) ? $draft_category->name : '' }}<br />
Город: {{ $advertisement->draft_city }}<br />
Телефон: {{ $advertisement->draft_phone }}<br />
@if ($advertisement->draft_image)
<img src="{{ asset('storage/images/preview/'.$advertisement->draft_image) }}" class="mb-10" />
@endif
<hr />
@endif

@if ($advertisement->status !== 0)
@if ($advertisement->status === 2)
Показывается версия:
@else
Одобренная ранее версия:
@endif
<br />
Заголовок: {{ $advertisement->header }}<br />
Сообщение:<br /> {{ nl2br($advertisement->advcontent) }}<br />
Категория: {{ isset($category->name) ? $category->name : '' }}<br />
Город: {{ $advertisement->city }}<br />
Телефон: {{ $advertisement->phone }}<br />
Адрес: {{ $advertisement->url }}<br />
@if ($advertisement->image)
<img src="{{ asset('storage/images/preview/'.$advertisement->image) }}" class="mb-10" />
@endif
@endif



<form action="{{ route('moderate.approve', $id) }}" method="POST">
@csrf
@method('POST')
<input type="submit" id="approve"  value="Одобрить" style="display: none;" />
</form>

<form action="{{ route('moderate.reject', $id) }}" method="POST">
@csrf
@method('POST')
<input type="submit" id="reject"  value="Удалить" style="display: none;" />
</form>

@if ($advertisement->status === 0)
<div class="alert">Объявление ждет вашего одобрения</div>
@elseif ($advertisement->status === 1)
<div class="alert">Объявление было изменено и ждет вашего одобрения</div>
@elseif ($advertisement->status === 2)
<div class="alert">Объявление одобрено</div>
@elseif ($advertisement->status === 3)
<div class="alert">Объявление отклонено</div>
@endif


@if (Session::has('message')) 
<div class="alert">{{ Session::get('message') }}</div>
@endif

<label for="approve">Одобрить</label> 
<label for="reject">Отклонить</label>
<br /><br />
<a href="{{ url('/myadv/'.$advertisement->id.'/edit/') }}">Редактировать, как автор</a>

</section>

<section class="res-element bg-white">
Поднято:
{{ $advertisement->up_adv }}
<br />
Обновлено:
{{ $advertisement->updated_at }}
<br />
Создано:
{{ $advertisement->created_at }}
<br />
Статус:
@if ($advertisement->status === 0)
Ждет одобрения впервые (код 0)
@elseif ($advertisement->status === 1)
Ждет одобрения (код 1)
@elseif ($advertisement->status === 2)
Одобрено (код 2)
@elseif ($advertisement->status === 3)
Отклонено (код 3)
@endif
<br />
@if ($advertisement->on_off === 0)
Отключено
@elseif ($advertisement->on_off === 1)
Включено
@endif
</section>

</div>
@endsection

