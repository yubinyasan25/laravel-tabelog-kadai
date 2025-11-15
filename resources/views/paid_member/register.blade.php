@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <h1 class="mb-4">有料会員登録</h1>

            <p class="text-muted mb-4">
                月額300円のプレミアム会員サービスに登録するため、決済ページへ進みます。
            </p>

            {{-- 成功・エラーメッセージ --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <hr class="mb-4">

            {{-- Checkout セッション作成 --}}
            <form action="{{ route('paid.session') }}" method="POST">
                @csrf
                <button type="submit" class="btn samuraimart-submit-button w-100 text-white mb-4">
                    決済画面へ進む
                </button>
            </form>

            <hr class="mb-4">

            <div class="text-center">
                <a class="fw-bold" href="{{ route('users.mypage') }}">
                    マイページに戻る
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
