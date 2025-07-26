@extends('template.template')

@section('pagecontent')
<div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">{{ $doctor->name }}</h1>
                <a href="{{ route('doctors.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Back to List</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-semibold mb-2">Basic Information</h2>
                    <p><strong>Email:</strong> {{ $doctor->email }}</p>
                    <p><strong>NMC Number:</strong> {{ $doctor->nmc_number }}</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-2">Professional Information</h2>
                    <p><strong>Hospital:</strong> {{ $doctor->doctorProfile->hospital }}</p>
                    <p><strong>Phone:</strong> {{ $doctor->doctorProfile->phone }}</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-2">Specializations</h2>
                    <p>{{ $doctor->doctorProfile->specializations }}</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-2">Qualifications</h2>
                    <p>{{ $doctor->doctorProfile->qualifications }}</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-2">Experience</h2>
                    <p>{{ $doctor->doctorProfile->experience }}</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('doctors.edit', $doctor->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded mr-2">Edit</a>
                <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection