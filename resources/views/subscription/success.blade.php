@extends('layouts.app')

@section('content')
<div class="container pt-5 text-center">
    <h1>有料会員登録完了</h1>
    <p>Stripeでの決済が完了しました。ご登録ありがとうございます！</p>
    <div class="text-center">
                 <a class="fw-bold" href="{{ route('users.mypage') }}">
                マイページに戻る
                </a>
    </div>
@endsection
