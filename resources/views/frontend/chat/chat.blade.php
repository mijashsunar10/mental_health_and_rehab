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
    <form id="chatForm" class="flex space-x-2">
        <input id="input" type="text" placeholder="Describe what's going on..." 
               class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Send
        </button>
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
</script>
@endsection
