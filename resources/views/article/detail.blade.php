@extends('layout')
@section('title', '投稿記事詳細')
@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <h2>{{ $article->title }}</h2>
    <span>作成日：{{ $article->created_at }}</span>
    <span>更新日：{{ $article->updated_at }}</span>
    <p>{{ $article->content }}</p>

    @if($article->image == null)
      <img src= "/storage/noimage.png" >
    @else
    <img src = "{{ asset( '/storage'.$article->image )}}" >
    @endif
    
  </div>
</div>
@endsection