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

                            {{-- 店舗画像をリンクで囲む --}}
                            <a href="{{ route('stores.show', $store->id) }}">
                                <img src="{{ asset('img/default.jpg') }}"
                                     alt="{{ $store->name }}"
                                     class="card-img-top"
                                     style="height:200px; object-fit:cover;">
                            </a>

                            <div class="card-body">
                                {{-- 店舗名をリンクで囲む --}}
                                <h5 class="card-title">
                                    <a href="{{ route('stores.show', $store->id) }}" class="text-dark text-decoration-none">
                                        {{ $store->name }}
                                    </a>
                                </h5>

                                <p class="card-text text-muted">{{ Str::limit($store->description, 60, '...') }}</p>

                                

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

{{-- JSでお気に入り切替 --}}
@auth
<script>
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
                this.classList.remove('btn-outline-secondary');
                this.classList.add('btn-danger');
            } else {
                this.textContent = '🤍 お気に入り追加';
                this.classList.remove('btn-danger');
                this.classList.add('btn-outline-secondary');
            }
        });
    });
});
</script>
@endauth

{{-- カテゴリリンクのスタイル --}}
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
</style>
@endsection
