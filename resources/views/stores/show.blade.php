@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- 左上に前のページリンク --}}
    <div class="mb-2">
        <a href="{{ url()->previous() }}" style="color:#2ecc71; text-decoration:none;">
            ← 前のページに戻る
        </a>
    </div>

    <div class="row">

        {{-- 右側店舗詳細 --}}
        <div class="col-md-9">
            <div class="card shadow-sm p-4">

                {{-- 店舗名上の横並びボタン（お気に入りなど） --}}
                <div class="d-flex align-items-center mb-3">
                    @auth
                        @if(auth()->user()->is_paid)
                            <button class="favorite-btn btn {{ auth()->user()->favorite_stores->contains($store->id) ? 'btn-outline-secondary' : 'btn-danger' }}"
                                    data-store-id="{{ $store->id }}">
                                {{ auth()->user()->favorite_stores->contains($store->id) ? '❤️ お気に入り解除' : '🤍 お気に入り追加' }}
                            </button>
                        @endif
                    @endauth
                </div>

                {{-- 店舗名 --}}
                <h2 class="mb-3">{{ $store->name }}</h2>

                {{-- 住所 --}}
                <p class="text-muted mb-3">{{ $store->address }}</p>

                {{-- 店舗画像とレビュー一覧を横並び --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <img src="{{ $store->image_url }}"  
                             alt="{{ $store->name }}" 
                             class="img-fluid rounded" style="width:100%; height:auto; object-fit:cover;">
                        <p class="mt-2">{{ $store->description }}</p>
                    </div>
                    <div class="col-md-8">
                        <h4>レビュー一覧</h4>
                        @forelse($store->reviews as $review)
                            <div class="border p-2 mb-2">
                                <strong>{{ $review->user->name }}</strong>：{{ $review->comment }}
                                @can('update', $review)
                                    <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-sm btn-primary ms-2 custom-btn-sm">編集</a>
                                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-secondary custom-btn-sm">削除</button>
                                    </form>
                                @endcan
                            </div>
                        @empty
                            <p>まだレビューはありません。</p>
                        @endforelse
                    </div>
                </div>

                <hr>

                {{-- 予約フォームとレビュー投稿フォームを横並び --}}
                <div class="row">
                    {{-- 予約フォーム --}}
                    <div class="col-md-6">
                        <h4>予約フォーム</h4>
                        @auth
                            @if(auth()->user()->is_paid)
                                <form action="{{ route('stores.reserve', $store->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">日付</label>
                                        <input type="date" name="reservation_date" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">時間</label>
                                        <select name="reservation_time" class="form-select" required>
                                            <option value="">選択してください</option>
                                            @for($h = 11; $h <= 22; $h++)
                                                <option value="{{ sprintf('%02d:00', $h) }}">{{ sprintf('%02d:00', $h) }}</option>
                                                @if ($h < 22)
                                                    <option value="{{ sprintf('%02d:30', $h) }}">{{ sprintf('%02d:30', $h) }}</option>
                                                @endif
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">人数</label>
                                        <select name="people" class="form-select" required>
                                            <option value="">選択してください</option>
                                            @for ($i = 1; $i <= 20; $i++)
                                                <option value="{{ $i }}">{{ $i }}名</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary custom-btn mb-3">予約する</button>
                                </form>
                            @else
                                <p class="text-muted">
                                    予約をするには
                                    <a href="{{ route('paid.register') }}" style="color:#2ecc71; text-decoration:none;">有料会員登録</a>
                                    が必要です。
                                </p>
                            @endif
                        @else
                            <p class="text-muted">
                                予約をするには 
                                <a href="{{ route('login') }}" style="color:#2ecc71; text-decoration:none;">ログイン後、有料会員登録</a>
                                が必要です。
                            </p>
                        @endauth
                    </div>

                    {{-- レビュー投稿フォーム --}}
                    <div class="col-md-6">
                        <h4>レビュー投稿</h4>
                        @auth
                            @if(auth()->user()->is_paid)
                                <form action="{{ route('reviews.store', $store->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">コメント</label>
                                        <textarea name="comment" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success custom-btn mb-3">投稿する</button>
                                </form>
                            @else
                                <p class="text-muted">
                                    レビューを投稿するには
                                    <a href="{{ route('paid.register') }}" style="color:#2ecc71; text-decoration:none;">有料会員登録</a>
                                    が必要です。
                                </p>
                            @endif
                        @else
                            <p class="text-muted">
                                レビューを投稿するには 
                                <a href="{{ route('login') }}" style="color:#2ecc71; text-decoration:none;">ログイン後、有料会員登録</a>
                                が必要です。
                            </p>
                        @endauth
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- JSでお気に入り切替 --}}
@auth
@if(auth()->user()->is_paid)
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.favorite-btn').forEach(button => {
        button.addEventListener('click', function() {
            const storeId = this.dataset.storeId;
            fetch(`/stores/${storeId}/favorite`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'added') {
                    this.textContent = '❤️ お気に入り解除';
                    this.classList.remove('btn-danger');
                    this.classList.add('btn-outline-secondary');
                } else {
                    this.textContent = '🤍 お気に入り追加';
                    this.classList.remove('btn-outline-secondary');
                    this.classList.add('btn-danger');
                }
            });
        });
    });
});
</script>
@endif
@endauth

{{-- 共通スタイル --}}
<style>
.category-item {
    height: 35px;
    background-color: #fff8e1;
    font-weight: 600;
    font-size: 0.9rem;
    border: 2px solid orange;
    text-align: center;
    line-height: 31px;
    transition: background-color 0.2s, border-color 0.2s;
}

.category-item:hover {
    background-color: #fff3d6;
    border-color: darkorange;
    text-decoration: none;
}

.custom-btn {
    height: 38px !important;
    line-height: 38px !important;
    padding: 0 16px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 1rem !important;
}

.custom-btn-sm {
    height: 30px !important;
    line-height: 30px !important;
    padding: 0 10px !important;
    font-size: 0.8rem;
}
</style>
@endsection
