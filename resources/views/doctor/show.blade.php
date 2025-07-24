@extends('template.template')

@section('pagecontent')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Doctor Photo -->
                        <div class="w-full md:w-1/3">
                            @if ($doctor->doctorProfile && $doctor->doctorProfile->photo)
                                <img src="{{ asset('storage/' . $doctor->doctorProfile->photo) }}" alt="{{ $doctor->name }}"
                                    class="w-full rounded-lg shadow-md">
                            @else
                                <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500">No photo available</span>
                                </div>
                            @endif

                            <!-- Edit button for profile owner -->
                            @auth('doctor')
                                @if (auth()->user()->role === \App\Enums\UserRole::Doctor->value)
                                    <div class="mt-4">
                                        <a href="{{ route('doctor.profile.edit') }}"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-block">
                                            Edit Profile
                                        </a>
                                    </div>
                                @endif
                            @endauth
                        </div>

                        <!-- Doctor Details -->
                        <div class="w-full md:w-2/3">
                            <h1 class="text-3xl font-bold text-gray-800">{{ $doctor->name }}</h1>

                            @if ($doctor->doctorProfile)
                                <div class="mt-4">
                                    <h2 class="text-xl font-semibold text-blue-600">
                                        {{ $doctor->doctorProfile->specialization }}
                                    </h2>
                                    <p class="text-gray-600 mt-2">NMC Number: {{ $doctor->nmc_number }}</p>
                                </div>

                                <div class="mt-6">
                                    <h3 class="text-xl font-semibold text-gray-800 border-b pb-2">Qualifications</h3>
                                    <p class="mt-2 text-gray-700 whitespace-pre-line">
                                        {{ $doctor->doctorProfile->qualifications }}</p>
                                </div>

                                <div class="mt-6">
                                    <h3 class="text-xl font-semibold text-gray-800 border-b pb-2">Experience</h3>
                                    <p class="mt-2 text-gray-700 whitespace-pre-line">
                                        {{ $doctor->doctorProfile->experience }}</p>
                                </div>

                                <div class="mt-6">
                                    <h3 class="text-xl font-semibold text-gray-800 border-b pb-2">About</h3>
                                    <p class="mt-2 text-gray-700 whitespace-pre-line">
                                        {{ $doctor->doctorProfile->bio ?? 'Not provided' }}</p>
                                </div>

                                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800 border-b pb-2">Contact</h3>
                                        <p class="mt-2 text-gray-700">
                                            <strong>Email:</strong> {{ $doctor->email }}<br>
                                            <strong>Phone:</strong>
                                            {{ $doctor->doctorProfile->phone ?? 'Not provided' }}<br>
                                            <strong>Address:</strong>
                                            @if ($doctor->doctorProfile->address)
                                                {{ $doctor->doctorProfile->address }},
                                                {{ $doctor->doctorProfile->city }},
                                                {{ $doctor->doctorProfile->state }},
                                                {{ $doctor->doctorProfile->country }} -
                                                {{ $doctor->doctorProfile->postal_code }}
                                            @else
                                                Not provided
                                            @endif
                                        </p>
                                    </div>

                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800 border-b pb-2">Availability</h3>
                                        <p class="mt-2 text-gray-700">
                                            <strong>Working Days:</strong>
                                            {{ implode(', ', $doctor->doctorProfile->working_days) }}<br>
                                            <strong>Timings:</strong>
                                            {{ \Carbon\Carbon::parse($doctor->doctorProfile->start_time)->format('h:i A') }}
                                            -
                                            {{ \Carbon\Carbon::parse($doctor->doctorProfile->end_time)->format('h:i A') }}
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="mt-4 p-4 bg-yellow-100 text-yellow-800 rounded-lg">
                                    Profile information not yet provided by the doctor.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
