<x-layouts.app :title="__('My Medical Records')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Header -->
        <div class="relative mb-6 w-full">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <flux:heading size="xl" level="1">{{ __('My Medical Records') }}</flux:heading>
                    <flux:subheading size="lg" class="mb-2">{{ __('View your complete medical history') }}</flux:subheading>
                </div>
                <a href="{{ route('records.export-pdf', request()->query()) }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export to PDF
                </a>
            </div>
            <flux:separator variant="subtle" />
        </div>

        @if(session('success'))
            <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('records.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                           class="w-full text-gray-900 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                           class="w-full text-gray-900 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">Doctor</label>
                    <select name="doctor_id" id="doctor_id"
                            class="w-full text-gray-900 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Doctors</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status"
                            class="w-full text-gray-900 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="md:col-span-4 flex gap-2">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                        Apply Filters
                    </button>
                    <a href="{{ route('records.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-300">
                        Clear Filters
                    </a>
                </div>
            </form>
        </div>

        <!-- Tabs -->
        <div x-data="{ tab: 'appointments' }">
            <div class="mb-6">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button @click="tab = 'appointments'"
                                :class="tab === 'appointments' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Appointments ({{ $appointments->total() }})
                        </button>
                        <button @click="tab = 'packages'"
                                :class="tab === 'packages' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Packages ({{ $purchases->count() }})
                        </button>
                        <button @click="tab = 'notes'"
                                :class="tab === 'notes' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Doctor Notes ({{ $notes->total() }})
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Tab Content -->
            <div x-show="tab === 'appointments'">
                @include('records.partials.appointments', ['appointments' => $appointments])
            </div>

            <div x-show="tab === 'packages'" style="display: none;">
                @include('records.partials.packages', ['purchases' => $purchases])
            </div>

            <div x-show="tab === 'notes'" style="display: none;">
                @include('records.partials.notes', ['notes' => $notes])
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
    @endpush
</x-layouts.app>
