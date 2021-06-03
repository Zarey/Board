@extends('backend.layout')
@section('content')

@if (Session::has('message')) 
<div class="alert">{{ Session::get('message') }}</div>
@endif


<div class="container-resp pt-20">
<h2>{{ $title }} - {{ $count }}</h2>
<?php foreach ($advertisements as $advertisement) { ?>
<section class="res-element bg-white">
<h2><?php echo $advertisement->draft_header; ?></h2>
<a href="<?php echo url('/moderate/'.$advertisement->id); ?>">Модерировать</a> | 
<a href="<?php echo url('/myadv/'.$advertisement->id.'/edit/'); ?>">Редактировать, как автор</a>
<br />Автор: <a href="<?php echo url('/user/'.$advertisement->author_id); ?>"><?php echo $advertisement->author_name ?></a> (в дальнейшем из админки автора выдавать с данными о нем)
</section>
<?php } ?>

{{ $advertisements->links('backend.pagination') }}
</div>

@endsection

<?php 
// echo"<xmp>";print_r($advertisements);echo"</xmp>";  
?>