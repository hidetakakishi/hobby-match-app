@extends('base')

@section('content')
    <div class="container">
        <div class="alert alert-success" role="alert">
            {{ $email }}にパスワード変更用のメールを送信しました。メールを確認して、パスワードを変更してください。
        </div>
    </div>
@endsection