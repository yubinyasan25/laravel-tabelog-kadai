@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">

        {{-- 左側カテゴリサイドバー --}}
        <div class="col-md-3 mb-4">
            <div class="card p-3 shadow-sm">
                
                <ul class="list-unstyled mb-0">
                    @foreach($categories as $category)
                        <li class="mb-2">
                            <a href="{{ route('stores.index', ['category' => $category->id]) }}"
                               class="d-flex align-items-center justify-content-center text-decoration-none text-dark rounded shadow-sm category-item">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- 右側店舗一覧 --}}
        <div class="col-md-9">
            <h1 class="mb-4">店舗一覧</h1>
            <div class="row">
                @forelse($stores as $store)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            @if($store->image)
                                <img src="{{ asset('storage/' . $store->image) }}"
                                     alt="{{ $store->name }}"
                                     class="card-img-top"
                                     style="height:200px; object-fit:cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $store->name }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($store->description, 60, '...') }}</p>
                                <a href="{{ route('stores.show', $store->id) }}"
                                   class="btn btn-warning btn-sm text-dark fw-semibold">
                                    詳細を見る
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>現在、店舗はありません。</p>
                @endforelse
            </div>
        </div>

    </div>
</div>

{{-- カテゴリリンクのスタイル（トップ画面と同じオレンジ枠線） --}}
<style>
    .category-item {
        height: 35px;
        background-color: #fff8e1;
        font-weight: 600;
        font-size: 0.9rem;
        border: 2px solid orange; /* オレンジ枠線 */
        text-align: center;
        line-height: 31px; /* 高さに合わせて文字を中央揃え */
        transition: background-color 0.2s, border-color 0.2s;
    }

    /* ホバー時に少し濃いオレンジに */
    .category-item:hover {
        background-color: #fff3d6;
        border-color: darkorange;
        text-decoration: none;
    }
</style>
@endsection
