<div class="w-full">
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Manage Your Availability</h2>

        @if (session()->has('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add Availability Form -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New Availability</h3>

            <form wire:submit.prevent="addAvailability" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Date Selection -->
                    <div>
                        <label for="selectedDate" class="block text-sm font-medium text-gray-700 mb-2">Select Date</label>
                        <input type="date" wire:model="selectedDate" id="selectedDate" min="{{ date('Y-m-d') }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring text-black focus:ring-blue-200">
                        @error('selectedDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Start Time -->
                    <div>
                        <label for="startTime" class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                        <input type="time" wire:model="startTime" id="startTime" class="w-full rounded-lg border-gray-300 focus:border-blue-500 text-black focus:ring focus:ring-blue-200">
                        @error('startTime') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- End Time -->
                    <div>
                        <label for="endTime" class="block text-sm font-medium text-gray-700 mb-2">End Time</label>
                        <input type="time" wire:model="endTime" id="endTime" class="w-full rounded-lg border-gray-300 focus:border-blue-500 text-black focus:ring focus:ring-blue-200">
                        @error('endTime') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        <p class="text-xs text-gray-500 mt-1">1-hour slots will be created automatically</p>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                        Add Availability
                    </button>
                </div>
            </form>
        </div>

        <!-- Current Availabilities -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Your Current Schedule</h3>

            @if($availabilities->isEmpty())
                <div class="text-center py-12 bg-gray-50 rounded-lg">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="mt-4 text-gray-600">No availability set yet. Add your first available slot above.</p>
                </div>
            @else
                <div class="space-y-6">
                    @php
                        $groupedByDate = $availabilities->groupBy(function($item) {
                            return \Carbon\Carbon::parse($item->availability_date)->format('Y-m-d');
                        });
                    @endphp

                    @foreach($groupedByDate as $date => $slots)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="text-md font-semibold text-gray-800 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($date)->format('l, F d, Y') }}
                            </h4>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                @foreach($slots as $availability)
                                        <div class="flex items-center justify-between p-3 rounded-lg {{ $availability->is_available ? 'bg-green-50 border border-green-200' : 'bg-gray-100 border border-gray-300' }}">
                                            <div class="flex-1">
                                                <p class="text-sm font-medium {{ $availability->is_available ? 'text-green-800' : 'text-gray-600' }}">
                                                    {{ \Carbon\Carbon::parse($availability->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($availability->end_time)->format('g:i A') }}
                                                </p>
                                                <p class="text-xs {{ $availability->is_available ? 'text-green-600' : 'text-gray-500' }}">
                                                    {{ $availability->is_available ? 'Available' : 'Unavailable' }}
                                                </p>
                                            </div>

                                            <div class="flex gap-1">
                                                <!-- Toggle Button -->
                                                <button wire:click="toggleAvailability({{ $availability->id }})" class="p-1 rounded hover:bg-white transition-colors" title="Toggle availability">
                                                    @if($availability->is_available)
                                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                        </svg>
                                                    @endif
                                                </button>

                                                <!-- Delete Button -->
                                                <button wire:click="deleteAvailability({{ $availability->id }})" class="p-1 rounded hover:bg-white transition-colors" title="Delete">
                                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
