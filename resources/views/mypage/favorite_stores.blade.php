@extends('layouts.app')

@section('content')
<div class="container mt-4 d-flex justify-content-center">
    <div class="col-md-8"> {{-- 横幅を2/3程度に調整 --}}
        {{-- 左上に前のページに戻るリンク --}}
        <div class="mb-3">
            <a href="javascript:history.back()" 
               onclick="if(!document.referrer) location.href='{{ url('/') }}';"
               style="color:#2ecc71; text-decoration:none;">
                ← 前のページに戻る
            </a>
        </div>

        <h2>お気に入り店舗一覧</h2>

        @if ($favorite_stores->isEmpty())
            <p>お気に入りはまだ追加されていません。</p>
        @else
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th style="width: 40%;">店舗名</th> {{-- 左1/4くらいの位置にカテゴリを配置 --}}
                        <th style="width: 25%;">カテゴリ</th>
                        <th style="width: 35%;"></th> {{-- ボタン列の幅を調整 --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($favorite_stores as $store)
                        <tr>
                            <td>{{ $store->name }}</td>
                            <td>{{ $store->category->name ?? '未設定' }}</td>
                            <td class="text-end">
                                {{-- 店舗詳細ボタン --}}
                                <a href="{{ route('stores.show', $store->id) }}" class="btn btn-primary btn-sm me-2">
                                    詳細
                                </a>

                                {{-- 削除ボタン --}}
                                @if(auth()->user()->is_paid)
                                    <form action="{{ route('favorites.destroy', $store->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            削除
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">有料会員限定</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div class="mt-4">
            {{ $favorite_stores->links() }}
        </div>
    </div>
</div>
@endsection
