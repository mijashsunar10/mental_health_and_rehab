@extends('template.template')

@section('pagecontent')
<div class="max-w-4xl mx-auto py-12 px-6">
    <div class="bg-white p-6 rounded-2xl shadow-xl flex flex-col md:flex-row gap-6">
        @if($profile->profile_image)
            <div class="flex-shrink-0">
                <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="Doctor Profile Image"
                    class="rounded-xl w-48 h-48 object-cover">
            </div>
        @endif

        <div>
            <h2 class="text-3xl font-bold text-pastry-primary mb-2">{{ $profile->user->name }}</h2>
            <p class="text-pastry-accent text-lg font-semibold mb-4">{{ $profile->user->nmc_number }}</p>
            <p class="text-pastry-accent text-lg font-semibold mb-4">{{ $profile->specialization }}</p>

            <div class="space-y-2 text-gray-700">
                <p><span class="font-medium text-pastry-secondary">Education:</span><br>{{ $profile->education }}</p>
                <p><span class="font-medium text-pastry-secondary">Experience:</span><br>{{ $profile->experience }}</p>
                <p><span class="font-medium text-pastry-secondary">Bio:</span><br>{{ $profile->bio }}</p>
            </div>
        </div>
    </div>

    @auth
        @if(auth()->user()->id === $profile->user_id && auth()->user()->role === 'doctor')
            <div class="text-right mt-6">
                <a href="{{ route('doctor.profile.edit') }}"
                    class="inline-block bg-pastry-accent hover:bg-pastry-secondary text-white font-semibold px-6 py-2 rounded-xl shadow">
                    Edit Profile
                </a>
            </div>
        @endif
    @endauth
</div>
@endsection
