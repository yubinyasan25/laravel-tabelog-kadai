@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- 左上に前のページに戻るリンク --}}
    <div class="mb-3">
        <a href="javascript:history.back()" 
           onclick="if(!document.referrer) location.href='{{ url('/') }}';"
           style="color:#2ecc71; text-decoration:none;">
            ← 前のページに戻る
        </a>
    </div>

    <h2>予約一覧</h2>

    @if ($reservations->isEmpty())
        <p>現在、予約はありません。</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>店舗名</th>
                    <th>日時</th>
                    <th>人数</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->store->name }}</td>
                        <td>{{ $reservation->reservation_datetime }}</td>
                        <td>{{ $reservation->number_of_people }}</td>
                        <td>
                            <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">キャンセル</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
