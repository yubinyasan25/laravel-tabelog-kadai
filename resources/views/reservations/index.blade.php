@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">予約一覧</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($reservations->isEmpty())
        <p>現在、予約はありません。</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>店舗名</th>
                    <th>予約日時</th>
                    <th>人数</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->store->name }}</td>
                        <td>{{ $reservation->reservation_datetime }}</td>
                        <td>{{ $reservation->number_of_people }}</td>
                        <td>
                            <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('本当にキャンセルしますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">キャンセル</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
