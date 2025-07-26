@php
    $isEdit = isset($package);
    $action = $isEdit ? route('admin.packages.update', $package) : route('admin.packages.store');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6 max-w-[80%] mx-auto mt-20">
    @csrf
    @method($method)

    <div class="mb-6">
        <h2 class="text-xl font-bold text-blue-800 mb-4">{{ $isEdit ? 'Edit Package' : 'Create New Package' }}</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Left Column -->
        <div>
            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-blue-700 mb-1">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $package->title ?? '') }}" 
                    class="w-full px-3 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-blue-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="4" 
                    class="w-full px-3 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $package->description ?? '') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-blue-700 mb-1">Type</label>
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="online" 
                            {{ old('type', $package->type ?? '') === 'online' ? 'checked' : '' }} 
                            class="text-blue-600 focus:ring-blue-500">
                        <span class="ml-2">Online</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="offline" 
                            {{ old('type', $package->type ?? '') === 'offline' ? 'checked' : '' }} 
                            class="text-blue-600 focus:ring-blue-500">
                        <span class="ml-2">Offline</span>
                    </label>
                </div>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Right Column -->
        <div>
            <!-- Image Upload -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-blue-700 mb-1">Package Image</label>
                <input type="file" id="image" name="image" 
                    class="w-full px-3 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                @if($isEdit && $package->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/'.$package->image) }}" alt="Current package image" class="h-32 w-auto rounded">
                        <p class="text-xs text-gray-500 mt-1">Current image</p>
                    </div>
                @endif
            </div>

            <!-- Package Options -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-blue-700 mb-1">Package Options</label>
                <div id="package-options-container">
                    @php
                        $oldOptions = old('options', $package->options ?? [['name' => '', 'price' => '', 'duration' => '']]);
                        if (empty($oldOptions)) {
                            $oldOptions = [['name' => '', 'price' => '', 'duration' => '']];
                        }
                    @endphp
                    
                    @foreach($oldOptions as $index => $option)
                        <div class="option-group mb-3 p-3 border border-blue-200 rounded bg-blue-50">
                            <div class="grid grid-cols-3 gap-2">
                                <div>
                                    <label class="block text-xs text-blue-600 mb-1">Name</label>
                                    <input type="text" name="options[{{ $index }}][name]" 
                                        value="{{ $option['name'] ?? '' }}" 
                                        class="w-full px-2 py-1 text-sm border border-blue-300 rounded">
                                </div>
                                <div>
                                    <label class="block text-xs text-blue-600 mb-1">Price ($)</label>
                                    <input type="number" step="0.01" name="options[{{ $index }}][price]" 
                                        value="{{ $option['price'] ?? '' }}" 
                                        class="w-full px-2 py-1 text-sm border border-blue-300 rounded">
                                </div>
                                <div>
                                    <label class="block text-xs text-blue-600 mb-1">Duration</label>
                                    <input type="text" name="options[{{ $index }}][duration]" 
                                        value="{{ $option['duration'] ?? '' }}" 
                                        class="w-full px-2 py-1 text-sm border border-blue-300 rounded">
                                </div>
                            </div>
                            @if($index > 0)
                                <button type="button" class="mt-2 text-xs text-red-600 hover:text-red-800 remove-option">
                                    Remove
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-option" class="mt-2 text-xs bg-blue-100 hover:bg-blue-200 text-blue-800 px-2 py-1 rounded">
                    + Add Another Option
                </button>
                @error('options')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('options.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <a href="{{ route('admin.packages.index') }}" class="mr-4 px-4 py-2 border border-blue-300 rounded-md text-blue-700 hover:bg-blue-50">
            Cancel
        </a>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            {{ $isEdit ? 'Update Package' : 'Create Package' }}
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add new option
        document.getElementById('add-option').addEventListener('click', function() {
            const container = document.getElementById('package-options-container');
            const index = container.children.length;
            
            const optionHtml = `
                <div class="option-group mb-3 p-3 border border-blue-200 rounded bg-blue-50">
                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="block text-xs text-blue-600 mb-1">Name</label>
                            <input type="text" name="options[${index}][name]" 
                                class="w-full px-2 py-1 text-sm border border-blue-300 rounded">
                        </div>
                        <div>
                            <label class="block text-xs text-blue-600 mb-1">Price ($)</label>
                            <input type="number" step="0.01" name="options[${index}][price]" 
                                class="w-full px-2 py-1 text-sm border border-blue-300 rounded">
                        </div>
                        <div>
                            <label class="block text-xs text-blue-600 mb-1">Duration</label>
                            <input type="text" name="options[${index}][duration]" 
                                class="w-full px-2 py-1 text-sm border border-blue-300 rounded">
                        </div>
                    </div>
                    <button type="button" class="mt-2 text-xs text-red-600 hover:text-red-800 remove-option">
                        Remove
                    </button>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', optionHtml);
        });
        
        // Remove option
        document.getElementById('package-options-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-option')) {
                e.target.closest('.option-group').remove();
                
                // Reindex remaining options
                const container = document.getElementById('package-options-container');
                const optionGroups = container.querySelectorAll('.option-group');
                
                optionGroups.forEach((group, index) => {
                    const inputs = group.querySelectorAll('input');
                    inputs[0].name = `options[${index}][name]`;
                    inputs[1].name = `options[${index}][price]`;
                    inputs[2].name = `options[${index}][duration]`;
                });
            }
        });
    });
</script>