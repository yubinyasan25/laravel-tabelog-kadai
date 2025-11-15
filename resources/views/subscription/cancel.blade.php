@extends('layouts.app')

@section('content')
<div class="container pt-5 text-center">
    <h1>決済がキャンセルされました</h1>
    <p>Stripeでの決済がキャンセルされました。再度登録する場合は下のボタンからどうぞ。</p>
    <a href="{{ route('paid.register') }}" class="btn btn-primary">有料会員登録に戻る</a>
</div>
@endsection
