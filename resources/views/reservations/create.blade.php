@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>{{ $store->name }} の予約フォーム</h2>

    <form action="{{ route('stores.reserve', $store->id) }}" method="POST">
        @csrf

        {{-- 店舗ID（hidden） --}}
        <input type="hidden" name="store_id" value="{{ $store->id }}">

        <div class="mb-3">
            <label for="reservation_date" class="form-label">日付</label>
            <input type="date" name="reservation_date" class="form-control" required>
        </div>

        {{-- ✅ 時間を30分刻みの選択肢に変更 --}}
        <div class="mb-3">
            <label for="reservation_time" class="form-label">時間</label>
           <select name="reservation_time" class="form-select" required>
    <option value="">選択してください</option> {{-- 追加 --}}
    @for ($hour = 11; $hour <= 22; $hour++)
        <option value="{{ sprintf('%02d:00', $hour) }}">{{ sprintf('%02d:00', $hour) }}</option>
        @if ($hour < 22)
            <option value="{{ sprintf('%02d:30', $hour) }}">{{ sprintf('%02d:30', $hour) }}</option>
        @endif
    @endfor
</select>
        </div>

        <div class="mb-3">
            <label for="people" class="form-label">人数</label>
            <input type="number" name="people" class="form-control" min="1" max="50" required>
        </div>

        <button type="submit" class="btn btn-primary">予約する</button>
        <a href="{{ route('stores.show', $store->id) }}" class="btn btn-secondary">戻る</a>
    </form>
</div>
@endsection
