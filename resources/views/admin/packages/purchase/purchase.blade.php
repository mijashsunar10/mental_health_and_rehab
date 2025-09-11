@extends('template.template')

@section('pagecontent')
<div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto mt-20">
    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex justify-between mb-2">
            @foreach(['Personal Info', 'Treatment Options', 'Confirmation & Payment'] as $index => $step)
                <span class="text-sm {{ $currentStep > $index ? 'text-blue-600 font-medium' : 'text-gray-500' }}">
                    Step {{ $index+1 }}: {{ $step }}
                </span>
            @endforeach
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ (($currentStep - 1) / 3) * 100 }}%"></div>
        </div>
    </div>

    <!-- Multi-step form -->
    <form method="POST" action="{{ route('packages.purchase.submit', $package) }}" class="space-y-6" id="multiStepForm">
        @csrf
        <input type="hidden" name="current_step" value="{{ $currentStep }}">

        <!-- Step 1: Personal Information -->
        <div id="step1" class="step" style="display: {{ $currentStep == 1 ? 'block' : 'none' }};">
            <h2 class="text-xl font-semibold mb-4">Personal Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="full_name" value="{{ old('full_name', Auth::user()->name ?? session('purchase_data.full_name')) }}" required class="w-full px-3 py-2 border rounded-md">
                    @error('full_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email ?? session('purchase_data.email')) }}" required class="w-full px-3 py-2 border rounded-md">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="tel" name="phone" value="{{ old('phone', Auth::user()->phone?? session('purchase_data.phone')) }}" required class="w-full px-3 py-2 border rounded-md">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob', Auth::user()->dob ?? session('purchase_data.dob')) }}" required class="w-full px-3 py-2 border rounded-md">
                    @error('dob')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Step 2: Treatment Options -->
        <div id="step2" class="step" style="display: {{ $currentStep == 2 ? 'block' : 'none' }};">
            <h2 class="text-xl font-semibold mb-4">Select Treatment Options</h2>
            <div class="space-y-4">
                @foreach($package->options as $index => $option)
                <div class="flex items-center p-4 border rounded-lg hover:bg-blue-50">
                    <input type="radio" id="option_{{ $index }}" name="selected_option" 
                           value="{{ $index }}" 
                           @if(old('selected_option', session('purchase_data.selected_option')) == $index) checked @endif
                           required
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                    <label for="option_{{ $index }}" class="ml-3 block">
                        <span class="font-medium">{{ $option['name'] }}</span>
                        <span class="text-gray-600 ml-2">${{ number_format($option['price'], 2) }} ({{ $option['duration'] }})</span>
                        <p class="text-sm text-gray-500 mt-1">{{ $option['description'] ?? 'Includes full treatment program' }}</p>
                    </label>
                </div>
                @endforeach
            </div>
            @error('selected_option')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Step 3: Confirmation & Payment -->
        <div id="step3" class="step" style="display: {{ $currentStep == 3 ? 'block' : 'none' }};">
            <h2 class="text-xl font-semibold mb-4">Order Summary & Payment</h2>
            
            @if($selectedOption)
            <div class="bg-blue-50 p-4 rounded-lg mb-6">
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Package:</span>
                    <span>{{ $package->title }}</span>
                </div>
                
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Selected Option:</span>
                    <span>{{ $selectedOption['name'] }} (${{ number_format($selectedOption['price'], 2) }})</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Duration:</span>
                    <span>{{ $selectedOption['duration'] }}</span>
                </div>
                <div class="flex justify-between border-t pt-2 mt-2">
                    <span class="font-medium">Total:</span>
                    <span class="font-bold">${{ number_format($selectedOption['price'], 2) }}</span>
                </div>
            </div>
            
            <!-- Stripe Payment Elements -->
            <div class="border rounded-lg p-4 mb-4">
                <h3 class="text-lg font-medium mb-3">Payment Information</h3>
                
                <div id="card-element" class="border rounded-md p-3 mb-3">
                    <!-- Stripe Card Element will be inserted here -->
                </div>
                
                <!-- Used to display form errors -->
                <div id="card-errors" role="alert" class="text-red-600 text-sm mb-3"></div>
                
                <div class="mb-4">
                    <label class="flex items-start">
                        <input type="checkbox" name="terms" id="terms-checkbox" required 
                               @if(old('terms')) checked @endif
                               class="mt-1 h-4 w-4 text-blue-600">
                        <span class="ml-2 text-sm">I agree to the <a href="#" class="text-blue-600 hover:underline">terms and conditions</a></span>
                    </label>
                    @error('terms')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            @else
            <div class="bg-red-50 text-red-600 p-3 rounded-md">
                <p>No option selected. Please go back and select a treatment option.</p>
                <a href="{{ route('packages.purchase', ['package' => $package, 'step' => 2]) }}" 
                   class="text-blue-600 hover:underline mt-2 inline-block">
                    Select Treatment Option
                </a>
            </div>
            @endif
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between pt-4 border-t">
            @if($currentStep > 1)
                <a href="{{ route('packages.purchase', ['package' => $package, 'step' => $currentStep - 1]) }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    Previous
                </a>
            @else
                <div></div>
            @endif
            
            @if($currentStep < 3)
                <button type="submit" name="next" value="1" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Next
                </button>
            @elseif($selectedOption)
                <button type="button" id="submit-payment" 
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    Complete Payment
                </button>
            @endif
        </div>
    </form>
</div>

<!-- Load Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Stripe initialization
    const stripe = Stripe('{{ env("STRIPE_KEY") }}');
    const elements = stripe.elements();
    
    // Create card element
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#424770',
                '::placeholder': {
                    color: '#aab7c4',
                },
            },
        },
    });
    
    cardElement.mount('#card-element');
    
    // Handle form submission
    const form = document.getElementById('multiStepForm');
    const submitButton = document.getElementById('submit-payment');
    const cardErrors = document.getElementById('card-errors');
    
    if (submitButton) {
        submitButton.addEventListener('click', async function(e) {
            e.preventDefault();
            
            console.log('Payment button clicked');
            
            // Validate terms checkbox
            const termsCheckbox = document.getElementById('terms-checkbox');
            if (!termsCheckbox.checked) {
                cardErrors.textContent = 'You must agree to the terms and conditions';
                return;
            }
            
            // Disable button to prevent multiple submissions
            submitButton.disabled = true;
            submitButton.textContent = 'Processing...';
            
            try {
                // Create payment method
                const {token, error} = await stripe.createToken(cardElement);
                
                if (error) {
                    // Show errors to the customer
                    cardErrors.textContent = error.message;
                    submitButton.disabled = false;
                    submitButton.textContent = 'Complete Payment';
                    console.error('Stripe error:', error);
                    return;
                }
                
                // Create a hidden input for the token
                const tokenInput = document.createElement('input');
                tokenInput.type = 'hidden';
                tokenInput.name = 'stripeToken';
                tokenInput.value = token.id;
                form.appendChild(tokenInput);
                
                // Change the form action for payment processing
                form.action = "{{ route('stripe.payment', $package) }}";
                
                // Submit the form
                console.log('Submitting form with token:', token.id);
                form.submit();
                
            } catch (error) {
                console.error('Payment error:', error);
                cardErrors.textContent = 'An unexpected error occurred. Please try again.';
                submitButton.disabled = false;
                submitButton.textContent = 'Complete Payment';
            }
        });
    }
    
    // Client-side validation for step 1
    form.addEventListener('submit', function(e) {
        const currentStep = {{ $currentStep }};
        
        if (currentStep === 1) {
            const requiredFields = form.querySelectorAll('#step1 [required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields');
            }
        }
    });
});
</script>
@endsection