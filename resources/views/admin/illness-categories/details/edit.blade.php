@extends('template.template')

@section('pagecontent')
<div class="container mx-auto px-4 py-8 mt-20">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Details for: {{ $illnessCategory->category_name }}</h1>
        <a href="{{ route('admin.illness-categories.index') }}" class="btn btn-secondary">
            Back to Categories
        </a>
    </div>

    <form action="{{ route('admin.illness-categories.details.update', $illnessCategory) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Hero Image</label>
                @if($detail->hero_image)
                    <img src="{{ Storage::url($detail->hero_image) }}" class="h-32 mb-2">
                @endif
                <input type="file" name="hero_image" class="border rounded w-full py-2 px-3">
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Overview</label>
                <textarea name="overview" class="tinymce border rounded w-full">{{ old('overview', $detail->overview) }}</textarea>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Symptoms</label>
                <textarea name="symptoms" class="tinymce border rounded w-full">{{ old('symptoms', $detail->symptoms) }}</textarea>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Types</label>
                <textarea name="types" class="tinymce border rounded w-full">{{ old('types', $detail->types) }}</textarea>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Treatment</label>
                <textarea name="treatment" class="tinymce border rounded w-full">{{ old('treatment', $detail->treatment) }}</textarea>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Prevention</label>
                <textarea name="prevention" class="tinymce border rounded w-full">{{ old('prevention', $detail->prevention) }}</textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary">Update Details</button>
            </div>
        </div>
    </form>
</div>
@endsection