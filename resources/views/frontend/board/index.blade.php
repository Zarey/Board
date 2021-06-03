@extends('frontend.layout')
@section('content')


<div class="container-resp pt-20">
<section class="res-element pb-0 bg-white">
<div class="simple-grid">
<?php foreach ($categories as $category) { ?>
<a class="pb-10" href="<?php echo url('/cat/'.$category->id); ?>">
	<h3><?= $category->name ?></h3>
	<?= $category->description ?></a>
<?php } ?>
</div>
</section>
</div>

<div class="container-resp pt-10 clearfix">
<div class="res-container">
<?php foreach ($advertisements as $advertisement) { ?>
<section class="res-element bg-white">
<a href="<?php echo url('/adv/'.$advertisement->url); ?>">
<?php if ($advertisement->image) { ?>
<img src="<?= asset('storage/images/preview/'.$advertisement->image); ?>" class="res-container__img_center">
<?php } else {?>
<img src="<?= asset('storage/images/preview/placeholder.jpg'); ?>" class="res-container__img_center">
<?php } ?>
</a>
<a href="<?php echo url('/adv/'.$advertisement->url); ?>"><h2><?php echo $advertisement->header; ?></h2></a>
Автор: <a href="<?php echo url('/user/'.$advertisement->author_id); ?>"><?php echo $advertisement->author_name ?></a><br />
</section>
<?php } ?>
</div>

{{ $advertisements->links('frontend.pagination') }}
</div>

<?php if (Auth::id() == 1) { ?>
<div class="container-resp pt-20">
<section class="res-element bg-white">
      <a target="_blank" href="https://webmaster.yandex.ru/tools/robotstxt/?hostName=<?php echo urlencode('https://'.$_SERVER['HTTP_HOST']); ?>">Проверить robots.txt в Яндексе</a>
      <br />
      <a target="_blank" href="https://www.google.com/webmasters/tools/robots-testing-tool?hl=ru&siteUrl=<?php echo urlencode('https://'.$_SERVER['HTTP_HOST']); ?>">Проверить robots.txt в Google</a>
      <hr />
	<a target="_blank" href="https://metrika.yandex.ru/dashboard?id=75130711">Посмотреть метрику</a> | 
	<a target="_blank" href="https://analytics.google.com/analytics/web/#/p268981273/reports/dashboard?r=lifecycle-acquisition-overview">Посмотреть аналитику</a><br />
</section>
</div>
<?php } ?>

@endsection