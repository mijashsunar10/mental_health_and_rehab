@extends('template.template')

@section('pagecontent')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Our Doctors</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($doctors as $doctor)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            @if($doctor->doctorProfile && $doctor->doctorProfile->photo)
                                <img src="{{ asset('storage/' . $doctor->doctorProfile->photo) }}" alt="{{ $doctor->name }}" class="w-full h-64 object-cover">
                            @else
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">No photo available</span>
                                </div>
                            @endif
                            
                            <div class="p-6">
                                <h2 class="text-xl font-semibold text-gray-800">{{ $doctor->name }}</h2>
                                
                                @if($doctor->doctorProfile)
                                    <p class="text-blue-600 mt-2">{{ $doctor->doctorProfile->specialization }}</p>
                                    <p class="text-gray-600 mt-2">{{ $doctor->doctorProfile->qualifications }}</p>
                                    <p class="text-gray-600 mt-2">NMC: {{ $doctor->nmc_number }}</p>
                                @endif
                                
                                <div class="mt-4">
                                    <a href="{{ route('doctors.show', $doctor->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">View Profile →</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6">
                    {{ $doctors->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection