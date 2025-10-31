<div class="space-y-6">
    @forelse($timeline as $item)
        @if($item['type'] === 'appointment')
            @php $appointment = $item['data']; @endphp
            <div class="flex gap-4">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="w-0.5 h-full bg-gray-200 mt-2"></div>
                </div>
                <div class="flex-1 bg-white rounded-xl shadow-md p-6 mb-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="text-lg font-semibold text-gray-800">Appointment with Dr. {{ $appointment->doctor->name }}</h4>
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $appointment->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">
                        {{ $appointment->appointment_date->format('F d, Y') }} at {{ date('g:i A', strtotime($appointment->start_time)) }}
                    </p>
                    @if($appointment->patient_notes)
                        <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-700"><strong>Patient Notes:</strong> {{ $appointment->patient_notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @else
            @php $note = $item['data']; @endphp
            <div class="flex gap-4">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="w-0.5 h-full bg-gray-200 mt-2"></div>
                </div>
                <div class="flex-1 bg-white rounded-xl shadow-md p-6 mb-4 border-l-4 border-green-500">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold text-gray-800">
                                {{ $note->title ?: 'Doctor Note' }}
                            </h4>
                            <p class="text-sm text-gray-600">by Dr. {{ $note->doctor->name }}</p>
                        </div>
                        <div class="flex gap-2">
                            @if($note->is_private)
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Private</span>
                            @endif
                            @if($note->follow_up_required)
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">Follow-up</span>
                            @endif
                            @if($note->category)
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $note->category }}</span>
                            @endif
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">{{ $note->created_at->format('F d, Y \a\t g:i A') }}</p>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $note->content }}</p>
                    </div>
                    @if($note->doctor_id === auth()->id())
                        <div class="mt-4 flex gap-2">
                            <form action="{{ route('doctor.notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this note?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    @empty
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No timeline data</h3>
            <p class="text-gray-600">This patient doesn't have any appointments or notes yet.</p>
        </div>
    @endforelse
</div>
