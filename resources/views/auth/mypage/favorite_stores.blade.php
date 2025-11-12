@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>お気に入り店舗</h1>

            <hr class="my-4">

            @if ($favorite_stores->isEmpty())
                <div class="row">
                    <p class="mb-0">お気に入りはまだ追加されていません。</p>
                </div>
            @else
                @foreach ($favorite_stores as $store)
                    <div class="row align-items-center mb-3 p-2 border rounded">
                        <div class="col-md-3">
                            <a href="{{ route('stores.show', $store->id) }}">
                                @if ($store->image !== "")
                                    <img src="{{ asset($store->image) }}" class="img-thumbnail">
                                @else
                                    <img src="{{ asset('img/dummy.png') }}" class="img-thumbnail">
                                @endif
                            </a>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-1">
                                <a href="{{ route('stores.show', $store->id) }}" class="link-dark">{{ $store->name }}</a>
                            </h5>
                            <p class="mb-0 text-muted">{{ $store->description }}</p>
                        </div>
                        <div class="col-md-3 text-end">
                            @if(auth()->user()->is_paid)
                                <form action="{{ route('stores.favorite.destroy', $store->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        削除
                                    </button>
                                </form>
                            @else
                                <p class="text-muted mb-0">有料会員限定</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif

            <hr class="my-4">

            <div class="mb-4">
                {{ $favorite_stores->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
