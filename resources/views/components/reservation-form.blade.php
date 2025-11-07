{{-- resources/views/components/reservation-form.blade.php --}}
<form action="{{ route('reservations.store', $store->id) }}" method="POST">
    @csrf

    <div class="form-group">
        <label>日付を選択</label>
        <input type="date" name="date" class="form-control" required>
    </div>

    <div class="form-group mt-3">
        <label>時間を選択（11:00〜22:00）</label>
        <select name="time" class="form-control" required>
            @php
                $times = [];
                for ($hour = 11; $hour <= 22; $hour++) {
                    foreach (['00', '30'] as $minute) {
                        if ($hour === 22 && $minute === '30') break;
                        $times[] = sprintf('%02d:%s', $hour, $minute);
                    }
                }
            @endphp

            @foreach ($times as $time)
                <option value="{{ $time }}">{{ $time }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mt-3">
        <label>人数（1〜50人）</label>
        <input type="number" name="people" class="form-control" min="1" max="50" required>
    </div>

    <button type="submit" class="btn btn-primary mt-4">予約する</button>
</form>
