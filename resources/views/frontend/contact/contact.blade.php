@extends('template.template')

@section('pagecontent')
<style>
    :root {
        /* Blue Color Palette */
        --blue-50: hsl(210, 100%, 98%);
        --blue-100: hsl(210, 100%, 96%);
        --blue-200: hsl(210, 100%, 90%);
        --blue-300: hsl(210, 100%, 80%);
        --blue-400: hsl(210, 100%, 70%);
        --blue-500: hsl(210, 100%, 60%);
        --blue-600: hsl(210, 100%, 50%);
        --blue-700: hsl(210, 100%, 40%);
        --blue-800: hsl(210, 100%, 30%);
        --blue-900: hsl(210, 100%, 20%);
        --blue-950: hsl(210, 100%, 10%);
        
        /* Glass Morphism Effects */
        --glass-bg: 210, 100%, 50%;
        --glass-border: 210, 100%, 80%;
        --card: 210, 40%, 96%;
        --border: 210, 30%, 85%;
    }

    /* Animations */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Glass cards */
    .contact-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(16px);
        border: 1px solid var(--blue-200);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(66, 153, 225, 0.2);
    }

    /* Form elements */
    .form-input {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid var(--blue-200);
        transition: all 0.3s ease;
    }
    
    .form-input:focus {
        border-color: var(--blue-500);
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.3);
        outline: none;
    }

    /* Buttons */
    .submit-btn {
        background: linear-gradient(135deg, var(--blue-500), var(--blue-600));
        color: white;
        box-shadow: 0 4px 15px rgba(66, 153, 225, 0.3);
        transition: all 0.3s ease;
    }
    
    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(66, 153, 225, 0.5);
    }

    /* Floating orbs */
    .floating-orb {
        position: fixed;
        border-radius: 50%;
        filter: blur(40px);
        z-index: 0;
        opacity: 0.6;
    }

    .animate-float { animation: float 6s ease-in-out infinite; }
    .animate-float-delay { animation: float 7s ease-in-out infinite 1s; }
    .animate-float-delay-2 { animation: float 8s ease-in-out infinite 2s; }
    .animate-fadeInUp { animation: fadeInUp 0.8s ease-out forwards; }
    .fa-spinner { animation: spin 1s linear infinite; }

    /* Flash messages */
    .flash-message {
        transition: all 0.3s ease;
    }
</style>

<!-- Flash Message Container -->
<div id="flashMessage" class="fixed top-16 left-0 right-0 text-center py-3 z-50 hidden flash-message">
    <span id="flashMessageText" class="px-4 py-2 rounded-lg"></span>
</div>

<!-- Loading Indicator -->
<div id="loadingIndicator" class="fixed top-16 left-0 right-0 bg-blue-600 text-white text-center py-3 z-50 hidden animate-fade-in">
    Sending your message... <i class="fas fa-spinner fa-spin"></i>
</div>

<section id="contact" class="min-h-screen relative mt-8 py-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-white to-blue-50 overflow-hidden">
    <!-- Floating background elements -->
    <div class="floating-orb top-20 left-10 w-64 h-64 bg-blue-100 animate-float"></div>
    <div class="floating-orb bottom-1/3 right-20 w-72 h-72 bg-blue-200 animate-float-delay"></div>
    <div class="floating-orb top-1/4 right-1/4 w-48 h-48 bg-blue-300 animate-float-delay-2"></div>

    <div class="relative z-10 max-w-7xl mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-16 animate-fadeInUp">
            <h2 class="text-4xl md:text-5xl font-bold text-blue-900 mb-4 relative inline-block">
                Contact Calm Core
                <div class="absolute bottom-0 left-1/2 w-32 h-1.5 bg-blue-500 transform -translate-x-1/2 rounded-full"></div>
            </h2>
            <p class="text-xl text-blue-700 max-w-2xl mx-auto leading-relaxed" style="animation-delay: 0.2s">
                Have questions about our programs or services? We're here to help with all your inquiries!
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column - Contact Info -->
            <div class="space-y-8">
                <!-- Contact Information Card -->
                <div class="contact-card rounded-2xl overflow-hidden animate-fadeInUp">
                    <div class="bg-gradient-to-r from-blue-800 to-blue-900 py-6 px-8 text-center">
                        <h3 class="text-2xl font-semibold text-white">Our Information</h3>
                    </div>
                    
                    <div class="p-8 space-y-8">
                        <!-- Address -->
                        <div class="flex items-start" style="animation-delay: 0.2s">
                            <div class="bg-blue-500 p-3 rounded-full shadow-md flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="ml-6">
                                <h4 class="text-xl font-semibold text-blue-800 mb-2">Recovery Center</h4>
                                <p class="text-blue-700">123 Serenity Lane, Peace Valley</p>
                                <p class="text-blue-500 text-sm mt-1">Open Monday-Friday, 8AM-8PM</p>
                            </div>
                        </div>
                        
                        <!-- Phone -->
                        <div class="flex items-start" style="animation-delay: 0.3s">
                            <div class="bg-blue-500 p-3 rounded-full shadow-md flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div class="ml-6">
                                <h4 class="text-xl font-semibold text-blue-800 mb-2">Call Us</h4>
                                <p class="text-blue-700">(123) 456-7890</p>
                                <a href="tel:+11234567890" class="text-blue-600 hover:text-blue-800 text-sm font-medium mt-1 inline-block transition-colors">
                                    Click to call →
                                </a>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="flex items-start" style="animation-delay: 0.4s">
                            <div class="bg-blue-500 p-3 rounded-full shadow-md flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-6">
                                <h4 class="text-xl font-semibold text-blue-800 mb-2">Email Us</h4>
                                <p class="text-blue-700">contact@calmcorerecovery.com</p>
                                <a href="mailto:contact@calmcorerecovery.com" class="text-blue-600 hover:text-blue-800 text-sm font-medium mt-1 inline-block transition-colors">
                                    Send email →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media Card -->
                <div class="contact-card rounded-2xl overflow-hidden animate-fadeInUp" style="animation-delay: 0.2s">
                    <div class="bg-gradient-to-r from-blue-800 to-blue-900 py-6 px-8 text-center">
                        <h3 class="text-2xl font-semibold text-white">Connect With Us</h3>
                    </div>
                    
                    <div class="p-8">
                        <div class="flex justify-center space-x-6">
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-2xl transition-colors" style="animation-delay: 0.3s">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-2xl transition-colors" style="animation-delay: 0.4s">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-2xl transition-colors" style="animation-delay: 0.5s">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-2xl transition-colors" style="animation-delay: 0.6s">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                        <p class="text-center text-blue-700 mt-8" style="animation-delay: 0.7s">
                            Join our community for wellness tips, recovery stories, and program updates
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Contact Form -->
            <div class="contact-card rounded-2xl overflow-hidden animate-fadeInUp" style="animation-delay: 0.4s">
                <div class="bg-gradient-to-r from-blue-800 to-blue-900 py-6 px-8 text-center">
                    <h3 class="text-2xl font-semibold text-white">Send Us a Message</h3>
                </div>
                
                <form id="contactForm" class="p-8 space-y-6">
                    @csrf
                    <div>
                        <label class="block text-lg font-medium text-blue-800 mb-3">Full Name</label>
                        <input type="text" name="name" class="form-input w-full px-5 py-3 rounded-lg text-blue-900 placeholder-blue-400" placeholder="Your Name" required>
                    </div>
                    
                    <div>
                        <label class="block text-lg font-medium text-blue-800 mb-3">Email Address</label>
                        <input type="email" name="email" class="form-input w-full px-5 py-3 rounded-lg text-blue-900 placeholder-blue-400" placeholder="your@email.com" required>
                    </div>
                    
                    <div>
                        <label class="block text-lg font-medium text-blue-800 mb-3">Phone Number</label>
                        <input type="tel" name="whatsapp" class="form-input w-full px-5 py-3 rounded-lg text-blue-900 placeholder-blue-400" placeholder="(123) 456-7890">
                    </div>
                    
                    <div>
                        <label class="block text-lg font-medium text-blue-800 mb-3">Your Message</label>
                        <textarea rows="5" name="message" class="form-input w-full px-5 py-3 rounded-lg text-blue-900 placeholder-blue-400" placeholder="Tell us how we can help..."></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn w-full py-4 px-6 rounded-full font-bold flex items-center justify-center gap-2 mt-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                        Send Message
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Map Section -->
        <div class="mt-20 text-center animate-fadeInUp" style="animation-delay: 0.6s">
            <h3 class="text-3xl font-bold text-blue-900 mb-6">Our Healing Space</h3>
            <p class="text-lg text-blue-700 mb-8">Visit our tranquil recovery center</p>
            
            <div class="contact-card h-96 w-full rounded-2xl overflow-hidden">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.215209132579!2d-73.98827968459382!3d40.74844097932799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDQ0JzU0LjQiTiA3M8KwNTknMDkuNyJX!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        const flashMessage = document.getElementById('flashMessage');
        const flashMessageText = document.getElementById('flashMessageText');
        const loadingIndicator = document.getElementById('loadingIndicator');

        // Show loading indicator
        loadingIndicator.classList.remove('hidden');

        fetch('{{ route('contact.send') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData,
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            // Show success message
            flashMessageText.textContent = data.message;
            flashMessage.classList.remove('hidden', 'bg-red-500', 'text-white');
            flashMessage.classList.add('bg-green-500', 'text-white');
            flashMessageText.classList.add('px-4', 'py-2', 'rounded-lg');
            
            // Reset form
            form.reset();
        })
        .catch(error => {
            // Show error message
            flashMessageText.textContent = error.message || 'An error occurred. Please try again.';
            flashMessage.classList.remove('hidden', 'bg-green-500', 'text-white');
            flashMessage.classList.add('bg-red-500', 'text-white');
            flashMessageText.classList.add('px-4', 'py-2', 'rounded-lg');
        })
        .finally(() => {
            // Hide loading indicator
            loadingIndicator.classList.add('hidden');
            
            // Show flash message
            flashMessage.classList.remove('hidden');
            
            // Hide flash message after 4 seconds
            setTimeout(() => {
                flashMessage.classList.add('hidden');
            }, 4000);
        });
    });

    // Scroll reveal animation setup
    document.addEventListener('DOMContentLoaded', () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeInUp');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.animate-fadeInUp').forEach(el => {
            observer.observe(el);
        });
    });
</script>
@endsection