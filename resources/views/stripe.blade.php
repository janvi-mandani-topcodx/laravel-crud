@extends('layout')
@section('content')
    <input id="card-holder-name" type="text">

    <!-- Stripe Elements Placeholder -->
    <div id="card-element"></div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <button id="card-button">
        Process Payment
    </button>
@endsection
@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        const stripe = Stripe("{{ config('services.stripe.stripe_key') }}");

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');


        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');



        cardButton.addEventListener('click', async (e) => {
            const response = await fetch('{{ route('stripe.payment') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ total: 1000 })
            });
            const data = await response.json();

            const { error, paymentIntent } = await stripe.confirmCardPayment(data.clientSecret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: cardHolderName.value
                    }
                }
            });

            if (error) {
                console.log("tttttt")
            } else {
                console.log("yyyyyyyy")
            }
        });

    </script>

@endsection
