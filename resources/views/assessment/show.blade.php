@extends('template.template')

@section('pagecontent')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6 mt-20 mb-10 border border-gray-100">
    <!-- Header Section with Progress -->
    <div class="bg-blue-600 p-6 rounded-t-lg -mx-6 -mt-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-white">
                    @if($category == 'anxiety') Anxiety Assessment
                    @elseif($category == 'depression') Depression Assessment
                    @else Stress Assessment @endif
                </h1>
                <p class="text-blue-100 mt-1">Based on your mental health experiences in the last month</p>
            </div>
            
            @if(count($questions) > 0)
            <div class="bg-blue-700 rounded-full px-4 py-2 flex items-center">
                <span class="text-white font-medium text-sm">
                    <span id="progress-count">0</span>/{{ count($questions) }}
                </span>
            </div>
            @endif
        </div>
        
        @if(count($questions) > 0)
        <!-- Progress Bar Container -->
        <div class="mt-6">
            <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-blue-200">Progress</span>
                <span class="text-sm font-medium text-blue-200" id="progress-percentage">0%</span>
            </div>
            <div class="w-full bg-blue-400 rounded-full h-2.5">
                <div 
                    id="progress-bar" 
                    class="bg-blue-100 h-2.5 rounded-full transition-all duration-500 ease-out" 
                    style="width: 0%"
                ></div>
            </div>
        </div>
        @endif
    </div>
    
    <!-- Assessment Form -->
    <form action="{{ route('responses.store') }}" method="POST" class="space-y-8">
        @csrf
        
        @forelse($questions as $index => $question)
        <div class="question-group p-5 bg-gray-50 rounded-lg transition-all duration-200 hover:bg-gray-100">
            <div class="flex items-start">
                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-800 font-bold mr-4 mt-1">
                    {{ $index + 1 }}
                </span>
                <div class="flex-1">
                    <p class="text-lg font-medium text-gray-800 mb-4">{{ $question->question }}</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach(['never' => 'Never', 'rarely' => 'Rarely', 'sometimes' => 'Sometimes', 'often' => 'Often'] as $value => $label)
                        <label class="flex items-center space-x-3 p-3 rounded-lg border border-gray-200 hover:border-blue-300 cursor-pointer transition-colors duration-200">
                            <input 
                                type="radio" 
                                name="responses[{{ $question->id }}][response]" 
                                value="{{ $value }}"
                                class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300"
                                required
                            >
                            <span class="text-gray-700">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                    <input type="hidden" name="responses[{{ $question->id }}][question_id]" value="{{ $question->id }}">
                </div>
            </div>
        </div>
        @empty
        <div class="p-6 bg-gray-50 rounded-lg text-center">
            <p class="text-gray-600">No questions available for this assessment.</p>
        </div>
        @endforelse
        
        @if(count($questions) > 0)
        <!-- Form Actions -->
        <div class="pt-6 border-t border-gray-200">
            <button type="submit" class="w-full flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Submit Assessment
            </button>
        </div>
        @endif
    </form>
</div>

@if(count($questions) > 0)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const radioInputs = document.querySelectorAll('input[type="radio"]');
    const progressCount = document.getElementById('progress-count');
    const progressBar = document.getElementById('progress-bar');
    const progressPercentage = document.getElementById('progress-percentage');
    const totalQuestions = {{ count($questions) }};
    const progressCounter = document.querySelector('.bg-blue-700');
    
    function updateProgress() {
        const answeredQuestions = new Set(
            Array.from(document.querySelectorAll('input[type="radio"]:checked'))
                .map(input => input.name.split('[')[1].split(']')[0])
        ).size;
        
        // Update counter
        progressCount.textContent = answeredQuestions;
        
        // Calculate percentage with one decimal place
        const percentage = Math.round((answeredQuestions / totalQuestions) * 100);
        
        // Update progress bar and percentage text
        progressBar.style.width = `${percentage}%`;
        progressPercentage.textContent = `${percentage}%`;
        
        // Change progress bar color as it fills
        if (percentage < 30) {
            progressBar.classList.remove('bg-yellow-300', 'bg-green-400');
            progressBar.classList.add('bg-blue-100');
        } else if (percentage < 70) {
            progressBar.classList.remove('bg-blue-100', 'bg-green-400');
            progressBar.classList.add('bg-yellow-300');
        } else {
            progressBar.classList.remove('bg-blue-100', 'bg-yellow-300');
            progressBar.classList.add('bg-green-400');
        }
        
        // Pulse effect when completing all questions
        if (answeredQuestions === totalQuestions) {
            progressCounter.classList.add('bg-green-500', 'animate-pulse');
            progressCounter.classList.remove('bg-blue-700');
            
            // Add celebration effect to progress bar
            progressBar.classList.add('animate-pulse');
        } else {
            progressCounter.classList.add('bg-blue-700');
            progressCounter.classList.remove('bg-green-500', 'animate-pulse');
            
            // Remove celebration effect if not complete
            progressBar.classList.remove('animate-pulse');
        }
    }
    
    radioInputs.forEach(input => {
        input.addEventListener('change', updateProgress);
    });
    
    // Initialize progress
    updateProgress();
});
</script>
@endif
@endsection