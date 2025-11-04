@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">名古屋B級グルメカテゴリ一覧</h1>

    <!-- カテゴリ一覧 -->
    <div class="mb-4">
        @foreach($categories as $category)
            <a href="#" class="btn btn-outline-primary btn-sm me-1 mb-1">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    <hr>

    <!-- 店舗一覧カード -->
    <div class="row">
        @foreach($stores as $store)
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

                        <a href="{{ route('stores.show', $store->id) }}" class="btn btn-primary btn-sm">
                            詳細を見る
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
