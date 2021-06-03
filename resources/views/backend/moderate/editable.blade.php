@extends('backend.layout')
@section('content')
<div class="container-resp pt-20">

<h2>{{ $title }}</h2>

<section class="res-element bg-white">

<form action="{{ route('moderate.change', $id) }}" method="POST">
@csrf
@method('POST')
Черновик для утверждения (может изменяться автором):<br />
<input type="text" name="draft_header" value="<?= $advertisement->draft_header ?>" autocomplete="off" placeholder="Заголовок объявления" required><br />
<textarea name="draft_advcontent" placeholder="Текст объявления" required><?= $advertisement->draft_advcontent ?></textarea><br />
<input type="text" name="draft_city" value="<?= $advertisement->draft_city ?>" autocomplete="off" placeholder="Город, район" required><br />
<input type="text" name="draft_phone" value="<?= $advertisement->draft_phone ?>" autocomplete="off" placeholder="Телефон для связи" required><br />
<hr />
Предыдущая версия:<br />
<input type="text" name="header" value="<?= $advertisement->header ?>" placeholder="Заголовок объявления" required><br />
<textarea name="advcontent" placeholder="Заголовок объявления" required><?= nl2br($advertisement->advcontent) ?></textarea><br />
<input type="text" name="city" value="<?= $advertisement->city ?>" autocomplete="off" placeholder="Город, район" required><br />
<input type="text" name="phone" value="<?= $advertisement->phone ?>" autocomplete="off" placeholder="Телефон для связи" required><br />
<input type="number" name="price" value="<?= $advertisement->price ?>" placeholder="Цена в рублях" required><br />
<input type="submit" id="change" value="Изменить" style="display: none;" />
</form>

<form action="{{ route('moderate.destroy', $id) }}" method="POST" onsubmit="if(!confirm('Удалить безвозвратно?')){return false;}">
@csrf
@method('POST')
<input type="submit" id="delete"  value="Удалить" style="display: none;" />
</form>

<form action="{{ route('moderate.upadv', $id) }}" method="POST">
@csrf
@method('POST')
<input type="submit" id="upadv"  value="Поднять" style="display: none;" />
</form>

<form action="{{ route('moderate.onadv', $id) }}" method="POST">
@csrf
@method('POST')
<input type="submit" id="onadv"  value="Поднять" style="display: none;" />
</form>

<form action="{{ route('moderate.offadv', $id) }}" method="POST">
@csrf
@method('POST')
<input type="submit" id="offadv"  value="Поднять" style="display: none;" />
</form>

@if (Session::has('message')) 
<div class="alert">{{ Session::get('message') }}</div>
@endif

 <label for="change">Обновить</label>  
 <label for="delete">Удалить</label>  
 <label for="upadv">Поднять</label>  
<?php if ($advertisement->on_off) { ?>
 <label for="offadv">Отключить показы</label>  
<?php } else { ?>
 <label for="onadv">Включить показы</label>
<?php } ?>
<br /><br />
<a href="<?php echo url('/moderate/'.$id); ?>">Перейти в раздел модерации</a>

</section>


<section class="res-element bg-white">
Поднято:
<?= $advertisement->up_adv ?>
<br />
Обновлено:
<?= $advertisement->updated_at ?>
<br />
Создано:
<?= $advertisement->created_at ?>
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

