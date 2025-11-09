@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
    <h1 class="mb-4 text-success">🎉 有料会員登録が完了しました！</h1>
    <p>これで月額300円のプレミアム会員サービスが利用できます。</p>
    <a href="{{ route('mypage.index') }}" class="btn btn-primary mt-4">マイページへ戻る</a>
</div>
@endsection
