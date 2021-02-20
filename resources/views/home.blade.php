@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ url('/article/index') }}"><h2>ようこそ、{{ Auth::user()->name }}さん</h2></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
