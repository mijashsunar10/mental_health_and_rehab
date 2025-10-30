<div class="w-full">
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">My Appointments</h2>
            <div class="text-sm text-gray-600">
                Total: <span class="font-semibold">{{ $appointments->count() }}</span>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter Tabs -->
        <div class="mb-6 border-b border-gray-200">
            <div class="flex gap-4">
                <button
                    wire:click="setFilter('upcoming')"
                    class="pb-3 px-4 text-sm font-medium border-b-2 transition-colors {{ $filter === 'upcoming' ? 'text-blue-600 border-blue-600' : 'text-gray-500 border-transparent hover:text-gray-700' }}">
                    Upcoming
                </button>
                <button
                    wire:click="setFilter('past')"
                    class="pb-3 px-4 text-sm font-medium border-b-2 transition-colors {{ $filter === 'past' ? 'text-blue-600 border-blue-600' : 'text-gray-500 border-transparent hover:text-gray-700' }}">
                    Past
                </button>
                <button
                    wire:click="setFilter('all')"
                    class="pb-3 px-4 text-sm font-medium border-b-2 transition-colors {{ $filter === 'all' ? 'text-blue-600 border-blue-600' : 'text-gray-500 border-transparent hover:text-gray-700' }}">
                    All
                </button>
            </div>
        </div>

        <!-- Appointments List -->
        @if($appointments->isEmpty())
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="mt-4 text-gray-600">No appointments found.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($appointments as $appointment)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold">
                                        {{ $appointment->patient->initials() }}
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $appointment->patient->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $appointment->patient->email }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Date</p>
                                        <p class="text-sm font-medium text-gray-800">
                                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Time</p>
                                        <p class="text-sm font-medium text-gray-800">
                                            {{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }} -
                                            {{ \Carbon\Carbon::parse($appointment->end_time)->format('g:i A') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Status</p>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $appointment->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $appointment->status === 'completed' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Contact</p>
                                        <p class="text-sm font-medium text-gray-800">
                                            {{ $appointment->patient->phone ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>

                                @if($appointment->patient_notes)
                                    <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                                        <p class="text-xs text-gray-500 mb-1">Patient Notes:</p>
                                        <p class="text-sm text-gray-700">{{ $appointment->patient_notes }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="ml-4">
                                <button
                                    wire:click="viewDetails({{ $appointment->id }})"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Details Modal -->
    @if($showDetailsModal && $selectedAppointment)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeModal">
            <div class="bg-white rounded-2xl p-8 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto" wire:click.stop>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Appointment Details</h2>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-6">
                    <!-- Patient Information -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Patient Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Name</p>
                                <p class="text-base font-medium text-gray-800">{{ $selectedAppointment->patient->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="text-base font-medium text-gray-800">{{ $selectedAppointment->patient->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="text-base font-medium text-gray-800">{{ $selectedAppointment->patient->phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Address</p>
                                <p class="text-base font-medium text-gray-800">{{ $selectedAppointment->patient->address ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Appointment Details -->
                    <div class="bg-blue-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Appointment Details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Date</p>
                                <p class="text-base font-medium text-gray-800">
                                    {{ \Carbon\Carbon::parse($selectedAppointment->appointment_date)->format('l, F d, Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Time</p>
                                <p class="text-base font-medium text-gray-800">
                                    {{ \Carbon\Carbon::parse($selectedAppointment->start_time)->format('g:i A') }} -
                                    {{ \Carbon\Carbon::parse($selectedAppointment->end_time)->format('g:i A') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $selectedAppointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $selectedAppointment->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $selectedAppointment->status === 'completed' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $selectedAppointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($selectedAppointment->status) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Booked On</p>
                                <p class="text-base font-medium text-gray-800">
                                    {{ $selectedAppointment->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Patient Notes -->
                    @if($selectedAppointment->patient_notes)
                        <div class="bg-yellow-50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Patient's Reason for Visit</h3>
                            <p class="text-gray-700">{{ $selectedAppointment->patient_notes }}</p>
                        </div>
                    @endif

                    <!-- Doctor Notes -->
                    <div class="bg-green-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Your Notes</h3>
                        <textarea
                            wire:model.defer="selectedAppointment.notes"
                            rows="4"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Add your notes about this appointment...">{{ $selectedAppointment->notes }}</textarea>
                        <button
                            wire:click="addNotes({{ $selectedAppointment->id }}, $event.target.previousElementSibling.value)"
                            class="mt-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                            Save Notes
                        </button>
                    </div>

                    <!-- Status Management -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Update Status</h3>
                        <div class="flex gap-2">
                            @if($selectedAppointment->status === 'pending')
                                <button
                                    wire:click="updateStatus({{ $selectedAppointment->id }}, 'confirmed')"
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    Confirm Appointment
                                </button>
                            @endif

                            @if(in_array($selectedAppointment->status, ['pending', 'confirmed']))
                                <button
                                    wire:click="updateStatus({{ $selectedAppointment->id }}, 'completed')"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    Mark as Completed
                                </button>

                                <button
                                    wire:click="updateStatus({{ $selectedAppointment->id }}, 'cancelled')"
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    Cancel Appointment
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
