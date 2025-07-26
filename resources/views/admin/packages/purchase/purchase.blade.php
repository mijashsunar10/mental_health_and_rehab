@extends('template.template')

@section('pagecontent')
<div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto mt-20">
    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex justify-between mb-2">
            @foreach(['Personal Info', 'Treatment Options', 'Payment Method', 'Confirmation'] as $index => $step)
                <span class="text-sm {{ $currentStep > $index ? 'text-blue-600 font-medium' : 'text-gray-500' }}">
                    Step {{ $index+1 }}: {{ $step }}
                </span>
            @endforeach
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ ($currentStep / 4) * 100 }}%"></div>
        </div>
    </div>

    <form method="POST" action="{{ route('packages.purchase.submit', $package) }}" class="space-y-6" id="multiStepForm">
        @csrf
        <input type="hidden" name="current_step" value="{{ $currentStep }}">

        <!-- Step 1: Personal Information -->
        <div id="step1" class="step" style="display: {{ $currentStep == 1 ? 'block' : 'none' }};">
            <h2 class="text-xl font-semibold mb-4">Personal Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="full_name" value="{{ old('full_name', session('purchase_data.full_name')) }}" required class="w-full px-3 py-2 border rounded-md">
                    @error('full_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', session('purchase_data.email')) }}" required class="w-full px-3 py-2 border rounded-md">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="tel" name="phone" value="{{ old('phone', session('purchase_data.phone')) }}" required class="w-full px-3 py-2 border rounded-md">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob', session('purchase_data.dob')) }}" required class="w-full px-3 py-2 border rounded-md">
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

        <!-- Step 3: Payment Method -->
        <div id="step3" class="step" style="display: {{ $currentStep == 3 ? 'block' : 'none' }};">
            <h2 class="text-xl font-semibold mb-4">Payment Information</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                    <input type="text" name="card_number" placeholder="1234 5678 9012 3456" 
                           value="{{ old('card_number', session('purchase_data.card_number')) }}" 
                           class="w-full px-3 py-2 border rounded-md">
                    @error('card_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                        <input type="text" name="expiry" placeholder="MM/YY" 
                               value="{{ old('expiry', session('purchase_data.expiry')) }}" 
                               class="w-full px-3 py-2 border rounded-md">
                        @error('expiry')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                        <input type="text" name="cvv" placeholder="123" 
                               value="{{ old('cvv', session('purchase_data.cvv')) }}" 
                               class="w-full px-3 py-2 border rounded-md">
                        @error('cvv')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4: Confirmation -->
        <div id="step4" class="step" style="display: {{ $currentStep == 4 ? 'block' : 'none' }};">
            <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
            <div class="bg-blue-50 p-4 rounded-lg mb-6">
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Package:</span>
                    <span>{{ $package->title }}</span>
                </div>
                
                @if($selectedOption)
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
            
            @if($selectedOption)
            <div class="mb-4">
                <label class="flex items-start">
                    <input type="checkbox" name="terms" required 
                           @if(old('terms')) checked @endif
                           class="mt-1 h-4 w-4 text-blue-600">
                    <span class="ml-2 text-sm">I agree to the <a href="#" class="text-blue-600 hover:underline">terms and conditions</a></span>
                </label>
                @error('terms')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
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
            
            @if($currentStep < 4)
                <button type="submit" name="next" value="1" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Next
                </button>
            @else
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
                        @if(!$selectedOption) disabled @endif>
                    Complete Purchase
                </button>
            @endif
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Since we're using server-side step handling, most logic is already in PHP
    // This JavaScript is just for any additional client-side interactions
    
    // If you want to add client-side validation or other interactions:
    const form = document.getElementById('multiStepForm');
    
    // Example: Add client-side validation before submission
    form.addEventListener('submit', function(e) {
        // You can add validation logic here if needed
        // For example, check if required fields are filled
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
    
    // If you want to add smooth transitions between steps (optional)
    function goToStep(step) {
        document.querySelectorAll('.step').forEach(stepEl => {
            stepEl.style.display = 'none';
        });
        document.getElementById('step' + step).style.display = 'block';
    }
});
</script>
@endsection