@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2>レビューを編集</h2>

    {{-- エラーメッセージ --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reviews.update', $review->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">コメント</label>
            <textarea name="comment" class="form-control" rows="4" required>{{ old('comment', $review->comment) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">更新する</button>
        <a href="{{ route('stores.show', $review->store_id) }}" class="btn btn-secondary">キャンセル</a>
    </form>
</div>
@endsection
