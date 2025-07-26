@extends('template.template')

@section('pagecontent')
<div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Edit Doctor Profile</h1>
            <a href="{{ route('doctors.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back to List</a>
        </div>

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold border-b pb-2">Basic Information</h2>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                id="name" name="name" type="text" value="{{ old('name', $doctor->name) }}" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                id="email" name="email" type="email" value="{{ old('email', $doctor->email) }}" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="nmc_number">
                                NMC Number <span class="text-red-500">*</span>
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                id="nmc_number" name="nmc_number" type="text" value="{{ old('nmc_number', $doctor->nmc_number) }}" required>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold border-b pb-2">Professional Information</h2>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="hospital">
                                Hospital/Clinic <span class="text-red-500">*</span>
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                id="hospital" name="hospital" type="text" value="{{ old('hospital', $doctor->doctorProfile->hospital) }}" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
                                Contact Number <span class="text-red-500">*</span>
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                id="phone" name="phone" type="tel" value="{{ old('phone', $doctor->doctorProfile->phone) }}" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="specializations">
                                Specializations <span class="text-red-500">*</span>
                            </label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                id="specializations" name="specializations" rows="3" required>{{ old('specializations', $doctor->doctorProfile->specializations) }}</textarea>
                        </div>
                    </div>

                    <!-- Qualifications and Experience -->
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold border-b pb-2">Qualifications</h2>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="qualifications">
                                Degrees & Certifications <span class="text-red-500">*</span>
                            </label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                id="qualifications" name="qualifications" rows="3" required>{{ old('qualifications', $doctor->doctorProfile->qualifications) }}</textarea>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold border-b pb-2">Experience</h2>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="experience">
                                Professional Experience <span class="text-red-500">*</span>
                            </label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                id="experience" name="experience" rows="3" required>{{ old('experience', $doctor->doctorProfile->experience) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update Doctor Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
 @endsection