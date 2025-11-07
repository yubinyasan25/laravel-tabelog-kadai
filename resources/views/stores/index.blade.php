@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">店舗一覧</h1>

    {{-- カテゴリ一覧 --}}
    @isset($categories)
        <div class="d-flex flex-wrap justify-content-start gap-3 mx-auto mb-4" style="max-width: 900px;">
            @foreach($categories as $category)
                <a href="{{ route('stores.index', ['category' => $category->id]) }}"
                   class="d-flex align-items-center justify-content-center text-decoration-none text-dark border border-warning rounded shadow-sm"
                   style="width: 160px; height: 35px; background-color: #fff8e1; font-weight: 600; font-size: 0.9rem;">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    @endisset

    <hr>

    {{-- 店舗一覧カード --}}
    @isset($stores)
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
                            <a href="{{ route('stores.show', $store->id) }}" class="btn btn-warning btn-sm text-dark fw-semibold">
                                詳細を見る
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p>現在、店舗はありません。</p>
            @endforelse
        </div>
    @endisset
</div>
@endsection
