{{-- resources/views/components/panic-button.blade.php --}}
@auth
<div id="panic-button-container" class="fixed right-4 top-1/2 transform -translate-y-1/2 z-50">
    <!-- Panic Button -->
    <button 
        id="panic-button" 
        class="bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-4 rounded-full shadow-lg transition-all duration-300 hover:scale-110 focus:outline-none focus:ring-4 focus:ring-red-300 animate-pulse"
        title="Emergency Panic Button"
    >
        <i class="fas fa-exclamation-triangle text-2xl"></i>
    </button>
    
    <!-- Loading State -->
    <button 
        id="panic-button-loading" 
        class="hidden bg-red-600 text-white font-bold py-4 px-4 rounded-full shadow-lg cursor-not-allowed opacity-75"
        disabled
    >
        <i class="fas fa-spinner fa-spin text-2xl"></i>
    </button>
</div>

<!-- Confirmation Modal -->
<div id="panic-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-[60] hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Emergency Alert</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to send an emergency alert? This will immediately notify the emergency contacts.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button 
                    id="confirm-panic" 
                    class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 mb-2"
                >
                    Yes, Send Emergency Alert
                </button>
                <button 
                    id="cancel-panic" 
                    class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300"
                >
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
<div id="panic-message" class="fixed top-4 right-4 z-[70] hidden">
    <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg hidden">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>Emergency alert sent successfully!</span>
        </div>
    </div>
    <div id="error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg hidden">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span>Failed to send emergency alert. Please try again.</span>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const panicButton = document.getElementById('panic-button');
    const panicButtonLoading = document.getElementById('panic-button-loading');
    const panicModal = document.getElementById('panic-modal');
    const confirmPanic = document.getElementById('confirm-panic');
    const cancelPanic = document.getElementById('cancel-panic');
    const panicMessage = document.getElementById('panic-message');
    const successMessage = document.getElementById('success-message');
    const errorMessage = document.getElementById('error-message');

    // Show confirmation modal
    panicButton.addEventListener('click', function() {
        panicModal.classList.remove('hidden');
    });

    // Cancel panic
    cancelPanic.addEventListener('click', function() {
        panicModal.classList.add('hidden');
    });

    // Close modal when clicking outside
    panicModal.addEventListener('click', function(e) {
        if (e.target === panicModal) {
            panicModal.classList.add('hidden');
        }
    });

    // Confirm panic and send email
    confirmPanic.addEventListener('click', function() {
        // Hide modal
        panicModal.classList.add('hidden');
        
        // Show loading state
        panicButton.classList.add('hidden');
        panicButtonLoading.classList.remove('hidden');
        
        // Get CSRF token
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Send AJAX request
        fetch('/panic-alert', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                timestamp: new Date().toISOString(),
                url: window.location.href,
                user_agent: navigator.userAgent
            })
        })
        .then(response => response.json())
        .then(data => {
            // Hide loading state
            panicButtonLoading.classList.add('hidden');
            panicButton.classList.remove('hidden');
            
            // Show message
            panicMessage.classList.remove('hidden');
            
            if (data.success) {
                successMessage.classList.remove('hidden');
                errorMessage.classList.add('hidden');
            } else {
                errorMessage.classList.remove('hidden');
                successMessage.classList.add('hidden');
            }
            
            // Hide message after 5 seconds
            setTimeout(() => {
                panicMessage.classList.add('hidden');
                successMessage.classList.add('hidden');
                errorMessage.classList.add('hidden');
            }, 5000);
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Hide loading state
            panicButtonLoading.classList.add('hidden');
            panicButton.classList.remove('hidden');
            
            // Show error message
            panicMessage.classList.remove('hidden');
            errorMessage.classList.remove('hidden');
            successMessage.classList.add('hidden');
            
            // Hide message after 5 seconds
            setTimeout(() => {
                panicMessage.classList.add('hidden');
                errorMessage.classList.add('hidden');
            }, 5000);
        });
    });
});
</script>
@endauth