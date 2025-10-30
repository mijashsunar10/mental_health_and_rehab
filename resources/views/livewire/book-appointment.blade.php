<div class="w-full">
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Date Selection -->
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Select Appointment Date</h3>

        @if(count($availableDates) > 0)
            <div class="grid grid-cols-3 md:grid-cols-5 gap-2">
                @foreach($availableDates as $dateInfo)
                    <button
                        wire:key="date-{{ $dateInfo['date'] }}"
                        wire:click="selectDate('{{ $dateInfo['date'] }}')"
                        class="p-3 text-center rounded-lg border-2 transition-all {{ $selectedDate === $dateInfo['date'] ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-200 hover:border-blue-400' }}">
                        <div class="text-xs font-medium">{{ $dateInfo['display'] }}</div>
                    </button>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 bg-gray-50 rounded-lg">
                <p class="text-gray-600">No available dates. The doctor hasn't set their availability yet.</p>
            </div>
        @endif
    </div>

    <!-- Time Slots Selection -->
    @if($selectedDate && count($availableSlots) > 0)
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Available Time Slots</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                @foreach($availableSlots as $slot)
                    <button
                        wire:key="slot-{{ $slot['start_time'] }}"
                        wire:click="selectSlot('{{ $slot['start_time'] }}')"
                        @if($slot['is_booked']) disabled @endif
                        class="p-3 text-center rounded-lg border-2 transition-all
                            {{ $slot['is_booked'] ? 'bg-gray-100 text-gray-400 border-gray-200 cursor-not-allowed' :
                               ($selectedSlot === $slot['start_time'] ? 'bg-green-600 text-white border-green-600' :
                               'bg-white text-gray-700 border-gray-200 hover:border-green-400') }}">
                        <div class="text-sm font-medium">{{ $slot['display'] }}</div>
                        @if($slot['is_booked'])
                            <div class="text-xs mt-1">Booked</div>
                        @endif
                    </button>
                @endforeach
            </div>
        </div>
    @elseif($selectedDate)
        <div class="mb-6 text-center py-8 bg-gray-50 rounded-lg">
            <p class="text-gray-600">No available slots for this date.</p>
        </div>
    @endif

    <!-- Book Appointment Button -->
    @if($selectedDate && $selectedSlot)
        <div class="text-center">
            <button
                wire:click="openBookingModal"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-full transition-all transform hover:scale-105">
                <div class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Book Appointment
                </div>
            </button>
        </div>
    @endif

    <!-- Booking Confirmation Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeModal">
            <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4" wire:click.stop>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Confirm Appointment</h2>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <!-- Doctor Info -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">{{ $doctor->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $doctor->nmc_number ? 'NMC: ' . $doctor->nmc_number : 'Psychiatrist' }}</p>
                    </div>

                    <!-- Appointment Details -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <div class="bg-blue-50 p-3 rounded-lg text-sm font-medium text-blue-800">
                                {{ \Carbon\Carbon::parse($selectedDate)->format('M j, Y') }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                            <div class="bg-blue-50 p-3 rounded-lg text-sm font-medium text-blue-800">
                                {{ \Carbon\Carbon::parse($selectedSlot)->format('g:i A') }}
                            </div>
                        </div>
                    </div>

                    <!-- Appointment Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Appointment Type</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative flex items-center p-4 bg-white border-2 rounded-lg cursor-pointer transition-all {{ $appointmentType === 'physical' ? 'border-blue-600 bg-blue-50' : 'border-gray-200 hover:border-blue-300' }}">
                                <input
                                    type="radio"
                                    wire:model="appointmentType"
                                    value="physical"
                                    class="sr-only">
                                <div class="flex items-center gap-3 w-full">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 {{ $appointmentType === 'physical' ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <div class="flex-grow">
                                        <div class="font-semibold text-sm {{ $appointmentType === 'physical' ? 'text-blue-800' : 'text-gray-700' }}">Physical</div>
                                        <div class="text-xs text-gray-500">In-person visit</div>
                                    </div>
                                    @if($appointmentType === 'physical')
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </label>

                            <label class="relative flex items-center p-4 bg-white border-2 rounded-lg cursor-pointer transition-all {{ $appointmentType === 'virtual' ? 'border-green-600 bg-green-50' : 'border-gray-200 hover:border-green-300' }}">
                                <input
                                    type="radio"
                                    wire:model="appointmentType"
                                    value="virtual"
                                    class="sr-only">
                                <div class="flex items-center gap-3 w-full">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 {{ $appointmentType === 'virtual' ? 'text-green-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex-grow">
                                        <div class="font-semibold text-sm {{ $appointmentType === 'virtual' ? 'text-green-800' : 'text-gray-700' }}">Virtual</div>
                                        <div class="text-xs text-gray-500">Online video call</div>
                                    </div>
                                    @if($appointmentType === 'virtual')
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </label>
                        </div>
                        @error('appointmentType') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Patient Notes -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Reason for Visit (Optional)</label>
                        <textarea
                            wire:model="patientNotes"
                            rows="3"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Brief description of your concerns..."></textarea>
                        @error('patientNotes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-4">
                        <button
                            wire:click="closeModal"
                            class="flex-1 border border-gray-300 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button
                            wire:click="bookAppointment"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition-colors">
                            Confirm Booking
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
