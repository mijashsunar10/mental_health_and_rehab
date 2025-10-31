@extends('template.template')
@section('pagecontent')

<section class="bg-gray-100 p-4 mt-20">
        <style>
        .check-icon {
            width: 20px;
            height: 20px;
            color: #10b981;
            flex-shrink: 0;
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 mb-12">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Our Doctors</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Meet our experienced team of medical professionals dedicated to providing exceptional healthcare services</p>
        </div>
    </div>
           <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mx-auto max-w-[85%]">

    @foreach($doctors as $doctor)
    <div class="max-w-md mx-auto bg-white rounded-2xl shadow-lg p-8">
        <!-- Header Section -->


        <div class="flex items-start gap-6 mb-8">
            <div class="w-24 h-24 rounded-full overflow-hidden flex-shrink-0">
                <img src="{{ $doctor->photo ? asset('storage/' . $doctor->photo) : asset('doctors/doctor.webp') }}"
                    alt="{{ $doctor->name }}" class="w-full h-full object-cover" />
            </div>

            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $doctor->name }}</h1>
                <p class="text-lg text-gray-600 mb-1">{{ $doctor->designation ?: 'Consultant Psychiatrist' }}</p>
                @if($doctor->address)
                <p class="text-lg text-gray-600 mb-3">{{ $doctor->address }}</p>
                @endif
                @if($doctor->nmc_number)
                <p class="text-sm text-gray-500 mb-4">NMC Number: {{ $doctor->nmc_number }}</p>
                @endif

                @if($doctor->specializations && count($doctor->specializations) > 0)
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    @foreach(array_slice($doctor->specializations, 0, 2) as $specialization)
                        <span class="bg-blue-900 text-white px-3 py-1 rounded-full text-sm font-medium">
                            {{ $specialization }}
                        </span>
                    @endforeach
                </div>
                @endif

                <div class="flex items-center gap-6 text-gray-600">
                    @if($doctor->address)
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-sm">{{ $doctor->address }}</span>
                    </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 mb-6">
            <div class="flex gap-8">
                <button id="specialization-tab-{{ $doctor->id }}"
                    class="tab-button pb-3 px-1 text-sm font-medium border-b-2 transition-colors text-blue-900 border-blue-900"
                    data-tab="specialization" data-doctor="{{ $doctor->id }}">
                    SPECIALIZATION
                </button>
                <button id="qualification-tab-{{ $doctor->id }}"
                    class="tab-button pb-3 px-1 text-sm font-medium border-b-2 transition-colors text-gray-500 border-transparent hover:text-gray-700"
                    data-tab="qualification" data-doctor="{{ $doctor->id }}">
                    QUALIFICATION
                </button>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="mb-8">
            <!-- Specialization Content -->
            <div id="specialization-content-{{ $doctor->id }}" class="tab-content">
                @if($doctor->specializations && count($doctor->specializations) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($doctor->specializations as $specialization)
                    <div class="flex items-center gap-3">
                        <svg class="check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-700">{{ $specialization }}</span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center text-gray-500 py-8">
                    <p>No specializations added yet.</p>
                </div>
                @endif
            </div>

            <!-- Qualification Content -->
            <div id="qualification-content-{{ $doctor->id }}" class="tab-content hidden">
                @if($doctor->qualifications && count($doctor->qualifications) > 0)
                <div class="space-y-4">
                    @foreach($doctor->qualifications as $qualification)
                    <div class="flex items-start gap-3">
                        <svg class="check-icon mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-700">{{ $qualification }}</span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center text-gray-500 py-8">
                    <p>No qualifications added yet.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Meet the Doctor Button -->
        <div class="text-center">
            <a href="{{ route('doctor.show', $doctor->id) }}">
            <button
                class="bg-blue-900 hover:bg-blue-800 text-white font-medium py-3 px-8 rounded-full transition-colors">
                Book Appointment
            </button>
            </a>
        </div>
    </div>
    @endforeach

           </div>
   
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Tab functionality
        var tabButtons = document.querySelectorAll('.tab-button');

        tabButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var targetTab = button.getAttribute('data-tab');
                var doctorId = button.getAttribute('data-doctor');

                // Get all buttons for this specific doctor
                var doctorButtons = document.querySelectorAll('[data-doctor="' + doctorId + '"]');

                // Remove active state from all tabs of this doctor
                doctorButtons.forEach(function (btn) {
                    btn.classList.remove('text-blue-900', 'border-blue-900');
                    btn.classList.add('text-gray-500', 'border-transparent');
                });

                // Add active state to clicked tab
                button.classList.remove('text-gray-500', 'border-transparent');
                button.classList.add('text-blue-900', 'border-blue-900');

                // Hide all tab contents for this doctor
                document.getElementById('specialization-content-' + doctorId).classList.add('hidden');
                document.getElementById('qualification-content-' + doctorId).classList.add('hidden');

                // Show target tab content
                document.getElementById(targetTab + '-content-' + doctorId).classList.remove('hidden');
            });
        });
    });
</script>
@endsection