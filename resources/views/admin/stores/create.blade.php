{{-- resources/views/admin/stores/create.blade.php --}}

@extends('admin::index')

@section('content')

@php
    $header = '新規店舗作成';
    $description = '';
@endphp

<div class="container">

    <form action="{{ route('admin.stores.store') }}" method="POST">
        @csrf

        {{-- 店舗名 --}}
        <div class="form-group mb-2">
            <label>店舗名</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name') }}"
                   required>
        </div>

        {{-- 住所 --}}
        <div class="form-group mb-2">
            <label>住所</label>
            <input type="text"
                   name="address"
                   class="form-control"
                   value="{{ old('address') }}"
                   required>
        </div>

        {{-- 紹介文 --}}
        <div class="form-group mb-2">
            <label>紹介文</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        {{-- 画像 --}}
        <div class="form-group mb-2">
            <label>画像ファイル名</label>
            <input type="text"
                   name="image"
                   class="form-control"
                   value="{{ old('image') }}">
        </div>

        <button type="submit" class="btn btn-success mt-2">作成する</button>
        <a href="{{ route('admin.stores.index') }}" class="btn btn-secondary mt-2">一覧に戻る</a>

    </form>
</div>

@endsection
