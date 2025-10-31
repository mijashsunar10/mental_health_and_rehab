@extends('template.template')

@section('pagecontent')
<div class="max-w-2xl mx-auto mt-20 p-4 bg-white rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold text-blue-700 mb-4">Therapist Chat</h1>

    <!-- Chat messages -->
    <div id="messages" class="h-96 overflow-y-auto border border-gray-200 rounded p-4 mb-4 space-y-2">
        <!-- Messages will appear here -->
    </div>

    <!-- Chat controls -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex space-x-2">
            <button id="pauseBtn" type="button" class="hidden bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                ⏸ Pause
            </button>
            <button id="resumeBtn" type="button" class="hidden bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">
                ▶ Continue
            </button>
        </div>
    </div>

    <!-- Chat input -->
    <form id="chatForm" class="space-y-2">
        <div class="flex items-center space-x-2">
            <input id="input" type="text" placeholder="Describe what's going on..."
                   class="flex-1 border border-gray-300 text-gray-900 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />

            <!-- Language selector for voice input -->
            <select id="voiceLang" class="border border-gray-300 text-gray-900 rounded px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="en-US">English</option>
                <option value="ne-NP">नेपाली</option>
            </select>

            <!-- Voice input button -->
            <button type="button" id="voiceBtn" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                </svg>
            </button>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Send
            </button>
        </div>

        <!-- Recording indicator -->
        <div id="recordingIndicator" class="hidden text-sm text-green-600 flex items-center space-x-2">
            <span class="animate-pulse">●</span>
            <span>Listening... Speak now</span>
        </div>
    </form>
</div>

<script>
const form = document.getElementById('chatForm');
const input = document.getElementById('input');
const messages = document.getElementById('messages');
const pauseBtn = document.getElementById('pauseBtn');
const resumeBtn = document.getElementById('resumeBtn');

let paused = false;  // Controls stream state
let controller = null; // For aborting fetch

function addMessage(role, text) {
    const div = document.createElement('div');
    div.className = role === 'user' 
        ? 'text-right text-blue-700 font-medium' 
        : 'text-left text-gray-700 whitespace-pre-wrap';
    div.textContent = text;
    messages.appendChild(div);
    messages.scrollTop = messages.scrollHeight;
    return div;
}

pauseBtn.addEventListener('click', () => {
    paused = true;
    pauseBtn.classList.add('hidden');
    resumeBtn.classList.remove('hidden');
});

resumeBtn.addEventListener('click', () => {
    paused = false;
    resumeBtn.classList.add('hidden');
    pauseBtn.classList.remove('hidden');
});

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const text = input.value.trim();
    if (!text) return;

    addMessage('user', text);
    input.value = '';

    // Show typing indicator
    const typing = document.createElement('div');
    typing.className = 'italic text-gray-400';
    typing.textContent = 'Dr. AI is typing...';
    messages.appendChild(typing);
    messages.scrollTop = messages.scrollHeight;

    try {
        controller = new AbortController();
        const resp = await fetch("{{ route('assistant.chat') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: text }),
            signal: controller.signal
        });

        if (!resp.ok) {
            typing.remove();
            addMessage('assistant', 'Server error: ' + resp.statusText);
            return;
        }

        // Create message container for streamed text
        const div = addMessage('assistant', '');
        typing.remove();

        pauseBtn.classList.remove('hidden');
        const reader = resp.body.getReader();
        const decoder = new TextDecoder();
        let buffer = '';

        while (true) {
            if (paused) {
                await new Promise(resolve => {
                    const interval = setInterval(() => {
                        if (!paused) {
                            clearInterval(interval);
                            resolve();
                        }
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
                } catch {
                    // Ignore incomplete JSON
                }
            }
        }

        pauseBtn.classList.add('hidden');
        resumeBtn.classList.add('hidden');

    } catch (err) {
        if (err.name === 'AbortError') {
            addMessage('assistant', '[Stream aborted]');
        } else {
            addMessage('assistant', 'Server error: ' + err.message);
        }
    } finally {
        pauseBtn.classList.add('hidden');
        resumeBtn.classList.add('hidden');
    }
});

// ==================== VOICE INPUT FUNCTIONALITY ====================
const voiceBtn = document.getElementById('voiceBtn');
const voiceLang = document.getElementById('voiceLang');
const recordingIndicator = document.getElementById('recordingIndicator');

// Check for browser support
if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
    voiceBtn.disabled = true;
    voiceBtn.classList.add('opacity-50', 'cursor-not-allowed');
    voiceBtn.title = 'Voice input not supported in this browser';
    console.warn('Speech Recognition API not supported in this browser');
}

// Initialize Speech Recognition
const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
let recognition = null;
let isRecording = false;

if (SpeechRecognition) {
    recognition = new SpeechRecognition();
    recognition.continuous = false;  // Stop after one result
    recognition.interimResults = true;  // Show interim results
    recognition.maxAlternatives = 1;

    // Voice button click handler
    voiceBtn.addEventListener('click', () => {
        if (isRecording) {
            stopRecording();
        } else {
            startRecording();
        }
    });

    function startRecording() {
        try {
            // Set language from dropdown
            recognition.lang = voiceLang.value;

            // Start recognition
            recognition.start();
            isRecording = true;

            // Update UI
            voiceBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
            voiceBtn.classList.add('bg-red-600', 'hover:bg-red-700', 'animate-pulse');
            recordingIndicator.classList.remove('hidden');

            console.log('Voice recognition started in language:', voiceLang.value);
        } catch (error) {
            console.error('Error starting voice recognition:', error);
            alert('Failed to start voice recognition. Please check your microphone permissions.');
        }
    }

    function stopRecording() {
        if (recognition) {
            recognition.stop();
        }
        isRecording = false;

        // Reset UI
        voiceBtn.classList.remove('bg-red-600', 'hover:bg-red-700', 'animate-pulse');
        voiceBtn.classList.add('bg-green-600', 'hover:bg-green-700');
        recordingIndicator.classList.add('hidden');
    }

    // Handle speech recognition results
    recognition.onresult = (event) => {
        const transcript = event.results[0][0].transcript;
        const isFinal = event.results[0].isFinal;

        // Update input field with transcribed text
        if (isFinal) {
            input.value = transcript;
            console.log('Final transcript:', transcript);
        }
    };

    // Handle recognition end
    recognition.onend = () => {
        stopRecording();
        console.log('Voice recognition ended');
    };

    // Handle errors
    recognition.onerror = (event) => {
        console.error('Speech recognition error:', event.error);
        stopRecording();

        let errorMessage = 'Voice recognition error';
        switch(event.error) {
            case 'no-speech':
                errorMessage = 'No speech detected. Please try again.';
                break;
            case 'audio-capture':
                errorMessage = 'Microphone not found. Please check your device.';
                break;
            case 'not-allowed':
                errorMessage = 'Microphone access denied. Please allow microphone permissions.';
                break;
            case 'network':
                errorMessage = 'Network error. Please check your internet connection.';
                break;
            default:
                errorMessage = `Error: ${event.error}`;
        }

        // Show error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'text-sm text-red-600 mt-1';
        errorDiv.textContent = errorMessage;
        form.appendChild(errorDiv);

        // Remove error message after 3 seconds
        setTimeout(() => {
            errorDiv.remove();
        }, 3000);
    };
}

// Stop recording when changing language
voiceLang.addEventListener('change', () => {
    if (isRecording) {
        stopRecording();
    }
});
</script>
@endsection
