<div class="space-y-4">
    @forelse($appointments as $appointment)
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h3 class="text-lg font-semibold text-gray-800">
                            Dr. {{ $appointment->doctor->name }}
                        </h3>
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $appointment->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $appointment->appointment_date->format('F d, Y') }}
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ date('g:i A', strtotime($appointment->start_time)) }} - {{ date('g:i A', strtotime($appointment->end_time)) }}
                        </div>
                        @if($appointment->appointment_type)
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                {{ ucfirst($appointment->appointment_type) }}
                            </div>
                        @endif
                        @if($appointment->payment_amount)
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                NPR {{ number_format($appointment->payment_amount, 2) }}
                            </div>
                        @endif
                    </div>

                    @if($appointment->patient_notes)
                        <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-700"><strong>Your Notes:</strong> {{ $appointment->patient_notes }}</p>
                        </div>
                    @endif

                    @if($appointment->doctorNotes->count() > 0)
                        <div class="mt-3">
                            <p class="text-sm font-medium text-gray-700 mb-2">Doctor Notes:</p>
                            <div class="space-y-2">
                                @foreach($appointment->doctorNotes->where('is_private', false) as $note)
                                    <div class="p-3 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                                        @if($note->title)
                                            <p class="text-sm font-semibold text-gray-800">{{ $note->title }}</p>
                                        @endif
                                        <p class="text-sm text-gray-700">{{ Str::limit($note->content, 150) }}</p>
                                        @if($note->category)
                                            <span class="inline-block mt-2 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">{{ $note->category }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No appointments found</h3>
            <p class="text-gray-600">You don't have any appointments matching the current filters.</p>
        </div>
    @endforelse

    @if($appointments->hasPages())
        <div class="mt-6">
            {{ $appointments->links() }}
        </div>
    @endif
</div>
