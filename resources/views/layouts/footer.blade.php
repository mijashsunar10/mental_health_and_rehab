 <style>
        .calm-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 25%, #2563eb 50%, #3b82f6 75%, #60a5fa 100%);
            position: relative;
        }
        .calm-overlay {
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 197, 253, 0.05) 100%);
        }
        .wave-top {
            background-image: url("data:image/svg+xml,%3csvg width='100' height='20' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M0 20 Q25 5 50 15 T100 10 V0 H0 Z' fill='%23ffffff' fill-opacity='0.1'/%3e%3c/svg%3e");
            background-repeat: repeat-x;
            background-position: top;
            background-size: 100px 20px;
        }
        .floating-element {
            animation: gentleFloat 8s ease-in-out infinite;
        }
        @keyframes gentleFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.3; }
            50% { transform: translateY(-15px) rotate(180deg); opacity: 0.6; }
        }
        .therapeutic-glow {
            box-shadow: 0 0 20px rgba(96, 165, 250, 0.3);
        }
        .calm-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .calm-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2);
        }
        .text-glow {
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }
        .breathing-animation {
            animation: breathe 4s ease-in-out infinite;
        }
        @keyframes breathe {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    </style>
<footer class="bg-[#140b37]" id="footer">
    <!-- Main content spacer -->
    <div class="min-h-screen flex items-end">
        
        <!-- Footer -->
        <footer class="w-full calm-gradient wave-top relative overflow-hidden">
            <!-- Floating therapeutic elements -->
            <div class="absolute top-8 left-16 w-20 h-20 rounded-full bg-white opacity-10 floating-element"></div>
            <div class="absolute top-20 right-20 w-12 h-12 rounded-full bg-blue-200 opacity-20 floating-element" style="animation-delay: -2s;"></div>
            <div class="absolute bottom-32 left-1/3 w-16 h-16 rounded-full bg-blue-100 opacity-15 floating-element" style="animation-delay: -4s;"></div>
            <div class="absolute bottom-20 right-1/4 w-8 h-8 rounded-full bg-white opacity-20 floating-element" style="animation-delay: -6s;"></div>
            
            <!-- Calm overlay -->
            <div class="calm-overlay absolute inset-0"></div>
            
            <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 py-16">
                <!-- Main footer content -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 mb-12">
                    
                    <!-- Brand Section -->
                    <div class="lg:col-span-1">
                        <div class="flex items-center mb-8 calm-hover">
                            <div class="w-16 h-16 bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl flex items-center justify-center mr-4 therapeutic-glow breathing-animation">
                                <i class="fas fa-heart text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-3xl font-bold text-white text-glow">Calm Core</h3>
                                <p class="text-blue-200 text-lg font-medium">Recovery</p>
                            </div>
                        </div>
                        <p class="text-blue-100 mb-8 leading-relaxed text-lg">
                            Our aim is to provide clients with every kind of therapeutic support and healing programs recovery can possibly offer. Our team of expert therapists and psychiatrists is always there to answer your specific needs with absolutely authentic care and help you design your healing journey that perfectly suits your recovery goals and wellbeing.
                        </p>
                        
                        <!-- Payment/Support Icons -->
                        <div class="mb-8">
                            <p class="text-blue-200 mb-4 font-medium">We Support:</p>
                            <div class="flex space-x-3">
                                <div class="w-12 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center calm-hover">
                                    <i class="fas fa-shield-alt text-white text-sm"></i>
                                </div>
                                <div class="w-12 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center calm-hover">
                                    <i class="fas fa-lock text-white text-sm"></i>
                                </div>
                                <div class="w-12 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center calm-hover">
                                    <i class="fas fa-user-md text-white text-sm"></i>
                                </div>
                                <div class="w-12 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center calm-hover">
                                    <i class="fas fa-heart text-white text-sm"></i>
                                </div>
                                <div class="w-12 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center calm-hover">
                                    <i class="fas fa-handshake text-white text-sm"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-2xl font-semibold text-white mb-8 text-glow">Quick Link</h4>
                        <div class="w-16 h-1 bg-blue-300 mb-8"></div>
                        <ul class="space-y-4">
                            <li><a href="#" class="text-blue-100 hover:text-white transition-all duration-300 text-lg calm-hover block">About Our Mission</a></li>
                            <li><a href="#" class="text-blue-100 hover:text-white transition-all duration-300 text-lg calm-hover block">Contact Us</a></li>
                            <li><a href="#" class="text-blue-100 hover:text-white transition-all duration-300 text-lg calm-hover block">Terms and Conditions</a></li>
                            <li><a href="#" class="text-blue-100 hover:text-white transition-all duration-300 text-lg calm-hover block">Our Services</a></li>
                            <li><a href="#" class="text-blue-100 hover:text-white transition-all duration-300 text-lg calm-hover block">Online Therapy</a></li>
                            <li><a href="#" class="text-blue-100 hover:text-white transition-all duration-300 text-lg calm-hover block">Recovery Programs</a></li>
                            <li><a href="#" class="text-blue-100 hover:text-white transition-all duration-300 text-lg calm-hover block">Support Groups</a></li>
                            <li><a href="#" class="text-blue-100 hover:text-white transition-all duration-300 text-lg calm-hover block">Wellness Blog</a></li>
                        </ul>
                    </div>
                    
                    <!-- Contact Details -->
                    <div>
                        <h4 class="text-2xl font-semibold text-white mb-8 text-glow">Contact Details</h4>
                        <div class="w-16 h-1 bg-blue-300 mb-8"></div>
                        
                        <div class="space-y-6">
                            <div class="text-blue-100 text-lg leading-relaxed">
                                <p class="mb-2">Wellness Center, Mental Health District,</p>
                                <p>Recovery Plaza, Healing Post Box</p>
                                <p>No:- 24/7</p>
                            </div>
                            
                            <div class="space-y-3">
                                <p class="text-white text-xl font-semibold">+1-800-CALM-HELP</p>
                                <p class="text-white text-xl font-semibold">+1-877-RECOVERY</p>
                            </div>
                            
                            <div class="space-y-2">
                                <p class="text-blue-100 flex items-center text-lg">
                                    <i class="fas fa-envelope mr-3 text-blue-300"></i>
                                    info@calmcorerecovery.com
                                </p>
                                <p class="text-blue-100 flex items-center text-lg">
                                    <i class="fas fa-headset mr-3 text-blue-300"></i>
                                    support@calmcorerecovery.com
                                </p>
                                <p class="text-blue-100 flex items-center text-lg">
                                    <i class="fas fa-user-md mr-3 text-blue-300"></i>
                                    therapy@calmcorerecovery.com
                                </p>
                            </div>
                            
                            <!-- Crisis Notice -->
                            <div class="bg-red-500 bg-opacity-20 border border-red-300 border-opacity-30 rounded-xl p-4 backdrop-blur-sm">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-exclamation-triangle text-red-200 mr-2"></i>
                                    <p class="text-red-100 font-semibold">Crisis Emergency?</p>
                                </div>
                                <p class="text-red-200 text-sm">Press Panic Button or Call Us</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Bottom Section -->
                <div class="border-t border-blue-400 border-opacity-30 pt-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="mb-4 lg:mb-0">
                            <p class="text-blue-100 text-lg">
                                <i class="fas fa-copyright mr-2"></i>
                                Copyright 2025 - Calm Core Recovery - by Healing Hearts Team
                            </p>
                        </div>
                        
                        <!-- Social Media -->
                        <div class="flex space-x-4">
                            <a href="#" class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-opacity-30 transition-all duration-300 calm-hover therapeutic-glow">
                                <i class="fab fa-facebook-f text-lg"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-opacity-30 transition-all duration-300 calm-hover therapeutic-glow">
                                <i class="fab fa-twitter text-lg"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-opacity-30 transition-all duration-300 calm-hover therapeutic-glow">
                                <i class="fab fa-instagram text-lg"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-opacity-30 transition-all duration-300 calm-hover therapeutic-glow">
                                <i class="fab fa-youtube text-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </footer>
    </div>
</footer>