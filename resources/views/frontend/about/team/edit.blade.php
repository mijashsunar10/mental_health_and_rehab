@extends('template.template')

@section('pagecontent')

<div class="container mx-auto px-4 py-8 max-w-4xl mt-12">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-blue-800 mb-6">Edit Team Member</h2>
        
        <form action="{{ route('ourteam.update', $teamMember->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="col-span-1">
                    <label for="name" class="block text-blue-700 font-medium mb-2">Name*</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $teamMember->name) }}" 
                           class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                           placeholder="Enter team member's name">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Position -->
                <div class="col-span-1">
                    <label for="position" class="block text-blue-700 font-medium mb-2">Position*</label>
                    <input type="text" id="position" name="position" value="{{ old('position', $teamMember->position) }}" 
                           class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('position') border-red-500 @enderror"
                           placeholder="Enter team member's position">
                    @error('position')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Image Upload -->
                <div class="col-span-2">
                    <label for="image" class="block text-blue-700 font-medium mb-2">Profile Image</label>
                    <div class="flex items-center space-x-6">
                        <div class="w-24 h-24 rounded-lg overflow-hidden border-2 border-blue-100 shadow-sm">
                            <img src="{{ asset('storage/' . $teamMember->image_path) }}" alt="Current Image" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <input type="file" id="image" name="image" 
                                   class="w-full px-4 py-2 border border-blue-200 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('image') border-red-500 @enderror"
                                   accept="image/jpeg, image/png, image/jpg">
                            <p class="text-sm text-blue-600 mt-2">Leave empty to keep current image</p>
                            @error('image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-4">
                        <img id="imagePreview" src="#" alt="New Image Preview" class="hidden max-w-full h-auto max-h-64 rounded-lg border-2 border-blue-100 shadow-sm">
                    </div>
                </div>
            </div>
            
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('team.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Update Team Member
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Image preview functionality
    document.getElementById('image').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('imagePreview');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            
            // Revoke the object URL to avoid memory leaks
            preview.onload = function() {
                URL.revokeObjectURL(preview.src);
            }
        }
    });
</script>
@endsection