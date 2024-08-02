@extends('base')

@section('content')
    <div class="container">
        <div class="alert alert-success" role="alert">
            mypage
        </div>
        <div>
            <p>userid</p>
            <p>{{ Auth::user()->id }}</p>
        </div>
        <div>
            <p>name</p>
            <p>{{ Auth::user()->name }}</p>
        </div>
        <div>
            <p>email</p>
            <p>{{ Auth::user()->email }}</p>
        </div>
    </div>
@endsection
