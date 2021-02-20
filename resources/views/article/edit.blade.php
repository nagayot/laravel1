@extends('layout')
@section('title', '記事編集')
@section('content')
<div class = "row">
    <div class = "col-md-8 col-md-offset-2">
        <h2>記事編集フォーム</h2>
        <form method = "POST" action = "{{ route('update') }}" onSubmit = "return checkSubmit()" enctype = "multipart/form-data">
        @csrf
            <input type = "hidden" name = "id" value = "{{ $article->id }}">

            <div class = "form-group">
                <label for = "title">
                    タイトル
                </label>
                <input id = "title" name = "title" class = "form-control" value = "{{ $article->title }}" type = "text">
                @if ($errors->has('title'))
                    <div class = "text-danger">
                        {{ $errors->first('title') }}
                    </div>
                @endif
            </div>

            <div>
                <label for = "image">
                </label>
                <input type = "file" name = "image" class = "">
                @if ($errors->has('image'))
                    <div class = "text-danger">
                        {{ $errors->first('image') }}
                    </div>
                @endif
            </div>

            <div class = "form-group">
                <label for="content">
                    本文
                </label>
                <textarea id = "content" name = "content" class = "form-control" rows = "4"> {{ $article->content }} </textarea>
                @if ($errors->has('content'))
                    <div class="text-danger">
                        {{ $errors->first('content') }}
                    </div>
                @endif
            </div>

            <div class = "mt-5">
                <a class = "btn btn-secondary" href="{{ route('articles') }}">
                    キャンセル
                </a>
                <button type="submit" class = "btn btn-primary">
                    更新する
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function checkSubmit(){
if(window.confirm('更新しますか？')){
    return true;
} else {
    return false;
}
}
</script>
@endsection