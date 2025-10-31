@extends('template.template')

@section('pagecontent')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6 mt-20 mb-10 border border-gray-100" 
     x-data="assessment()">
    <!-- Header Section with Progress -->
    <div class="bg-blue-600 p-6 rounded-t-lg -mx-6 -mt-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-white">
                    @if($category == 'anxiety') Anxiety Assessment (GAD-7)
                    @elseif($category == 'depression') Depression Assessment (PHQ-9)
                    @elseif($category == 'stress') Stress Assessment (PSS)
                    @else PTSD Assessment (PCL-5) @endif
                </h1>
                <p class="text-blue-100 mt-1">
                    @if($category == 'stress')
                        Over the last month, how often have you experienced the following?
                    @elseif($category == 'ptsd')
                        Over the last month, how much were you bothered by:
                    @else
                        Over the last 2 weeks, how often have you been bothered by the following?
                    @endif
                </p>
            </div>
            
            @if(count($questions) > 0)
            <div class="bg-blue-700 rounded-full px-4 py-2 flex items-center"
                 :class="{ 'bg-green-500 animate-pulse': allQuestionsAnswered }">
                <span class="text-white font-medium text-sm">
                    <span x-text="answeredCount"></span>/{{ count($questions) }}
                </span>
            </div>
            @endif
        </div>
        
        @if(count($questions) > 0)
        <!-- Progress Bar Container -->
        <div class="mt-6">
            <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-blue-200">Progress</span>
                <span class="text-sm font-medium text-blue-200" x-text="progressPercentage + '%'"></span>
            </div>
            <div class="w-full bg-blue-400 rounded-full h-2.5">
                <div 
                    class="h-2.5 rounded-full transition-all duration-500 ease-out" 
                    :style="'width: ' + progressPercentage + '%'"
                    :class="{
                        'bg-blue-100': progressPercentage < 30,
                        'bg-yellow-300': progressPercentage >= 30 && progressPercentage < 70,
                        'bg-green-400': progressPercentage >= 70,
                        'animate-pulse': allQuestionsAnswered
                    }"
                ></div>
            </div>
        </div>
        @endif
    </div>
    
    <!-- Assessment Form -->
    <form action="{{ route('responses.store') }}" method="POST" class="space-y-8">
        @csrf
        
        @if(count($questions) > 0)
        <!-- Question navigation controls -->
        <div class="flex justify-between items-center mb-6">
            <button 
                type="button" 
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium flex items-center transition-colors duration-200 hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="currentIndex === 0"
                @click="prevQuestion"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Previous
            </button>
            
            <div class="text-sm text-gray-500">
                Question <span x-text="currentIndex + 1"></span> of {{ count($questions) }}
            </div>
            
            <button 
                type="button" 
                class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium flex items-center transition-colors duration-200 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="currentIndex === {{ count($questions) - 1 }} || !isCurrentQuestionAnswered"
                @click="nextQuestion"
            >
                Next
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
        
        <!-- Error message for unanswered question -->
        <div x-show="showError" x-transition class="p-4 bg-red-50 text-red-700 rounded-lg border border-red-200 mb-4">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                Please select an answer before continuing.
            </div>
        </div>
        
        <!-- Questions container with transition -->
        <div class="relative min-h-[300px] overflow-hidden">
            @foreach($questions as $index => $question)
            <div 
                x-show="currentIndex === {{ $index }}"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-8"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-x-0"
                x-transition:leave-end="opacity-0 transform -translate-x-8"
                class="question-group p-5 bg-gray-50 rounded-lg absolute inset-0"
            >
                <div class="flex items-start">
                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-800 font-bold mr-4 mt-1">
                        {{ $index + 1 }}
                    </span>
                    <div class="flex-1">
                        <p class="text-lg font-medium text-gray-800 mb-4">{{ $question->question }}</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @php
                                if ($category === 'stress') {
                                    $responseOptions = ['0' => 'Never', '1' => 'Almost never', '2' => 'Sometimes', '3' => 'Fairly often', '4' => 'Very often'];
                                } elseif ($category === 'ptsd') {
                                    $responseOptions = ['0' => 'Not at all', '1' => 'A little bit', '2' => 'Moderately', '3' => 'Quite a bit', '4' => 'Extremely'];
                                } else {
                                    $responseOptions = ['0' => 'Not at all', '1' => 'Several days', '2' => 'More than half the days', '3' => 'Nearly every day'];
                                }
                            @endphp
                            @foreach($responseOptions as $value => $label)
                            <label class="flex items-center space-x-3 p-3 rounded-lg border border-gray-200 hover:border-blue-300 cursor-pointer transition-colors duration-200"
                                   :class="{ 'border-blue-400 bg-blue-50': responses[{{ $question->id }}] === '{{ $value }}' }">
                                <input
                                    type="radio"
                                    name="responses[{{ $question->id }}][response]"
                                    value="{{ $value }}"
                                    class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300"
                                    x-model="responses[{{ $question->id }}]"
                                    @change="onAnswerChange({{ $index }})"
                                    required
                                >
                                <span class="text-gray-700 text-sm">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                        <input type="hidden" name="responses[{{ $question->id }}][question_id]" value="{{ $question->id }}">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Form Actions -->
        <div class="pt-6 border-t border-gray-200 flex justify-between">
            <button 
                type="button" 
                class="px-6 py-3 border border-gray-300 rounded-md shadow-sm text-lg font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200"
                @click="currentIndex = 0"
            >
                Restart
            </button>
            
            <button 
                type="submit" 
                class="px-6 py-3 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 flex items-center"
                :class="{ 'opacity-50 cursor-not-allowed': !allQuestionsAnswered }"
                :disabled="!allQuestionsAnswered"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Submit Assessment
            </button>
        </div>
        @else
        <div class="p-6 bg-gray-50 rounded-lg text-center">
            <p class="text-gray-600">No questions available for this assessment.</p>
        </div>
        @endif
    </form>
</div>

@if(count($questions) > 0)
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('assessment', () => ({
        currentIndex: 0,
        responses: {},
        progressPercentage: 0,
        answeredCount: 0,
        showError: false,
        
        init() {
            // Initialize responses object with empty values
            @foreach($questions as $question)
            this.responses[{{ $question->id }}] = '';
            @endforeach
            
            this.updateProgress();
        },
        
        get allQuestionsAnswered() {
            return Object.values(this.responses).every(response => response !== '');
        },
        
        get isCurrentQuestionAnswered() {
            // Get the current question ID
            const questionIds = [
                @foreach($questions as $question)
                {{ $question->id }},
                @endforeach
            ];
            const currentQuestionId = questionIds[this.currentIndex];
            return this.responses[currentQuestionId] !== '';
        },
        
        nextQuestion() {
            // Check if current question is answered
            if (!this.isCurrentQuestionAnswered) {
                this.showError = true;
                setTimeout(() => {
                    this.showError = false;
                }, 3000);
                return;
            }
            
            this.showError = false;
            
            if (this.currentIndex < {{ count($questions) - 1 }}) {
                this.currentIndex++;
            }
        },
        
        prevQuestion() {
            this.showError = false;
            
            if (this.currentIndex > 0) {
                this.currentIndex--;
            }
        },
        
        onAnswerChange(index) {
            this.updateProgress();
            this.showError = false;
            
            // Auto-advance to next question after a short delay if not the last question
            if (this.currentIndex < {{ count($questions) - 1 }}) {
                setTimeout(() => {
                    this.nextQuestion();
                }, 300);
            }
        },
        
        updateProgress() {
            this.answeredCount = Object.values(this.responses).filter(response => response !== '').length;
            this.progressPercentage = Math.round((this.answeredCount / {{ count($questions) }}) * 100);
        }
    }));
});
</script>
@endif
@endsection