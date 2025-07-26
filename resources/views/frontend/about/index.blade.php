@extends('template.template')

@section('pagecontent')
<div class="relative overflow-hidden">
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gray-900">
        <!-- Darkened Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                 alt="Serene mental health recovery" 
                 class="w-full h-full object-cover opacity-70">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 to-gray-800/50"></div>
        </div>
        
        <!-- Hero Content -->
        <div class="relative z-10 text-center px-4 py-20">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight animate-fade-in">
                Welcome to <span class="text-blue-300">CalmCore Recovery</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto animate-fade-in animate-delay-100">
                Where <span class="font-semibold text-blue-200">mental wellness</span> meets compassionate care in a journey of transformation
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in animate-delay-200">
                <a href="#our-story" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold transition-all duration-300 shadow-lg hover:shadow-blue-500/30">
                    Our Story
                </a>
                <a href="/contact" class="px-8 py-3 border-2 border-blue-300 text-blue-100 hover:bg-blue-900/30 rounded-lg font-bold transition-all duration-300">
                    Contact Us
                </a>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 z-10 animate-bounce">
            <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <!-- Our Story Section -->
    {{-- <section id="our-story" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <div class="lg:flex items-center gap-12">
                <div class="lg:w-1/2 mb-12 lg:mb-0 animate-fade-in-left">
                    <div class="relative rounded-xl overflow-hidden shadow-xl h-96">
                        <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80" 
                             alt="Therapist session" 
                             class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="lg:w-1/2 animate-fade-in-right">
                    <h2 class="text-3xl font-bold text-blue-800 mb-6">
                        Our <span class="text-blue-600">Story</span> of Healing
                    </h2>
                    <p class="text-blue-700 mb-6 text-lg leading-relaxed">
                        Founded in 2015, CalmCore Recovery began with a simple vision: to create a sanctuary where mental health recovery is treated with the same urgency and compassion as physical health. What started as a small practice has grown into a nationally recognized center of excellence.
                    </p>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 transition-all hover:shadow-md">
                            <h3 class="text-xl font-semibold text-blue-800 mb-3">Our Philosophy</h3>
                            <p class="text-blue-700">
                                Healing happens when science meets soul - we combine cutting-edge therapies with human connection
                            </p>
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 transition-all hover:shadow-md">
                            <h3 class="text-xl font-semibold text-blue-800 mb-3">Why We're Different</h3>
                            <p class="text-blue-700">
                                Personalized treatment plans that evolve with you, not rigid programs that force you to conform
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <div id="our-story">

    @include('frontend.home.about')
    </div>

    
    @include('frontend.home.aboutus1')

    <!-- Approach Section -->
    <section class="py-20 bg-blue-50">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-blue-800 mb-4">Our Transformative Approach</h2>
                <p class="text-blue-700 max-w-2xl mx-auto text-lg">
                    We don't just treat symptoms - we help rewrite life stories through innovative care
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 animate-fade-in">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-blue-800 mb-3 text-center">Therapy & Counseling</h3>
                    <p class="text-blue-700 text-center">
                        Evidence-based individual and group therapy sessions tailored to your unique needs
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 animate-fade-in animate-delay-200">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-blue-800 mb-3 text-center">Mindfulness Practices</h3>
                    <p class="text-blue-700 text-center">
                        Techniques to help you stay present, reduce anxiety, and build emotional resilience
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 animate-fade-in animate-delay-400">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-blue-800 mb-3 text-center">Community Healing</h3>
                    <p class="text-blue-700 text-center">
                        Supportive group environments that foster connection and shared growth
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="py-20 bg-blue-800 text-white">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Voices of Healing</h2>
                <p class="text-blue-200 max-w-2xl mx-auto">
                    Stories of transformation from our CalmCore family
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-blue-700/50 p-8 rounded-xl backdrop-blur-sm animate-fade-in">
                    <div class="flex items-start mb-6">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Sarah J." class="w-16 h-16 rounded-full border-2 border-blue-400 mr-4">
                        <div>
                            <h4 class="text-xl font-bold">Sarah J.</h4>
                            <p class="text-blue-300">Anxiety Recovery</p>
                        </div>
                    </div>
                    <p class="text-blue-100 italic">
                        "CalmCore didn't just give me coping mechanisms - they helped me rediscover who I was before anxiety took over. After 12 years of struggling, I finally have my life back."
                    </p>
                    <div class="mt-6 flex">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <!-- Repeat 4 more times for 5 stars -->
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-blue-700/50 p-8 rounded-xl backdrop-blur-sm animate-fade-in animate-delay-200">
                    <div class="flex items-start mb-6">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael T." class="w-16 h-16 rounded-full border-2 border-blue-400 mr-4">
                        <div>
                            <h4 class="text-xl font-bold">Michael T.</h4>
                            <p class="text-blue-300">Depression Recovery</p>
                        </div>
                    </div>
                    <p class="text-blue-100 italic">
                        "The team at CalmCore understood my depression in ways no one else ever had. Their integrative approach addressed both my brain chemistry and life circumstances."
                    </p>
                    <div class="mt-6 flex">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <!-- Repeat 4 more times for 5 stars -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-blue-900 to-blue-700 text-white">
        <div class="max-w-4xl mx-auto text-center px-6">
            <h2 class="text-4xl font-bold mb-8 animate-fade-in">
                Your Healing Journey Starts Here
            </h2>
            <p class="text-xl text-blue-200 mb-10 max-w-2xl mx-auto animate-fade-in animate-delay-100">
                Take the first step toward a brighter tomorrow. Our compassionate team is ready to walk with you.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-6 animate-fade-in animate-delay-200">
                <a href="/contact" class="px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white rounded-lg font-bold shadow-lg hover:shadow-blue-500/30 transition-all duration-300">
                    Schedule Consultation
                </a>
                <a href="/programs" class="px-8 py-4 border-2 border-blue-400 hover:bg-blue-800/30 text-blue-100 hover:text-white rounded-lg font-bold transition-all duration-300">
                    Explore Programs
                </a>
            </div>
        </div>
    </section>
</div>

<style>
    /* Animation Classes */
    .animate-fade-in {
        opacity: 0;
        animation: fadeIn 1s ease-out forwards;
    }
    
    .animate-fade-in-left {
        opacity: 0;
        transform: translateX(-20px);
        animation: fadeInLeft 1s ease-out forwards;
    }
    
    .animate-fade-in-right {
        opacity: 0;
        transform: translateX(20px);
        animation: fadeInRight 1s ease-out forwards;
    }
    
    .animate-delay-100 {
        animation-delay: 0.1s;
    }
    
    .animate-delay-200 {
        animation-delay: 0.2s;
    }
    
    .animate-delay-400 {
        animation-delay: 0.4s;
    }
    
    /* Keyframes */
    @keyframes fadeIn {
        to {
            opacity: 1;
        }
    }
    
    @keyframes fadeInLeft {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes fadeInRight {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    .animate-bounce {
        animation: bounce 2s infinite;
    }
    
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
</style>

<script>
    // Simple intersection observer for animations
    document.addEventListener('DOMContentLoaded', function() {
        const animateElements = document.querySelectorAll('[class*="animate-"]');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, { threshold: 0.1 });

        animateElements.forEach(element => {
            observer.observe(element);
        });
    });
</script>
@endsection