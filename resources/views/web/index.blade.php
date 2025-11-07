@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- 表題 --}}
    <h1 class="text-center mb-5 fw-bold">NAGOYAMESHIグルメガイド</h1>

    {{-- カテゴリ一覧（5列で折り返し・中央揃え・高さ広め） --}}
    <div class="d-flex flex-wrap justify-content-center gap-3 mb-4" style="max-width: 1000px; margin: 0 auto;">
        @foreach($categories as $category)
            <a href="{{ route('stores.index', ['category' => $category->id]) }}"
               class="d-flex align-items-center justify-content-center text-decoration-none text-dark border border-warning rounded shadow-sm"
               style="width: 18%; min-width: 150px; height: 60px; background-color: #fff8e1; font-weight: 600; font-size: 0.95rem;">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

</div>
@endsection
