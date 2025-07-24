@extends('template.template')

@section('pagecontent')
<div class="max-w-3xl mx-auto py-12 px-6">
    <h2 class="text-2xl font-semibold mb-6 text-pastry-primary">Edit Your Profile</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-2xl shadow-xl">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Specialization</label>
            <input type="text" name="specialization" value="{{ old('specialization', $profile->specialization) }}" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pastry-primary focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Education</label>
            <textarea name="education" rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pastry-primary focus:outline-none">{{ old('education', $profile->education) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Experience</label>
            <textarea name="experience" rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pastry-primary focus:outline-none">{{ old('experience', $profile->experience) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
            <textarea name="bio" rows="4"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pastry-primary focus:outline-none">{{ old('bio', $profile->bio) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Profile Image</label>
            <input type="file" name="profile_image"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg file:bg-pastry-secondary file:text-white file:px-4 file:py-2">
        </div>

        <div class="pt-4">
            <button type="submit"
                class="bg-pastry-primary hover:bg-pastry-secondary text-white font-semibold px-6 py-2 rounded-xl shadow">
                Update Profile
            </button>
        </div>
    </form>
</div>
@endsection
