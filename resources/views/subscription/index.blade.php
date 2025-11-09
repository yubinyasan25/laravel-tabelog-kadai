@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">有料会員登録（月額300円）</h2>

    @if(auth()->user()->is_paid_member)
        <p class="text-success">あなたはすでに有料会員です。</p>
    @else
        <a href="{{ route('subscription.subscribe') }}" class="btn btn-primary">
            月額300円で有料会員になる
        </a>
    @endif
</div>
@endsection
