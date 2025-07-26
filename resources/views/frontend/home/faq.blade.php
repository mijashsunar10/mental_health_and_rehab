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
            
            /* Gradient Definitions */
            --gradient-text: linear-gradient(135deg, var(--blue-500) 0%, var(--blue-600) 100%);
            --gradient-button: linear-gradient(135deg, var(--blue-400) 0%, var(--blue-600) 100%);
            --gradient-glass: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            
            /* Glass Morphism Effects */
            --glass-bg: 210, 100%, 50%;
            --glass-border: 210, 100%, 80%;
            --card: 210, 40%, 96%;
            --border: 210, 30%, 85%;
        }

        /* Enhanced FAQ animations */
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
        }

        .faq-answer.open {
            opacity: 1;
            /* max-height set dynamically via JS */
        }

        /* Content animation */
        .faq-answer .content {
            transform: translateY(-20px);
            transition: all 0.3s ease-out;
        }

        .faq-answer.open .content {
            transform: translateY(0);
        }

        /* Floating elements with glow */
        .floating-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(40px);
            z-index: 0;
            animation: float 8s ease-in-out infinite;
            opacity: 0.6;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); }
            50% { transform: translateY(-20px) translateX(10px); }
        }

        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delay { animation: float 7s ease-in-out infinite 1s; }
        .animate-float-delay-2 { animation: float 8s ease-in-out infinite 2s; }

        /* Gradient text for headings */
        .gradient-heading {
            background: var(--gradient-text);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Glass card effect */
        .glass {
            background: var(--gradient-glass);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        /* Hover effect for FAQ items */
        .faq-toggle:hover {
            box-shadow: 0 0 15px rgba(66, 153, 225, 0.3);
            border-color: var(--blue-400);
        }

        /* Pulse animation for CTA */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .pulse-animate {
            animation: pulse 4s infinite;
        }
    </style>

    <section class="min-h-screen relative overflow-hidden py-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-white to-blue-200">
        <!-- Floating orbs background -->
        <div class="floating-orb top-20 left-10 w-32 h-32 bg-blue-100 animate-float"></div>
        <div class="floating-orb bottom-1/3 right-20 w-40 h-40 bg-blue-200 animate-float-delay"></div>
        <div class="floating-orb top-1/4 right-1/4 w-24 h-24 bg-blue-300 animate-float-delay-2"></div>

        <!-- Main content container -->
        <div class="relative z-10 flex items-center justify-center">
            <div class="w-full max-w-4xl">
                <!-- Header with glass morphism effect -->
                <div class="glass rounded-2xl mb-12 p-8 text-center shadow-xl">
                    <h1 class="text-5xl font-bold mb-6 gradient-heading">
                        Calm Core Recovery FAQs
                    </h1>
                    <div class="w-32 h-1 mx-auto my-6 bg-gradient-to-r from-transparent via-blue-400 to-transparent rounded-full"></div>
                    <p class="text-xl text-blue-700 max-w-2xl mx-auto">
                        Answers to all your questions about our recovery programs
                    </p>
                    
                    @auth
                        <a href="{{ route('faqs.create') }}" class="inline-block mt-8">
                            <button class="glass border border-blue-200 px-8 py-3 rounded-full font-bold text-blue-800 hover:shadow-[0_0_30px_rgba(66,153,225,0.3)] transition-all duration-300 flex items-center gap-2 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:rotate-90 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Add New FAQ
                            </button>
                        </a>
                    @endauth
                </div>

                <!-- FAQ Container -->
                <div id="faq-container" class="space-y-4">
                    @foreach ($faqs as $index => $faq)
                        <div class="group">
                            <button
                                class="faq-toggle w-full flex justify-between items-center text-left p-6 text-lg font-semibold text-blue-900 bg-white focus:outline-none rounded-xl border border-blue-200 hover:border-blue-400 transition-all duration-300"
                                onclick="toggleAnswer('answer{{ $faq->id }}')" aria-expanded="false">
                                <div class="flex items-center">
                                    <span class="w-8 h-8 flex items-center justify-center bg-blue-500 text-white rounded-full mr-4 font-bold">{{ $index + 1 }}</span>
                                    <span class="text-left">{{ $faq->question }}</span>
                                </div>
                                <svg id="icon{{ $faq->id }}"
                                    class="ml-2 w-6 h-6 text-blue-500 transition-transform duration-300 transform"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="faq-answer rounded-b-xl mt-1 border-l-4 border-blue-500"
                                id="answer{{ $faq->id }}">
                                <div class="content pb-8 pt-6 px-8">
                                    <p class="text-blue-800 leading-relaxed text-lg">
                                        {{ $faq->answer }}
                                    </p>
                                    @auth
                                        <div class="mt-6 flex flex-wrap gap-3">
                                            <a href="{{ route('faqs.edit', $faq->slug) }}"
                                                class="transition-all duration-200 hover:scale-105">
                                                <button
                                                    class="text-white font-bold px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg hover:shadow-md flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path
                                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                    </svg>
                                                    Edit
                                                </button>
                                            </a>
                                            <form action="{{ route('faqs.destroy', $faq->slug) }}" method="POST"
                                                class="transition-all duration-200 hover:scale-105">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-white font-bold px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 rounded-lg hover:shadow-md flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Footer CTA -->
                <div class="mt-16 text-center">
                    <p class="text-blue-700 text-lg mb-6">Still have questions about our programs?</p>
                    <a href="/contact" class="inline-block pulse-animate">
                        <button
                            class="px-10 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-full hover:shadow-[0_0_30px_rgba(66,153,225,0.4)] transition-all duration-300">
                            Contact Our Team
                        </button>
                    </a>
                    <div class="mt-12 flex justify-center space-x-6">
                        <div class="w-12 h-12 rounded-full bg-blue-100 backdrop-blur-sm"></div>
                        <div class="w-12 h-12 rounded-full bg-blue-200 backdrop-blur-sm"></div>
                        <div class="w-12 h-12 rounded-full bg-blue-300 backdrop-blur-sm"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Enhanced FAQ toggle with smooth animations
        function toggleAnswer(answerId) {
            const answer = document.getElementById(answerId);
            const icon = document.getElementById(`icon${answerId.replace('answer', '')}`);

            if (answer.classList.contains('open')) {
                // Closing animation
                answer.style.maxHeight = `${answer.scrollHeight}px`;
                setTimeout(() => {
                    answer.style.maxHeight = '0';
                    answer.style.opacity = '0';
                }, 10);
                icon.classList.remove('rotate-180');
                
                setTimeout(() => {
                    answer.classList.remove('open');
                }, 500);
            } else {
                // Opening animation
                answer.classList.add('open');
                answer.style.maxHeight = `${answer.scrollHeight}px`;
                answer.style.opacity = '1';
                icon.classList.add('rotate-180');
                
                // Adjust height after content transition completes
                setTimeout(() => {
                    answer.style.maxHeight = 'none';
                }, 500);
            }
        }

        // Initialize any open FAQs (for permalinks)
        document.addEventListener('DOMContentLoaded', () => {
            const hash = window.location.hash;
            if (hash) {
                const targetAnswer = document.getElementById(hash.substring(1));
                if (targetAnswer && targetAnswer.classList.contains('faq-answer')) {
                    toggleAnswer(targetAnswer.id);
                    setTimeout(() => {
                        targetAnswer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 350);
                }
            }
        });
    </script>