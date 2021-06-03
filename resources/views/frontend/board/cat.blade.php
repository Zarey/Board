@extends('frontend.layout')
@section('content')

<div class="container-resp pt-20">
<h2><?php echo $category->name ?></h2>
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

@endsection