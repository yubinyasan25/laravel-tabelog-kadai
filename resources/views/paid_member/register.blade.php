@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <h1>有料会員登録</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form id="paid-member-form" action="{{ route('paid.store') }}" method="POST">
        @csrf
        <div id="card-element" class="mb-3"></div>
        <button type="submit" class="btn btn-primary">有料会員登録</button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    const form = document.getElementById('paid-member-form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const { paymentMethod, error } = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
        });
        if(error){
            alert(error.message);
            return;
        }
        const hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type','hidden');
        hiddenInput.setAttribute('name','payment_method');
        hiddenInput.setAttribute('value',paymentMethod.id);
        form.appendChild(hiddenInput);
        form.submit();
    });
</script>
@endsection
