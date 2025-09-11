<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container col-md-4 mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Make Payment</h4>
        </div>
        <div class="card-body">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Message --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="p-3 bg-light bg-opacity-10 rounded">
                <h6 class="card-title mb-3">Order Summary</h6>

                <div class="d-flex justify-content-between mb-1 small">
                    <span>Subtotal</span>
                    <span>$190.00</span>
                </div>

                <div class="d-flex justify-content-between mb-1 small">
                    <span>Shipping</span>
                    <span>$20.00</span>
                </div>

                <div class="d-flex justify-content-between mb-1 small">
                    <span>Coupon (Code: NEWYEAR)</span>
                    <span class="text-danger">- $10.00</span>
                </div>

                <div class="d-flex justify-content-between mb-4 small">
                    <span><strong>TOTAL</strong></span>
                    <strong class="text-dark">$200.00</strong>
                </div>

                <form method="POST" action="{{route('stripe.payment')}}" id="stripe-form">
                    @csrf
                    <input type="hidden" name="price" value="200">
                    <input type="hidden" name="stripeToken" id="stripe-token">
                    <div id="card-element" class="form-control">
                    </div>
                        <!-- A Stripe Element will be inserted here. -->
                       <button class="btn btn-primary w-100 mt-2" type="submit" onclick="createToken()">Submit</button>
                </form>

                 
            
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://js.stripe.com/basil/stripe.js"></script>

<script type="text/javascript">
    var stripe = Stripe('{{env("STRIPE_KEY")}}');
    // var elements = stripe.elements({
    // mode: 'payment',
    // currency: 'usd',
    // amount: 1099,
    // });

    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');

    function createToken() {
        stripe.createToken(cardElement).then(function(result) {
            // if (result.error) {
            //     // Inform the user if there was an error.
            //     console.log(result.error.message);
            // } else {
            //     // Send the token to your server.
            //     console.log(result.token.id);
            //     // stripeTokenHandler(result.token);
            // }

            console.log(result);
            if (result.token) {
                document.getElementById('stripe-token').value = result.token.id;
                document.getElementById('stripe-form').submit();
                // document.getElementById('payment-form').submit();
            }
        });
    }


</script>

</body>
</html>
