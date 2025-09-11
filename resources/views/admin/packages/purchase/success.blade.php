{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Successful - Wellness Package</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
</head> --}}
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
        .gradient-bg {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>

@section('pagecontent')
    <section class="antialiased mt-24">


    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Success Message -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8 card-hover">
            <div class="md:flex">
                <div class="md:flex-shrindashboardk-0 gradient-bg md:w-1/3 flex items-center justify-center p-8">
                    <div class="text-center text-white">
                        <i class="fas fa-check-circle text-6xl mb-4"></i>
                        <h2 class="text-2xl font-bold">Payment Successful!</h2>
                        <p class="mt-2">Thank you for your purchase</p>
                    </div>
                </div>
                <div class="p-8 md:w-2/3">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome to WellnessPlus! {{ $purchase->user->name ?? 'Guest' }}!</h1>
                       {{-- <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome, {{ $purchase->user->name ?? 'Guest' }}!</h1> --}}
                    <p class="text-gray-600 mb-6">Your wellness journey starts now. Here's what you've purchased:</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-blue-800 mb-2">Package Details</h3>
                           <p><i class="fas fa-cube text-blue-500 mr-2"></i> {{ $package->title }}</p>
    <p><i class="fas fa-tag text-blue-500 mr-2"></i> {{ $package->options[$purchase->selected_option]['name'] }}</p>
    <p><i class="fas fa-clock text-blue-500 mr-2"></i> Started: {{ $purchase->start_date }}</p>
                        </div>
                        
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-green-800 mb-2">Payment Information</h3>
                            <p class="text-gray-700"><i class="fas fa-credit-card text-green-500 mr-2"></i> Purchase Ended:{{$purchase->end_date}}</p>
                           <p><i class="fas fa-receipt text-green-500 mr-2"></i> Transaction: {{ $purchase->payment->transaction_id ?? 'N/A' }}</p>
                             <p><i class="fas fa-dollar-sign text-green-500 mr-2"></i> Amount: ${{ number_format($purchase->amount, 2) }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-purple-50 p-4 rounded-lg mb-6">
                        <h3 class="font-semibold text-purple-800 mb-2">What's Next?</h3>
                        <ul class="list-disc list-inside text-gray-700 space-y-2">
                            <li>You will receive a confirmation email shortly</li>
                            <li>Our wellness specialist will contact you within 24 hours</li>
                            <li>Access your personalized dashboard to schedule sessions</li>
                        </ul>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4 mt-8">
                        <a href="{{route('dashboard')}}" class="pulse bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-6 rounded-lg text-center transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-tachometer-alt mr-2"></i> Go to Dashboard
                        </a>
                        <a href="#" class="border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white font-bold py-3 px-6 rounded-lg text-center transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-download mr-2"></i> Download Invoice
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Package Benefits -->
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Your Package Benefits</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="text-blue-500 text-3xl mb-4">
                    <i class="fas fa-user-md"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">12 One-on-One Sessions</h3>
                <p class="text-gray-600">Personalized consultations with our wellness experts tailored to your needs.</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="text-green-500 text-3xl mb-4">
                    <i class="fas fa-apple-alt"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Nutrition Plan</h3>
                <p class="text-gray-600">Customized diet plan designed by our certified nutritionists.</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="text-purple-500 text-3xl mb-4">
                    <i class="fas fa-heart"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Health Monitoring</h3>
                <p class="text-gray-600">Regular health check-ups and progress tracking through our platform.</p>
            </div>
        </div>

        <!-- Next Steps -->
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Your Next Steps</h2>
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-xl font-semibold">Schedule Your First Session</h3>
                    <p class="text-gray-600">Get started by booking your initial consultation</p>
                </div>
                <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300">
                    Book Now
                </a>
            </div>
        </div>

        <!-- Support Section -->
        <div class="bg-gradient-to-r from-blue-400 to-purple-500 rounded-xl shadow-lg text-white p-8 mb-8">
            <div class="flex flex-col md:flex-row items-center">
                <div class="flex-1 mb-6 md:mb-0">
                    <h2 class="text-2xl font-bold mb-2">Need Assistance?</h2>
                    <p class="mb-4">Our support team is here to help you with any questions</p>
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

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">WellnessPlus</h3>
                    <p class="text-gray-400">Your journey to better health and wellness starts here.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Our Services</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Packages</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Testimonials</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">FAQs</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Contact Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Connect With Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
                <p>&copy; 2023 WellnessPlus. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Simple confirmation animation
        document.addEventListener('DOMContentLoaded', function() {
            const checkIcon = document.querySelector('.fa-check-circle');
            checkIcon.classList.add('pulse');
            
            // Remove animation after 5 seconds
            setTimeout(() => {
                checkIcon.classList.remove('pulse');
            }, 5000);
        });
    </script>
</section>
@endsection



