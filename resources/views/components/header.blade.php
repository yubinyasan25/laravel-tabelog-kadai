<header>
    <nav class="navbar navbar-expand-md navbar-light shadow-sm samuraimart-header-container h-auto">
        <div class="container">

            {{-- 🔹 ロゴクリックでトップページへ --}}
            <a class="navbar-brand" href="{{ route('top') }}">
                <img src="{{ asset('img/NAGOYAロゴ.png') }}" alt="トップへ戻る" class="w-25">
            </a>

            {{-- 検索フォーム --}}
            <form action="{{ route('stores.index') }}" method="GET" class="d-flex ms-3">
                <input class="form-control samuraimart-header-search-input me-1" 
                       placeholder="店舗名・キーワードを入力" 
                       name="keyword"
                       value="{{ request('keyword') }}">
                <button type="submit" class="btn samuraimart-header-search-button">
                    <i class="fas fa-search samuraimart-header-search-icon"></i>
                </button>
            </form>

            {{-- ハンバーガーメニュー --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- メニュー --}}
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item me-4">
                            <a class="nav-link fw-bold" href="{{ route('register') }}">新規登録</a>
                        </li>
                        <li class="nav-item me-4">
                            <a class="nav-link fw-bold" href="{{ route('login') }}">ログイン</a>
                        </li>

                        <div class="vr me-4 samuraimart-vertical-bar"></div>

                        <li class="nav-item me-4">
                            <a class="nav-link" href="{{ route('login') }}"><i class="far fa-heart"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-shopping-cart"></i></a>
                        </li>
                    @else
                        <li class="nav-item me-4">
                            <a class="nav-link fw-bold" href="{{ route('mypage') }}">
                                <i class="fas fa-user me-2"></i>マイページ
                            </a>
                        </li>

                        <div class="vr me-4 samuraimart-vertical-bar"></div>

                        <li class="nav-item me-4">
                            <a class="nav-link" href="{{ route('mypage.favorite') }}">
                                <i class="far fa-heart"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('carts.index') }}">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>
