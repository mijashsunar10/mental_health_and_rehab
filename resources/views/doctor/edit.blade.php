@extends('template.template')

@section('pagecontent')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Your Doctor Profile</h1>
                
                <form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="space-y-4">
                            <div>
                                <label for="specialization" class="block text-sm font-medium text-gray-700">Specialization*</label>
                                <input type="text" id="specialization" name="specialization" 
                                    value="{{ old('specialization', $profile->specialization) }}" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label for="qualifications" class="block text-sm font-medium text-gray-700">Qualifications*</label>
                                <textarea id="qualifications" name="qualifications" rows="3" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('qualifications', $profile->qualifications) }}</textarea>
                                <p class="mt-1 text-sm text-gray-500">List your degrees and certifications</p>
                            </div>
                            
                            <div>
                                <label for="experience" class="block text-sm font-medium text-gray-700">Experience*</label>
                                <textarea id="experience" name="experience" rows="3" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('experience', $profile->experience) }}</textarea>
                                <p class="mt-1 text-sm text-gray-500">Describe your professional experience</p>
                            </div>
                            
                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                                <textarea id="bio" name="bio" rows="3"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('bio', $profile->bio) }}</textarea>
                                <p class="mt-1 text-sm text-gray-500">Tell patients about yourself</p>
                            </div>
                            
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700">Profile Photo</label>
                                @if($profile->photo)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $profile->photo) }}" alt="Current Photo" class="h-24 w-24 rounded-md object-cover">
                                    </div>
                                @endif
                                <input type="file" id="photo" name="photo"
                                    class="mt-1 block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100">
                            </div>
                        </div>
                        
                        <!-- Contact & Availability -->
                        <div class="space-y-4">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="text" id="phone" name="phone" 
                                    value="{{ old('phone', $profile->phone) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <input type="text" id="address" name="address" 
                                    value="{{ old('address', $profile->address) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                    <input type="text" id="city" name="city" 
                                        value="{{ old('city', $profile->city) }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                                    <input type="text" id="state" name="state" 
                                        value="{{ old('state', $profile->state) }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                    <input type="text" id="country" name="country" 
                                        value="{{ old('country', $profile->country) }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                                    <input type="text" id="postal_code" name="postal_code" 
                                        value="{{ old('postal_code', $profile->postal_code) }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Working Days*</label>
                                <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-2">
                                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                        <div class="flex items-center">
                                            <input type="checkbox" id="day_{{ strtolower($day) }}" name="working_days[]" value="{{ $day }}"
                                                {{ in_array($day, old('working_days', $profile->working_days)) ? 'checked' : '' }}
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="day_{{ strtolower($day) }}" class="ml-2 block text-sm text-gray-700">{{ $day }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time*</label>
                                    <input type="time" id="start_time" name="start_time" 
                                        value="{{ old('start_time', $profile->start_time) }}" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="end_time" class="block text-sm font-medium text-gray-700">End Time*</label>
                                    <input type="time" id="end_time" name="end_time" 
                                        value="{{ old('end_time', $profile->end_time) }}" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('doctor.profile.show', auth()->id()) }}" 
                           class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-6 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection