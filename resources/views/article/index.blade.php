@extends('layout')
@section('title', '記事一覧')
@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">

    <h2>投稿記事一覧</h2>
      @if (session('err_msg'))
          <p class = "text-danger">{{ session('err_msg') }}</p>
      @endif

      <table class = "table table-striped" id = "all-articles">
        <tr>
            <th>著者ID</th>
            <th>記事番号</th>
            <th>タイトル</th>
            <th>日付</th>
        </tr>
        @foreach($articles as $article)
        <tr>
          <td>{{ $article->user_id }}</td>
          <td>{{ $article->id }}</td>
          <td><a href = "/article/{{ $article->id }}">{{ $article->title }}</a></td>
          <td>{{ $article->updated_at }}</td>
          <td><button type = "button" class = "btn btn-primary" onclick = "location.href = '/article/edit/{{ $article->id }}'">編集</button></td>
          <form method = "POST" action = "{{ route('delete', $article->id) }}" onSubmit = "return checkDelete()" >
            @csrf
            <td><button type = "submit" class = "btn btn-primary">削除</button></td>
          </form>
        </tr>
        @endforeach
      </table>
      <div class = "paginate mt-5 d-flex justify-content-center">
	      {{ $articles->links() }}
      </div>
  </div>
</div>

<script>
  function checkDelete(){
      if(window.confirm('削除しますか？')){
        return true;
      } else {
        return false;
      }
  }
</script>

@endsection


