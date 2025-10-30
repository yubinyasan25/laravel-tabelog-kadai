@extends('layouts.app')

@section('content')
<div class="container">
    <h1>名古屋B級グルメ店舗一覧</h1>
    <div class="row">
        @foreach($stores as $store)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($store->image)
                        <img src="{{ asset('images/' . $store->image) }}" class="card-img-top" alt="{{ $store->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $store->name }}</h5>
                        <p class="card-text">{{ $store->description }}</p>
                        <p class="card-text"><small>{{ $store->address }}</small></p>
                        @if($store->recommend_flag)
                            <span class="badge bg-success">おすすめ</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
