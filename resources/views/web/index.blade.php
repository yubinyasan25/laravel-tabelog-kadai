@extends('layouts.app')

@section('content')

{{-- コンテナは写真＋タイトル用 --}}
<div class="position-relative mx-auto" style="max-width: 1000px; height: 250px; overflow: hidden;">

    {{-- 写真3枚を横並び --}}
    <div class="d-flex w-100 h-100">
        <img src="{{ asset('img/味噌煮込み.JPG') }}" alt="写真1" class="flex-grow-1" style="object-fit: cover; height: 100%;">
        <img src="{{ asset('img/森.JPG') }}" alt="写真2" class="flex-grow-1" style="object-fit: cover; height: 100%;">
        <img src="{{ asset('img/トースト.JPG') }}" alt="写真3" class="flex-grow-1" style="object-fit: cover; height: 100%;">
    </div>

    {{-- 写真の中央にタイトル --}}
    <h1 class="position-absolute top-50 start-50 text-white fw-bold"
        style="transform: translate(-50%, -50%); text-shadow: 2px 2px 6px rgba(0,0,0,0.7); font-size: 2.5rem; margin: 0;">
        NAGOYAMESHIグルメガイド
    </h1>

</div>

{{-- カテゴリは写真の下に配置 --}}
<div class="container py-4">
    <div class="row g-3"> {{-- g-3 でボタン間の隙間 --}}
        @foreach($categories as $category)
            <div class="col-6 col-md-3"> {{-- スマホでは2列、PCでは4列 --}}
                <a href="{{ route('stores.index', ['category' => $category->id]) }}"
                   class="d-flex align-items-center justify-content-center text-decoration-none text-dark border rounded shadow-sm
                          {{ (isset($categoryId) && $categoryId == $category->id) ? 'border-danger' : 'border-warning' }}"
                   style="height: 60px; background-color: #fff8e1; font-weight: 600; font-size: 0.95rem;">
                    {{ $category->name }}
                </a>
            </div>
        @endforeach
    </div>
</div>

@endsection
