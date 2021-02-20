<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ asset('/js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

  <a class = "navbar-brand" href = "#">Laravel課題</a>
  
  <button class = "navbar-toggler" type = "button" data-toggle = "collapse" data-target = "#navbarNavAltMarkup" aria-controls = "navbarNavAltMarkup" aria-expanded = "false" aria-label = "Toggle navigation">
    <span class = "navbar-toggler-icon"></span>
  </button>

  <div class = "collapse navbar-collapse" id="navbarNavAltMarkup">

    <div class = "navbar-nav">
      <a class = "nav-item nav-link active" href = "{{ route('articles') }}">投稿記事一覧
        <span class = "sr-only"></span>
      </a>
      <a class = "nav-item nav-link" href = "{{ route('letter') }}">投稿</a>
    </div>

    <div class = "form-group mt-3">
      <form class = "form-inline my-2 my-lg-0 ml-2">
        <div class = "search-form">
          <input type = "search" class = "form-control mr-sm-2" id = "search-box" name = "keyword" placeholder = "キーワードを入力" value = "">
          <input type = "button" value = "記事を探す" class = "btn btn-info" id = "search-btn">
        </div>
      </form>
    </div>

    <h2 class="nav-item dropdown ml-auto list-unstyled">

      <a class="navbar-brand" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
          {{ __('ログアウト') }}
      </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form>

    </h2>

  </div>
</nav>

<script>
$(function(){
  $('#search-btn').on('click', function(){

    var keyword = $('#search-box').val();

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:'/article/index/'+keyword,
        type:'GET',
        dataType: 'json',
        data:{ keyword: keyword }
    })

    .done(function (data){
      
      var searched = JSON.stringify(data);
      searched = $.parseJSON(searched);
      //console.log(searched);

      $('#all-articles').empty();

      if(searched.data.length === 0){
        $('#all-articles').append(
          '<p >'+'該当する記事がありません。検索し直してください。'+'</p>'
        );
      }

      for(var i = 0; i<searched.data.length; i++){
        $('#all-articles').append(
          '<tr>'+
            '<td>' + searched.data[i].user_id + '</td>' +
            '<td>' + searched.data[i].id + '</td>' +
            '<td>' + '<a href="#">' + searched.data[i].title + '</a>' + '</td>' +
            '<td>' + searched.data[i].created_at + '</td>' +
          '</tr>'
        );
      }
    })

    .fail(function(XMLHttpRequest, textStatus, errorThrown){
        console.log('表示に失敗しました');
        console.log("XMLHttpRequest : " + XMLHttpRequest.status);
        console.log("textStatus     : " + textStatus);
        console.log("errorThrown    : " + errorThrown.message);
    });
  });
});
</script>
