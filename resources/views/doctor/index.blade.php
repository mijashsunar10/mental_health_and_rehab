@extends('template.template')
@section('pagecontent')

<section class="bg-gray-100 p-4">
        <style>
        .check-icon {
            width: 20px;
            height: 20px;
            color: #10b981;
            flex-shrink: 0;
        }
    </style>
    <div class="max-w-md mx-auto bg-white rounded-2xl shadow-lg p-8">
        <!-- Header Section -->
        <div class="flex items-start gap-6 mb-8">
            <div class="w-24 h-24 rounded-full overflow-hidden flex-shrink-0">
                <img src=""
                    alt="Dr. Naresh Trehan" class="w-full h-full object-cover" />
            </div>

            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Dr. Sangam Darlami </h1>
                <p class="text-lg text-gray-600 mb-1">Consultant Psychiatrist</p>
                <p class="text-lg text-gray-600 mb-3">Calm Core Recovery ,Pokhara</p>
                <p class="text-sm text-gray-500 mb-4">NMC Number: 12345</p>

                <div class="flex items-center gap-1 mb-4">
                    <span class="bg-blue-900 text-white px-3 py-1 rounded-full text-sm font-medium">
                        Depression 
                    </span>
                    <span class="bg-blue-900 text-white px-3 py-1 rounded-full text-sm font-medium">
                        Anxiety 
                    </span>

                </div>

                <div class="flex items-center gap-6 text-gray-600">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-sm">Pokhara</span>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 mb-6">
            <div class="flex gap-8">
                <button id="specialization-tab"
                    class="tab-button pb-3 px-1 text-sm font-medium border-b-2 transition-colors text-blue-900 border-blue-900"
                    data-tab="specialization">
                    SPECIALIZATION
                </button>
                <button id="qualification-tab"
                    class="tab-button pb-3 px-1 text-sm font-medium border-b-2 transition-colors text-gray-500 border-transparent hover:text-gray-700"
                    data-tab="qualification">
                    QUALIFICATION
                </button>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="mb-8">
            <!-- Specialization Content -->
            <div id="specialization-content" class="tab-content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center gap-3">
                        <svg class="check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-700">>Depression & Anxiety Disorders</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-700">Schizophrenia & Psychotic Disorders</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-700">Child & Adolescent Psychiatry</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-700">Cognitive Behavioral Therapy (CBT)</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-700">Bipolar Disorder</span>
                    </div>
                </div>
            </div>

            <!-- Qualification Content -->
            <div id="qualification-content" class="tab-content hidden">
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <svg class="check-icon mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-700">MBBS - King George's Medical University, 2013</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="check-icon mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-700">MD (Psychiatry) - King George's Medical University, 2016</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="check-icon mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-700">Certificate in Cognitive Behavioral Therapy
                            International Institute of CBT, London • 2016</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="check-icon mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-700">Certificate in Addiction Medicine - Cleveland Clinic, USA, 2018</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meet the Doctor Button -->
        <div class="text-center">
            <button
                class="bg-blue-900 hover:bg-blue-800 text-white font-medium py-3 px-8 rounded-full transition-colors">
                View Profile
            </button>
        </div>
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
        var tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var targetTab = button.getAttribute('data-tab');

                // Remove active state from all tabs
                tabButtons.forEach(function (btn) {
                    btn.classList.remove('text-blue-900', 'border-blue-900');
                    btn.classList.add('text-gray-500', 'border-transparent');
                });

                // Add active state to clicked tab
                button.classList.remove('text-gray-500', 'border-transparent');
                button.classList.add('text-blue-900', 'border-blue-900');

                // Hide all tab contents
                tabContents.forEach(function (content) {
                    content.classList.add('hidden');
                });

                // Show target tab content
                document.getElementById(targetTab + '-content').classList.remove('hidden');
            });
        });
    });
</script>
@endsection