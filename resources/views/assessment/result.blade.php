@extends('template.template')

@section('pagecontent')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6 mt-10 mb-10 border border-gray-100">
    <!-- Result Header -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-t-lg -mx-6 -mt-6 mb-6">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-white">
                @if($category == 'anxiety') Anxiety Assessment Results
                @elseif($category == 'depression') Depression Assessment Results
                @else Stress Assessment Results @endif
            </h1>
            <p class="text-blue-100 mt-2">Your personalized results and recommendations</p>
        </div>
    </div>

    <!-- Score Summary -->
    <div class="mb-8 p-5 bg-gray-50 rounded-lg">
        <div class="flex flex-col items-center">
            <!-- Circular Progress Indicator -->
            <div class="relative w-40 h-40 mb-4">
                <svg class="w-full h-full" viewBox="0 0 100 100">
                    <!-- Background circle -->
                    <circle
                        class="text-gray-200"
                        stroke-width="8"
                        stroke="currentColor"
                        fill="transparent"
                        r="40"
                        cx="50"
                        cy="50"
                    />
                    <!-- Progress circle -->
                    @php
                        $strokeColor = match($level) {
                            'Low' => 'text-green-500',
                            'Mild' => 'text-blue-500',
                            'Moderate' => 'text-yellow-500',
                            'High' => 'text-red-500',
                            default => 'text-blue-500'
                        };
                        $circumference = 2 * 3.1416 * 40;
                        $strokeDashoffset = $circumference - ($normalizedScore / 20 * $circumference);
                    @endphp
                    <circle
                        class="{{ $strokeColor }}"
                        stroke-width="8"
                        stroke-dasharray="{{ $circumference }}"
                        stroke-dashoffset="{{ $strokeDashoffset }}"
                        stroke-linecap="round"
                        stroke="currentColor"
                        fill="transparent"
                        r="40"
                        cx="50"
                        cy="50"
                        transform="rotate(-90 50 50)"
                    />
                </svg>
                <div class="absolute inset-0 flex items-center justify-center flex-col">
                    <span class="text-3xl font-bold text-gray-800">{{ $normalizedScore }}/20</span>
                    <span class="text-lg font-medium {{ $strokeColor }}">{{ $level }}</span>
                </div>
            </div>

            <h2 class="text-xl font-semibold text-gray-800 mb-2">
                @if($level == 'Low')
                    Minimal Symptoms
                @elseif($level == 'Mild')
                    Mild Symptoms
                @elseif($level == 'Moderate')
                    Significant Symptoms
                @else
                    Severe Symptoms
                @endif
            </h2>
            <p class="text-gray-600 text-center">
                Based on your responses to the {{ $category }} assessment.
            </p>
        </div>
    </div>

    <!-- Suggestions Section -->
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Personalized Suggestions
        </h3>
        
        <div class="space-y-4">
            @foreach($suggestions as $suggestion)
            <div class="flex items-start p-4 bg-blue-50 rounded-lg border border-blue-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-1 mr-3 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-gray-700">{{ $suggestion }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Resources Section -->
    <div class="mb-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            Additional Resources
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="https://www.nimh.nih.gov/health/find-help" target="_blank" class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-blue-300 transition-colors duration-200">
                <h4 class="font-medium text-blue-600 mb-1">National Institute of Mental Health</h4>
                <p class="text-sm text-gray-600">Find help and information about mental health conditions</p>
            </a>
            
            <a href="https://www.psychologytoday.com/us" target="_blank" class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-blue-300 transition-colors duration-200">
                <h4 class="font-medium text-blue-600 mb-1">Find a Therapist</h4>
                <p class="text-sm text-gray-600">Search for licensed mental health professionals in your area</p>
            </a>
            
            @if($category == 'anxiety')
            <a href="https://adaa.org/" target="_blank" class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-blue-300 transition-colors duration-200">
                <h4 class="font-medium text-blue-600 mb-1">Anxiety & Depression Association</h4>
                <p class="text-sm text-gray-600">Resources specifically for anxiety disorders</p>
            </a>
            @endif
            
            @if($category == 'depression')
            <a href="https://www.nami.org/About-Mental-Illness/Mental-Health-Conditions/Depression" target="_blank" class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-blue-300 transition-colors duration-200">
                <h4 class="font-medium text-blue-600 mb-1">NAMI Depression Resources</h4>
                <p class="text-sm text-gray-600">National Alliance on Mental Illness depression information</p>
            </a>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-200">
        <a href="{{ route('dashboard') }}" class="flex-1 text-center px-6 py-3 border border-gray-300 rounded-md text-base font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
            Return to Dashboard
        </a>
        <a href="{{ route('assessment.index') }}" class="flex-1 text-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
            Take Another Assessment
        </a>
    </div>
</div>
@endsection