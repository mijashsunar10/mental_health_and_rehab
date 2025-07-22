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

        .form-glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            border: 1px solid var(--blue-200);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
        
        .input-field {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid var(--blue-200);
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            border-color: var(--blue-500);
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.3);
            outline: none;
        }
        
        .label-text {
            color: var(--blue-800);
            font-weight: 500;
        }
        
        .submit-btn {
            background: linear-gradient(135deg, var(--blue-500), var(--blue-600));
            color: white;
            box-shadow: 0 4px 15px rgba(66, 153, 225, 0.3);
            transition: all 0.3s ease;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(66, 153, 225, 0.5);
        }

        .back-link {
            transition: all 0.3s ease;
        }
        
        .back-link:hover {
            color: white;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        /* Floating background elements */
        .floating-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(40px);
            z-index: 0;
            opacity: 0.6;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); }
            50% { transform: translateY(-20px) translateX(10px); }
        }

        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delay { animation: float 7s ease-in-out infinite 1s; }
    </style>

    <section class="min-h-screen relative py-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-white to-blue-50">
        <!-- Floating background elements -->
        <div class="floating-orb top-20 left-10 w-32 h-32 bg-blue-100 animate-float"></div>
        <div class="floating-orb bottom-1/3 right-20 w-40 h-40 bg-blue-200 animate-float-delay"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto">
            <div class="form-glass rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-800 to-blue-900 p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-3xl font-bold text-white">
                            Create New FAQ
                        </h2>
                        <a href="{{ route('faqs.index') }}" class="back-link flex items-center text-blue-200 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Back to FAQs
                        </a>
                    </div>
                </div>
                
                <!-- Form -->
                <div class="p-8">
                    <form action="{{ route('faqs.store') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-8">
                            <!-- Question Field -->
                            <div>
                                <label for="question" class="block text-lg font-medium text-blue-800 mb-3 label-text">
                                    Question
                                </label>
                                <input
                                    type="text"
                                    name="question"
                                    id="question"
                                    required
                                    class="input-field w-full px-5 py-3 rounded-lg text-blue-900 placeholder-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Enter the frequently asked question"
                                />
                                @error('question')
                                    <p class="mt-2 text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Answer Field -->
                            <div>
                                <label for="answer" class="block text-lg font-medium text-blue-800 mb-3 label-text">
                                    Detailed Answer
                                </label>
                                <textarea
                                    name="answer"
                                    id="answer"
                                    rows="6"
                                    required
                                    class="input-field w-full px-5 py-3 rounded-lg text-blue-900 placeholder-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Provide a comprehensive answer"
                                ></textarea>
                                @error('answer')
                                    <p class="mt-2 text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="pt-4">
                                <button type="submit" class="submit-btn px-8 py-3 rounded-full font-bold flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Create FAQ
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Decorative footer -->
            <div class="mt-12 text-center">
                <div class="flex justify-center space-x-6">
                    <div class="w-10 h-10 rounded-full bg-blue-100 backdrop-blur-sm"></div>
                    <div class="w-10 h-10 rounded-full bg-blue-200 backdrop-blur-sm"></div>
                    <div class="w-10 h-10 rounded-full bg-blue-300 backdrop-blur-sm"></div>
                </div>
            </div>
        </div>
    </section>
@endsection