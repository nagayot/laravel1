@extends('layout')
@section('title', '記事投稿')
@section('content')
<div class = "row">
    <div class = "col-md-8 col-md-offset-2">
        <h2>記事投稿フォーム</h2>
        <form method = "POST" action = "{{ route('post') }}" onSubmit = "return checkSubmit()" enctype = "multipart/form-data">
            @csrf
            <div class = "form-group">
                <label for = "title">
                    タイトル
                </label>
                <input id = "title" name = "title" class = "form-control" value = "{{ old('title') }}" type = "text">
                @if ($errors->has('title'))
                    <div class = "text-danger">
                        {{ $errors->first('title') }}
                    </div>
                @endif
            </div>

            <div class = "form-group">
                <label for = "image">
                </label>
                <input type = "file" name = "image" class = "form-control-file">
                @if ($errors->has('image'))
                    <div class = "text-danger">
                        {{ $errors->first('image') }}
                    </div>
                @endif
            </div>

            <div class = "form-group">
                <label for = "content">
                    本文
                </label>
                <textarea id = "content" name = "content" class = "form-control" rows = "4"> {{ old('content') }} </textarea>
                @if ($errors->has('content'))
                    <div class = "text-danger">
                        {{ $errors->first('content') }}
                    </div>
                @endif
            </div>

            <div class = "mt-5">
                <a class = "btn btn-secondary" href = "{{ route('articles') }}">
                    キャンセル
                </a>
                <button type = "submit" class = "btn btn-primary">
                    投稿する
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function checkSubmit()
    {
        if(window.confirm('送信してよろしいですか？'))
        {
            return true;
        }else 
        {
            return false;
        }
    }
</script>
@endsection