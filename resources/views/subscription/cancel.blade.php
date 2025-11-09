@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
    <h1 class="mb-4 text-danger">💡 有料会員を解約しました</h1>
    <p>サービスのご利用ありがとうございました。</p>
    <a href="{{ route('mypage.index') }}" class="btn btn-primary mt-4">マイページへ戻る</a>
</div>
@endsection
