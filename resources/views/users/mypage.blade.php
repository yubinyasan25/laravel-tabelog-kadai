@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center mb-4">
        <div class="col-lg-5">
            <h1 class="mb-4">マイページ</h1>

            {{-- 成功メッセージ --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <hr class="my-0">

            {{-- 会員情報の編集 --}}
            <div class="container">
                <a href="{{ route('users.mypage.edit') }}" class="link-dark">
                    <div class="row justify-content-between align-items-center py-4 samuraimart-mypage-link">
                        <div class="col-1 ps-0 me-3"><i class="fas fa-user fa-3x"></i></div>
                        <div class="col-9 d-flex flex-column">
                            <h3 class="mb-0">会員情報の編集</h3>
                            <p class="mb-0 text-secondary">メールアドレスや住所などを変更できます</p>
                        </div>
                        <div class="col text-end"><i class="fas fa-chevron-right fa-2x text-secondary"></i></div>
                    </div>
                </a>
            </div>

            <hr class="my-0">

            {{-- パスワード変更 --}}
            <div class="container">
                <a href="{{ route('mypage.edit_password') }}" class="link-dark">
                    <div class="row justify-content-between align-items-center py-4 samuraimart-mypage-link">
                        <div class="col-1 ps-0 me-3"><i class="fas fa-lock fa-3x"></i></div>
                        <div class="col-9 d-flex flex-column">
                            <h3 class="mb-0">パスワード変更</h3>
                            <p class="mb-0 text-secondary">ログイン時のパスワードを変更します</p>
                        </div>
                        <div class="col text-end"><i class="fas fa-chevron-right fa-2x text-secondary"></i></div>
                    </div>
                </a>
            </div>

            <hr class="my-0">

            {{-- 有料会員 & 既存カード情報 --}}
            <div class="container">
                <div class="row justify-content-between align-items-center py-4 samuraimart-mypage-link">
                    <div class="col-1 ps-0 me-3"><i class="fas fa-star fa-3x"></i></div>
                    <div class="col-9 d-flex flex-column">
                        <h3 class="mb-0">有料会員情報</h3>

                        @if(auth()->user()->is_paid_member)
                            <p class="mb-0 text-success">あなたはすでに有料会員です。</p>

                            {{-- 既存カード情報 --}}
                            @if($card ?? false)
                                <p>カード: {{ strtoupper($card->card->brand) }} **** **** **** {{ $card->card->last4 }}</p>
                                <p>有効期限: {{ $card->card->exp_month }}/{{ $card->card->exp_year }}</p>
                            @else
                                <p>カード情報は登録されていません。</p>
                            @endif

                        @else
                            <a href="{{ route('paid.register') }}" class="btn btn-primary mt-2">
                                月額300円で有料会員になる
                            </a>
                        @endif
                    </div>
                    <div class="col text-end"><i class="fas fa-chevron-right fa-2x text-secondary"></i></div>
                </div>
            </div>

            <hr class="my-0">

            {{-- ログアウト --}}
            <div class="container">
                <a href="{{ route('logout') }}" class="link-dark"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div class="row justify-content-between align-items-center py-4 samuraimart-mypage-link">
                        <div class="col-1 ps-0 me-3"><i class="fas fa-sign-out-alt fa-3x"></i></div>
                        <div class="col-9 d-flex flex-column">
                            <h3 class="mb-0">ログアウト</h3>
                            <p class="mb-0 text-secondary">NAGOYAMESHIからログアウトします</p>
                        </div>
                        <div class="col text-end"><i class="fas fa-chevron-right fa-2x text-secondary"></i></div>
                    </div>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
