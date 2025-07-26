@extends('template.template')

@section('pagecontent')
<div class="container mx-auto px-4 py-8 mt-20">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Add Details for: {{ $illnessCategory->category_name }}</h1>
            <p class="text-gray-600 mt-1">Fill in the details for this illness category</p>
        </div>
        <a href="{{ route('admin.illness-categories.index') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Back to Categories
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <form action="{{ route('admin.illness-categories.details.store', $illnessCategory) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="px-4 py-5 sm:p-6 space-y-6">
                <!-- Hero Image Upload -->
                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        Hero Image
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <div class="max-w-lg flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="hero_image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload a file</span>
                                        <input id="hero_image" name="hero_image" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG up to 2MB
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TinyMCE Editors -->
                @foreach([
                    'overview' => 'Overview',
                    'symptoms' => 'Symptoms', 
                    'types' => 'Types',
                    'treatment' => 'Treatment',
                    'prevention' => 'Prevention'
                ] as $field => $label)
                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                    <label for="{{ $field }}" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        {{ $label }}
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <textarea id="{{ $field }}" name="{{ $field }}" rows="6" 
                            class="tinymce max-w-lg shadow-sm block w-full focus:ring-blue-500 focus:border-blue-500 sm:text-sm border border-gray-300 rounded-md">
                            {{ old($field) }}
                        </textarea>
                        @error($field)
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Form Footer -->
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 border-t border-gray-200">
                <a href="{{route('anxiety')}}">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Save Details
                </button>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection