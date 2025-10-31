<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Tailwind / Alpine / Fonts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        [x-cloak]{ display:none !important; }

        /* Chat bubble styles */
        .chat-bubble {
            max-width: 75%;
            padding: 8px 12px;
            border-radius: 12px;
            word-wrap: break-word;
            white-space: pre-wrap;
        }
        .chat-user { 
            background-color: #2563eb; 
            color: white !important; 
            border-bottom-right-radius: 0; 
            margin-left: auto;
        }
        .chat-assistant { 
            background-color: #f3f4f6; 
            color: #111827 !important; 
            border-bottom-left-radius: 0; 
            margin-right: auto;
        }

        /* Messages container scroll */
        .messages-container {
            overflow-y: auto;
            flex: 1;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }
        .messages-container::-webkit-scrollbar {
            width: 6px;
        }
        .messages-container::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }
        .messages-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        .messages-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="font-poppins bg-gray-50 min-h-screen flex flex-col">
    @include('layouts.header')
    <section id="pagecontent">
        @yield('pagecontent')
    </section>
    @include('components.panic-button')

    {{-- 📅 Book Appointment Button --}}
    <a href="{{ route('doctor.profile') }}"
       class="fixed bottom-5 left-5 z-50 bg-green-600 text-white px-6 py-3 rounded-full shadow-lg hover:bg-green-700 transition transform hover:scale-105 flex items-center gap-2 sm:bottom-3 sm:left-3"
       title="Book an appointment">
        <i class="fa-solid fa-calendar-check text-lg"></i>
        <span class="font-semibold">Book Appointment</span>
    </a>

    {{-- 💬 Floating Chatbot --}}
    <div x-data="chatBot()" class="fixed bottom-5 right-5 z-50 sm:bottom-3 sm:right-3">
        <!-- Chat icon -->
        <button 
            @click="open = !open" 
            class="bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 transition transform hover:scale-105"
            title="Chat with Dr. AI"
        >
            <i class="fa-solid fa-comments text-xl"></i>
        </button>

        <!-- Chat window -->
        <div 
            x-show="open"
            x-cloak
            x-transition
            class="absolute bottom-16 right-0 w-[400px] sm:w-96 h-[500px] bg-white border border-gray-200 rounded-lg shadow-2xl flex flex-col overflow-hidden"
        >
            <!-- Header -->
            <div class="bg-blue-600 text-white py-3 px-4 font-semibold flex justify-between items-center flex-shrink-0">
                <span>Dr. AI – Assistant</span>
                <button @click="open = false" class="text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Messages -->
            <div id="messages" class="messages-container">
                <div class="chat-bubble chat-assistant">
                    Hello! I'm Dr. AI. How can I help you today?
                </div>
            </div>

            <!-- Controls & Input -->
            <div class="flex flex-col border-t flex-shrink-0">
                <div class="flex justify-between px-3 py-2 bg-gray-50">
                    <div class="flex space-x-2">
                        <button id="pauseBtn" @click="paused = true" class="hidden bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600 transition">⏸ Pause</button>
                        <button id="resumeBtn" @click="paused = false" class="hidden bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700 transition">▶ Continue</button>
                    </div>
                    <button @click="clearMessages()" class="text-gray-500 hover:text-gray-700 text-xs flex items-center" title="Clear conversation">
                        <i class="fas fa-trash-alt mr-1"></i> Clear
                    </button>
                </div>

                <form id="chatForm" class="flex flex-col p-3 border-t space-y-2" @submit.prevent="sendMessage">
                    <div class="flex items-center space-x-2">
                        <input x-ref="messageInput" type="text" placeholder="Type a message..." class="flex-1 border border-gray-300 text-gray-900 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                        <!-- Language selector -->
                        <select x-ref="voiceLang" class="border border-gray-300 text-gray-900 rounded-lg px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="en-US">🇺🇸 English</option>
                            <option value="ne-NP">🇳🇵 नेपाली (Beta)</option>
                            <option value="hi-IN">🇮🇳 हिन्दी</option>
                        </select>

                        <!-- Voice button -->
                        <button type="button" @click="toggleVoice()"
                                :title="!isOnline ? 'Voice input requires internet connection' : 'Click to speak (Voice input)'"
                                :disabled="!isOnline"
                                class="text-white px-3 py-2 rounded-lg text-sm transition shadow-md"
                                :class="!isOnline ? 'bg-gray-400 cursor-not-allowed' : (isRecording ? 'bg-red-600 hover:bg-red-700 animate-pulse' : 'bg-green-600 hover:bg-green-700')">
                            <i :class="!isOnline ? 'fas fa-microphone-slash' : (isRecording ? 'fas fa-stop' : 'fas fa-microphone')"></i>
                        </button>

                        <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 text-sm transition flex items-center" :disabled="isProcessing">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>

                    <!-- Recording indicator -->
                    <div x-show="isRecording" class="text-xs text-green-600 flex items-center space-x-1">
                        <span class="animate-pulse">●</span>
                        <span x-text="'Listening in ' + ($refs.voiceLang?.options[$refs.voiceLang?.selectedIndex]?.text || 'selected language') + '...'"></span>
                    </div>

                    <!-- Language hint -->
                    <div x-show="!isRecording" class="text-xs text-gray-500 space-y-1">
                        <div class="italic">💡 Tip: English voice input works best</div>
                        <div class="text-xs">नेपाली: Google's voice recognition often detects it as हिन्दी. For better results, type in Nepali directly or speak in English.</div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Chat Script --}}
    <script>
        function chatBot() {
            return {
                open: false,
                paused: false,
                controller: null,
                isProcessing: false,
                maxMessages: 50,
                csrf: null,
                isRecording: false,
                recognition: null,
                isOnline: navigator.onLine,

                init() {
                    this.csrf = document.querySelector('meta[name="csrf-token"]').content;

                    this.$watch('open', value => {
                        if (value) setTimeout(() => this.$refs.messageInput.focus(), 100);
                    });

                    // Monitor online/offline status
                    window.addEventListener('online', () => {
                        this.isOnline = true;
                        console.log('Internet connection restored');
                    });
                    window.addEventListener('offline', () => {
                        this.isOnline = false;
                        console.log('Internet connection lost');
                        if (this.isRecording) {
                            this.recognition.stop();
                        }
                    });

                    // Initialize Speech Recognition
                    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                    if (SpeechRecognition) {
                        console.log('Speech Recognition API is supported');
                        this.recognition = new SpeechRecognition();
                        this.recognition.continuous = false;
                        this.recognition.interimResults = false;
                        this.recognition.maxAlternatives = 3; // Get more alternatives for better Nepali detection

                        this.recognition.onstart = () => {
                            console.log('Voice recognition started with language:', this.recognition.lang);
                        };

                        this.recognition.onresult = (event) => {
                            console.log('Voice recognition result:', event);
                            console.log('Detected language:', this.recognition.lang);

                            // Log all alternatives
                            const result = event.results[0];
                            console.log('Number of alternatives:', result.length);
                            for (let i = 0; i < result.length; i++) {
                                console.log(`Alternative ${i}:`, result[i].transcript, `(confidence: ${result[i].confidence})`);
                            }

                            // Use the best result
                            const transcript = result[0].transcript;
                            console.log('Selected transcript:', transcript);
                            this.$refs.messageInput.value = transcript;
                            this.isRecording = false;
                        };

                        this.recognition.onend = () => {
                            console.log('Voice recognition ended');
                            this.isRecording = false;
                        };

                        this.recognition.onerror = (event) => {
                            console.error('Speech recognition error:', event.error);
                            this.isRecording = false;

                            let errorMsg = 'Voice error';
                            if (event.error === 'no-speech') {
                                errorMsg = 'No speech detected. Please speak clearly and try again.';
                            } else if (event.error === 'not-allowed') {
                                errorMsg = 'Microphone access denied. Please allow microphone permissions in your browser settings.';
                            } else if (event.error === 'audio-capture') {
                                errorMsg = 'Microphone not found. Please check your device has a working microphone.';
                            } else if (event.error === 'network') {
                                errorMsg = 'Network error. Voice input requires internet connection. Please check your connection and try again.';
                                // Auto-retry once after network error
                                setTimeout(() => {
                                    if (!this.isRecording) {
                                        console.log('Auto-retrying voice recognition...');
                                    }
                                }, 1000);
                            } else if (event.error === 'aborted') {
                                return; // Don't show error for manual abort
                            } else {
                                errorMsg = `Voice error: ${event.error}. Please try typing instead.`;
                            }

                            this.addMessage('assistant', '⚠️ ' + errorMsg);
                        };
                    } else {
                        console.warn('Speech Recognition API not supported in this browser');
                    }
                },

                toggleVoice() {
                    // Check internet connection first
                    if (!this.isOnline) {
                        this.addMessage('assistant', '⚠️ Voice input requires internet connection. Please connect to the internet and try again.');
                        return;
                    }

                    if (!this.recognition) {
                        this.addMessage('assistant', '⚠️ Voice input not supported in this browser. Please use Chrome, Edge, or Safari.');
                        return;
                    }

                    if (this.isRecording) {
                        try {
                            this.recognition.stop();
                        } catch (e) {
                            console.error('Error stopping recognition:', e);
                        }
                        this.isRecording = false;
                    } else {
                        try {
                            const selectedLang = this.$refs.voiceLang.value;
                            this.recognition.lang = selectedLang;

                            console.log('🎤 Starting voice recognition');
                            console.log('Selected language code:', selectedLang);
                            console.log('Language name:', this.$refs.voiceLang.options[this.$refs.voiceLang.selectedIndex].text);

                            // Special handling for Nepali
                            if (selectedLang === 'ne-NP') {
                                console.warn('⚠️ Nepali (ne-NP) selected. Note: Browser support is limited and may fall back to Hindi.');
                                this.addMessage('assistant', 'Note: Nepali voice recognition has limited support. Results may be in Hindi. Consider typing in Nepali for better accuracy.');
                            }

                            this.recognition.start();
                            this.isRecording = true;
                        } catch (e) {
                            console.error('Error starting recognition:', e);
                            this.addMessage('assistant', '⚠️ Error starting voice input: ' + e.message);
                            this.isRecording = false;
                        }
                    }
                },

                addMessage(role, text) {
                    const messages = document.getElementById('messages');
                    const div = document.createElement('div');
                    div.className = `chat-bubble ${role === 'user' ? 'chat-user' : 'chat-assistant'}`;
                    div.textContent = text;
                    messages.appendChild(div);

                    messages.scrollTop = messages.scrollHeight;

                    while (messages.children.length > this.maxMessages) messages.removeChild(messages.firstChild);

                    return div;
                },

                clearMessages() {
                    const messages = document.getElementById('messages');
                    messages.innerHTML = '';
                    this.addMessage('assistant', "Hello! I'm Dr. AI. How can I help you today?");
                },

                async sendMessage() {
                    const input = this.$refs.messageInput;
                    const text = input.value.trim();
                    if (!text || this.isProcessing) return;

                    this.addMessage('user', text);
                    input.value = '';
                    this.isProcessing = true;

                    const messages = document.getElementById('messages');
                    const typing = document.createElement('div');
                    typing.className = 'italic text-gray-400 flex items-center';
                    typing.innerHTML = '<i class="fas fa-ellipsis-h mr-2"></i> Dr. AI is typing...';
                    messages.appendChild(typing);
                    messages.scrollTop = messages.scrollHeight;

                    try {
                        this.controller = new AbortController();
                        const resp = await fetch("{{ route('assistant.chat') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': this.csrf },
                            body: JSON.stringify({ message: text }),
                            signal: this.controller.signal
                        });

                        if (!resp.ok) {
                            typing.remove();
                            this.addMessage('assistant', '⚠️ Server error: ' + resp.statusText);
                            this.isProcessing = false;
                            return;
                        }

                        typing.remove();
                        const div = this.addMessage('assistant', '');
                        const reader = resp.body.getReader();
                        const decoder = new TextDecoder();
                        let buffer = '';

                        while (true) {
                            if (this.paused) {
                                await new Promise(resolve => {
                                    const interval = setInterval(() => {
                                        if (!this.paused) { clearInterval(interval); resolve(); }
                                    }, 300);
                                });
                            }

                            const { done, value } = await reader.read();
                            if (done) break;
                            const chunk = decoder.decode(value, { stream: true });
                            buffer += chunk;

                            const lines = buffer.split('\n');
                            buffer = lines.pop();

                            for (const line of lines) {
                                if (!line.trim()) continue;
                                try {
                                    const json = JSON.parse(line);
                                    if (json.message?.content) {
                                        div.textContent += json.message.content;
                                        messages.scrollTop = messages.scrollHeight;
                                    }
                                } catch {}
                            }
                        }
                    } catch (err) {
                        if (err.name === 'AbortError') this.addMessage('assistant', '[⏹ Stream stopped]');
                        else this.addMessage('assistant', '⚠️ Error: ' + err.message);
                    } finally { this.isProcessing = false; }
                }
            }
        }
    </script>
</body>
</html>