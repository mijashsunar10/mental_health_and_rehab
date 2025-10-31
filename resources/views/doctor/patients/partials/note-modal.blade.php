<div x-show="showNoteModal"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="showNoteModal = false"></div>

        <!-- Modal panel -->
        <div class="inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            <form action="{{ route('doctor.notes.store') }}" method="POST">
                @csrf

                <input type="hidden" name="user_id" value="{{ $patient->id }}">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Add New Note</h3>
                    <button type="button" @click="showNoteModal = false" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <!-- Appointment Selection -->
                    <div>
                        <label for="appointment_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Link to Appointment (Optional)
                        </label>
                        <select name="appointment_id" id="appointment_id"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- No appointment link --</option>
                            @foreach($appointments as $appointment)
                                <option value="{{ $appointment->id }}">
                                    {{ $appointment->appointment_date->format('M d, Y') }} - {{ date('g:i A', strtotime($appointment->start_time)) }}
                                    ({{ ucfirst($appointment->status) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Title (Optional)
                        </label>
                        <input type="text" name="title" id="title"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Brief title for this note">
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                            Category (Optional)
                        </label>
                        <select name="category" id="category"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Select category --</option>
                            <option value="Assessment">Assessment</option>
                            <option value="Treatment">Treatment</option>
                            <option value="Progress">Progress</option>
                            <option value="Medication">Medication</option>
                            <option value="Therapy Session">Therapy Session</option>
                            <option value="Follow-up">Follow-up</option>
                            <option value="General">General</option>
                        </select>
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                            Note Content <span class="text-red-500">*</span>
                        </label>
                        <textarea name="content" id="content" rows="8" required
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Enter detailed note content..."></textarea>
                    </div>

                    <!-- Checkboxes -->
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_private" id="is_private" value="1"
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <label for="is_private" class="ml-2 block text-sm text-gray-700">
                                Private note (patient cannot see this)
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="follow_up_required" id="follow_up_required" value="1"
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <label for="follow_up_required" class="ml-2 block text-sm text-gray-700">
                                Follow-up required
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showNoteModal = false"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-300">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                        Save Note
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
