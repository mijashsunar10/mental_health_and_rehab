@extends('template.template')

@section('pagecontent')

  <!-- Our Team Section -->
    <section class="py-20 px-4 bg-gradient-to-b from-orange-50 to-white " id="team-section">
        <div class="max-w-[80%] mx-auto">
            <!-- Section Header with Create Button -->
            <div class="text-center mb-16 relative scroll-reveal">
                <div class="flex justify-between items-center mb-8">
                    <span
                        class="inline-block px-4 py-2 bg-orange-100 text-orange-600 rounded-full text-sm font-semibold mb-4 animate-reveal-up">Meet
                        the Experts</span>
                    @auth
                        <a href="{{ route('ourteam.create') }}"
                            class="flex items-center px-5 py-2 bg-pastry-primary hover:bg-orange-600 text-white rounded-full transition-all duration-300 shadow-md hover:shadow-lg animate-bounce-in"
                            style="animation-delay: 0.2s">
                            <i class="fas fa-plus mr-2"></i> Add Team Member
                        </a>
                    @endauth
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-pastry-primary mb-4 animate-reveal-up">Our <span
                        class="text-pastry-secondary">Team</span></h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg animate-reveal-up" style="animation-delay: 0.2s">
                    Learn from the best in the industry. Our team of award-winning pastry chefs and bakers bring decades of
                    experience to our classrooms.
                </p>
            </div>

            <!-- Team Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($teamMembers as $index => $member)
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 group relative scroll-reveal"
                        style="transition-delay: {{ $index * 0.1 }}s">
                        <!-- Admin Controls (Edit/Delete) -->
                        @auth
                            <div
                                class="absolute top-4 right-4 z-10 flex space-x-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <a href="{{ route('ourteam.edit', $member->id) }}"
                                    class="w-8 h-8 flex items-center justify-center bg-white text-orange-500 rounded-full shadow-md hover:bg-orange-50 transition-all animate-bounce-in"
                                    style="animation-delay: 0.2s">
                                    <i class="fas fa-pencil-alt text-sm"></i>
                                </a>
                                <form action="{{ route('ourteam.destroy', $member->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this team member?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-8 h-8 flex items-center justify-center bg-white text-red-500 rounded-full shadow-md hover:bg-red-50 transition-all animate-bounce-in"
                                        style="animation-delay: 0.3s">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        @endauth

                        <div class="relative overflow-hidden h-80">
                            <img src="{{ $member->image_path ? asset('storage/' . $member->image_path) : asset('images/default-team-member.jpg') }}"
                                loading="lazy" alt="{{ $member->name }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                            <!-- Modified gradient - lighter at top, stronger at bottom -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/30"></div>
                            <div class="absolute bottom-0 left-0 p-6">
                                <h3 class="text-2xl font-bold text-orange-400 drop-shadow-md">{{ $member->name }}</h3>
                                <p class="font-bold text-white drop-shadow-md">{{ $member->position }}</p>
                            </div>
                        </div>
                        {{-- <div class="p-6 ">
                            <p class="text-orange-800 mb-4">{{ $member->bio }}</p>
                            <div class="flex justify-between items-center">
                                <div class="flex space-x-4">
                                    @if ($member->social_instagram)
                                        <a href="{{ $member->social_instagram }}"
                                            aria-label="{{ $member->name }}'s Instagram"
                                            class="text-orange-500 hover:text-orange-600 transition-colors animate-reveal-up"
                                            style="animation-delay: 0.3s">
                                            <i class="fab fa-instagram text-xl"></i>
                                        </a>
                                    @endif
                                    @if ($member->social_facebook)
                                        <a href="{{ $member->social_facebook }}"
                                            aria-label="{{ $member->name }}'s Twitter"
                                            class="text-orange-500 hover:text-orange-600 transition-colors animate-reveal-up"
                                            style="animation-delay: 0.4s">
                                            <i class="fab fa-facebook text-xl"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div> --}}
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 animate-reveal-up">
                        <p class="text-gray-500 text-lg">No team members found</p>
                        @auth
                            <a href="{{ route('ourteam.create') }}"
                                class="mt-4 inline-flex items-center px-5 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-full transition-all duration-300 shadow-md hover:shadow-lg animate-bounce-in">
                                <i class="fas fa-plus mr-2"></i> Add Your First Team Member
                            </a>
                        @endauth
                    </div>
                @endforelse
            </div>
        </div>
    </section>





@endsection