@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">

       

        {{-- 右側店舗詳細 --}}
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
                        <input type="date" name="reservation_date" class="form-control" required>
                    </div>

                    {{-- 時間 --}}
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

                    {{-- 人数 --}}
                    <div class="mb-3">
                        <label class="form-label">人数</label>
                        <select name="people" class="form-select" required>
                            <option value="">選択してください</option>
                            @for ($i = 1; $i <= 20; $i++)
                                <option value="{{ $i }}">{{ $i }}名</option>
                            @endfor
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">予約する</button>
                </form>
            </div>
        </div>

    </div>
</div>

{{-- カテゴリリンクの共通スタイル（オレンジ枠・背景色・中央揃え） --}}
<style>
    .category-item {
        height: 35px;
        background-color: #fff8e1;
        font-weight: 600;
        font-size: 0.9rem;
        border: 2px solid orange; /* オレンジ枠線 */
        text-align: center;
        line-height: 31px; /* 高さに合わせて文字中央揃え */
        transition: background-color 0.2s, border-color 0.2s;
    }

    .category-item:hover {
        background-color: #fff3d6;
        border-color: darkorange;
        text-decoration: none;
    }
</style>
@endsection
