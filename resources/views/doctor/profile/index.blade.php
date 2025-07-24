@extends('template.template')

@section('pagecontent')
<div class="max-w-6xl mx-auto py-12 px-6">
    <h2 class="text-3xl font-bold text-pastry-primary mb-8 text-center">Our Doctors</h2>

    <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6">
        @forelse($doctors as $profile)
            <a href="{{ route('doctor.profile.show', $profile->user_id) }}"
                class="group block bg-white border border-gray-200 rounded-2xl shadow hover:shadow-lg transition-all duration-200">
                <div class="p-4 flex flex-col items-center text-center">
                    <img src="{{ $profile->profile_image ? asset('storage/' . $profile->profile_image) : asset('images/doctor-placeholder.png') }}"
                        alt="{{ $profile->user->name }}"
                        class="w-32 h-32 rounded-full object-cover mb-4 border-4 border-pastry-secondary shadow-inner group-hover:scale-105 transition">

                    <h3 class="text-xl font-semibold text-pastry-primary">{{ $profile->user->name }}</h3>
                    <p class="text-sm text-pastry-accent">{{ $profile->specialization }}</p>

                    <div class="mt-2 text-gray-600 text-sm">
                        {{ Str::limit($profile->bio, 80) }}
                    </div>

                    <div class="mt-4">
                        <span class="inline-block bg-pastry-accent text-white text-xs font-semibold px-3 py-1 rounded-full">
                            View Profile
                        </span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center text-gray-500">No doctor profiles found.</div>
        @endforelse
    </div>
</div>
@endsection
