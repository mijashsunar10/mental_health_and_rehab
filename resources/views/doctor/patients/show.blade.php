<x-layouts.app :title="__('Patient Records - ' . $patient->name)">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl" x-data="{ showNoteModal: false, editingNote: null }">
        <!-- Header -->
        <div class="relative mb-6 w-full">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <flux:heading size="xl" level="1">{{ $patient->name }}</flux:heading>
                    <flux:subheading size="lg" class="mb-2">{{ __('Patient Medical Records') }}</flux:subheading>
                </div>
                <a href="{{ route('doctor.patients.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Patients
                </a>
            </div>
            <flux:separator variant="subtle" />
        </div>

        @if(session('success'))
            <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Patient Info & Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Patient Info Card -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Patient Information</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="text-sm font-medium text-gray-900">{{ $patient->email }}</p>
                    </div>
                    @if($patient->phone)
                        <div>
                            <p class="text-sm text-gray-600">Phone</p>
                            <p class="text-sm font-medium text-gray-900">{{ $patient->phone }}</p>
                        </div>
                    @endif
                    @if($patient->dob)
                        <div>
                            <p class="text-sm text-gray-600">Date of Birth</p>
                            <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($patient->dob)->format('M d, Y') }}</p>
                        </div>
                    @endif
                    @if($patient->address)
                        <div>
                            <p class="text-sm text-gray-600">Address</p>
                            <p class="text-sm font-medium text-gray-900">{{ $patient->address }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="lg:col-span-2 grid grid-cols-2 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-blue-500">
                    <p class="text-sm text-gray-600">Total Appointments</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['total_appointments'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-green-500">
                    <p class="text-sm text-gray-600">Completed</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['completed_appointments'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-purple-500">
                    <p class="text-sm text-gray-600">Upcoming</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['upcoming_appointments'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-yellow-500">
                    <p class="text-sm text-gray-600">Total Sessions</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['total_sessions'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-indigo-500">
                    <p class="text-sm text-gray-600">Total Notes</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['total_notes'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-orange-500">
                    <p class="text-sm text-gray-600">Follow-ups</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['follow_up_required'] }}</p>
                </div>
            </div>
        </div>

        <!-- Add Note Button -->
        <div class="mb-6">
            <button @click="showNoteModal = true; editingNote = null"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Note
            </button>
        </div>

        <!-- Tabs -->
        <div x-data="{ tab: 'timeline' }">
            <div class="border-b border-gray-200 mb-6">
                <nav class="-mb-px flex space-x-8">
                    <button @click="tab = 'timeline'"
                            :class="tab === 'timeline' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Timeline
                    </button>
                    <button @click="tab = 'appointments'"
                            :class="tab === 'appointments' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Appointments ({{ $appointments->count() }})
                    </button>
                    <button @click="tab = 'notes'"
                            :class="tab === 'notes' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Notes ({{ $notes->count() }})
                    </button>
                    <button @click="tab = 'packages'"
                            :class="tab === 'packages' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Packages ({{ $purchases->count() }})
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div x-show="tab === 'timeline'">
                @include('doctor.patients.partials.timeline', ['timeline' => $timeline])
            </div>

            <div x-show="tab === 'appointments'" style="display: none;">
                @include('doctor.patients.partials.appointments', ['appointments' => $appointments, 'patient' => $patient])
            </div>

            <div x-show="tab === 'notes'" style="display: none;">
                @include('doctor.patients.partials.notes', ['notes' => $notes, 'patient' => $patient])
            </div>

            <div x-show="tab === 'packages'" style="display: none;">
                @include('doctor.patients.partials.packages', ['purchases' => $purchases])
            </div>
        </div>

        <!-- Add/Edit Note Modal -->
        @include('doctor.patients.partials.note-modal', ['patient' => $patient])
    </div>

    @push('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
    @endpush
</x-layouts.app>
