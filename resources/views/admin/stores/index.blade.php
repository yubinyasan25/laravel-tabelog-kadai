{{-- resources/views/admin/stores/index.blade.php --}}

@extends('admin::index')

@section('content')

@php
    $header = '店舗一覧';
    $description = '';
@endphp

<div class="container">

    {{-- 検索フォーム --}}
    <form action="{{ route('admin.stores.index') }}" method="GET" class="mb-3 d-flex gap-2">
        <input type="text"
               name="keyword"
               value="{{ request('keyword') }}"
               placeholder="店舗名・住所で検索"
               class="form-control">
        <button type="submit" class="btn btn-primary">検索</button>

        {{-- 新規作成ボタン --}}
        <a href="{{ route('admin.stores.create') }}" class="btn btn-success">新規作成</a>
    </form>

    {{-- 一覧テーブル --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>店舗名</th>
                <th>住所</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stores as $store)
            <tr>
                <td>{{ $store->id }}</td>
                <td>{{ $store->name }}</td>
                <td>{{ $store->address }}</td>
                <td>
                    {{-- 編集ボタン --}}
                    <a href="{{ route('admin.stores.edit', $store->id) }}" class="btn btn-warning btn-sm">
                        編集
                    </a>

                    {{-- 削除ボタン --}}
                    <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('削除しますか？');">
                            削除
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">登録された店舗はありません</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
