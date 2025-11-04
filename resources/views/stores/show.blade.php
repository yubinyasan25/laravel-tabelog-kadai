 @extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            {{-- カテゴリサイドバーなど --}}
            <div class="card p-3 shadow-sm">
                <h5>カテゴリ</h5>
                <ul class="list-unstyled">
                    @foreach($categories as $category)
                        <li><a href="#" class="text-decoration-none">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card shadow-sm p-4">
                <h2 class="mb-3">{{ $store->name }}</h2>
                <p class="text-muted mb-3">{{ $store->address }}</p>

                @if($store->image)
                    <img src="{{ asset('storage/' . $store->image) }}" 
                         alt="{{ $store->name }}" 
                         class="img-fluid mb-4 rounded">
                @endif

                <p>{{ $store->description }}</p>

                <hr>
                <a href="{{ route('stores.index') }}" class="btn btn-secondary mt-3">
                    店舗一覧に戻る
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
