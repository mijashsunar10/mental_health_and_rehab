@extends('template.template')

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>

@section('pagecontent')
    <section class="antialiased mt-24">
        <!-- Main Content -->
        <div class="container mx-auto px-4 py-8 max-w-4xl">
            <!-- Cancel Message -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <div class="md:flex">
                    <div class="md:flex-shrink-0 bg-gradient-to-br from-red-400 to-red-600 md:w-1/3 flex items-center justify-center p-8">
                        <div class="text-center text-white">
                            <i class="fas fa-times-circle text-6xl mb-4"></i>
                            <h2 class="text-2xl font-bold">Purchase Cancelled</h2>
                        </div>
                    </div>
                    <div class="p-8 md:w-2/3">
                        <h1 class="text-3xl font-bold text-gray-800 mb-4">Your purchase was cancelled</h1>
                        <p class="text-gray-600 mb-6">{{ $message ?? 'Your purchase was cancelled. Please try again if you want to continue.' }}</p>

                        @if(session('error'))
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                            <p class="font-medium">Error:</p>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                        @endif

                        <div class="bg-blue-50 p-4 rounded-lg mb-6">
                            <h3 class="font-semibold text-blue-800 mb-2">What would you like to do?</h3>
                            <ul class="list-disc list-inside text-gray-700 space-y-2">
                                <li>Browse our available packages again</li>
                                <li>Contact support if you experienced any issues</li>
                                <li>Return to your dashboard</li>
                            </ul>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 mt-8">
                            <a href="{{ route('admin.packages.index') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-3 px-6 rounded-lg text-center transition-all duration-300 flex items-center justify-center">
                                <i class="fas fa-box-open mr-2"></i> View Packages
                            </a>
                            <a href="{{ route('dashboard') }}" class="border border-gray-400 text-gray-700 hover:bg-gray-100 font-bold py-3 px-6 rounded-lg text-center transition-all duration-300 flex items-center justify-center">
                                <i class="fas fa-tachometer-alt mr-2"></i> Go to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Support Section -->
            <div class="bg-gradient-to-r from-blue-400 to-purple-500 rounded-xl shadow-lg text-white p-8 mt-8">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="flex-1 mb-6 md:mb-0">
                        <h2 class="text-2xl font-bold mb-2">Need Assistance?</h2>
                        <p class="mb-4">Our support team is here to help you with any questions or concerns</p>
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-xl mr-2"></i>
                            <span>support@wellnessplus.com</span>
                        </div>
                        <div class="flex items-center mt-2">
                            <i class="fas fa-phone-alt text-xl mr-2"></i>
                            <span>1-800-WELLNESS</span>
                        </div>
                    </div>
                    <div class="text-5xl">
                        <i class="fas fa-headset"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
