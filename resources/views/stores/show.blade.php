@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            {{-- カテゴリサイドバー --}}
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
                <a href="{{ route('stores.index') }}" class="btn btn-secondary mt-3 mb-4">
                    店舗一覧に戻る
                </a>

                {{-- 予約フォーム --}}
                <h4 class="mt-4">予約フォーム</h4>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('stores.reserve', $store->id) }}" method="POST">
                    @csrf
                    
                    {{-- 日付 --}}
                    <div class="mb-3">
                        <label class="form-label">日付</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>

                    {{-- 時間（11:00～22:00、30分刻み） --}}
                    <div class="mb-3">
                        <label class="form-label">時間</label>
                        <select name="time" class="form-select" required>
                            <option value="">選択してください</option>
                            @for($h = 11; $h <= 22; $h++)
                                <option value="{{ sprintf('%02d:00:00', $h) }}">{{ sprintf('%02d:00', $h) }}</option>
                                <option value="{{ sprintf('%02d:30:00', $h) }}">{{ sprintf('%02d:30', $h) }}</option>
                            @endfor
                        </select>
                    </div>

                    {{-- 人数（1～50名） --}}
                    <div class="mb-3">
                        <label class="form-label">人数</label>
                        <input type="number" name="people" class="form-control" min="1" max="50" required>
                    </div>

                    <button type="submit" class="btn btn-primary">予約する</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
