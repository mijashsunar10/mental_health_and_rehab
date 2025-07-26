@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Video Gallery</h1>
            <p class="text-gray-600 mt-1">Explore and manage your video collection</p>
        </div>
        <a href="{{ route('videos.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
            </svg>
            Upload Video
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-500 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($videos as $video)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="relative pb-[56.25%] bg-gray-100">
                    <video class="absolute top-0 left-0 w-full h-full object-cover" controls poster="{{ $video->thumbnail_url }}">
                        <source src="{{ $video->video_url }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">{{ $video->title }}</h3>
                    
                    <!-- Enhanced Description Section -->
                    <div class="mb-4">
                        <p class="text-gray-600 text-sm leading-relaxed mb-2">
                            {{ Str::limit($video->description, 120) }}
                        </p>
                        <div class="flex items-center text-xs text-gray-500 mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Uploaded {{ $video->created_at->diffForHumans() }}
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        {{-- <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                            Watch Full Video
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a> --}}
                        <form action="{{ route('videos.destroy', $video->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium flex items-center" onclick="return confirm('Are you sure you want to delete this video?')">
                                Delete
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $videos->links() }}
    </div>
</div>
@endsection