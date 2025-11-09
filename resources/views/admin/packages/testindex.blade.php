@extends('template.template')

@section('pagecontent')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-800">Addiction Treatment Packages</h1>
        <div class="flex items-center space-x-4">
            <!-- View Toggle Buttons -->
            <div class="flex bg-blue-100 rounded-lg p-1">
                <button id="tableViewBtn" class="px-3 py-1 rounded-lg bg-blue-600 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 4a1 1 0 00-1 1v2a1 1 0 001 1h2a1 1 0 001-1V5a1 1 0 00-1-1H5zm0 4a1 1 0 00-1 1v2a1 1 0 001 1h2a1 1 0 001-1V9a1 1 0 00-1-1H5zm5-4a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 01-1 1h-2a1 1 0 01-1-1V5zm0 4a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 01-1 1h-2a1 1 0 01-1-1V9zm5-5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1h2a1 1 0 001-1V5zm0 4a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1h2a1 1 0 001-1V9z" clip-rule="evenodd" />
                    </svg>
                </button>
                <button id="cardViewBtn" class="px-3 py-1 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </button>
            </div>
            
            <!-- Filter Dropdown -->
            <select id="packageFilter" class="border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="all">All Packages</option>
                <option value="online">Online</option>
                <option value="offline">Offline</option>
            </select>
            
            <a href="{{ route('admin.packages.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Create New Package
            </a>
        </div>
    </div>

    <!-- Table View -->
    <div id="tableView" class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-blue-100">
                    <th class="py-3 px-4 text-left text-blue-800">Image</th>
                    <th class="py-3 px-4 text-left text-blue-800">Title</th>
                    <th class="py-3 px-4 text-left text-blue-800">Type</th>
                    <th class="py-3 px-4 text-left text-blue-800">Options</th>
                    <th class="py-3 px-4 text-left text-blue-800">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($packages as $package)
                    <tr class="border-b border-blue-50 package-row" data-type="{{ $package->type }}">
                        <td class="py-3 px-4">
                            @if($package->image)
                                <img src="{{ asset('storage/'.$package->image) }}" alt="{{ $package->title }}" class="w-16 h-16 object-cover rounded">
                            @else
                                <div class="w-16 h-16 bg-blue-100 rounded flex items-center justify-center">
                                    <span class="text-blue-400">No image</span>
                                </div>
                            @endif
                        </td>
                        <td class="py-3 px-4">{{ $package->title }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 rounded-full text-xs 
                                {{ $package->type === 'online' ? 'bg-blue-100 text-blue-800' : 'bg-indigo-100 text-indigo-800' }}">
                                {{ ucfirst($package->type) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            @foreach($package->options as $index => $option)
                                <div class="text-sm mb-1">
                                    <span class="font-medium">{{ $option['name'] ?? 'Option ' . ($index + 1) }}</span> -
                                    ${{ number_format($option['price'], 2) }} ({{ $option['duration'] }})
                                </div>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Card View -->
    <div id="cardView" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($packages as $package)
            <div class="package-card border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300" data-type="{{ $package->type }}">
                <div class="h-48 bg-blue-50 overflow-hidden">
                    @if($package->image)
                        <img src="{{ asset('storage/'.$package->image) }}" alt="{{ $package->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-lg text-blue-800 mb-2">{{ $package->title }}</h3>
                    <div class="mb-4">
                        @foreach($package->options as $index => $option)
                            <div class="text-sm mb-2">
                                <div class="font-medium">{{ $option['name'] ?? 'Option ' . ($index + 1) }}</div>
                                <div class="text-gray-600">${{ number_format($option['price'], 2) }} • {{ $option['duration'] }}</div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-end">
                        @if($package->type === 'online')
                            <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                Buy Now
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- 🩺 AI Therapist Chatbox Section -->
<div class="fixed bottom-6 right-6 w-80 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
    <div class="bg-blue-600 text-white p-3 font-semibold">AI Therapist Assistant</div>
    <div id="chatBox" class="p-3 h-64 overflow-y-auto space-y-2 text-sm"></div>
    <div class="p-3 border-t flex">
        <input id="userMessage" type="text" placeholder="Type your message..." class="flex-1 border border-gray-300 rounded-l-md px-3 py-2 focus:outline-none">
        <button id="sendBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded-r-md">Send</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // View toggling and filters (your existing JS)
    const tableViewBtn = document.getElementById('tableViewBtn');
    const cardViewBtn = document.getElementById('cardViewBtn');
    const tableView = document.getElementById('tableView');
    const cardView = document.getElementById('cardView');
    const packageFilter = document.getElementById('packageFilter');
    
    tableViewBtn.addEventListener('click', () => {
        tableView.classList.remove('hidden');
        cardView.classList.add('hidden');
    });
    cardViewBtn.addEventListener('click', () => {
        tableView.classList.add('hidden');
        cardView.classList.remove('hidden');
    });
    packageFilter.addEventListener('change', function() {
        const filterValue = this.value;
        document.querySelectorAll('.package-row, .package-card').forEach(el => {
            el.classList.toggle('hidden', !(filterValue === 'all' || el.dataset.type === filterValue));
        });
    });

    // 💬 Therapist Chat Logic
    const sendBtn = document.getElementById('sendBtn');
    const userMessageInput = document.getElementById('userMessage');
    const chatBox = document.getElementById('chatBox');

    sendBtn.addEventListener('click', async () => {
        const message = userMessageInput.value.trim();
        if (!message) return;

        // Display user message
        chatBox.innerHTML += `<div class='text-right text-blue-700'><b>You:</b> ${message}</div>`;
        userMessageInput.value = '';

        // Send message to Laravel endpoint
        const res = await fetch("{{ route('assistant.chat') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ message })
        });

        const data = await res.json();
        const reply = data.assistant || data.error || "No response.";
        chatBox.innerHTML += `<div class='text-left text-gray-700'><b>Dr. AI:</b> ${reply}</div>`;
        chatBox.scrollTop = chatBox.scrollHeight;
    });
});
</script>
@endsection
