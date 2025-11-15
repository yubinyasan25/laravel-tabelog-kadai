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

            {{-- 有料会員情報 --}}
            <div class="container">
                <div class="row justify-content-between align-items-center py-4 samuraimart-mypage-link">
                    <div class="col-1 ps-0 me-3"><i class="fas fa-star fa-3x"></i></div>
                    <div class="col-9 d-flex flex-column">
                        <h3 class="mb-0">有料会員情報</h3>

                        @if(auth()->user()->is_paid_member)
                            <p class="mb-0 text-success">あなたは有料会員です。</p>

                            {{-- 有料会員解除ボタン（モーダル表示） --}}
                            <button type="button" class="btn btn-danger w-100 mt-2" data-bs-toggle="modal" data-bs-target="#cancelModal">
                                有料会員を解除する
                            </button>

                            {{-- モーダル --}}
                            <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="cancelModalLabel">有料会員解除の確認</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                                  </div>
                                  <div class="modal-body">
                                    本当に有料会員を解除しますか？
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                    <form method="POST" action="{{ route('paid.cancel') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">解除する</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>

                        @else
                            <a href="{{ route('paid.register') }}" 
                               class="btn samuraimart-submit-button w-100 text-white mt-2">
                                月額300円で有料会員になる
                            </a>
                        @endif
                    </div>
                    <div class="col text-end"><i class="fas fa-chevron-right fa-2x text-secondary"></i></div>
                </div>
            </div>

            <hr class="my-0">

            {{-- 有料会員のみ表示 --}}
            @if(auth()->user()->is_paid_member)

                {{-- 予約一覧 --}}
                <div class="container">
                    <a href="{{ route('reservations.index') }}" class="link-dark">
                        <div class="row justify-content-between align-items-center py-4 samuraimart-mypage-link">
                            <div class="col-1 ps-0 me-3"><i class="fas fa-calendar-check fa-3x"></i></div>
                            <div class="col-9 d-flex flex-column">
                                <h3 class="mb-0">予約一覧</h3>
                                <p class="mb-0 text-secondary">過去と今の予約状況を確認できます</p>
                            </div>
                            <div class="col text-end"><i class="fas fa-chevron-right fa-2x text-secondary"></i></div>
                        </div>
                    </a>
                </div>

                <hr class="my-0">

                {{-- お気に入り一覧 --}}
                <div class="container">
                    <a href="{{ route('favorites.index') }}" class="link-dark">
                        <div class="row justify-content-between align-items-center py-4 samuraimart-mypage-link">
                            <div class="col-1 ps-0 me-3"><i class="fas fa-heart fa-3x"></i></div>
                            <div class="col-9 d-flex flex-column">
                                <h3 class="mb-0">お気に入り一覧</h3>
                                <p class="mb-0 text-secondary">あなたのお気に入り店舗を確認できます</p>
                            </div>
                            <div class="col text-end"><i class="fas fa-chevron-right fa-2x text-secondary"></i></div>
                        </div>
                    </a>
                </div>

                <hr class="my-0">

            @endif

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
