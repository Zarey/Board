@extends('backend.layout')
@section('content')

@if (Session::has('message')) 
<div class="container-resp pt-20">
<div class="alert">{{ Session::get('message') }}</div>
</div>
@endif

<div class="container-resp pt-20">
<h2>{{ $title }}</h2>
<?php foreach ($advertisements as $advertisement) { ?>
<section class="res-element bg-white">
<a href="<?php echo url('/myadv/'.$advertisement->id.'/edit/'); ?>">
<?php if ($advertisement->draft_image) { ?>
<img src="<?= asset('storage/images/preview/'.$advertisement->draft_image); ?>">
<?php } else {?>
<img src="<?= asset('storage/images/preview/placeholder.jpg'); ?>">
<?php } ?>
</a>
<a href="<?php echo url('/myadv/'.$advertisement->id.'/edit/'); ?>"><h2><?php echo $advertisement->draft_header; ?></h2></a>
</section>
<?php } ?>

{{ $advertisements->links('backend.pagination') }}
</div>

@endsection