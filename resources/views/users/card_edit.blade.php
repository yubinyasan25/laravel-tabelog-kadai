@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">クレジットカード情報管理</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($card)
        <p>現在のカード: {{ strtoupper($card->card->brand) }} **** **** **** {{ $card->card->last4 }}</p>
        <p>有効期限: {{ $card->card->exp_month }}/{{ $card->card->exp_year }}</p>
    @else
        <p>カード情報は登録されていません。</p>
    @endif

    <hr>

    <h4>カード情報を変更</h4>
    <form id="card-form" action="{{ route('mypage.card.update') }}" method="POST">
        @csrf
        <div id="card-element" class="mb-3"></div>
        <button type="submit" class="btn btn-primary mt-2">カードを更新</button>
    </form>

    @if($card)
        <hr>
        <form action="{{ route('mypage.card.delete') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger mt-2">サブスク解約・カード削除</button>
        </form>
    @endif
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    const form = document.getElementById('card-form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const {paymentMethod, error} = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
        });

        if(error){
            alert(error.message);
            return;
        }

        const hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'payment_method_id');
        hiddenInput.setAttribute('value', paymentMethod.id);
        form.appendChild(hiddenInput);

        form.submit();
    });
</script>
@endsection
