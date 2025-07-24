@extends('template.template')

@section('pagecontent')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $illnessCategory->category_name }}</h1>
            <div class="flex items-center mt-2 text-sm text-blue-600">
                <a href="{{ route('admin.illness-categories.index') }}" class="hover:underline">Categories</a>
                <span class="mx-2">/</span>
                <span>{{ $illnessCategory->category_name }}</span>
            </div>
        </div>
        <a href="{{ route('admin.illness-categories.index') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            Back to List
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
            @if($illnessCategory->detail)
                <!-- Display category details here -->
                <div class="prose max-w-none">
                    {!! $illnessCategory->detail->overview !!}
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No details added yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Add details to this category to display them here.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.illness-categories.details.create', $illnessCategory) }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Add Details
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection