@extends('layouts.app')

@section('content')
<div class="container pt-5 text-center">
    <h1>有料会員登録完了</h1>
    <p>Stripeでの決済が完了しました。ご登録ありがとうございます！</p>
    <a href="{{ route('users.mypage') }}" class="btn btn-primary">マイページに戻る</a>
</div>
@endsection
