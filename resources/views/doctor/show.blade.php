@extends('template.template')
@section('pagecontent')
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .calendar-day {
            transition: all 0.2s ease;
        }

        .calendar-day:hover {
            transform: translateY(-1px);
        }

        .available-slot {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .unavailable-slot {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .selected-slot {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
<section class="bg-gray-50 mt-20">
    <!-- Header Navigation -->

    <div class="max-w-[90%] mx-auto">
        <!-- Hero Section -->
        <div class="gradient-bg text-white">
            <div class="px-6 py-12">
                <div class="flex flex-col lg:flex-row items-start gap-8">
                    <div
                        class="w-48 h-48 rounded-2xl overflow-hidden flex-shrink-0 border-4 border-white/20 shadow-2xl">
                        <img src="{{ $doctor->photo ? asset('storage/' . $doctor->photo) : asset('doctors/doctor.webp') }}"
                            alt="{{ $doctor->name }}" class="w-full h-full object-cover" />
                    </div>

                    <div class="flex-1">
                        <div class="mb-4">
                            <h1 class="text-4xl lg:text-5xl font-bold mb-3">{{ $doctor->name }}</h1>
                            <p class="text-xl mb-2 text-blue-100"> Consultant Psychiatrist</p>
                            @if($doctor->address)
                            <p class="text-lg mb-3 text-blue-100">{{ $doctor->address }}</p>
                            @endif
                            @if($doctor->nmc_number)
                            <div class="flex items-center gap-2 text-sm text-blue-100">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>NMC Number: {{ $doctor->nmc_number }}</span>
                            </div>
                            @endif
                        </div>
                        <!-- department -->
                        <div class="flex flex-wrap gap-3 mb-6">
                            <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">
                                D.N.B. (Psychiatry)
                            </span>
                            <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">
                                MBBS </span>
                        </div>

                        <div class="grid grid-cols-3 gap-6 max-w-md">
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-1">30+</div>
                                <div class="text-sm text-blue-100">Years Experience</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-1">15K+</div>
                                <div class="text-sm text-blue-100">Sucessfully Patients treated</div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="lg:w-80 w-full">
                        <div class="glass-effect rounded-2xl p-6 shadow-xl">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Info</h3>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3 text-sm text-gray-700">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>Select a date and time in the booking section below</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col lg:flex-row gap-8 px-6 py-8">
            <!-- Left Content -->
            <div class="flex-1">
                <!-- Tab Navigation -->
                <div class="bg-white rounded-xl shadow-sm border mb-6">
                    <div class="flex gap-1 p-1">
                        <button
                            class="tab-btn flex-1 py-3 px-4 text-sm font-medium rounded-lg transition-all duration-200 bg-blue-50 text-blue-600"
                            data-tab="overview">
                            Overview
                        </button>
                        <button
                            class="tab-btn flex-1 py-3 px-4 text-sm font-medium rounded-lg transition-all duration-200 text-gray-600 hover:text-gray-800"
                            data-tab="experience">
                            Experience
                        </button>
                        <button
                            class="tab-btn flex-1 py-3 px-4 text-sm font-medium rounded-lg transition-all duration-200 text-gray-600 hover:text-gray-800"
                            data-tab="qualifications">
                            Qualifications
                        </button>
                        <button
                            class="tab-btn flex-1 py-3 px-4 text-sm font-medium rounded-lg transition-all duration-200 text-gray-600 hover:text-gray-800"
                            data-tab="awards">
                            Awards
                        </button>
                    </div>
                </div>

                <!-- Tab Contents -->
                <div class="bg-white rounded-xl shadow-sm border p-8">
                    <!-- Overview Tab -->
                    <div id="overview-content" class="tab-content animate-fade-in">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">About Dr. Sangam Darlami</h2>
                        <div class="prose max-w-none text-gray-700 leading-relaxed space-y-4">
                            <p>
                                As a pioneering member of the team that performed India's first successful Heart
                                Transplantation in 1994, Dr. Bhan has been instrumental in establishing cardiac surgical
                                programs at Puttaparthi (1992), Whitefield (2001), and Max Heart and Vascular Institute
                                Saket (2004).
                            </p>
                            <p>
                                Having performed over 15,000 cardiovascular surgeries, including complex aortic
                                surgeries, heart transplants, and pediatric cardiac procedures, Dr. Bhan's expertise in
                                minimally invasive cardiac surgery has revolutionized treatment approaches across India.
                            </p>
                        </div>

                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-blue-50 rounded-xl p-6">
                                <h3 class="font-semibold text-gray-800 mb-4">Specializations</h3>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2 text-sm">
                                        <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                                        <span>Aortic Surgery</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm">
                                        <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                                        <span>Heart Transplantation</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-green-50 rounded-xl p-6">
                                <h3 class="font-semibold text-gray-800 mb-4">Languages</h3>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-white px-3 py-1 rounded-full text-sm">English</span>
                                    <span class="bg-white px-3 py-1 rounded-full text-sm">Hindi</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Experience Tab -->
                    <div id="experience-content" class="tab-content hidden">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Professional Experience</h2>
                        <div class="space-y-6">
                            <div class="border-l-4 border-blue-600 pl-6">
                                <h3 class="text-lg font-semibold text-gray-800">Director & Head - Cardiovascular Surgery
                                </h3>
                                <p class="text-blue-600 font-medium">Medanta - The Medicity, Gurugram</p>
                                <p class="text-sm text-gray-600">2010 - Present</p>
                                <p class="text-gray-700 mt-2">Leading the cardiovascular surgery department with over
                                    2000 successful surgeries annually.</p>
                            </div>

                            <div class="border-l-4 border-gray-300 pl-6">
                                <h3 class="text-lg font-semibold text-gray-800">Senior Consultant</h3>
                                <p class="text-gray-600 font-medium">Max Heart and Vascular Institute</p>
                                <p class="text-sm text-gray-600">2004 - 2010</p>
                                <p class="text-gray-700 mt-2">Established and led the cardiac surgery program.</p>
                            </div>

                        </div>
                    </div>

                    <!-- Qualifications Tab -->
                    <div id="qualifications-content" class="tab-content hidden">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Educational Qualifications</h2>
                        <div class="space-y-4">
                            <div
                                class="bg-gradient-to-r from-blue-50 to-transparent rounded-xl p-6 border-l-4 border-blue-600">
                                <h3 class="text-lg font-semibold text-gray-800">Fellowship in Heart Transplantation</h3>
                                <p class="text-gray-600">University of Pittsburgh Medical Center, USA • 1994</p>
                            </div>

                            <div
                                class="bg-gradient-to-r from-yellow-50 to-transparent rounded-xl p-6 border-l-4 border-yellow-500">
                                <h3 class="text-lg font-semibold text-gray-800">MBBS (Gold Medalist)</h3>
                                <p class="text-gray-600">Medical College Srinagar • 1985</p>
                                <p class="text-sm text-yellow-600 font-medium">Best Outgoing Graduate</p>
                            </div>
                        </div>
                    </div>

                    <!-- Awards Tab -->
                    <div id="awards-content" class="tab-content hidden">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Awards & Recognition</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div
                                class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl p-6 border border-yellow-200">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Padma Bhushan</h3>
                                        <p class="text-sm text-gray-600">Government of India, 2010</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700">For distinguished service in the field of medicine</p>
                            </div>

                            <div
                                class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Dr. B.C. Roy Award</h3>
                                        <p class="text-sm text-gray-600">Medical Council of India, 2008</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700">National Award for excellence in medicine</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar - Appointment Booking -->
            <div class="lg:w-96 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Book Appointment</h3>
                    <livewire:book-appointment :doctorId="$doctor->id" />
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const targetTab = button.getAttribute('data-tab');

                    // Remove active state from all tabs
                    tabButtons.forEach(btn => {
                        btn.classList.remove('bg-blue-50', 'text-blue-600');
                        btn.classList.add('text-gray-600');
                    });

                    // Add active state to clicked tab
                    button.classList.remove('text-gray-600');
                    button.classList.add('bg-blue-50', 'text-blue-600');

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                        content.classList.remove('animate-fade-in');
                    });

                    // Show target tab content with animation
                    const targetContent = document.getElementById(targetTab + '-content');
                    targetContent.classList.remove('hidden');
                    setTimeout(() => {
                        targetContent.classList.add('animate-fade-in');
                    }, 10);
                });
            });
        });
    </script>
</section>

@endsection