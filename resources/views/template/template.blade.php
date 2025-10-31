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

                <form id="chatForm" class="flex p-3 border-t" @submit.prevent="sendMessage">
                    <input x-ref="messageInput" type="text" placeholder="Type a message..." class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm transition flex items-center ml-2" :disabled="isProcessing">
                        <i class="fas fa-paper-plane mr-1"></i> Send
                    </button>
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

                init() {
                    this.csrf = document.querySelector('meta[name="csrf-token"]').content;

                    this.$watch('open', value => {
                        if (value) setTimeout(() => this.$refs.messageInput.focus(), 100);
                    });
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