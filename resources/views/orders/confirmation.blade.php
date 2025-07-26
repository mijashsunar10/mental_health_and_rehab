@extends('template.template')

@section('pagecontent')
<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white">
            <h2 class="mb-0"><i class="fas fa-check-circle"></i> Order Confirmed</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="text-primary">Order Details</h3>
                    <ul class="list-group mb-4">
                        <li class="list-group-item">
                            <strong>Order #:</strong> {{ $order->id }}
                        </li>
                        <li class="list-group-item">
                            <strong>Date:</strong> {{ $order->created_at->format('F j, Y \a\t g:i a') }}
                        </li>
                        <li class="list-group-item">
                            <strong>Status:</strong>
                            <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Reference:</strong> {{ $order->payment_reference }}
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h3 class="text-primary">Payment Information</h3>
                    <ul class="list-group mb-4">
                        <li class="list-group-item">
                            <strong>Amount:</strong> ${{ number_format($order->amount, 2) }}
                        </li>
                        <li class="list-group-item">
                            <strong>Card:</strong> **** **** **** {{ $order->payment_details['last_four'] ?? '****' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Type:</strong> {{ $order->payment_details['card_type'] ?? 'Unknown' }}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-4">
                <h3 class="text-primary">Package Details</h3>
                <div class="card">
                    <div class="card-body">
                        <h4>{{ $order->package->title }}</h4>
                        @if($selectedOption)
                        <div class="mt-3">
                            <h5>Selected Option:</h5>
                            <ul>
                                <li><strong>Name:</strong> {{ $selectedOption['name'] }}</li>
                                <li><strong>Duration:</strong> {{ $selectedOption['duration'] }}</li>
                                <li><strong>Price:</strong> ${{ number_format($selectedOption['price'], 2) }}</li>
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div class="alert alert-info">
                    <h4><i class="fas fa-info-circle"></i> What's Next?</h4>
                    <ul>
                        <li>You'll receive a confirmation email shortly</li>
                        <li>Our team will contact you within 24 hours</li>
                        <li>Check your spam folder if you don't see our email</li>
                    </ul>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="fas fa-home"></i> Back to Home
                </a>
                <a href="{{ route('user.orders') }}" class="btn btn-primary">
                    <i class="fas fa-list"></i> View All Orders
                </a>
            </div>
        </div>
    </div>
</div>
@endsection