<div class="space-y-4">
    @forelse($notes as $note)
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300 border-l-4 border-blue-500">
            <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        @if($note->title)
                            <h3 class="text-lg font-semibold text-gray-800">{{ $note->title }}</h3>
                        @else
                            <h3 class="text-lg font-semibold text-gray-800">Note from Dr. {{ $note->doctor->name }}</h3>
                        @endif

                        @if($note->follow_up_required)
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                Follow-up Required
                            </span>
                        @endif

                        @if($note->category)
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $note->category }}
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Dr. {{ $note->doctor->name }}
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $note->created_at->format('M d, Y') }}
                        </div>
                        @if($note->appointment)
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Linked to appointment
                            </div>
                        @endif
                    </div>

                    <div class="prose max-w-none">
                        <div class="text-gray-700 whitespace-pre-wrap">{{ $note->content }}</div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No notes found</h3>
            <p class="text-gray-600">You don't have any doctor notes matching the current filters.</p>
        </div>
    @endforelse

    @if($notes->hasPages())
        <div class="mt-6">
            {{ $notes->links() }}
        </div>
    @endif
</div>
