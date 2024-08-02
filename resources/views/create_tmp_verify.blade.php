@extends('base')

@section('content')
    <div class="container">
        <div class="alert alert-success" role="alert">
            {{ $email }}に確認用のメールを送信しました。メールを確認して、アカウントを有効化してください。
        </div>
    </div>
@endsection