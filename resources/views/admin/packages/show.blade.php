@extends('template.template')

@section('pagecontent')
    <div class="bg-white rounded-lg shadow-md p-6 mt-20 max-w-[80%] mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-blue-800">{{ $package->title }}</h1>
            <span class="px-3 py-1 rounded-full text-sm 
                {{ $package->type === 'online' ? 'bg-blue-100 text-blue-800' : 'bg-indigo-100 text-indigo-800' }}">
                {{ ucfirst($package->type) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Column -->
            <div>
                @if($package->image)
                    <img src="{{ asset('storage/'.$package->image) }}" alt="{{ $package->title }}" class="w-full h-64 object-cover rounded-lg mb-4">
                @else
                    <div class="w-full h-64 bg-blue-100 rounded-lg mb-4 flex items-center justify-center">
                        <span class="text-blue-400">No image available</span>
                    </div>
                @endif

                <div class="prose max-w-none">
                    <h3 class="text-lg font-semibold text-blue-700 mb-2">Description</h3>
                    <p class="text-gray-700">{{ $package->description }}</p>
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-800 mb-4">Package Options</h3>
                    
                    <div class="space-y-4">
                        @foreach($package->options as $option)
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-blue-100">
                                <h4 class="font-medium text-blue-700">{{ $option['name'] }}</h4>
                                <div class="mt-2 flex justify-between items-center">
                                    <span class="text-blue-600 font-medium">${{ number_format($option['price'], 2) }}</span>
                                    <span class="text-sm text-blue-500">{{ $option['duration'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 flex space-x-3">
                 @auth
                    @if(auth()->user()->is_admin)  
                    <a href="{{ route('admin.packages.edit', $package) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Edit Package
                    </a>
                    <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this package?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Delete Package
                        </button>
                    </form>
                    @endif
                     @endauth
                </div>
            </div>
        </div>
    </div>
@endsection