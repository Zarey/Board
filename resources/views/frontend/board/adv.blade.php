@extends('frontend.layout')
@section('content')

<div class="container-resp pt-20">
<section class="res-element bg-white">
<h2><?php echo $advertisement->header ?></h2>
<?php echo nl2br($advertisement->advcontent) ?>
<?php if ($advertisement->image) { ?>
	<img src="<?= asset('storage/images/'.$advertisement->image); ?>">
<?php } ?>


<hr />
Автор: <a href="<?php echo url('/user/'.$advertisement->author_id); ?>"><?php echo $advertisement->author_name ?></a><br />
Телефон: <a href="tel:<?php echo $advertisement->phone ?>"><?php echo $advertisement->phone ?></a><br />
Город: <?php echo $advertisement->city ?><br />
<?php if ($advertisement->price) { ?>
Цена: <?php echo $advertisement->price ?> Руб.
<?php } ?>

<?php if ($advertisement->price && $advertisement->image) { ?>
    <script type="application/ld+json">
      {
        "@context": "https://schema.org/",
        "@type": "Product",
        "name": "<?php echo $advertisement->header ?>",
        "image": [
          "<?= asset('storage/images/'.$advertisement->image); ?>"
         ],
        "description": "<?php echo str_replace(array("\r\n", "\r", "\n"), ' ', $advertisement->advcontent) ?>",
        "offers": {
          "@type": "AggregateOffer",
          "offerCount": "1",
          "lowPrice": "<?php echo $advertisement->price ?>",
          "highPrice": "<?php echo $advertisement->price ?>",
          "priceCurrency": "RUB"
        }
      }
    </script>
<?php } ?>
</section>
</div>


<?php if (Auth::id() == 1) { ?>
<div class="container-resp pt-20">
<section class="res-element bg-white">
			<a target="_blank" href="https://webmaster.yandex.ru/site/https:<?php echo $_SERVER['HTTP_HOST']; ?>:443/indexing/reindex/">Проиндексировать в Яндексе</a><br />
			<a target="_blank" href="https://search.google.com/search-console?hl=ru&resource_id=https://<?php echo $_SERVER['HTTP_HOST']; ?>/">Проиндексировать в Google</a>
			<hr />
			<a target="_blank" href="https://yandex.ru/search/?text=url%3A<?php echo URL::current(); ?>">Проверить индекс в Яндексе</a><br />
			<a target="_blank" href="https://www.google.com/search?q=<?php echo URL::current(); ?>">Проверить индекс в Google</a>
			<br />
			<hr />
			<a target="_blank" href="https://webmaster.yandex.ru/site/https:<?php echo $_SERVER['HTTP_HOST']; ?>:443/indexing/indexing/?page=1&samplesType=event&filters=%7B%22URL%22%3A%5B%7B%22name%22%3A%22TEXT_CONTAINS%22%2C%22value%22%3A%22<?php echo urlencode($_SERVER['REQUEST_URI']); ?>%22%7D%5D%7D">Статистика обхода (Яндекс)</a><br />
			<hr />
			<a target="_blank" href="https://webmaster.yandex.ru/tools/microtest/?url=<?php echo URL::current(); ?>">Проверить структурированные данные в Яндексе</a>
			<br />
			<a target="_blank" href="https://search.google.com/test/rich-results?url=<?php echo URL::current(); ?>">Проверить структурированные данные в Google</a>

</section>
</div>
<?php } ?>




<?php 
// echo"<xmp>";print_r($advertisement);echo"</xmp>"; 
?>




@endsection