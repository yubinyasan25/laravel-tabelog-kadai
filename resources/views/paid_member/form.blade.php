@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <h1 class="mb-4">有料会員登録</h1>
    <p>月額300円のプレミアム会員サービスに登録するには、クレジットカード情報を入力してください。</p>

    {{-- 成功・エラーメッセージ --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="payment-form" action="{{ route('paid.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="card-element" class="form-label">クレジットカード情報</label>
            <div id="card-element" class="form-control"></div>
        </div>

        <input type="hidden" name="payment_method" id="payment_method">

        <button type="submit" id="submit-button" class="btn btn-primary mt-3">
            有料会員になる
        </button>
    </form>
</div>

{{-- Stripe.js --}}
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const {paymentMethod, error} = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement
        });

        if (error) {
            alert(error.message);
            return;
        }

        document.getElementById('payment_method').value = paymentMethod.id;
        form.submit();
    });
</script>
@endsection
