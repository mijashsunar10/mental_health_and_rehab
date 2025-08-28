@extends('template.template')

@section('pagecontent')

<!-- Our Team Section -->
<section class="py-20 px-4 bg-gradient-to-b from-blue-50 to-white mt-12" id="team-section">
    <div class="max-w-7xl mx-auto">
        <!-- Section Header with Create Button -->
        <div class="text-center mb-16 relative scroll-reveal">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div>
                    <span class="inline-block px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold mb-4 animate-reveal-up">
                        Meet Our Professionals
                    </span>
                </div>
                @auth
                 @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                    <a href="{{ route('ourteam.create') }}"
                        class="flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-300 shadow-md hover:shadow-lg animate-bounce-in"
                        style="animation-delay: 0.2s">
                        <i class="fas fa-plus mr-2"></i> Add Team Member
                    </a>
                    @endauth
                @endauth
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-blue-800 mb-4 animate-reveal-up">
                Our <span class="text-blue-600">Expert Team</span>
            </h2>
            <p class="text-gray-600 max-w-3xl mx-auto text-lg animate-reveal-up" style="animation-delay: 0.2s">
                Meet our dedicated team of professionals who bring years of experience and passion to every project. 
                Together, we deliver exceptional results for our clients.
            </p>
        </div>

        <!-- Team Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($teamMembers as $index => $member)
                <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 group relative scroll-reveal hover:-translate-y-2"
                    style="transition-delay: {{ $index * 0.1 }}s">
                    <!-- Admin Controls (Edit/Delete) -->
                    @auth
                        <div class="absolute top-4 right-4 z-10 flex space-x-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
                            <a href="{{ route('ourteam.edit', $member->id) }}"
                                class="w-9 h-9 flex items-center justify-center bg-white text-blue-600 rounded-full shadow-md hover:bg-blue-50 transition-all animate-bounce-in"
                                style="animation-delay: 0.2s"
                                aria-label="Edit {{ $member->name }}">
                                <i class="fas fa-pencil-alt text-sm"></i>
                            </a>
                            <form action="{{ route('ourteam.destroy', $member->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this team member?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-9 h-9 flex items-center justify-center bg-white text-red-600 rounded-full shadow-md hover:bg-red-50 transition-all animate-bounce-in"
                                    style="animation-delay: 0.3s"
                                    aria-label="Delete {{ $member->name }}">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </form>
                        </div>
                    @endauth

                    <!-- Team Member Card -->
                    <div class="relative overflow-hidden h-80">
                        <!-- Team Member Image -->
                        <img src="{{ $member->image_path ? asset('storage/' . $member->image_path) : asset('images/default-team-member.jpg') }}"
                            loading="lazy" alt="{{ $member->name }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                        
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 via-gray-900/30 to-gray-900/10"></div>
                        
                        <!-- Member Info -->
                        <div class="absolute bottom-0 left-0 p-6 w-full">
                            <h3 class="text-2xl font-bold text-blue-600 drop-shadow-md">{{ $member->name }}</h3>
                            <p class="font-semibold text-white drop-shadow-md">{{ $member->position }}</p>
                            
                            <!-- Social Links -->
                            @if($member->social_instagram || $member->social_facebook)
                            <div class="flex space-x-3 mt-3">
                                @if($member->social_instagram)
                                    <a href="{{ $member->social_instagram }}" target="_blank" rel="noopener noreferrer"
                                        class="w-8 h-8 flex items-center justify-center bg-blue-600/80 hover:bg-blue-500 rounded-full transition-colors"
                                        aria-label="{{ $member->name }}'s Instagram">
                                        <i class="fab fa-instagram text-white text-sm"></i>
                                    </a>
                                @endif
                                @if($member->social_facebook)
                                    <a href="{{ $member->social_facebook }}" target="_blank" rel="noopener noreferrer"
                                        class="w-8 h-8 flex items-center justify-center bg-blue-600/80 hover:bg-blue-500 rounded-full transition-colors"
                                        aria-label="{{ $member->name }}'s Facebook">
                                        <i class="fab fa-facebook-f text-white text-sm"></i>
                                    </a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Bio Section (appears on hover) -->
                    <div class="absolute inset-0 bg-blue-800/90 p-6 flex flex-col justify-end opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="text-blue-100 text-sm overflow-hidden">
                            <p class="line-clamp-5">{{ $member->bio ?? 'Professional bio coming soon...' }}</p>
                        </div>
                        <button class="mt-4 text-blue-300 hover:text-white text-sm font-medium transition-colors flex items-center">
                            Read more
                            <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 animate-reveal-up">
                    <div class="bg-blue-50 rounded-xl p-8 max-w-2xl mx-auto">
                        <i class="fas fa-users text-blue-400 text-5xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-blue-800 mb-2">No Team Members Yet</h3>
                        <p class="text-blue-600 mb-6">We'll be introducing our team soon. Check back later!</p>
                        @auth
                            <a href="{{ route('ourteam.create') }}"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-300 shadow-md hover:shadow-lg">
                                <i class="fas fa-plus mr-2"></i> Add Your First Team Member
                            </a>
                        @endauth
                    </div>
                </div>
            @endforelse
        </div>
        
        <!-- View More Button (if needed) -->
        @if(count($teamMembers) > 8)
        <div class="text-center mt-12 animate-reveal-up">
            <button class="px-8 py-3 bg-white text-blue-600 border border-blue-200 hover:border-blue-300 rounded-lg shadow-sm hover:shadow-md transition-all font-medium">
                View All Team Members
            </button>
        </div>
        @endif
    </div>
</section>

@endsection