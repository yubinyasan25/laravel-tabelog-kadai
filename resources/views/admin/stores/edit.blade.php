{{-- resources/views/admin/stores/edit.blade.php --}}

@extends('admin::index')

@section('content')

@php
    $header = '店舗編集';
    $description = '';
@endphp

<div class="container">

    <form action="{{ route('admin.stores.update', $store->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- 店舗名 --}}
        <div class="form-group mb-2">
            <label>店舗名</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name', $store->name) }}"
                   required>
        </div>

        {{-- 住所 --}}
        <div class="form-group mb-2">
            <label>住所</label>
            <input type="text"
                   name="address"
                   class="form-control"
                   value="{{ old('address', $store->address) }}"
                   required>
        </div>

        {{-- 紹介文 --}}
        <div class="form-group mb-2">
            <label>紹介文</label>
            <textarea name="description" class="form-control">{{ old('description', $store->description) }}</textarea>
        </div>

        {{-- 画像 --}}
        <div class="form-group mb-2">
            <label>画像ファイル名</label>
            <input type="text"
                   name="image"
                   class="form-control"
                   value="{{ old('image', $store->image) }}">
        </div>

        <button type="submit" class="btn btn-primary mt-2">更新する</button>
        <a href="{{ route('admin.stores.index') }}" class="btn btn-default mt-2">一覧に戻る</a>

    </form>
</div>

@endsection
